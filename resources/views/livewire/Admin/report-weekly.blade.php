	<div class="bg-white shadow ">
		<div class="flex flex-col md:flex-row md:space-x-4 space-x-0 justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
			<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
				{{ __('Weekly Hours Report') }}
			</h2>

		
		<form class="flex space-x-2 mt-4 md:mt-0">		
			<input type="week" name="time" @if(request('time') != null) value="{{Carbon\Carbon::parse(request('time'))->format('Y-')}}W{{Carbon\Carbon::parse(request('time'))->week - 1}}" @endif class="shadow appearance-none border rounded py-0 md:py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline text-sm md:text-base">
			<button wire:click="$emit('refreshTable')" class="bg-gradient-to-r from-purple-500 to-blue-600 duration-200 opacity-80 hover:opacity-100 md:py-2 rounded-full py-2 px-2 text-lg font-semibold tracking-wider  md:px-6 text-white md:rounded-xl shadow-md focus:outline-none flex items-center gap-2 ">
			<i class="fas fa-search"></i><span class="hidden md:block pr-2">Search</span></button>
		</form>
		</div>   
	
	</div>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
    			<livewire:tables.report-weekly searchable="employee" exportable :param="$time" />
			</div>
		</div>
	</div>
