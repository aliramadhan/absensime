<div class="bg-white shadow">
    
    @if (session()->has('success'))
    
      <div class="flex fixed bottom-10 " x-data="{ showNotif: true }" x-show="showNotif" x-transition:leave="transition duration-100 transform ease-in" x-transition:leave-end="opacity-0 scale-90" x-init="setTimeout(() => showNotif = false, 5000)">
        <div class="m-auto">
          <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-xl">
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
      <div class="flex fixed bottom-10 " x-data="{ showNotif: true }" x-show.transition="showNotif" x-init="setTimeout(() => showNotif = false, 5000)">
        <div class="m-auto">
          <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-xl">
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
    <div class="flex gap-4 justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 " x-data="{ 'showModal': false }" @keydown.escape="showModal = false" x-cloak>
         <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Manage Division') }}
        </h2>
       @if($isModal == 'create')
		@include('livewire.Admin.create_division')
	@endif
	      <div class="overflow-auto" style="background-color: rgba(0,0,0,0.5)" x-show="showModal" :class="{ 'fixed inset-0 z-10 flex items-center justify-center': showModal }">
          <!--Dialog-->
          <div class="bg-white mx-auto rounded shadow-lg pt-4 text-left w-4/12 " x-show="showModal" @click.away="showModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" >

              <!--Title-->
              <div class="flex justify-between items-center px-5 border-b pb-2">
                  <p class="text-2xl font-semibold text-gray-700">Add Division</p>
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
                          <label for="formName" class="block text-gray-500 text-sm font-semibold mb-2">Division Name:</label>
                          <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formName" wire:model="name">
                          @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                      </div>
                      <div class="mb-4 flex-auto">
                          <label for="formEmail" class="block text-gray-500 text-sm font-semibold mb-2">Desc:</label>
                          <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formEmail" wire:model="desc">
                          @error('desc') <span class="text-red-500">{{ $message }}</span>@enderror
                      </div>
                  </div>
              </div>

              <!--Footer-->
              <div class="flex justify-end py-3 bg-gray-100 space-x-4 px-4  items-center">
                  <button class="bg-transparent py-2 px-4 rounded-lg text-gray-500 hover:bg-white hover:text-indigo-400 font-semibold tracking-wider border border-gray-400 rounded-lg bg-white" @click="showModal = false">Cancel</button>
                  <button class="modal-close bg-blue-500 py-2 px-5 rounded-lg text-white hover:bg-indigo-400 font-semibold tracking-wider" @click="$wire.storeDivision()">Save</button>
              </div>
              </form>

          </div>
          <!--/Dialog -->
        </div><!-- /Overlay --> 
        <button @click="showModal = true" class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:px-6 px-4 py-2 text-lg font-semibold tracking-wider text-white rounded-lg md:rounded-xl shadow-md focus:outline-none flex items-center gap-2"><i class="fas fa-plus"></i><span class="hidden md:block">New Division</span></button> 

         <div wire:loading wire:target="create,closeModal,import" class="overflow-x-hidden overflow-y-hidden fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center">
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
    <livewire:tables.list-division exportable/>
</div>
</div></div>