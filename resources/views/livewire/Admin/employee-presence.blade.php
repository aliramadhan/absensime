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
 
}

thead th:first-child {
  left: 0;
  z-index: 1;
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

    <div class="md:grid grid-cols-2 flex items-center justify-items-end w-full mb-4 relative flex-col md:flex-row gap-3 justify-items-stretch">
        <form method="GET" action="#" class="relative text-gray-600 focus-within:text-gray-400 flex space-x-2 md:w-auto w-full justify-self-start f">
            <input type="month" @if(request('month') != null) value="{{Carbon\Carbon::parse(request('month'))->format('Y-m')}}" @endif name="month" class="rounded-lg border-gray-400">
            <input type="submit" name="submit" class="rounded-lg bg-blue-400 cursor-pointer hover:bg-blue-600 duration-300 text-white font-semibold px-4 py-2 tracking-wide" value="Filter">
        </form>
        <div class="flex space-x-2 justify-self-end items-center">
        <div class="relative text-gray-600 focus-within:text-gray-400 fixed md:w-auto w-full ">
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
          </button>
      </span>
      <input type="search" id="myInputSearch" onkeyup="searching1()"  class="py-2 text-sm text-white bg-gray-50 rounded-md pl-10 focus:outline-none focus:bg-white focus:shadow-xl focus:text-gray-900 focus:w-100 w-full duration-300 border-gray-400" placeholder="Search..." autocomplete="off">

  </div>
  <button class=" focus:outline-none font-semibold hover:bg-green-400 shadow-md duration-300 border-2 border-green-400 cursor-pointer text-green-500 hover:text-white  py-2 px-6 rounded-lg md:w-auto w-6/12" wire:click="exportSchedule()">Export</button>
  </div>
</div>

<div class="scroll overflow-auto cursor-pointer relative" style="max-height: 24em;">
    <table class="table-fixed border flex-initial relative">
      <thead>
       <tr>

           <th  class="text-white bg-gray-700 w-1/2  px-1 py-2 z-10 top-0 " rowspan="2" >Name</th>
           <th class="z-10 top-0" colspan="{{$now->daysInMonth}}"> Bulan Tahun</th>         
          
        </tr>
        <tr class="bg-white">
             @for($i = 1; $i <= $now->daysInMonth; $i++)
            @php
            $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
            $mytimenow=Carbon\Carbon::now('d');
            @endphp

            @if($i==$mytimenow->format('d'))
          
            <th class='bg-blue-500 hover:bg-blue-700 duration-300 text-white px-6 py-1 font-semibold border-b-2 rounded-t-md w-32 shadow-lg border' style="z-index:-1;">
                {{$date->format('d')}}
            </th>
            @else
            <th class='hover:bg-yellow-500 bg-gray-100 duration-300 rounded-t-md hover:text-white px-6 py-1 bg-white font-semibold border-b-2 border-gray-200 w-32 border '>
                {{$date->format('d')}}
            </th>

            @endif
            @endfor
        </tr>
    </thead>
    <tbody class="border-gray-50 duration-300"  id="scheduleTable">
        @foreach($users as $user)
        <tr class="text-center">
            <th  class="p-2  truncate text-white bg-gray-700 whitespace-nowrap  border-2 text-left h-auto text-sm font-semibold shadow-xl w-1/2 top-0   "><div class="truncate md:w-full w-28">{{$user->name}} </div></th>
            
            
            @for($i = 1; $i <= $now->daysInMonth; $i++)
              @php
              $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
              $schedule = App\Models\Schedule::where('employee_id',$user->id)->whereDate('date',$date)->first();
              @endphp
              @if($schedule == null)
                <td class="bg-red-300">-</td>
              @elseif($schedule->status == 'Not sign in')
                <td >Not sign in</td>
              @elseif($schedule->status_depart == 'Late')
                <td>Late</td>
              @elseif($schedule->status == 'No Record')
                <td class="bg-red-500 text-white">A</td>
              @else
                <td>{{$schedule->status}}</td>
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