<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::resource('appointments', AppointmentController::class);

Route::get('/appointments', [AppointmentController::class, 'bookingPage']);
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
