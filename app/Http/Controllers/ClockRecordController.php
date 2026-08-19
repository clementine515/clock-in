<?php

namespace App\Http\Controllers;

use App\Models\ClockRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClockRecordController extends Controller
{
    /**
     * 出勤処理 (Clock In)
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString(); // "2026-08-19" のような文字列

        // 1. 本日すでに出勤データが存在するか判定
        $existingRecord = ClockRecord::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($existingRecord) {
            return redirect()->back()->with('error', 'You have already clocked in today.');
        }

        // 2. 出勤レコードを作成（Model経由でDBへ書き込み）
        ClockRecord::create([
            'user_id' => $user->id,
            'date' => $today,
            'checkin_time' => Carbon::now()->toTimeString(), // 現在時刻 "16:51:30"
        ]);

        return redirect()->back()->with('status', 'Clock In successful!');
    }

    /**
     * 退勤処理 (Clock Out)
     */
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        // 1. 本日の出勤データを取り出す
        $record = ClockRecord::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        // 出勤データがない場合
        if (!$record) {
            return redirect()->back()->with('error', 'No clock-in record found for today. Please clock in first.');
        }

        // すでに退勤データがある場合
        if ($record->checkout_time) {
            return redirect()->back()->with('error', 'You have already clocked out today.');
        }

        // 2. 退勤時間を更新（Model経由でDBへ上書き）
        $record->update([
            'checkout_time' => Carbon::now()->toTimeString(),
        ]);

        return redirect()->back()->with('status', 'Clock Out successful! Good job today.');
    }
}
