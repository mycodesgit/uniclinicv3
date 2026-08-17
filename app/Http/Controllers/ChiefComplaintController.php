<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChiefComplaintController extends Controller
{
    public function index()
    {
        return view('complaint.chief');
    }
}
