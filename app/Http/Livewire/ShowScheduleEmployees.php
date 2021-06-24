<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\ListLeave;
use App\Exports\ScheduleExport;
use Excel;
use App\Models\User;

class ShowScheduleEmployees extends Component
{
	public $schedules, $now, $users, $shifts, $leaves;
    public function render()
    {
    	$this->users = User::where('role','Employee')->orWhere('role','Manager')->orderBy('name','asc')->get();
    	$this->now = $now = Carbon::now();
        $this->shifts = Shift::all();
        $this->leaves = ListLeave::all()->pluck('name')->toArray();
    	$schedules = Schedule::whereBetween('date',[$now->startOfMonth()->format('Y-m-d'),$now->endOfMonth()->format('Y-m-d')])->get();
        return view('livewire.User.show-schedule-employees');
    }
    public function exportSchedule()
    {
    	$filename = 'Schedule_'.$this->now->format('F Y').'.xlsx';
        return Excel::download(new ScheduleExport('User'), $filename);
    }
}