<div class="bg-white shadow">
    <div class="flex justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Working Request') }}
        </h2>
        @if($isModal == 'Create')
            @include('livewire.User.Request.create_request')
        @endif

        <div class="flex gap-2" x-data="{ showModal: @entangle('isModal') }" @keydown.escape="showModal = false" x-cloak>
         <!--  <button wire:click="showCreateRequest()" class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:px-5 px-4 py-4 md:py-2 text-lg font-semibold tracking-wider text-white md:rounded-xl rounded-full shadow-md focus:outline-none items-center flex-row gap-3 flex"><i class="fas fa-paper-plane" ></i><span class="hidden md:block">Create Request</span></button> -->
          <button class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:px-6 px-4 md:py-2 py-3 flex items-center gap-2 text-lg font-semibold tracking-wider text-white rounded-xl shadow-md focus:outline-none" @click="showModal = true"><i class="fas fa-plus"></i> <span class="hidden md:block">Create Request</span></button>
          
          <div class="overflow-auto" style="background-color: rgba(0,0,0,0.5)" x-show="showModal" :class="{ 'fixed inset-0 z-30 flex items-center justify-center': showModal }">
            <!--Dialog-->
            <div class="bg-white mx-auto rounded shadow-lg pt-4 text-left w-11/12 md:w-8/12 lg:w-4/12 " x-show="showModal"  x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" >
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
        <div wire:loading wire:target="showCreate,closeModal" class="overflow-x-hidden overflow-y-hidden fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center">
           <section class="h-full w-full border-box  transition-all duration-500 flex bg-gray-500 opacity-75">   
              <div class="text-6xl text-white m-auto text-center">        
                 <i class="fas fa-circle-notch animate-spin"></i>
             </div>
         </section>
        </div>  
    
    </div>
</div>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            
            <livewire:request-datatable-user
            exportable
            searchable="desc"
            />
        </div>
    </div>
</div>
<script>
    window.addEventListener('alert', event => { 
       toastr[event.detail.type](event.detail.message, 
           event.detail.title ?? '') toastr.options = {
        "closeButton": true,
        "progressBar": true,
    }
})
</script>


