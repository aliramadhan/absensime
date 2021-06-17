<div class="bg-white p-4 rounded-lg overflow-y-auto h-full">
	@php

    	$weekStart = Carbon\Carbon::now()->startOfWeek();
    	$weekStop = Carbon\Carbon::now()->endOfWeek();
    	$listSchedules = App\Models\Schedule::where('employee_id',$user->id)->whereBetween('date',[$weekStart,$weekStop->format('Y-m-d 23:59:59')])->orderBy('date','desc')->get();
    	$idArray = App\Models\Schedule::where('employee_id',$user->id)->whereBetween('date',[$weekStart,$weekStop->format('Y-m-d 23:59:59')])->pluck('id');
    	$taskCount = 0;
    	foreach($listSchedules as $listSchedule){
    		if($listSchedule->details->count() > 0){
    			foreach($listSchedule->details->where('status','Work')->where('task','!=',null)->sortByDesc('created_at')->groupBy('task') as $task){
    				$taskCount++;
    			}
    		}
	    }
	@endphp
	<div class="flex justify-between items-center justify-end">
		<h1 class="text-3xl font-semibold">Task</h1>
		<h1 class="text-xl ">{{$taskCount}}</h1>
	</div>
	
	<div class="relative">
		<div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-yellow-200">  							
			<div style="width: 80%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-500"></div>  							
		</div>
	</div>
	<div class="flex-col flex gap-4">
		@foreach($listSchedules as $listSchedule)
			@if($listSchedule->details->count() > 0)
			@foreach($listSchedule->details->where('task','!=',null)->where('status','Work')->sortByDesc('created_at')->groupBy('task') as $task)
			<div class="flex flex-col gap-1 text-sm border-b capitalize">
				<div class="flex items-center mb-2 font-semibold space-x-2 text-gray-500">
					<h1 class="bg-gray-600 text-white px-3 py-1 rounded-lg lg:text-xs min-w-max">{{Carbon\Carbon::parse($task->first()->created_at)->format('d, D')}}</h1>
					<h1 class="text-gray-800 lg:text-base xl:text-lg truncate">{{$task->first()->task}}</h1>
				</div>
				<p class="leading-tight ">{{$task->first()->task_desc}}</p>
				
					@if($task->first()->stoped_at == null)
						<h1 class="text-right font-semibold text-gray-700 mb-1">
						<i class="fas fa-spinner animate-spin"></i>  On Progress
						</h1>
					@else
					<h1 class="text-right font-semibold text-orange-500 mb-1">
					<i class="fas fa-check-circle"></i> 
					Done
					</h1>
					@endif
				
			</div>
			@endforeach
			@endif
		@endforeach
	</div>
</div>