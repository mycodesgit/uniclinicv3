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
    public function index(Request $request)
    {
        $now = Carbon::now();
        $currentYear = $now->year;

        $selectedYear = (int) $request->query('year', $currentYear);
        if ($selectedYear < 2000 || $selectedYear > ($currentYear + 1)) {
            $selectedYear = $currentYear;
        }

        $data = $this->getDashboardData($selectedYear, $now->month, $now->day);

        return view('pages.home.dashboard', array_merge($data, [
            'selectedYear' => $selectedYear,
        ]));
    }

    /**
     * Return ALL year-filtered dashboard data as JSON for AJAX refresh (no page reload).
     */
    public function data(Request $request)
    {
        $currentYear = Carbon::now()->year;

        $validated = Validator::make($request->all(), [
            'year' => 'nullable|integer|min:2000|max:' . ($currentYear + 1),
        ]);

        if ($validated->fails()) {
            return response()->json(['message' => 'Invalid year.'], 422);
        }

        $selectedYear = (int) $request->query('year', $currentYear);
        $now = Carbon::now();

        $data = $this->getDashboardData($selectedYear, $now->month, $now->day);

        return response()->json(array_merge(['year' => $selectedYear], $data));
    }

    /**
     * Shared aggregation used by index() and data().
     *
     * Year-filtering rule: keep the current month/day, swap the year.
     * e.g. today = Oct 13 2026 + year=2025 -> Oct 13 2025 and Oct 2025.
     * Yearly charts use the full selected year. Medicine cards are live
     * inventory snapshots (medicines table has no date column) and stay static.
     */
    private function getDashboardData(int $selectedYear, int $month, int $day): array
    {
        // Clamp day for short months / Feb 29 on non-leap years.
        $daysInMonth = Carbon::create($selectedYear, $month, 1)->daysInMonth;
        $safeDay = min($day, $daysInMonth);
        $selectedDate = Carbon::create($selectedYear, $month, $safeDay)->startOfDay();

        // 1. Visit counts scoped to the selected year (same month/day).
        $ptodayvisits = Patientvisit::whereDate('date', $selectedDate->toDateString())->count();

        $pthismonthvisits = Patientvisit::whereMonth('date', $month)
            ->whereYear('date', $selectedYear)
            ->count();

        // Medicine inventory has no date column — always current snapshot.
        $medcount = Medicine::count();
        $medoutstockcount = Medicine::count();

        // 2. Fetch Colleges List (Default Database)
        $colleges = DB::table('college')
            ->orderBy('college_abbr')
            ->pluck('college_abbr');

        // 3. Fetch Visit Summaries scoped to selected year + month/day.
        //    The monthly per-college counts use the SAME population as the
        //    "No. of Patient Visits" chart (classification = New Cases with an
        //    stid), so the college bars always add up to the monthly total.
        $monthlyPatientVisits = DB::table('patientvisits')
            ->select('stid', DB::raw('COUNT(id) as total_visits'))
            ->whereMonth('date', $month)
            ->whereYear('date', $selectedYear)
            ->where('typeofconsultation', 1)
            ->whereNotNull('stid')
            ->groupBy('stid')
            ->pluck('total_visits', 'stid');

        $dailyPatientVisits = DB::table('patientvisits')
            ->whereDate('date', $selectedDate->toDateString())
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
        $monthlyByCollege   = [];
        $dailyByCollege     = [];
        $monthlyUnspecified = 0;

        // Monthly: iterate EVERY stid with visits so no visit is dropped —
        // rows that cannot be mapped to a college (employee IDs, guests,
        // students missing from the enrollment server) roll into "Unspecified".
        foreach ($monthlyPatientVisits as $studentId => $total) {
            if ($studentId === null || $studentId === '' || !$studentColleges->has($studentId)) {
                $monthlyUnspecified += $total;
                continue;
            }

            $college = strtoupper(trim($studentColleges[$studentId]->college_abbr));
            $monthlyByCollege[$college] = ($monthlyByCollege[$college] ?? 0) + $total;
        }

        // Aggregate Daily Unique Student Visits
        foreach ($studentColleges as $studentId => $row) {
            if (in_array($studentId, $dailyStudentIds)) {
                $college = strtoupper(trim($row->college_abbr));
                $dailyByCollege[$college] = ($dailyByCollege[$college] ?? 0) + 1;
            }
        }

        // 7. Format output arrays matching the full college list
        $collegeAcronymsmonth = [];
        $collegeCountsmonth   = [];
        $collegeAcronymsdaily = [];
        $collegeCountsdaily   = [];

        $masterCollegeKeys = $colleges->map(fn ($c) => strtoupper(trim($c)))->all();

        foreach ($colleges as $college) {
            $key = strtoupper(trim($college));

            $collegeAcronymsmonth[] = $college;
            $collegeCountsmonth[]   = $monthlyByCollege[$key] ?? 0;

            $collegeAcronymsdaily[] = $college;
            $collegeCountsdaily[]   = $dailyByCollege[$key] ?? 0;
        }

        // Colleges found in the data but missing from the college list
        // (e.g. KAB students) are appended so every visit stays visible.
        foreach (array_keys(array_merge($dailyByCollege, $monthlyByCollege)) as $key) {
            if (in_array($key, $masterCollegeKeys, true)) {
                continue;
            }

            $collegeAcronymsmonth[] = $key;
            $collegeCountsmonth[]   = $monthlyByCollege[$key] ?? 0;

            $collegeAcronymsdaily[] = $key;
            $collegeCountsdaily[]   = $dailyByCollege[$key] ?? 0;
        }

        // Unmapped visits still count toward the monthly total
        if ($monthlyUnspecified > 0) {
            $collegeAcronymsmonth[] = 'Unspecified';
            $collegeCountsmonth[]   = $monthlyUnspecified;
        }

        // 8. Fetch Monthly Visits filtered by typeofconsultation = 1 for Selected Year
        $monthlyConsultations = DB::table('patientvisits')
            ->select(
                DB::raw('MONTH(date) as month'),
                DB::raw('COUNT(id) as total_visits')
            )
            ->whereYear('date', $selectedYear)
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

        // 9. Fetch Monthly Patient Visits by Category (pcat) for Selected Year
        $categories = DB::table('patientvisits')
            ->whereYear('date', $selectedYear)
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
            ->whereYear('date', $selectedYear)
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

        return [
            'ptodayvisits' => $ptodayvisits,
            'pthismonthvisits' => $pthismonthvisits,
            'medcount' => $medcount,
            'medoutstockcount' => $medoutstockcount,
            'collegeAcronymsmonth' => $collegeAcronymsmonth,
            'collegeCountsmonth' => $collegeCountsmonth,
            'collegeAcronymsdaily' => $collegeAcronymsdaily,
            'collegeCountsdaily' => $collegeCountsdaily,
            'chartData' => $chartData,
            'categoryMonthlyDatasets' => $categoryMonthlyDatasets,
            'filterDate' => $selectedDate->toDateString(),
            'monthLabel' => $selectedDate->format('F Y'),
            'dayLabel' => $selectedDate->format('F d, Y'),
        ];
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('getLogin')->with('success','You have been Successfully Logged Out');
    }
}
