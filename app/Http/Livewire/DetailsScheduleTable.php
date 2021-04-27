<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Models\HistorySchedule;
use App\Models\Schedule;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class DetailsScheduleTable extends LivewireDatatable
{
    public function builder()
    {
    	$user = auth()->user();
    	$details = HistorySchedule::orderBy('created_at','desc')	;
    	return $details;
    }

    public function columns()
    {
    	return [
    		Column::callback(['schedule_id'], function ($schedule_id) {
	            	$schedule = Schedule::find($schedule_id);
			        return $schedule->date;
	            })->label('Date'),
    		Column::callback(['id'], function ($id) {
	            	$detail = HistorySchedule::find($id);
	            	$time_start = Carbon::parse($detail->started_at);
	            	if ($detail->stoped_at == null) {
	            		$time_stop = Carbon::now();
	            	}
	            	else{
	            		$time_stop = Carbon::parse($detail->stoped_at);
	            	}
	            	$timer = $time_start->format('H:i').' - '.$time_stop->format('H:i');
			        return $timer;
	            })->label('Timer'),
    		Column::name('task')
    			->label('Task'),
    		Column::name('task_desc')
    			->label('Description'),
    		Column::name('status')
    			->label('Status'),
    		Column::name('location')
    			->label('Location Work')

    	];
    }
}