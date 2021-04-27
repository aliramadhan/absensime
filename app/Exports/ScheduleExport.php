<?php

namespace App\Exports;

use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ScheduleExport implements FromView, ShouldAutoSize, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $now;

    function __construct($user) {
        $this->now = Carbon::now();
        $this->user = $user;
    }
    
    public function view(): View
    {
        $schedule = Schedule::whereBetween('date',[$this->now->startOfMonth()->format('Y-m-d 00:00:00'),$this->now->endOfMonth()->format('Y-m-d 23:59:59')])->get();
        if ($this->user == 'Admin') {
            return view('table.schedule-table-export', [
                'schedules' => $schedule
            ]);
            # code...
        }
        else{
            $users = User::where('role','Employee')->orWhere('role','Manager')->get();
            return view('table.schedule-table-export-user', [
                'now' => $this->now,
                'users' => $users
            ]);
        }
    }
    public function title(): string
    {
        return 'Schedule ';
    }
}