<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\AppointmentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home.dashboard');
});

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    
    Route::prefix('/patient')->group(function () {
        Route::get('/students',[PatientsController::class,'index'])->name('patients.students');
    });

    Route::prefix('/appointment')->group(function () {
        Route::get('/walkins',[AppointmentsController::class,'index'])->name('appointment.walkin');
        Route::get('/online',[AppointmentsController::class,'onlineappoint'])->name('appointment.online');
    });