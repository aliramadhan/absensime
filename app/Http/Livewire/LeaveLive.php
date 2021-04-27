<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ListLeave;
class LeaveLive extends Component
{
	public $leaves, $leave, $name, $duration, $is_annual = false, $isModal;
    public function render()
    {
    	$this->leaves = ListLeave::all();
        return view('livewire.Admin.leave-live');
    }
    public function resetField()
    {
    	$this->name = null;
    	$this->duration = null;
    	$this->is_annual = null;
    }
    public function closeModal()
    {
    	$this->isModal = null;
    }
    public function storeLeave()
    {
    	$this->validate([
    		'name' => 'required|unique:list_leaves',
    		'duration' => 'required',
    	]);
    	ListLeave::create([
    		'name' => $this->name,
    		'duration' => $this->duration,
    		'is_annual' => $this->is_annual,
    	]);
      	session()->flash('success', 'new Leave added successfully.');
      	$this->resetField();
      	$this->closeModal();
        $this->emit('refreshLivewireDatatable');
    }
    public function deleteLeave($id)
    {
    	$leave = ListLeave::find($id);
    	if ($leave != null) {
      		session()->flash('failure', 'Leave '.$leave->name.' deleted successfully.');
    		$leave->delete();
    	}
        $this->emit('refreshLivewireDatatable');
    }
}
