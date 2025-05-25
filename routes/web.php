// routes/web.php
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PractitionerController;




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

    Route::resource('services', ServiceController::class);
Route::resource('practitioners', PractitionerController::class);


Route::middleware('auth')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])
         ->name('appointments.index');

    Route::get('/appointments/create', [AppointmentController::class, 'create'])
         ->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])
         ->name('appointments.store');
    Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])
         ->name('appointments.edit');
    Route::put('/appointments/{id}', [AppointmentController::class, 'update'])
         ->name('appointments.update');
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])
         ->name('appointments.destroy');
    Route::post('/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])
         ->name('appointments.confirm');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

     
});
