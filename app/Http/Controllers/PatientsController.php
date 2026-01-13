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

use App\Models\SettingDB\ConfigureCurrent;
use App\Models\SettingDB\Region;
use App\Models\SettingDB\Province;
use App\Models\SettingDB\City;
use App\Models\SettingDB\Barangay;

class PatientsController extends Controller
{
    public function index()
    {
        return view('patient.plist');
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

    public function showdetails($id)
    {
        $patients = Student::findOrFail($id);

        $regions = Region::all();

        return view('patient.details', compact('patients', 'regions'));
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
}
