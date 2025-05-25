<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PractitionerController;
Route::get('/', function () {
    return view('welcome');
});
Route::resource('services', ServiceController::class);
Route::resource('practitioners', PractitionerController::class);
