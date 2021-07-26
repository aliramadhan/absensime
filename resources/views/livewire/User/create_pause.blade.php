<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-start justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class=" py-4 px-6 sm:flex border-b flex ">
                <h1 class=" font-semibold text-2xl text-gray-600">Pause Recording Form</h1>                 
                </div>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        <div class="mb-4">
                            <label for="formTask" class="block text-gray-500 text-sm font-semibold mb-2">Type</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTask" wire:model="type_pause">
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
                            @error('type') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="formTask" class="block text-gray-500 text-sm font-semibold mb-2">@if($type_pause == 'New Task')Task @else Reason @endif</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTask" wire:model="task">
                            @error('task') <span class="text-red-500">{{ $message }}</span>@enderror
                                                
                        </div>
                        @if($type_pause == 'Break')      
                            <label class="mt-1 text-gray-600 font-semibold">
                                (This type must <span class="text-orange-500">replace</span> the elapsed hours)
                            </label>
                        @elseif($type_pause == 'Permission')
                            <label for="formIsCancelOrder" class="block text-gray-500 text-sm  ">automatically stop recording when end of shift</label>
                            <input type="checkbox" class="shadow appearance-none hover:pointer border rounded-md w-5 h-5 text-orange-500 leading-tight focus:outline-none focus:shadow-outline" id="formIsCancelOrder" wire:model="checkAutoStop" placeholder="fill in here...">
                            @error('is_cancel_order') <span class="text-red-500">{{ $message }}</span>@enderror
                        @endif

                        @if($type_pause == 'New Task')
                        <div class="mb-4">
                            <label for="formTaskDesc" class="block text-gray-500 text-sm font-semibold mb-2">Task Description</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTaskDesc" wire:model="task_desc">
                            @error('task_desc') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @endif
                    </div>
                </div>
    
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    
                    @if($type_pause == 'New Task')
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="pauseOn()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-6 py-2 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5 items-center">
                        <i class="fas fa-history mr-2 -ml-2"></i> Start New Task
                        </button>
                    </span>
                    @else
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="pauseOn()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-6 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow transition ease-in-out duration-150 sm:text-sm sm:leading-5 items-center">
                        <i class="fas fa-pause-circle mr-2 -ml-2"></i> Pause
                        </button>
                    </span>
                    @endif
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