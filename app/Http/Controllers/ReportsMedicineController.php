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
use App\Models\ClinicDB\MedicineBatch;
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
        return view('pages.reports.medicinerep');
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

        return view('pages.reports.medicinerepresult', compact('monthmed', 'monthselected', 'currentYear'));
    }

    public function generate(Request $request)
    {
        // 1. Validate that 'month' is passed and valid
        $request->validate([
            'month' => 'required|numeric|between:1,12',
        ]);

        // 2. Format inputs safely
        $month = (int) $request->input('month');
        $monthselected = sprintf('%02d', $month);
        $currentYear = now()->year;

        // 3. Convert month number to full month name (e.g., "05" -> "May")
        $monthName = \Carbon\Carbon::createFromDate($currentYear, $month, 1)->format('F');

        // 4. Fetch all medicines with stock relations (no category column exists,
        //    so rows are a flat list ordered by name instead of grouped)
        $medicines = Medicine::with(['batches', 'transactions'])
                ->orderBy('name', 'asc')
                ->get();

        // 5. Build per-medicine inventory rows for the selected month
        $rows = $this->buildMonthlyInventoryRows($medicines, $month, $currentYear);

        // 6. Prepare data payload
        $data = [
            'rows'          => $rows,
            'monthselected' => $monthselected,
            'monthName'     => $monthName,
            'currentYear'   => $currentYear,
        ];

        // 7. Generate PDF
        $pdf = PDF::loadView('pages.reports.pdf.medicinepdf', $data)
                ->setPaper('Legal', 'landscape');

        // Return as inline stream (ideal for iframe embedding)
        return $pdf->stream("Medicine_Report_{$monthName}_{$currentYear}.pdf", ['Attachment' => false]);
    }

    /**
     * Monthly inventory math per medicine.
     *
     * Form formula: End of Month = (A + B + C) - (D + E + F)
     *  (A) Beginning balance  = received before month - dispensed before month
     *  (B) Deliveries         = quantity_received with received_date in month
     *  (C)/(D) Stock transfers = 0 (no transfer tracking exists in the DB)
     *  (E) Monthly consumption = dispense-type transactions created in month
     *  (F) Expired stocks      = quantity_remaining of batches expiring in month
     */
    private function buildMonthlyInventoryRows($medicines, int $month, int $year): array
    {
        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end = (clone $start)->endOfMonth()->endOfDay();

        $consumptionTypes = ['dispense', 'dispensed', 'issued'];

        $rows = [];

        foreach ($medicines as $med) {
            $begReceived = 0;
            $delivQty = 0;
            $delivDates = [];
            $monthBatches = [];

            foreach ($med->batches as $batch) {
                $receivedAt = $batch->received_date
                    ? Carbon::parse($batch->received_date)->startOfDay()
                    : ($batch->created_at ? Carbon::parse($batch->created_at)->startOfDay() : null);

                if ($receivedAt === null) {
                    continue;
                }

                if ($receivedAt->lt($start)) {
                    $begReceived += (int) $batch->quantity_received;
                } elseif ($receivedAt->lte($end)) {
                    $delivQty += (int) $batch->quantity_received;
                    $delivDates[] = $receivedAt->format('m/d/Y');
                    $monthBatches[] = $batch;
                }
            }

            $consumedBefore = 0;
            $consumption = 0;

            foreach ($med->transactions as $transaction) {
                if (!in_array(strtolower((string) $transaction->transaction_type), $consumptionTypes, true)) {
                    continue;
                }
                if (!$transaction->created_at) {
                    continue;
                }
                $transactedAt = Carbon::parse($transaction->created_at);

                if ($transactedAt->lt($start)) {
                    $consumedBefore += (int) $transaction->quantity;
                } elseif ($transactedAt->lte($end)) {
                    $consumption += (int) $transaction->quantity;
                }
            }

            // (A) Beginning balance: what was left at the end of the previous month
            $begBal = $begReceived - $consumedBefore;

            // (F) Expired during the month: still on hand but past expiry
            $expired = 0;
            foreach ($med->batches as $batch) {
                if (!$batch->expiration_date || (int) $batch->quantity_remaining <= 0) {
                    continue;
                }
                $expiry = Carbon::parse($batch->expiration_date)->startOfDay();
                if ($expiry->gte($start) && $expiry->lte($end)) {
                    $expired += (int) $batch->quantity_remaining;
                }
            }

            $stockRec = 0;   // (C) no transfer tracking in DB
            $stockTrans = 0; // (D) no transfer tracking in DB

            // Lot/Batch details: this month's deliveries, else batches still on hand
            $detailBatches = !empty($monthBatches)
                ? $monthBatches
                : $med->batches->filter(fn($b) => (int) $b->quantity_remaining > 0)->values()->all();

            $batchDetails = collect($detailBatches)->map(function ($b) {
                $exp = $b->expiration_date ? Carbon::parse($b->expiration_date)->format('m/d/Y') : 'N/A';
                return $b->lotbatch_number . ' (' . $exp . ')';
            })->implode(', ');

            // Formula: (A + B + C) - (D + E + F)
            $endOfMonth = ($begBal + $delivQty + $stockRec) - ($stockTrans + $consumption + $expired);

            $rows[] = [
                'name'        => trim(($med->code ? $med->code . ' ' : '') . $med->name),
                'begBal'      => $begBal,
                'delivQty'    => $delivQty,
                'delivDates'  => implode(', ', array_unique($delivDates)),
                'batchDetails'=> $batchDetails,
                'stockRec'    => $stockRec,
                'stockTrans'  => $stockTrans,
                'consumption' => $consumption,
                'expired'     => $expired,
                'endOfMonth'  => $endOfMonth,
            ];
        }

        return $rows;
    }
}
