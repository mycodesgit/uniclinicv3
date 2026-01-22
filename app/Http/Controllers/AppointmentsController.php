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
use App\Models\ClinicDB\Medicine;
use App\Models\ClinicDB\Complaint;

class AppointmentsController extends Controller
{
    public function index()
    {
        return view('appointment.walkin');
    }

    public function onlineappoint()
    {
        return view('appointment.online');
    }

    public function getwalkinconsult()
    {
        $data = Patientvisit::leftJoin('coasv2_db_enrollment.students', 'patientvisits.stid', '=', 'coasv2_db_enrollment.students.stud_id')
            ->leftJoin('complaint', 'patientvisits.chief_complaint', '=', 'complaint.id')
            ->select(
                    'patientvisits.*', 
                    'coasv2_db_enrollment.students.lname', 
                    'coasv2_db_enrollment.students.fname', 
                    'coasv2_db_enrollment.students.mname', 
                    'coasv2_db_enrollment.students.ext', 
                    'complaint.complaint as complaintname')
            ->orderBy('patientvisits.date', 'desc')
            ->get()
            ->map(function ($item) {
                $item->complaintname = collect(explode(',', $item->chief_complaint))
                    ->map(fn($id) => Complaint::find($id)?->complaint)
                    ->filter()
                    ->values();
                return $item;
            });

        return response()->json(['data' => $data]);
    }
}
