<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Shift;
use App\Models\Schedule;
use Livewire\WithFileUploads;
use App\Imports\ImportSchedule;
use Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleLive extends Component
{
  use WithFileUploads;
	public $schedules, $schedule, $employees, $shifts, $employee_id, $shift_id,$date, $employee, $shift, $file;
  public $isModal = null;
	protected $rules = [
		'employee_id' => 'required',
		'shift_id' => 'required',
		'date' => 'required|date_format:Y-m-d',
	];
  protected $messages = [
    '*.required' => 'The :attribute cannot be empty.',
  ];

  protected $validationAttributes = [
    'employee_id' => 'Employee',
    'shift_id' => 'Shift',
    'date' => 'Date',
    'file' => 'File Import',
  ];
  public function updated($propertyName)
  {
    $this->validateOnly($propertyName);
  }
  public function render()
  {
    $this->employees = User::where('role','Employee')->orWhere('role','Manager')->get();
    $this->shifts = Shift::orderBy('name','desc')->get();
		$this->schedules = Schedule::orderBy('date','asc')->get();
    return view('livewire.Admin.Schedule.schedule-live');
  }
  public function closeModal()
  {
    $this->isModal = false;
  }
  public function create()
  {
    $this->isModal = 'create';
  }
  public function edit($id)
  {
    $this->schedule = Schedule::findOrFail($id);
    $this->employee_id = $this->schedule->employee_id;
    $this->shift_id = $this->schedule->shift_id;
    $this->date = $this->schedule->date;
    $this->isModal = 'edit';
  }
  public function delete($id)
  {
    $this->schedule = Schedule::findOrFail($id);
    $this->employee_id = $this->schedule->employee_id;
    $this->shift_id = $this->schedule->shift_id;
    $this->isModal = 'delete';
  }
  public function import()
  {
    $this->isModal = 'import';
  }
  public function resetFields()
  {
    $this->employee_id = '';
    $this->shift_id = '';
    $this->date = '';
    $this->employee = null;
    $this->shift = null;
    $this->file = null;
  }
  public function store()
  {
    $this->validate();
    $schedule = Schedule::where('employee_id',$this->employee_id)->where('date',$this->date)->first();
    $this->employee = User::findOrFail($this->employee_id);
    $this->shift = Shift::findOrFail($this->shift_id);
    if ($schedule != null) {
      session()->flash('success', 'Schedule for '.$this->employee->name . ' at '.$this->date.' already exists, add different date.');
      $this->closeModal();
      $this->resetFields();
    }
    else{
      //insert into database
      $schedule = Schedule::create([
        'employee_id' => $this->employee_id,
        'employee_name' => $this->employee->name,
        'shift_id' => $this->shift_id,
        'shift_name' => $this->shift->name,
        'date' => $this->date,
        'status' => 'Not sign in',
      ]);

      session()->flash('success', 'Schedule for '.$this->employee->name . ' at '.$this->date.' added successfully.');
      $this->closeModal();
      $this->resetFields();    
    }
    $this->emit('refreshLivewireDatatable');
  }
  public function update()
  {
    $this->validate();
    $this->shift = Shift::findOrFail($this->shift_id);
    $this->employee = User::findOrFail($this->employee_id);
    $this->schedule->update([
      'shift_id' => $this->shift_id,
      'shift_name' => $this->shift->name,
    ]);

    session()->flash('success', 'Schedule for '.$this->employee->name . ' at '.$this->date.' updated successfully.');
    $this->closeModal();
    $this->resetFields(); 
    $this->emit('refreshLivewireDatatable');
  }
  public function destroy()
  {
    $this->shift = Shift::findOrFail($this->shift_id);
    $this->employee = User::findOrFail($this->employee_id);
    session()->flash('failure', 'Schedule for '.$this->employee->name . ' at '.$this->date.' deleted successfully.');
    $this->schedule->delete();
    $this->closeModal();
    $this->resetFields(); 
    $this->emit('refreshLivewireDatatable');
  }
  public function importSchedule()
  {
    $this->validate([
      'file' => 'required|mimes:xls,xlsx',
    ]);
    $data = Excel::toArray(new Schedule, $this->file)[0];
    for ($i=1; $i < count($data); $i++) { 
      $employee = User::where('code_number',$data[$i][0])->orWhere('name','like','%'.$data[$i][0].'%')->first();
      if ($employee == null) {
        continue;
      }
      for ($k=1; $k < count($data[0]); $k++) { 
        $date = Carbon::parse(Date::excelToDateTimeObject($data[0][$k]));
        if($data[$i][$k] == null){
          continue;
        }
        $shift = Shift::where('name','like','%'.$data[$i][$k].'%')->first();
          $schedule = Schedule::updateOrCreate([
            'employee_id' => $employee->id,
            'employee_name' => $employee->name,
            'date' => $date->format('Y-m-d')
          ],[
            'shift_id' => $shift->id,
            'shift_name' => $shift->name,
          ]);
      }
    }
    session()->flash('success', 'Import Schedule successfully.');
    $this->closeModal();
    $this->resetFields();   
    $this->emit('refreshLivewireDatatable');
  }
}
