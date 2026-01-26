<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ClinicDB\Patientvisit;

class DashboardController extends Controller
{
    public function index()
    {
        $ptodayvisits = Patientvisit::whereDate('created_at', Carbon::today())->count();

        return view('home.dashboard', compact('ptodayvisits'));
    }
}
