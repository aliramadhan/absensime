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
	public $user, $tasks,$now, $isModal, $type, $desc,$date, $time_overtime, $leaves;

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
    }
    public function createRequest()
    {
        //MEMBUAT VALIDASI
        $now = Carbon::now();
        if ($this->type != 'Overtime') {
            $this->validate([
                'type' => 'required|string',
                'date' => 'required|date|after:now',
                'desc' => 'required',
            ]);
        }
        else{
            $this->validate([
                'type' => 'required|string',
                'date' => 'required|date',
                'desc' => 'required',
            ]);
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
        if ($issetRequest != null) {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Can't submit request, duplicate request.");
        }
        elseif ($isSchedule == null) {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Can't submit request, no schedule found.");
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
            ]);
            //send mail to manager

            $this->closeModal();
            $this->resetFields();
            session()->flash('success', 'Request successfully added.');
            $this->emit('refreshLivewireDatatable');
        }
    }
}
