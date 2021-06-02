<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Request;
use App\Models\User;
use App\Models\ListLeave;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestNotificationMail;

class RequestUser extends Component
{
	public $user, $tasks,$now, $isModal, $type, $desc, $date, $time_overtime, $is_cancel_order, $leaves,$stopRequestDate, $startRequestDate;

    public function render()
    {
        $this->leaves = ListLeave::all();
    	$this->now = Carbon::now();
    	$this->user = auth()->user();
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
        if($this->type == 'Activated Record'){
            $this->validate([
                'desc' => 'required',
            ]);
            $this->date = Carbon::now();
            $this->is_cancel_order = 0;
        }
        elseif($this->type == 'Sick'){
            $this->validate([
                'type' => 'required|string',
                'desc' => 'required',
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
                $this->resetFields();
                return session()->flash('failure', "Can't request annual leave, your remaining annual leave is zero.");
            }
        }
        $issetRequest = Request::whereDate('date',$this->date)->where('type',$this->type)->where('employee_id',$this->user->id)->first();
        $isSchedule = Schedule::whereDate('date',$this->date)->where('employee_id',$this->user->id)->first();
        if ($this->type == 'Sick') {
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
        elseif ($isSchedule == null && $this->type != 'Overtime' && $this->type != 'Sick') {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Can't submit request, no schedule found.");
        }
        else{
            if ($this->type == 'Activated Record') {
                $request = Request::create([
                    'employee_id' => $this->user->id,
                    'employee_name' => $this->user->name,
                    'type' => $this->type,
                    'desc' => $this->desc,
                    'date' => $this->date,
                    'time' => $this->time_overtime,
                    'is_cancel_order' => $this->is_cancel_order,
                ]);
                $this->user->update(['is_active' => 1]);
            }
            else{
                if ($this->type == 'Sick') {
                    return dd($this->type);
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
                                'time' => $this->time_overtime,
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
            $this->resetFields();
            session()->flash('success', 'Request successfully added.');
            $this->emit('refreshLivewireDatatable');
        }
    }
}
