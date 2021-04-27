<?php

namespace App\Exports;

use App\Models\Shift;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class ShiftExport implements FromView, ShouldAutoSize, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $now;

    function __construct() {
        $this->now = Carbon::now();
    }
    
    public function view(): View
    {
        return view('table.shift-table-export', [
            'shifts' => Shift::all()
        ]);
    }

    public function title(): string
    {
        return 'Shift ';
    }
}
