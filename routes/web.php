<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClockRecordController;
use App\Models\ClockRecord; // ← 追加
use App\Models\BreakTime;
use Carbon\Carbon; // ← 追加
use Illuminate\Support\Facades\Auth; // ← 追加
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // ↓ ここからダッシュボード表示ロジックに書き換え
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        // breaks リレーションを読み込む
        $record = ClockRecord::with('breaks')
            ->where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        $status = 'Not Clocked In';

        if ($record) {
            if ($record->checkout_time) {
                $status = 'Clocked Out';
            } else {
                // end_time が null の休憩データがあれば「On Break」
                $hasActiveBreak = $record->breaks->whereNull('end_time')->isNotEmpty();
                if ($hasActiveBreak) {
                    $status = 'On Break';
                } else {
                    $status = 'Working';
                }
            }
        }

        return view('dashboard', compact('record', 'status'));
    })->name('dashboard');

    // 打刻用ルート（POST送信）
    Route::post('/clock-in', [ClockRecordController::class, 'checkIn'])->name('clock.in');
    Route::post('/clock-out', [ClockRecordController::class, 'checkOut'])->name('clock.out');

    // 休憩用ルート（追加）
    Route::post('/break-start', [ClockRecordController::class, 'breakStart'])->name('break.start');
    Route::post('/break-end', [ClockRecordController::class, 'breakEnd'])->name('break.end');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
