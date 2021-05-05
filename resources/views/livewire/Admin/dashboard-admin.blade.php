<div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
  
    @if($isModal == 'Import')
      @include('livewire.Admin.Schedule.import')
    @elseif($isModal == 'Division')
      @include('livewire.Admin.manage_division')
    @endif
<div class="bg-white shadow">
  <div class="flex justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
      <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
      </h2>

      @if (session()->has('message'))
          <div class="alert alert-success">
              {{ session('message') }}
          </div>
      @endif

    
  </div>
  </div>
  
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 xl:px-20">
      <div class="grid md:grid-cols-8 md:grid-flow-col md:gap-4 md:divide-x  md:divide-gray-300 grid-cols-1 md:px-0 px-4">
        <div class="md:col-span-2 md:grid-rows-8 grid-cols-1 grid text-gray-600 text-center h-full md:mt-4 my-5">
          <livewire:show-task-activity />
        </div>




        <div class="grid md:grid-rows-8 grid-cols-1 md:divide-y md:divide-gray-300 col-span-6">
          <div class="flex flex-col place-items-auto gap-2 md:mt-0 mt-10 pt-4 py-6 row-span-1 md:pl-8">
            <label class="text-xl text-center ">Today Statistic</label>
            <div class="grid md:grid-cols-3 grid-cols-1 lg:gap-10 md:gap-2 mt-5 ">

              <div id="jh-stats-positive" class="flex flex-col justify-center px-4 py-4 bg-white border border-gray-200 rounded-xl relative">
                <i class="fas fa-check-circle absolute top-2 left-4 text-blue-400 text-xl"></i>
                <div>
                  <div>
                    <p class="flex items-center justify-end @if($count_attend < $prev_attend) text-red-500 @elseif($prev_attend < $count_attend) text-green-500 @else text-gray-500 @endif text-md absolute top-2 right-4">
                      @if($count_attend < $prev_attend)
                      <span class="font-bold">
                        @if($prev_attend == 0)
                          100%
                        @else
                          {{($count_attend - $prev_attend)/$prev_attend*100}}%
                        @endif
                      </span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 9a1 1 0 012 0v8a1 1 0 01-1 1h-8a1 1 0 010-2h5.59L13 10.41l-3.3 3.3a1 1 0 01-1.4 0l-6-6a1 1 0 011.4-1.42L9 11.6l3.3-3.3a1 1 0 011.4 0l6.3 6.3V9z"/></svg>
                      @elseif($prev_attend < $count_attend)
                      <span class="font-bold">
                        @if($prev_attend == 0)
                          100%
                        @else
                          {{($count_attend - $prev_attend)/$prev_attend*100}}%
                        @endif
                      </span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 15a1 1 0 002 0V7a1 1 0 00-1-1h-8a1 1 0 000 2h5.59L13 13.59l-3.3-3.3a1 1 0 00-1.4 0l-6 6a1 1 0 001.4 1.42L9 12.4l3.3 3.3a1 1 0 001.4 0L20 9.4V15z"/></svg>
                      @else
                      <span class="font-bold">
                        0%
                      </span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M17 11a1 1 0 010 2H7a1 1 0 010-2h10z"/></svg>
                      @endif
                    </p>
                  </div>
                  <p class="text-2xl leading-tight font-semibold text-center text-gray-800">{{$count_attend}}</p>
                  <p class="text-base text-center leading-tight text-gray-500">Attend</p>
                </div>
                <div class="relative">
                  <label class="absolute top-0 right-0 text-center text-xs ">{{$count_attend}}/<span class="font-semibold">{{$schedules->count()}}</span>
                  </label>
                  <div class="overflow-hidden h-2 mt-4 text-xs flex rounded bg-gray-200">               
                    <div style="width: @if($schedules->count() != 0){{$count_attend/$schedules->count()*100}}%@else )% @endif" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>               
                  </div>
                </div>

              </div>
              <div id="jh-stats-negative" class="flex flex-col justify-center px-4 py-4 mt-4 bg-white border border-gray-200 rounded-xl relative sm:mt-0">
                <i class="fas fa-times-circle absolute top-2 left-4 text-red-400 text-xl"></i>
                <div>
                  <div>
                    <p class="flex items-center justify-end @if($count_notsignin < $prev_notsignin) text-red-500 @elseif($prev_notsignin < $count_notsignin) text-green-500 @else text-gray-500 @endif text-md absolute top-2 right-4">
                      @if($count_notsignin < $prev_notsignin)
                      <span class="font-bold">
                        @if($prev_notsignin == 0)
                          100%
                        @else
                          {{($prev_notsignin - $count_notsignin)/$prev_notsignin*100}}%
                        @endif
                      </span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 9a1 1 0 012 0v8a1 1 0 01-1 1h-8a1 1 0 010-2h5.59L13 10.41l-3.3 3.3a1 1 0 01-1.4 0l-6-6a1 1 0 011.4-1.42L9 11.6l3.3-3.3a1 1 0 011.4 0l6.3 6.3V9z"/></svg>
                      @elseif($prev_notsignin < $count_notsignin)
                      <span class="font-bold">
                        @if($prev_notsignin == 0)
                          100%
                        @else
                          {{($count_notsignin - $prev_notsignin)/$prev_notsignin*100}}%
                        @endif
                      </span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 15a1 1 0 002 0V7a1 1 0 00-1-1h-8a1 1 0 000 2h5.59L13 13.59l-3.3-3.3a1 1 0 00-1.4 0l-6 6a1 1 0 001.4 1.42L9 12.4l3.3 3.3a1 1 0 001.4 0L20 9.4V15z"/></svg>
                      @else
                      <span class="font-bold">
                        0%
                      </span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M17 11a1 1 0 010 2H7a1 1 0 010-2h10z"/></svg>
                      @endif
                    </p>
                  </div>
                  <p class="text-2xl leading-tight font-semibold text-center text-gray-800">{{$count_notsignin}}</p>
                  <p class="text-base text-center leading-tight text-gray-500">Not Sign in</p>
                </div>
                <div class="relative">
                  <label class="absolute top-0 right-0 text-center text-xs ">{{$count_notsignin}}/<span class="font-semibold">{{$schedules->count()}}</span>
                  </label>
                  <div class="overflow-hidden h-2 mt-4 text-xs flex rounded bg-gray-200">               
                    <div style="width: @if($schedules->count() != 0){{$count_notsignin/$schedules->count()*100}}% @else 0% @endif" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500"></div>                
                  </div>
                </div>
              </div>
              <div id="jh-stats-neutral" class="flex flex-col justify-center px-4 py-4 mt-4 bg-white border border-gray-200 rounded-xl relative sm:mt-0">
                <div>
                  <div>
                    <p class="flex items-center justify-end @if($count_permit < $prev_permit) text-red-500 @elseif($prev_permit < $count_permit) text-green-500 @else text-gray-500 @endif text-md absolute top-2 right-4">
                      @if($count_permit < $prev_permit)
                      <span class="font-bold">
                        @if($prev_permit == 0)
                          100%
                        @else
                          {{($prev_permit - $count_permit)/$prev_permit*100}}%
                        @endif
                      </span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 9a1 1 0 012 0v8a1 1 0 01-1 1h-8a1 1 0 010-2h5.59L13 10.41l-3.3 3.3a1 1 0 01-1.4 0l-6-6a1 1 0 011.4-1.42L9 11.6l3.3-3.3a1 1 0 011.4 0l6.3 6.3V9z"/></svg>
                      @elseif($prev_permit < $count_permit)
                      <span class="font-bold">
                        @if($prev_permit == 0)
                          100%
                        @else
                          {{($count_permit - $prev_permit)/$prev_permit*100}}%
                        @endif
                      </span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 15a1 1 0 002 0V7a1 1 0 00-1-1h-8a1 1 0 000 2h5.59L13 13.59l-3.3-3.3a1 1 0 00-1.4 0l-6 6a1 1 0 001.4 1.42L9 12.4l3.3 3.3a1 1 0 001.4 0L20 9.4V15z"/></svg>
                      @else
                      <span class="font-bold">
                        0%
                      </span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M17 11a1 1 0 010 2H7a1 1 0 010-2h10z"/></svg>
                      @endif
                    </p>
                  </div>
                  <p class="text-2xl leading-tight font-semibold text-center text-gray-800">{{$count_permit}}</p>
                  <p class="text-base text-center leading-tight text-gray-500">Permission</p>
                </div>
                <div class="relative">
                  <label class="absolute top-0 right-0 text-center text-xs ">{{$count_permit}}/<span class="font-semibold">{{$schedules->count()}}</span>
                  </label>
                  <div class="overflow-hidden h-2 mt-4 text-xs flex rounded bg-gray-200">               
                    <div style="width: @if($schedules->count() != 0){{$count_permit/$schedules->count()*100}}% @else 0% @endif" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-500"></div>                
                  </div>
                </div>
              </div>
          
          </div>
          </div>
          <div class="row-span-3 grid grid-cols-3 divide-x py-4 md:pl-8 gap-4">
            <div class="lg:col-span-2 col-span-3">
              <livewire:charts.chart-attend-statistic />

            </div>
            <div class="pl-4 py-1 flex flex-col hidden lg:block items-center ">
            <label class="text-xl text-center ">Head of Division</label>
            @foreach($users->where('role','Manager') as $user)
            <div class="flex justify-between gap-2 items-center text-sm my-2"> 
              <label class=" font-semibold text-center">{{$user->division}}</label>
              <span class="border flex-auto h-0.5 bg-gray-900 "></span>
              <label class=" text-center">{{$user->name}}</label>
            </div>
            @endforeach
            
            <div class="w-full text-center mt-4">
            <a class="bg-gray-400 focus:outline-none py-2 text-center px-8 shadow-lg rounded-lg text-sm mt-4 text-white hover:bg-blue-600 mx-auto modal-open cursor-pointer" wire:click="showManageDivision()">Manage</a>
            </div>
            </div>
          </div>

          <div class="row-span-3 md:grid md:grid-cols-2 lg:grid-cols-1 text-center md:pl-8 py-4">
           <div class="px-4 py-1 flex flex-col  lg:hidden md:block">
            <label class="text-xl text-center mb-5">Head Office</label>
            @foreach($users->where('role','Manager') as $user)
            <div class="flex justify-between gap-2 items-center text-sm my-2"> 
              <label class=" font-semibold text-center">{{$user->division}}</label>
              <span class="border flex-auto h-0.5 bg-gray-900 "></span>
              <label class=" text-center">{{$user->name}}</label>
            </div>
            @endforeach
            <a class="bg-blue-400 focus:outline-none  py-2 rounded-lg text-sm mt-4 text-white w-full hover:bg-blue-600 mx-auto modal-open" wire:click="showManageDivision()">Manage</a>
          </div>
          
          <div class="flex hide-scroll lg:grid lg:grid-cols-4 xl:gap-8 gap-2 mt-2 text-gray-700">
         
            <div class="flex hover:shadow-lg duration-200 justify-between bg-blue-200 gap-2 py-4 px-4 xl:px-8 rounded-lg flex-col items-center">
              <i class="fas fa-sign-in-alt bg-white px-6 text-gray-600 py-5 rounded-full text-3xl "></i>
              <label class="font-semibold ">Recap Shift</label>
              <button class="text-sm focus:outline-none  bg-blue-400 w-full hover:bg-blue-700 cursor-pointer text-white  py-2 px-6 rounded-lg" wire:click="exportShift()">Download</button>
            </div>
             <div class="flex hover:shadow-lg duration-200 justify-between bg-blue-200 gap-2  py-4 px-4 xl:px-8 rounded-lg flex-col items-center">
              <i class="far fa-calendar-alt bg-white px-6 text-gray-600 py-5 rounded-full text-3xl "></i>
              <label class="font-semibold ">Recap Schedule</label>
              <button class="text-sm focus:outline-none  bg-blue-400 w-full hover:bg-blue-700 cursor-pointer text-white  py-2 px-6 rounded-lg" wire:click="exportSchedule()">Download</button>
            </div>
             <div class="flex hover:shadow-lg duration-200 justify-between bg-blue-200 gap-2  py-4 px-4 xl:px-8 rounded-lg flex-col items-center">
              <i class="far fa-copy bg-white px-6 text-gray-600 py-5 rounded-full text-3xl "></i>
              <label class="font-semibold ">Recap Request</label>             
              <button class="text-sm focus:outline-none  bg-blue-400 w-full hover:bg-blue-700 cursor-pointer text-white py-2 px-6 rounded-lg" wire:click="exportRequest()">Download</button>
            </div>
             <div class="flex hover:shadow-lg duration-200 justify-between bg-yellow-200 gap-2  py-4 px-4 xl:px-8 rounded-lg flex-col items-center">
              <i class="fas fa-print bg-white px-6 text-gray-600 py-5 rounded-full text-3xl "></i>
              <label class="font-semibold ">Recap All Document</label>             
              <button class="text-sm focus:outline-none  bg-yellow-400 w-full hover:bg-yellow-600 cursor-pointer text-white py-2 px-6 rounded-lg" wire:click="exportAll()">Download</button>
            </div>

          </div>
          </div>
          
        </div>
      </div>
      </div>
    </div>
 
   <div  wire:loading wire:loading.min.300ms wire:loading.delay.500ms wire:loading.class="overflow-x-hidden overflow-y-hidden fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" wire:target="exportShift, exportSchedule, exportRequest, exportAll">
    <section class="h-full w-full border-box lg:px-24 md:px-16 sm:px-8 px-8 sm:pt-32 pt-20 sm:pb-32 pb-20 transition-all duration-500 linear" style="background-image: linear-gradient(to bottom, rgb(31 29 43 / 76%), rgba(39, 37, 53, 1));"    >     
      <div class="container mx-auto flex items-center justify-center flex-col ">        
        <img class="md:w-2/12 w-7/12 mb-10  object-center rounded-full border-4 border-white p-4" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNDY0IDQ2NCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDY0IDQ2NDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggc3R5bGU9ImZpbGw6I0ZDRjA1QTsiIGQ9Ik0zNzYsNDY0SDQwVjMyaDIyNGwxMTIsMTEyVjQ2NHoiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiNGREJENDA7IiBkPSJNNDI0LDQxNkg4OFYwaDIyNGwxMTIsMTEyVjQxNnoiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiNGNDlFMjE7IiBkPSJNMzEyLDExMmgxMTJMMzEyLDBWMTEyeiIvPg0KPGc+DQoJPHBhdGggc3R5bGU9ImZpbGw6I0U5Njg2QTsiIGQ9Ik0xNTIsMzUyaC0xNmMtNC40MTgsMC04LTMuNTgyLTgtOHMzLjU4Mi04LDgtOGgxNmM0LjQxOCwwLDgsMy41ODIsOCw4UzE1Ni40MTgsMzUyLDE1MiwzNTJ6Ii8+DQoJPHBhdGggc3R5bGU9ImZpbGw6I0U5Njg2QTsiIGQ9Ik0zNzYsMzUySDE4NGMtNC40MTgsMC04LTMuNTgyLTgtOHMzLjU4Mi04LDgtOGgxOTJjNC40MTgsMCw4LDMuNTgyLDgsOFMzODAuNDE4LDM1MiwzNzYsMzUyeiIvPg0KCTxwYXRoIHN0eWxlPSJmaWxsOiNFOTY4NkE7IiBkPSJNMTUyLDMwNGgtMTZjLTQuNDE4LDAtOC0zLjU4Mi04LThzMy41ODItOCw4LThoMTZjNC40MTgsMCw4LDMuNTgyLDgsOFMxNTYuNDE4LDMwNCwxNTIsMzA0eiIvPg0KCTxwYXRoIHN0eWxlPSJmaWxsOiNFOTY4NkE7IiBkPSJNMzc2LDMwNEgxODRjLTQuNDE4LDAtOC0zLjU4Mi04LThzMy41ODItOCw4LThoMTkyYzQuNDE4LDAsOCwzLjU4Miw4LDhTMzgwLjQxOCwzMDQsMzc2LDMwNHoiLz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojRTk2ODZBOyIgZD0iTTE1MiwyNTZoLTE2Yy00LjQxOCwwLTgtMy41ODItOC04czMuNTgyLTgsOC04aDE2YzQuNDE4LDAsOCwzLjU4Miw4LDhTMTU2LjQxOCwyNTYsMTUyLDI1NnoiLz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojRTk2ODZBOyIgZD0iTTM3NiwyNTZIMTg0Yy00LjQxOCwwLTgtMy41ODItOC04czMuNTgyLTgsOC04aDE5MmM0LjQxOCwwLDgsMy41ODIsOCw4UzM4MC40MTgsMjU2LDM3NiwyNTZ6Ii8+DQoJPHBhdGggc3R5bGU9ImZpbGw6I0U5Njg2QTsiIGQ9Ik0xNTIsMjA4aC0xNmMtNC40MTgsMC04LTMuNTgyLTgtOHMzLjU4Mi04LDgtOGgxNmM0LjQxOCwwLDgsMy41ODIsOCw4UzE1Ni40MTgsMjA4LDE1MiwyMDh6Ii8+DQoJPHBhdGggc3R5bGU9ImZpbGw6I0U5Njg2QTsiIGQ9Ik0zNzYsMjA4SDE4NGMtNC40MTgsMC04LTMuNTgyLTgtOHMzLjU4Mi04LDgtOGgxOTJjNC40MTgsMCw4LDMuNTgyLDgsOFMzODAuNDE4LDIwOCwzNzYsMjA4eiIvPg0KCTxwYXRoIHN0eWxlPSJmaWxsOiNFOTY4NkE7IiBkPSJNMTUyLDE2MGgtMTZjLTQuNDE4LDAtOC0zLjU4Mi04LThzMy41ODItOCw4LThoMTZjNC40MTgsMCw4LDMuNTgyLDgsOFMxNTYuNDE4LDE2MCwxNTIsMTYweiIvPg0KCTxwYXRoIHN0eWxlPSJmaWxsOiNFOTY4NkE7IiBkPSJNMzc2LDE2MEgxODRjLTQuNDE4LDAtOC0zLjU4Mi04LThzMy41ODItOCw4LThoMTkyYzQuNDE4LDAsOCwzLjU4Miw4LDhTMzgwLjQxOCwxNjAsMzc2LDE2MHoiLz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojRTk2ODZBOyIgZD0iTTEzNiw3Mmg0OHY0OGgtNDhWNzJ6Ii8+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8L3N2Zz4NCg==" alt="">
           <div class="text-center w-full">          <h1 class="text-3xl text-white mb-3 font-semibold text-black tracking-wide"          >Exporting Successful</h1>          <p class="lg-show-empty-3-2 mb-12 text-base tracking-wide leading-7 text-gray-50"         >We've sent the recapulation to your email address too</p> </div>      </div>    </section>    
   </div>
  
    <script type="text/javascript">
      var arrayMonth = {!! json_encode($dataChart['month']) !!};
      var dataAttend = {!! json_encode($dataChart['attend']) !!};
      var dataNotsignin = {!! json_encode($dataChart['not sign in']) !!};
      var ctx = document.getElementById('myChart').getContext('2d');
      var chart = new Chart(ctx, {
              // The type of chart we want to create
              type: 'line',

              // The data for our dataset
              data: {
                labels: arrayMonth,
                datasets: [{
                  label: 'Attend',

                  borderColor: '#3498db',
                  data: dataAttend
                },{
                  label: 'Not signin',

                  borderColor: '#fc0303',
                  data: dataNotsignin
                },]
              },

          // Configuration options go here
          options: {}
        });
      </script>
     
</div>
<div class="bg-white w-full text-center mt-10">footer</div>
