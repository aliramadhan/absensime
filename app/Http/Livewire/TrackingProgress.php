<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Schedule;

class TrackingProgress extends Component
{
	public $schedule,$user,$now;
    public function render()
    {
    	$this->now = Carbon::now();
        $this->user = auth()->user();
    	$this->schedule = Schedule::where('employee_id',$this->user->id)->where('date',$this->now->format('Y-m-d'))->first();
        return view('livewire.User.tracking-progress');
    }
}
