<?php

namespace App\Http\Livewire\Tables;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Carbon\Carbon;

class ReportWeekly extends LivewireDatatable
{
    public function builder()
    {
    	$now = Carbon::now();
    }

    public function columns()
    {
        //
    }
}