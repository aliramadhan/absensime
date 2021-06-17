<?php

namespace App\Http\Livewire\Tables;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportWeekly extends LivewireDatatable
{
    public function builder()
    {
		return $users = User::where('role','Employee');

    }

    public function columns()
    {

    	/*foreach ($users->get() as $user) {
    		//get time weekly
    		$startWeek = Carbon::now()->startOfWeek();
    		$endWeek = Carbon::now()->endOfWeek();
    		$weekly_work = Schedule::where('employee_id',$user->id)->whereBetween('date',[$startWeek->format('Y-m-d'),$endWeek->format('Y-m-d')]);
    		$seconds = intval($weekly_work->sum(\DB::raw('workhour + timer'))%60);
		    $total_minutes = intval($weekly_work->sum(\DB::raw('workhour + timer'))/60);
		    $minutes = $total_minutes%60;
		    $hours = intval($total_minutes/60);
		    $user->time_weekly = $hours."h ".$minutes."m";

    		//set target weekly
            foreach ($weekly_work->get() as $scheduleLoop) {
                $minuteTarget = 0;
                $shift = Shift::where('id',$scheduleLoop->shift_id)->first();
                $time_out = Carbon::parse($shift->time_out);
                $time_in = Carbon::parse($shift->time_in);
                $user->target_weekly += $time_in->diffInMinutes($time_out);
            }

            if ($user->target_weekly == 0) {
                $user->percent_weekly = 0;
            }
            else{
                if ($user->position == 'Security') {
                    $user->percent_weekly = ($total_minutes/$user->target_weekly) * 100;
                }
                elseif($user->position == 'Project Manager'){
                    $user->percent_weekly = ($total_minutes/$user->target_weekly) * 100;
                }
                else{
                    $user->percent_weekly = ($total_minutes/$user->target_weekly) * 100;
                }
                $minutes = $user->target_weekly%60;
                $hours = intval($user->target_weekly/60);
                $user->target_weekly = $hours."h ".$minutes."m";
            }
    	}*/
    	return [
	    	Column::name('name')
	    		->label('Employee Name')->filterable(),
            Column::callback(['id'], function ($id) {
            	$user = User::find($id);
            	$startWeek = Carbon::now()->startOfWeek();
	    		$endWeek = Carbon::now()->endOfWeek();
	    		$weekly_work = Schedule::where('employee_id',$user->id)->whereBetween('date',[$startWeek->format('Y-m-d'),$endWeek->format('Y-m-d')]);
	    		$seconds = intval($weekly_work->sum(\DB::raw('workhour + timer'))%60);
			    $total_minutes = intval($weekly_work->sum(\DB::raw('workhour + timer'))/60);
			    $minutes = $total_minutes%60;
			    $hours = intval($total_minutes/60);
			    return $hours."h ".$minutes."m";
            })->label('Weekly Hour'),
            Column::callback(['id','name'], function ($id,$name) {
            	$user = User::find($id);
            	$startWeek = Carbon::now()->startOfWeek();
	    		$endWeek = Carbon::now()->endOfWeek();
	    		$weekly_work = Schedule::where('employee_id',$user->id)->whereBetween('date',[$startWeek->format('Y-m-d'),$endWeek->format('Y-m-d')]);
	    		$seconds = intval($weekly_work->sum(\DB::raw('workhour + timer'))%60);
			    $total_minutes = intval($weekly_work->sum(\DB::raw('workhour + timer'))/60);
			    $minutes = $total_minutes%60;
			    $hours = intval($total_minutes/60);
			    //set target weekly
	            foreach ($weekly_work->get() as $scheduleLoop) {
	                $minuteTarget = 0;
	                $shift = Shift::where('id',$scheduleLoop->shift_id)->first();
	                $time_out = Carbon::parse($shift->time_out);
	                $time_in = Carbon::parse($shift->time_in);
                    if ($time_in > $time_out) {
                        $user->target_weekly += $time_in->diffInMinutes($time_out->addDay());
                    }
                    else{
                        $user->target_weekly += $time_in->diffInMinutes($time_out);

                    }
	            }
                $minutes = $user->target_weekly%60;
                $hours = intval($user->target_weekly/60);
			    return $hours."h ".$minutes."m";
            })->label('Target Hour'),
            Column::callback(['id','name','role'], function ($id,$name, $role) {
            	$user = User::find($id);
            	$startWeek = Carbon::now()->startOfWeek();
	    		$endWeek = Carbon::now()->endOfWeek();
	    		$weekly_work = Schedule::where('employee_id',$user->id)->whereBetween('date',[$startWeek->format('Y-m-d'),$endWeek->format('Y-m-d')]);
	    		$seconds = intval($weekly_work->sum(\DB::raw('workhour + timer'))%60);
			    $total_minutes = intval($weekly_work->sum(\DB::raw('workhour + timer'))/60);
			    $minutes = $total_minutes%60;
			    $hours = intval($total_minutes/60);
			    //set target weekly
	            foreach ($weekly_work->get() as $scheduleLoop) {
	                $minuteTarget = 0;
	                $shift = Shift::where('id',$scheduleLoop->shift_id)->first();
	                $time_out = Carbon::parse($shift->time_out);
	                $time_in = Carbon::parse($shift->time_in);
	                $user->target_weekly += $time_in->diffInMinutes($time_out);
	            }
                $minutes = $user->target_weekly%60;
                $hours = intval($user->target_weekly/60);

	            if ($user->target_weekly == 0) {
	                $user->percent_weekly = 0;
	            }
	            else{
	                if ($user->position == 'Security') {
	                    $user->percent_weekly = ($total_minutes/$user->target_weekly) * 100;
	                }
	                elseif($user->position == 'Project Manager'){
	                    $user->percent_weekly = ($total_minutes/$user->target_weekly) * 100;
	                }
	                else{
	                    $user->percent_weekly = ($total_minutes/$user->target_weekly) * 100;
	                }
	                $minutes = $user->target_weekly%60;
	                $hours = intval($user->target_weekly/60);
	                $user->target_weekly = $hours."h ".$minutes."m";
	            }
            	if ($user->percent_weekly >= 100) {
            		return 'Over Target';
            	}
            	elseif($user->percent_weekly == 100){
            		return 'Complete';
            	}
            	elseif ($user->percent_weekly <= 0) {
            		return 'need Working';
            	}
            	elseif($user->percent_weekly < 100){
            		return 'Less';
            	}
            })->label('Status'),
    	];
    }
}