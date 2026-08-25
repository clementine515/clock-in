<?php

namespace App\Http\Controllers;

use App\Models\ClockRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyAttendanceController extends Controller
{
    /**
     * 日付別勤怠一覧画面の表示
     */
    public function index(Request $request)
    {
        // URLクエリパラメータから date を取得（なければ today）
        $targetDate = $request->query('date', Carbon::today()->toDateString());

        // Carbonオブジェクトに変換
        $current = Carbon::parse($targetDate);

        // 前日と翌日の日付文字列を作成
        $prevDate = $current->copy()->subDay()->toDateString();
        $nextDate = $current->copy()->addDay()->toDateString();

        // 指定日の全ユーザーの打刻レコードを取得（ユーザー情報と休憩情報も同時に取得）
        $records = ClockRecord::with(['user', 'breaks'])
            ->where('date', $targetDate)
            ->get();

        return view('daily-list', compact('records', 'current', 'prevDate', 'nextDate'));
    }
}
