<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class ReportsMedicalStatisticController extends Controller
{
    public function index()
    {
        $pdf = PDF::loadView('reports.pdf.medicalstatisticpdf')->setPaper('Legal', 'portrait');
        return $pdf->stream();
    }
}
