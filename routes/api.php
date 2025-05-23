<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\AdminController;


Route::middleware(['auth:sanctum', 'role:patient'])->group(function () {
    Route::get('/patient/profile', [PatientController::class, 'show']);
    Route::put('/patient/profile', [PatientController::class, 'update']);
});


Route::middleware(['auth:sanctum', 'role:staff'])->group(function () {
    Route::get('/staff/patients', [StaffController::class, 'index']);
    Route::put('/staff/patients/{id}', [StaffController::class, 'update']);
});


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/patients', [AdminController::class, 'index']);
    Route::put('/admin/patients/{id}', [AdminController::class, 'update']);
});



Route::middleware(['auth:sanctum', 'role:patient'])->group(function () {
    Route::get('/patient/appointments', [PatientController::class, 'appointments']);
});
