<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ClinicDB\Patientvisit;

class DashboardController extends Controller
{
    public function index()
    {
        $ptodayvisits = Patientvisit::whereDate('created_at', Carbon::today())->count();

        $pthismonthvisits = Patientvisit::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $colleges = DB::table('college')
            ->select('college_abbr')
            ->orderBy('college_abbr')
            ->get()
            ->pluck('college_abbr');

        $studentsByCollege = DB::connection('enrollment')
            ->table('program_en_history')
            ->join('students', 'program_en_history.studentID', '=', 'students.stud_id')
            ->select(
                'students.id as student_id',
                DB::raw('LEFT(program_en_history.progCod, 3) as college_abbr')
            )
            ->whereIn(DB::raw('LEFT(program_en_history.progCod, 3)'), $colleges)
            ->get()
            ->groupBy('college_abbr');

        $visitCounts = DB::table('patientvisits')
            ->select('stid', DB::raw('COUNT(*) as total'))
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('stid')
            ->get()
            ->keyBy('stid');

        $collegeCountsmonth = [];
        $collegeAcronymsmonth = [];

        foreach ($colleges as $college) {

            $count = 0;

            if (isset($studentsByCollege[$college])) {
                foreach ($studentsByCollege[$college] as $student) {
                    $count += $visitCounts[$student->student_id]->total ?? 0;
                }
            }

            $collegeAcronymsmonth[] = $college;
            $collegeCountsmonth[]  = $count;
        }

        return view('home.dashboard', compact('ptodayvisits', 'pthismonthvisits', 'collegeAcronymsmonth', 'collegeCountsmonth'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('getLogin')->with('success','You have been Successfully Logged Out');
    }
}
