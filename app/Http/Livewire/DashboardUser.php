<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Request;
use App\Models\HistorySchedule;
use App\Models\ListLeave;
use App\Models\Shift;
use Carbon\Carbon;
use Geocoder;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestNotificationMail;

class DashboardUser extends Component
{
    public $user, $now, $schedule, $schedules, $detailSchedule, $detailsSchedule, $task, $task_desc, $isModal, $location, $weekSchedules, $type_pause, $shift, $limit_workhour = 28800, $is_cancel_order, $is_check_half = 0, $note, $prevSchedule, $checkAutoStop;
    public $progress = 0, $latitude, $longitude, $position, $currentPosition;
    public $wfo = 0, $wfh = 0, $business_travel = 0, $remote, $unproductive, $time = "", $timeInt = 0, $dateCheck, $monthCheck, $leaves, $newShift, $shifts, $newCatering, $users, $setUser, $cekRemote;
    //for Request
    public $type, $desc,$date,$time_overtime, $tasking = 0,$stopRequestDate, $startRequestDate, $time_out, $time_in;
    //for activation with request
    public $typeRequest, $dateTo, $dateFrom, $descRequest;

    protected $listeners = [
        'set:latitude-longitude' => 'setLatitudeLongitude',
        'updateJurnal'
    ];

    protected $rules = [
        'detailsSchedule.*.task' => 'required|string|min:6',
        'detailsSchedule.*.id_task' => 'required',
    ];

    public function setLatitudeLongitude($latitude, $longitude) 
    {
       $this->latitude = $latitude;
       $this->longitude = $longitude;
    }
    public function intToTime($int)
    {

        $seconds = intval($int%60);
        $total_minutes = intval($int/60);
        $minutes = $total_minutes%60;
        $hours = intval($total_minutes/60);
        $time = $hours."h ".$minutes."m";
        return $time;
    }
    public function updateJurnal(HistorySchedule $detail, $value)
    {
        $detail->update([
            'task' => $value
        ]);
    }
    public function render()
    {
        $this->user = auth()->user();
        $this->leaves = ListLeave::all();
        $unproductive = 0;
        $this->user = auth()->user();
        $this->now = Carbon::now();
        $this->shifts = Shift::all();
        $this->users = User::where('division',$this->user->division)->where('roles','Employee')->get();
        $this->schedules = Schedule::where('employee_id',$this->user->id)->whereBetween('date',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->orderBy('date','asc')->get();
        $request = Request::whereDate('date',$this->now)->where('employee_id',$this->user->id)->where('type','Remote')->where('status','Accept')->first();
        if ($request != null) {
            $this->cekRemote = 1;
            $this->location = 'Remote';
        }
        //check if have shift over 24
        $schedules = Schedule::where('employee_id',$this->user->id)->whereBetween('date',[Carbon::now()->subDay(2),Carbon::now()])->where('status','!=','Done')->where('status','!=','No Record')->orderBy('date','desc')->get();
        if ($schedules->first() != null) {
            $this->schedule = $schedules->first();
        }
        else{
            $this->schedule = Schedule::where('employee_id',$this->user->id)->where('date',$this->now->format('Y-m-d'))->first();
        }
        $this->prevSchedule = Schedule::where('employee_id',$this->user->id)->where('date',Carbon::now()->subDay()->format('Y-m-d'))->first();
        if ($this->schedule != null) {
            $this->shift = $this->schedule->shift;
            $this->time_in = $time_in = Carbon::parse($this->shift->time_in);
            $this->time_out = $time_out = Carbon::parse($this->shift->time_out);
            if ($this->shift->is_night) {
                $this->limit_workhour = $time_in->diffInSeconds(Carbon::parse($time_out)->addDay());
            }
            else{
                $this->limit_workhour = $time_in->diffInSeconds($time_out);
            }
            $this->detailSchedule = $this->schedule->details->SortByDesc('id')->first();
            if($this->detailSchedule != null && $this->detailSchedule->status != 'Rest' && $this->detailSchedule->stoped_at == null){
                $this->location = $this->detailSchedule->location;
            }
            foreach ($this->schedule->details->where('status','Rest') as $detail) {
                if ($detail->stoped_at != null) {
                    $startPause = Carbon::parse($detail->started_at);
                    $stopPause = Carbon::parse($detail->stoped_at);
                    $unproductive += $startPause->diffInSeconds($stopPause);
                }
                else{
                    $startPause = Carbon::parse($detail->started_at);
                    $unproductive += $startPause->diffInSeconds(Carbon::now());
                }
            }
            $this->unproductive = $this->intToTime($unproductive);

            //count WFO/WFH
            $wfo = 0;
            $wfh = 0;
            $remote = 0;
            $business_travel = 0;
            foreach ($this->schedule->details->where('status','Work') as $work) {
                if ($work->stoped_at != null) {
                    $startPause = Carbon::parse($work->started_at);
                    $stopPause = Carbon::parse($work->stoped_at);
                    if ($work->location == 'WFO') {
                        $wfo += $startPause->diffInSeconds($stopPause);
                    }
                    elseif($work->location == 'WFH'){
                        $wfh += $startPause->diffInSeconds($stopPause);
                    }
                    elseif($work->location == 'Remote'){
                        $remote += $startPause->diffInSeconds($stopPause);
                    }
                    else{
                        $business_travel += $startPause->diffInSeconds($stopPause);
                    }
                }
                else{
                    $startPause = Carbon::parse($work->started_at);
                    if ($work->location == 'WFO') {
                        $wfo += $startPause->diffInSeconds(Carbon::now());
                    }
                    elseif($work->location == 'WFH'){
                        $wfh += $startPause->diffInSeconds(Carbon::now());
                    }
                    elseif($work->location == 'Remote'){
                        $remote += $startPause->diffInSeconds(Carbon::now());
                    }
                    else{
                        $business_travel += $startPause->diffInSeconds(Carbon::now());
                    }
                }
            }
            $this->wfo = $this->intToTime($wfo);
            $this->wfh = $this->intToTime($wfh);
            $this->remote = $this->intToTime($remote);
            $this->business_travel = $this->intToTime($business_travel);
        }
        //set weekly target
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $weekly_work = Schedule::where('employee_id',$this->user->id)->whereBetween('date',[$startWeek->format('Y-m-d'),$endWeek->format('Y-m-d')]);
        foreach ($weekly_work->get() as $weeklySchedule) {
            $shiftWeekly = $weeklySchedule->shift;
            $time_inWeekly = Carbon::parse($shiftWeekly->time_in);
            $time_outWeekly = Carbon::parse($shiftWeekly->time_out);
            if ($time_outWeekly < $time_inWeekly) {
                $this->user->target_weekly += $time_inWeekly->diffInSeconds($time_outWeekly->addDay());
            }
            else{
                $this->user->target_weekly += $time_inWeekly->diffInSeconds($time_outWeekly);
            }
        }
        $this->user->target_weekly = $this->intToTime($this->user->target_weekly);
        return view('livewire.User.dashboard');
    }
    public function showStart()
    {
        $this->isModal = 'Working';
    }
    public function showStop()
    {
        $this->isModal = 'Stop';
    }
    public function showOvertime()
    {
        $this->isModal = 'Overtime';
    }
    public function overtimeOn()
    {
        //update detail pause and stop it
        $this->schedule->update([
            'status' => 'Overtime'
        ]);

        //create new overtime
        $this->detailSchedule = HistorySchedule::create([
            'schedule_id' => $this->schedule->id,
            'status' => 'Overtime',
            'started_at' => Carbon::now(),
            'task' => $this->task,
            'task_desc' => $this->task_desc,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location' => $this->location
        ]);

        $this->closeModal();
        $this->resetFields();
        session()->flash('success', 'Overtime record started.');
    }
    public function startOn()
    {
        //validate option tracking
        $this->validate([
            'location' => 'required|string|not_in:none',
        ],[
            'location.required' => 'Please, Choose Tracking Option before start record.',
            'location.not_in' => 'Please, Choose Tracking Option before start record.',
        ]);
        //set position
        $position = Geocoder::getAllAddressesForCoordinates($this->latitude, $this->longitude);
        $this->position = $position[0]['formatted_address'];
        $this->currentPosition = $position[2]['address_components'][1]->long_name.', '.$position[2]['address_components'][4]->long_name;
        //Update schedule and create task
        $this->now = Carbon::now();
        $shift = $this->schedule->shift;
        $time_in = Carbon::parse($shift->time_in);
        if ($this->now < $time_in) {
            $status_depart = 'Early';
        }
        elseif ($this->now->diffInMinutes($time_in) < 60) {
            $status_depart = 'Present';
        }
        elseif($this->now->diffInMinutes($time_in) >= 60){
            $status_depart = 'Late';
        }
        $this->schedule->update([
            'started_at' => $this->now,
            'status' => 'Working',
            'status_depart' => $status_depart,
            'position_start' => $this->position,
            'current_position' => $this->currentPosition
        ]);
        $this->detailSchedule = HistorySchedule::create([
            'schedule_id' => $this->schedule->id,
            'status' => 'Work',
            'started_at' => $this->now,
            'location' => $this->location,
            'task' => $this->task,
            'task_desc' => $this->task_desc,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location' => $this->location
        ]);
        $this->task = null;
        $this->closeModal();
        $this->resetFields();
        session()->flash('success', 'Record started.');
    }
    public function closeModal()
    {
        $this->isModal = false;
    }
    public function resetFields()
    {
        $this->task = null;
        $this->type_pause = null;
        $this->task_desc = null;
        $this->checkAutoStop = null;
    }
    public function showPause()
    {
        $this->isModal = 'Pause';
    }
    public function showCreateRequest()
    {
        $this->isModal = 'Create Request';
    }
    public function pauseOn()
    {
        if ($this->type_pause == 'New Task') {
            $this->validate([
                'type_pause' => 'required',
                'task' => 'required'
            ],[
                'type_pause.required' => 'Type is required.',
                'task.required' => 'Task is required.',
            ]);
        }
        else{
            $this->validate([
                'type_pause' => 'required',
                'task' => 'required'
            ],[
                'type_pause.required' => 'Type is required.',
                'task.required' => 'Reason is required.',
            ]);
        }
        if ($this->detailSchedule == null) {
            $this->detailSchedule = $this->schedule->details->where('status','Work')->SortByDesc('id')->first();
        }
        if ($this->type_pause == 'New Task') {
            $status = 'Work';
            $statusSchedule = 'Working';
        }
        else{
            $status = 'Rest';
            $statusSchedule = 'Pause';
        }
        //stoped working detail
        $this->detailSchedule->update(['stoped_at' => Carbon::now()]);

        //create pause detail
        $this->detailSchedule = HistorySchedule::create([
            'schedule_id' => $this->schedule->id,
            'started_at' => Carbon::now(),
            'status' => $status,
            'task' => $this->task,
            'task_desc' => $this->task_desc,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);
        if ($this->checkAutoStop) {
            $this->detailSchedule->update([
                'is_stop_shift' => 1
            ]);
        }
        $timer = $this->schedule->timer;
        $workhour = $this->schedule->workhour + $timer;
        $this->schedule->update([
            'workhour' => $workhour,
            'timer' => 0,
            'status' => $statusSchedule,
        ]);
        $this->closeModal();
        $this->resetFields();
        session()->flash('success', 'Record paused.');
    }
    public function showResume()
    {
        $this->isModal = 'Resume';
    }
    public function resumeOn()
    {
        $this->detailSchedule =$this->schedule->details->SortByDesc('id')->first();
        $position = Geocoder::getAllAddressesForCoordinates($this->latitude, $this->longitude);
        $this->validate([
            'location' => 'required|string|not_in:none',
        ],[
            'location.required' => 'Please, Choose Tracking Option before resuming.',
        ]);
        //update detail pause and stop it
        $this->schedule->update([
            'status' => 'Working',
            'current_position' => $position[2]['address_components'][1]->long_name.', '.$position[2]['address_components'][4]->long_name,

        ]);
        $this->detailSchedule->update([
            'stoped_at' => Carbon::now(),
        ]);

        //create new detail work
        $this->detailSchedule = HistorySchedule::create([
            'schedule_id' => $this->schedule->id,
            'status' => 'Work',
            'started_at' => Carbon::now(),
            'task' => $this->task,
            'task_desc' => $this->task_desc,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location' => $this->location,
            'position' => $position[0]['formatted_address']
        ]);

        $this->closeModal();
        $this->resetFields();
        session()->flash('success', 'Record resumed.');
    }
    public function stopOn()
    {
        //set position
        $position = Geocoder::getAllAddressesForCoordinates($this->latitude, $this->longitude);
        $this->position = $position[0]['formatted_address'];
        $this->currentPosition = $position[3]['address_components'][0]->long_name.', '.$position[3]['address_components'][1]->long_name;
        $time_out = Carbon::parse($this->shift->time_out);
        $time_in = Carbon::parse($this->shift->time_in);
        $time_limit = $time_in->diffInSeconds($time_out);
        
        $timer = $this->schedule->timer;
        $workhour = $this->schedule->workhour + $timer;
        /*
        if ($workhour > $time_limit) {
            $workhour = $time_limit;
        }*/
        //cek if jurnal terisi semua
        $this->validate([
            'detailsSchedule.*.task' => 'required',
        ],[
            'required' => 'Jurnal wajib diisi semua.'
        ]);

        $indexSchedule = Schedule::where('employee_id',$this->user->id)->pluck('id');
        $detailsSchedule = HistorySchedule::whereIn('schedule_id',$indexSchedule)->where('task',null)->get();
        if ($detailsSchedule->count() > count($this->detailsSchedule)) {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Jurnal harus diisi semua.");
        }
        else{
            $i = 0;
            foreach ($detailsSchedule as $detail) {
                $detail->update([
                    'task' => $this->detailsSchedule[$i]['task']
                ]);
                $i++;
            }
        }
        /*
        $detailsSchedule = $this->schedule->details->where('task',null)->sortBy('id');
        if($this->prevSchedule->count() > 0){
            $detailsSchedule = $detailsSchedule->merge($this->prevSchedule->details->where('task',null)->sortBy('id'));
        }
        if ($detailsSchedule->count() > count($this->detailsSchedule)) {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Jurnal harus diisi semua.");
        }
        else{
            return dd($this->detailsSchedule);
            $i = 1;
            foreach ($this->schedule->details->where('status','!=','Rest') as $detail) {
                $detail->update([
                    'task' => $this->detailsSchedule[$i]['task']
                ]);
                $i++;
            }
            if ($this->prevSchedule != null) {
                foreach ($this->prevSchedule->details->where('status','!=','Rest') as $detail) {
                    $detail->update([
                        'task' => $this->detailsSchedule[$i]['task']
                    ]);
                    $i++;
                }
            }
        }*/
        //update task and stop schedule
        $this->now = Carbon::now();
        $this->detailSchedule->update([
            'stoped_at' => $this->now,
        ]);
        $this->schedule->update([
            'stoped_at' => $this->now,
            'workhour' => $workhour,
            'timer' => 0,
            'status' => 'Done',
            'status_stop' => 'Done',
            'note' => $this->note,
            'position_stop' => $this->position,
            'current_position' => $this->currentPosition
        ]);
        $this->closeModal();
        session()->flash('success', 'Record stoped.');
    }
    public function continueOn()
    {
        $this->schedule->update([
            'status_stop' => 'Continue Record',
            'note' => $this->note
        ]);
        $this->closeModal();
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
        $this->user->update(['is_active' => 1]);

        $this->closeModal();
        $this->type = $this->typeRequest = null;
        $this->desc = $this->typeRequest  = null;
        $this->date = $this->dateTo = $this->dateFrom= null;
        $this->time_overtime = null;
        $this->is_cancel_order = null;
        $this->emit('refreshLivewireDatatable');
        session()->flash('message', 'Request successfully added.');
    }
    public function createRequest()
    {
        $cekLeave = ListLeave::where('name','like','%'.$this->type.'%')->first();
        //MEMBUAT VALIDASI
        $now = Carbon::now();
        if($this->type == 'Activation Record'){
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
        if ($issetRequest != null && $this->type != 'Activation Record') {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Can't submit request, duplicate request.");
        }
        elseif ($isSchedule == null && $this->type != 'Overtime' && $cekLeave == null) {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Can't submit request, no schedule found.");
        }
        else{
            //create activated record
            if ($this->type == 'Activation Record') {
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
                $this->user->update(['is_active' => 1]);
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
            session()->flash('message', 'Request successfully added.');
        }
    }
}
