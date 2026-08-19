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

use App\Models\HrisDB\Employees;

class ReportsMedicalStatisticController extends Controller
{
    public function index()
    {
        return view('pages.reports.medstatrep');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reporting_period' => 'required|in:monthly,quarterly,yearly',
            'period_value'     => 'required',
            'prepared_by'      => 'required|string',
            'position'         => 'required|string',
        ]);

        // Process data and queries using shared helper
        $data = $this->getReportData($request);

        return view('pages.reports.medstatrepresult', $data);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'reporting_period' => 'required|in:monthly,quarterly,yearly',
            'period_value'     => 'required',
        ]);

        // Fetch data using the query helper
        $data = $this->getReportData($request);

        $pdf = PDF::loadView('pages.reports.pdf.medicalstatisticpdf', $data)
                ->setPaper('Legal', 'portrait');

        // Return inline stream instead of forcing a download
        return $pdf->stream('Medical_Statistics_Report.pdf', ['Attachment' => false]);
    }

    /**
     * Helper logic to handle database filtering and label transformation
     */
    private function getReportData(Request $request)
    {
        $type         = $request->input('reporting_period');
        $value        = $request->input('period_value');
        $selectedYear = $request->input('year', date('Y'));
        $preparedBy   = $request->input('prepared_by');
        $position     = $request->input('position');

        $query = Patientvisit::query();

        $formattedPeriodValue = '';

        // --- 1. Filter Logic by Period Type ---
        if ($type === 'monthly') {
            $months = [
                '01' => 'January',   '02' => 'February', '03' => 'March',
                '04' => 'April',     '05' => 'May',      '06' => 'June',
                '07' => 'July',      '08' => 'August',   '09' => 'September',
                '10' => 'October',   '11' => 'November', '12' => 'December'
            ];
            
            $formattedPeriodValue = ($months[$value] ?? $value) . " {$selectedYear}";

            $query->whereMonth('created_at', $value)
                ->whereYear('created_at', $selectedYear);

        } elseif ($type === 'quarterly') {
            $quarters = [
                '01' => "1st Quarter (Jan - Mar) {$selectedYear}",
                '02' => "2nd Quarter (Apr - Jun) {$selectedYear}",
                '03' => "3rd Quarter (Jul - Sep) {$selectedYear}",
                '04' => "4th Quarter (Oct - Dec) {$selectedYear}",
            ];

            $formattedPeriodValue = $quarters[$value] ?? "Q{$value} {$selectedYear}";

            $monthRanges = [
                '01' => [1, 3],   // Q1
                '02' => [4, 6],   // Q2
                '03' => [7, 9],   // Q3
                '04' => [10, 12], // Q4
            ];

            if (array_key_exists($value, $monthRanges)) {
                [$startMonth, $endMonth] = $monthRanges[$value];
                $startDate = Carbon::create($selectedYear, $startMonth, 1)->startOfDay();
                $endDate   = Carbon::create($selectedYear, $endMonth)->endOfMonth()->endOfDay();

                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

        } elseif ($type === 'yearly') {
            $formattedPeriodValue = "Year {$selectedYear}";
            $query->whereYear('created_at', $selectedYear);
        }

        // --- 2. Fetch matching database visits ---
        $reports = $query->get();

        // --- 3. Extract IDs for Cross-Database Lookups ---
        // A. Students (pcat = 1) -> Enrollment DB
        $studentIds = $reports->where('pcat', 1)
                            ->pluck('stdntID')
                            ->filter()
                            ->unique()
                            ->toArray();

        // B. HRIS Personnel (pcat = 2: Faculty, 3: Admin, 4: Contractual) -> HRIS DB
        // Pull from stdntID (or $visit->emp_ID if your Patientvisit table has a distinct emp_ID column)
        $employeeIds = $reports->whereIn('pcat', [2, 3, 4])
                            ->map(fn($v) => $v->emp_ID ?? $v->stdntID)
                            ->filter()
                            ->unique()
                            ->toArray();

        // --- 4. Batch Query Remote Databases ---

        // Query Enrollment DB for student genders
        $studentsGenders = [];
        if (!empty($studentIds)) {
            $studentsGenders = Student::whereIn('stud_id', $studentIds)
                                    ->pluck('gender', 'stud_id') 
                                    ->toArray();
        }

        // Query HRIS DB using 'sex' and 'emp_ID'
        $employeeGenders = [];
        if (!empty($employeeIds)) {
            $employeeGenders = Employees::whereIn('emp_ID', $employeeIds)
                                                        ->pluck('sex', 'emp_ID') 
                                                        ->toArray();
        }

        // --- 5. Initialize Consultation Categories ---
        $categories = [
            1 => 'Students',
            2 => 'Faculty',
            3 => 'Administrative Personnel',
            4 => 'Contractual/Job Order Personnel',
            5 => 'Visitors',
        ];

        $consultations = [];
        foreach ($categories as $pcatId => $label) {
            $consultations[$pcatId] = [
                'label'  => $label,
                'male'   => 0,
                'female' => 0,
                'total'  => 0,
            ];
        }

        // --- 6. Categorize & Count Gender Distribution ---
        foreach ($reports as $visit) {
            $pcat = (int) $visit->pcat;
            $gender = null;

            if ($pcat === 1) {
                // Student: Map via EnrollmentDB
                $gender = $studentsGenders[$visit->stdntID] ?? null;
            } elseif (in_array($pcat, [2, 3, 4])) {
                // Faculty/Staff: Map via HrisDB using emp_ID and sex
                $empKey = $visit->emp_ID ?? $visit->stdntID;
                $gender = $employeeGenders[$empKey] ?? null;
            } else {
                // Visitors (pcat = 5): Direct fallback to local column
                $gender = $visit->gender ?? null;
            }

            // Clean & normalize string ('Male', 'male', 'M', 'm', 'Female', 'female', 'F', 'f')
            $gender = strtolower(trim($gender ?? ''));

            if (array_key_exists($pcat, $consultations)) {
                if ($gender === 'male' || $gender === 'm') {
                    $consultations[$pcat]['male']++;
                } elseif ($gender === 'female' || $gender === 'f') {
                    $consultations[$pcat]['female']++;
                }
                $consultations[$pcat]['total'] = $consultations[$pcat]['male'] + $consultations[$pcat]['female'];
            }
        }

        // --- 7. Calculate Grand Totals ---
        $grandTotal = [
            'male'   => array_sum(array_column($consultations, 'male')),
            'female' => array_sum(array_column($consultations, 'female')),
            'total'  => array_sum(array_column($consultations, 'total')),
        ];

        $reportingPeriodLabel = ucfirst($type);

        return compact(
            'reports',
            'consultations',
            'grandTotal',
            'reportingPeriodLabel',
            'formattedPeriodValue',
            'preparedBy',
            'position',
            'selectedYear'
        );
    }
}