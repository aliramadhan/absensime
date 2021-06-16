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
        'position',
        'task',
        'task_desc',
        'latitude',
        'longitude',
    ];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
