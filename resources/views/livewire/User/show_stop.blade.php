<!-- This example requires Tailwind CSS v2.0+ -->
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <!--
      Background overlay, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <!--
      Modal panel, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        To: "opacity-100 translate-y-0 sm:scale-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100 translate-y-0 sm:scale-100"
        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    -->
    @php
      $detailsSchedule = $schedule->details->where('task',null)->sortBy('id');
    @endphp
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start ">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <!-- Heroicon name: outline/exclamation -->
            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-col flex md:grid gap-2">
            <div id="modal-title" class="flex-auto text-left">
            <h3 class="text-base md:text-lg leading-none font-medium text-gray-900" >
              Stop Recording & Journal Recap<label class="hidden md:inline-block">itulation</label>
            </h3>
             <label class="font-semibold tracking-wide text-xs md:text-sm text-gray-600">You Have {{$detailsSchedule->count()}} empty journal</label>
             </div>
            <div class="overflow-y-auto max-h-72 pr-2 flex-auto border-b-2">
            
               <div class="text-sm overflow-y-auto  my-2  p-2 ">
                @forelse($detailsSchedule as $details)
                  <div class="flex space-x-4 items-center ">
                  <label class="w-1">{{$loop->iteration}}.</label>
                  <label class="flex-shrink-0 w-18">{{Carbon\Carbon::parse($details->started_at)->format('H:i')}} - {{Carbon\Carbon::parse($details->stoped_at)->format('H:i')}}</label>
                  <input type="text" class="rounded-lg  py-1 px-2 w-9/12 text-sm border-gray-400" required placeholder="Fill your task/journal.." wire:model="detailsSchedule.{{ $loop->iteration }}.task">
                </div>
                @empty

                @endforelse
             </div>
            

           
            </div>
            @if($now < Carbon\Carbon::parse($shift->time_out))
            <label class="text-red-500 text-xs md:text-sm font-semibold">Warning : Stopped recording before your shift is over</label>
            <input type="text" wire:model="note" class="shadow appearance-none border rounded w-full py-1 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" placeholder="Fill in your reason.." required>
            @endif

            <p class="text-xs md:text-sm text-gray-700 break-all">
            Are you sure you want to stop your record workhour?<br> This action cannot be undone.
            </p>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 items-center flex sm:flex-row-reverse space-x-2">
        <button wire:click="stopOn()" type="button" class="w-6/12 inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm tracking-wider">
          Stop
        </button>
        <button wire:click="closeModal()" type="button" class="w-6/12 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>
