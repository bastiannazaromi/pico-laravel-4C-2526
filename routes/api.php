<?php

use App\Http\Controllers\GpsController;
use App\Http\Controllers\RelayController;
use Illuminate\Support\Facades\Route;

Route::post('/gps', [GpsController::class, 'store']);

Route::get('/relay', [RelayController::class, 'status']);
