<div>
  <div class="bg-white shadow">
  <div class="flex justify-between items-center max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 gap-2">
      <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        Attendance <span class="md:inline-block hidden"> Record </span>
        <div class="overflow-hidden md:hidden block">
          <div class="flex space-x-1 items-center font-semibold text-sm">
             <h2 class="text-white rounded-lg bg-orange-500 px-2">{{auth()->user()->leave_count}}</h2> 
            <label class="text-gray-500">Annual Leave Quota</label>
           
          </div>
        </div>

      </h2>
      @if (session()->has('success'))
      <div class="flex absolute bottom-10 " x-data="{ show: true }" x-show="show" x-transition:leave="transition duration-100 transform ease-in" x-transition:leave-end="opacity-0 scale-90" x-init="setTimeout(() => show = false, 4000)">
        <div class="m-auto">
          <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-lg">
            <div class="flex flex-row">
              <div class="px-2">
                <svg width="24" height="24" viewBox="0 0 1792 1792" fill="#44C997" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1299 813l-422 422q-19 19-45 19t-45-19l-294-294q-19-19-19-45t19-45l102-102q19-19 45-19t45 19l147 147 275-275q19-19 45-19t45 19l102 102q19 19 19 45t-19 45zm141 83q0-148-73-273t-198-198-273-73-273 73-198 198-73 273 73 273 198 198 273 73 273-73 198-198 73-273zm224 0q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z"/>
                </svg>
              </div>
              <div class="ml-2 mr-6">
                <span class="font-semibold">Processing was Successful!</span>
                <span class="block text-gray-500">{{ session('success') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>      
      @endif

      @if (session()->has('failure'))
      <div class="flex absolute bottom-10 " x-data="{ show: true }" x-show.transition="show" x-init="setTimeout(() => show = false, 4000)">
        <div class="m-auto">
          <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-lg">
            <div class="flex flex-row">
              <div class="px-2">
                <i class="fas fa-times-circle text-red-600"></i>
              </div>
              <div class="ml-2 mr-6">
                <span class="font-semibold">Somethings wrong!</span>
                <span class="block text-gray-500">{{ session('failure') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>      

      @endif
      <div class="flex gap-2">
      <button wire:click="showCreateRequest()" class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:px-5 px-4 py-4 md:py-2 text-lg font-semibold tracking-wider text-white md:rounded-xl rounded-full shadow-md focus:outline-none items-center flex-row gap-3 flex"><i class="fas fa-paper-plane" ></i><span class="hidden md:block">Create Request</span></button>
    <!--   <button wire:click="showMandatory()" class="border-blue-500 border-2 hover:bg-blue-500 hover:text-white text-blue-500 duration-200 opacity-80 hover:opacity-100 md:px-5 px-4 py-4 md:py-2 text-lg font-semibold tracking-wider md:rounded-xl rounded-full shadow-md focus:outline-none items-center flex-row gap-3 flex"><i class="fas fa-envelope-open-text"></i><span class="hidden md:block">Mandatory</span></button> -->
      </div>

      <div wire:loading wire:target="showCreateRequest,closeModal,showMandatory" class="overflow-x-hidden overflow-y-hidden fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center">
       <section class="h-full w-full border-box  transition-all duration-500 flex bg-gray-500 opacity-75"    >   
        <div class="text-6xl text-white m-auto text-center">        
         <i class="fas fa-circle-notch animate-spin"></i>
       </div>
     </section>
   </div>


    
  </div>


  </div>
    <div class="md:py-12 py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-8 flex-col flex flex-col-reverse gap-4">

            <div class="lg:flex lg:flex-col md:grid md:grid-cols-2  sm:rounded-lg col-span-2 space-y-4 flex flex-col-reverse hide-scroll">
                
              <div class="overflow-hidden md:mt-0 mt-4">

                <style>
                  [x-cloak] {
                    display: none;
                  }
                </style>

                <div class="antialiased sans-serif bg-gray-100 md:w-full w-11/12 mx-auto md:mx-0 rounded-lg mb-3 md:mb-0">
                  <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                    <div class="container mx-auto  ">


                      <div class="bg-white rounded-lg shadow overflow-hidden p-1" x-on:mouseover="$wire.set('monthCheck', month)">

                        <div class="flex items-center justify-between py-2 px-2">
                          <div>
                            <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800 "></span>
                            <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                          </div>
                          <div class="border rounded-lg px-1" style="padding-top: 2px;">
                            <button 
                            type="button"
                            class="leading-none focus:outline-none  focus:ring focus:border-blue-200 rounded-lg transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center" 
                            :class="{'cursor-not-allowed opacity-25': month == 0 }"
                            :disabled="month == 0 ? true : false"
                            @click="month--; getNoOfDays()">
                            <svg class="h-4 w-4 text-gray-500 inline-flex leading-none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>  
                          </button>
                          <div class="border-r inline-flex h-4"></div>    
                          <button 
                          type="button"
                          class="leading-none focus:outline-none  focus:ring focus:border-blue-200 rounded-lg transition ease-in-out duration-100 inline-flex items-center cursor-pointer hover:bg-gray-200 p-1" 
                          :class="{'cursor-not-allowed opacity-25': month == 11 }"
                          :disabled="month == 11 ? true : false"
                          @click="month++; getNoOfDays()">
                          <svg class="h-4 w-4 text-gray-500 inline-flex leading-none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                          </svg>                    
                        </button>
                      </div>
                    </div>  

                    <div class="-mx-1 -mb-1 hide-scroll">
                      <div class="flex flex-wrap md:text-xs" style="margin-bottom: -40px;">
                        <template x-for="(day, index) in DAYS" :key="index">  
                          <div style="width: 14.1%" class="px-2 py-2 ">
                            <div
                            x-text="day" 
                            class="text-gray-600 text-sm uppercase tracking-wide font-bold text-center mb-10"></div>
                          </div>
                        </template>
                      </div>

                      <div class="flex flex-wrap border-t border-l items-center ml-1 mb-1">
                        <template x-for="blankday in blankdays">
                          <div 
                          style="width: 14.1%;  height: 50px;"
                          class="text-center border-r border-b px-4 pt-2" 
                          ></div>
                        </template> 
                        <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex"> 
                          <div style="width: 14.1%; height: 50px" class="px-1 border-r border-b text-center flex items-center hover-trigger">
                            <div
                            @click="showEventModal(date)"
                            x-text="date"
                            class="inline-flex w-8 h-8 items-center justify-center cursor-pointer text-center leading-none rounded-full transition ease-in-out duration-300 p-2 hover-trigger mx-auto"
                            :class="{'bg-blue-500 text-white': isToday(date) == true, 'hover-trigger text-gray-700 hover:bg-blue-200': isToday(date) == false }"
                            x-on:mouseover="$wire.set('dateCheck', date)"
                            ></div> 
                            @php
                            $monthCheck += 1;
                            $dateText = '2021-'.$monthCheck.'-'.$dateCheck;
                            if($dateCheck != null){
                            $datePicker = Carbon\Carbon::parse($dateText);
                          }
                          else{
                          $datePicker = Carbon\Carbon::now();
                        }
                        $scheduleDatePicker = \App\Models\Schedule::whereDate('date',$datePicker)->where('employee_id',$user->id)->first();
                        @endphp

                        @if($scheduleDatePicker != null)
                        <div class="absolute bg-white border border-gray-100 px-3 py-1 -mt-16 shadow-lg rounded-lg w-max flex-col z-20 text-left hover-target font-semibold bg-gray-700 text-white">{{$scheduleDatePicker->shift_name}}</div>
                        @else 
                        <div class="absolute bg-white border border-gray-100 px-3 py-1 -mt-16 shadow-lg rounded-lg w-max flex-col z-20 text-left hover-target font-semibold bg-red-600 text-white">Day off </div>
                        @endif

                      </div>
                    </template>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <script>
            const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

            function app() {
              return {
                month: '',
                year: '',
                no_of_days: [],
                blankdays: [],
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

                events: [
                {
                  event_date: new Date(2021, 4, 1),
                  event_title: "April Fool's Day",
                  event_theme: 'blue'
                },

                {
                  event_date: new Date(2021, 3, 10),
                  event_title: "Birthday",
                  event_theme: 'red'
                },

                {
                  event_date: new Date(2021, 3, 16),
                  event_title: "Upcoming Event",
                  event_theme: 'green'
                }
                ],
                event_title: '',
                event_date: '',
                event_theme: 'blue',

                themes: [
                {
                  value: "blue",
                  label: "Blue Theme"
                },
                {
                  value: "red",
                  label: "Red Theme"
                },
                {
                  value: "yellow",
                  label: "Yellow Theme"
                },
                {
                  value: "green",
                  label: "Green Theme"
                },
                {
                  value: "purple",
                  label: "Purple Theme"
                }
                ],

                openEventModal: false,

                initDate() {
                  let today = new Date();
                  this.month = today.getMonth();
                  this.year = today.getFullYear();
                  this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                },

                isToday(date) {
                  const today = new Date();
                  const d = new Date(this.year, this.month, date);

                  return today.toDateString() === d.toDateString() ? true : false;
                },

                showEventModal(date) {
            // open the modal
            this.openEventModal = true;
            this.event_date = new Date(this.year, this.month, date).toDateString();
          },

          addEvent() {
            if (this.event_title == '') {
              return;
            }

            this.events.push({
              event_date: this.event_date,
              event_title: this.event_title,
              event_theme: this.event_theme
            });

            console.log(this.events);

            // clear the form data
            this.event_title = '';
            this.event_date = '';
            this.event_theme = 'blue';

            //close the modal
            this.openEventModal = false;
          },

          getNoOfDays() {
            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

            // find where to start calendar day of week
            let dayOfWeek = new Date(this.year, this.month).getDay();
            let blankdaysArray = [];
            for ( var i=1; i <= dayOfWeek; i++) {
              blankdaysArray.push(i);
            }

            let daysArray = [];
            for ( var i=1; i <= daysInMonth; i++) {
              daysArray.push(i);
            }
            
            this.blankdays = blankdaysArray;
            this.no_of_days = daysArray;
          }
        }
      }
    </script>
  </div>

      

    </div>

              <div class="overflow-hidden md:col-span-1 col-span-2 md:hidden lg:block hidden">
                <div class="bg-white p-4 rounded-lg overflow-y-auto h-full flex justify-between border items-center font-semibold">
                  <label class=" text-gray-700">Annual Leave Quota</label>
                  <h2 class="text-white rounded-lg bg-orange-500 px-2">{{auth()->user()->leave_count}}</h2> 
                </div>
              </div>
            <div class="overflow-hidden md:col-span-1 col-span-2 md:w-full w-11/12 mx-auto md:mx-0 rounded-lg">
              <div class="overflow-hidden md:col-span-1 col-span-2 md:block lg:hidden hidden mb-2">
                <div class="bg-white p-4 rounded-lg overflow-y-auto h-full flex justify-between border items-center font-semibold">
                  <label class=" text-gray-700">Annual Leave Quota</label>
                  <h2 class="text-white rounded-lg bg-orange-500 px-2">{{auth()->user()->leave_count}}</h2> 
                </div>
              </div>             
                @include('livewire.User.tasks-components') 
            </div>
               

            </div>
            <div class="overflow-hidden sm:rounded-lg col-span-6 grid md:gap-10 md:space-y-0 space-y-4">
                
                <div class="overflow-hidden sm:rounded-lg h-60 grid xl:grid-cols-8 lg:grid-cols-6 md:grid-cols-6 items-center leading-tight h-full ">
                 <div class=" bg-gradient-to-r from-purple-300 to-blue-400 w-full h-full py-10 px-4 flex-row col-span-2 text-center text-white rounded-xl hidden md:block shdow-lg">   
                    <div class="bg-cover bg-no-repeat bg-center w-32 h-32 mb-6 items-center rounded-full mx-auto" style="background-image: url({{ Auth::user()->profile_photo_url }});">
                    @if($schedule != null)
                    @php
                      $progress = ($schedule->timer + $schedule->workhour)/$limit_workhour * 100;
                    @endphp
                    @endif
                    <progress-ring stroke="4" percent="5" radius="74.5" progress="@if($progress>=100) {{100}} @else {{$progress}} @endif"  class=" left-11 -mt-1 "></progress-ring>  
                  </div>

                    <h2 class="font-semibold text-xl tracking-wide truncate">{{auth()->user()->name}}</h2>                  
                    <h2 class="text-gray-50">{{auth()->user()->division}}</h2> 
                  
                </div>
                <div class="flex-auto col-span-4 xl:col-span-6 h-full md:py-6 pt-8 md:pt-0">
                    <div class="grid grid-rows-4 border-l-0 border-2 bg-white h-full my-auto md:rounded-br-xl md:rounded-tl-xl md:rounded-tr-xl shadow-lg static ">
                    <div class="border-b-2 row-span-1 px-4 flex justify-between items-center relative "> 

                        <div class="py-4 md:py-0 xl:text-4xl justify-between md:mx-0 mx-auto text-3xl font-bold text-gray-500 flex items-center space-x-2 md:-ml-2">
                           <div class="bg-cover bg-no-repeat bg-center w-12 h-12 items-center rounded-full mx-auto inline-flex md:hidden" style="background-image: url({{ Auth::user()->profile_photo_url }});"></div>
                         <label class="border-r pr-2"> @if($schedule != null){{Carbon\Carbon::parse($schedule->date)->format('l')}} @else {{$now->format('l')}} @endif</label>
                          <div class="md:text-base md:text-sm font-semibold text-gray-500 flex flex-col leading-none mt-2 ">
                            <label class="leading-none text-base">@if($schedule != null){{Carbon\Carbon::parse($schedule->date)->format('d F')}} @else {{$now->format('d F')}} @endif</label>
                            <label class="text-blue-500 xl:text-lg text-base md:text-base leading-none ">@if($schedule != null) {{Carbon\Carbon::parse($schedule->date)->format('Y')}} @else {{$now->format('Y')}} @endif</label>
                          </div>
                        </div>
                        <div class="flex items-center gap-4 hidden md:inline-flex">
                        @if($schedule != null)
                        @php
                            $weekStart = Carbon\Carbon::now()->startOfWeek();
                            $weekStop = Carbon\Carbon::now()->endOfWeek();
                            $weekSchedules = App\Models\Schedule::where('employee_id',$user->id)->whereBetween('created_at',[$weekStart,$weekStop->format('Y-m-d 23:59:59')])->get();
                        @endphp
                        <div class="my-auto flex-row">
                            <h2 class="font-semibold text-gray-800 text-sm md:text-base"><i class="far fa-calendar-alt text-orange-500"></i> Shift {{$schedule->shift->name}}</h2>
                            <h4 class="text-sm md:text-base">{{Carbon\Carbon::parse($schedule->shift->time_in)->format('H:i')}} - {{Carbon\Carbon::parse($schedule->shift->time_out)->format('H:i')}}</h4>
                        </div>
                        @endif
                        <a href="#" class=""><i class="fas fa-chevron-right text-xl text-blue-500 hover:text-blue-700"></i>
                          </a>
                         </div>

                         <a href="#" class="flex items-center gap-4 md:hidden block w-screen left-0 absolute -mt-9 z-10 top-0 text-center bg-gradient-to-r from-purple-400 to-blue-500 border text-white py-2 hover:bg-gray-500">
                          @if($schedule != null)
                          @php
                          $weekStart = Carbon\Carbon::now()->startOfWeek();
                          $weekStop = Carbon\Carbon::now()->endOfWeek();
                          $weekSchedules = App\Models\Schedule::where('employee_id',$user->id)->whereBetween('created_at',[$weekStart,$weekStop->format('Y-m-d 23:59:59')])->get();
                          @endphp
                          <div class="space-x-2 flex mx-auto items-center ">
                            <h2 class="font-semibold text-sm md:text-base tracking-wide"><i class="far fa-calendar-alt"></i>  Shift {{$schedule->shift->name}}</h2>
                            <h4 class="text-sm md:text-base tracking-wider">{{Carbon\Carbon::parse($schedule->shift->time_in)->format('H:i')}} - {{Carbon\Carbon::parse($schedule->shift->time_out)->format('H:i')}}</h4>
                           
                          </div>
                          @else
                          <div class="gap-2 flex mx-auto items-center ">
                            <h2 class="font-semibold text-sm md:text-base "> No Schedule Today</h2>                          
                          </div>
                         
                          @endif
                          
                        </a>

                    </div>

                    <div class="row-span-4 px-4 py-3 mt-2 md:mb-0 mb-4">                      
                      <div class="flex md:flex-row flex-col justify-between space-x-0 md:space-x-4 items-center pb-3">
                        <label class="flex space-x-4 items-center md:mb-0 mb-2 flex-shrink-0">
                            <span class="text-gray-700 flex space-x-1 ">Tracking Option</span>
                            <select class="form-select rounded-lg py-1 pr-8 text-sm bg-gray-50 border-gray-400" wire:model="location" @if(($cekRemote) || ($schedule != null && $schedule->status == 'Working'))</select> disabled @endif>
                                @if($cekRemote)<option selected="true">Remote</option>@endif
                                <option value="WFO">Work From Office</option>
                                <option value="WFH">Work From Home</option>
                                <option value="Business Travel">Business Travel</option>
                            </select>
                        </label>

                         <h2 class="text-gray-700 text-center mr-2 truncate w-11/12"><i class="fas fa-map-marker-alt mr-1 text-orange-500"></i> {{ $schedule->current_position ?? "Your Location" }}</h2>
                         </div>
                    <div class="flex justify-between items-center flex-col md:flex-row">
              @if($isModal == 'Pause')
                  @include('livewire.User.create_pause')
              @elseif($isModal == 'Working')
                  @include('livewire.User.create_start')
              @elseif($isModal == 'Resume')
                  @include('livewire.User.create_start')
              @elseif($isModal == 'Create Request')
                  @include('livewire.User.Request.create_request')
              @elseif($isModal == 'Create Mandatory')
                  @include('livewire.User.Request.create_mandatory')
              @elseif($isModal == 'Stop')
                  @include('livewire.User.show_stop')
              @endif
                        @if($schedule != null && $schedule->started_at != null)
                <!-- <br>Started record at : {{ Carbon\Carbon::parse($schedule->started_at)->format('d F Y H:i:s') }} -->
              @if($schedule->status == 'Working')
              <div wire:poll.10ms class="pt-3 block lg:w-4/12 md:w-5/12 w-full md:mt-0 mt-2 text-gray-700">
                @if($schedule != null && $schedule->status != 'Not sign in')
                  @php
                    $workhourDetail = 0;
                    foreach ($schedule->details->where('status','Work') as $listDetail) {
                        $started_atDetail = Carbon\Carbon::parse($listDetail->started_at);
                        $stoped_atDetail = Carbon\Carbon::parse($listDetail->stoped_at);
                        $workhourDetail += $started_atDetail->diffInSeconds($stoped_atDetail);
                    }
                  @endphp
                  @if($workhourDetail >= $limit_workhour && $schedule->status_stop == null && $workhourDetail <= ($limit_workhour + 600))
                    @include('livewire.User.show-confirm-stop')
                  @endif
                @endif
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

              @else
                <div class="pt-3 block md:w-4/12 mt-2 text-gray-700 w-auto">
                  @php
                      $timeInt = $schedule->workhour;
                      $seconds = intval($timeInt%60);
                      $total_minutes = intval($timeInt/60);
                      $minutes = $total_minutes%60;
                      $hours = intval($total_minutes/60);
                      $time = $hours."h ".$minutes."m";
                  @endphp
                 <h2 class="text-center relative border-4 border-blue-400 rounded-xl leading-tight" >
                  <span class=" xl:inline-block inline-block  -top-4 bg-white relative  xl:px-2 text-lg xl:font-medium lg:text-base ">Tracking Progress</span>
                  <span class="xl:hidden hidden md:inline-block md:px-2 -top-4 bg-white relative px-4 text-lg lg:text-base ">Tracking</span>
                  <div class="md:px-5 px-12 pb-2 -mt-6 flex flex-col items-center text-center ">
                    <h2 class="text-2xl font-semibold text-orange-500 mt-3 ">{{$time}}</h2>
                    <h2 class="text-base ">Status: <span class="font-semibold text-gray-800">{{$schedule->status}}</span></h2>
                  </div>
                </h2>
              </div>
              @endif
            @endif
             <div class="bg-white md:p-4 mt-5 md:mt-0 rounded-xl md:w-auto w-full">
              
             
              @if(auth()->user()->is_active != 1)
               <button  class="bg-gradient-to-r from-green-400 to-purple-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 text-lg font-semibold tracking-wider px-6  text-white rounded-xl shadow-md focus:outline-none w-full"><i class="far fa-smile-beam"></i> Your account can't start record for several reason</button>   
              @elseif($schedule != null && ($schedule->status == 'Working'))
              <div class="grid grid-cols-2 items-center gap-4">
                <button wire:click="showPause()" class="bg-gradient-to-r from-green-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6  text-white rounded-xl shadow-md focus:outline-none "><i class="fas fa-pause-circle"></i><br>Pause</button>
                <button wire:click="showStop()" class=" bg-red-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6  text-white rounded-xl shadow-md focus:outline-none "><i class="far fa-stop-circle"></i><br> Stop</button>
               </div>
              @elseif($schedule != null && $schedule->status == 'Pause')

              <button @if($tasking) wire:click="showResume()" @else wire:click="resumeOn()" @endif class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6  text-white rounded-xl shadow-md focus:outline-none w-full"><i class="fas fa-history"></i> Resume</button>
              <label class="flex items-center mt-3 w-auto">
                <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600 rounded-md" wire:model="tasking" @if($tasking) wire:click="$set('tasking',false)"  @else wire:click="$set('tasking',true)" @endif><span class="ml-2 text-gray-700"> Writing assignments ?</span>
              </label>
              @elseif($schedule != null && $schedule->status == 'Not sign in' && auth()->user()->is_active == 1 )
              <button @if($tasking) wire:click="showStart()" @else wire:click="startOn()" @endif class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6 w-full text-white rounded-xl shadow-md focus:outline-none "><i class="far fa-clock"></i> Start Record</button>             
              <label class="flex items-center mt-3 w-auto">
                <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600 rounded-md"  wire:model="tasking" @if($tasking) wire:click="$set('tasking',false)"  @else wire:click="$set('tasking',true)" @endif><span class="ml-2 text-gray-700"> Writing assignments ?     </span>
              </label>
              @elseif($schedule != null && $schedule->status == 'Not sign in' && auth()->user()->is_active == 1)
              <button class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6 w-full text-white rounded-xl shadow-md focus:outline-none "><i class="far fa-clock"></i> Not ready to Record</button>             
              <label class="flex items-center mt-3 w-auto">
                Ready to start at : {{Carbon\Carbon::parse($schedule->shift->time_in)->subMinute(10)->format('H:i')}} 
              </label>
              @elseif($schedule != null && ($schedule->status == 'Done'))
               <button  class="bg-gradient-to-r from-green-400 to-purple-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 text-lg font-semibold tracking-wider px-6  text-white rounded-xl shadow-md focus:outline-none w-full"><i class="far fa-smile-beam"></i> Today's recording is complete</button>     
              @elseif($schedule != null && $schedule->status != 'Done' && $schedule->status != 'Rest' && $schedule->status != 'Working' && $schedule->status != 'Not sign in')

                <button class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6 w-full text-white rounded-xl shadow-md focus:outline-none "><i class="far fa-clock"></i> Today is {{$schedule->status}}</button>    
              @else
               <button  class="border-4 border-blue-600 duration-200 opacity-80 hover:opacity-100 py-4 text-xl font-bold tracking-wider px-6  text-gray-600 rounded-xl shadow-md focus:outline-none w-full"><i class="far fa-smile-beam"></i> No Schedule Today!</button>             
              @endif              
            
            
              <div wire:loading wire:target="showPause,showStop,showResume,showStart,showOvertime" class="overflow-x-hidden overflow-y-hidden fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center">
                 <section class="h-full w-full border-box  transition-all duration-500 flex bg-gray-500 opacity-75"    >   
                  <div class="text-6xl text-white m-auto text-center">        
                   <i class="fas fa-circle-notch animate-spin"></i>
                 </div>
               </section>
             </div>   


            </div>
          </div>
            </div>

                     

                    </div>
                    
                </div>
                 </div>
                 
            <div wire:poll.10ms class="absolute">
              @if($schedule != null)
                @php
                  $request_late = App\Models\Request::whereDate('date',$now)->where('employee_id',$user->id)->where('type','Excused')->where('status','Accept')->first();
                  $request_remote= App\Models\Request::whereDate('date',$now)->where('employee_id',$user->id)->where('type','Remote')->where('status','Accept')->first();
                @endphp
                @if($request_late != null)
                  @php $schedule->update(['status_depart' => 'Present']); @endphp
                @endif
                @if($request_remote != null)
                  @php $location = 'Remote'; @endphp
                @endif
                @php
                $start = Carbon\Carbon::parse($schedule->started_at);
                if($schedule->details->where('status','Work')->sortByDesc('id')->first() != null){
                  $start = Carbon\Carbon::parse($schedule->details->sortByDesc('id')->first()->started_at);
                  $timeInt = $start->diffInSeconds(Carbon\Carbon::now());
                  if($schedule->details->where('status','Work')->sortByDesc('id')->first()->stoped_at != null){
                    $timeInt = $start->diffInSeconds(Carbon\Carbon::parse($schedule->details->where('status','Work')->sortByDesc('id')->first()->stoped_at));
                  }
                }
                $time_out = Carbon\Carbon::parse($schedule->shift->time_out);
                if($schedule->stoped_at == null){
                  $schedule->update(['timer' => $timeInt]);
                }
                else{
                  $schedule->update(['timer' => 0]);
                }
                $timeInt = $schedule->workhour + $schedule->timer;
                $seconds = intval($timeInt%60);
                $total_minutes = intval($timeInt/60);
                $minutes = $total_minutes%60;
                $hours = intval($total_minutes/60);
                $time = $hours."h ".$minutes."m";
                @endphp
              @if($now->gte($time_out) && $time_out->diffInMinutes($now) <= 5)
                
              @endif
              @endif
            </div>
                    
                    <div class="bg-white overflow-hidden border-1 sm:rounded-2xl p-4 md:w-full w-11/12 md:mx-0 mx-auto rounded-lg shadow-lg border md:border-4 border-white">
                      <div class="grid md:grid-cols-6 items-center gap-2">
                        <div class="md:col-span-3 col-span-2 flex flex-row justify-between md:text-xl text-sm xl:text-2xl text-gray-800 leading-none font-semibold md:border-0 border-b pb-2 ">
                          <div class="flex flex-col">
                          <h2 class="text-3xl leading-none ">Detail</h2>
                          @if($schedule != null)
                          <h2 class="md:text-sm xl:text-lg text-gray-500 font-base">Start Tracking at <span class="text-gray-700 md:text-base text-xs">
                            @if($schedule->started_at != null)<span class="md:hidden block mt-1"></span> 
                           {{ Carbon\Carbon::parse($schedule->started_at)->format('H:i, d F Y') }}@endif</span></h2>@endif
                          </div>
                          <div class="block md:hidden flex flex-col md:text-sm text-xs xl:text-base border-2 rounded-xl px-2 py-1 text-white leading-none font-semibold bg-gradient-to-r from-green-400 to-blue-500 shadow-lg">
                            <div class="font-xs leading-tight flex justify-between flex-auto space-x-2"><label>WFH</label><label class="text-gray-50">{{$wfh}}</label></div>
                            <div class="font-xs leading-tight flex justify-between flex-auto space-x-2"><label>WFO</label><label class="text-gray-50">{{$wfo}}</label></div>
                            <div class="font-xs leading-tight flex justify-between flex-auto space-x-2"><label>BT</label><label class="text-right flex-auto text-gray-50">{{$business_travel}}</label></div>
                          </div>
                        </div>
                        <div class="flex flex-col text-xl text-gray-800 leading-none font-semibold md:text-left text-center shadow-lg py-2 px-2 border-2 rounded-lg border-red-300">
                         <h2 class="text-base leading-none">{{$unproductive}}</h2>
                         <h2 class="md:text-sm bg-red xl:text-md leading-none text-sm text-gray-500 font-base">Unproductive</h2>
                       </div>
                          <div class="flex flex-col text-xl text-gray-800 leading-none font-semibold md:text-left text-center shadow-lg py-2 px-2 border-2 rounded-lg border-green-300">
                         <h2 class="text-base leading-none">{{$time}}</h2>
                         <h2 class="md:text-sm bg-red xl:text-md leading-none text-sm text-gray-500 font-base">Productive</h2>
                       </div>
                      <div class="hidden md:block flex flex-col md:text-xs xl:text-sm  rounded-xl px-3 py-2 text-white  leading-none font-semibold bg-gradient-to-r from-green-400 to-blue-500 shadow-lg" style="">
                        <h2 class="font-xs leading-tight flex justify-between flex-auto">WFH<span class="text-gray-50">{{$wfh}}</span></h2>
                        <h2 class="font-xs leading-tight flex justify-between flex-auto">WFO<span class="text-gray-50">{{$wfo}}</span></h2>
                        <h2 class="font-xs leading-tight flex justify-between flex-auto">BT<span class="text-gray-50">{{$business_travel}}</span></h2>
                      </div>
                     </div>
                 
                    <div class="relative pt-1  mt-12">
                      <div class="flex mb-2 items-center justify-between">
                        <div>
                           @if($schedule != null && $schedule->status == 'Pause')
                           <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-yellow-600 bg-yellow-200"><i class="fas fa-pause animate-pulse" ></i>
                            Task is paused 
                          </span>
                          @elseif($schedule != null && $schedule->status == 'Working')
                          <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200">
                           <i class="fas fa-spinner animate-spin"></i> Task in progress 
                           </span>
                          @elseif($schedule != null && $schedule->status == 'Not sign in')
                          <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                           <i class="far fa-clock mr-2"></i>Task ready to start
                           </span>
                           @elseif($schedule != null && $schedule->status == 'Done')

                           <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200"><i class="fas fa-check  animate-bounce"></i>
                           Tracking is Done 
                         </span> 
                         <span class="text-sm text-gray-500 font-semibold">
                          <span class="text-gray-700">@if($schedule != null)
                            <span class="hidden md:inline-block">Stop Tracking at </span> 
                            <span class="md:hidden inline-block"><i class="far fa-stop-circle"></i></span>
                            <span class="text-orange-500">{{ Carbon\Carbon::parse($schedule->stoped_at)->format('H:i') }}@endif</span></span>
                         </span>   
                         @else

                         @endif
                       </div>
                        <div class="text-right">
                          <span class="text-xs font-semibold inline-block text-yellow-600">
                            @if($timeInt/$limit_workhour <= 1)
                            {{$nf=number_format((($timeInt/$limit_workhour)*100),2,",",".")}}%
                            @else
                            100%
                            @endif
                          </span>
                        </div>
                      </div>
                      <div class=" h-3 mb-4 text-xs flex rounded-xl bg-gray-200">
                        @if($schedule != null)

                        @foreach($schedule->details as $detail)
                          @php
                            $time_start = Carbon\Carbon::parse($detail->started_at);
                            $time_stop = Carbon\Carbon::parse($detail->stoped_at);
                            $time_detail = $time_start->diffInSeconds($time_stop);

                          @endphp
                      <div style="width: {{($time_detail/$limit_workhour)*100}}%" class="animate transform transition-transform hover:-translate-y-2 duration-1000 cursor-pointer shadow-none flex flex-col text-center whitespace-nowrap text-gray-800 justify-center @if($detail->status == 'Rest') bg-red-500 @elseif($detail->status == 'Work') bg-blue-500 @else bg-yellow-500 @endif hover-trigger @if($loop->iteration == 1) rounded-l-lg @elseif($time_detail>$limit_workhour) rounded-r-lg @endif @if($detail->stoped_at ==null) animate-pulse  @endif "> 


                            <div class="absolute bg-white border border-gray-100 px-4 py-2 -mt-20 shadow-md rounded-lg w-max flex-col z-50 text-left hover-target ">  
                             <h2 class="text-base font-semibold">

                               {{$detail->task}}

                             </h2>    
                               <div class="flex">    
                                  <h2 class="font-semibold border-r pr-1 text-gray-500">           
                                   <i class=" far fa-clock"> </i> {{$time_start->format('H:i')}} - {{$time_stop->format('H:i')}}
                                  </h2>  
                                  <h2 class="pl-1"> 
                                    {{$detail->location}}
                                 </h2>   
                               </div>   
                           </div>
                         </div>


                        @endforeach
                        @endif

                      </div> 
                    </div>
          </div>
                  @php
                    $startWeek = Carbon\Carbon::now()->startOfWeek();
                    $endWeek = Carbon\Carbon::now()->endOfWeek();
                    $weekly_work = \App\Models\Schedule::where('employee_id',$user->id)->whereBetween('date',[$startWeek->format('Y-m-d'),$endWeek->format('Y-m-d')]);
                    $seconds = intval($weekly_work->sum(\DB::raw('workhour + timer'))%60);
                    $total_minutes = intval($weekly_work->sum(\DB::raw('workhour + timer'))/60);
                    $minutes = $total_minutes%60;
                    $hours = intval($total_minutes/60);
                    $time_weekly = $hours."h ".$minutes."m";
                  @endphp
                    <div class="bg-white overflow-hidden rounded-lg p-4 flex flex-col border md:w-full w-11/12 mx-auto md:mx-0">
                      <div class="grid md:grid-cols-6  grid-rows-2 items-center gap-2">
                        <div class="col-span-3 flex flex-col text-2xl text-gray-800 leading-none font-semibold">
                          <h2 class="text-3xl leading-none">Recent</h2>
                          <h2 class="text-sm md:text-lg text-gray-500 font-base ">You Have <span class="text-orange-500">{{$user->schedules->where('status','!=','Not sign in')->count()}}</span> Activities on this month</h2>
                        </div>
                        <div class="flex flex-col text-xl text-left text-gray-800 leading-none font-semibold">
                         <h2 >{{$weekly_work->where('status','!=','Not sign in')->count()}}</h2>
                         <h2 class="text-sm md:text-base border-t-2 border-gray-500 text-gray-500 font-base">Attend</h2>
                       </div>
                        <div class="flex flex-col text-xl text-left text-gray-800 leading-none font-semibold">
                         <h2 >{{$weekly_work->where('status','Not sign in')->count()}}</h2>
                         <h2 class="text-sm md:text-base border-t-2 border-gray-500 text-gray-500 font-base">Not Present</h2>
                       </div>
                       <div class="flex flex-col text-sm text-center text-gray-800 items-center relative weekly-trigger cursor-pointer">
                        <h2 class="text-lg text-orange-500 font-base font-semibold leading-none">
                          {{$time_weekly}}
                        </h2>
                        <h2 class="text-white bg-orange-500 py-1 rounded-lg w-full md:w-10/12 md:text-base text-xs">Weekly Hour</h2>

                        <div class="flex flex-col text-sm text-center text-gray-800 items-center absolute weekly-target bg-white w-full rounded-lg shadow-lg">
                          <h2 class="text-lg text-blue-500 font-base font-semibold leading-none">
                            {{$user->target_weekly}}
                          </h2>
                          <h2 class="text-white bg-blue-500 py-1 rounded-lg w-full md:text-base text-xs">Weekly Target</h2>
                        </div>
                        <style>
                        .weekly-trigger .weekly-target {
                         visibility: hidden;
                         opacity: 0;
                         transition: visibility 0s, opacity 0.5s linear;
                        }

                        .weekly-trigger:hover .weekly-target {
                         visibility: visible;
                         opacity: 1;

                        }
                      </style>

                      </div>
                      </div>
                      <div class="scroll hide-scroll flex flex-row grid grid-flow-col auto-cols-max items-start font-semibold md:mt-0 mt-4 gap-3 overflow-x-auto cursor-pointer">
                        @foreach($schedules as $scheduleUser)
                        @php
                          $seconds = intval(($scheduleUser->workhour + $scheduleUser->timer)%60);
                          $total_minutes = intval(($scheduleUser->workhour + $scheduleUser->timer)/60);
                          $minutes = $total_minutes%60;
                          $hours = intval($total_minutes/60);
                          $timeMonthly = $hours."h ".$minutes."m";
                        @endphp
                      <div class="flex flex-col px-4 py-3 text-center w-36 h-36 items-center hover:bg-gray-200 duration-200 cursor-pointer rounded-bl-3xl rounded-tr-3xl justify-between border-2 border-gray-400 " >
                        <div class=" flex-col flex mb-2 ">
                          <label class="font-bold leading-none text-3xl text-gray-700">{{Carbon\Carbon::parse($scheduleUser->date)->format('d')}}</label>
                          <label class="text-sm font-base text-white leading-none bg-orange-500 px-2 py-1 rounded-md">{{Carbon\Carbon::parse($scheduleUser->date)->format('l')}}</label>
                        </div>
                        @if($scheduleUser->status == 'Working' || $scheduleUser->status == 'Done')
                      
                        <div class="text-gray-500 text-xs ">{{$scheduleUser->details->first()->location}}</div>
                        <div class="text-gray-700 text-xs ">{{$timeMonthly}}</div>
                        <!-- <div class="mb-6 text-xs">{{$scheduleUser->details->first()->note}}</div> -->
                         <div class="text-blue-500 flex leading-tight items-center text-sm bg-white w-full justify-center py-1 rounded-lg">
                          <i class="fas fa-check-circle mr-1"></i>Attend
                        </div>
                        @else
                        <div class="text-red-500 flex leading-tight items-center text-sm bg-white w-full justify-center py-1 rounded-lg">
                          <i class="fas fa-times-circle mr-1"></i>{{$scheduleUser->status}}
                        </div>
                        @endif
                      </div>
                      @endforeach
                      </div>
                  </div>
                 

            </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        class ProgressRing extends HTMLElement {
          constructor() {
            super();
            const stroke = this.getAttribute('stroke');
            const radius = this.getAttribute('radius');
            const normalizedRadius = radius - stroke * 2;
            this._circumference = normalizedRadius * 2 * Math.PI;

            this._root = this.attachShadow({mode: 'open'});
            this._root.innerHTML = `
            <svg
            height="${radius * 2}"
            width="${radius * 2}"
            class="svg-cus"
            >
            <circle
            stroke="white"
            stroke-dasharray="${this._circumference} ${this._circumference}"
            style="stroke-dashoffset:${this._circumference}"
            stroke-width="${stroke}"
            fill="transparent"
            r="${normalizedRadius}"
            cx="${radius}"
            cy="${radius}"
            />
            </svg>

            <style>
            circle {
              transition: stroke-dashoffset 0.35s;
              transform: rotate(-90deg);
              transform-origin: 50% 50%;
          }
          .svg-cus{
             border: 1px solid white;
            border-radius: 100%;
                margin: -11px;
          }
          </style>
          `;
      }


      setProgress(percent) {
        const offset = this._circumference - (percent / 100 * this._circumference);
        const circle = this._root.querySelector('circle');
        circle.style.strokeDashoffset = offset; 
    }

    static get observedAttributes() {
        return ['progress'];
    }

    attributeChangedCallback(name, oldValue, newValue) {
       
        if (name === 'progress') {
          this.setProgress(newValue);
      }
  }
}

window.customElements.define('progress-ring', ProgressRing);


    </script>
<script>
    function showPosition() {
        if(navigator.geolocation) {
            //navigator.geolocation.getCurrentPosition(getLocation);
            navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            console.log('Lat : '+latitude+" & Long : "+longitude);
              window.livewire.emit('set:latitude-longitude', latitude, longitude);
            });
        } else {
            alert("Sorry, your browser does not support HTML5 geolocation.");
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

    window.onload = showPosition;

</script>
</div>
