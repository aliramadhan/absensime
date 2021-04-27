<?php

namespace App\Exports;

use App\Models\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class RequestExport implements FromView, ShouldAutoSize, WithTitle
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
        $request = Request::whereBetween('created_at',[$this->now->startOfMonth()->format('Y-m-d 00:00:00'),$this->now->endOfMonth()->format('Y-m-d 23:59:59')])->get();
        return view('table.request-table-export', [
            'requests' => $request
        ]);
    }

    public function title(): string
    {
        return 'Request ';
    }
}
