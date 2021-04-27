<?php

namespace App\Http\Livewire\Charts;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Schedule;

class ChartAttendStatistic extends Component
{
	public $dataChart, $now;
    public function render()
    {
    	$this->now = Carbon::now();
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
        return view('livewire.charts.chart-attend-statistic');
    }
}
