<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class AdminDatatableShift extends LivewireDatatable
{
    public $hideable = 'select';
    public function builder()
    {
  		return Shift::orderBy('name','desc');
    }

    public function columns()
    {
    	return [
	    	Column::name('name')
	    		->label('Shift'),
	    	TimeColumn::name('time_in')
	    		->label('Time In')
	    		->format('H:i'),
	    	TimeColumn::name('time_out')
	    		->label('Time Out')
	    		->format('H:i'),
            Column::callback(['id'], function ($id) {
            	$shift = Shift::find($id);
                return view('livewire.Admin.table-actions-shift-admin', [
                	'id' => $id,
                	'shift' => $shift,
                ]);
            })->label('Action')
	    ];
    }
}