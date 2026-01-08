<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// PENTING: Panggil Controller yang baru Anda buat (MobileFishController)
use App\Http\Controllers\Api\MobileFishController;
use App\Http\Controllers\FeedingLogController;


// 1. Route Login (Sesuai permintaan Flutter)
// URL: http://ip-address/api/login
Route::post('mobile/login', [MobileFishController::class, 'login']);

// 2. Route Simpan Suhu (Sesuai fungsi insertSuhu di MobileFishController)
// URL: http://ip-address/api/insert-suhu
Route::post('mobile/insert-suhu', [MobileFishController::class, 'insertSuhu']);

// 3. Route Ambil Data (Opsional, jika nanti mau menampilkan suhu di Flutter)
Route::get('/get-suhu', [MobileFishController::class, 'getLatestSuhu']);
Route::post('/record-feeding', [FeedingLogController::class, 'storeFromFlutter']);

Route::get('/mobile/schedules', [MobileFishController::class, 'getSchedules']);
Route::post('/mobile/schedules', [MobileFishController::class, 'storeSchedule']);

// Route untuk Kontrol Manual
Route::get('/mobile/trigger-pakan', [MobileFishController::class, 'triggerPakan']);
Route::get('/mobile/trigger-kuras', [MobileFishController::class, 'triggerKuras']);