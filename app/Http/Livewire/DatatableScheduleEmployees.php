<?php

namespace App\Http\Livewire;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class DatatableScheduleEmployees extends LivewireDatatable
{
    public function builder()
    {
  		return Schedule::where('id','!=',null);
    }

    public function columns()
    {
        return [
	    	Column::name('employee_name')
	    		->label('Employee Name'),
            DateColumn::name('date')
                ->label('Date')
                ->format('d F Y')->filterable(),
            Column::name('shift_name')
                ->label('Shift'),
            Column::callback(['workhour', 'timer'], function ($workhour, $timer) {
        		$int = $workhour + $timer;
        		$seconds = intval($int%60);
		        $total_minutes = intval($int/60);
		        $minutes = $total_minutes%60;
		        $hours = intval($total_minutes/60);
		        $time = $hours."h ".$minutes."m";
		        return $time;
            })->label('WorkHour'),
            Column::name('status')
                ->label('Status'),
            Column::name('status_depart')
                ->label('Status Depart'),
            TimeColumn::name('started_at')
                ->label('Time Start')
                ->format('H:i:s'),
            TimeColumn::name('stoped_at')
                ->label('Time Stop')
                ->format('H:i:s'),
        ];
    }
}