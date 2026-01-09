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

    public function studentsShow(Request $request)
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

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('patient.details', compact('student'));
    }
}
