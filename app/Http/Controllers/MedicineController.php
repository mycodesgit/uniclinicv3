<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ClinicDB\Medicine;
use App\Models\ClinicDB\MedicineBatch;
use App\Models\ClinicDB\MedicineTransaction;

class MedicineController extends Controller
{
    public function index()
    {
        return view('pages.medicine.list');
    }

    /**
     * Get medicine records for main DataTables display.
     */
    public function getmedicineRead() 
    {
        $data = Medicine::withSum('batches as quantity_remaining', 'quantity_remaining')
            ->with(['batches' => function ($query) {
                $query->where('quantity_remaining', '>', 0)
                      ->orderBy('expiration_date', 'ASC');
            }])
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($item) {
                $latestBatch = $item->batches->first();

                return [
                    'id'                 => $item->id,
                    'code'               => $item->code,
                    'name'               => $item->name,
                    'generic_name'       => $item->generic_name,
                    'dosage'             => $item->dosage,
                    'unit'               => $item->unit,
                    'reorder_level'      => $item->reorder_level ?? 10,
                    'quantity_remaining' => $item->quantity_remaining ?? 0,
                    'lotbatch_number'    => $latestBatch ? $latestBatch->lotbatch_number : null,
                    'expiration_date'    => $latestBatch ? $latestBatch->expiration_date : null,
                    'refnoid'            => $latestBatch ? $latestBatch->refnoid : null,
                ];
            });

        return response()->json(['data' => $data]);
    }

    /**
     * Read all batches for a specific medicine item.
     */
    public function medicineBatchesRead($id)
    {
        try {
            $batches = MedicineBatch::where('medicine_id', $id)
                ->orderBy('expiration_date', 'ASC')
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $batches
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch batch details.'], 500);
        }
    }

    /**
     * Create a new Medicine Catalog Item.
     */
    public function medicineCreate(Request $request) 
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'unit'          => 'required|string|max:50',
            'code'          => 'nullable|string|max:100|unique:medicines,code',
            'generic_name'  => 'nullable|string|max:255',
            'dosage'        => 'nullable|string|max:100',
            'reorder_level' => 'nullable|integer|min:0',
        ]);

        try {
            Medicine::create([
                'code'          => $request->input('code'),
                'name'          => $request->input('name'),
                'generic_name'  => $request->input('generic_name'),
                'dosage'        => $request->input('dosage'),
                'unit'          => $request->input('unit'),
                'reorder_level' => $request->input('reorder_level', 10),
            ]);

            return response()->json(['success' => true, 'message' => 'Medicine catalog item created successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to store Medicine'], 500);
        }
    }

    /**
     * Add Initial or Subsequent Stock Batch to a Medicine item.
     */
    public function medicineBatchCreate(Request $request)
    {
        $request->validate([
            'medicine_id'       => 'required|exists:medicines,id',
            'lotbatch_number'   => 'required|string|max:100',
            'quantity_received' => 'required|integer|min:1',
            'expiration_date'   => 'required|date',
            'refnoid'           => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            $qty = $request->input('quantity_received');

            $batch = MedicineBatch::create([
                'medicine_id'        => $request->input('medicine_id'),
                'lotbatch_number'    => $request->input('lotbatch_number'),
                'quantity_received'  => $qty,
                'quantity_remaining' => $qty,
                'expiration_date'    => $request->input('expiration_date'),
                'refnoid'            => $request->input('refnoid'),
                'description'        => $request->input('description'),
            ]);

            MedicineTransaction::create([
                'medicine_id'       => $request->input('medicine_id'),
                'medicine_batch_id' => $batch->id,
                'type'              => 'IN',
                'quantity'          => $qty,
                'notes'             => 'Stock Batch Added (Ref: ' . ($request->input('refnoid') ?? 'N/A') . ')',
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Stock batch added successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to add stock batch'], 500);
        }
    }

    /**
     * Update an existing Batch Stock entry.
     */
    public function medicineBatchUpdate(Request $request)
    {
        $request->validate([
            'batch_id'           => 'required|exists:medicine_batches,id',
            'lotbatch_number'    => 'required|string|max:100',
            'quantity_remaining' => 'required|integer|min:0',
            'expiration_date'    => 'required|date',
            'refnoid'            => 'nullable|string|max:100',
        ]);

        try {
            $batch = MedicineBatch::findOrFail($request->input('batch_id'));
            
            $batch->update([
                'lotbatch_number'    => $request->input('lotbatch_number'),
                'quantity_remaining' => $request->input('quantity_remaining'),
                'expiration_date'    => $request->input('expiration_date'),
                'refnoid'            => $request->input('refnoid'),
            ]);

            return response()->json([
                'success'     => true, 
                'message'     => 'Batch stock updated successfully',
                'medicine_id' => $batch->medicine_id
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update batch details'], 500);
        }
    }

    /**
     * Update Medicine Catalog Details.
     */
    public function medicineUpdate(Request $request) 
    {
        $id = $request->input('id');

        $request->validate([
            'id'            => 'required|exists:medicines,id',
            'name'          => 'required|string|max:255',
            'unit'          => 'required|string|max:50',
            'code'          => 'nullable|string|max:100|unique:medicines,code,' . $id,
            'generic_name'  => 'nullable|string|max:255',
            'dosage'        => 'nullable|string|max:100',
            'reorder_level' => 'nullable|integer|min:0',
        ]);

        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->update([
                'code'          => $request->input('code'),
                'name'          => $request->input('name'),
                'generic_name'  => $request->input('generic_name'),
                'dosage'        => $request->input('dosage'),
                'unit'          => $request->input('unit'),
                'reorder_level' => $request->input('reorder_level', 10),
            ]);

            return response()->json(['success' => true, 'message' => 'Medicine updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update medicine details'], 500);
        }
    }

    /**
     * Delete Medicine Catalog item and associated batches.
     */
    public function medicineDelete($id) 
    {
        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->delete();

            return response()->json(['success' => true, 'message' => 'Medicine deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete medicine item'], 500);
        }
    }
}
