<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

use App\Models\EnrollmentDB\StudEnrolmentHistory;
use App\Models\EnrollmentDB\Student;

use App\Models\ScheduleDB\College;
use App\Models\ScheduleDB\EnPrograms;

use App\Models\SettingDB\ConfigureCurrent;
use App\Models\SettingDB\Region;
use App\Models\SettingDB\Province;
use App\Models\SettingDB\City;
use App\Models\SettingDB\Barangay;

class PDFreportController extends Controller
{
    public function showprehepdf($id)
    {
        $decryptedId = Crypt::decryptString($id);

        $patients = Student::join('program_en_history', 'students.stud_id', '=', 'program_en_history.studentID')
            ->join('coasv2_db_schedule.college', function ($join) {
                $join->on(
                    DB::raw("SUBSTRING_INDEX(program_en_history.progCod, '-', 1)"),
                    '=',
                    'coasv2_db_schedule.college.college_abbr'
                );
            })
            ->where('students.id', $decryptedId)
            ->select(
                'students.*',
                'students.created_at as createdas',
                'college.college_name',
                'program_en_history.course'
            )
            ->orderBy('program_en_history.id', 'desc')
            ->first();

        $hregion = !empty($patients->home_region) ? Region::find($patients->home_region) : null;
        $hprovince  = !empty($patients->home_province) ? Province::where('province_id', $patients->home_province)->first() : null;
        $hcity = !empty($patients->home_city) ? City::where('city_id', $patients->home_city)->first() : null;
        $hbarangay = !empty($patients->home_brgy) ? Barangay::find($patients->home_brgy) : null;
        $gregion = !empty($patients->guardian_region) ? Region::find($patients->guardian_region) : null;
        $gprovince = !empty($patients->guardian_province) ?  Province::where('province_id', $patients->guardian_province)->first() : null;
        $gcity = !empty($patients->guardian_city) ? City::where('city_id', $patients->guardian_city)->first() : null;
        $gbarangay = !empty($patients->guardian_brgy) ? Barangay::find($patients->guardian_brgy) : null;



        $pdf = PDF::loadView('formspdf.prehepdf', compact('patients', 'hregion', 'hprovince', 'hcity', 'hbarangay', 'gregion', 'gprovince', 'gcity', 'gbarangay', 'id'))->setPaper('Legal', 'portrait');
        return $pdf->stream();
    }
}
