<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ClinicDB\Patientvisit;
use App\Models\ClinicDB\Medicine;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // 1. Total Visits Count & Medicine Count (Default Database)
        $ptodayvisits = Patientvisit::whereDate('date', $today)->count();
        
        $pthismonthvisits = Patientvisit::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->count();
        
        $medcount = Medicine::count();
        $medoutstockcount = Medicine::where('qty', '<', 10)->count();

        // 2. Fetch Colleges List (Default Database)
        $colleges = DB::table('college')
            ->orderBy('college_abbr')
            ->pluck('college_abbr');

        // 3. Fetch Visit Summaries from local Database grouped by Student ID
        $monthlyPatientVisits = DB::table('patientvisits')
            ->select('stid', DB::raw('COUNT(id) as total_visits'))
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('stid')
            ->pluck('total_visits', 'stid');

        $dailyPatientVisits = DB::table('patientvisits')
            ->whereDate('created_at', $today)
            ->pluck('stid')
            ->unique();

        // 4. Extract student IDs that actually had visits
        $monthlyStudentIds = $monthlyPatientVisits->keys()->toArray();
        $dailyStudentIds   = $dailyPatientVisits->toArray();

        // Combine all relevant student IDs to fetch from external server in a single query
        $allActiveStudentIds = array_unique(array_merge($monthlyStudentIds, $dailyStudentIds));

        // 5. Query the External Enrollment Server for Student College Affiliations
        $studentColleges = collect();
        if (!empty($allActiveStudentIds)) {
            $studentColleges = DB::connection('enrollment')
                ->table('program_en_history')
                ->join('students', 'program_en_history.studentID', '=', 'students.stud_id')
                ->whereIn('students.id', $allActiveStudentIds)
                ->select(
                    'students.id as student_id',
                    DB::raw('LEFT(program_en_history.progCod, 3) as college_abbr')
                )
                ->distinct()
                ->get()
                ->keyBy('student_id');
        }

        // 6. Aggregate Totals by College
        $monthlyByCollege = [];
        $dailyByCollege   = [];

        foreach ($studentColleges as $studentId => $data) {
            $college = $data->college_abbr;

            // Aggregate Monthly Visits
            if (isset($monthlyPatientVisits[$studentId])) {
                $monthlyByCollege[$college] = ($monthlyByCollege[$college] ?? 0) + $monthlyPatientVisits[$studentId];
            }

            // Aggregate Daily Unique Student Visits
            if (in_array($studentId, $dailyStudentIds)) {
                $dailyByCollege[$college] = ($dailyByCollege[$college] ?? 0) + 1;
            }
        }

        // 7. Format output arrays matching the full college list
        $collegeAcronymsmonth = [];
        $collegeCountsmonth   = [];
        $collegeAcronymsdaily = [];
        $collegeCountsdaily   = [];

        foreach ($colleges as $college) {
            $collegeAcronymsmonth[] = $college;
            $collegeCountsmonth[]   = $monthlyByCollege[$college] ?? 0;

            $collegeAcronymsdaily[] = $college;
            $collegeCountsdaily[]   = $dailyByCollege[$college] ?? 0;
        }

        // 8. Fetch Monthly Visits filtered by typeofconsultation = 1 for Current Year
        // Change 'count(id)' to 'count(DISTINCT stid)' if you only want unique students per month
        $monthlyConsultations = DB::table('patientvisits')
            ->select(
                DB::raw('MONTH(date) as month'),
                DB::raw('COUNT(id) as total_visits') 
            )
            ->whereYear('date', $currentYear)
            ->where('typeofconsultation', 1)
            ->whereNotNull('stid')
            ->groupBy(DB::raw('MONTH(date)'))
            ->pluck('total_visits', 'month')
            ->toArray();

        // Fill all 12 months (Jan = 1 to Dec = 12) defaulting missing months to 0
        $chartData = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartData[] = $monthlyConsultations[$m] ?? 0;
        }

        // 9. Fetch Monthly Patient Visits by Category (pcat) for typeofconsultation = 1
        $categories = DB::table('patientvisits')
            ->whereNotNull('pcat')
            ->where('pcat', '!=', '')
            ->distinct()
            ->pluck('pcat')
            ->toArray();

        $rawCategoryMonthlyData = DB::table('patientvisits')
            ->select(
                DB::raw('MONTH(date) as month'),
                'pcat',
                DB::raw('COUNT(id) as total')
            )
            ->whereYear('date', $currentYear)
            ->where('typeofconsultation', 1)
            ->whereNotNull('pcat')
            ->groupBy(DB::raw('MONTH(date)'), 'pcat')
            ->get();

        $categoryMonthlyDatasets = [];

        foreach ($categories as $category) {
            $monthlyCounts = array_fill(1, 12, 0); // Initialize Jan-Dec with 0

            foreach ($rawCategoryMonthlyData as $row) {
                if ($row->pcat === $category) {
                    $monthlyCounts[$row->month] = $row->total;
                }
            }

            $categoryMonthlyDatasets[] = [
                'label' => $category,
                'data'  => array_values($monthlyCounts), // Jan to Dec values
            ];
        }

        
        return view('pages.home.dashboard', compact(
            'ptodayvisits', 
            'pthismonthvisits', 
            'medcount', 
            'medoutstockcount', 
            'collegeAcronymsmonth', 
            'collegeCountsmonth', 
            'collegeAcronymsdaily', 
            'collegeCountsdaily',
            'chartData',
            'categoryMonthlyDatasets'
        ));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('getLogin')->with('success','You have been Successfully Logged Out');
    }
}
