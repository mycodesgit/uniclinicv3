<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\EnrollmentDB\StudEnrolmentHistory;
use App\Models\EnrollmentDB\Student;

use App\Models\HrisDB\Employees;
use App\Models\HrisDB\Region;
use App\Models\HrisDB\Province;
use App\Models\HrisDB\City;
use App\Models\HrisDB\Barangay;

use App\Models\ClinicDB\Patientvisit;
use App\Models\ClinicDB\PatientReferral;
use App\Models\ClinicDB\Medicine;
use App\Models\ClinicDB\MedicineBatch;
use App\Models\ClinicDB\MedicineTransaction;
use App\Models\ClinicDB\Complaint;
use App\Models\ClinicDB\MedicalServicesRendered;

class AppointmentsController extends Controller
{
    public function index()
    {
        return view('pages.appointment.walkin');
    }

    public function walkinconsultdetails($adid)
    {
        $decryptedId = Crypt::decryptString($adid);
        $patients = Student::findOrFail($decryptedId);
        
        $complaints = Complaint::all();

        $medicines = Medicine::with(['batches' => function ($query) {
                $query->where('quantity_remaining', '>', 0)
                    ->orderBy('expiration_date', 'asc');
            }])
            ->where('is_active', true)
            ->get()
            ->map(function ($medicine) {
                $totalRemaining = $medicine->batches->sum('quantity_remaining');
                
                // Get first batch
                $firstBatch = $medicine->batches->first();
                
                // Safely parse date using Carbon
                $nearestExpiry = 'N/A';
                if ($firstBatch && $firstBatch->expiration_date) {
                    $nearestExpiry = \Carbon\Carbon::parse($firstBatch->expiration_date)->format('M d, Y');
                }

                return (object) [
                    'id'                 => $medicine->id,
                    'code'               => $medicine->code,
                    'name'               => $medicine->name,
                    'quantity_remaining' => $totalRemaining,
                    'nearest_expiry'     => $nearestExpiry,
                ];
            })
            ->filter(fn ($med) => $med->quantity_remaining > 0)
            ->values();

        $medserverender = MedicalServicesRendered::all();

        $student = DB::connection('enrollment')
            ->table('students')
            ->where('id', $decryptedId)
            ->first();

        $patientVisit = Patientvisit::where('stid', $student->id)->get();

        return view('pages.appointment.walkin-details', compact('patients', 'complaints', 'medicines', 'medserverender', 'patientVisit', 'adid'));
    }

    public function walkinconsultempdetails($emp_ID)
    {
        $patients = Employees::where('emp_ID', $emp_ID)->firstOrFail();
        $complaints =  Complaint::all();
        $medicines = Medicine::all();
        $medserverender = MedicalServicesRendered::all();

        $emps = DB::connection('hremp')
            ->table('employees')
            ->where('emp_ID', $emp_ID)
            ->first();

        $patientVisit = Patientvisit::where('stdntID', $emps->emp_ID)->get();

        return view('pages.appointment.walkin-empdetails', compact('patients', 'complaints', 'medicines', 'medserverender', 'patientVisit', 'emp_ID'));
    }

    public function getwalkinconsult($adid)
    {
        $decryptedId = Crypt::decryptString($adid);
        
        $student = DB::connection('enrollment')
            ->table('students')
            ->select('id', 'lname', 'fname', 'mname', 'ext')
            ->where('id', $decryptedId)
            ->first();

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Eager-load transactions with batch and medicine relations
        $visits = Patientvisit::with(['transactions'])
            ->where('stid', $student->id)
            ->orderBy('date', 'desc')
            ->get();
        
        if ($visits->isEmpty()) {
            return response()->json(['data' => []]);
        }

        // Fetch complaint IDs
        $complaintIds = $visits->pluck('chief_complaint')
            ->filter()
            ->flatMap(fn ($v) => explode(',', $v))
            ->filter()
            ->unique();

        $complaints = $complaintIds->isNotEmpty()
            ? Complaint::whereIn('id', $complaintIds)->pluck('complaintname', 'id')
            : collect();

        $data = $visits->map(function ($visit) use ($student, $complaints) {

            // Extract medicines linked to this visit via transactions
            $medicineCodes = $visit->transactions->map(function ($tx) {
                return $tx->batch->medicine->code ?? null;
            })->filter()->unique()->implode(', ');

            $medicineNames = $visit->transactions->map(function ($tx) {
                return $tx->batch->medicine->name ?? null;
            })->filter()->unique()->implode(', ');

            $totalQty = $visit->transactions->sum('quantity');

            return [
                'id'              => $visit->id,
                'consultID'       => $visit->consultID,
                'date'            => $visit->date,
                'time'            => $visit->time,

                'chief_complaint' => $visit->chief_complaint,
                'bp'              => $visit->bp,
                'pr'              => $visit->pr,
                'rr'              => $visit->rr,
                'spo'             => $visit->spo,
                'btemp'           => $visit->btemp,
                'lmp'             => $visit->lmp,
                'pheight'         => $visit->pheight,
                'pweight'         => $visit->pweight,
                'treatment'       => $visit->treatment,
                'certificate'     => $visit->certificate,

                'lname'           => $student->lname,
                'fname'           => $student->fname,
                'mname'           => $student->mname,
                'ext'             => $student->ext,

                // Multi-relation outputs
                'code'            => $medicineCodes ?: 'N/A',
                'medicinename'    => $medicineNames ?: 'N/A',
                'qty'             => $totalQty > 0 ? $totalQty : ($visit->qty ?? 0),

                'complaintname'   => collect(explode(',', (string) $visit->chief_complaint))
                    ->map(fn ($id) => $complaints[$id] ?? null)
                    ->filter()
                    ->implode(', '),
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function getwalkinempconsult($emp_ID)
    {
        $emps = DB::connection('hremp')
            ->table('employees')
            ->select('emp_ID', 'lname', 'fname', 'mname', 'suffix')
            ->where('emp_ID', $emp_ID)
            ->first();

        // Always return a valid DataTables response
        if (!$emps) {
            return response()->json(['data' => []]);
        }

        $visits = Patientvisit::where('stdntID', $emps->emp_ID)
            ->orderBy('date', 'desc')
            ->get();

        if ($visits->isEmpty()) {
            return response()->json(['data' => []]);
        }

        $complaintIds = $visits->pluck('chief_complaint')
            ->filter()
            ->flatMap(fn ($v) => explode(',', $v))
            ->filter()
            ->unique();

        $medicineIds = $visits->pluck('medicine')
            ->filter()
            ->flatMap(fn ($v) => explode(',', $v))
            ->filter()
            ->unique();

        $complaints = $complaintIds->isNotEmpty()
            ? Complaint::whereIn('id', $complaintIds)->pluck('complaintname', 'id')
            : collect();

        $medicines = $medicineIds->isNotEmpty()
            ? Medicine::whereIn('id', $medicineIds)->pluck('medicine', 'id')
            : collect();

        $data = $visits->map(function ($visit) use ($emps, $complaints, $medicines) {
            return [
                'id'        => $visit->id,
                'date'      => $visit->date,
                'time'      => $visit->time,
                'treatment' => $visit->treatment,
                'qty'       => $visit->qty,
                'consultID' => $visit->consultID,

                'lname'  => $emps->lname,
                'fname'  => $emps->fname,
                'mname'  => $emps->mname,
                'suffix' => $emps->suffix,

                'complaintname' => collect(explode(',', (string) $visit->chief_complaint))
                    ->map(fn ($id) => $complaints[$id] ?? null)
                    ->filter()
                    ->implode(', '),

                'medicinename' => collect(explode(',', (string) $visit->medicine))
                    ->map(fn ($id) => $medicines[$id] ?? null)
                    ->filter()
                    ->implode(', '),
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function createWalkinConsultation(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $patient = new Patientvisit();

            // Assign single inputs
            $patient->stid = $request->input('stid');
            $patient->stdntID = $request->input('stdntID');
            $patient->consultID = $request->input('consultID');
            $patient->pcat = $request->input('pcat');
            $patient->typeofconsultation = $request->input('typeofconsultation');
            $patient->date = $request->input('date');
            $patient->time = $request->input('time');
            $patient->treatment = $request->input('treatment');
            $patient->certificate = $request->input('certificate');
            $patient->bp = $request->input('bp');
            $patient->pr = $request->input('pr');
            $patient->rr = $request->input('rr');
            $patient->spo = $request->input('spo');
            $patient->btemp = $request->input('btemp');
            $patient->lmp = $request->input('lmp');
            $patient->pheight = $request->input('pheight');
            $patient->pweight = $request->input('pweight');

            // Process multi-select array inputs safely
            $complaints = array_filter((array) $request->input('chief_complaint', []));
            $services = array_filter((array) $request->input('medservrendered', []));

            $patient->chief_complaint = implode(',', $complaints);
            $patient->medservrendered = implode(',', $services);

            // Save patient visit record first to acquire its primary ID for transaction linking
            $patient->save();

            // Process dynamic Medicine & Quantity entries
            $rawMedicines = $request->input('medicine', []);
            $rawQuantities = $request->input('qty', []);

            $savedMedicines = [];
            $savedQuantities = [];

            foreach ($rawMedicines as $index => $medId) {
                $requestedQty = (int) ($rawQuantities[$index] ?? 0);

                if (!empty($medId) && $requestedQty > 0) {
                    $medicine = Medicine::find($medId);

                    if ($medicine) {
                        // Fetch available active batches sorted by oldest expiration date (FIFO)
                        $batches = MedicineBatch::where('medicine_id', $medId)
                            ->where('quantity_remaining', '>', 0)
                            ->orderBy('expiration_date', 'asc')
                            ->get();

                        $totalAvailable = $batches->sum('quantity_remaining');

                        // Proceed if overall stock is sufficient
                        if ($totalAvailable >= $requestedQty) {
                            $qtyToDeduct = $requestedQty;

                            foreach ($batches as $batch) {
                                if ($qtyToDeduct <= 0) {
                                    break;
                                }

                                $deductFromBatch = min($batch->quantity_remaining, $qtyToDeduct);

                                // 1. Deduct quantity remaining from batch
                                $batch->decrement('quantity_remaining', $deductFromBatch);

                                // 2. Log transaction row for audit and PDF reports
                                MedicineTransaction::create([
                                    'medicine_id'     => $medId,
                                    'batch_id'        => $batch->id,
                                    'patientvisit_id' => $patient->id,
                                    'transaction_type'=> 'dispense', // or 'issued'
                                    'quantity'        => $deductFromBatch,
                                    'remarks'         => 'Walk-in Consultation Dispense',
                                    'created_by'      => Auth::id() ?? null,
                                ]);

                                $qtyToDeduct -= $deductFromBatch;
                            }

                            $savedMedicines[] = $medId;
                            $savedQuantities[] = $requestedQty;
                        }
                    }
                }
            }

            // Store selected medicines and quantities in consultation record
            $patient->medicine = implode(',', $savedMedicines);
            $patient->qty = implode(',', $savedQuantities);
            $patient->save();

            return response()->json([
                'success' => true,
                'message' => 'Walk-in consultation saved successfully.'
            ]);
        });
    }

    public function updateWalkinConsultation(Request $request)
    {
        // 1. FORM VALIDATION
        $validatedData = $request->validate([
            'id'              => 'required|exists:patientvisits,id',
            'date'              => 'required|date',
            'time'              => 'required',
            'chief_complaint'   => 'required|array|min:1',
            'chief_complaint.*' => 'required',
            'medicine'          => 'nullable|array',
            'medicine.*'        => 'nullable',
            'qty'               => 'nullable|array',
            'qty.*'             => 'nullable|integer|min:1',
            'bp'                => 'nullable|string',
            'pr'                => 'nullable|string',
            'rr'                => 'nullable|string',
            'spo'               => 'nullable|string',
            'btemp'             => 'nullable|string',
            'lmp'               => 'nullable|string',
            'pheight'           => 'nullable|string',
            'pweight'           => 'nullable|string',
            'treatment'         => 'nullable|string',
            'certificate'       => 'nullable|boolean',
        ]);

        // 2. TRY-CATCH BLOCK WITH DATABASE TRANSACTION
        try {
            DB::beginTransaction();

            $patient = Patientvisit::findOrFail($validatedData['id']);

            // Update basic patient fields
            $patient->date        = $validatedData['date'];
            $patient->time        = $validatedData['time'];
            $patient->treatment   = $request->input('treatment');
            $patient->certificate = $request->input('certificate');
            $patient->bp          = $request->input('bp');
            $patient->pr          = $request->input('pr');
            $patient->rr          = $request->input('rr');
            $patient->spo         = $request->input('spo');
            $patient->btemp       = $request->input('btemp');
            $patient->lmp         = $request->input('lmp');
            $patient->pheight     = $request->input('pheight');
            $patient->pweight     = $request->input('pweight');

            // Process Chief Complaints Array -> CSV
            $complaints = array_filter($validatedData['chief_complaint'], fn($val) => !is_null($val) && $val !== '');
            $patient->chief_complaint = implode(',', $complaints);

            // ----------------------------------------------------
            // A. RESTORE OLD INVENTORY STOCK
            // ----------------------------------------------------
            $oldMedicines  = array_filter(explode(',', $patient->medicine));
            $oldQuantities = array_filter(explode(',', $patient->qty));

            foreach ($oldMedicines as $index => $oldMedId) {
                if (!empty($oldMedId)) {
                    $medModel = Medicine::find($oldMedId);
                    if ($medModel) {
                        $restoredQty = isset($oldQuantities[$index]) ? (int)$oldQuantities[$index] : 0;
                        $medModel->increment('qty', $restoredQty);
                    }
                }
            }

            // ----------------------------------------------------
            // B. DEDUCT NEW INVENTORY STOCK
            // ----------------------------------------------------
            $newMedicines = array_filter($request->input('medicine', []), fn($val) => !is_null($val) && $val !== '');
            $newQtys      = array_filter($request->input('qty', []), fn($val) => !is_null($val) && $val !== '');

            $processedMeds = [];
            $processedQtys = [];

            foreach ($newMedicines as $index => $medId) {
                $qtyToDeduct = isset($newQtys[$index]) ? (int)$newQtys[$index] : 0;

                $medicineModel = Medicine::find($medId);
                if ($medicineModel) {
                    // Check if enough stock exists
                    if ($medicineModel->qty < $qtyToDeduct) {
                        // Rollback transaction if stock is insufficient
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => "Insufficient stock for {$medicineModel->medicine}. Available: {$medicineModel->qty}"
                        ], 422);
                    }

                    // Deduct medicine quantity
                    $medicineModel->decrement('qty', $qtyToDeduct);

                    $processedMeds[] = $medId;
                    $processedQtys[] = $qtyToDeduct;
                }
            }

            // Save new CSV strings
            $patient->medicine = implode(',', $processedMeds);
            $patient->qty      = implode(',', $processedQtys);

            // Save record
            $patient->save();

            // Commit transaction if all database operations succeeded
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Consultation updated successfully!'
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
                'message' => 'Validation failed. Please check your inputs.'
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating: ' . $e->getMessage()
            ], 500);
        }
    }

    public function walkinConsultDelete($id) 
    {
        return DB::transaction(function () use ($id) {
            // 1. Find the consultation record
            $consultation = Patientvisit::findOrFail($id);

            // 2. Extract saved medicines and quantities into arrays
            $medicines = array_filter(explode(',', $consultation->medicine ?? ''));
            $quantities = array_filter(explode(',', $consultation->qty ?? ''));

            // 3. Restore inventory for each prescribed medicine
            foreach ($medicines as $index => $medId) {
                $qtyToRestore = (int) ($quantities[$index] ?? 0);

                if (!empty($medId) && $qtyToRestore > 0) {
                    $medRecord = Medicine::find($medId);

                    if ($medRecord) {
                        // Put stock BACK into available stock
                        $medRecord->increment('qty', $qtyToRestore);

                        // REDUCE total dispensed count (ensure it doesn't drop below 0)
                        if ($medRecord->dispensed_qty >= $qtyToRestore) {
                            $medRecord->decrement('dispensed_qty', $qtyToRestore);
                        } else {
                            $medRecord->update(['dispensed_qty' => 0]);
                        }
                    }
                }
            }

            // 4. Delete the consultation record
            $consultation->delete();

            return response()->json([
                'success' => true,
                'message' => 'Consultation deleted and medicine stock restored successfully.'
            ]);
        });
    }

    public function getwalkinreferral($adid) 
    {
        $decryptedId = Crypt::decryptString($adid);

        $student = DB::connection('enrollment')
            ->table('students')
            ->select('id', 'lname', 'fname', 'mname', 'ext')
            ->where('id', $decryptedId)
            ->first();

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $refer = PatientReferral::where('stid', $student->id)
            ->select('patientreferral.*')
            ->orderBy('date', 'desc')
            ->get();
        
        if ($refer->isEmpty()) {
            return response()->json(['data' => []]);
        }

        $data = $refer->map(function ($visit) use ($student) {

            return [
                'id'                    => $visit->id,
                'date'                  => $visit->date,
                'time'                  => $visit->time,
                'bp'                    => $visit->bp,
                'pr'                    => $visit->pr,
                'rr'                    => $visit->rr,
                'spo'                  => $visit->spo,
                'btemp'                 => $visit->btemp,
                'lmp'                   => $visit->lmp,
                'pheight'               => $visit->pheight,
                'pweight'               => $visit->pweight,
                'preferfrom'            => $visit->preferfrom,
                'preferto'              => $visit->preferto,
                'reasonrefer'           => $visit->reasonrefer,
                'tentdiagnose'          => $visit->tentdiagnose,
                'treatmentmedgiven'     => $visit->treatmentmedgiven,

                'lname' => $student->lname,
                'fname' => $student->fname,
                'mname' => $student->mname,
                'ext'   => $student->ext,

                
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function getwalkinempreferral($emp_ID) 
    {
        $emps = DB::connection('hremp')
            ->table('employees')
            ->select('emp_ID', 'lname', 'fname', 'mname', 'suffix')
            ->where('emp_ID', $emp_ID)
            ->first();

        // Always return a valid DataTables response
        if (!$emps) {
            return response()->json(['data' => []]);
        }

        $refer = PatientReferral::where('stdntID', $emps->emp_ID)
            ->orderBy('date', 'desc')
            ->get();
        
        if ($refer->isEmpty()) {
            return response()->json(['data' => []]);
        }

        $data = $refer->map(function ($visit) use ($emps) {

            return [
                'id'                    => $visit->id,
                'date'                  => $visit->date,
                'time'                  => $visit->time,
                'preferfrom'            => $visit->preferfrom,
                'preferto'              => $visit->preferto,
                'reasonrefer'           => $visit->reasonrefer,
                'tentdiagnose'          => $visit->tentdiagnose,
                'treatmentmedgiven'     => $visit->treatmentmedgiven,

                'lname' => $student->lname,
                'fname' => $student->fname,
                'mname' => $student->mname,
                'suffix'   => $student->suffix,

                
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function createWalkinReferral(Request $request) 
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'preferfrom' => 'required',
                'preferto' => 'required',
                'reasonrefer' => 'required',
                'tentdiagnose' => 'required',
                'treatmentmedgiven' => 'required',
            ]);

            try {
                PatientReferral::create([
                    'stid' => $request->input('stid'),
                    'stdntID' => $request->input('stdntID'),
                    'referralID' => $request->input('referralID'),
                    'date' => $request->input('date'),
                    'time' => $request->input('time'),
                    'bp' => $request->input('bp'),
                    'pr' => $request->input('pr'),
                    'rr' => $request->input('rr'),
                    'spo' => $request->input('spo'),
                    'btemp' => $request->input('btemp'),
                    'lmp' => $request->input('lmp'),
                    'pheight' => $request->input('pheight'),
                    'pweight' => $request->input('pweight'),
                    'preferfrom' => $request->input('preferfrom'),
                    'preferto' => $request->input('preferto'),
                    'reasonrefer' => $request->input('reasonrefer'),
                    'tentdiagnose' => $request->input('tentdiagnose'),
                    'treatmentmedgiven' => $request->input('treatmentmedgiven'),
                ]);

                return response()->json(['success' => true, 'message' => 'Referral stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store Referral'], 404);
            }
        }
    }

    public function updateWalkinReferral(Request $request)
    {
        // 1. FORM VALIDATION
        $validatedData = $request->validate([
            'id'              => 'required|exists:patientreferral,id',
            'date'              => 'required|date',
            'time'              => 'required',
            'bp'                => 'nullable|string',
            'pr'                => 'nullable|string',
            'rr'                => 'nullable|string',
            'spo'               => 'nullable|string',
            'btemp'             => 'nullable|string',
            'lmp'               => 'nullable|string',
            'pheight'           => 'nullable|string',
            'pweight'           => 'nullable|string',
            'preferfrom'        => 'nullable|string',
            'preferto'          => 'nullable|string',
            'reasonrefer'       => 'nullable|string',
            'tentdiagnose'      => 'nullable|string',
            'treatmentmedgiven' => 'nullable|string',
        ]);

        // 2. TRY-CATCH BLOCK WITH DATABASE TRANSACTION
        try {
            DB::beginTransaction();

            $patient = PatientReferral::findOrFail($validatedData['id']);

            // Update basic patient fields
            $patient->date        = $validatedData['date'];
            $patient->time        = $validatedData['time'];
            $patient->bp          = $request->input('bp');
            $patient->pr          = $request->input('pr');
            $patient->rr          = $request->input('rr');
            $patient->spo         = $request->input('spo');
            $patient->btemp       = $request->input('btemp');
            $patient->lmp         = $request->input('lmp');
            $patient->pheight     = $request->input('pheight');
            $patient->pweight     = $request->input('pweight');
            $patient->preferfrom   = $request->input('preferfrom');
            $patient->preferto     = $request->input('preferto');
            $patient->reasonrefer  = $request->input('reasonrefer');
            $patient->tentdiagnose = $request->input('tentdiagnose');
            $patient->treatmentmedgiven = $request->input('treatmentmedgiven');

            // Save record
            $patient->save();

            // Commit transaction if all database operations succeeded
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Consultation updated successfully!'
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
                'message' => 'Validation failed. Please check your inputs.'
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating: ' . $e->getMessage()
            ], 500);
        }
    }

    public function walkinReferralDelete($id) 
    {
        $pvisit = PatientReferral::find($id);
        $pvisit->delete();

        return response()->json(['success'=> true, 'message'=>'Deleted Successfully',]);
    }

    public function onlineappoint()
    {
        return view('pages.appointment.online');
    }
}
