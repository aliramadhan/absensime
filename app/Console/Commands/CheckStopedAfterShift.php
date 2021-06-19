<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifStopedAfterShift;

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
        foreach ($schedules as $schedule) {
            $user = User::find($schedule->employee_id);
            $shift = Shift::find($schedule->shift_id);
            $time_in = Carbon::parse($shift->time_in);
            $time_out = Carbon::parse($shift->time_out);
            if ($now->greaterThan($time_out)) {
                $time_limit = $time_in->diffInSeconds($time_out);
                if (($schedule->workhour + $schedule->timer) >= $time_limit && ($schedule->status != 'Done' && $schedule->status != 'Overtime' && $schedule->status != 'Not sign in') && ($time_out->diffInMinutes($now) == 30)) {
                    Mail::to($user->email)->send(new NotifStopedAfterShift());
                    $this->info("Sending email to: {$user->name}!");
                }
                else{
                    $this->info("not Sending email.");
                }
            }
            else{
                $this->info("belum lewat shift");
            }
        }
    }
}
