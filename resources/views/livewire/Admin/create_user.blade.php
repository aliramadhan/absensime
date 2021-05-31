<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class=" py-4 px-6 sm:flex border-b flex ">
                <h1 class=" font-semibold text-2xl text-gray-600">Add User</h1>                 
                </div>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        <div class="mb-4">
                            <label for="formName" class="block text-gray-500 text-sm font-semibold mb-2">Employee Name:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formName" wire:model="name">
                            @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4 flex-auto">
                            <label for="formEmail" class="block text-gray-500 text-sm font-semibold mb-2">Email:</label>
                            <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formEmail" wire:model="email">
                            @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4 flex-auto flex gap-4">
                        <div class="flex-auto">
                            <label for="formRole" class="block text-gray-500 text-sm font-semibold mb-2">Role:</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formRole" wire:model="role">
                                <option hidden>Choose Here</option>
                            	<option>Employee</option>
                            	<option>Manager</option>
                            </select>
                            @error('role') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div  class="flex-auto">
                            <label for="formDivision" class="block text-gray-500 text-sm font-semibold mb-2">Division:</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formDivision" wire:model="division">
                                <option hidden>Choose Here</option>
                                @foreach($divisions as $thedivision)
                                    <option>{{$thedivision->name}}</option>
                                @endforeach
                            </select>
                            @error('division') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        </div>
                        <div class="mb-4 flex-auto flex gap-4">
                        <div class="flex-auto">
                            <label for="formNumber" class="block text-gray-500 text-sm font-semibold mb-2">Number Phone:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formNumber" wire:model="number">
                            @error('number') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="flex-auto">
                            <label for="formAddress" class="block text-gray-500 text-sm font-semibold mb-2">Address:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formAddress" wire:model="address">
                            @error('address') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        </div>
                        <div class="mb-4 flex-auto">
                            <label for="formJoinedAt" class="block text-gray-500 text-sm font-semibold mb-2">Joined At:</label>
                            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formJoinedAt" wire:model="joined_at">
                            @error('joined_at') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
    
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="storeUser()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Save
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Cancel
                        </button>
                    </span>
                </div>
                </form>
            </div>
        </div>
    </div>
