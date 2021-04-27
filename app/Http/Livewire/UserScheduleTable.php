<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class UserScheduleTable extends LivewireDatatable
{
    public $model = Schedule::class;
    public $hideable = 'select';
    public function builder()
    {
        return Schedule::where('employee_id',auth()->user()->id);

    }
    public function columns()
    {
        return [
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
            Column::callback(['started_at'], function ($started_at) {
                if ($started_at == null) {
                    return '-';
                }
                $time = Carbon::parse($started_at)->format('H:i:s');
                return $time;
            })->label('Time Start'),
            Column::callback(['stoped_at'], function ($stoped_at) {
                if ($stoped_at == null) {
                    return '-';
                }
                $time = Carbon::parse($stoped_at)->format('H:i:s');
                return $time;
            })->label('Time Stop'),
        ];
    }
}