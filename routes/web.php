<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\PDFreportController;
use App\Http\Controllers\MedicineController;

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
        Route::get('/students/search',[PatientsController::class,'show'])->name('patients.show');
        Route::get('/students/{id}',[PatientsController::class,'showdetails'])->name('patients.details');
        Route::post('/student/show/moreinfo/update', [PatientsController::class, 'update'])->name('patients.update');
        Route::post('/student/show/moreinfo/historyupdate', [PatientsController::class, 'studentsHistory'])->name('patients.studentsHistory');

        Route::get('/portal/provinces/{region_id}', [PatientsController::class, 'getPortalProvinces'])->name('getPortalProvinces');
        Route::get('/portal/cities/{province_id}', [PatientsController::class, 'getPortalCities'])->name('getPortalCities');
        Route::get('/portal/barangays/{city_id}', [PatientsController::class, 'getPortalBarangays'])->name('getPortalBarangays');

        Route::get('/students/prehe-report/{id}', [PDFreportController::class,'showprehepdf'])->name('showprehepdf');
    });

    Route::prefix('/appointment')->group(function () {
        Route::get('/walkins',[AppointmentsController::class,'index'])->name('appointment.walkin');
        Route::get('/walkins/details/{id}',[AppointmentsController::class,'walkinconsultdetails'])->name('appointment.walkin.details');
        Route::get('/walkins/fetch/{id}',[AppointmentsController::class,'getwalkinconsult'])->name('getwalkinconsult.walkin');
        Route::post('/walkins/add',[AppointmentsController::class,'createWalkinConsultation'])->name('appointment.walkinconsult.store');

        Route::get('/walkins/referralfetch/{id}',[AppointmentsController::class,'getwalkinreferral'])->name('getwalkinreferral.walkin');
        Route::post('/walkins/referral/add',[AppointmentsController::class,'createWalkinReferral'])->name('appointment.walkinreferral.store');

        Route::get('/online',[AppointmentsController::class,'onlineappoint'])->name('appointment.online');
    });

    Route::prefix('/all')->group(function () {
        Route::get('/medicine',[MedicineController::class,'index'])->name('medicine.list');
        Route::get('/medicine/list/ajax', [MedicineController::class, 'getmedicineRead'])->name('getmedicineRead');
        Route::post('/medicine/add', [MedicineController::class, 'medicineCreate'])->name('medicineCreate');
        Route::post('/medicineUpdate', [MedicineController::class, 'medicineUpdate'])->name('medicineUpdate');
        Route::post('/medicineDelete/{id}', [MedicineController::class, 'medicineDelete'])->name('medicineDelete');
    });