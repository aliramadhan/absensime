<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HistorySchedule;
use App\Models\Shift;
use App\Models\User;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'shift_id',
        'shift_name',
        'date',
        'workhour',
        'timer',
        'status',
        'status_depart',
        'status_stop',
        'note',
        'position_start',
        'position_stop',
        'current_position',
        'started_at',
        'stoped_at',
    ];

    public function details()
    {
        return $this->hasMany(HistorySchedule::class,'schedule_id');
    }
    public function shift()
    {
        return $this->hasOne(Shift::class,'id','shift_id');
    }
    public function user()
    {
        return $this->hasOne(User::class,'id','employee_id');
    }
}
