<?php

namespace App\Http\Livewire;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class AdminDatatableSchedule extends LivewireDatatable
{
    public $hideable = 'select', $isModal;
    public $schedules, $users, $shifts;
    public function builder()
    {
        $this->schedules = Schedule::all();
        $this->users = User::all();
        $this->shifts = Shift::all();
        if (auth()->user()->roles == 'Manager') {
            $this->users = User::where('division',auth()->user()->division)->get();
            $users = User::where('division',auth()->user()->division)->pluck('id');
            $this->schedules = Schedule::whereIn('employee_id',$users)->get();
            return Schedule::whereIn('employee_id',$users)->orderBy('date','desc');
        }
  		return Schedule::orderBy('date','desc');
    }

    public function columns()
    {
    	return [
	    	Column::name('employee_name')
	    		->label('Employee Name'),
	    	DateColumn::name('date')
	    		->label('Date')
	    		->format('d F Y')
	    		->filterable(),
	    	Column::name('shift_name')
	    		->label('Shift'),
	    	Column::name('status')
	    		->label('Status'),

            Column::callback(['id'], function ($id) {
            	$schedule = $this->schedules->where('id',$id)->first();
            	$employee = $this->users->where('id',$schedule->employee_id)->first();
            	$shifts = $this->shifts;
            	if($schedule->date > Carbon::now()->format('Y-m-d')){
	                return view('livewire.Admin.table-actions-schedule-admin', [
	                	'id' => $id,
	                	'employee' => $employee,
	                	'date' => $schedule->date,
	                	'shifts' => $shifts,
	                	'shift' => $schedule->shift,
	                	'schedule' => $schedule,
	                ]);
            	}
            })->label('Action')->excludeFromExport()

    	];
    }
    public function destroy($id)
    {
    	$schedule = Schedule::find($id);
    	$schedule->delete();
      	session()->flash('failure', 'Schedule '.$schedule->name . ' deleted successfully.');
    }
}