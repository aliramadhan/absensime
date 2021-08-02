<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'employee_name',
        'date',
        'type',
        'time',
        'desc',
        'status',
        'is_cancel_order',
        'is_check_half',
        'change_catering',
    ];
}
