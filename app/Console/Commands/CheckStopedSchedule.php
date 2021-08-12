<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\User;
use App\Mail\SendNotifUserNonActived;
use Illuminate\Support\Facades\Mail;

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
    protected $description = "Check if employee not stoping schedule before end of shift.";

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
            if ($shift->is_night) {
                //do something
            }
            else{
                if ($schedule->status == 'Not sign in') {
                    $user->is_active = 0;
                    $user->save();
                    $data [] = $user->name;
                    $schedule->update([
                        'status' => 'No Record',
                    ]);
                }
                elseif ($schedule->status != 'Done') {
                    $user->is_active = 0;
                    $user->save();
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
