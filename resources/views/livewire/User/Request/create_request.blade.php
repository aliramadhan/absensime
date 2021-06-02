<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400 ">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
             <div class=" py-4 px-6 sm:flex border-b flex ">
                <h1 class=" font-semibold text-2xl text-gray-600">Request Form <span class="text-orange-500">{{$type}}</span></h1>                 
            </div>
                <div class="bg-white px-4 pb-4 sm:p-6 sm:pb-4 font-semibold">

                    <div class=""> 
                       
                        <div class="mb-4 px-2">
                            <label for="formType" class="block text-gray-500 text-sm  mb-2">Request Type</label>
                            <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formType" wire:model="type">
                                <option hidden>Choose here</option>
                                @foreach($leaves as $leave)
                                    <option>{{$leave->name}}</option>
                                @endforeach
                                <option>Activated Record</option>
                                <option>Sick</option>
                                <option>Overtime</option>
                                <option>Remote</option>
                                <option>Excused</option>
                            </select>
                            @error('type') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @if($type != 'Activated Record')
                            @if($type  == 'Sick')
                            <div class="mb-4 flex ">
                            <div class="px-2 flex-auto">
                                <label for="formStartRequestDate" class="block text-gray-500 text-sm  mb-2">From</label>
                                <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStartRequestDate" wire:model="startRequestDate" @if($type != 'Overtime')min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif>
                                @error('startRequestDate') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="flex-auto px-2">
                                <label for="formStopRequestDate" class="block text-gray-500 text-sm  mb-2">To</label>
                                <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStopRequestDate" wire:model="stopRequestDate" @if($type != 'Overtime')min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif>
                                @error('stopRequestDate') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            </div>
                            @else
                            <div class="mb-4 px-2">
                                <label for="formDate" class="block text-gray-500 text-sm  mb-2">Date </label>
                                <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDate" wire:model="date" @if($type != 'Overtime')min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" @endif>
                                @error('date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            @endif
                        @endif
                        <div class="mb-4 px-2">
                            <label for="formDesc" class="block text-gray-500 text-sm  mb-2">Reason </label>
                            <input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDesc" wire:model="desc" placeholder="Fill in here">
                            @error('desc') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @if($type == 'Overtime')
                        <div class="mb-4 px-2">
                            <label for="formTime" class="block text-gray-500 text-sm  mb-2">Duration (minute) :</label>
                            <input type="number" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTime" wire:model="time_overtime" placeholder="duration in minutes">
                            @error('time_overtime') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @endif
                        @if($type != 'Overtime')
                        <div class="mb-4 px-2 flex items-center gap-2">
                            <label for="formIsCancelOrder" class="block text-gray-500 text-sm ">Cancel Order Catering ?</label>
                            <input type="checkbox" class="shadow appearance-none hover:pointer border rounded-md w-5 h-5 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formIsCancelOrder" wire:model="is_cancel_order" placeholder="fill in here...">
                            @error('desc') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @endif
                    </div>
                </div>
    
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button wire:click.prevent="createRequest()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
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