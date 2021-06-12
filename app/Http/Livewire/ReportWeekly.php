<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\User;
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
    		if ($user->position == 'Security') {
    			$user->target_weekly = '50h';
    			$user->percent_weekly = ($total_minutes/3000) * 100;
    		}
    		elseif($user->position == 'Project Manager'){
    			$user->target_weekly = '20h';
    			$user->percent_weekly = ($total_minutes/1200) * 100;
    		}
    		else{
    			$user->target_weekly = '40h';
    			$user->percent_weekly = ($total_minutes/2400) * 100;
    		}
    	}
        return view('livewire.Admin.report-weekly');
    }
}
