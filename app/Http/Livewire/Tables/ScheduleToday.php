<?php

namespace App\Http\Livewire\Tables;

use App\Models\Schedule;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Carbon\Carbon;

class ScheduleToday extends LivewireDatatable
{
    public function builder()
    {
    	$now = Carbon::now();
  		return Schedule::orderBy('date','desc');
    }

    public function columns()
    {
    	return [
	    	Column::name('employee_name')
	    		->label('Employee Name')
	    		->filterable(),
	    	DateColumn::name('date')
	    		->label('Date')
	    		->format('d F Y')
	    		->filterable(),
            Column::name('shift_name')
                ->label('Shift'),
            Column::name('status_depart')
                ->label('Status Attendance'),
	    	Column::name('status')
	    		->label('Status')
                ->filterable(['Working','Not sign in',' Rest','Done']),
            TimeColumn::name('started_at')
            	->format('H:i:s'),
            TimeColumn::name('stoped_at')
            	->format('H:i:s'),
            Column::callback(['workhour', 'timer'], function ($workhour, $timer) {
        		$int = $workhour + $timer;
        		$time = $int/60/60;
		        return number_format($time,1);
            })->label('WorkHour'),
            Column::callback(['id','timer'], function ($id,$timer) {
                $schedule = Schedule::find($id);
                if ($schedule->details->count() < 1) {
                    return '-';
                }
                else{
                    return $schedule->details->first()->location;
                }
            })->label('Work Type'),
            Column::callback(['id'], function ($id) {
                $schedule = Schedule::find($id);
                $now = Carbon::now();
                $shift = $schedule->shift;
                if ($schedule->stoped_at != null) {
                    $stoped = Carbon::parse($schedule->stoped_at);
                    $time_out =Carbon::parse($schedule->date .' '.$shift->time_out);
                    if ($stoped < $time_out) {
                        return $stoped->diffInMinutes($time_out). "minutes";
                    }
                    else{
                        return '-';
                    }
                }
                else{
                    return '-';
                }
            })->label('Wasted Time'),
            Column::name('note')
                ->label('Reason'),
            Column::name('position_start')
                ->label('Position (start state)'),
	    	Column::name('position_stop')
	    		->label('Position (stop state)'),

    	];
    }
}