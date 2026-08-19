<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClockRecordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 打刻用ルート（POST送信）
    Route::post('/clock-in', [ClockRecordController::class, 'checkIn'])->name('clock.in');
    Route::post('/clock-out', [ClockRecordController::class, 'checkOut'])->name('clock.out');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
