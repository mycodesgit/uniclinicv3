<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ClinicDB\AccidentInjury;

class AccidentInjuryController extends Controller
{
    public function index()
    {
        return view('pages.accident.injury');
    }

    public function show() 
    {
        $data = AccidentInjury::orderBy('id', 'ASC')->get();

        return response()->json(['data' => $data]);
    }

    public function create(Request $request) 
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
            ]);

            $nameInjury = $request->input('name'); 

            $existingMedServRender = AccidentInjury::where('name', $nameInjury)
                            ->first();

            if ($existingMedServRender) {
                return response()->json(['error' => true, 'message' => 'Nature of Injury already exists'], 404);
            }

            try {
                AccidentInjury::create([
                    'name' => $nameInjury,
                ]);

                return response()->json(['success' => true, 'message' => 'Nature of Injury stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store Nature of Injury'], 404);
            }
        }
    }
}
