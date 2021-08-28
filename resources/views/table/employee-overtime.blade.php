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
        <th class="text-white px-2 z-10 w-32">Total</th>
        <th class="text-white px-2 z-10 w-32">Total</th>
    </tr>
    
      
</thead>
<tbody class="border-gray-50 duration-300"  id="scheduleTable">
    @foreach($users as $user)
    @php
      $manager = App\Models\User::where('division',$user->division)->where('roles','Manager')->first();
      if($manager == null){
        $manager = App\Models\User::where('division',$user->division)->where('position','Small Leader')->first();
      }

    @endphp
    <tr class="text-center">
        <th  class="p-2  truncate text-white bg-gray-700 whitespace-nowrap  border-2 text-left h-auto text-sm font-semibold shadow-xl w-1/2 top-0 z-20  "><div class="truncate md:w-full w-28">{{$user->name}} </div></th>
         <th  class="p-2  truncate text-white bg-gray-900 whitespace-nowrap  border-2 text-left h-auto text-sm font-semibold shadow-xl w-1/2 top-0 z-10  "><div class="truncate md:w-full w-28">@if($manager != null) {{$manager->name}} @endif </div></th>
        
        @for($i = 1; $i <= $now->daysInMonth; $i++)
          @php
            $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
            $request = App\Models\Request::whereDate('date',$date)->where('type','Overtime')->where('employee_id',$user->id)->where('status','Accept')->get();
            $overtime = 0;
            if($request->count() > 0){
              $created_at = Carbon\Carbon::parse($request->first()->created_at);
              $updated_at = Carbon\Carbon::parse($request->first()->updated_at);
            }
            foreach($request as $item){
              $overtime += $item->time;
            }
            $user->overtime += $overtime;
          @endphp
          <td>
            @if($request->count() > 0)
              @if($created_at < $date)
                Sebelum tanggal
              @elseif($created_at != $updated_at)
                Tanggal diupdate
              @endif
            @endif
            {{$overtime}}
          </td>

        @endfor
      <th class="border border-gray-200 text-gray-700 bg-gray-700 w-2"></th>
      <th class="border border-gray-200 w-32 bg-gray-700 text-white" >{{$user->overtime}}</th>
    </tr>
    @endforeach  

    </tbody>
</table>
