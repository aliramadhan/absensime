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
    <div class="flex gap-4 justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
         <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Manage Division') }}
        </h2>
       @if($isModal == 'create')
		@include('livewire.Admin.create_division')
	@endif
	
        <button wire:click="$set('isModal', 'create')" class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:px-6 px-4 py-2 text-lg font-semibold tracking-wider text-white rounded-lg md:rounded-xl shadow-md focus:outline-none flex items-center gap-2"><i class="fas fa-plus"></i><span class="hidden md:block">New Division</span></button> 

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