<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Request;
use App\Models\User;
use App\Models\HistoryLock;
use App\Models\Shift;
use App\Mail\SendNotifUserNonActived;
use App\Mail\NotifStopedAfterShift;
use App\Mail\NotifLateAfterTimeIn;
use Illuminate\Support\Facades\Mail;

class CheckStopedAfterShift extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:stopedaftershift';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if employee not stoping schedule after end of shift.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $schedules = Schedule::whereDate('date',$now)->get();
        $data = [];
        foreach ($schedules as $schedule) {
            $user = User::find($schedule->employee_id);
            $shift = Shift::find($schedule->shift_id);
            $time_in = Carbon::parse($shift->time_in);
            $time_out = Carbon::parse($shift->time_out);
            $this->info($schedule->workhour + $schedule->timer);
            //notif ketika lewat shift
            if ($now->greaterThan($time_out)) {
                $time_limit = $time_in->diffInSeconds($time_out);
                $this->info($time_limit);
                if (($schedule->workhour + $schedule->timer) >= $time_limit && ($schedule->status != 'Done' && $schedule->status != 'Not sign in') && ($time_out->diffInMinutes($now) % 10 == 0)) {
                    Mail::to($user->email)->send(new NotifStopedAfterShift());
                    $this->info("Sending after shift notification email to: {$user->name}!");
                }
                //auto stop ketika pause is_stopshift bernilai true
                elseif($schedule->status == 'Pause' && $schedule->details->sortByDesc('id')->first() != null){
                    $detail = $schedule->details->sortByDesc('id')->first();
                    if ($detail->is_stop_shift) {
                        $user->is_active = 0;
                        $user->save();
                        $history_lock = HistoryLock::create([
                            'employee_id' => $user->id,
                            'date' => $schedule->date,
                            'reason' => 'Forget to stop in the previous shift',
                        ]);
                        $data [] = $user->name;

                        //update task and stop schedule
                        $detailSchedule = $schedule->details->sortByDesc('id')->first();
                        $detailSchedule->update([
                            'stoped_at' => $now,
                        ]);
                        $workhour = 0;
                        foreach ($schedule->details->where('status','Work') as $detail) {
                            $started_at = Carbon::parse($detail->started_at);
                            $stoped_at = Carbon::parse($detail->stoped_at);
                            $workhour += $started_at->diffInSeconds($stoped_at);
                        }
                        $schedule->update([
                            'stoped_at' => $now,
                            'workhour' => $workhour,
                            'timer' => 0,
                            'status' => 'Done',
                        ]);
                    }
                }
                /*elseif(($schedule->status != 'Done' && $schedule->status != 'Overtime' && $schedule->status != 'Not sign in') && ($schedule->status_stop == null) && ($time_out->diffInMinutes($now) == 10){
                    $workhour = 0;
                    foreach ($schedule->details->where('status','Work') as $detail) {
                        $started_at = Carbon::parse($detail->started_at);
                        $stoped_at = Carbon::parse($detail->stoped_at);
                        $workhour += $started_at->diffInSeconds($stoped_at);
                    }
                    if ($workhour >= $time_limit) {
                        $user->is_active = 0;
                        $user->save();
                        $data [] = $user->name;

                        //update task and stop schedule
                        $detailSchedule = $schedule->details->sortByDesc('id')->first();
                        $detailSchedule->update([
                            'stoped_at' => $now,
                        ]);
                        
                        foreach ($schedule->details->where('status','Work') as $detail) {
                            $started_at = Carbon::parse($detail->started_at);
                            $stoped_at = Carbon::parse($detail->stoped_at);
                            $workhour += $started_at->diffInSeconds($stoped_at);
                        }
                        $schedule->update([
                            'stoped_at' => $now,
                            'workhour' => $workhour,
                            'timer' => 0,
                            'status' => 'Done',
                        ]);
                    }
                }*/
                else{
                    //$this->info("not Sending email.");
                }
            }
            elseif ($now->greaterThan($time_in)) {
                $timeSet = $time_in->diffInMinutes($now);
                //send email if 1 hour not yet started
                if($timeSet == 1 && $schedule->status == 'Not sign in'){
                    Mail::to($user->email)->send(new NotifLateAfterTimeIn($timeSet));
                    $this->info("Sending late notification email to: {$user->name}!");
                    $user->is_active = 0;
                    $user->save();
                    $history_lock = HistoryLock::create([
                        'employee_id' => $user->id,
                        'date' => $schedule->date,
                        'reason' => 'Late from the assigned shift',
                    ]);
                }
                elseif($timeSet == 60 && $schedule->status == 'Not sign in'){
                    Mail::to($user->email)->send(new NotifLateAfterTimeIn($timeSet));
                    $this->info("Sending late notification email to: {$user->name}!");
                    $user->is_active = 0;
                    $user->save();
                    $history_lock = HistoryLock::create([
                        'employee_id' => $user->id,
                        'date' => $schedule->date,
                        'reason' => 'Reach the tolerance limit of 1 hour late',
                    ]);
                }
                elseif($schedule->status == 'Pause' && $schedule->details->sortByDesc('id')->first() != null){
                    $isRequestChecked = Request::where('employee_id',$user->id)->whereDate('date',$now)->where('type','Activation Record')->orderBy('id','desc')->first();
                    $selisihRequestChecked = 0;
                    if ($isRequestChecked != null && $isRequestChecked->is_checked_half) {
                        $selisihRequestChecked = Carbon::parse($isRequestChecked->created_at)->diffInMinutes($time_in);
                    }
                    $paused_at = Carbon::parse($schedule->details->sortByDesc('id')->first()->started_at);
                    $timeSet = $paused_at->diffInHours($now);
                    if ($timeSet == 4 || ($timeSet + $selisihRequestChecked) == 4) {
                        $user->is_active = 0;
                        $user->save();
                        $history_lock = HistoryLock::create([
                            'employee_id' => $user->id,
                            'date' => $schedule->date,
                            'reason' => 'Permission to leave work for more than 4 hours',
                        ]);
                        $data [] = $user->name;

                        //update task and stop schedule
                        $detailSchedule = $schedule->details->sortByDesc('id')->first();
                        $detailSchedule->update([
                            'stoped_at' => $now,
                        ]);
                        $workhour = 0;
                        foreach ($schedule->details->where('status','Work') as $detail) {
                            $started_at = Carbon::parse($detail->started_at);
                            $stoped_at = Carbon::parse($detail->stoped_at);
                            $workhour += $started_at->diffInSeconds($stoped_at);
                        }
                        $schedule->update([
                            'stoped_at' => $now,
                            'workhour' => $workhour,
                            'timer' => 0,
                            'status' => 'Done',
                        ]);
                    }
                }
            }
            else{
                //$this->info("belum lewat shift");
            }
        }
        if (count($data) > 0) {
            Mail::to('aliachmadramadhan@gmail.com')->send(new SendNotifUserNonActived($data));
            Mail::to('fajarfaz@gmail.com')->send(new SendNotifUserNonActived($data));
            Mail::to('sigit@24slides.com')->send(new SendNotifUserNonActived($data));
            Mail::to('tikakartika@24slides.com')->send(new SendNotifUserNonActived($data));
            $this->info('mail Sended.');
        }
    }
}
