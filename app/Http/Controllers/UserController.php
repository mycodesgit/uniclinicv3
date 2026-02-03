<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\ClinicDB\User;

class UserController extends Controller
{
    public function index() 
    {
        return view("users.list");
    }
}
