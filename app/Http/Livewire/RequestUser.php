<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Request;
use App\Models\User;
use App\Models\ListLeave;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\HistoryLock;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestNotificationMail;

class RequestUser extends Component
{
	public $user, $tasks,$now, $isModal, $type, $desc, $date, $time_overtime, $is_cancel_order, $is_check_half = 0, $leaves,$stopRequestDate, $startRequestDate, $newShift, $shifts, $newCatering, $users, $setUser, $historyLock;

    public function render()
    {
        $this->leaves = ListLeave::all();
    	$this->now = Carbon::now();
    	$this->user = auth()->user();
        $this->users = User::where('division',$this->user->division)->where('roles','Employee')->get();
        $this->shifts = Shift::all();
        //set history lock
        $this->historyLock = HistoryLock::where('employee_id',$this->user->id)->where('is_requested',0)->orderBy('id','asc')->get();
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
    
    public function updateDescRequest()
    {
        if ($this->type == 'Record Activation') {
            $this->desc = $this->historyLock->first()->reason;
        }
        else{
            $this->desc = "";
        }
    }
    public function createActivationWithRequest()
    {
        //validate for activation        
        $this->validate([
            'desc' => 'required',
        ]);
        $this->date = Carbon::now();
        $this->is_cancel_order = 0;
        //validate for request after activation
        $this->validate([
            'typeRequest' => 'required',
            'dateTo' => 'required|date|after_or_equal:dateFrom',
            'dateFrom' => 'required|date|before_or_equal:dateTo',
            'descRequest' => 'required',
        ]);
        //cek if ada request belum acc pada hari dan type request yang sama atau have schedule
        $startDate = Carbon::parse($this->dateFrom);
        $stopDate = Carbon::parse($this->dateTo);
        $limitDays = $startDate->diffInDays($stopDate);
        for ($i=0; $i <= $limitDays; $i++, $startDate->addDay()) { 
            $issetRequest = Request::whereDate('date',$startDate)->where('type',$this->typeRequest)->where('employee_id',$this->user->id)->where('status','Waiting')->first();
            $isSchedule = Schedule::whereDate('date',$startDate)->where('employee_id',$this->user->id)->first();
            if ($isSchedule == null) {
                $this->closeModal();
                $this->resetFields();
                return session()->flash('failure', "Can't submit request, no schedule found.");
            }
            if ($issetRequest != null) {
                $this->closeModal();
                $this->resetFields();
                return session()->flash('failure', "Can't submit request, duplicate request.");
            }
            //create request after activation
            if ($isSchedule != null && $issetRequest == null) {
                $request = Request::create([
                    'employee_id' => $this->user->id,
                    'employee_name' => $this->user->name,
                    'type' => $this->typeRequest,
                    'desc' => $this->descRequest,
                    'date' => $startDate,
                    'is_cancel_order' => $this->is_cancel_order,
                    'status' => 'Waiting'
                ]);

                //send mail to manager if manager founded
                $manager = User::where('role','Manager')->where('division',$this->user->division)->first();
                if($manager != null){
                    $date = $this->dateFrom .' -> '.$this->dateTo;
                    $data = array('name' => $this->user->name, 'type' => $this->typeRequest, 'date' => $date, 'desc' => $this->descRequest,'user_mail' => $this->user->email);
                    Mail::to($manager->email)->send(new RequestNotificationMail($data));
                }

                //send mail to admin
                $admins = User::where('role','Admin')->get();
                foreach ($admins as $admin) {
                    $date = $this->dateFrom .' -> '.$this->dateTo;
                    $data = array('name' => $this->user->name, 'type' => $this->typeRequest, 'date' => $date, 'desc' => $this->descRequest,'user_mail' => $this->user->email);
                    Mail::to($admin->email)->send(new RequestNotificationMail($data));
                }
            }
        }
        //create activation
        $request = Request::create([
            'employee_id' => $this->user->id,
            'employee_name' => $this->user->name,
            'type' => $this->type,
            'desc' => $this->desc,
            'date' => $this->date,
            'time' => $this->time_overtime,
            'is_cancel_order' => $this->is_cancel_order,
            'is_check_half' => $this->is_check_half,
            'status' => 'Accept'
        ]);
        $this->historyLock->first()->update([
            'request_id' => $request->id,
            'is_requested' => 1
        ]);
        if ($this->historyLock->count() < 1) {
            $this->user->update(['is_active' => 1]);
        }

        $this->closeModal();
        $this->type = $this->typeRequest = null;
        $this->desc = $this->typeRequest  = null;
        $this->date = $this->dateTo = $this->dateFrom= null;
        $this->time_overtime = null;
        $this->is_cancel_order = null;
        $this->emit('refreshLivewireDatatable');
        session()->flash('success', 'Request successfully added.');
    }
    public function createRequest()
    {
        $cekLeave = ListLeave::where('name','like','%'.$this->type.'%')->first();
        //MEMBUAT VALIDASI
        $now = Carbon::now();
        if($this->type == 'Record Activation'){
            $this->validate([
                'desc' => 'required',
            ]);
            $this->date = Carbon::now();
            $this->is_cancel_order = 0;
        }
        elseif($this->type == 'Sick' || $this->type == 'Permission' || $this->type == 'Remote' || $cekLeave != null){
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
        elseif ($this->type == 'Mandatory') {
            $this->validate([
                'setUser' => 'required',
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
        /*
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
        }*/
        //cek if request not duplicate
        $issetRequest = Request::whereDate('date',$this->date)->where('type',$this->type)->where('employee_id',$this->user->id)->where('status','Waiting')->first();
        if ($this->type == 'Mandatory') {
            $issetRequest = Request::whereDate('date',$this->date)->where('type',$this->type)->where('employee_id',$this->setUser)->where('status','Waiting')->first();
        }
        //cek if user has schedule
        $isSchedule = Schedule::whereDate('date',$this->date)->where('employee_id',$this->user->id)->first();
        if ($this->type == 'Mandatory') {
            $isSchedule = Schedule::whereDate('date',$this->date)->where('employee_id',$this->setUser)->first();
        }

        if ($this->type == 'Sick' || $this->type == 'Permission' || $this->type == 'Remote' || $cekLeave != null) {
            for ($i=0; $i <= $limitDays; $i++, $startDate->addDay()) { 
                $issetRequest = Request::whereDate('date',$startDate)->where('type',$this->type)->where('employee_id',$this->user->id)->where('status','Waiting')->first();
                if ($issetRequest != null) {
                    $this->closeModal();
                    $this->resetFields();
                    return session()->flash('failure', "Can't submit request, duplicate request.");
                }
            }
        }
        
        if ($issetRequest != null && $this->type != 'Record Activation') {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Can't submit request, duplicate request.");
        }
        elseif ($isSchedule == null && $cekLeave == null && $this->type != 'Record Activation') {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Can't submit request, no schedule found.");
        }
        else{
            //create activated record
            if ($this->type == 'Record Activation') {
                if ($this->historyLock->first() != null && $this->historyLock->first()->reason == 'Reach the tolerance limit of 1 hour late') {
                    $this->desc = 'Reach the tolerance limit of 1 hour late - '.$this->desc;
                }
                $request = Request::create([
                    'employee_id' => $this->user->id,
                    'employee_name' => $this->user->name,
                    'type' => $this->type,
                    'desc' => $this->desc,
                    'date' => $this->date,
                    'time' => $this->time_overtime,
                    'is_cancel_order' => $this->is_cancel_order,
                    'is_check_half' => $this->is_check_half,
                    'status' => 'Accept'
                ]);
                $this->historyLock->first()->update([
                    'request_id' => $request->id,
                    'is_requested' => 1
                ]);
                if ($this->historyLock->where('is_requested',0)->count() < 1) {
                    $this->user->update(['is_active' => 1]);
                }
            }
            else{
                //create request sick
                if ($this->type == 'Sick' || $this->type == 'Permission') {
                    $startDate = Carbon::parse($this->startRequestDate);
                    $stopDate = Carbon::parse($this->stopRequestDate);
                    for ($i=0; $i <= $limitDays; $i++, $startDate->addDay()) { 
                        $isSchedule = Schedule::whereDate('date',$startDate)->where('employee_id',$this->user->id)->first();
                        if ($isSchedule == null) {
                            session()->flash('failure', "Can't submit request, no schedule found at ".$startDate->format('d F Y').".");
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
                                'status' => 'Waiting'
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
                            session()->flash('failure', "Can't submit request, no schedule found at ".$startDate->format('d F Y').".");
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
                elseif($this->type == 'Mandatory'){
                    $user = User::where('id',$this->setUser)->first();
                    $shift = Shift::find($this->newShift);
                    $date = Carbon::parse($this->date);
                    $desc = $user->name .' change shift from '.$isSchedule->shift_name.' to '.$shift->name.' for date '.$date->format('d F Y');
                    //send mail to manager if manager founded
                    $manager = User::where('role','Manager')->where('division',$this->user->division)->first();
                    if($manager != null){
                        $data = array('name' => $user->name, 'type' => $this->type, 'date' => $date->format('d F Y'), 'desc' => $desc,'user_mail' => $user->email);
                        Mail::to($manager->email)->send(new RequestNotificationMail($data));
                    }

                    //send mail to admin
                    $admins = User::where('role','Admin')->get();
                    foreach ($admins as $admin) {
                        $data = array('name' => $user->name, 'type' => $this->type, 'date' => $date->format('d F Y'), 'desc' => $desc,'user_mail' => $user->email);
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
                        'employee_id' => $user->id,
                        'employee_name' => $user->name,
                        'type' => $this->type,
                        'desc' => $desc,
                        'date' => $this->date,
                        'change_catering' => $this->newCatering,
                        'is_cancel_order' => $this->is_cancel_order,
                        'status' => 'Accept',
                    ]);

                    //update schedule after create mandatory
                    $schedule = Schedule::whereDate('date',$date)->where('employee_id',$user->id)->first();
                    //cancel catering
                    if ($request->is_cancel_order == 1) {
                        $order = DB::table('orders')->whereDate('order_date',$request->date)->where('employee_id',$user->id)->limit(1);
                        if ($order != null) {
                            $order->delete();
                        }
                    }
                    elseif($request->is_cancel_order == 0 && $request->change_catering !=null){
                        $order = DB::table('orders')->whereDate('order_date',$request->date)->where('employee_id',$user->id)->limit(1);
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
            session()->flash('success', 'Request successfully added.');
        }
    }
}
