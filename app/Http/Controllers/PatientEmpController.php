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

use App\Models\ScheduleDB\College;
use App\Models\ScheduleDB\EnPrograms;

use App\Models\ClinicDB\Patientvisit;
use App\Models\ClinicDB\PatientReferral;
use App\Models\ClinicDB\Medicine;
use App\Models\ClinicDB\Complaint;

use App\Models\SettingDB\ConfigureCurrent;
use App\Models\SettingDB\Region;
use App\Models\SettingDB\Province;
use App\Models\SettingDB\City;
use App\Models\SettingDB\Barangay;

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
                      ->orWhere('emp_ID', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('lname')
            ->paginate(10);

        return response()->json($emps);
    }
}
