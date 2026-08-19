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

use App\Models\ScheduleDB\College;
use App\Models\ScheduleDB\EnPrograms;

use App\Models\SettingDB\ConfigureCurrent;
use App\Models\SettingDB\Region;
use App\Models\SettingDB\Province;
use App\Models\SettingDB\City;
use App\Models\SettingDB\Barangay;

use App\Models\ClinicDB\Patientvisit;
use App\Models\ClinicDB\PatientReferral;
use App\Models\ClinicDB\Medicine;
use App\Models\ClinicDB\Complaint;

class ReportsController extends Controller
{
    public function walkinsearch()
    {
        return view('pages.reports.walkinconsultrep');
    }

    public function walkinsearchresult(Request $request)
    {
        return view('pages.reports.walkinconsultrepresult');
    }

    public function walkinsearchresultJson(Request $request)
    {
        $date = $request->query('date');
        $monthly = $request->query('monthly');
        $pcat = $request->query('pcat');

        $students = DB::connection('enrollment')
            ->table('students')
            ->select('id', 'fname', 'lname', 'mname', 'ext')
            ->get()
            ->keyBy('id');

        $complaint = Complaint::all()->keyBy('id');
        $medicines = Medicine::all()->keyBy('id');

        $patientVisits = Patientvisit::query();

        if ($pcat) {
            $patientVisits->where('pcat', $pcat);
        }

        if ($date) {
            $patientVisits = $patientVisits->whereDate('date', $date);
        } elseif ($monthly) {
            $patientVisits = $patientVisits->whereMonth('date', $monthly);
        }

        $patientVisits = $patientVisits->get();

        $data = $patientVisits->map(function ($visit) use ($students, $complaint, $medicines) {
            $student = $students[$visit->stid] ?? null;

            $complaintIds = $visit->chief_complaint 
                ? array_map('trim', explode(',', $visit->chief_complaint)) 
                : [];

            $medicineIds = $visit->medicine 
                ? array_map('trim', explode(',', $visit->medicine)) 
                : [];

            $complaintNames = collect($complaintIds)
                ->map(fn($id) => $complaint[$id]->complaintname ?? null)
                ->filter()
                ->implode(', ');

            $medicineNames = collect($medicineIds)
                ->map(fn($id) => $medicines[$id]->medicine ?? null)
                ->filter()
                ->implode(', ');

            return [
                'id' => $visit->id,
                'fname' => $student->fname ?? null,
                'mname' => $student->mname ?? null,
                'lname' => $student->lname ?? null,
                'ext' => $student->ext ?? null,
                'date' => $visit->date,
                'time' => $visit->time,
                'complaintname' => $complaintNames,
                'treatment' => $visit->treatment,
                'medicinename' => $medicineNames,
                'qty' => $visit->qty,
            ];
        });

        return response()->json(['data' => $data]);
    }
}
