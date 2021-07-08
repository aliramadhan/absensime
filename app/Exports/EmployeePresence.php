<?php

namespace App\Exports;

use App\Models\Schedule;
use App\Models\User;
use App\Models\ListLeave;
use App\Models\Shift;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmployeePresence implements FromView, ShouldAutoSize, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $now;

    function __construct($now) {
        $this->now = Carbon::parse($now);
    }
    
    public function view(): View
    {
    	$users = User::where('role','Employee')->orWhere('role','Manager')->orderBy('name','asc')->get();
        $shifts = Shift::all();
        $leaves = ListLeave::all()->pluck('name')->toArray();
        $schedule = Schedule::whereBetween('date',[$this->now->startOfMonth()->format('Y-m-d 00:00:00'),$this->now->endOfMonth()->format('Y-m-d 23:59:59')])->get();
        return view('table.employee-presence', [
            'schedules' => $schedule,
            'users' => $users,
            'now' => $this->now,
            'leaves' => $leaves,
            'shifts' => $shifts
        ]);
    }
    public function title(): string
    {
        return 'Employee Presence ';
    }
}
