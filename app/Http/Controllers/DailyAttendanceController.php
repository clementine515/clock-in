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

        // 1ページあたり10件でページネーションを取得
        $records = ClockRecord::with(['user', 'breaks'])
            ->where('date', $targetDate)
            ->orderBy('created_at', 'asc')
            ->paginate(10)
            ->appends(['date' => $targetDate]); // ページ切り替え時も日付(?date=YYYY-MM-DD)を保持

        return view('daily-list', compact('records', 'current', 'prevDate', 'nextDate'));
    }
}
