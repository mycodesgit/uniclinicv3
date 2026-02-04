<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PatientEmpController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\PDFreportController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;

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

Route::group(['middleware'=>['guest']],function(){
    Route::get('/', function () {
        return view('login');
    });

    Route::get('/login',[LoginController::class,'loginView'])->name('getLogin');
    Route::post('/login/auth',[LoginController::class,'loginAuthenticate'])->name('postLogin');
});

Route::group(['middleware'=>['login_auth']],function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/logout',[DashboardController::class,'logout'])->name('logout');
    
    Route::prefix('/patient')->group(function () {
        Route::get('/students',[PatientsController::class,'index'])->name('patients.students');
        Route::get('/students/search',[PatientsController::class,'show'])->name('patients.show');
        Route::get('/students/{id}',[PatientsController::class,'showdetails'])->name('patients.details');
        Route::post('/student/show/moreinfo/update', [PatientsController::class, 'update'])->name('patients.update');
        Route::post('/student/show/moreinfo/historyupdate', [PatientsController::class, 'studentsHistory'])->name('patients.studentsHistory');

        Route::get('/guest',[PatientsController::class,'showguest'])->name('patients.showguest');
        Route::post('/guest/add',[PatientsController::class,'create'])->name('patients.create');

        Route::get('/employee/search', [PatientEmpController::class, 'search'])->name('patients.employee.search');
        Route::get('/employee/details/{id}',[PatientEmpController::class,'showempdetails'])->name('patients.employee.empdetails');

        Route::get('/portal/provinces/{region_id}', [PatientsController::class, 'getPortalProvinces'])->name('getPortalProvinces');
        Route::get('/portal/cities/{province_id}', [PatientsController::class, 'getPortalCities'])->name('getPortalCities');
        Route::get('/portal/barangays/{city_id}', [PatientsController::class, 'getPortalBarangays'])->name('getPortalBarangays');

        Route::get('/students/prehe-report/{id}', [PDFreportController::class,'showprehepdf'])->name('showprehepdf');
    });

    Route::prefix('/appointment')->group(function () {
        Route::get('/walkins',[AppointmentsController::class,'index'])->name('appointment.walkin');
        Route::get('/walkins/details/{id}',[AppointmentsController::class,'walkinconsultdetails'])->name('appointment.walkin.details');
        Route::get('/walkins/empdetails/{emp_ID}',[AppointmentsController::class,'walkinconsultempdetails'])->name('appointment.walkin.empdetails');
        Route::get('/walkins/fetch/{id}',[AppointmentsController::class,'getwalkinconsult'])->name('getwalkinconsult.walkin');
        Route::get('/walkins/fetchemp/{emp_ID}',[AppointmentsController::class,'getwalkinempconsult'])->name('getwalkinempconsult.walkin');
        Route::post('/walkins/add',[AppointmentsController::class,'createWalkinConsultation'])->name('appointment.walkinconsult.store');

        Route::get('/walkins/referralfetch/{id}',[AppointmentsController::class,'getwalkinreferral'])->name('getwalkinreferral.walkin');
        Route::get('/walkins/referralfetchemp/{emp_ID}',[AppointmentsController::class,'getwalkinempreferral'])->name('getwalkinempreferral.walkin');
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

    Route::prefix('/generate')->group(function () {
        Route::get('/reports/consultation',[ReportsController::class,'walkinsearch'])->name('reports.walkinsearch');
        Route::get('/reports/patientdata/details/{id}',[ReportsController::class,'walkinconsultdetails'])->name('reports.patientdatarep.details');
    });

    Route::prefix('/users')->group(function () {
        Route::get('/list',[UserController::class,'index'])->name('users.list');
        Route::post('/list/add', [UserController::class, 'create'])->name('user.create');
        Route::get('/list/add', [UserController::class, 'create'])->name('user.create');
        Route::get('/list/ajax', [UserController::class, 'show'])->name('user.show');
        Route::post('/list/update', [UserController::class, 'update'])->name('user.update');
        Route::post('/list/update/pass', [UserController::class, 'userPassUpdate'])->name('userPassUpdate');
        Route::post('/list/update/status', [UserController::class, 'userStatusUpdate'])->name('userStatusUpdate');
    });
});
