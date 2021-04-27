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
    public function builder()
    {
  		return Schedule::where('id','!=',null);
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
	    		->label('Status')
                ->filterable(),

            Column::callback(['id'], function ($id) {
            	$schedule = Schedule::find($id);
            	$employee = User::find($schedule->employee_id);
            	$shifts = Shift::all();
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
            })->label('Action')

    	];
    }
    public function destroy($id)
    {
    	$schedule = Schedule::find($id);
    	$schedule->delete();
      	session()->flash('failure', 'Schedule '.$schedule->name . ' deleted successfully.');
    }
}