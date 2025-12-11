<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Redirect root "/" -> Login
Route::get('/', function () {
    return redirect('/login');
});

// Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

// Dashboard (protected, hanya bisa diakses setelah login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Tambahkan route untuk tombol "Feed Now"
Route::post('/feed-now', [DashboardController::class, 'feedNow'])
    ->middleware('auth')
    ->name('feed.now');
// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('success', 'Anda berhasil logout.');
})->name('logout');
