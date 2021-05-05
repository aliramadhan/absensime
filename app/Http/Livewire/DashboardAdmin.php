<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Division;
use App\Models\Schedule;
use App\Models\HistorySchedule;
use App\Models\User;
use Livewire\WithFileUploads;
use App\Imports\ImportSchedule;
use App\Exports\ShiftExport;
use App\Exports\ScheduleExport;
use App\Exports\RequestExport;
use App\Exports\ScheduleShiftRequestExport;
use Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Http\Request;

class DashboardAdmin extends Component
{
	protected $listeners = ['refreshComponent' => 'render'];
	public $count_attend, $count_notsignin, $count_permit,$now,$schedules,
		$prev_attend, $prev_notsignin, $prev_permit;
	public $dataChart, $isModal, $users, $file, $listManage, $userManage, $divisionName, $divisions;

    public function render()
    {
    	$this->now = Carbon::now();
    	$this->users = User::all();
    	$this->divisions = Division::all();
    	$this->schedules = $schedules = Schedule::whereDate('date',$this->now)->get();
    	//count attend, not sign in, permit
    	$this->count_attend = $schedules->filter(function ($item) {
		    return $item->status == 'Working' || $item->status == 'Done' || $item->status == 'Overtime' ;
		})->count();
		$this->count_notsignin = $schedules->where('status','Not sign in')->count();
		$this->count_permit = $schedules->filter(function ($item) {
		    return $item->status == 'Sick' || $item->status == 'Annual Leave';
		})->count();
		//count previous attend, notsignin, permit
		$prev_schedules = Schedule::whereDate('date',Carbon::now()->subDay())->get();
		$this->prev_attend = $prev_schedules->filter(function ($item) {
		    return $item->status == 'Working' || $item->status == 'Done' || $item->status == 'Overtime' ;
		})->count();
		$this->prev_notsignin = $prev_schedules->where('status','Not sign in')->count();
		$this->prev_permit = $prev_schedules->filter(function ($item) {
		    return $item->status == 'Sick' || $item->status == 'Annual Leave';
		})->count();

		//get data for chart
		$totalMonth = $this->now->month;
		for ($i=1; $i <= $totalMonth; $i++) { 
			$start_year = Carbon::parse($this->now->year.'-'.$i.'-1');
			$scheduleDate = Schedule::whereBetween('date',[$start_year->startOfMonth()->format('Y-m-d'),$start_year->endOfMonth()->format('Y-m-d')])->get();
			if ($i == $totalMonth) {
				$scheduleDate = Schedule::whereBetween('date',[$start_year->startOfMonth()->format('Y-m-d'),$this->now->format('Y-m-d')])->get();
			}
			$this->dataChart ['month'] [] = $start_year->format('F'); 

			if($scheduleDate->count() < 1) {
				$this->dataChart ['attend'] [] = 0; 
				$this->dataChart ['not sign in'] [] = 0; 
			}
			else{
				$this->dataChart ['attend'] [] = $scheduleDate->filter(function ($item) {
				    return $item->status == 'Working' || $item->status == 'Done' || $item->status == 'Overtime' ;
				})->count(); 
				$this->dataChart ['not sign in'] [] = $scheduleDate->where('status','Not sign in')->count();
			}
		}

        return view('livewire.Admin.dashboard-admin');
    }
    public function showImport()
    {
    	$this->isModal = 'Import';
    }
    public function showManageDivision()
    {
    	$this->isModal = 'Division';
    }
	public function closeModal()
	{
		$this->isModal = false;
	}
	public function importSchedule()
	{
		$this->validate([
		  'file' => 'required|mimes:xls,xlsx',
		]);
		$data = Excel::toArray(new Schedule, $this->file)[0];
		for ($i=1; $i < count($data); $i++) { 
		  $employee = User::where('code_number',$data[$i][0])->first();
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
		$this->file = null;   
		$this->emit('refreshLivewireDatatable');
	}
    public function exportShift() 
    {
    	$filename = 'Shift_'.$this->now->format('F Y').'.xlsx';
		session()->flash('success', 'Export Shift successfully.');
        return Excel::download(new ShiftExport, $filename);
    }
    public function exportSchedule() 
    {
    	$filename = 'Schedule_'.$this->now->format('F Y').'.xlsx';
		session()->flash('success', 'Export Schedule successfully.');
        return Excel::download(new ScheduleExport('Admin'), $filename);
    }
    public function exportRequest() 
    {
    	$filename = 'Request_'.$this->now->format('F Y').'.xlsx';
		session()->flash('success', 'Export Request Employee successfully.');
        return Excel::download(new RequestExport, $filename);
    }
    public function exportAll() 
    {
    	$filename = 'AllData_'.$this->now->format('F Y').'.xlsx';
		session()->flash('success', 'Export Alldata successfully.');
        return Excel::download(new ScheduleShiftRequestExport, $filename);
    }
    public function storeDivision()
    {
    	$this->validate([
    		'divisionName' => 'required|unique:divisions,name'
    	]);
		session()->flash('success', 'new Division added successfully.');
		$division = Division::create([
			'name' => $this->divisionName,
			'desc' => ' '
		]);
		$this->divisionName = null;
    }
    public function changeManager($id,$user_id)
    {
    	$user = User::find($user_id);
    	$division = Division::find($id);
    	$cekManager = User::where('roles','Manager')->where('division',$division->name)->get();
    	if ($cekManager->count() >= 1) {
    		foreach ($cekManager as $manager) {
    			$manager->roles = 'Employee';
    			$manager->save();
    		}
    	}
    	$user->roles = 'Manager';
    	$user->save();
		session()->flash('notif_update	', 'updated Manager successfully.');
		$this->emit('refreshComponent');
    }
}
