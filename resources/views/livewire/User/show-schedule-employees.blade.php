<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Employee Schedule') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
  

<style type="text/css">
	.headcol {
  position: absolute; 
  top: auto;
  margin-top: -1px;
}
textarea:focus, input:focus{
    outline: none;
}
*:focus {
    outline: none;
}
.long {
	padding-left: 88px;
  
}
</style>

        
<div class=" block pb-8 mb-10">
    <div class="flex items-center justify-between mb-4 relative">
       <div class="relative text-gray-600 focus-within:text-gray-400 fixed">
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
          </button>
      </span>
      <input type="search" id="myInput" onkeyup="searching()"  class="py-2 text-sm text-white bg-gray-100 rounded-md pl-10 focus:outline-none focus:bg-white focus:shadow-xl focus:text-gray-900 focus:w-100 duration-300 border-gray-400" placeholder="Search..." autocomplete="off">
  </div>
  <button class="text-sm focus:outline-none  bg-blue-400  hover:bg-blue-700 cursor-pointer text-white  py-2 px-6 rounded-lg" wire:click="exportSchedule()">Export Schedule</button>
</div>
     
   <div class="overflow-x-auto py-4">
    <table class="table-fixed border ">
          <thead>
    	<tr>

        	<th class="headcol bg-white w-60 absolute border py-1  -ml-1">Employee Name</th>
        	<td class="px-28">a</td>
            @for($i = 1; $i <= $now->daysInMonth; $i++)
                @php
                    $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
                @endphp
                <th class='hover:bg-blue-400 px-6 py-1 bg-white font-semibold border-b-2 border-gray-400 w-32'>
                    {{$date->format('d')}}
                </th>
            @endfor
        </tr>
     </thead>
      <tbody class="border duration-300" id="myTable">
        @foreach($users as $user)
        <tr >
            <th class=" p-2 -ml-1 border-l border-r headcol bg-white w-60 whitespace-nowrap hide-scroll absolute border-t text-left   h-auto text-sm font-semibold shadow-xl z-10">{{$user->name}}</th>
            
            @for($i = 1; $i <= $now->daysInMonth; $i++)
                @php
                    $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
                    $schedule = App\Models\Schedule::where('employee_id',$user->id)->whereDate('date',$date)->first();
                @endphp
                @if($schedule == null)
                    <td class='px-1 py-2 text-center border border-gray-500 text-xs w-48'>
                    <label class="hover:bg-red-400 bg-red-600 text-white px-1 rounded-lg">Day off</label>
                    </td>
                @elseif($schedule != null && $schedule->status != 'Not sign in')
                    <td class='hover:bg-blue-400 px-1 py-2 text-center font-semibold tracking-wide text-center border border-gray-400  text-xs'>{{$schedule->shift_name}}</td>
                @else
                    <td class='hover:bg-blue-400 px-1 py-2 text-center bg-gray-200 border border-gray-400 font-semibold tracking-wide text-center text-xs '>{{$schedule->shift_name}}</td>
                @endif
            @endfor
        </tr>
        @endforeach    
    </tbody>
    </table>
    </div>
</div>
    
   
</div>
</div>
</div>


<script>
function searching() {
    var input, filter, tbody, tr, th, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    tbody = document.getElementById("myTable");
    tr = tbody.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        th = tr[i].getElementsByTagName("th")[0];
        txtValue = th.textContent || th.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>