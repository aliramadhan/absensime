<table class="table-fixed  flex-initial relative">
  <thead>
   <tr>
     <th  class="text-white bg-gray-700 w-1/2  px-1 py-2 top-0 z-50" rowspan="2" >Name</th>
     <th  class="text-white bg-gray-900 w-1/2  px-1 py-2 top-0 z-40" rowspan="2" >Leader</th>
     <th class="text-white tracking-wider top-0" colspan="{{$now->daysInMonth}}"> {{$now->format('F Y')}}</th>   
     <th class="text-gray-700 bg-gray-700 w-2"></th>
     <th class="text-gray-700 tracking-wide top-0 bg-white" colspan="7">TOTAL</th>      
    </tr>
    <tr >

@for($i = 1; $i <= $now->daysInMonth; $i++)
          @php
          $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
          @endphp
          <th class='hover:bg-yellow-500 duration-300  hover:text-white px-6 py-1 bg-white font-semibold border-b-2 border-gray-200 w-32 border z-10' >
              {{$date->format('d')}}
          </th>
        @endfor
       <th class="text-gray-700 bg-gray-700 w-2"></th>
            <th class="text-white px-2 z-10 w-32">V </th>
            <th class="text-white px-2 z-10 w-32">V(r)</th>
            <th class="text-white px-2 z-10 w-32">L</th>
            <th class="text-white px-2 z-10 w-32">R</th>
            <th class="text-white px-2 z-10 w-32">S</th>
            <th class="text-white px-2 z-10 w-32">P</th>
            <th class="text-white px-2 z-10 w-32">T</th>
            <th class="text-white px-2 z-10 w-32">A</th>
            <th class="text-white px-2 z-10 w-32">?</th>
            <th class="text-white px-2 z-10 w-32 bg-blue-800">Total</th>
    </tr>
    
      
</thead>
<tbody class="border-gray-50 duration-300"  id="scheduleTable">
    @foreach($users as $user)
    @php
      $schedules = App\Models\Schedule::where('employee_id',$user->id)->whereBetween('date',[$now->startOfMonth()->format('Y-m-d'),$now->endOfMonth()->format('Y-m-d')])->get();
      $manager = App\Models\User::where('division',$user->division)->where('roles','Manager')->first();
      if($manager == null){
        $manager = App\Models\User::where('division',$user->division)->where('position','Small Leader')->first();
      }

      $totalA = $schedules->filter(function ($item) {
         return $item->date <= Carbon\Carbon::now() && $item->status != 'Not sign in';
      });


      $totalWFO = 0;
      $totalWFH = 0;
      $totalRemote = 0;
      $totalVr = 0;
    @endphp
    <tr class="text-center">
        <th  class="p-2  truncate text-white bg-gray-700 whitespace-nowrap  border-2 text-left h-auto text-sm font-semibold shadow-xl w-1/2 top-0 z-20  "><div class="truncate md:w-full w-28">{{$user->name}} </div></th>
         <th  class="p-2  truncate text-white bg-gray-900 whitespace-nowrap  border-2 text-left h-auto text-sm font-semibold shadow-xl w-1/2 top-0 z-10  "><div class="truncate md:w-full w-28">@if($manager != null) {{$manager->name}} @endif </div></th>
         @php $no_use=0; @endphp
        @for($i = 1; $i <= $now->daysInMonth; $i++)
          @php
          $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
          $schedule = App\Models\Schedule::where('employee_id',$user->id)->whereDate('date',$date)->first();
          if($schedule != null){
              $detailSchedule = App\Models\HistorySchedule::where('schedule_id',$schedule->id)->where('status','Work')->get();
              $wfo = $detailSchedule->where('location','WFO')->count();
              $wfh = $detailSchedule->where('location','WFH')->count();
              $remote = $detailSchedule->where('location','Remote')->count();
          }
          if($schedule != null){
                $shift = $schedule->shift;
                $time_in = Carbon\Carbon::parse($shift->time_in);
                $time_out = Carbon\Carbon::parse($shift->time_out);
                $time_limit = $time_in->diffInSeconds($time_out);
                $started_at = Carbon\Carbon::parse($schedule->started_at);
              }
              if($schedule != null && $shift->is_night){
                $time_limit = $time_in->diffInSeconds(Carbon\Carbon::parse($time_out)->addDay());
              }
              if($schedule != null){
                  $detailSchedule = App\Models\HistorySchedule::where('schedule_id',$schedule->id)->where('status','Work')->get();
                  $wfo = $detailSchedule->where('location','WFO')->count();
                  $wfh = $detailSchedule->where('location','WFH')->count();
                  $travel = $detailSchedule->where('location','Business Travel')->count();
                  $remote = $detailSchedule->where('location','Remote')->count();
              }
          @endphp
          @if($schedule == null)
                <td class="border border-gray-200 bg-gray-50">-</td>
              @elseif($schedule->status == 'Not sign in')
                @if($date->day >= Carbon\Carbon::now()->day)
                  <td class="border border-gray-200 bg-gray-50">-</td>
                @else
                  <td class="border font-semibold border-gray-200 bg-red-500 text-white" style="background-color:#EF4444;color: white;">A</td>
                @endif
              @elseif($schedule->status_depart == 'Late' && ($started_at->gt($time_in) && $time_in->diffInMinutes($started_at) < 60) && ($schedule->workhour + $schedule->timer) >= $time_limit)
                <td class="border font-semibold border-gray-200 bg-blue-400 text-blue-900" style="color: #6D4ED8;">V</td>
              @elseif($schedule->status_depart == 'Late' && ($started_at->gt($time_in) && $time_in->diffInMinutes($started_at) >= 60) && ($schedule->workhour + $schedule->timer) >= $time_limit)
                <td class="border font-semibold border-gray-200 bg-red-400 text-red-900"  style="color: #EF4444;">V</td>
              @elseif($schedule->status_depart == 'Late')
                <td class="border font-semibold border-gray-200 bg-green-400 text-green-900" style="background-color:#34D399;color: white;">T</td>
              @elseif($schedule->status == 'Done' && $schedule->details->count() < 1)
                <td class="border font-semibold border-gray-200 ">*V</td>
              @elseif($schedule->status == 'Remote' && $schedule->details->count() < 1)
                <td class="border font-semibold border-gray-200 ">*V(R)</td>
              @elseif($schedule->status == 'Done' && ($schedule->workhour + $schedule->timer) < $time_limit)
                <td class="border font-semibold border-gray-200 bg-red-400 text-red-900">?</td>
                @php $no_use++; @endphp
              @elseif($remote > 0)
                <td class="border font-semibold border-gray-200 bg-green-400 text-green-900" style="background-color: blue;color: white">Remote</td>@php $totalRemote++; @endphp
              @elseif($wfh > 0 && $wfo > 0)
                <td >V(r) and V</td>@php $totalWFH++; $totalWFO++; @endphp
              @elseif($wfh > 0)
                <td class="border font-semibold border-gray-200 ">V(r)</td>@php $totalWFH++; @endphp
              @elseif($wfo > 0)
                <td class="border font-semibold border-gray-200 ">V</td>@php $totalWFO++; @endphp
              @elseif($travel > 0)
                <td class="border font-semibold border-gray-200 text-blue-700">V(r)</td>
              @elseif($schedule->status == 'No Record')
                <td class="border font-semibold border-gray-200 bg-red-500 text-white" style="background-color:#EF4444;color: white;">A</td>
              @elseif($schedule->status == 'Permission')
                <td class="border font-semibold border-gray-200 " style="background-color:#FDB717; color: white;">P</td>
              @elseif(in_array($schedule->status,$leaves))
                <td class="bg-yellow-500 text-white font-semibold" style="background-color:#FDB717; color: white;">L</td>
              @else
                <td class="bg-yellow-500 text-white font-semibold" style="background-color:#FDB717; color: white;">{{$schedule->status}}</td>
              @endif  

        @endfor
            <th class="border border-gray-200 text-gray-700 bg-gray-700 w-2"></th>
            <th class="border border-gray-200 w-32">{{$totalWFO}}</th>
            <th class="border border-gray-200 w-32">{{$totalWFH}}</th>
            <th class="border border-gray-200 w-32">{{$schedules->WhereIn('status',$leaves)->count()}}</th>
            <th class="border border-gray-200 w-32">{{$totalRemote}}</th>
            <th class="border border-gray-200 w-32">{{$schedules->where('status','Sick')->count()}}</th> 
            <th class="border border-gray-200 w-32">{{$schedules->where('status','Permission')->count()}}</th> 
            <th class="border border-gray-200 w-32">{{$schedules->where('status_depart','Late')->count()}}</th>          
            <th class="border border-gray-200 w-32">{{$schedules->where('status','No Record')->count()}}</th>
            <th class="border border-gray-200 w-32">{{$no_use}}</th> 
            <th class="border border-gray-200 w-32 bg-gray-700 text-white" >{{$totalA->count()}}</th>
    </tr>
    @endforeach  

    </tbody>
</table>
