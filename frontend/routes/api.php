<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PatientApiController;
use App\Http\Controllers\Api\PractitionerProfileApiController;
use App\Http\Controllers\Api\AppointmentApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);

    Route::get('/patient/appointments', [PatientApiController::class, 'myAppointments']);
    Route::put('/patient/profile', [PatientApiController::class, 'updateProfile']);

    Route::get('/practitioner/profile', [PractitionerProfileApiController::class, 'show']);
    Route::put('/practitioner/profile', [PractitionerProfileApiController::class, 'update']);

    Route::apiResource('appointments', AppointmentApiController::class);
    Route::post('appointments/{id}/confirm', [AppointmentApiController::class, 'confirm']);

    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/me', [AuthApiController::class, 'me']);
});

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/forgot-password', [AuthApiController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [AuthApiController::class, 'resetPassword']);
