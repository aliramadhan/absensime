<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Shift;

class ShiftLive extends Component
{
	public $name, $time_in, $time_out, $shifts,$shift;
  public $isModal;
  protected $rules = [
    'name' => 'required|string',
    'time_in' => 'required|date_format:H:i',
    'time_out' => 'required|date_format:H:i|after:time_in',
  ];

  public function render()
  {
  	 $this->shifts = Shift::all();
      return view('livewire.Admin.Shift.shift-live');
  }
  public function create()
  {
      $this->isModal = 'create';
  }
  public function delete($id)
  {
  	$this->shift = Shift::findOrFail($id);
    $this->isModal = 'delete';
  }
  public function edit($id)
  {
  	$this->shift = Shift::findOrFail($id);
  	$this->name = $this->shift->name;
  	$this->time_in = $this->shift->time_in;
  	$this->time_out = $this->shift->time_out;
    $this->isModal = 'edit';
  }
  public function resetFields()
  {
  	$this->name = '';
  	$this->time_in = '';
  	$this->time_out = '';
  	$this->shift = null;
  }
  public function closeModal()
  {
      $this->isModal = false;
  }
  public function store()
  {
      //MEMBUAT VALIDASI
      $this->validate();

      $shift = Shift::create([
      	'name' => $this->name,
      	'time_in' => $this->time_in,
      	'time_out' => $this->time_out,
      ]);

      //redirect if success
      session()->flash('success', 'Shift '.$this->name . ' added successfully.');
      $this->closeModal(); //TUTUP MODAL
      $this->resetFields(); //DAN BERSIHKAN FIELD
      $this->emit('refreshLivewireDatatable');
  }
  public function update()
  {
  	$this->shift->update([
      	'name' => $this->name,
      	'time_in' => $this->time_in,
      	'time_out' => $this->time_out,
  	]);

      //redirect if success
      session()->flash('message', 'Shift '.$this->name . ' updated successfully.');
      $this->closeModal(); //TUTUP MODAL
      $this->resetFields(); //DAN BERSIHKAN FIELD
      $this->emit('refreshLivewireDatatable');
  }
  public function destroy()
  {
  	$message =  'Shift '.$this->name . ' deleted successfully.';
  	$this->shift->delete();	
    session()->flash('failure', $message);
    $this->closeModal(); //TUTUP MODAL
    $this->resetFields(); //DAN BERSIHKAN FIELD
    $this->emit('refreshLivewireDatatable');
  }
  public function updated($propertyName)
  {
      $this->validateOnly($propertyName);
  }
}
