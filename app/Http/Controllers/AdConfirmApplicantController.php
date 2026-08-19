<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;

use Storage;
use Carbon\Carbon;
use App\Models\AdmissionDB\Applicant;
use App\Models\AdmissionDB\ApplicantDocs;
use App\Models\AdmissionDB\ApplicantClinic;
use App\Models\AdmissionDB\ExamineeResult;
use App\Models\AdmissionDB\Programs;
use App\Models\AdmissionDB\Strands;
use App\Models\AdmissionDB\AdmissionDate;
use App\Models\AdmissionDB\Time;
use App\Models\AdmissionDB\Venue;
use App\Models\AdmissionDB\Year;

class AdConfirmApplicantController extends Controller
{
    public function index()
    {
        $strand = Strands::all();
        $curryear = Year::orderBy('adyear', 'DESC')->get();

        return view('pages.admission.confirm', compact('strand', 'curryear'));
    }
    
    public function store(Request $request)
    {
        $strand = Strands::all();
        $curryear = Year::orderBy('adyear', 'DESC')->get();

        return view('pages.admission.confirmsearch', compact('strand', 'curryear'));
    }

    public function show(Request $request)
    {   
        $year = $request->query('year');
        $campus = $request->query('campus');
        $strand =$request->query('strand');

        $query = Applicant::leftJoin('ad_examinee_result', 'ad_applicant_admission.id', '=', 'ad_examinee_result.app_id')
                        ->leftJoin('ad_applicant_clinic', 'ad_applicant_admission.id', '=', 'ad_applicant_clinic.app_id')
                        ->select('ad_applicant_admission.*', 'ad_applicant_admission.id as adid', 'ad_applicant_admission.strand as appstrand', 'ad_examinee_result.*', 'ad_applicant_clinic.*')
                        ->where('ad_applicant_admission.year', $year)
                        ->where('ad_applicant_admission.campus', $campus)
                        ->whereIn('p_status', [3, 4, 5, 6]);
        
        if ($strand) {
            $query->where('ad_applicant_admission.strand', $strand);
        }

        $data = $query->get();
        
        // Encrypt adid
        $data->transform(function ($item) {
            $item->adid = Crypt::encryptString($item->adid);
            return $item;
        });
        
        return response()->json(['data' => $data]);
    }

    public function updateMDHUdocs(Request $request) 
    {
        $decryptedId = Crypt::decryptString($request->input('id'));
        
        $affectedRows = ApplicantClinic::where('app_id', $decryptedId)
            ->update(['status' => $request->input('status')]);

        if ($affectedRows > 0) {
            return response()->json(['success' => true, 'message' => 'Updated Successfully'], 200);
        } else {
            return response()->json(['error' => true, 'message' => 'No applicant found.'], 422);
        }
    }

    public function idcrypt(Request $request) 
    {
        $enrcryptedID = encrypt($request->data);

        return $enrcryptedID;
    }
}
