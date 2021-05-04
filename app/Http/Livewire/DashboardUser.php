<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Request;
use App\Models\HistorySchedule;
use App\Models\ListLeave;
use Carbon\Carbon;
use Geocoder;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestNotificationMail;

class DashboardUser extends Component
{
	public $user, $now, $schedule, $schedules, $detailSchedule, $task, $task_desc, $isModal, $location = "WFO", $weekSchedules, $type_pause, $shift, $limit_workhour = 28800;
    public $progress = 0, $latitude, $longitude, $position, $currentPosition;
    public $wfo = 0, $wfh = 0, $business_travel = 0, $remote, $unproductive, $time = "", $timeInt = 0, $dateCheck, $monthCheck, $leaves;
    //for Request
    public $type, $desc,$date,$time_overtime, $tasking = false;

    protected $listeners = [
        'set:latitude-longitude' => 'setLatitudeLongitude'
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

    public function render()
    {
        $this->user = auth()->user();
        $this->leaves = ListLeave::all();
        $unproductive = 0;
        $this->user = auth()->user();
        $this->now = Carbon::now();
        $this->schedules = Schedule::where('employee_id',$this->user->id)->whereBetween('date',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
    	$this->schedule = Schedule::where('employee_id',$this->user->id)->where('date',$this->now->format('Y-m-d'))->first();
        if ($this->schedule != null) {
            $this->shift = $this->schedule->shift;
            $time_in = Carbon::parse($this->shift->time_in);
            $time_out = Carbon::parse($this->shift->time_out);
            $this->limit_workhour = $time_in->diffInSeconds($time_out);
            $this->detailSchedule = $this->schedule->details->SortByDesc('id')->first();
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
            'location' => $this->location
    	]);
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
    	
        //update detail pause and stop it
        $this->schedule->update([
    		'status' => 'Working'
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
            'location' => $this->location
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
        //update task and stop schedule
        $this->now = Carbon::now();
        $this->detailSchedule->update([
            'stoped_at' => $this->now,
        ]);
        $timer = $this->schedule->timer;
        $workhour = $this->schedule->workhour + $timer;
    	$this->schedule->update([
    		'stoped_at' => $this->now,
            'workhour' => $workhour,
            'timer' => 0,
    		'status' => 'Done',
            'position_stop' => $this->position,
            'current_position' => $this->currentPosition
    	]);
        $this->closeModal();
        session()->flash('success', 'Record stoped.');
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
        if ($this->user->leave_count < 1 && $cekLeave->is_annual == 1 && !in_array($this->type, ['Overtime','Sick','Remote','Excused'])) {
            $this->closeModal();
            $this->resetFields();
            return session()->flash('failure', "Can't request annual leave, your remaining annual leave is zero.");
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

            $this->closeModal();
            $this->type = null;
            $this->desc = null;
            $this->date = null;
            $this->time_overtime = null;
            session()->flash('message', 'Request successfully added.');
        }
    }
}
