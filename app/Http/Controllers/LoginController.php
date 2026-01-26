<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClinicDB\User;

class LoginController extends Controller
{
    public function loginView()
    {
        return view('login');
    }

    public function loginAuthenticate(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->status == 2) {
            return redirect()->back()->with('error', 'Account is disabled');
        }

        $validated = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
        ], $request->remember);

        if ($validated) {
            return redirect()->route('dashboard')->with('success', 'Login Successfully');
        } else {
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
    }
}
