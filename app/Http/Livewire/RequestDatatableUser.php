<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Request;
use App\Models\Schedule;
use App\Models\HistorySchedule;
use App\Models\User;
use App\Models\ListLeave;
use App\Models\Shift;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use DB;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RequestDatatableUser extends LivewireDatatable
{
    use LivewireAlert;
	public $hideable = 'select',$time_overtime, $users;
    public function builder()
    {
    	if (auth()->user()->roles == 'Manager') {
    		$users = User::where('division',auth()->user()->division)->pluck('id');
        	return Request::whereIn('employee_id',$users)->where('type','!=','Activation Order')->orderBy('id','desc');
    	}
    	elseif (auth()->user()->role == 'Admin') {
    		$this->users = User::all();
        	return Request::where('employee_id','!=',null)->where('type','!=','Activation Order')->orderBy('id','desc');
    	}
    	else{
        	return Request::where('employee_id',auth()->user()->id)->where('type','!=','Activation Order')->orderBy('id','desc');
    	}
    }

    public function columns()
    {
    	$list_leave = ListLeave::pluck('name');
    	$list_leave->push('Sick');
    	$list_leave->push('Overtime');
    	$list_leave->push('Remote');
    	$list_leave->push('Change Shift');
    	$list_leave->push('Activation Record');
    	$list_leave->push('Excused');
    	if (auth()->user()->roles == 'Manager') {
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
	            Column::callback(['is_cancel_order'], function ($is_cancel) {
	            	if ($is_cancel == 1) {
	            		return 'cancel order';
	            	}
			        return '-';
	            })->label('is Cancel order?'),
	        	Column::name('status')
	                ->label('Status')->filterable(['Waiting', 'Accept', 'Decline']),       
	            DateColumn::name('created_at')
	                ->label('Request at')
	                ->format('d F Y H:i'),
	            Column::callback(['id'], function ($id) {
	            	$request = Request::find($id);
	            	$user = User::find($request->employee_id);
	            	$this->time_overtime = $request->time_overtime;
					$order = DB::table('orders')->whereDate('order_date',$request->date)->where('employee_id',$user->id)->first();
	            	if ($request->status == 'Waiting') {
		                return view('livewire.Admin.table-actions-request-admin', ['id' => $id, 'request' => $request, 'order' => $order]);
	            	}
	            })->label('Action')->excludeFromExport(),
	        ];
    	}
    	elseif (auth()->user()->role == 'Admin') {
	        return [
	            Column::callback(['employee_id'], function ($employee_id) {
	            	$user = $this->users->where('id',$employee_id)->first();
			        return $user->name;
	            })->label('Employee')->filterable(),
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
	            Column::callback(['is_cancel_order'], function ($is_cancel) {
	            	if ($is_cancel == 1) {
	            		return 'cancel order';
	            	}
			        return '-';
	            })->label('is Cancel order?'),
	        	Column::name('status')
	                ->label('Status')->filterable(['Waiting', 'Accept', 'Decline']),  
	            DateColumn::name('created_at')
	                ->label('Request at')
	                ->format('d F Y H:i'),
	            Column::callback(['id'], function ($id) {
	            	$request = Request::find($id);
    				$user = $this->users->where('id',$request->employee_id)->first();
	            	$this->time_overtime = $request->time_overtime;
					$order = DB::table('orders')->whereDate('order_date',$request->date)->where('employee_id',$user->id)->first();
	                return view('livewire.Admin.table-actions-request-admin', ['id' => $id, 'request' => $request, 'order' => $order]);
	            })->label('Actions')->excludeFromExport()
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
	            Column::callback(['is_cancel_order'], function ($is_cancel) {
	            	if ($is_cancel == 1) {
	            		return 'cancel order';
	            	}
			        return '-';
	            })->label('is Cancel order?'),
	        	Column::name('status')
	                ->label('Status')->filterable(['Waiting', 'Accept', 'Decline']),           
	            DateColumn::name('created_at')
	                ->label('Request at')
	                ->format('H:i l, d F Y'),
	            Column::callback(['id'], function ($id) {
	            	$request = Request::find($id);
	            	$this->time_overtime = $request->time_overtime;
	            	if ($request->status == 'Waiting') {
		                return view('livewire.User.table_actions.table-actions-request-user', ['id' => $id, 'request' => $request]);
	            	}
	            })->label('Action')->excludeFromExport()
	        ];
    	}
    }
    public function actionRequest($id, $action)
    {
    	$request = Request::find($id);
    	$dateRequest = Carbon::parse($request->created_at);
    	$date = Carbon::parse($request->date);
    	$user = User::find($request->employee_id);
    	$message = '';
    	if ($action == 'Accept') {
    		$schedule = Schedule::whereDate('date',$request->date)->where('employee_id',$user->id)->first();
    		$cekLeave = ListLeave::where('name','like','%'.$request->type.'%')->first();
    		if($cekLeave != null && $cekLeave->is_annual == 1 && $schedule != null){
    			$user->leave_count -= 1;
    			$user->save();
	    		$schedule->update([
	    			'status' => $request->type
	    		]);
    		}
    		elseif($request->type == 'Excused' && $schedule != null){
    			$schedule->update([
    				'status_depart' => 'Present'
    			]);
    		}
    		elseif($request->type == 'Absent' && $schedule != null){
    			$format = explode('#', $request->format);
    			$started_at = Carbon::parse($format[2]);
    			$stoped_at = Carbon::parse($format[3]);
    			$time = $started_at->diffInMinutes($stoped_at);
    			$schedule = Schedule::where('employee_id',$user->id)->whereDate('date',$date)->first();
    			#check late or not
    			if ($started_at > Carbon::parse($schedule->shift->time_in)) {
    				$status_depart = 'Late';
    			}
    			else{
    				$status_depart = 'Present';
    			}
    			if ($schedule != null) {
    				$schedule->update([
    					'status' => 'Done',
    					'status_depart' => $status_depart,
    					'started_at' => $started_at,
    					'stoped_at' => $stoped_at
    				]);
    				#create history schedule
    				$detail = HistorySchedule::create([
			            'schedule_id' => $schedule->id,
			            'status' => 'Work',
			            'started_at' => $started_at,
    					'stoped_at' => $stoped_at,
    					'location' => $format[1],
    				]);
    			}
    		}
    		elseif($request->type == 'Change Shift' && $schedule != null){
				$string = $request->desc;
				$prefix = "to ";
				$index = strpos($string, $prefix) + strlen($prefix);
				$result = substr($string, $index);
				$pieces = explode(" ", $result);
				$shift = Shift::where(function ($query) use ($pieces) {
					for ($i=0; $i < count($pieces); $i++) { 
						$query->orwhere('name', 'like',  '%' . $pieces[$i] .'%');
					}
				})->first();
	    		//cancel catering
	    		if ($request->is_cancel_order == 1) {
					$order = DB::table('orders')->whereDate('order_date',$request->date)->where('employee_id',$user->id)->first();
					if ($order != null) {
						$orderDate = Carbon::parse($order->order_date);
						if (!$orderDate->isSameDay($dateRequest)) {
							$order = DB::table('orders')->whereDate('order_date',$request->date)->where('employee_id',$user->id)->limit(1);
							$order->delete();
						}
					}
	    		}
	    		elseif($request->is_cancel_order == 0 && $request->change_catering !=null){
					$order = DB::table('orders')->whereDate('order_date',$request->date)->where('employee_id',$user->id)->first();
					if ($order != null) {
		    			$order->update([
		    				'shift' => $request->change_catering
		    			]);
					}
	    		}

				$schedule->update([
					'shift_id' => $shift->id,
					'shift_name' => $shift->name
				]);
    		}
    		elseif($request->type != 'Overtime' && $schedule != null){
	    		$schedule->update([
	    			'status' => $request->type
	    		]);
    		}
    		//cancel catering
    		if ($request->is_cancel_order == 1) {
				$order = DB::table('orders')->whereDate('order_date',$request->date)->where('employee_id',$user->id)->first();
				if ($order != null) {
					$orderDate = Carbon::parse($order->order_date);
					if (!$orderDate->isSameDay($dateRequest)) {
						$order = DB::table('orders')->whereDate('order_date',$request->date)->where('employee_id',$user->id)->limit(1);

						$order->delete();
					}
				}
    		}
    		$request->status = $action;
    		$request->save();
    	}
    	else{
    		$request->status = $action;
    		$request->save();
    	}
        $this->emit('refreshLivewireDatatable');
        $this->alert('info', 'Request '.$request->type.' from '.$user->name.' '.$action.'ed.', [
            'position' =>  'center', 
            'timer' =>  3000,
            'toast' =>  false, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'showConfirmButton' =>  false, 
        ]);
    }
}