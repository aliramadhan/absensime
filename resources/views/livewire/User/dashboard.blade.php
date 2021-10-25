<div>
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
      <div x-data="{ showNotif: false }">        
      @if (session()->has('success'))
        <div class="flex fixed bottom-10 z-30" x-data="{ showNotif: true }" x-show="showNotif" x-transition:leave="transition duration-100 transform ease-in" x-transition:leave-end="opacity-0 scale-90" x-init="setTimeout(() => showNotif = false, 10000)">
          <div class="m-auto">
            <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-xl ">
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

      @if(session()->has('failure'))
        <div class="flex fixed bottom-10 z-30" x-data="{ showNotif: true }" x-show.transition="showNotif" x-init="setTimeout(() => showNotif = false, 10000)">
          <div class="m-auto">
            <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-xl ">
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
      </div>
      <div class="flex gap-2" x-data="{ showModal: false }" @keydown.escape="showModal = false" x-cloak>
       <!--  <button wire:click="showCreateRequest()" class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:px-5 px-4 py-4 md:py-2 text-lg font-semibold tracking-wider text-white md:rounded-xl rounded-full shadow-md focus:outline-none items-center flex-row gap-3 flex"><i class="fas fa-paper-plane" ></i><span class="hidden md:block">Create Request</span></button> -->
        <button class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:px-6 px-4 md:py-2 py-3 flex items-center gap-2 text-lg font-semibold tracking-wider text-white rounded-xl shadow-md focus:outline-none" @click="showModal = true"><i class="fas fa-plus"></i> <span class="hidden md:block">Create Request</span></button>
        
        <div class="overflow-auto" style="background-color: rgba(0,0,0,0.5)" x-show="showModal" :class="{ 'fixed inset-0 z-30 flex items-center justify-center': showModal }">
          <!--Dialog-->
          <div class="bg-white mx-auto rounded shadow-lg pt-4 text-left w-11/12 md:w-8/12 lg:w-4/12 " x-show="showModal" @click.away="showModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" >
            <!--Title-->
            <div class="flex justify-between items-center px-5 border-b pb-2">
                <p class="text-2xl font-semibold text-gray-700">Request <span class="text-orange-500">{{$type}}</span></p>
                <div class="cursor-pointer z-50" @click="showModal = false">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>
            <!-- content -->
            <form>
              <div class="bg-white px-6 pt-5 pb-4  max-w-8xl ">
                <div wire:loading wire:target="type" class="px-3 text-base md:text-lg text-gray-700"> 
                  <i class="fas fa-circle-notch animate-spin"></i> 
                  <label class="animate-pulse"">Building form.. </label> 
                </div>
                <div class="" wire:loading.remove wire:target="type">
                  <div class="mb-4">
                    <label for="forEmployee" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Request Type</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formType" wire:model="type" wire:change="updateDescRequest()">
                      <option hidden>Choose here</option>
                      @foreach($leaves as $leave)
                        <option>{{$leave->name}}</option>
                      @endforeach
                      <!--@if($user->is_active == 0)
                      <option>Record Activation</option>
                      @endif-->
                      <option>Absent</option>
                      <option>Sick</option>
                      <option>Permission</option>
                      <option>Overtime</option>
                      <option>Remote</option>
                      <option>Change Shift</option>
                      
                      @if($user->roles == 'Manager')
                          <option>Mandatory</option>
                      @endif
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                  </div>
                  @if($type == 'Mandatory')
                    <div class="mb-4">
                      <label for="formSetUser" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Select Employee </label>
                      <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formSetUser" wire:model="setUser">
                        <option hidden>Choose here</option>
                          @foreach($users as $thisUser)
                            <option value="{{$thisUser->id}}" >{{$thisUser->name}}</option>
                          @endforeach
                      </select>
                      @error('setUser') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="formDate" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Date </label>
                        <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDate" wire:model="date" @if($type == 'Change Shift' && $schedule != null) @if($schedule->status == 'Not sign in') min="{{Carbon\Carbon::now()->format('Y-m-d')}}" @else min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif @elseif($type == 'Excused') min="{{Carbon\Carbon::now()->format('Y-m-d')}}" @elseif($type == 'Absent') max="{{Carbon\Carbon::now()->subDay(1)->format('Y-m-d')}}" @elseif($type != 'Overtime')min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif>
                        @error('date') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="formNewShift" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">New Shift </label>
                        <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formNewShift" wire:model="newShift">
                            <option hidden>Choose here</option>
                            @foreach($shifts as $listShift)
                                <option value="{{$listShift->id}}" >{{$listShift->name}}</option>
                            @endforeach
                        </select>
                        @error('newShift') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="formNewShift" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Change Catering Shift </label>
                        <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formNewShift" wire:model="newCatering">
                            <option hidden>Choose here</option>
                            <option>Do Nothing!</option>
                            <option>Cancel Order</option>
                            <option>Pagi</option>
                            <option>Siang</option>
                        </select>
                        @error('newCatering') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                  @elseif($leaves->contains('name',$type) || $type == 'Sick' || $type == 'Permission')
                    <div class="mb-4 gap-4 grid grid-cols-1 md:grid-cols-2">
                      <div class="flex-auto">
                        <label for="formStartRequestDate" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">From</label>
                        <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStartRequestDate" wire:model="startRequestDate" >
                        @error('startRequestDate') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                      </div>
                      <div class="flex-auto">
                          <label for="formStopRequestDate" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">To</label>
                          <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStopRequestDate" wire:model="stopRequestDate">
                          @error('stopRequestDate') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                      </div>
                    </div>
                    <div class="mb-4">
                      <label for="formDesc" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Reason </label>
                      <input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDesc" wire:model="desc" placeholder="Fill in here...">
                      @error('desc') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4 flex items-center gap-2">
                      <label for="formIsCancelOrder" class="block text-gray-500 text-sm tracking-wide font-semibold">Cancel your <span class="text-orange-500">catering</span> order ?</label>
                      <input type="checkbox" class="shadow appearance-none hover:pointer border rounded-md w-5 h-5 text-orange-500 leading-tight focus:outline-none focus:shadow-outline" id="formIsCancelOrder" wire:model="is_cancel_order" placeholder="fill in here......">
                      @error('is_cancel_order') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                  @elseif($type == 'Remote')
                    <div class="mb-4 grid md:grid-cols-2 grid-cols-1 gap-4">
                      <div class="flex-auto">
                        <label for="formStartRequestDate" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">From</label>
                        <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStartRequestDate" wire:model="startRequestDate" >
                        @error('startRequestDate') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                      </div>
                      <div class="flex-auto">
                        <label for="formStopRequestDate" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">To</label>
                        <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStopRequestDate" wire:model="stopRequestDate">
                        @error('stopRequestDate') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                      </div>
                    </div>
                    <div class="mb-4">
                      <label for="formNewShift" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Where? </label>
                      <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDesc" wire:model="desc">
                        <option hidden>Choose here</option>                             
                        <option>Malang</option>
                        <option>Luar Malang</option>                                
                      </select>
                    </div>
                    <div class="mb-4 flex items-center gap-2">
                      <label for="formIsCancelOrder" class="block text-gray-500 text-sm tracking-wide font-semibold">Cancel your <span class="text-orange-500">catering</span> order ?</label>
                      <input type="checkbox" class="shadow appearance-none hover:pointer border rounded-md w-5 h-5 text-orange-500 leading-tight focus:outline-none focus:shadow-outline" id="formIsCancelOrder" wire:model="is_cancel_order" placeholder="fill in here......">
                      @error('is_cancel_order') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                  @elseif($type == 'Absent')
                    <div class="mb-4">
                      <label for="formDate" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Date </label>
                      <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDate" wire:model="date" @if($type == 'Change Shift' && $schedule != null) @if($schedule->status == 'Not sign in') min="{{Carbon\Carbon::now()->format('Y-m-d')}}" @else min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif @elseif($type == 'Excused') min="{{Carbon\Carbon::now()->format('Y-m-d')}}" @elseif($type == 'Absent') max="{{Carbon\Carbon::now()->subDay(1)->format('Y-m-d')}}" @elseif($type != 'Overtime')min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif>
                      @error('date') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                      <label for="formLocation" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Working at (Tracking option)</label>
                      <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formLocation" wire:model="locationRe">
                          <option hidden>Choose one</option>
                          <option value="WFO">Work From Office</option>
                          <option value="WFH">Work From Home</option>
                          <option value="Business Travel">Business Travel</option>
                          <option>Remote</option>
                      </select>
                      @error('locationRe') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <label for="formStartedAt" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Started at </label>
                        <input type="time" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStartedAt"  placeholder="Fill in here..." wire:model="started_at">
                        @error('started_at') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                      </div>
                      <div>
                        <label for="formStopedAt" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Stoped at </label>
                        <input type="time" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStopedAt" placeholder="Fill in here..." wire:model="stoped_at">
                        @error('stoped_at') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                      </div>
                    </div>
                    <div class="mb-4">
                      <label for="formDesc" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Reason you forgot to record </label>
                      <input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" wire:model="desc" id="formDesc" placeholder="isi Alasan.">
                      @error('desc') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                  @elseif($type == 'Overtime')
                    <div class="mb-4">
                      <label for="formDate" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Date </label>
                      <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDate" wire:model="date" @if($type == 'Change Shift' && $schedule != null) @if($schedule->status == 'Not sign in') min="{{Carbon\Carbon::now()->format('Y-m-d')}}" @else min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif @elseif($type == 'Excused') min="{{Carbon\Carbon::now()->format('Y-m-d')}}" @elseif($type == 'Absent') max="{{Carbon\Carbon::now()->subDay(1)->format('Y-m-d')}}" @elseif($type != 'Overtime')min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif>
                      @error('date') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                      <label for="formDesc" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Reason </label>
                      <input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDesc" wire:model="desc" placeholder="Fill in here...">
                      @error('desc') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                      <label for="formTime" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Duration (minute) :</label>
                      <input type="number" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTime" wire:model="time_overtime" placeholder="duration in minutes">
                      @error('time_overtime') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                  @elseif($type == 'Change Shift')
                    <div class="mb-4">
                      <label for="formDate" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Date </label>
                      <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDate" wire:model="date" @if($type == 'Change Shift' && $schedule != null) @if($schedule->status == 'Not sign in') min="{{Carbon\Carbon::now()->format('Y-m-d')}}" @else min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif @elseif($type == 'Excused') min="{{Carbon\Carbon::now()->format('Y-m-d')}}" @elseif($type == 'Absent') max="{{Carbon\Carbon::now()->subDay(1)->format('Y-m-d')}}" @elseif($type != 'Overtime')min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif>
                      @error('date') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                      <label for="formNewShift" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">New Shift </label>
                      <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formNewShift" wire:model="newShift">
                        <option hidden>Choose here</option>
                        @foreach($shifts as $listShift)
                          <option value="{{$listShift->id}}" >{{$listShift->name}}</option>
                        @endforeach
                      </select>
                      @error('newShift') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                      <label for="formNewShift" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Change Catering Shift </label>
                      <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formNewShift" wire:model="newCatering">
                        <option hidden>Choose here</option>
                        <option>Do Nothing!</option>
                        <option>Cancel Order</option>
                        <option>Pagi</option>
                        <option>Siang</option>
                      </select>
                      @error('newCatering') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                  @endif
                  <!--
                  <div class="mb-4">
                      <label for="forDate" class="block text-gray-500 text-sm font-bold mb-2">Date:</label>
                      <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="forDate" wire:model="date" min="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                      @error('date') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                  </div>
                  <div class="mb-4">
                      <label for="forShift" class="block text-gray-500 text-sm font-bold mb-2">Shift:</label>
                      <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="forShift" wire:model="shift_id">
                          <option hidden>Choose Shift here</option>
                          @foreach($shifts as $shift)
                          <option value="{{$shift->id}}">{{$shift->name}} ( {{Carbon\Carbon::parse($shift->time_in)->format('H:i')}} - {{Carbon\Carbon::parse($shift->time_out)->format('H:i')}} )</option>
                          @endforeach
                      </select>
                      @error('shift_id') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                  </div>--> 
                </div>
              </div>

              <!--Footer-->
              <div class="flex justify-end py-3 bg-gray-100 space-x-4 px-4  items-center">
                  <a class="bg-transparent py-2 px-4 rounded-lg text-gray-500 hover:bg-white hover:text-gray-700 font-semibold tracking-wider border border-gray-400 rounded-lg bg-white focus:outline-none cursor-pointer" @click="showModal = false">Cancel</a>
                  <button type="button" class="modal-close bg-blue-500 py-2 px-5 rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none" @click="$wire.createRequest()" wire:loading.remove wire:target="createRequest">Send</button>
                  <button type="button" class="modal-close bg-blue-500 py-2 px-5 rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none animate-pulse" wire:loading wire:target="createRequest" readonly>Sending..</button>
              </div>
            </form>

          </div>
              <!--/Dialog -->
        </div><!-- /Overlay -->
      <!--   <button wire:click="showMandatory()" class="border-blue-500 border-2 hover:bg-blue-500 hover:text-white text-blue-500 duration-200 opacity-80 hover:opacity-100 md:px-5 px-4 py-4 md:py-2 text-lg font-semibold tracking-wider md:rounded-xl rounded-full shadow-md focus:outline-none items-center flex-row gap-3 flex"><i class="fas fa-envelope-open-text"></i><span class="hidden md:block">Mandatory</span></button> -->
      </div>
    </div>
   
        
         
      



      <div wire:loading wire:target="showCreateRequest,closeModal,showMandatory" class="overflow-x-hidden overflow-y-hidden fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center">
        <section class="h-full w-full border-box  transition-all duration-500 flex bg-gray-500 opacity-75"    >   
          <div class="text-6xl text-white m-auto text-center">        
            <i class="fas fa-circle-notch animate-spin"></i>
          </div>
        </section>
      </div>
  </div>
    <div class="md:py-12 py-0">
        <div class="max-w-7xl mx-auto sm:px-0 md:px-4 lg:px-8">
            <div class="lg:grid lg:grid-cols-8 flex-col flex flex-col-reverse gap-4">

            <div class="lg:flex lg:flex-col md:grid md:grid-cols-2  sm:rounded-lg col-span-2 lg:space-y-4 flex flex-col-reverse hide-scroll lg:space-x-0 md:space-x-2">
                
              <div class="overflow-hidden md:mt-0 mt-4">

                <style>
                  [x-cloak] {
                    display: none;
                  }
                </style>

                <div class="antialiased sans-serif bg-gray-100 md:w-full w-11/12 mx-auto md:mx-0 rounded-lg mb-3 md:mb-0">
                  <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                    <div class="container mx-auto  ">


                      <div class="bg-white rounded-lg shadow overflow-hidden p-1">

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
                            class=" text-sm uppercase tracking-wide font-bold text-center mb-10"></div>
                          </div>
                        </template>
                      </div>

                      <div class="flex flex-wrap border-t border-l items-center ml-1 mb-1 border-gray-300">
                        <template x-for="blankday in blankdays">
                          <div 
                          style="width: 14.1%;  height: 50px;"
                          class="text-center border-r border-b px-4 pt-2 border-gray-300" 
                          ></div>
                        </template> 
                        <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex"> 
                          <div style="width: 14.1%; height: 50px" class="border-r border-b  border-gray-300 text-center flex items-center leading-none">
                            <div class="relative flex flex-col  inline-flex w-full h-full  items-center justify-center cursor-pointer text-center leading-none  transition ease-in-out duration-300 m-auto  "
                            :class="{'bg-blue-400 text-white border-white hover:bg-blue-500': isToday(date[0]) == true, 'hover:bg-gray-200 text-gray-600 ': isToday(date[0]) == false }">
                            <div
                            @click="showEventModal(date)" class="text-lg font-semibold border-b border-dashed w-6 text-center " :class="isToday(date[0]) ? 'border-white':'border-gray-500'"
                            x-text="date[0]"></div> 
                            <label x-text="date[1]" class="text-xs font-semibold rounded-br-md  pt-0.5" :class="{'text-white': date[1] == 'libur' && isToday(date[0]) == true,'text-red-500': date[1] == 'libur' && isToday(date[0]) != true}"></label>
                            </div>
                 
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
                schedules: {!! json_encode(App\Models\Schedule::where('employee_id',$user->id)->get()->toArray()) !!},
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
                  let daysInMonth = new Date(this.year, this.month + 1, 0);
                  // find where to start calendar day of week
                  let dayOfWeek = new Date(this.year, this.month).getDay();
                  let blankdaysArray = [];
                  for ( var i=1; i <= dayOfWeek; i++) {
                    blankdaysArray.push(i);
                  }

                  let daysArray = [];
                  let dateString = '';
                  for ( var i=1; i <= daysInMonth.getDate(); i++) {
                    var month = daysInMonth.getMonth() + 1;
                    if (month < 10) {
                      month = '0'+month;
                    }
                    if (i < 10) {
                      dateString = daysInMonth.getFullYear() + '-' + month + '-0' + i;
                    }
                    else{
                      dateString = daysInMonth.getFullYear() + '-' + month + '-' + i;
                    }

                    var schedule = this.schedules.find(function(item){
                      return item.date == dateString
                    })
                    if (schedule != null) {
                      daysArray.push([i,schedule.shift_name]);
                    }
                    else{
                      daysArray.push([i,'libur']);
                    }
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
            <div class="overflow-hidden md:col-span-1 col-span-2 md:w-full w-11/12 mx-auto md:mx-0 rounded-lg md:mt-0 sm:mt-4">
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
                 <div class=" bg-gradient-to-r from-purple-300 to-blue-400 w-full h-full py-10 px-4 flex-row col-span-2 text-center text-white rounded-xl hidden md:block shdow-md">   
                    <div class="bg-cover bg-no-repeat bg-center w-32 h-32 mb-6 items-center rounded-full mx-auto relative weekly-trigger cursor-pointer" style="background-image: url({{ Auth::user()->profile_photo_url }});">
                    @if($schedule != null)
                    @php
                      $progress = ($schedule->timer + $schedule->workhour)/$limit_workhour * 100;
                    @endphp
                    @endif
                    <progress-ring stroke="4" percent="5" radius="74.5" progress="@if($progress>=100) {{100}} @else {{$progress}} @endif"  class=" left-11 -mt-1 "></progress-ring>  
                    <div class="absolute weekly-target w-32 h-32 top-0  rounded-full justify-center text-center px-2 space-y-2 flex flex-col" style="background-color: #292929a3;">
                      <label class="leading-none">Work Progress</label>
                       <label class="text-4xl"> @if($progress>=100) {{100}}% @else {{number_format($progress,0)}}% @endif</label> </div>
                  </div>

                    <h2 class="font-semibold text-xl tracking-wide truncate">{{auth()->user()->name}}</h2>                  
                    <h2 class="text-gray-50">{{auth()->user()->division}}</h2> 
                  
                </div>
                <div class="flex-auto col-span-4 xl:col-span-6 h-full md:py-6 pt-8 md:pt-0">
                    <div class="grid grid-rows-4 border-l-0 border-2 bg-white h-full my-auto md:rounded-br-xl md:rounded-tl-xl md:rounded-tr-xl  static ">
                    <div class="border-b-2 row-span-1 px-4 flex justify-between items-center relative "> 

                        <div class="py-4 md:py-0 xl:text-4xl justify-between md:mx-0 mx-auto text-3xl font-bold text-gray-500 flex items-center space-x-4 md:-ml-2">
                           <div class="bg-cover bg-no-repeat bg-center w-12 h-12 items-center rounded-full mx-auto inline-flex md:hidden" style="background-image: url({{ Auth::user()->profile_photo_url }});"></div>
                         <label class="border-r pr-2"> @if($schedule != null){{Carbon\Carbon::parse($schedule->date)->format('l')}} @else {{$now->format('l')}} @endif</label>
                          <div class="md:text-base md:text-sm font-semibold text-gray-500 flex flex-col leading-none mt-2 ">
                            <label class="leading-none text-base hidden md:block">@if($schedule != null){{Carbon\Carbon::parse($schedule->date)->format('d F')}} @else {{$now->format('d F')}} @endif</label>
                             <label class="leading-none text-base  md:hidden block">@if($schedule != null){{Carbon\Carbon::parse($schedule->date)->format('d M')}} @else {{$now->format('d M')}} @endif</label>
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
                            @if($schedule != null)
                             <h2 class="font-semibold text-gray-800 text-sm md:text-base "><i class="far fa-calendar-alt text-orange-500"></i> Shift {{$schedule->shift->name}}  @if($user->position == 'Project Manager') <span class="text-sm font-semibold text-gray-500 align-top">+4 h </span> @endif</h2>
                            <h4 class="text-sm md:text-base ">{{Carbon\Carbon::parse($schedule->shift->time_in)->format('H:i')}} - {{Carbon\Carbon::parse($schedule->shift->time_out)->format('H:i')}}</h4>
                            
                            @else
                           <h2 class="font-semibold text-gray-800 text-sm md:text-base ">No Schedule</h2>
                            @endif
                        </div>
                        @endif
                       
                         </div>

                         <a href="#" class="flex items-center gap-4 md:hidden block w-screen left-0 absolute -mt-9 z-10 top-0 text-center bg-gradient-to-r from-purple-400 to-blue-500 border text-white py-2 hover:bg-gray-500">
                          @if($schedule != null)
                          @php
                          $weekStart = Carbon\Carbon::now()->startOfWeek();
                          $weekStop = Carbon\Carbon::now()->endOfWeek();
                          @endphp
                          <div class="space-x-2 flex mx-auto items-center ">
                            <h2 class="font-semibold text-sm md:text-base tracking-wide"><i class="far fa-calendar-alt"></i>  Shift {{$schedule->shift->name}} </h2>
                            <h4 class="text-sm md:text-base tracking-wider">{{Carbon\Carbon::parse($schedule->shift->time_in)->format('H:i')}} - {{Carbon\Carbon::parse($schedule->shift->time_out)->format('H:i')}} @if($user->position == 'Project Manager') <span >(+4 h) </span> @endif</h4>
                           
                          </div>
                          @else
                          <div class="gap-2 flex mx-auto items-center ">
                            <h2 class="font-semibold text-sm md:text-base tracking-wide"> No Schedule Today</h2>                          
                          </div>
                         
                          @endif
                          
                        </a>

                    </div>

                    <div class="row-span-4 px-4 py-3 mt-2 md:mb-0 mb-4  xl:w-auto overflow-hidden">                      
                      <div class="flex md:flex-row flex-col  space-x-0 md:space-x-4 items-start md:items-center pb-3 truncate">
                        <label class="flex space-x-4 items-center md:mb-0 mb-2 flex-shrink-0">
                            <span class="text-gray-700 flex space-x-1 ">Tracking Option</span>
                            @if(($cekRemote)|| ($schedule != null && $schedule->status == 'Working'))
                            <select class="form-select rounded-md py-1 pr-8 text-sm bg-gray-50 border-gray-400 md:w-auto w-6/12" disabled wire:model="location" >
                                @if($cekRemote)<option selected="true">Remote</option>@endif
                                <option value="WFO">Work From Office</option>
                                <option value="WFH">Work From Home</option>
                                <option value="Business Travel">Business Travel</option>
                            </select>
                            @else
                              <select class="form-select rounded-md py-1 pr-8 text-sm bg-gray-50 border-gray-400 md:w-auto w-6/12  @error('location') border-red-500  @enderror" wire:model="location" >
                                <option hidden value="none">Choose One</option>
                                @if($cekRemote)<option selected="true">Remote</option>@endif
                                <option value="WFO">Work From Office</option>
                                <option value="WFH">Work From Home</option>
                                <option value="Business Travel">Business Travel</option>
                                  </select>
                            @endif
                        </label>
                          @error('location') <span class="text-red-500 text-base font-semibold ">Please fill tracking option</span>@enderror

                       <!--   <h2 class="text-gray-700 text-left mr-2 truncate w-full md:w-11/12  border rounded-xl px-3  py-1"><i class="fas fa-map-marker-alt mr-1 text-orange-500"></i> {{ $schedule->current_position ?? "Your Location" }}</h2> -->
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
              <div @if($schedule != null && ($schedule->status == 'Working' || $schedule->status == 'Not sign in')) wire:poll.keep-alive="syncTime" @elseif($user->is_active == 0) wire:poll.keep-alive="syncTime" @endif class="block lg:w-4/12 md:w-5/12 w-full md:mt-0 mt-2 text-gray-700">
                @if($schedule != null && $schedule->status != 'Not sign in')
                  @if($time_in->lessThan(Carbon\Carbon::parse($schedule->started_at)) && Carbon\Carbon::parse($schedule->started_at)->diffInMinutes($time_in) > 60  && $schedule->note == null)
                    @include('livewire.User.show-late')
                  @endif
                  @php
                    $workhourDetail = 0;
                    foreach ($schedule->details->where('status','Work') as $listDetail) {
                        $started_atDetail = Carbon\Carbon::parse($listDetail->started_at);
                        $stoped_atDetail = Carbon\Carbon::parse($listDetail->stoped_at);
                        $workhourDetail += $started_atDetail->diffInSeconds($stoped_atDetail);
                    }
                  @endphp
                  @if($workhourDetail >= $limit_workhour && $schedule->status_stop == null && $workhourDetail <= ($limit_workhour + 1800) && ($user->position != 'Project Manager' && $user->position != 'Junior PM'))
                    @include('livewire.User.show-confirm-stop')
                  @elseif(($workhourDetail >= $limit_workhour+14400) && $schedule->status_stop == null && $workhourDetail <= ($limit_workhour + 16200) && ($user->position == 'Project Manager'  && $user->position == 'Junior PM'))
                    @include('livewire.User.show-confirm-stop')
                  @elseif($workhourDetail >= $limit_workhour && $schedule->status_stop == null && $workhourDetail > ($limit_workhour + 1800) && ($user->position != 'Project Manager' && $user->position != 'Junior PM'))
                    @php
                      //update task and stop schedule
                      $detailSchedule = $schedule->details->sortByDesc('id')->first();
                      $detailSchedule->update([
                          'stoped_at' => $now,
                      ]);
                      $workhour = 0;
                      foreach ($schedule->details->where('status','Work') as $detail) {
                          $started_at = Carbon\Carbon::parse($detail->started_at);
                          $stoped_at = Carbon\Carbon::parse($detail->stoped_at);
                          $workhour += $started_at->diffInSeconds($stoped_at);
                      }
                      $schedule->update([
                          'stoped_at' => $now,
                          'workhour' => $workhour,
                          'timer' => 0,
                          'status' => 'Done',
                      ]);
                    @endphp
                  @elseif(($workhourDetail >= $limit_workhour+14400) && $schedule->status_stop == null && $workhourDetail > ($limit_workhour + 16200) && ($user->position == 'Project Manager' && $user->position == 'Junior PM'))
                    @php
                      //update task and stop schedule
                      $detailSchedule = $schedule->details->sortByDesc('id')->first();
                      $detailSchedule->update([
                          'stoped_at' => $now,
                      ]);
                      $workhour = 0;
                      foreach ($schedule->details->where('status','Work') as $detail) {
                          $started_at = Carbon\Carbon::parse($detail->started_at);
                          $stoped_at = Carbon\Carbon::parse($detail->stoped_at);
                          $workhour += $started_at->diffInSeconds($stoped_at);
                      }
                      $schedule->update([
                          'stoped_at' => $now,
                          'workhour' => $workhour,
                          'timer' => 0,
                          'status' => 'Done',
                      ]);
                    @endphp
                  @endif
                @endif
                @if($schedule != null)
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
                  <div class="pt-3 block  md:mt-0 mt-2 text-gray-700 w-auto">
                <h2 class="text-center relative border-4 border-blue-400 rounded-xl leading-tight" >
                  <span class="md:hidden xl:inline-block -top-4 bg-white relative  xl:px-2 md:text-lg text-base px-3 xl:font-medium lg:text-base ">Tracking Progress</span>
                    <span class="xl:hidden hidden md:inline-block md:px-2  -top-4 bg-white relative px-4 text-lg lg:text-base ">Tracking</span>
                  <div class="px-5 pb-2 md:-mt-4 -mt-6 flex flex-col items-center text-center ">
                    <h2 class="text-2xl font-semibold text-orange-500 mt-2 mb-1 tracking-wide">{{$time}}</h2>
                    <h2 class="text-base ">Status: <span class="font-semibold text-gray-800">{{$schedule->status}}</span></h2>
                  </div>
                </h2>
              </div>
             
              @else
                <div class="pt-3 block  md:mt-0 mt-2 text-gray-700 w-auto">
                  @php
                      $timeInt = $schedule->workhour;
                      $seconds = intval($timeInt%60);
                      $total_minutes = intval($timeInt/60);
                      $minutes = $total_minutes%60;
                      $hours = intval($total_minutes/60);
                      $time = $hours."h ".$minutes."m";
                  @endphp
                 <h2 class="text-center relative border-4 border-blue-400 rounded-xl leading-tight" >
                  <span class=" xl:inline-block md:hidden  -top-4 bg-white relative  xl:px-2 text-lg xl:font-medium lg:text-base ">Tracking Progress</span>
                  <span class="xl:hidden hidden md:inline-block md:px-2 -top-4 bg-white relative px-4 text-lg lg:text-base ">Tracking</span>
                  <div class="md:px-5 px-12 pb-2 -mt-6 flex flex-col items-center text-center ">
                    <h2 class="text-2xl font-semibold text-orange-500 mt-3 ">{{$time}}</h2>
                    <h2 class="text-base ">Status: <span class="font-semibold text-gray-800">{{$schedule->status}}</span></h2>
                  </div>
                </h2>
              </div>
                
              @endif
            </div>
            @endif
            @endif
              
             <div class="bg-white md:p-4 mt-5 md:mt-0 rounded-xl md:w-auto w-full">
              
              @if($schedule != null && $user->is_active != 1 && $schedule->status == 'Done')
             
               <button  class="relative bg-gradient-to-r from-red-400 to-purple-700 duration-200 opacity-80 hover:opacity-100 px-4 py-4 text-lg font-semibold tracking-wider px-6  text-white rounded-xl shadow-xl focus:outline-none w-full weekly-trigger"><i class="fas fa-lock"></i> Recording Complete  
                <div class="absolute weekly-target bg-white rounded-lg text-gray-700  md:-bottom-8 bottom-0 md:-top-15 z-30 p-3 left-0 ml-0 md:ml-2 shadow-xl border-2 md:-left-8 text-sm whitespace-normal">Your account is locked because you didn’t stop the record. To start your attendance record, you need to activate your account and provide the reason.</div>
               </button>  
              <!--
              @elseif(auth()->user()->is_active != 1 && ($prevSchedule != null && $prevSchedule->position_stop == null))
             
               <button  class="relative bg-gradient-to-r from-red-400 to-purple-700 duration-200 opacity-80 hover:opacity-100 px-4 py-4 text-lg font-semibold tracking-wider px-6  text-white rounded-xl shadow-xl focus:outline-none w-full weekly-trigger"><i class="fas fa-lock"></i> Account is Locked
                <div class="absolute weekly-target bg-white rounded-lg text-gray-700  md:-bottom-8 bottom-0 md:-top-15 z-30 p-3 left-0 ml-0 md:ml-2 shadow-xl border-2 md:-left-8 text-sm whitespace-normal">Your account is locked because you didn’t stop the record. To start your attendance record, you need to activate your account and provide the reason.</div>
               </button>     
              
              @elseif(auth()->user()->is_active != 1 && ($prevSchedule != null && $prevSchedule->status == 'No Record'))
               <button  class="relative bg-gradient-to-r from-red-400 to-purple-700 duration-200 opacity-80 hover:opacity-100 px-4 py-4 text-lg font-semibold tracking-wider px-6  text-white rounded-xl shadow-xl focus:outline-none w-full weekly-trigger"><i class="fas fa-lock"></i> Account is Locked
                <div class="absolute weekly-target bg-white rounded-lg text-gray-700  md:-bottom-8 bottom-0 md:-top-15 z-30 p-3 left-0 ml-0 md:ml-2 shadow-xl border-2 md:-left-8 text-sm whitespace-normal">Your account is locked. You are absent from work with no news. To start your attendance record, you need to activate your account and provide the reason.</div>
               </button>    
              -->         
              @elseif(auth()->user()->is_active != 1 && ($schedule != null && $schedule->started_at != null))
                @if($detailSchedule->status == 'Rest' && Carbon\Carbon::parse($detailSchedule->started_at)->diffInHours($now) >= 4))
                <button  class="relative bg-gradient-to-r from-red-400 to-purple-700 duration-200 opacity-80 hover:opacity-100 px-4 py-4 text-lg font-semibold tracking-wider px-6  text-white rounded-xl shadow-xl focus:outline-none w-full weekly-trigger"><i class="fas fa-lock"></i> Account is Locked
                <div class="absolute weekly-target bg-white rounded-lg text-gray-700  md:-bottom-8 bottom-0 md:-top-18 z-30 p-3  shadow-xl border-2 left-0 md:-left-10 text-sm whitespace-normal">Your account is locked. You have reached the  tolerance limit of 4 hour late. To start your attendance record, you need to activate your account and provide the reason for your tardiness.</div>
               </button>               
               @endif   
              @elseif(auth()->user()->is_active != 1 && $schedule != null)
                @if(Carbon\Carbon::parse($schedule->shift->time_in)->diffInMinutes($now) >= 60)
                <button  class="relative bg-gradient-to-r from-red-400 to-purple-700 duration-200 opacity-80 hover:opacity-100 px-4 py-4 text-lg font-semibold tracking-wider px-6  text-white rounded-xl shadow-xl focus:outline-none w-full weekly-trigger"><i class="fas fa-lock"></i> Account is Locked
                  <div class="absolute weekly-target bg-white rounded-lg text-gray-700 md:-bottom-8 bottom-0 md:-top-18 z-30 p-3  shadow-xl border-2 left-0 md:-left-10 text-sm whitespace-normal">Your account is locked. You have reached the  tolerance limit of 1 hour late. To start your attendance record, you need to activate your account and provide the reason for your tardiness.</div>
                </button>  
                @else
                <button  class="relative bg-gradient-to-r from-red-400 to-purple-700 duration-200 opacity-80 hover:opacity-100 px-4 py-4 text-lg font-semibold tracking-wider px-6  text-white rounded-xl shadow-xl focus:outline-none w-full weekly-trigger"><i class="fas fa-lock"></i> Account is Locked
                  <div class="absolute weekly-target bg-white rounded-lg text-gray-700 md:-bottom-8 bottom-0 md:-top-18 z-30 p-3  shadow-xl border-2 left-0 md:-left-10 text-sm whitespace-normal">Your account is locked. You are late from the assigned shift. To start your attendance record, you need to activate your account and provide the reason for your tardiness. </div>
                </button>  
                @endif
              @elseif($schedule != null && ($schedule->status == 'Working'))
              <div class="grid grid-cols-2 items-center gap-4" x-data="{ showModalPause: @entangle('modalPause'), showModalStop: @entangle('modalStop') }" @keydown.escape="showModalPause = false" x-cloak>
                <button @click="showModalPause = true" class="bg-gradient-to-r from-green-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl font-semibold tracking-wider px-6  text-white rounded-xl shadow-xl focus:outline-none "><i class="fas fa-pause-circle"></i><br>Pause</button>
                <button @click="showModalStop = true" class=" bg-red-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl font-semibold tracking-wider px-6  text-white rounded-xl shadow-xl focus:outline-none "><i class="far fa-stop-circle"></i><br> Stop</button>
                <!-- MODAL PAUSE -->
                <div class="overflow-auto" style="background-color: rgba(0,0,0,0.5)" x-show="showModalPause" :class="{ 'fixed inset-0 z-50 flex items-center justify-center': showModalPause }">
                <!--Dialog-->
                <div class="bg-white mx-auto rounded shadow-lg pt-4 text-left w-11/12 md:w-8/12 lg:w-4/12" x-show="showModalPause" @click.away="showModalPause = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" >

                    <!--Title-->
                    <div class="flex justify-between items-center px-5 border-b pb-2">
                      <p class="text-2xl font-semibold text-gray-700">Pause Recording</p>
                      <div class="cursor-pointer z-50" @click="showModalPause = false">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                          <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                      </div>
                    </div>

                    <!-- content -->

                      <div class="bg-white px-6 pt-5 pb-4  max-w-8xl ">
                         <div wire:loading wire:target="type_pause" class="px-3 text-base md:text-lg text-gray-700"> 
                          <i class="fas fa-circle-notch animate-spin"></i> 
                          <label class="animate-pulse"">Building form.. </label> 
                        </div>
                        <div class=""wire:loading.remove wire:target="type_pause">
                          <div class="mb-4">
                              <label for="formTask" class="block text-gray-500 text-sm font-semibold mb-2">Pause Type</label>
                              <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline mb-1" id="formTask" wire:model="type_pause">
                                  <option hidden>Choose one</option>
                                  @if($schedule->status == 'Overtime')
                                      <option value="Break">Break</option>
                                      <option>New Task</option>                               
                                  @else      
                                      <option value="Break">Permission with Substitute</option>
                                      <option value="Permission">Permission without Substitute</option> 
                                      <option>New Task</option>                                 
                                  @endif
                              </select>
                              @error('type_pause') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                          </div>
                          @if ($type_pause =='Break' OR $type_pause =='New Task' OR $type_pause =='Permission')
                          <div class="mb-4">
                              <label for="formTask" class="block text-gray-500 text-sm font-semibold mb-2">@if($type_pause == 'New Task')Task @else Reason @endif</label>
                              <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTask" wire:model="task" required>
                              @error('task') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                                                  
                          </div>
                          @endif
                          @if($type_pause == 'Break')      
                              <label class="mt-1 text-gray-500 font-base italic ">
                                  *Izin meninggalkan pekerjaan maks 4 jam.
                              </label>
                          @elseif($type_pause == 'Permission')
                              <div class="flex space-x-2">
                              <label for="formIsCancelOrder" class="block text-gray-500 text-sm font-semibold ">Automatically stop recording when end of shift?</label>
                              <input type="checkbox" class="shadow appearance-none hover:pointer border rounded-md w-5 h-5 text-orange-500 leading-tight focus:outline-none focus:shadow-outline" id="formIsCancelOrder" wire:model="checkAutoStop" placeholder="fill in here...">
                              </div>
                              @error('is_cancel_order') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                          @endif

                          @if($type_pause == 'New Task')
                          <div class="mb-4">
                              <label for="formTaskDesc" class="block text-gray-500 text-sm font-semibold mb-2">Task Description</label>
                              <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTaskDesc" wire:model="task_desc">
                              @error('task_desc') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                          </div>
                          @endif
                        </div>
                      </div>

                      <!--Footer-->
                      <div class="flex md:flex-row flex-col justify-end py-3 bg-gray-100 space-x-0 space-y-2 md:space-y-0 md:space-x-4 px-4  items-center">
                        <button class="bg-transparent py-2 px-4 rounded-lg text-gray-500 hover:bg-white hover:text-gray-700 cursor-pointer font-semibold tracking-wider border border-gray-400 rounded-lg bg-white" @click="showModalPause = false">Cancel</button>
                        <button class="bg-blue-500 py-2 px-5 rounded-lg md:w-max w-full text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none" @click="$wire.pauseOn()" wire:loading.remove wire:target="pauseOn">@if($type_pause == 'New Task') Start New Task @else Pause @endif</button>
                        <button class="modal-close bg-blue-500 py-2 px-5 rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none animate-pulse" wire:loading wire:target="pauseOn" readonly>Processing..</button>
                      </div>

                  </div>
                  <!--/Dialog -->
                </div><!-- /Overlay -->

                <!-- MODAL STOP -->
                <div class="overflow-auto" style="background-color: rgba(0,0,0,0.5)" x-show="showModalStop" :class="{ 'fixed inset-0 z-50 flex items-center justify-center': showModalStop }">
                <!--Dialog-->
                <div class="bg-white mx-auto rounded shadow-lg pt-4 text-left w-11/12 md:w-8/12 lg:w-4/12" x-show="showModalStop" @click.away="showModalStop = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" >

                    <!--Title-->
                    <div class="flex justify-between items-center px-5 border-b pb-2">
                      <p class="text-2xl font-semibold text-gray-700">Stop Recording</p>
                      <div class="cursor-pointer z-50" @click="showModalStop = false">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                          <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                      </div>
                    </div>

                    <!-- content -->

                      <div class="bg-white px-6 pt-5 pb-4  max-w-8xl ">
                        <div class="">
                          @if($now < Carbon\Carbon::parse($shift->time_out))  
                          <div class="flex-col space-y-1 text-left">      
                            <label class="text-red-600 tracking-wide text-xs md:text-sm "><label class="font-semibold">Warning</label>: Stopped recording before <br class="sm:hidden inline-block">  shift over</label>
                            <div class="flex space-x-2 text-gray-700 items-center pr-4 ">
                              <label class="font-base text-xs md:text-sm tracking-wide font-semibold">Reason</label>
                              <input type="text" wire:model="note"  class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline text-sm border-gray-200 bg-gray-200 focus:outline-none focus:bg-white tracking-wide" placeholder="Fill your reason.." required>
                              @error('note') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                          </div>   
                          @endif
                          <div class="border md:shadow-md rounded-lg text-white px-1 md:px-2 py-2">
                            <p class="text-xs md:text-sm text-gray-700 text-left">
                              Are you sure you want to stop recording?<br> This action cannot be undone.
                            </p>
                          </div>
                        </div>
                      </div>

                      <!--Footer-->
                      <div class="flex md:flex-row flex-col justify-end py-3 bg-gray-100 space-x-0 space-y-2 md:space-y-0 md:space-x-4 px-4  items-center">
                        <button class="bg-transparent py-2 px-4 rounded-lg text-gray-500 hover:bg-white hover:text-indigo-600 cursor-pointer font-semibold tracking-wider border border-gray-400 rounded-lg bg-white" @click="showModalStop = false">Cancel</button>
                        <button class="bg-blue-500 py-2 px-5 rounded-lg md:w-min w-full text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none" @click="$wire.stopOn()" wire:loading.remove wire:target="stopOn">Stop</button>
                        <button class="modal-close bg-blue-500 py-2 px-5 rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none animate-pulse" wire:loading wire:target="stopOn" readonly>Processing..</button>
                      </div>

                  </div>
                  <!--/Dialog -->
                </div><!-- /Overlay --> 
               </div>
              @elseif($schedule != null && $schedule->status == 'Pause')

              <button @if($tasking) wire:click="showResume()" @else wire:click="resumeOn()" @endif class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6  text-white rounded-xl shadow-xl focus:outline-none w-full">
                <i class="fas fa-history"  wire:loading.remove  wire:target="resumeOn"></i>
                <i class="fas fa-circle-notch animate-spin" wire:loading wire:target="resumeOn"></i> Resume Record</button>
              <label class="flex items-center mt-3 w-auto">
                <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600 rounded-md" wire:model="tasking" @if($tasking) wire:click="$set('tasking',false)"  @else wire:click="$set('tasking',true)" @endif><span class="ml-2 text-gray-700"> Write a journal? </span>
              </label>
              @elseif($schedule != null && $schedule->status == 'Not sign in' && auth()->user()->is_active == 1 )
              <button @if($tasking) wire:click="showStart()" @else wire:click="startOn()" @endif class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6 w-full text-white rounded-xl shadow-xl focus:outline-none " wire:loading.remove wire:target="startOn">
                <i class="far fa-clock" ></i>
                <i class="fas fa-circle-notch animate-spin" wire:loading wire:target="startOn"></i> Start Record</button>             
              <button class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6 w-full text-white rounded-xl shadow-xl focus:outline-none "  wire:loading wire:target="startOn" readonly>               
                <i class="fas fa-circle-notch animate-spin"></i> Starting Record..
              </button> 

              <label class="flex items-center mt-3 w-auto">
                <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600 rounded-md"  wire:model="tasking" @if($tasking) wire:click="$set('tasking',false)"  @else wire:click="$set('tasking',true)" @endif><span class="ml-2 text-gray-700"> Write a journal?    </span>
              </label>
              @elseif($schedule != null && $schedule->status == 'Not sign in' && auth()->user()->is_active == 1)
              <button class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6 w-full text-white rounded-xl shadow-xl focus:outline-none "><i class="far fa-clock"></i> Not ready to Record</button>             
              <label class="flex items-center mt-3 w-auto">
                Ready to start at : {{Carbon\Carbon::parse($schedule->shift->time_in)->subMinute(10)->format('H:i')}} 
              </label>
              @elseif($schedule != null && ($schedule->status == 'Done'))
               <button  class="relative bg-gradient-to-r from-blue-400 to-blue-700 duration-200 opacity-80 hover:opacity-100 px-4 py-4 text-lg font-semibold tracking-wider px-6 text-white rounded-xl shadow-xl focus:outline-none w-full weekly-trigger"><i class="fas fa-user-check"></i> Recording Complete     
                       
               </button>     
              @elseif($schedule != null && $schedule->status != 'Done' && $schedule->status != 'Rest' && $schedule->status != 'Working' && $schedule->status != 'Not sign in')

                <button class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 px-4 py-4 xl:text-2xl lg:text-xl text-2xl lg:font-base xl:font-semibold tracking-wider px-6 w-full text-white rounded-xl shadow-xl focus:outline-none "><i class="far fa-clock"></i> Today is {{$schedule->status}}</button>    
              @else
               <button  class="border-4 border-blue-600 duration-200 opacity-80 hover:opacity-100 py-4 text-xl font-bold tracking-wider px-6  text-gray-600 rounded-xl shadow-md focus:outline-none w-full"><i class="far fa-smile-beam"></i> No Schedule Today.</button>             
              @endif              
            
            
              <div wire:loading wire:target="showPause,showStop,showResume,showStart,showOvertime,starton" class="overflow-x-hidden overflow-y-hidden fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center">
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
                 
            <div class="absolute">
              @if($schedule != null)
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
                    
                    <div class="bg-white overflow-hidden border-1 sm:rounded-2xl p-4 md:w-full w-11/12 md:mx-0 mx-auto rounded-lg duration-300 hover:shadow-lg border md:border-4 border-white">

                      <div class="grid md:grid-cols-6 items-center gap-2">
                        <div class="md:col-span-3 col-span-2 flex flex-row justify-between md:text-xl text-sm xl:text-2xl text-gray-800 leading-none font-semibold md:border-0 border-b pb-2 ">
                          <div class="flex flex-col">
                          <h2 class="text-3xl leading-none ">Detail</h2>
                          @if($schedule != null)
                          <h2 class="md:text-sm xl:text-base text-gray-500 font-base md:mt-0 mt-1">Start Tracking at <span class="text-gray-600">
                            @if($schedule->started_at != null)<span class="md:hidden block "></span> 
                           {{ Carbon\Carbon::parse($schedule->started_at)->format('H:i, d F Y') }}@endif</span></h2>@endif
                          </div>
                          <div class="block md:hidden flex flex-col md:text-sm text-xs xl:text-base border-2 rounded-xl px-2 py-1 text-white leading-none font-semibold bg-gradient-to-r from-green-400 to-blue-500 shadow-lg ">
                            <div class="font-xs leading-tight flex justify-between flex-auto space-x-2"><label>WFO</label><label class="text-gray-50">{{$wfo}}</label></div>
                            <div class="font-xs leading-tight flex justify-between flex-auto space-x-2"><label>WFH</label><label class="text-gray-50">{{$wfh}}</label></div>
                            
                            <div class="font-xs leading-tight flex justify-between flex-auto space-x-2"><label>BT</label><label class="text-right flex-auto text-gray-50">{{$business_travel}}</label></div>
                          </div>
                        </div>
                        <div class="flex flex-col text-xl   leading-none font-semibold md:text-left text-center hover:text-red-500 duration-300 py-2 px-2 text-gray-400 border-r border-gray-300">
                         <h2 class="text-base text-gray-800 leading-none">{{$unproductive}}</h2>
                         <h2 class="md:text-sm bg-red xl:text-md leading-none text-sm  tracking-wide font-base">Unproductive</h2>
                       </div>                       
                          <div class="flex flex-col text-xl   leading-none font-semibold md:text-left text-center hover:text-green-500 duration-300 py-2 px-2 text-gray-400 ">
                         <h2 class="text-base text-gray-800 leading-none">{{$time}}</h2>
                         <h2 class="md:text-sm bg-red xl:text-md leading-none text-sm  tracking-wide font-base">Productive</h2>
                       </div>
                      <div class="hidden md:block flex flex-col md:text-xs xl:text-sm  rounded-xl px-3 py-2 text-white  leading-none font-semibold bg-gradient-to-r from-green-400 to-blue-500 shadow-lg ">
                        <h2 class="font-xs leading-tight flex justify-between flex-auto">WFO<span class="text-gray-50">{{$wfo}}</span></h2>
                        <h2 class="font-xs leading-tight flex justify-between flex-auto">WFH<span class="text-gray-50">{{$wfh}}</span></h2>
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
                    $weekly_work = $schedules->whereBetween('date',[$startWeek->format('Y-m-d'),$endWeek->format('Y-m-d')]);
                    $sumWeeklyHour = $weekly_work->sum(\DB::raw('workhour + timer'));
                    $seconds = intval($sumWeeklyHour%60);
                    $total_minutes = intval($sumWeeklyHour/60);
                    $minutes = $total_minutes%60;
                    $hours = intval($total_minutes/60);
                    $time_weekly = $hours."h ".$minutes."m";
                  @endphp
                    <div class="bg-white overflow-hidden rounded-lg p-4 flex flex-col border md:w-full w-11/12 mx-auto md:mx-0 duration-300 hover:shadow-lg">
                      <div class="grid md:grid-cols-6  grid-rows-2 items-center gap-2">
                        <div class="col-span-3 flex flex-col text-2xl text-gray-800 leading-none font-semibold">
                          <h2 class="text-3xl leading-none">Recent</h2>
                          <h2 class="text-sm md:text-lg text-gray-500 font-base ">You Have <span class="text-orange-500">{{$schedules->count()}}</span> Activities on this month</h2>
                        </div>
                        <div class="flex flex-col text-xl text-left text-gray-800 leading-none font-semibold">
                         <h2 >
                            {{$schedules->filter(function ($item) {
                               return $item->status == 'Working' || $item->status == 'Done' || $item->status == 'Rest';
                            })->count()}}
                         </h2>
                         <h2 class="text-sm md:text-base border-t-2 border-gray-500 text-gray-500 font-base">Attend</h2>
                       </div>
                        <div class="flex flex-col text-xl text-left text-gray-800 leading-none font-semibold">
                         <h2 >
                            {{$schedules->filter(function ($item) {
                               return $item->status != 'Working' && $item->status != 'Done' && $item->status != 'Rest';
                            })->count()}}
                         </h2>
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

                      </div>
                      </div>
                      <div class="scroll hide-scroll flex flex-row grid grid-flow-col auto-cols-max items-start font-semibold md:mt-0 mt-4 gap-3 overflow-x-auto cursor-pointer" id="flavoursContainer">
                        @foreach($schedules as $scheduleUser)
                        @php
                          $seconds = intval(($scheduleUser->workhour + $scheduleUser->timer)%60);
                          $total_minutes = intval(($scheduleUser->workhour + $scheduleUser->timer)/60);
                          $minutes = $total_minutes%60;
                          $hours = intval($total_minutes/60);
                          $timeMonthly = $hours."h ".$minutes."m";
                          $cekactive = Carbon\Carbon::parse($scheduleUser->date)->format('d');
                          if($endWeek->format('d')<$startWeek->format('d')){
                            $passing = 1;  
                          }else{
                            $passing =0;
                            }
                        @endphp
                         
                      <div class="flex flex-col px-4 py-3 text-center w-28 h-28 md:w-36 md:h-36 items-center hover:bg-white  duration-200 cursor-pointer rounded-bl-3xl rounded-tr-3xl justify-between border-2  @if(($cekactive>=$startWeek->format('d') && $cekactive<=$endWeek->format('d'))OR($passing==1 && $cekactive<=$startWeek->format('d'))) border-gray-500 bg-white @else border-gray-400 bg-gray-100 @endif " >
                        <div class=" flex-col flex mb-2 ">
                          <label class="font-bold leading-none text-xl md:text-3xl text-gray-700">{{$cekactive}}</label>
                          <label class="text-xs md:text-sm font-base text-white leading-none bg-orange-500 px-2 py-1 rounded-md">{{Carbon\Carbon::parse($scheduleUser->date)->format('l')}}</label>
                        </div>
                        @if($scheduleUser->status == 'Working' || $scheduleUser->status == 'Done')
                      
                        <div class="text-gray-700 text-xs ">{{$timeMonthly}}</div>
                        
                         <div class="text-green-500 flex leading-tight items-center text-sm bg-white w-full justify-center py-1 rounded-lg">
                          <i class="fas fa-check-circle mr-1"></i>Attend
                        </div>
                        @elseif($scheduleUser->status == 'Absent')
                        <div class="text-red-500 flex leading-tight items-center text-sm bg-white w-full justify-center py-1 rounded-lg">
                          <i class="fas fa-times-circle mr-1"></i>Absent
                        </div>
                         @elseif($scheduleUser->status == 'Not sign in' )
                        <div class="text-indigo-500 flex leading-tight items-center text-sm bg-white w-full justify-center py-1 rounded-lg">
                          <i class="fas fa-walking mr-1"></i>Coming
                        </div>
                        @elseif($scheduleUser->status == 'Pause')
                        <div class="text-purple-500 flex leading-tight items-center text-sm bg-white w-full justify-center py-1 rounded-lg">
                          <i class="fas fa-pause-circle mr-1"></i>{{$scheduleUser->status}}
                        </div>
                        @else
                        <div class="text-gray-700 flex leading-tight items-center text-sm bg-white w-full justify-center py-1 rounded-lg">
                          <i class="fas fa-house-user mr-1"></i></i>{{$scheduleUser->status}}
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

      const flavoursContainer = document.getElementById('flavoursContainer');
      const flavoursScrollWidth = flavoursContainer.scrollWidth;

      window.addEventListener('load', () => {
        self.setInterval(() => {
          if (flavoursContainer.scrollLeft !== flavoursScrollWidth) {
            flavoursContainer.scrollTo(flavoursContainer.scrollLeft + 1, 0);
          }
        }, 15);
      });
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

    function showPosition() {
      /*
        if(navigator.geolocation) {
            //navigator.geolocation.getCurrentPosition(getLocation);
            navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            console.log('Lat : '+latitude+" & Long : "+longitude);
              window.livewire.emit('set:latitude-longitude', latitude, longitude);
            },function error(msg) {alert('Please enable your GPS position feature.');}
            , {
                maximumAge: 600000,
                timeout: 10000,
                enableHighAccuracy: true
            });
        } else {
            alert("Sorry, your browser does not support HTML5 geolocation.");
        }*/
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
