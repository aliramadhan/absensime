<?php

namespace App\Http\Livewire\Tables;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Models\Division;

class ListDivision extends LivewireDatatable
{
    public function builder()
    {
        return Division::where('id','!=',null);
    }

    public function columns()
    {
    	return [
	    	Column::name('name')
	    		->label('Division Name'),
	    	Column::name('desc')
	    		->label('Description'),
            Column::callback(['id'], function ($id) {
                $division = Division::find($id);
                return view('livewire.Admin.table_actions.table-action-list-division', ['id' => $id, 'division' => $division]);
            })->label('Action')
    	];
    }
}