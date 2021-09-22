<div class="bg-white shadow">
    @if (session()->has('success'))
    
      <div class="flex fixed bottom-10 z-20" x-data="{ showNotif: true }" x-show="showNotif" x-transition:leave="transition duration-100 transform ease-in" x-transition:leave-end="opacity-0 scale-90" x-init="setTimeout(() => showNotif = false, 5000)">
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
      <div class="flex fixed bottom-10 z-20" x-data="{ showNotif: true }" x-show.transition="showNotif" x-init="setTimeout(() => showNotif = false, 5000)">
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
    <div class="flex space-x-4 justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
         <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Employee Schedule') }}
        </h2>
        @if($isModal == 'create')
            @include('livewire.Admin.Schedule.create')
        @elseif($isModal == 'edit')
            @include('livewire.Admin.Schedule.create')
        @elseif($isModal == 'delete')
            @include('livewire.Admin.Schedule.delete')
        @elseif($isModal == 'import')
            @include('livewire.Admin.Schedule.import')
        @endif
        <div class="flex space-x-4">
         <button wire:click="create()" class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:px-6 px-4 md:py-2 py-3 flex items-center gap-2 text-lg font-semibold tracking-wider text-white rounded-xl shadow-md focus:outline-none "><i class="fas fa-plus"></i> <span class="hidden md:block">Schedule</span></button>
         <button wire:click="import()" class="bg-gradient-to-r from-green-500 to-green-600 duration-200 opacity-80 hover:opacity-100 md:px-6 px-4 md:py-2 py-3 flex items-center gap-2 text-lg font-semibold tracking-wider text-white rounded-xl shadow-md focus:outline-none "><i class="fas fa-file-import"></i> <span class="hidden md:block">Import </span></button>
         </div>

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



            <livewire:admin-datatable-schedule
                searchable="employee_name"
                exportable
             >
        </div>

        <div class="flex flex-col row-span-1 text-right pointer px-4 capitalize  bg-white py-4 bg-gray-100 rounded-xl border mt-4">

          <h4 class=" text-gray-700 font-bold tracking-wide text-xl leading-snug text-left mb-4" >         
            <i class="fas fa-question-circle text-blue-500"></i> Legend         
         </h4>
         <div class="grid md:grid-cols-3 grid-cols-1 gap-2">

          <h4 class=" font-medium text-md leading-snug text-left flex items-center text-gray-700">   
            <span class="font-bold">No Record</span> : Absence 
        </h4>
        <h4 class=" font-medium text-md leading-snug text-left flex items-center text-gray-700">   
            <span class="font-bold">No sign in</span> : Haven't started recording yet 
        </h4>
        <h4 class="font-medium flex-1 text-md leading-snug text-left flex items-center text-gray-700">
            <span class="font-bold">Done</span> : Recording on this date finished
        </h4>
        <h4 class=" font-medium text-md leading-snug text-left flex items-center text-gray-700">   
            <span class="font-bold">Working</span> : Recording in progress
        </h4>
      

    </div>     
</div>

    </div>

</div>


