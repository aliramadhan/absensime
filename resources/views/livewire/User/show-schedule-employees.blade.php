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
.scroll::-webkit-scrollbar{
    height: 8px;
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
      <input type="search" id="myInput" onkeyup="searching()"  class="py-2 text-sm text-white bg-gray-50 rounded-md pl-10 focus:outline-none focus:bg-white focus:shadow-xl focus:text-gray-900 focus:w-100 duration-300 border-gray-400" placeholder="Search..." autocomplete="off">
  </div>
  <button class="text-sm focus:outline-none font-semibold bg-blue-400 shadow-md duration-300 hover:bg-blue-700 cursor-pointer text-white  py-2 px-6 rounded-lg" wire:click="exportSchedule()">Export Schedule</button>
</div>
     
   <div class="scroll overflow-x-auto py-4 cursor-pointer">
    <table class="table-fixed border flex-initial">
          <thead>
    	<tr>

        	<th class="headcol text-gray-800 bg-white w-60 absolute border py-1  -ml-1">Employee Name</th>
        	<td class="px-28">a</td>
            @for($i = 1; $i <= $now->daysInMonth; $i++)
                @php
                    $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
                @endphp
                @if($i==$now->daysInMonth)
                <th class='bg-blue-500 text-white px-6 py-1 font-semibold border-b-2 border-gray-400 w-32'>
                    {{$date->format('d')}}
                </th>
                @else
                <th class='hover:bg-yellow-500 hover:text-white px-6 py-1 bg-white font-semibold border-b-2 border-gray-400 w-32'>
                    {{$date->format('d')}}
                </th>
                @endif
            @endfor
        </tr>
     </thead>
      <tbody class="border-gray-50 duration-300" id="myTable">
        @foreach($users as $user)
        <tr >
            <th class="p-2 -ml-1 border-l border-r headcol bg-white w-60 whitespace-nowrap hide-scroll absolute border-t text-left h-auto text-sm font-semibold shadow-xl z-10 text-gray-700">{{$user->name}}</th>
            
            @for($i = 0; $i <= $now->daysInMonth; $i++)
                @php
                    $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
                    $schedule = App\Models\Schedule::where('employee_id',$user->id)->whereDate('date',$date)->first();
                @endphp
                 @if($i==$now->daysInMonth)
                 @if($schedule == null)
                    <td class='px-1 py-2 text-center border border-gray-500 text-xs w-48 bg-blue-200'>
                    <label class="hover:bg-red-300 duration-500 text-white py-0 px-2 rounded-full shadow-md" style="background-image: linear-gradient( to right, #ff416c, #ff4b2b );"></label>
                    </td>
                @elseif($schedule != null && $schedule->status != 'Not sign in')
                    <td class='hover:bg-blue-300 px-1 py-2 text-center font-semibold tracking-wide text-center border border-gray-400 text-xs'>{{$schedule->shift_name}}</td>
                @else
                    <td class='hover:bg-blue-300 px-1 py-2 text-center bg-gray-200 border border-gray-400 font-semibold tracking-wide text-center text-xs '>{{$schedule->shift_name}}</td>
                @endif
                 @else
                @if($schedule == null)
                    <td class='px-1 py-2 text-center border border-gray-500 text-xs w-48'>
                    <label class="hover:bg-red-300 duration-500 bg-red-500 text-white py-0 px-2 rounded-full"></label>
                    </td>
                @elseif($schedule != null && $schedule->status != 'Not sign in')
                    <td class='hover:bg-blue-300 px-1 py-2 text-center font-semibold tracking-wide text-center border border-gray-400 text-xs'>{{$schedule->shift_name}}</td>
                @else
                    <td class='hover:bg-blue-300 px-1 py-2 text-center bg-gray-200 border border-gray-400 font-semibold tracking-wide text-center text-xs '>{{$schedule->shift_name}}</td>
                @endif
                @endif
            @endfor
        </tr>
        @endforeach    
    </tbody>
    </table>
    </div>
     <div class="flex flex-col row-span-1 text-right pointer px-4 capitalize gap-4 bg-white py-4 bg-gray-100 rounded-xl border mt-4">
        <h4 class="min-w-0 text-gray-900 font-semibold text-xl leading-snug text-left " >         
         Legend         
       </h4>
       <div class="flex flex-col gap-2" id="hideTarget">
        
        <h4 class="min-w-0 font-medium text-md leading-snug text-left flex items-center text-gray-700">
          <span class="flex h-3 w-3 mr-2">
            <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3" style="background-image: linear-gradient( to right, #ff416c, #ff4b2b );"></span>
          </span>
          Day Off
        </h4>
        <h4 class="min-w-0 font-medium text-md leading-snug text-left flex items-center text-gray-700">
          <span class="flex h-3 w-3 mr-2">
            <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-blue-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
          </span>
          Today / Day Active
        </h4>
        <h4 class="font-medium text-md flex items-center text-gray-700">           
            <span class="font-bold mr-2 w-3  text-lg">A</span>
            <label>08.00 - 16.00</label>

        </h4>
        <h4 class="font-medium text-md flex items-center text-gray-700">          
            <span class="font-bold mr-2 w-3  text-lg">B</span>          
            <label>09.00 - 17.00</label>
        </h4>

      </div>     
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

const slider = document.querySelector(".scroll");
let isDown = false;
let startX;
let scrollLeft;

slider.addEventListener("mousedown", e => {
  isDown = true;
  slider.classList.add("active");
  startX = e.pageX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;
});
slider.addEventListener("mouseleave", () => {
  isDown = false;
  slider.classList.remove("active");
});
slider.addEventListener("mouseup", () => {
  isDown = false;
  slider.classList.remove("active");
});
slider.addEventListener("mousemove", e => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - slider.offsetLeft;
  const walk = x - startX;
  slider.scrollLeft = scrollLeft - walk;
});
</script>