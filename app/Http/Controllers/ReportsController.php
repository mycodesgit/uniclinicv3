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

class ReportsController extends Controller
{
    public function patientdatarep()
    {
        return view('reports.patientdatarep');
    }

    public function walkinconsultdetails($id)
    {
        $patients = Student::findOrFail($id);
        $colleges = College::all();
        $programs = EnPrograms::all();

        $student = DB::connection('enrollment')
            ->table('students')
            ->where('id', $id)
            ->first();

        return view('reports.patientdatarep_details', compact('patients', 'colleges', 'programs', 'id'));
    }
}
