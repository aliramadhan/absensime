<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;

class HistorySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'status',
        'started_at',
        'stoped_at',
        'location',
        'task',
        'task_desc',
        'location',
        'latitude',
        'longitude',
    ];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
