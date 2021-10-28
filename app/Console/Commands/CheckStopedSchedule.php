<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\HistoryLock;
use App\Models\User;
use App\Mail\SendNotifUserNonActived;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NotifWithSlack;
use Illuminate\Support\Facades\Notification;

class CheckStopedSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:stopedschedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "CheckStopedSchedule if employee not stoping schedule before end of shift.";

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
            $shift = $schedule->shift;
            $time_in = Carbon::parse($shift->time_in);
            $time_out = Carbon::parse($shift->time_out);
            if($shift->is_night) {
                //do something
            }
            else{
                if ($schedule->status == 'Not sign in') {
                    $schedule->update([
                        'status' => 'No Record',
                    ]);
                }
                elseif ($schedule->status != 'Done') {
                    //update task and stop schedule
                    $detailSchedule = $schedule->details->sortByDesc('id')->first();
                    $workhour = 0;
                    if($detailSchedule != null){
                        $detailSchedule->update([
                            'stoped_at' => $now,
                        ]);
                        foreach ($schedule->details->where('status','Work') as $detail) {
                            $started_at = Carbon::parse($detail->started_at);
                            $stoped_at = Carbon::parse($detail->stoped_at);
                            $workhour += $started_at->diffInSeconds($stoped_at);
                        }
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
        $message = "CheckedStoped Berhasil. \n<https://attendance.pahlawandesignstudio.com/|*click me!*>";
        Notification::route('slack', env('SLACK_HOOK'))
      ->notify(new NotifWithSlack($message, 'U0115H2EE4F'));
        if (count($data) > 0) {
            # code...
            Mail::to('aliachmadramadhan@gmail.com')->send(new SendNotifUserNonActived($data));
            Mail::to('fajarfaz@gmail.com')->send(new SendNotifUserNonActived($data));
            Mail::to('sigit@24slides.com')->send(new SendNotifUserNonActived($data));
            Mail::to('tikakartika@24slides.com')->send(new SendNotifUserNonActived($data));
            $this->info('mail Sended.');
        }

    }
}
