<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PatientController;

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/profile', [PatientController::class, 'show'])->name('patient.profile.show');
    Route::put('/patient/profile', [PatientController::class, 'update'])->name('patient.profile.update');
});
use App\Http\Controllers\StaffController;

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/patients', [StaffController::class, 'index'])->name('staff.patients.index'); // عرض المرضى
    Route::put('/staff/patients/{id}', [StaffController::class, 'update'])->name('staff.patients.update'); // تعديل بيانات مريض معين
});
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/patients', [AdminController::class, 'index'])->name('admin.patients.index'); // عرض المرضى
    Route::put('/admin/patients/{id}', [AdminController::class, 'update'])->name('admin.patients.update'); // تعديل بيانات مريض معين
});
