<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Shift;
use Carbon\Carbon;

class ReportWeekly extends Component
{
	public $users;
    
    public function render()
    {
    	$this->users = User::where('role','Employee')->get();
    	foreach ($this->users as $user) {
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
    	}
        return view('livewire.Admin.report-weekly');
    }
}
