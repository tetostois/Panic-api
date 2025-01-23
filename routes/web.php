<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanicController;

// Route de connexion
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées par le middleware 'auth:api'
Route::middleware('auth:api')->group(function () {
    Route::post('/send-panic', [PanicController::class, 'sendPanic']);
    Route::post('/cancel-panic', [PanicController::class, 'cancelPanic']);
    Route::get('/panic-history', [PanicController::class, 'getPanicHistory']);
});