<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;

class ResetAnnualLeave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:annualleave';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Annual Leave for User.';

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
        $resetDate = Carbon::parse($now->format('Y-10-1'));
        $users = User::where('role','!=','Admin')->where('role','!=','Catering')->get();
        foreach ($users as $user) {
            $joined = Carbon::parse($user->joined_at);
            if ($joined->diffInYears($now) < 1) {
                $leave_count = round($joined->diffInMonths($resetDate)/12*14);
                $user->update(['leave_count' => $leave_count]);
            }
            elseif ($joined->diffInYears($now) >= 1 && $joined->diffInYears($now) <= 3) {
                $user->update(['leave_count' => 14]);
            }
            elseif ($joined->diffInYears($now) > 3) {
                $user->update(['leave_count' => 21]);
            }
        }
        $this->info('Reset Annual Leave success.');
    }
}
