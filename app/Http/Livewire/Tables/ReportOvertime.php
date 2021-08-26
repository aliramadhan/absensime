<?php

namespace App\Http\Livewire\Tables;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Request;
use App\Models\User;
use App\Exports\ExportOvertime;
use Excel;

class ReportOvertime extends Component
{
	public $now, $users;
	public function mount()
	{
		$this->now = Carbon::now();
		$this->users = User::where('role','Employee')->orWhere('role','Manager')->orderBy('name','asc')->get();
	}
    public function render()
    {
    	if (request('month') != null) {
    		$this->now = $now = Carbon::parse(request('month'));
    	}
        return view('livewire.Admin.report-overtime');
    }
    public function exportSchedule($now)
    {
    	$filename = 'EmployeeOvertime_'.$this->now->format('F Y').'.xlsx';
        return Excel::download(new ExportOvertime($now), $filename);
    }
}
