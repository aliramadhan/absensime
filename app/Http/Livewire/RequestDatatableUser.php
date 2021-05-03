<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Request;
use App\Models\Schedule;
use App\Models\User;
use App\Models\ListLeave;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class RequestDatatableUser extends LivewireDatatable
{
	public $hideable = 'select',$time_overtime;
    public function builder()
    {
    	if (auth()->user()->role == 'Manager') {
        	return Request::where('employee_id','!=',null);
    	}
    	elseif (auth()->user()->role == 'Admin') {
        	return Request::where('employee_id','!=',null);
    	}
    	else{
        	return Request::where('employee_id',auth()->user()->id);
    	}
    }

    public function columns()
    {
    	$list_leave = ListLeave::pluck('name');
    	$list_leave->push('Sick');
    	$list_leave->push('Overtime');
    	$list_leave->push('Remote');
    	if (auth()->user()->role == 'Manager') {
	        return [
	            Column::callback(['employee_id'], function ($employee_id) {
	            	$user = User::find($employee_id);
			        return $user->name;
	            })->label('Employee')->filterable(),
	            DateColumn::name('date')
	                ->label('Date')
	                ->format('d F Y')->filterable(),
	            Column::name('type')
	                ->label('Type')->filterable($list_leave),
	            Column::name('desc')
	                ->label('Description'),
	            Column::callback(['time'], function ($time) {
	            	if ($time == null) {
	            		return '-';
	            	}
			        return $time/60;
	            })->label('Duration Request(Hour)'),
	        	Column::name('status')
	                ->label('Status')->filterable(['Waiting', 'Approve', 'Decline']),       
	            DateColumn::name('created_at')
	                ->label('Request at')
	                ->format('d F Y H:i'),
	            Column::callback(['id'], function ($id) {
	            	$request = Request::find($id);
	            	$this->time_overtime = $request->time_overtime;
	            	if ($request->status == 'Waiting') {
		                return view('livewire.Admin.table-actions-request-admin', ['id' => $id, 'request' => $request]);
	            	}
	            })->label('Action')
	        ];
    	}
    	elseif (auth()->user()->role == 'Admin') {
	        return [
	            Column::callback(['employee_id'], function ($employee_id) {
	            	$user = User::find($employee_id);
			        return $user->name;
	            })->label('Employee'),
	            DateColumn::name('date')
	                ->label('Date')
	                ->format('d F Y')->filterable(),
	            Column::name('type')
	                ->label('Type')
	                ->filterable($list_leave),
	            Column::name('desc')
	                ->label('Description'),
	            Column::callback(['time'], function ($time) {
	            	if ($time == null) {
	            		return '-';
	            	}
			        return $time/60;
	            })->label('Duration Request(Hour)'),
	            DateColumn::name('created_at')
	                ->label('Request at')
	                ->format('d F Y H:i'),
	        ];
    	}
    	else{
	        return [
	            DateColumn::name('date')
	                ->label('Date')
	                ->format('d F Y')
	                ->filterable(),
	            Column::name('type')
	                ->label('Type')
	                ->filterable($list_leave),
	            Column::name('desc')
	                ->label('Description')
	                ->searchable(),	 
	            Column::callback(['time'], function ($time) {
	            	if ($time == null) {
	            		return '-';
	            	}
			        return $time/60;
	            })->label('Duration Request(Hour)'),
	        	Column::name('status')
	                ->label('Status')->filterable(['Waiting', 'Approve', 'Decline']),           
	            DateColumn::name('created_at')
	                ->label('Request at')
	                ->format('H:i l, d F Y')
	                ,
	        ];
    	}
    }
    public function actionRequest($id, $action)
    {
    	$request = Request::find($id);
    	$user = User::find($request->employee_id);
    	if ($action == 'Accept') {
    		$schedule = Schedule::whereDate('date',$request->date)->first();
    		$cekLeave = ListLeave::where('name','like','%'.$request->type.'%')->first();
    		if($request->type != 'Overtime' && $request->type != 'Excused'){
	    		$schedule->update([
	    			'status' => $request->type
	    		]);
    		}
    		elseif($request->type == 'Excused'){
    			$schedule->update([
    				'status_depart' => 'Present'
    			]);
    		}
    		elseif($cekLeave != null && $cekLeave->is_annual == 1){
    			$user->leave_count -= 1;
    			$user->save();
    		}
    		$request->status = $action;
    		$request->save();
    	}
    	else{
    		$request->status = $action;
    		$request->save();
    	}
        $this->emit('refreshLivewireDatatable');
    }
}