<div class="bg-white shadow">
    <div class="flex justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
         <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Working Request') }}
        </h2>
        @if(auth()->user()->roles == 'Manager')

        <button wire:click="showCreate()" class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:py-2 rounded-full py-4 px-4 text-lg font-semibold tracking-wider  md:px-6 text-white md:rounded-xl shadow-md focus:outline-none flex items-center gap-2 "><i class="fas fa-paper-plane"></i><span class="hidden md:block">Create Request</span></button>

        @endif
    </div>

</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
  

    <livewire:request-datatable-user exportable />
		</div>
	</div>
</div>
