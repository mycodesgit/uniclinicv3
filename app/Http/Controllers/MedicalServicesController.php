<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ClinicDB\MedicalServicesRendered;

class MedicalServicesController extends Controller
{
    public function index()
    {
        return view('pages.service.medserve');
    }

    public function show() 
    {
        $data = MedicalServicesRendered::orderBy('id', 'ASC')->get();

        return response()->json(['data' => $data]);
    }

    public function create(Request $request) 
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'medservrender' => 'required',
            ]);

            $medservrender = $request->input('medservrender'); 

            $existingMedServRender = MedicalServicesRendered::where('medservrender', $medservrender)
                            ->first();

            if ($existingMedServRender) {
                return response()->json(['error' => true, 'message' => 'Medical Services already exists'], 404);
            }

            try {
                MedicalServicesRendered::create([
                    'medservrender' => $medservrender,
                ]);

                return response()->json(['success' => true, 'message' => 'Medical Services stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store Medical Services'], 404);
            }
        }
    }

    public function update(Request $request) 
    {
        $id = $request->input('id');

        $request->validate([
            'id'               => 'required|exists:medicalservices,id',
            'medservrender'    => 'required|string|max:255',
        ]);

        try {
            $medserve = MedicalServicesRendered::findOrFail($id);
            $medserve->update([
                'medservrender' => $request->input('medservrender'),
            ]);

            return response()->json(['success' => true, 'message' => 'Medical Services updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update Medical Services details'], 500);
        }
    }

    public function delete($id) 
    {
        try {
            $medserve = MedicalServicesRendered::findOrFail($id);
            $medserve->delete();

            return response()->json(['success' => true, 'message' => 'Medical Services deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Medical Services item'], 500);
        }
    }
}
