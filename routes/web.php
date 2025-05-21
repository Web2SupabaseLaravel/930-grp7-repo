// routes/web.php
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PractitionerController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\PatientController;



// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/home', function () { return view('home'); })->name('home');

    // User Management (Admin)
    Route::middleware('can:manage-users')->group(function () {
        Route::resource('users', UserController::class)->except(['create', 'edit']);
    });

    // Practitioner & Service Management
    Route::middleware('can:manage-practitioners')->group(function () {
        Route::resource('practitioners', PractitionerController::class)->except(['create', 'edit']);
        Route::resource('services',       ServiceController::class)     ->except(['create', 'edit']);
    });

    Route::middleware('auth:api')->group(function(){
    Route::apiResource('appointments', AppointmentController::class);
});


    
Route::middleware('auth:api')->group(function(){

    Route::get   ('patients',        [PatientController::class,'index']);
    Route::get   ('patients/{id}',   [PatientController::class,'show']);
    Route::put   ('patients/{id}',   [PatientController::class,'update']);


    Route::get   ('patients/me/appointments', [PatientController::class,'myAppointments']);
    Route::put   ('patients/me',               [PatientController::class,'update'])
         ->name('patients.update.self');
});

    Route::middleware(['auth:api','can:view-reports'])->group(function(){
    Route::get('reports/appointments',       [ReportController::class,'appointmentVolume']);
    Route::get('reports/utilization',        [ReportController::class,'practitionerUtilization']);
    Route::get('reports/cancellations',      [ReportController::class,'cancellationNoShow']);
});

    Route::get('practitioners/me/appointments', function(){
    $pr = auth()->user()->practitioner; 
    return $pr->appointments()->with('patient','service')->get();
})->middleware('auth:api');

});
