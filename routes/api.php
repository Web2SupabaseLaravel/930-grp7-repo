<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

// API routes for Appointment Scheduling
Route::apiResource('appointments', AppointmentController::class);
