<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // 追記：アクセサ用
use App\Models\BreakTime; // 追記
use Carbon\Carbon; // 追記：時間計算用

class ClockRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'checkin_time',
        'checkout_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breaks()
    {
        return $this->hasMany(BreakTime::class, 'clock_record_id');
    }

    /**
     * 総休憩時間（分）を計算して "HH:MM" 形式で返すアクセサ
     */
    protected function totalBreakTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                $totalMinutes = 0;

                foreach ($this->breaks as $break) {
                    if ($break->start_time && $break->end_time) {
                        $start = Carbon::parse($break->start_time);
                        $end = Carbon::parse($break->end_time);
                        $totalMinutes += $start->diffInMinutes($end);
                    }
                }

                if ($totalMinutes === 0) {
                    return '00:00';
                }

                $hours = floor($totalMinutes / 60);
                $minutes = $totalMinutes % 60;

                return sprintf('%02d:%02d', $hours, $minutes);
            }
        );
    }

    /**
     * 実労働時間（拘束時間 - 休憩時間）を "HH:MM" 形式で返すアクセサ
     */
    protected function workTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                // 出勤または退勤のどちらかが無い場合は未計算扱い
                if (!$this->checkin_time || !$this->checkout_time) {
                    return '-';
                }

                $checkin = Carbon::parse($this->checkin_time);
                $checkout = Carbon::parse($this->checkout_time);

                // 拘束時間（分）
                $totalBoundMinutes = $checkin->diffInMinutes($checkout);

                // 休憩時間（分）の合計
                $totalBreakMinutes = 0;
                foreach ($this->breaks as $break) {
                    if ($break->start_time && $break->end_time) {
                        $start = Carbon::parse($break->start_time);
                        $end = Carbon::parse($break->end_time);
                        $totalBreakMinutes += $start->diffInMinutes($end);
                    }
                }

                // 実労働時間（分）＝ 拘束時間 − 休憩時間
                $actualWorkMinutes = max(0, $totalBoundMinutes - $totalBreakMinutes);

                $hours = floor($actualWorkMinutes / 60);
                $minutes = $actualWorkMinutes % 60;

                return sprintf('%02d:%02d', $hours, $minutes);
            }
        );
    }
}
