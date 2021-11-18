<?php

namespace App\Http\Livewire\Tables;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Models\ListLeave as Leave;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ListLeave extends LivewireDatatable
{
    use LivewireAlert;
    public function builder()
    {
        return Leave::where('id','!=',null);
    }

    public function columns()
    {
    	return [
	    	Column::name('name')
	    		->label('Leave Name'),
	    	Column::name('desc')
	    		->label('Description'),
	        Column::callback(['is_annual'], function ($is_annual) {
	        	if ($is_annual == 1) {
	        		return 'yes';
	        	}
		        return 'no';
	        })->label('is Annual'),
            Column::callback(['id'], function ($id) {
            	$leave = Leave::find($id);
                return view('livewire.Admin.table_actions.table-action-list-leave', ['id' => $id, 'leave' => $leave]);
            })->label('Action')
    	];
    }
    public function destroy($id)
    {
        $leave = Leave::find($id);
        if ($leave != null) {
            session()->flash('failure', 'Leave '.$leave->name.' deleted successfully.');
            $leave->delete();
            $this->alert('info', 'Leave '.$leave->name.' deleted successfully.', [
                'position' =>  'center', 
                'timer' =>  3000,
                'toast' =>  false,
            ]);
            return redirect()->back();
        }
    }
}