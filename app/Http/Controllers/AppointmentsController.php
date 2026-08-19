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
        
        $complaints =  Complaint::all();
        $medicines = Medicine::all();
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

        $emps = DB::connection('hremp')
            ->table('employees')
            ->where('emp_ID', $emp_ID)
            ->first();

        $patientVisit = Patientvisit::where('stdntID', $emps->emp_ID)->get();

        return view('pages.appointment.walkin-empdetails', compact('patients', 'complaints', 'medicines', 'patientVisit', 'emp_ID'));
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

        $visits = Patientvisit::where('stid', $student->id)
            ->orderBy('date', 'desc')
            ->get();
        
        if ($visits->isEmpty()) {
            return response()->json(['data' => []]);
        }

        $complaintIds = $visits->pluck('chief_complaint')
            ->filter() // remove null
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

        $data = $visits->map(function ($visit) use ($student, $complaints, $medicines) {

            return [
                'id'        => $visit->id,
                'consultID' => $visit->consultID,
                'date'      => $visit->date,
                'time'      => $visit->time,
                'qty'       => $visit->qty,

                'chief_complaint' => $visit->chief_complaint,
                'bp' => $visit->bp,
                'pr' => $visit->pr,
                'rr' => $visit->rr,
                'spo' => $visit->spo,
                'btemp' => $visit->btemp,
                'lmp' => $visit->lmp,
                'pheight' => $visit->pheight,
                'pweight' => $visit->pweight,
                'treatment' => $visit->treatment,
                'certificate' => $visit->certificate,
                'medicine' => $visit->medicine,
                'qty' => $visit->qty,

                'lname' => $student->lname,
                'fname' => $student->fname,
                'mname' => $student->mname,
                'ext'   => $student->ext,

                // SAFE string output
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
        $patient = new Patientvisit();
        $patient->stid = $request->input('stid');
        $patient->stdntID = $request->input('stdntID');
        $patient->consultID = $request->input('consultID');
        $patient->date = $request->input('date');
        $patient->time = $request->input('time');
        $patient->pcat = $request->input('pcat');

        $patient->chief_complaint = $request->input('chief_complaint');
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

        $input1 = $request->input('qty', []);  
        $input2 = $request->input('medicine', []);
        $input3 = $request->input('chief_complaint', []);

        $maxCount = max(count($input1), count($input2), count($input3));
        
        $input1 = array_pad($input1, $maxCount, '');  
        $input2 = array_pad($input2, $maxCount, '');
        $input3 = array_pad($input3, $maxCount, '');
        
        $input1 = array_map(function($value) {
            return $value === null ? '' : $value;
        }, $input1);
        
        $input2 = array_map(function($value) {
            return $value === null ? '' : $value;
        }, $input2);
        
        $input3 = array_map(function($value) {
            return $value === null ? '' : $value;
        }, $input3);
        
        $complaint = implode(',', $input3);
        
        if (substr($complaint, -1) === ',') {
            $complaint = rtrim($complaint, ',');
        }
        $quantity = implode(',', $input1);
        $medicine = implode(',', $input2);
        
        $patient->medicine = $medicine;
        
        $medicinesDetails = [];
        $medicines = explode(',', $medicine);
        $quantities = explode(',', $quantity);
        
        $quantityvisit = explode(',', $patient->qty);
        
        foreach ($medicines as $index => $med) {
            $medicine2 = Medicine::select('qty', 'id', 'medicine')->where('id', $med)->first();
            
            if ($medicine2) {
                $visitQuantity = isset($quantityvisit[$index]) ? $quantityvisit[$index] : 0;
                $newQuantity = ((int)$medicine2->qty + (int)$visitQuantity) - (int)$quantities[$index];
        
                if ($newQuantity >= 0) {
                    $medicine2->update(['qty' => $newQuantity]);
        
                    $medicinesDetails[] = [
                        'id' => $medicine2->id,
                        'medicine' => $medicine2->medicine,
                        'quantity' => $newQuantity
                    ];
                }
            }
        }
        
        $patient->chief_complaint = $complaint;
        
        $patient->qty = $quantity;
        
        $patient->save();

        return response()->json(['success' => true, 'message' => 'Added Successfully']);
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
        $pvisit = Patientvisit::find($id);
        $pvisit->delete();

        return response()->json(['success'=> true, 'message'=>'Deleted Successfully',]);
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
