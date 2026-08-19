<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\EnrollmentDB\StudEnrolmentHistory;
use App\Models\EnrollmentDB\Student;

use App\Models\ClinicDB\Patientvisit;
use App\Models\ClinicDB\PatientReferral;
use App\Models\ClinicDB\Medicine;
use App\Models\ClinicDB\Complaint;

class MedicineController extends Controller
{
    public function index()
    {
        return view('pages.medicine.list');
    }

    public function getmedicineRead() 
    {
        $data = Medicine::orderBy('id', 'ASC')->get();

        return response()->json(['data' => $data]);
    }

    public function medicineCreate(Request $request) 
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'medicine' => 'required',
                'qty' => 'required',
                'expirydate' => 'required',
            ]);

            $catName = $request->input('category'); 
            $medicineName = $request->input('medicine'); 
            $measureName = $request->input('measure'); 
            $lotnoName = $request->input('lotno'); 
            $refnoidName = $request->input('refnoid'); 

            $existingMedicine = Medicine::where('category', $catName)
                            ->where('medicine', $medicineName)
                            ->where('measure', $measureName)
                            ->where('lotno', $lotnoName)
                            ->where('refnoid', $refnoidName)
                            ->first();

            if ($existingMedicine) {
                return response()->json(['error' => true, 'message' => 'Medicine already exists'], 404);
            }

            try {
                Medicine::create([
                    'category' => $catName,
                    'medicine' => $medicineName,
                    'qty'=> $request->input('qty'),
                    'measure'=> $measureName,
                    'lotno'=> $lotnoName,
                    'expirydate'=> $request->input('expirydate'),
                    'refnoid'=> $refnoidName,
                ]);

                return response()->json(['success' => true, 'message' => 'Medicine stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store Medicine'], 404);
            }
        }
    }

    public function medicineUpdate(Request $request) 
    {
        $request->validate([
            'medicine' => 'required',
            'qty' => 'required',
            'expirydate' => 'required',
        ]);

        try {
            $medicineName = $request->input('medicine');
            $existingMedicine = Medicine::where('medicine', $medicineName)->where('id', '!=', $request->input('id'))->first();

            if ($existingMedicine) {
                return response()->json(['error' => true, 'message' => 'Medicine already exists'], 404);
            }

            $medcne = Medicine::findOrFail($request->input('id'));
            $medcne->update([
                'category' => $request->input('category'),
                'medicine' => $request->input('medicine'),
                'qty'=> $request->input('qty'),
                'measure' => $request->input('measure'),
                'lotno' => $request->input('lotno'),
                'expirydate'=> $request->input('expirydate'),
                'refnoid'=> $request->input('refnoid'),
        ]);
            return response()->json(['success' => true, 'message' => 'Medicine update successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to Update Medicine'], 404);
        }
    }

    public function medicineDelete($id) 
    {
        $med = Medicine::find($id);
        $med->delete();

        return response()->json(['success'=> true, 'message'=>'Deleted Successfully',]);
    }
}
