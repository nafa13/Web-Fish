<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// Route untuk Login dari HP
Route::post('/login', [ApiController::class, 'login']);

// Group Route yang butuh login (opsional: bisa pakai sanctum nanti, sekarang kita buka dulu biar mudah dites)
Route::get('/dashboard-data', [ApiController::class, 'getDashboardData']);
Route::post('/feed-now', [ApiController::class, 'feedNow']);
Route::post('/sensor-data', [ApiController::class, 'storeSensorData']); // Untuk Arduino kirim data