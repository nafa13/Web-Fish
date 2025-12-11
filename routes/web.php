<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FishStatusController;

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

// Route Group untuk Schedule
Route::middleware('auth')->group(function () {
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
});

Route::middleware('auth')->group(function () {
    // Route Dashboard & Schedule yang sudah ada...
    
    // Route Fish Status
    Route::get('/fish-status', [FishStatusController::class, 'index'])->name('fish.status');
});