<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BreakTime; // 追記

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
}
