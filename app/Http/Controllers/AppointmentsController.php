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

class AppointmentsController extends Controller
{
    public function index()
    {
        return view('appointment.walkin');
    }

    public function walkinconsultdetails($id)
    {
        $patients = Student::findOrFail($id);
        $complaints =  Complaint::all();
        $medicines = Medicine::all();

        $student = DB::connection('enrollment')
            ->table('students')
            ->where('id', $id)
            ->first();

        $patientVisit = Patientvisit::where('stid', $student->id)->get();

        return view('appointment.walkin-details', compact('patients', 'complaints', 'medicines', 'patientVisit', 'id'));
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

        return view('appointment.walkin-empdetails', compact('patients', 'complaints', 'medicines', 'patientVisit', 'emp_ID'));
    }

    public function getwalkinconsult($id)
    {
        $student = DB::connection('enrollment')
            ->table('students')
            ->select('id', 'lname', 'fname', 'mname', 'ext')
            ->where('id', $id)
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
                'date'      => $visit->date,
                'time'      => $visit->time,
                'treatment' => $visit->treatment,
                'qty'       => $visit->qty,
                'consultID' => $visit->consultID,

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


    public function getwalkinreferral($id) 
    {
        $student = DB::connection('enrollment')
            ->table('students')
            ->select('id', 'lname', 'fname', 'mname', 'ext')
            ->where('id', $id)
            ->first();

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $refer = PatientReferral::where('stid', $student->id)
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

    public function onlineappoint()
    {
        return view('appointment.online');
    }
}
