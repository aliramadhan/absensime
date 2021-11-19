<?php

namespace App\Http\Livewire\Tables;

use App\Models\Schedule;
use App\Models\Request;
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
                ->label('Status Attendance')->filterable(),
            Column::name('status')
                ->label('Status')
                ->filterable(['Working','Not sign in',' Pause','Done']),
            TimeColumn::name('started_at')
                ->format('H:i:s'),
            TimeColumn::name('stoped_at')
                ->format('H:i:s'),
            Column::callback(['id','workhour', 'timer'], function ($id,$workhour, $timer) {
                $schedule = Schedule::find($id);
                $isRequest = Request::where('date',$schedule->date)->where('type','Absent')->where('status','Accept')->first();
                $int = $workhour + $timer;
                $time = $int/60/60;
                if ($isRequest != null) {
                    return number_format($time,1).' (absent)';
                }
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
                $schedule = Schedule::where('id',$id)->with('shift')->first();
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
            /*Column::callback(['id','timer','status'], function ($id,$timer,$status) {
                $schedule = Schedule::find($id);
                $rest = $schedule->details->where('status','Rest')->sortByDesc('id')->first();
                if($rest != null && $schedule->status == 'Pause'){
                    if($rest->is_subtitute){
                        return 'with subtitute';
                    }
                    else{
                        return 'without subtitute';
                    }
                }
            })->label('Reason')*/
            Column::name('note')->label('Reason'),
            Column::name('position_start')
                ->label('Position (start state)'),
            Column::name('position_stop')
                ->label('Position (stop state)'),

        ];
    }
}