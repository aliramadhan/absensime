<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryLock extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'request_id',
        'date',
        'reason',
        'is_requested',
    ];
}
