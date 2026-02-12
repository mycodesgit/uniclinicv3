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

use App\Models\HrisDB\Employees;
use App\Models\HrisDB\Region;
use App\Models\HrisDB\Province;
use App\Models\HrisDB\City;
use App\Models\HrisDB\Barangay;

use App\Models\ScheduleDB\College;
use App\Models\ScheduleDB\EnPrograms;

use App\Models\ClinicDB\Patientvisit;
use App\Models\ClinicDB\PatientReferral;
use App\Models\ClinicDB\Medicine;
use App\Models\ClinicDB\Complaint;

use App\Models\SettingDB\ConfigureCurrent;

class PatientEmpController extends Controller
{
    public function search(Request $request)
    {
        $campus = 1;
        $search = $request->query('search');

        $emps = Employees::select(
                'id',
                'lname',
                'fname',
                'emp_ID',
                'sex',
                'camp_id',
                'civil_status'
            )->where('camp_id', $campus)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('lname', 'LIKE', "%{$search}%")
                        ->orWhere('fname', 'LIKE', "%{$search}%")
                        ->orWhere('emp_ID', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('lname')
            ->paginate(10);

        return response()->json($emps);
    }

    public function showempdetails($id)
    {
        $patients = Employees::findOrFail($id);

        $patientinfo = Employees::leftJoin('cities', 'employees.add_city', '=', 'cities.city_id')
            ->leftJoin('barangays', 'employees.add_brgy', '=', 'barangays.id')
            ->leftJoin('provinces', 'employees.add_prov', '=', 'provinces.province_id')
            ->leftJoin('regions', 'employees.add_region', '=', 'regions.region_id')
            ->select('employees.*', 'barangays.name as brgy_name', 'cities.name as city_name', 'provinces.name as province_name', 'regions.name as region_name')
            ->where('employees.id', $id)
            ->firstOrFail();

        $regions = Region::all();

        $emps = DB::connection('hremp')
            ->table('employees')
            ->where('employees.id', $id)
            ->first();

        $patientVisit = Patientvisit::where('stid', $emps->id)->get();

        return view('patient.empdetails', compact('patients', 'regions', 'patientinfo', 'patientVisit'));
    }
}
