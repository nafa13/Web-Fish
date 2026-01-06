<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// PENTING: Panggil Controller yang baru Anda buat (MobileFishController)
use App\Http\Controllers\Api\MobileFishController;

// 1. Route Login (Sesuai permintaan Flutter)
// URL: http://ip-address/api/login
Route::post('/login', [MobileFishController::class, 'login']);

// 2. Route Simpan Suhu (Sesuai fungsi insertSuhu di MobileFishController)
// URL: http://ip-address/api/insert-suhu
Route::post('/insert-suhu', [MobileFishController::class, 'insertSuhu']);

// 3. Route Ambil Data (Opsional, jika nanti mau menampilkan suhu di Flutter)
Route::get('/get-suhu', [MobileFishController::class, 'getLatestSuhu']);