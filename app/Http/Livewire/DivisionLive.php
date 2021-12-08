<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Division;
//use Jantinnerezo\LivewireAlert\LivewireAlert;

class DivisionLive extends Component
{
    //use LivewireAlert;
	public $divisions, $isModal, $name, $desc, $showModal = false;
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
    	$this->showModal = null;
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
        $this->alert('info', 'new Division added successfully.', [
            'position' =>  'center', 
            'timer' =>  3000,
            'toast' =>  false, 
            'text' =>  '', 
        ]);
      	$this->resetField();
      	$this->closeModal();
        $this->emit('refreshLivewireDatatable');
    }
    public function deleteDivision($id)
    {
    	$division = Division::find($id);
    	if ($division != null) {
            $this->alert('info', 'Division '.$division->name.' deleted successfully.', [
                'position' =>  'center', 
                'timer' =>  3000,
                'toast' =>  false, 
                'text' =>  '', 
            ]);
    		$division->delete();
    	}
        $this->emit('refreshLivewireDatatable');
    }
}