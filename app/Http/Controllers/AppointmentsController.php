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
        $patientVisit = Patientvisit::where('stid', $id)->get();

        return view('appointment.walkin-details', compact('patients', 'complaints', 'medicines', 'patientVisit', 'id'));
    }

    public function getwalkinconsult($id)
    {
        $patients = Student::findOrFail($id);

        $data = Patientvisit::leftJoin('coasv2_db_enrollment.students', 'patientvisits.stid', '=', 'coasv2_db_enrollment.students.id')
            ->leftJoin('complaint', 'patientvisits.chief_complaint', '=', 'complaint.id')
            ->leftJoin('medicines', 'patientvisits.medicine', '=', 'medicines.id')
            ->select(
                    'patientvisits.*', 
                    'coasv2_db_enrollment.students.lname', 
                    'coasv2_db_enrollment.students.fname', 
                    'coasv2_db_enrollment.students.mname', 
                    'coasv2_db_enrollment.students.ext', 
                    'complaint.complaint as complaintname',
                    'medicines.medicine as medicinename')
            ->orderBy('patientvisits.date', 'desc')
            ->where('patientvisits.stid', $id)
            ->get()
            ->map(function ($item) {
                $item->complaintname = collect(explode(',', $item->chief_complaint))
                    ->map(fn($id) => Complaint::find($id)?->complaint)
                    ->filter()
                    ->values();
                
                $item->medicinename = collect(explode(',', $item->medicine))
                    ->map(fn($id) => Medicine::find($id)?->medicine)
                    ->filter()
                    ->values();
                
                return $item;
            });

        return response()->json(['data' => $data]);
    }

    public function createWalkinConsultation(Request $request)
    {
        $patient = new Patientvisit();
        $patient->stid = $request->input('stid');
        $patient->stdntID = $request->input('stdntID');
        $patient->date = $request->input('date');
        $patient->time = $request->input('time');

        $patient->chief_complaint = $request->input('chief_complaint');
        $patient->treatment = $request->input('treatment');
        $patient->certificate = $request->input('certificate');

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
        $data = PatientReferral::leftJoin('coasv2_db_enrollment.students', 'patientreferral.stid', '=', 'coasv2_db_enrollment.students.id')
            ->select(
                    'patientreferral.*', 
                    'coasv2_db_enrollment.students.lname', 
                    'coasv2_db_enrollment.students.fname', 
                    'coasv2_db_enrollment.students.mname', 
                    'coasv2_db_enrollment.students.ext', )
            ->orderBy('patientreferral.date', 'desc')
            ->where('patientreferral.stid', $id)
            ->get();

        return response()->json(['data' => $data]);
    }

    public function onlineappoint()
    {
        return view('appointment.online');
    }
}
