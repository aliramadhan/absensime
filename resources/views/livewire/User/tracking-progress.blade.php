<div wire:poll.10ms class="pt-3 block lg:w-4/12 md:w-5/12 w-full md:mt-0 mt-2 text-gray-700">
	  @php
	  $start = Carbon\Carbon::parse($schedule->started_at);
	  if($schedule->details->where('status','Work')->sortByDesc('id')->first() != null){
	  $start = Carbon\Carbon::parse($schedule->details->sortByDesc('id')->first()->started_at);
	}
	$timeInt = $start->diffInSeconds(Carbon\Carbon::now());
	$schedule->update(['timer' => $timeInt]);
	$timeInt += $schedule->workhour;
	$seconds = intval($timeInt%60);
	$total_minutes = intval($timeInt/60);
	$minutes = $total_minutes%60;
	$hours = intval($total_minutes/60);
	$time = $hours."h ".$minutes."m";
	@endphp
	<h2 class="text-center relative border-4 border-blue-400 rounded-xl leading-tight" >
	  <span class="md:hidden xl:inline-block -top-4 bg-white relative  xl:px-2 md:text-lg text-base px-3 xl:font-medium lg:text-base ">Tracking Progress</span>
	    <span class="xl:hidden hidden md:inline-block md:px-2  -top-4 bg-white relative px-4 text-lg lg:text-base ">Tracking</span>
	  <div class="px-5 pb-2 md:-mt-4 -mt-6 flex flex-col items-center text-center ">
	    <h2 class="text-2xl font-semibold text-orange-500 mt-3">{{$time}}</h2>
	    <h2 class="text-base ">Status: <span class="font-semibold text-gray-800">{{$schedule->status}}</span></h2>
	  </div>
	</h2>
</div>