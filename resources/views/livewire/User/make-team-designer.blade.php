<x-slot name="header">
	<div class="flex justify-between items-center">
		<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
			{{ __('Manage Teammates') }}
		</h2>
		<button wire:click="import()" class="bg-gradient-to-r from-green-500 to-green-600 duration-200 opacity-80 hover:opacity-100 md:px-6 px-4 md:py-2 py-3 flex items-center gap-2 text-lg font-semibold tracking-wider text-white rounded-xl shadow-md focus:outline-none "><i class="fas fa-file-import"></i> <span class="hidden md:block">Import </span></button>
	</div>
</x-slot>

<div class="py-12" x-data="{ showModal: false }" @keydown.escape="showModal = false" x-cloak>
	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="w-full h-full rounded-xl grid grid-cols-4 gap-6">
			<button @click="showModal = true" class="flex justify-between flex-col hover:bg-white border-gray-400 hover:border-indigo-600 rounded-xl px-4 py-3 text-sm hover:shadow-xl duration-300 border-4 border-dashed text-gray-500 hover:text-indigo-700 focus:outline-none" >
				<div class="flex flex-col justify-center items-center m-auto space-y-2">
					<i class="fas fa-plus-circle fa-4x"></i>
					<label class="font-semibold text-xl">Add New Team</label>
				</div>
			</button>

<div class="overflow-auto" style="background-color: rgba(0,0,0,0.5)" x-show="showModal" :class="{ 'fixed inset-0 z-50 flex items-center justify-center': showModal }">
				<!--Dialog-->
				<div class="bg-white mx-auto rounded shadow-lg pt-4 text-left w-11/12 md:w-8/12 lg:w-4/12 " x-show="showModal" @click.away="showModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" >
					<!--Title-->
					<div class="flex justify-between items-center px-5 border-b pb-2">
						<p class="text-2xl font-semibold text-gray-700">Add Teammates</p>
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
									<label for="formStartedAt" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Team Name </label>
									<input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStartedAt"  placeholder="Fill in here..." >
									@error('started_at') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
								</div>          
								<div class="mb-4">
									<label for="formStartedAt" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Task Team </label>
									<input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formStartedAt"  placeholder="Fill in here..." >
									@error('started_at') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
								</div>  
								<div class="mb-4">
									<label for="formStartedAt" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Leader </label>
									<select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formLocation" wire:model="locationRe">
										<option hidden>Choose one</option>
										<option value="WFO">Work From Office</option>
										<option value="WFH">Work From Home</option>
										<option value="Business Travel">Business Travel</option>
										<option>Remote</option>
									</select>
									@error('started_at') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
								</div>          

								<div class="mb-4">
									<label for="formStartedAt" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">Crew </label>
									<select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formLocation" wire:model="locationRe">
										<option hidden>Choose one</option>
										<option value="WFO">Work From Office</option>
										<option value="WFH">Work From Home</option>
										<option value="Business Travel">Business Travel</option>
										<option>Remote</option>
									</select>
									@error('locationRe') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
								</div>              
								
								
								
								
							</div>
						</div>

						<!--Footer-->
						<div class="flex justify-end py-3 bg-gray-100 space-x-4 px-4  items-center">
							<a class="bg-transparent py-2 px-4 rounded-lg text-gray-500 hover:bg-white hover:text-gray-700 font-semibold tracking-wider border border-gray-400 rounded-lg bg-white focus:outline-none cursor-pointer" @click="showModal = false">Cancel</a>
							<button type="button" class="modal-close bg-blue-500 py-2 px-5 rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none" @click="$wire.createRequest()" wire:loading.remove wire:target="createRequest">Save</button>
							<button type="button" class="modal-close bg-blue-500 py-2 px-5 rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none animate-pulse" wire:loading wire:target="createRequest" readonly>Saving..</button>
						</div>
					</form>

				</div>
				<!--/Dialog -->
			</div><!-- /Overlay -->

			@for ($i=1; $i < 12; $i++)        		       
			<div class="flex justify-between flex-col bg-white rounded-xl px-4 py-3 text-sm hover:shadow-xl duration-300">
				<div class="flex flex-rows justify-between items-center">
					<label class="w-8 h-8 flex flex-wrap items-center bg-gray-100 text-indigo-500 font-semibold text-lg rounded-full justify-center">{{$i}}</label>
					<div class="flex justify-center">
						<!-- Dropdown -->
						<div x-data="{ open: false }" class="relative">
							<button x-on:click="open = true" class="block h-8 w-8 overflow-hidden focus:outline-none hover:bg-gray-100 duration-300 rounded-full">
								<i class="fas fa-ellipsis-h text-gray-500"></i>
							</button>
							<!-- Dropdown Body -->
							<div x-show.transition="open" x-on:click.away="open = false" class="absolute right-0 w-40 bg-white border rounded shadow-xl">   
								<a href="#" class="transition-colors duration-200 block px-4 py-2 text-normal text-gray-900 rounded hover:bg-purple-500 hover:text-white">Edit Team</a>
								
								<hr></hr>
								<a href="#" class="transition-colors duration-200 block px-4 py-2 text-normal text-gray-900 rounded hover:bg-red-500 hover:text-white">    
									Disband Team
								</a>
							</div>
							<!-- // Dropdown Body -->
						</div>
						<!-- // Dropdown -->
					</div>
					
				</div>
				<div class="flex flex-col py-4">
					<label class="font-semibold tracking-wide mb-1 text-gray-800 text-base">Nama Team</label>
					<label class="text-gray-700 overflow-ellipsis overflow-hidden max-h-20 ">{Task Yang dikerjakan}</label>
				</div>
				<div class="flex flex-row justify-between items-center">
					<label class="text-white bg-green-500 font-semibold rounded-md px-2 py-1 text-xs h-max"><i class="fas fa-users mr-1"></i> 12 Orang</label>
					<div class="flex flex-row relative items-center">       			
						@for ($z=0; $z < 6; $z++) 
						<img src="https://images.pexels.com/photos/6009274/pexels-photo-6009274.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="w-7 h-7 rounded-full object-cover bg-white p-0.5 -mr-2">
						@endfor
					</div>
				</div>       		
			</div>
			@endfor

		</div>
	</div>   
</div>
