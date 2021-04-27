<div wire:poll.1000ms >
	@php
	$now = Carbon\Carbon::now();
	$activities = \App\Models\HistorySchedule::where('task','!=',null)->whereDate('created_at',$now)->groupBy('schedule_id')->orderBy('created_at','desc')->get()->filter(function($item) {
	  if ($item->status == 'Work' || $item->status == 'Overtime') {
	    return $item;
	  }
	})->take(10);
    @endphp
	<div class="flex flex-col gap-4 overflow-auto md:pr-2 row-span-6 mb-5">
		<label class="text-xl ">Employee Activities</label>
		@foreach($activities as $activity)
		<div class="" x-data="{ show: false }">
		<button @click="show = !show" :aria-expanded="show ? 'true' : 'false'" class="grid lg:grid-cols-4 md:grid-cols-1 grid-cols-4 md:items-start items-center text-sm md:gap-0 lg:gap-2 hover:bg-white hover:border-yellow-300 rounded-lg border border-gray-300 duration-200 relative w-full focus:outline-none" >
	  	
			<div class="col-span-1 ml-2 md:mx-auto relative w-max lg:my-2 " >
				<img src="{{ $activity->schedule->user->profile_photo_url }}" class="rounded-full h-12 w-12 object-cover md:mt-1 mx-auto ">
				@if(Cache::has('is_online' . $activity->schedule->user->id))
				<span class="absolute w-3 h-3 rounded-full bg-green-500 border-2 top-0 right-0 "></span>
				<span class="absolute w-3 h-3 rounded-full bg-green-500 border-2 top-0 right-0 animate-ping"></span>
				@else
				<span class="absolute w-3 h-3 rounded-full bg-red-500 border-2 top-0 right-0 "></span>
				<span class="absolute w-3 h-3 rounded-full bg-red-500 border-2 top-0 right-0 animate-ping"></span>
				@endif			
			</div>

			<div class="flex flex-col gap-1 col-span-3 text-left md:text-center lg:text-left relative py-4 px-2 leading-tight mr-2 lg:mt-0 md:-mt-4 transition duration-300 ease-in-out" >
				<label class="font-semibold truncate ">{{$activity->schedule->employee_name}}</label>
				<label x-show="!show" class="cursor-pointer" :class="{'md:mb-2 mb-0 text-justify truncate': !show }" ><span class="bg-white px-2 rounded-full border border-gray-400 mr-1 text-xs ">{{$activity->location}}</span>{{$activity->task}} </label>			
				<label x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90"  class="cursor-pointer" :class="{ 'md:mb-2 mb-0 text-justify break-all ': show, 'md:mb-2 mb-0 text-justify truncate': !show }" ><span class="bg-white px-2 rounded-full border border-gray-400 mr-1 text-xs ">{{$activity->location}}</span>{{$activity->task}} </label>			
			</div>
			<label class="absolute bottom-0 right-0 text-xs bg-orange-500 text-white px-2 rounded-tl-lg rounded-br-lg">Start at {{Carbon\Carbon::parse($activity->started_at)->format('H:i')}}</label>
			</button>
		</div>
		@endforeach
	</div>


    @php
    $now = Carbon\Carbon::now();
    $activities = \App\Models\HistorySchedule::where('status','Work')->orWhere('status','Overtime')->whereDate('created_at',$now)->limit(10)->get();
    //count unproductive and productive time per month
    $productive = $unproductive = 0;
    $detailSchedule = App\Models\HistorySchedule::whereDate('created_at',$now)->get();
    //unproductive
    foreach ($detailSchedule->where('status','Rest') as $detail) {
      if ($detail->stoped_at != null) {
        $startPause = Carbon\Carbon::parse($detail->started_at);
        $stopPause = Carbon\Carbon::parse($detail->stoped_at);
        $unproductive += $startPause->diffInSeconds($stopPause);
      }
      else{
          $startPause = Carbon\Carbon::parse($detail->started_at);
          $unproductive += $startPause->diffInSeconds(Carbon\Carbon::now());
      }
    }
    $unproductive = $unproductive/60/60;

    //productive
    foreach ($detailSchedule->filter(function ($item){ return $item->status == 'Work' || $item->status == 'Overtime'; }) as $work) {
      if ($work->stoped_at != null) {
        $startPause = Carbon\Carbon::parse($work->started_at);
        $stopPause = Carbon\Carbon::parse($work->stoped_at);
        $productive += $startPause->diffInSeconds($stopPause);
      }
      else{
        $startPause = Carbon\Carbon::parse($work->started_at);
        $productive += $startPause->diffInSeconds(Carbon\Carbon::now());
      }
    }
    $productive = number_format($productive/60/60,2);
    @endphp


    <div class="w-full bg-white flex flex-col items-center rounded-xl py-6 border px-2 row-span-2 max-h-64 relative">
      <canvas id="myChart2" width="600" height="450" >
        
      </canvas>

    </div>
    <script type="text/javascript">
	  var unproductive = {!! $unproductive!!};
	  var productive = {!! $productive!!};
	  var ctx = document.getElementById("myChart2");
	  var myChart2 = new Chart(ctx, {
	    type: 'doughnut',
	    data: {
	      labels: ['Productive (Hour)', 'Unproductive (Hour)'],
	      datasets: [{
	        label: '# of Statistic',
	        data: [productive, unproductive],
	        backgroundColor: [
	        'rgba(255, 99, 132, 0.5)',
	        'rgba(54, 162, 235, 0.2)',
	        'rgba(255, 206, 86, 0.2)',
	        'rgba(75, 192, 192, 0.2)'
	        ],
	        borderColor: [
	        'rgba(255,99,132,1)',
	        'rgba(54, 162, 235, 1)',
	        'rgba(255, 206, 86, 1)',
	        'rgba(75, 192, 192, 1)'
	        ],
	        borderWidth: 1,
	        
	      }]
	    },
	    options: {
	      legend: {
	        
	      },
	    //cutoutPercentage: 40,
	    responsive: true,

	   }
	});
	</script>

</div>