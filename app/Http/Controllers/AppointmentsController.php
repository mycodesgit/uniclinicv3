<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
