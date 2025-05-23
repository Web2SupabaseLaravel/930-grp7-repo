<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/profile', [PatientController::class, 'show'])->name('patient.profile.show');
    Route::put('/patient/profile', [PatientController::class, 'update'])->name('patient.profile.update');
});
use App\Http\Controllers\StaffController;

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/patients', [StaffController::class, 'index'])->name('staff.patients.index');
    Route::put('/staff/patients/{id}', [StaffController::class, 'update'])->name('staff.patients.update'); 
});
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/patients', [AdminController::class, 'index'])->name('admin.patients.index'); 
    Route::put('/admin/patients/{id}', [AdminController::class, 'update'])->name('admin.patients.update'); 
});

Route::middleware(['auth', 'role:admin'])->get('/admin', function () {
    return view('admin');
})->name('admin.dashboard');

Route::middleware(['auth', 'role:patient'])->get('/patient', function () {
    $user = Auth::user();
    $appointments = $user->appointments()->orderBy('appointment_at')->get();

    return view('patient', compact('user', 'appointments'));
})->name('patient.dashboard');
use App\Models\User;

Route::middleware(['auth', 'role:staff'])->get('/staff', function () {
    $patients = User::where('role', 'patient')->get();
    return view('staff', compact('patients'));
})->name('staff.dashboard');
