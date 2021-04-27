<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListLeave extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'duration',
        'is_annual',
    ];
}
