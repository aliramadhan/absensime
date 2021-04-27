<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Division;

class DivisionLive extends Component
{
	public $divisions, $isModal, $name, $desc;
    public function render()
    {
    	$this->divisions = Division::all();
        return view('livewire.Admin.division-live');
    }
    public function resetField()
    {
    	$this->name = null;
    	$this->desc = null;
    }
    public function closeModal()
    {
    	$this->isModal = null;
    }
    public function storeDivision()
    {
    	$this->validate([
    		'name' => 'required|unique:divisions',
    		'desc' => 'required'
    	]);
    	Division::create([
    		'name' => $this->name,
    		'desc' => $this->desc
    	]);
      	session()->flash('success', 'new Division added successfully.');
      	$this->resetField();
      	$this->closeModal();
        $this->emit('refreshLivewireDatatable');
    }
    public function deleteDivision($id)
    {
    	$division = Division::find($id);
    	if ($division != null) {
      		session()->flash('failure', 'Division '.$division->name.' deleted successfully.');
    		$division->delete();
    	}
        $this->emit('refreshLivewireDatatable');
    }
}