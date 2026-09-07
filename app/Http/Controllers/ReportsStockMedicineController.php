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
        
        $medicines = Medicine::select('id', 'code', 'name')
            ->when($search, function($query, $search) {
                return $query->where('code', 'like', "%{$search}%");
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

        // Eager load both batches and transactions
        $medicine = Medicine::with(['batches', 'transactions'])->findOrFail($medicineselected);

        // Map batches to ledger entries (Receipts)
        $receipts = $medicine->batches->map(function ($batch) {
            return [
                'date'      => $batch->received_date ? \Carbon\Carbon::parse($batch->received_date) : $batch->created_at,
                'reference' => $batch->refnoid ?? 'DELIVERY',
                'receipt'   => $batch->quantity_received,
                'issue'     => null,
                'office'    => null,
            ];
        });

        // Map transactions to ledger entries (Issues)
        $issues = $medicine->transactions
            ->filter(function ($tx) {
                return in_array(strtolower($tx->transaction_type), ['dispensed', 'issued', 'dispense']);
            })
            ->map(function ($tx) {
                return [
                    'date'      => $tx->created_at,
                    'reference' => $tx->patientvisit_id ? 'VISIT #' . $tx->patientvisit_id : 'DISPENSE',
                    'receipt'   => null,
                    'issue'     => $tx->quantity,
                    'office'    => $tx->remarks ?? 'Clinic',
                ];
            });

        // Merge and sort chronologically by date
        $stockCardEntries = $receipts->concat($issues)->sortBy('date');

        $data = [
            'medicine'         => $medicine,
            'medicineselected' => $medicineselected,
            'stockCardEntries' => $stockCardEntries,
        ];

        $pdf = PDF::loadView('pages.reports.pdf.medicinestockpdf', $data)
                ->setPaper('Legal', 'portrait');

        // Clean slashes and backslashes from the filename code
        $safeCode = str_replace(['/', '\\'], '-', $medicine->code);

        return $pdf->stream("Stock_Card_{$safeCode}.pdf");
    }
}