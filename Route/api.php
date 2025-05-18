<?php


use App\Http\Controllers\API\ServiceController;

Route::apiResource('services', ServiceController::class);
Route::apiResource('services', App\Http\Controllers\API\ServiceController::class);
