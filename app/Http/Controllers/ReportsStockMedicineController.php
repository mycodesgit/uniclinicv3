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

class ReportsStockMedicineController extends Controller
{
    public function index()
    {
        return view('reports.stockmedicinerep');
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

        return view('reports.stockmedicinerepresult', $data);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'reporting_period' => 'required|in:monthly,quarterly,yearly',
            'period_value'     => 'required',
        ]);

        // Fetch data using the query helper
        $data = $this->getReportData($request);

        // Generate PDF or return view based on request
        if ($request->has('pdf')) {
            $pdf = PDF::loadView('reports.stockmedicinerepresult', $data);
            return $pdf->download('stock_medicine_report.pdf');
        }

        return view('reports.stockmedicinerepresult', $data);
    }
}