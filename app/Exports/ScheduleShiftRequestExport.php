<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class ScheduleShiftRequestExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $now;

    function __construct() {
        $this->now = Carbon::now();
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets = [new RequestExport(), new ScheduleExport(), new ShiftExport()];
        return $sheets;
    }
}
