<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ClinicDB\Complaint;
use App\Models\ClinicDB\CategoryComplaint;

class CategoryComplaintController extends Controller
{
    public function show()
    {
        $data = CategoryComplaint::get();

        return response()->json(['data' => $data]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'category_name' => 'required',
            ]);

            $categoryName = $request->input('category_name');
            $existingCategory = CategoryComplaint::where('category_name', $categoryName)->first();

            if ($existingCategory) {
                return redirect()->route('categoryRead')->with('error1', 'Category already exists!');
            }

            try {
                $cat = CategoryComplaint::create([
                    'category_name' => $request->input('category_name'),
                ]);

                return response()->json(['success' => true, 'message' => 'Category stored successfully!'],  200);

            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store Category!'],  404);
            }
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'category_name' => 'required',
        ]);

        try {
            $categoryName = $request->input('category_name');
            $existingCategory = CategoryComplaint::where('category_name', $categoryName)->where('id', '!=', $request->input('id'))->first();

            if ($existingCategory) {
                return response()->json(['error' => true, 'message' => 'Category already exists!'], 200);
            }

            $category = CategoryComplaint::findOrFail($request->input('id'));
            $category->update([
                'category_name' => $categoryName,
                'cstatus' => $request->input('cstatus'),
            ]);

            return response()->json(['success' => true, 'message' => 'Updated Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Failed to update Category!'], 404);
        }
    }
}
