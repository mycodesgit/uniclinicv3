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

class ReportsMedicineController extends Controller
{
    public function index()
    {
        return view('reports.medicinerep');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'month' => 'required|numeric|between:1,12',
            ],
            [
                // Custom validation messages
                'month.required' => 'Please select a month before generating the report.',
                'month.numeric'  => 'The selected month must be a valid number.',
                'month.between'  => 'Please select a valid month from the list.',
            ]
        );

        $monthselected = sprintf('%02d', $request->input('month'));
        $currentYear = now()->year;

        $monthmed = Medicine::whereYear('created_at', $currentYear)
                            ->whereMonth('created_at', $monthselected)
                            ->get();

        return view('reports.medicinerepresult', compact('monthmed', 'monthselected', 'currentYear'));
    }

    public function generate(Request $request)
    {
        // 1. Validate that 'month' is passed and valid
        $request->validate([
            'month' => 'required|numeric|between:1,12',
        ]);

        // 2. Format inputs safely
        $monthselected = sprintf('%02d', $request->input('month'));
        $currentYear = now()->year;

        // 3. Convert month number to full month name (e.g., "05" -> "May")
        $monthName = \Carbon\Carbon::createFromDate($currentYear, (int)$monthselected, 1)->format('F');

        // 4. Fetch and group data
        $monthmed = Medicine::whereYear('created_at', $currentYear)
                            ->whereMonth('created_at', $monthselected)
                            ->get();

        $grouped = $monthmed->groupBy('category');

        // 5. Prepare data payload
        $data = [
            'monthmed'      => $grouped,
            'monthselected' => $monthselected,
            'monthName'     => $monthName,
            'currentYear'   => $currentYear,
        ];

        // 6. Generate PDF
        $pdf = PDF::loadView('reports.pdf.medicinepdf', $data)
                ->setPaper('Legal', 'landscape');

        // Return as inline stream (ideal for iframe embedding)
        return $pdf->stream("Medicine_Report_{$monthName}_{$currentYear}.pdf", ['Attachment' => false]);
    }
}
