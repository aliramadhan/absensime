<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\HistoryLock;
use App\Models\User;
use App\Mail\SendNotifUserNonActived;
use Illuminate\Support\Facades\Mail;

class CheckWorkingState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:workingstate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "CheckWorkingState if schedule employee state is Working.";

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
        $schedules = Schedule::whereBetween('date',['2021-08-01','2021-10-01'])->get();
        $this->info($schedules);
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
                if ($schedule->status == 'Working') {
                    //update task and stop schedule
                    $detailSchedule = $schedule->details->sortByDesc('id')->first();
                    if($detailSchedule != null){
                        $stoped = Carbon::parse($detailSchedule->started_at);
                        $detailSchedule->update([
                            'stoped_at' => $stoped->format('Y-m-d 23:59:59'),
                        ]);
                        $workhour = 0;
                        foreach ($schedule->details->where('status','Work') as $detail) {
                            $started_at = Carbon::parse($detail->started_at);
                            $stoped_at = Carbon::parse($detail->stoped_at);
                            $workhour += $started_at->diffInSeconds($stoped_at);
                        }
                    }
                    $stoped = Carbon::parse($schedule->started_at);
                    $schedule->update([
                        'stoped_at' => $stoped->format('Y-m-d 23:59:59'),
                        'workhour' => $workhour,
                        'timer' => 0,
                        'status' => 'Done',
                    ]);
                }
            }
            $this->info('success');
        }
    }
}
