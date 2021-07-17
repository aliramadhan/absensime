<div class="bg-white shadow">
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

            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif


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


