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

class ReportsMedicalStatisticController extends Controller
{
    public function index()
    {
        return view('reports.medstatrep');
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

        return view('reports.medstatrepresult', $data);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'reporting_period' => 'required|in:monthly,quarterly,yearly',
            'period_value'     => 'required',
        ]);

        // Fetch data using the query helper
        $data = $this->getReportData($request);

        $pdf = PDF::loadView('reports.pdf.medicalstatisticpdf', $data)
                ->setPaper('Legal', 'portrait');

        // Return inline stream instead of forcing a download
        return $pdf->stream('Medical_Statistics_Report.pdf', ['Attachment' => false]);
    }

    /**
     * Helper logic to handle database filtering and label transformation
     */
    private function getReportData(Request $request)
    {
        $type        = $request->input('reporting_period');
        $value       = $request->input('period_value');
        $preparedBy  = $request->input('prepared_by');
        $position    = $request->input('position');
        $currentYear = date('Y');

        $query = Patientvisit::query();
        $formattedPeriodValue = $value;

        if ($type === 'monthly') {
            $months = [
                '01' => 'January',   '02' => 'February', '03' => 'March',
                '04' => 'April',     '05' => 'May',      '06' => 'June',
                '07' => 'July',      '08' => 'August',   '09' => 'September',
                '10' => 'October',   '11' => 'November', '12' => 'December'
            ];
            $formattedPeriodValue = $months[$value] ?? $value;

            $query->whereMonth('created_at', $value)
                  ->whereYear('created_at', $currentYear);

        } elseif ($type === 'quarterly') {
            $quarters = [
                '01' => 'January to April',
                '02' => 'May to August',
                '03' => 'September to December',
            ];
            $formattedPeriodValue = $quarters[$value] ?? $value;

            $monthRanges = [
                '01' => [1, 4],   // Jan to Apr
                '02' => [5, 8],   // May to Aug
                '03' => [9, 12],  // Sep to Dec
            ];

            if (array_key_exists($value, $monthRanges)) {
                [$startMonth, $endMonth] = $monthRanges[$value];
                $startDate = Carbon::create($currentYear, $startMonth, 1)->startOfDay();
                $endDate   = Carbon::create($currentYear, $endMonth)->endOfMonth()->endOfDay();

                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

        } elseif ($type === 'yearly') {
            $formattedPeriodValue = $value;
            $query->whereYear('created_at', $value);
        }

        $reports = $query->get();
        $reportingPeriodLabel = ucfirst($type);

        return compact(
            'reports',
            'reportingPeriodLabel',
            'formattedPeriodValue',
            'preparedBy',
            'position'
        );
    }
}