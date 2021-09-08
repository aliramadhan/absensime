<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400 ">
    <div class="flex items-start justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
             <div class=" py-4 px-6 sm:flex border-b flex ">
                <h1 class=" font-semibold text-2xl text-gray-600 flex items-start">Request Form <span class="text-orange-500 ml-2">{{$type}}</span>
                    @if($type=='Record Activation')
                    <span class="bg-gray-600 text-white px-1 rounded-md text-sm shadow-md ml-1">{{$historyLock->count()}} </span>
                    @endif
                </h1>               
            </div>
            <div class="bg-white px-4 md:pb-4 sm:p-6 pb-0 font-semibold">
              
              

                    <div class="mt-2 md:mt-0"> 
                       
                       
                        <div class="mb-4 px-2">
                            <label for="formType" class="block text-gray-500 text-sm  mb-2">Request Type</label>
                            <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formType" wire:model="type" wire:change="updateDescRequest()">
                                <option hidden>Choose here</option>
                                @foreach($leaves as $leave)
                                    <option>{{$leave->name}}</option>
                                @endforeach
                                <!--
                                @if($historyLock->count() > 0)
                                <option>Record Activation</option>
                                @endif
                                -->
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
                            @error('type') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                       
                        @if($type == 'Mandatory')
                            <div class="mb-4 px-2">
                                <label for="formSetUser" class="block text-gray-500 text-sm  mb-2">Select Employee </label>
                                <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formSetUser" wire:model="setUser">
                                    <option hidden>Choose here</option>
                                    @foreach($users as $thisUser)
                                        <option value="{{$thisUser->id}}" >{{$thisUser->name}}</option>
                                    @endforeach
                                </select>
                                @error('setUser') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        @endif
                        @if($type != 'Record Activation')
                            @if($type  == 'Sick' || $type  == 'Permission' || $leaves->contains('name',$type) || $type == 'Remote')
                            <div class="mb-4 flex md:flex-row flex-col">
                            <div class="px-2 flex-auto md:mb-0 mb-4">
                                <label for="formStartRequestDate" class="block text-gray-500 text-sm  mb-2">From</label>
                                <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStartRequestDate" wire:model="startRequestDate" >
                                @error('startRequestDate') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="flex-auto px-2">
                                <label for="formStopRequestDate" class="block text-gray-500 text-sm  mb-2">To</label>
                                <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStopRequestDate" wire:model="stopRequestDate">
                                @error('stopRequestDate') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            </div>
                            @else
                            <div class="mb-4 px-2">
                                <label for="formDate" class="block text-gray-500 text-sm  mb-2">Date </label>
                                <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDate" wire:model="date" @if($type == 'Change Shift' && $now->lte(Carbon\Carbon::parse('today 8am'))) min="{{Carbon\Carbon::now()->format('Y-m-d')}}" @elseif($type == 'Excused') min="{{Carbon\Carbon::now()->format('Y-m-d')}}" @elseif($type != 'Overtime')min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif>
                                @error('date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            @endif
                        @endif
                        @if($type == 'Change Shift' || $type == 'Mandatory')
                        <div class="mb-4 px-2">
                            <label for="formNewShift" class="block text-gray-500 text-sm  mb-2">New Shift </label>
                            <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formNewShift" wire:model="newShift">
                                <option hidden>Choose here</option>
                                @foreach($shifts as $listShift)
                                    <option value="{{$listShift->id}}" >{{$listShift->name}}</option>
                                @endforeach
                            </select>
                            @error('newShift') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @endif
                        @if($type == 'Record Activation')
                        <!--
                        <div class="mb-4 px-2">
                           <label for="formNewShift" class="block text-gray-500 text-sm  mb-2">Reason</label>
                           <input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" readonly id="formDesc">
                        </div>-->
                        <div class="mb-4 px-2">
                            <label for="formDesc" class="block text-gray-500 text-sm  mb-2">Reason </label>
                                <input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" wire:model="desc" id="formDesc" readonly>
                            @error('desc') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>


                         @if($desc == 'Late from the assigned shift' || $desc == 'Reach the tolerance limit of 1 hour late')
                            <div class="mb-4 px-2 flex items-center gap-2">
                                <label for="formIsCancelOrder" class="block text-gray-500 text-sm  ">Permission setengah hari?</label>
                                <input type="checkbox" class="shadow appearance-none hover:pointer border rounded-md w-5 h-5 text-orange-500 leading-tight focus:outline-none focus:shadow-outline" id="formIsCancelOrder" wire:model="is_check_half" placeholder="fill in here......">
                                @error('is_check_half') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        @endif


                        @elseif($type != 'Change Shift' && $type != 'Mandatory' && $type != 'Remote' && $type != '' )
                        <div class="mb-4 px-2">
                            <label for="formDesc" class="block text-gray-500 text-sm  mb-2">Reason </label>
                            <input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDesc" wire:model="desc" placeholder="Fill in here...">
                            @error('desc') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

                        @elseif($type== 'Remote')
                        <div class="mb-4 px-2">
                            <label for="formNewShift" class="block text-gray-500 text-sm  mb-2">Where? </label>
                            <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDesc" wire:model="desc">
                                <option hidden>Choose here</option>                             
                                <option>Malang</option>
                                <option>Luar Malang</option>                                
                            </select>
                        </div>
                        @endif
                        @if($type == 'Overtime')
                        <div class="mb-4 px-2">
                            <label for="formTime" class="block text-gray-500 text-sm  mb-2">Duration (minute) :</label>
                            <input type="number" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTime" wire:model="time_overtime" placeholder="duration in minutes">
                            @error('time_overtime') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @endif
                        @if(($type != 'Overtime' && $type != 'Change Shift' && $type != 'Mandatory')&&($type != 'Record Activation')&&($type != 'Excused')&&($type != ''))
                        <div class="mb-4 px-2 flex items-center gap-2">
                            <label for="formIsCancelOrder" class="block text-gray-500 text-sm  ">Cancel your <span class="text-orange-500">catering</span> order ?</label>
                            <input type="checkbox" class="shadow appearance-none hover:pointer border rounded-md w-5 h-5 text-orange-500 leading-tight focus:outline-none focus:shadow-outline" id="formIsCancelOrder" wire:model="is_cancel_order" placeholder="fill in here......">
                            @error('is_cancel_order') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @elseif($type == 'Change Shift' || $type == 'Mandatory')
                        <div class="mb-4 px-2">
                            <label for="formNewShift" class="block text-gray-500 text-sm  mb-2">Change Catering Shift </label>
                            <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formNewShift" wire:model="newCatering">
                                <option hidden>Choose here</option>
                                <option>Do Nothing!</option>
                                <option>Cancel Order</option>
                                <option>Pagi</option>
                                <option>Siang</option>
                            </select>
                            @error('newCatering') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @endif
                       
                        @if($desc == 'Forget to entry')
                        <div class="mb-4 px-2">
                              <label for="formNewShift" class="block text-gray-500 text-sm  mb-2">Because </label>
                            <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formType" wire:model="typeRequest">
                                <option hidden>Choose here</option>
                                @foreach($leaves as $leave)
                                <option>{{$leave->name}}</option>
                                @endforeach
                                <option>Sick</option>
                                <option>Permission</option>
                                <option>Absent</option>
                            </select>
                        </div>
                            @error('typeRequest') <span class="text-red-500">{{ $message }}</span>@enderror
                            <div class="flex mb-4 space-x-2">
                            <div class="px-2 flex-auto md:mb-0 w-6/12">
                                <label for="formStartRequestDate" class="block text-gray-500 text-sm  mb-2">From</label>
                                <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStartRequestDate" wire:model="dateFrom">
                                @error('dateFrom') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="flex-auto px-2 w-6/12">
                                <label for="formStopRequestDate" class="block text-gray-500 text-sm  mb-2">To</label>
                                <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStopRequestDate"wire:model="dateTo">
                                @error('dateTo') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                             </div>
                            <div class="mb-4 px-2">
                                <label for="formDesc" class="block text-gray-500 text-sm  mb-2">@if($desc == 'Forget to entry') Additional @endif Reason </label>
                                <input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDesc" placeholder="Fill in here..." wire:model="descRequest">
                                @error('descRequest') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        @endif
                    </div>
                </div>
    
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button @if($type == 'Record Activation' && $desc == 'Forget to entry') wire:click.prevent="createActivationWithRequest()" @else wire:click.prevent="createRequest()" @endif wire:click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Send
                            </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        
                        <button wire:click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Cancel
                        </button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>