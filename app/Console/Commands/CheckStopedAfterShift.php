<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Request;
use App\Models\User;
use App\Models\HistoryLock;
use App\Models\Shift;
use App\Models\ListLeave;
use App\Mail\SendNotifUserNonActived;
use App\Mail\NotifStopedAfterShift;
use App\Mail\NotifLateAfterTimeIn;
use App\Notifications\NotifWithSlack;
use Illuminate\Support\Facades\Mail;
use Cache;
use Notification;

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
            if($shift->is_night){
                continue;
                if(Carbon::parse($schedule->date)->day == $now->day){
                    $time_in = Carbon::parse($shift->time_in);
                    $time_out = Carbon::parse($shift->time_out)->addDay();
                }
                elseif(Carbon::parse($schedule->date)->day < $now->day){
                    $time_in = Carbon::parse($shift->time_in)->subDay();
                    $time_out = Carbon::parse($shift->time_out);
                }
            }
            if(($user->position == 'Project Manager' && $user->position == 'Junior PM')){
                $time_out->addHours(4);
            }
            $time_limit = $time_in->diffInSeconds($time_out);
            $historyLock = HistoryLock::where('employee_id',$user->id)->whereDate('created_at',$now)->get();
            $cekLeave = ListLeave::where('name','like','%'.$schedule->status.'%')->first();
            //notif ketika lewat shift

            if ($now->greaterThan($time_out)) {
                if (($schedule->workhour + $schedule->timer) >= $time_limit && ($schedule->status != 'Done' && $schedule->status != 'Not sign in') && ($schedule->status != 'Sick' || $schedule->status != 'Permission' || $cekLeave == null)) {
                    //check if notif has been sent
                    if(Cache::has('sent_notif_stop_' .$user->id)){
                        //do nothing
                    }
                    else{
                        if ($user->slack_id != null) {
                            $message = "Hey <@".$user->slack_id.">, Your recording has exceeded shift, please stop recording";
                            Notification::route('slack', env('SLACK_HOOK'))
                              ->notify(new NotifWithSlack($message, $user->slack_id));
                            $expireTime = Carbon::now()->addHours(8);
                            Cache::put('sent_notif_stop_'.$user->id, Carbon::now(), $expireTime);
                            $this->info("Sending after shift notification email to: {$user->name}!");
                            #send notif to dev
                            Notification::route('slack', env('SLACK_HOOK'))
                          ->notify(new NotifWithSlack("Notif stop untuk ".$user->name, 'U0115H2EE4F'));
                        }
                        //Mail::to($user->email)->send(new NotifStopedAfterShift());
                    }
                }
                //auto stop ketika pause is_stopshift bernilai true
                elseif($schedule->status == 'Pause' && $schedule->details->sortByDesc('id')->first() != null){
                    $detail = $schedule->details->sortByDesc('id')->first();
                    if ($detail->is_stop_shift) {
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
                elseif ($schedule->status == 'Not sign in') {
                    $schedule->update([
                        'status' => 'No Record',
                    ]);
                    $message = "Hey <@".$user->slack_id.">, Kamu hari ini tidak melakukan recording. Kamu dapat melakukan perubahan pencatatan besok silakan klik tautan <https://attendance.pahlawandesignstudio.com/|*ini*>.";
                        Notification::route('slack', env('SLACK_HOOK'))
                            ->notify(new NotifWithSlack($message, $user->slack_id));
                        #send notif to dev
                        Notification::route('slack', env('SLACK_HOOK'))
                      ->notify(new NotifWithSlack("Notif tidak record untuk ".$user->name, 'U0115H2EE4F'));
                }
                /*elseif(($schedule->status != 'Done' && $schedule->status != 'Not sign in') && ($schedule->status_stop == null) && ($time_out->diffInMinutes($now) == 10){
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
                /*
                if($timeSet < 60 && ($schedule->status == 'Not sign in')){
                    //Mail::to($user->email)->send(new NotifLateAfterTimeIn($timeSet));
                    //$this->info("Sending late notification email to: {$user->name}!");
                    if(Cache::has('sent_notif_late_' .$user->id)){
                        //do nothing
                    }
                    else{
                        if ($user->slack_id != null) {
                            $message = "Hey <@".$user->slack_id.">, Kamu terlambat masuk. Ayo segera catat jam masuk. klik tautan <https://attendance.pahlawandesignstudio.com/|*ini*>.";
                            Notification::route('slack', env('SLACK_HOOK'))
                              ->notify(new NotifWithSlack($message, $user->slack_id));
                            $expireTime = Carbon::now()->addHours(8);
                            Cache::put('sent_notif_late_'.$user->id, Carbon::now(), $expireTime);
                            #send notif to dev
                            Notification::route('slack', env('SLACK_HOOK'))
                          ->notify(new NotifWithSlack("Notif telat untuk ".$user->name, 'U0115H2EE4F'));
                        }
                    }
                    
                }*/
                if($timeSet >= 60 && $schedule->status == 'Not sign in'){

                    if(Cache::has('sent_notif_late1_' .$user->id)){
                        //do nothing
                    }
                    else{
                        if ($user->slack_id != null) {
                            $message = "Hey <@".$user->slack_id.">, Kamu sudah melebihi batas 1 jam toleransi terlambat masuk. Ayo segera catat jam masuk. klik tautan <https://attendance.pahlawandesignstudio.com/|*ini*>.";
                            Notification::route('slack', env('SLACK_HOOK'))
                              ->notify(new NotifWithSlack($message, $user->slack_id));
                            $expireTime = Carbon::now()->addHours(8);
                            Cache::put('sent_notif_late1_'.$user->id, Carbon::now(), $expireTime);
                            #send notif to dev
                            Notification::route('slack', env('SLACK_HOOK'))
                          ->notify(new NotifWithSlack("Notif stop 1 jam untuk ".$user->name, 'U0115H2EE4F'));
                        }
                        //Mail::to($user->email)->send(new NotifLateAfterTimeIn($timeSet));
                        $this->info("Sending late notification email to: {$user->name}!");
                    
                    }
                }
                elseif($schedule->status == 'Pause' && $schedule->details->sortByDesc('id')->first() != null){
                    $isRequestChecked = Request::where('employee_id',$user->id)->whereDate('date',$now)->where('type','Activation Record')->orderBy('id','desc')->first();
                    $selisihRequestChecked = 0;
                    if ($isRequestChecked != null && $isRequestChecked->is_checked_half) {
                        $selisihRequestChecked = Carbon::parse($isRequestChecked->created_at)->diffInMinutes($time_in);
                    }
                    $paused_at = Carbon::parse($schedule->details->sortByDesc('id')->first()->started_at);
                    $timeSet = $paused_at->diffInHours($now); #for auto stop
                    $timeSet1 = $paused_at->diffInMinutes($now); #for notif

                    if ($timeSet >= 4 || ($timeSet + $selisihRequestChecked) >= 4) {
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
                    elseif($timeSet1 >= 210){
                        if(Cache::has('sent_notif_maxpause_' .$user->id)){
                            //do nothing
                        }
                        else{
                            if ($user->slack_id != null) {
                                $message = "Hey <@".$user->slack_id.">, Kamu sudah melebihi batas 4 jam toleransi. Ayo segera catat jam masuk. klik tautan <https://attendance.pahlawandesignstudio.com/|*ini*>.";
                                Notification::route('slack', env('SLACK_HOOK'))
                                  ->notify(new NotifWithSlack($message, $user->slack_id));
                                $expireTime = Carbon::now()->addHours(1);
                                Cache::put('sent_notif_maxpause_'.$user->id, Carbon::now(), $expireTime);
                                $this->info("Sending late notification email to: {$user->name}!");
                                #send notif to dev
                                Notification::route('slack', env('SLACK_HOOK'))
                              ->notify(new NotifWithSlack("Notif pause lebih 4 jam untuk ".$user->name, 'U0115H2EE4F'));
                            }
                        
                        }
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
