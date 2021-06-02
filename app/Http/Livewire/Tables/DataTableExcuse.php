<?php

namespace App\Http\Livewire\Tables;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Models\Request;

class DataTableExcuse extends LivewireDatatable
{
    public function builder()
    {
        return Request::where('type','Excuse');
    }

    public function columns()
    {
    	return [
	    	Column::name('employee_name')
	    		->label('Employee Name')->filterable(),
	    	DateColumn::name('date')
	    		->label('Date')->format('d F Y')->filterable(),
	    	Column::name('desc')
	    		->label('Reason Excuse'),
    	];
    }
}