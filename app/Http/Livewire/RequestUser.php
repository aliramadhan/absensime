<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Request;
use App\Models\User;
use App\Models\ListLeave;
use App\Models\Schedule;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestNotificationMail;

class RequestUser extends Component
{
	public $user, $tasks,$now, $isModal, $type, $desc, $date, $time_overtime, $is_cancel_order, $leaves,$stopRequestDate, $startRequestDate, $newShift, $shifts, $newCatering;

    public function render()
    {
        $this->leaves = ListLeave::all();
    	$this->now = Carbon::now();
    	$this->user = auth()->user();
        $this->shifts = Shift::all();
        return view('livewire.User.Request.request-user');
    }
    public function showCreate()
    {
        $this->isModal = 'Create';
    }
    public function closeModal()
    {
        $this->isModal = false;
    }
    public function resetFields()
    {
        $this->type = null;
        $this->desc = null;
        $this->date = null;
        $this->time_overtime = null;
        $this->is_cancel_order = null;
    }
    public function createRequest()
    {
        //MEMBUAT VALIDASI
        $now = Carbon::now();
        if($this->type == 'Activation Record'){
            $this->validate([
                'desc' => 'required',
            ]);
            $this->date = Carbon::now();
            $this->is_cancel_order = 0;
        }
        elseif($this->type == 'Sick' || $this->type == 'Remote'){
            $this->validate([
                'type' => 'required|string',
                'desc' => 'required',
                'startRequestDate' => 'required',
                'stopRequestDate' => 'required'
            ]);

            $startDate = Carbon::parse($this->startRequestDate);
            $stopDate = Carbon::parse($this->stopRequestDate);
            $limitDays = $startDate->diffInDays($stopDate);
        }
        elseif ($this->type == 'Overtime') {
            $this->validate([
                'type' => 'required|string',
                'date' => 'required|date',
                'desc' => 'required',
                'time_overtime' => 'required'
            ]);
            $this->is_cancel_order = 0;
        }
        elseif ($this->type == 'Change Shift') {
            $this->validate([
                'type' => 'required|string',
                'date' => 'required|date',
                'newShift' => 'required'
            ]);
            $this->is_cancel_order = 0;
        }
        else{
            $this->validate([
                'type' => 'required|string',
                'date' => 'required|date|after:now',
                'desc' => 'required',
            ]);
        }
        //cek cancel catering not null
        if ($this->is_cancel_order == null) {
            $this->is_cancel_order = 0;
        }
        $cekLeave = ListLeave::where('name','like','%'.$this->type.'%')->first();
        if ($cekLeave != null) {
            if ($this->user->leave_count < 1 && $cekLeave->is_annual == 1 && !in_array($this->type, ['Overtime','Sick','Remote','Excused'])) {
                $this->closeModal();
                $this->type = null;
                $this->desc = null;
                $this->date = null;
                $this->time_overtime = null;
                $this->is_cancel_order = null;
                return session()->flash('failure', "Can't request annual leave, your remaining annual leave is zero.");
            }
        }
        $issetRequest = Request::whereDate('date',$this->date)->where('type',$this->type)->where('employee_id',$this->user->id)->first();
        $isSchedule = Schedule::whereDate('date',$this->date)->where('employee_id',$this->user->id)->first();
        if ($this->type == 'Sick' || $this->type == 'Remote') {
            for ($i=0; $i <= $limitDays; $i++, $startDate->addDay()) { 
                $issetRequest = Request::whereDate('date',$startDate)->where('type',$this->type)->where('employee_id',$this->user->id)->first();
                if ($issetRequest != null) {
                    $this->closeModal();
                    $this->resetFields();
                    return session()->flash('failure', "Can't submit request, duplicate request.");
                }

            }
        }
        if ($issetRequest != null) {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Can't submit request, duplicate request.");
        }
        elseif ($isSchedule == null && $this->type != 'Overtime' && $this->type != 'Sick' && $this->type != 'Remote') {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Can't submit request, no schedule found.");
        }
        else{
            //create activated record
            if ($this->type == 'Activated Record') {
                $request = Request::create([
                    'employee_id' => $this->user->id,
                    'employee_name' => $this->user->name,
                    'type' => $this->type,
                    'desc' => $this->desc,
                    'date' => $this->date,
                    'time' => $this->time_overtime,
                    'is_cancel_order' => $this->is_cancel_order,
                    'status' => 'Accept'
                ]);
                $this->user->update(['is_active' => 1]);
            }
            else{
                //create request sick
                if ($this->type == 'Sick') {
                    $startDate = Carbon::parse($this->startRequestDate);
                    $stopDate = Carbon::parse($this->stopRequestDate);
                    for ($i=0; $i <= $limitDays; $i++, $startDate->addDay()) { 
                        $isSchedule = Schedule::whereDate('date',$startDate)->where('employee_id',$this->user->id)->first();
                        if ($isSchedule == null) {
                            continue;
                        }
                        else{
                            $request = Request::create([
                                'employee_id' => $this->user->id,
                                'employee_name' => $this->user->name,
                                'type' => $this->type,
                                'desc' => $this->desc,
                                'date' => $startDate,
                                'is_cancel_order' => $this->is_cancel_order,
                                'status' => 'Accept'
                            ]);
                        }
                    }

                    //send mail to manager if manager founded
                    $manager = User::where('role','Manager')->where('division',$this->user->division)->first();
                    if($manager != null){
                        $date = $this->startRequestDate .' -> '.$this->stopRequestDate;
                        $data = array('name' => $this->user->name, 'type' => $this->type, 'date' => $date, 'desc' => $this->desc,'user_mail' => $this->user->email);
                        Mail::to($manager->email)->send(new RequestNotificationMail($data));
                    }

                    //send mail to admin
                    $admins = User::where('role','Admin')->get();
                    foreach ($admins as $admin) {
                        $date = $this->startRequestDate .' -> '.$this->stopRequestDate;
                        $data = array('name' => $this->user->name, 'type' => $this->type, 'date' => $date, 'desc' => $this->desc,'user_mail' => $this->user->email);
                        Mail::to($admin->email)->send(new RequestNotificationMail($data));
                    }
                }
                //create request leave / remote
                elseif($cekLeave != null || $this->type == 'Remote'){
                    $startDate = Carbon::parse($this->startRequestDate);
                    $stopDate = Carbon::parse($this->stopRequestDate);
                    for ($i=0; $i <= $limitDays; $i++, $startDate->addDay()) { 
                        $isSchedule = Schedule::whereDate('date',$startDate)->where('employee_id',$this->user->id)->first();
                        if ($isSchedule == null) {
                            continue;
                        }
                        else{
                            $request = Request::create([
                                'employee_id' => $this->user->id,
                                'employee_name' => $this->user->name,
                                'type' => $this->type,
                                'desc' => $this->desc,
                                'date' => $startDate,
                                'is_cancel_order' => $this->is_cancel_order,
                            ]);
                        }
                    }

                    //send mail to manager if manager founded
                    $manager = User::where('role','Manager')->where('division',$this->user->division)->first();
                    if($manager != null){
                        $date = $this->startRequestDate .' -> '.$this->stopRequestDate;
                        $data = array('name' => $this->user->name, 'type' => $this->type, 'date' => $date, 'desc' => $this->desc,'user_mail' => $this->user->email);
                        Mail::to($manager->email)->send(new RequestNotificationMail($data));
                    }

                    //send mail to admin
                    $admins = User::where('role','Admin')->get();
                    foreach ($admins as $admin) {
                        $date = $this->startRequestDate .' -> '.$this->stopRequestDate;
                        $data = array('name' => $this->user->name, 'type' => $this->type, 'date' => $date, 'desc' => $this->desc,'user_mail' => $this->user->email);
                        Mail::to($admin->email)->send(new RequestNotificationMail($data));
                    }
                }
                //create request change shift
                elseif ($this->type == 'Change Shift') {
                    $shift = Shift::find($this->newShift);
                    $date = Carbon::parse($this->date);
                    $desc = $this->user->name .' change shift from '.$isSchedule->shift_name.' to '.$shift->name.' for date '.$date->format('d F Y');
                    //send mail to manager if manager founded
                    $manager = User::where('role','Manager')->where('division',$this->user->division)->first();
                    if($manager != null){
                        $data = array('name' => $this->user->name, 'type' => $this->type, 'date' => $date->format('d F Y'), 'desc' => $desc,'user_mail' => $this->user->email);
                        Mail::to($manager->email)->send(new RequestNotificationMail($data));
                    }

                    //send mail to admin
                    $admins = User::where('role','Admin')->get();
                    foreach ($admins as $admin) {
                        $data = array('name' => $this->user->name, 'type' => $this->type, 'date' => $date->format('d F Y'), 'desc' => $desc,'user_mail' => $this->user->email);
                        Mail::to($admin->email)->send(new RequestNotificationMail($data));
                    }

                    //cek if cancel order
                    if ($this->newCatering == 'Cancel Order') {
                        $this->is_cancel_order = 1;
                    }
                    elseif($this->newCatering == 'Do Nothing!'){
                        $this->is_cancel_order = 0;
                    }

                    $request = Request::create([
                        'employee_id' => $this->user->id,
                        'employee_name' => $this->user->name,
                        'type' => $this->type,
                        'desc' => $desc,
                        'date' => $this->date,
                        'change_catering' => $this->newCatering,
                        'is_cancel_order' => $this->is_cancel_order,
                    ]);

                }
                //create request overtime
                else{
                    //send mail to manager if manager founded
                    $manager = User::where('role','Manager')->where('division',$this->user->division)->first();
                    if($manager != null){
                        $date = Carbon::parse($this->date);
                        $data = array('name' => $this->user->name, 'type' => $this->type, 'date' => $date->format('d F Y'), 'desc' => $this->desc,'user_mail' => $this->user->email);
                        Mail::to($manager->email)->send(new RequestNotificationMail($data));
                    }

                    //send mail to admin
                    $admins = User::where('role','Admin')->get();
                    foreach ($admins as $admin) {
                        $date = Carbon::parse($this->date);
                        $data = array('name' => $this->user->name, 'type' => $this->type, 'date' => $date->format('d F Y'), 'desc' => $this->desc,'user_mail' => $this->user->email);
                        Mail::to($admin->email)->send(new RequestNotificationMail($data));
                    }

                    $request = Request::create([
                        'employee_id' => $this->user->id,
                        'employee_name' => $this->user->name,
                        'type' => $this->type,
                        'desc' => $this->desc,
                        'date' => $this->date,
                        'time' => $this->time_overtime,
                        'is_cancel_order' => $this->is_cancel_order,
                    ]);
                }
            }

            $this->closeModal();
            $this->type = null;
            $this->desc = null;
            $this->date = null;
            $this->time_overtime = null;
            $this->is_cancel_order = null;
            $this->emit('refreshLivewireDatatable');
            session()->flash('message', 'Request successfully added.');
        }
    }
}
