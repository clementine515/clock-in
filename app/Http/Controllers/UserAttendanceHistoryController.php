<?php

namespace App\Http\Controllers;

use App\Models\ClockRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAttendanceHistoryController extends Controller
{
    /**
     * ログインユーザーの月別勤怠履歴を表示
     */
    public function index(Request $request)
    {
        // パラメータから month (YYYY-MM) を取得（無ければ今月）
        $targetMonth = $request->query('month', Carbon::now()->format('Y-m'));

        // Carbonオブジェクトに変換（該当月の1日）
        $currentMonth = Carbon::parse($targetMonth . '-01');

        // 前月と翌月（YYYY-MM形式）
        $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');

        // ログインユーザーの指定月の打刻データを取得（日付昇順）
        $records = ClockRecord::with('breaks')
            ->where('user_id', Auth::id())
            ->whereYear('date', $currentMonth->year)
            ->whereMonth('date', $currentMonth->month)
            ->orderBy('date', 'asc')
            ->get();

        return view('user-history', compact('records', 'currentMonth', 'prevMonth', 'nextMonth'));
    }
}
