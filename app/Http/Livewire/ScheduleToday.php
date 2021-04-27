<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ScheduleToday extends Component
{
	public $isModal;
    public function render()
    {
        return view('livewire.Admin.schedule-today');
    }
}
