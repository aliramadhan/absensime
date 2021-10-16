<div>
    <div class="bg-white shadow">
        <div class="flex gap-4 justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 " x-data="{ 'showModal': false }" @keydown.escape="showModal = false" x-cloak>
             <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Shift Work') }}
            </h2>

            @if($isModal == 'create')
                @include('livewire.Admin.Shift.create')    
            @elseif($isModal == 'edit')
                @include('livewire.Admin.Shift.create')
            @elseif($isModal == 'delete')
                @include('livewire.Admin.Shift.delete')
            @endif
            
              <div class="overflow-auto" style="background-color: rgba(0,0,0,0.5)" x-show="showModal" :class="{ 'fixed inset-0 z-10 flex items-center justify-center': showModal }">
                <!--Dialog-->
                <div class="bg-white mx-auto rounded shadow-lg pt-4 text-left w-4/12 " x-show="showModal" @click.away="showModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" >

                    <!--Title-->
                    <div class="flex justify-between items-center px-5 border-b pb-2">
                        <p class="text-2xl font-semibold text-gray-700">Add Shift</p>
                        <div class="cursor-pointer z-50" @click="showModal = false">
                            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- content -->
                    <form>

                    <div class="bg-white px-6 pt-5 pb-4  max-w-8xl ">
                        <div class="">
                            <div class="mb-4">
                                <label for="formNameShift" class="block text-gray-500 text-sm font-semibold mb-2">Shift Name:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formNameShift" wire:model="name" placeholder="fill here for Shift name">
                                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="flex flex-row justify-between gap-4">
                            <div class="mb-4 flex-auto">
                                <label for="formTimeInShift" class="block text-gray-500 text-sm font-semibold mb-2">Time In:</label>
                                <input type="time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTimeInShift" wire:model="time_in">
                                @error('time_in') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                                <div class="mb-4 flex-auto">
                                    <label for="formTimeOutShift" class="block text-gray-500 text-sm font-semibold mb-2">Time Out:</label>
                                    <input type="time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTimeOutShift" wire:model="time_out">
                                    @error('time_out') <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="flex justify-end py-3 bg-gray-100 space-x-4 px-4  items-center">
                        <button class="bg-transparent py-2 px-4 rounded-lg text-gray-500 hover:bg-white hover:text-indigo-400 font-semibold tracking-wider border border-gray-400 rounded-lg bg-white" @click="showModal = false">Cancel</button>
                        <button class="modal-close bg-blue-500 py-2 px-5 rounded-lg text-white hover:bg-indigo-400 font-semibold tracking-wider" @click="$wire.store()">Save</button>
                    </div>
                    </form>

                </div>
                <!--/Dialog -->
              </div><!-- /Overlay -->
             <button @click="showModal = true" class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:px-6 px-4 md:py-2 py-3 flex items-center gap-2 text-lg font-semibold tracking-wider text-white rounded-xl shadow-md focus:outline-none "><i class="fas fa-plus"></i><span class="hidden md:block">New Shift</span></button>  

             <div wire:loading wire:target="create,closeModal" class="overflow-x-hidden overflow-y-hidden fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center">
                 <section class="h-full w-full border-box  transition-all duration-500 flex bg-gray-500 opacity-75"    >   
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
                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

               
                <livewire:admin-datatable-shift
                    searchable="name"
                    exportable
                 />
                 
            </div>
        </div>
    </div>
</div>