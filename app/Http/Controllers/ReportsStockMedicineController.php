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
        return view('pages.reports.medicinestockrep');
    }

    public function fetch(Request $request)
    {
        $search = $request->get('q'); // search term (optional)
        
        $medicines = Medicine::select('id', 'medicine')
            ->when($search, function($query, $search) {
                return $query->where('medicine', 'like', "%{$search}%");
            })
            ->limit(20) // load only 20 at a time
            ->get();

        return response()->json($medicines);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'medicine' => 'required|numeric|between:1,12',
            ],
            [
                // Custom validation messages
                'medicine.required' => 'Please select a medicine before generating the report.',
                'medicine.numeric'  => 'The selected medicine must be a valid number.',
                'medicine.between'  => 'Please select a valid medicine from the list.',
            ]
        );

        return view('pages.reports.medicinestockrepresult');
    }

    public function generate(Request $request)
    {
        $medicineselected = $request->input('medicine');

        $stockmed = Medicine::where('id', $medicineselected)
                ->select('medicines.*')
                ->get();
        $data = [
            'stockmed' => $stockmed,
            'medicineselected' => $medicineselected,
        ];

        $pdf = PDF::loadView('pages.reports.pdf.medicinestockpdf', $data)->setPaper('Legal', 'portrait');

        return $pdf->stream();
    }
}