<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ClinicDB\Complaint;

class ChiefComplaintController extends Controller
{
    public function index()
    {
        return view('complaint.chief');
    }

    public function create(Request $request) 
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'categoryname' => 'required',
                'complaintname' => 'required',
                'specificcondition' => 'nullable',
            ]);

            $catName = $request->input('categoryname');
            $complaintName = $request->input('complaintname');
            $specificCondition = $request->input('specificcondition');

            $existingComplaint = Complaint::where('categoryname', $catName)
                            ->where('complaintname', $complaintName)
                            ->first();

            if ($existingComplaint) {
                return response()->json(['error' => true, 'message' => 'Chief complaint already exists'], 404);
            }

            try {
                Complaint::create([
                    'categoryname' => $catName,
                    'complaintname' => $complaintName,
                    'specificcondition' => $specificCondition,
                ]);

                return response()->json(['success' => true, 'message' => 'Chief complaint stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store Chief Complaint'], 404);
            }
        }
    }

    public function show() 
    {
        $data = Complaint::orderBy('id', 'ASC')->get();

        return response()->json(['data' => $data]);
    }

    public function update(Request $request) 
    {
        $request->validate([
            'categoryname' => 'required',
            'complaintname' => 'required',
        ]);

        try {
            $catName = $request->input('categoryname');
            $complaintName = $request->input('complaintname');
            $existingComplaint = Complaint::where('categoryname', $catName)->where('complaintname', $complaintName)->where('id', '!=', $request->input('id'))->first();

            if ($existingComplaint) {
                return response()->json(['error' => true, 'message' => 'Chief Complaint already exists'], 404);
            }

            $chiefcomp = Complaint::findOrFail($request->input('id'));
            $chiefcomp->update([
                'categoryname' => $catName,
                'complaintname' => $complaintName,
                'specificcondition'=> $request->input('specificcondition'),
        ]);
            return response()->json(['success' => true, 'message' => 'Chief Complaint update successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to Update Chief Complaint'], 404);
        }
    }

    public function delete($id) 
    {
        $chiefcomp = Complaint::find($id);
        $chiefcomp->delete();

        return response()->json(['success'=> true, 'message'=>'Deleted Successfully',]);
    }
}
