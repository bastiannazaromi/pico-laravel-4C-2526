<?php

use App\Http\Controllers\GpsController;
use App\Http\Controllers\RelayController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RelayController::class, 'index']);
Route::get('/relay/status', [RelayController::class, 'status']);
Route::post('/relay/update', [RelayController::class, 'update']);

Route::get('/gps', [GpsController::class, 'index']);
