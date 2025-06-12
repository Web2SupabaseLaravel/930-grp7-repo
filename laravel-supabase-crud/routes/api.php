<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController; // ← هذا يجب أن يكون هنا فوق

// تسجيل الدخول والتسجيل
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'show']); // للاختبار مثلاً

// API Resources
Route::apiResource('roles', RoleController::class);

Route::middleware('api')->group(function () {
    Route::apiResource('users', UserController::class);
});
