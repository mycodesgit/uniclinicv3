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

use App\Models\ScheduleDB\College;
use App\Models\ScheduleDB\EnPrograms;

use App\Models\ClinicDB\GuestPatient;
use App\Models\ClinicDB\Patientvisit;
use App\Models\ClinicDB\PatientReferral;
use App\Models\ClinicDB\Medicine;
use App\Models\ClinicDB\Complaint;

use App\Models\SettingDB\ConfigureCurrent;
use App\Models\SettingDB\Region;
use App\Models\SettingDB\Province;
use App\Models\SettingDB\City;
use App\Models\SettingDB\Barangay;

class PatientsController extends Controller
{
    public function index()
    {
        $regions = Region::all();

        return view('patient.plist', compact('regions'));
    }

    public function show(Request $request)
    {
        $campus = 'MC';
        $search = $request->query('search');

        $students = Student::where('campus', $campus)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('lname', 'LIKE', "%{$search}%")
                      ->orWhere('stud_id', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('lname')
            ->paginate(10);

        return response()->json($students);
    }

    public function showguest()
    {
        $data = GuestPatient::all();

        return response()->json(['data' => $data]);
    }

    public function showdetails($id)
    {
        $patients = Student::findOrFail($id);

        $regions = Region::all();

        $student = DB::connection('enrollment')
            ->table('students')
            ->where('id', $id)
            ->first();

        $patientVisit = Patientvisit::where('stid', $student->id)->get();

        return view('patient.details', compact('patients', 'regions', 'patientVisit'));
    }

    public function create(Request $request)
{
    if ($request->isMethod('post')) {

        $request->validate([
            'lname' => 'required',
            'fname' => 'required',
            'mname' => 'required',
        ]);

        $lname = $request->input('lname');
        $fname = $request->input('fname');
        $mname = $request->input('mname');

        // ✅ KEEP THIS (unchanged)
        $existingGuestPatient = GuestPatient::where('lname', $lname)
            ->where('fname', $fname)
            ->where('mname', $mname)
            ->first();

        if ($existingGuestPatient) {
            return response()->json([
                'error' => true,
                'message' => 'Guest Patient already exists'
            ], 404);
        }

        try {
            // ✅ SAFE auto-increment
            $lastPatient = GuestPatient::orderBy('id', 'desc')->first();
            $nextNumber = $lastPatient ? $lastPatient->id + 1 : 1;

            GuestPatient::create([
                'patientID' => 'GSTP-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT),
                'lname' => $lname,
                'fname' => $fname,
                'mname' => $mname,
                'ext' => $request->input('ext'),
                'gender' => $request->input('gender'),
                'civil_status' => $request->input('civil_status'),
                'address' => $request->input('address'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Guest Patient created successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to create Guest Patient'
            ], 500);
        }
    }
}


    public function getPortalProvinces($region_id) 
    {
        return response()->json(Province::where('region_id', $region_id)->get());
    }
    
    public function getPortalCities($province_id) 
    {
        return response()->json(City::where('province_id', $province_id)->get());
    }
    
    public function getPortalBarangays($city_id) 
    {
        return response()->json(Barangay::where('city_id', $city_id)->get());
    }

    public function update(Request $request)
    {
        $patient = Student::findOrFail($request->id);
        $column = $request->column;
        if ($column == 'birthdate') {
            $birthdate = Carbon::parse($request->value);
            $age = $birthdate->age;
            $patient->update([
                $column => $request->value,
                'age' => $age
            ]);
        } else {
            $patient->update([
                $column => $request->value
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function studentsHistory(Request $request)
    {
        $patient = Student::find($request->id);
        $column = $request->column;
        $value = $request->value;
        $array = $request->data_array; 

        $arrayVal = $patient->$column;
        $arrayVal = explode(",", $arrayVal);
        $currentValue = isset($arrayVal[$array]) ? $arrayVal[$array] : null;
        $newvalue = $currentValue === $value ? '' : $value;
        $arrayVal[$array] = $newvalue;
        $newarrayVal = implode(",", $arrayVal);
        $patient->$column = $newarrayVal;
        $patient->save();
        
    
        return response()->json(['success' => true]);
    }
}
