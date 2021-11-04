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
      .hover-trigger .hover-target {
       visibility: hidden;
       opacity: 0;
       transition: visibility 0s, opacity 0.5s linear;
     }

     .hover-trigger:hover .hover-target {
      visibility: visible;
      opacity: 1;
    }
    table {
      position: relative;
      border-collapse: collapse;
    }
    thead th {
      position: -webkit-sticky; /* for Safari */
      position: sticky;
      top: 0;
      width: 40px;
      --tw-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    thead th:first-child {
      left: 0;
      z-index: 30;
    }

    tbody th {
      position: -webkit-sticky; /* for Safari */
      position: sticky;
      left: 0;
      background: #FFF;
      border-right: 1px solid #CCC;
      width: 40px;
    }
  </style>


  <div class=" block pb-8 mb-10">
    <div class="grid grid-cols-2 flex items-center justify-items-end  mb-4 relative flex-col md:flex-row gap-3 flex-col-reverse">
     <div class="relative text-gray-600 focus-within:text-gray-500 fixed md:w-auto w-full justify-self-start">
      <span class="absolute inset-y-0 left-0 flex items-center pl-2">
        <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </button>
      </span>
      <input type="search" id="myInputSearch" onkeyup="searching1()"  class="py-2 text-sm bg-gray-50 rounded-md pl-10 focus:outline-none focus:bg-white focus:shadow-xl focus:text-gray-900 focus:w-100 w-full duration-300 border-gray-400" placeholder="Search..." autocomplete="off">
    </div>
    <button class="text-sm focus:outline-none font-semibold bg-blue-400 shadow-md duration-300 hover:bg-blue-700 cursor-pointer text-white  py-2 px-6 rounded-lg md:w-auto w-full" wire:click="exportSchedule()">Export <span class="hidden md:inline">Schedule</span></button>
  </div>

  <div class="scroll overflow-auto cursor-pointer relative" style="max-height: 40em;">
    <table class="table-fixed  flex-initial relative">
      <thead>
       <tr>

         <th  class="text-gray-700 bg-gray-100 w-56 px-1 py-2 top-0 tracking-wider font-semibold">Employee Name</th>

         @for($i = 1; $i <= $now->daysInMonth; $i++)
          @php
          $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
          $mytimenow=Carbon\Carbon::now('d');
          @endphp
          @if($i==$mytimenow->format('d'))
          <th class='bg-blue-500 hover:bg-blue-700 duration-300 text-white px-6 py-2 border-r border-l border-white font-semibold border-b-2  w-80 shadow-lg  z-20 '>
            <div class="flex flex-col text-sm items-center text-center">
              <label class="">{{$date->format('M d')}}</label>
              <label class="w-20 text-gray-50 font-base tracking-wide">{{$date->format('l')}}</label>
            </div>
          </th>
          @else
          <th class='hover:bg-blue-200  bg-gray-100 duration-300  hover:text-gray-500 px-6 py-2 border-r border-l border-white bg-white font-semibold border-b-2 border-gray-200 w-80  z-10 '>
            <div class="flex flex-col text-sm items-center text-center">
              <label class="">{{$date->format('M d')}}</label>
              <label class="w-20 text-indigo-400 font-base tracking-wide">{{$date->format('l')}}</label>
            </div>
          </th>
          @endif
          @endfor
        </tr>
      </thead>
      <tbody class="border-gray-50 duration-300"  id="scheduleTable">
        @foreach($users as $user)
        <tr >
          <th  class="p-2  truncate text-gray-700 bg-gray-100 whitespace-nowrap  border-2 text-left h-auto text-sm font-semibold shadow-xl w-1/2 top-0  z-20 ">
            <div class="truncate md:w-full w-28 flex flex-rows space-x-2  items-center">
             <img src="{{$user->profile_photo_url}}" class="w-8 h-8 rounded-full"> 
             <div class="grid grid-rows-2  w-56 ">
              <label class="truncate "> {{$user->name}} </label>
              <label class="text-gray-500"> {{$user->division}} </label>
            </div>
          </div>
        </th>

        @for($i = 1; $i <= $now->daysInMonth; $i++)
          @php
          $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
          $schedule = App\Models\Schedule::where('employee_id',$user->id)->whereDate('date',$date)->first();
          @endphp
          @if($i==$mytimenow->format('d'))
          @if($schedule == null)
          <td class='px-1 py-2 text-center z-10 shadow-md text-xs w-80 bg-blue-400 border'>
            <!-- <label class="hover:bg-red-300 border-2 border-white duration-500 text-white py-0 px-2 rounded-full shadow-md" style="background-image: linear-gradient( to right, #ff416c, #ff4b2b );"></label> -->
            <label class="text-sm text-white trecking-wide"> Day Off </label>
          </td>
          @elseif($schedule != null && in_array($schedule->status,$leaves))

          <td class='hover:bg-blue-300 text-white px-1 py-2 text-center font-semibold tracking-wide text-center border border-gray-300 text-sm bg-blue-400 hover-trigger relative'>{{$schedule->shift_name}}
            <div class="hover-target absolute duration-300 top-0 bg-blue-500 left-0 text-white text-xs w-full h-full p-1">{{$schedule->status}} </div>
          </td>
          @elseif($schedule != null && $schedule->status == 'Done')
          <td class='hover:bg-green-500 px-1 py-2 text-center border border-white bg-green-400 font-semibold tracking-wide text-center text-sm text-white '>
            <div class="flex"> 
              {{$schedule->shift_name}}
              {{Carbon\Carbon::parse($shift->time_in)->format('H.i')}} - {{Carbon\Carbon::parse($shift->time_out)->format('H.i')}}
            </div>
          </td>
          @elseif($schedule != null && $schedule->status == 'No Record')
          <td class='hover:bg-red-500 px-1 py-2 text-center border border-white bg-red-200 font-semibold tracking-wide text-center text-sm text-gray-700 hover:text-white'>{{$schedule->shift_name}}</td>
          @elseif($schedule != null && $schedule->status != 'Not sign in' && $schedule->status !='Working' && $schedule->status !='Pause')
          <td class='hover:bg-yellow-300 text-white px-1 py-2 text-center font-semibold tracking-wide text-center border border-gray-300 text-sm bg-yellow-400 relative hover-trigger duration-300 '>{{$schedule->shift_name}}
            <div class="hover-target absolute duration-300 top-0 bg-yellow-500 left-0 text-white text-xs w-full h-full p-1">{{$schedule->status}} </div></td>
            @elseif($schedule != null && $schedule->status == 'Pause')
            <td class='hover:bg-blue-300 text-white px-1 py-2 text-center font-semibold tracking-wide text-center border border-gray-300 text-sm bg-blue-400 hover-trigger relative'>Paused
              <div class="hover-target absolute duration-300 top-0 bg-blue-500 left-0 text-white text-sm w-full h-full p-1 py-2">{{$schedule->shift_name}}</div>
            </td>
            @else
            <td class='hover:bg-blue-500 px-1 py-2 text-center border border-white bg-blue-400 font-semibold tracking-wide text-center text-sm text-white '>
              <div class="flex flex-col">
                <label class="text-base"> {{$schedule->shift_name}} </label>
                <label class="font-normal"> Recording </label> <!--  lek durung record muncul e jam shift e -->
              </div>
            </td>
            @endif
            @else
            @if($schedule == null)
            <td class='px-1 py-2 text-center border border-gray-300 text-xs w-80'>
             <label class="text-sm text-red-600 trecking-wide"> Day Off </label>
             <!-- <label class="hover:bg-red-300 duration-500 bg-red-500 text-white py-0 px-2 rounded-full"></label> -->
           </td>
           @elseif($schedule != null && in_array($schedule->status,$leaves) )
           <td class='hover:bg-blue-300 px-1 py-2 text-center font-semibold tracking-wide text-center border border-gray-300 text-sm bg-yellow-500 relative duration-300 text-white'>
            <div class="flex flex-col">
              <label class="text-base">  {{$schedule->shift_name}} </label>
              <label class="font-normal"> {{$schedule->status}}  </label>
            </div>
          </td>
          @elseif($schedule != null && $schedule->status == 'Done')
          <td class='hover:bg-green-500 px-1 py-2 text-center border border-white bg-green-400 font-semibold tracking-wide text-center text-sm text-white '>
            <div class="flex flex-col">
              <label class="text-base"> {{$schedule->shift_name}} </label>
              <label class="font-normal"> {{Carbon\Carbon::parse($schedule->shift->time_in)->format('H.i')}} - {{Carbon\Carbon::parse($schedule->shift->time_out)->format('H.i')}} </label>
            </div>
          </td>
          @elseif($schedule != null && $schedule->status == 'No Record')
          <td class='hover:bg-red-500 px-1 py-2 text-center border border-white bg-red-200 font-semibold tracking-wide text-center text-sm text-gray-700 hover:text-white'>{{$schedule->shift_name}}</td>
          @elseif($schedule != null && $schedule->status != 'Not sign in')
          <td class='hover:bg-blue-300 px-1 py-2 text-center font-semibold tracking-wide text-center border border-gray-300 text-sm'>{{$schedule->shift_name}}</td>
          @else
          <td class='hover:bg-gray-100 px-1 py-2 text-center  border border-gray-300 font-semibold tracking-wide text-center text-sm '>
            <div class="flex flex-col">
              <label class="text-base"> {{$schedule->shift_name}} </label>
              <label class="font-normal"> {{Carbon\Carbon::parse($schedule->shift->time_in)->format('H.i')}} - {{Carbon\Carbon::parse($schedule->shift->time_out)->format('H.i')}} </label>
            </div>
          </td>
          @endif
          @endif
          @endfor
        </tr>
        @endforeach    
      </tbody>
    </table>
  </div>
  <div class="flex flex-col row-span-1 text-right pointer px-4 capitalize  bg-white py-4 bg-gray-100 rounded-xl border mt-4">
    <h4 class=" text-gray-900 font-semibold text-xl leading-snug text-left mb-4" >         
     Legend         
   </h4>
   <div class="grid md:grid-cols-3 grid-cols-1 gap-2">

    <h4 class=" font-medium text-md leading-snug text-left flex items-center text-gray-700">
      <span class="flex h-3 w-3 mr-2">
        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3" style="background-image: linear-gradient( to right, #ff416c, #ff4b2b );"></span>
      </span>
      Day Off 
    </h4>
    <h4 class="font-medium flex-1 text-md leading-snug text-left flex items-center text-gray-700">
      <span class="flex h-3 w-3 mr-2">
        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-blue-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
      </span>
      Today / Day Active
    </h4>
    <h4 class="font-medium flex-1 text-md leading-snug text-left flex items-center text-gray-700">
      <span class="flex h-3 w-3 mr-2">
        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-yellow-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
      </span>
      Permission / Leave
    </h4>
    <h4 class="font-medium flex-1 text-md leading-snug text-left flex items-center text-gray-700">
      <span class="flex h-3 w-3 mr-2">
        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-green-300 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-400"></span>
      </span>
      Present
    </h4>
    <h4 class="font-medium flex-1 text-md leading-snug text-left flex items-center text-gray-700">
      <span class="flex h-3 w-3 mr-2">
        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-200 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-6 bg-red-300"></span>
      </span>
      Absent
    </h4>
    @foreach($shifts as $shift)
    <h4 class="font-medium text-md flex items-center text-gray-700">           
      <span class="font-bold mr-2 w-min-3  text-lg">{{$shift->name}}</span>
      <label>{{Carbon\Carbon::parse($shift->time_in)->format('H.i')}} - {{Carbon\Carbon::parse($shift->time_out)->format('H.i')}}</label>

    </h4>
    @endforeach
  </div>     
</div>

</div>


</div>
</div>
</div>


<script>
  function searching1() {
    var input, filter, tbody, tr, th, i, txtValue;
    input = document.getElementById("myInputSearch");
    filter = input.value.toUpperCase();
    tbody = document.getElementById("scheduleTable");
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
