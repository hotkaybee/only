<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AvailableCarsController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/available-cars', [AvailableCarsController::class, 'index']);
    Route::get('/available-cars/{car}', [AvailableCarsController::class, 'show']);
});
