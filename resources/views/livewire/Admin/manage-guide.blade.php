	
<x-slot name="header">

	<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
		{{ __('Manage Guide') }}
	</h2>

</x-slot>

<div class="grid grid-cols-4 gap-8 max-w-7xl mx-auto py-12 lg:px-8 md:px-5 px-3  ">
	<div class="flex flex-col space-y-3 col-span-4 lg:col-span-1">

		<label class="text-xl font-semibold text-gray-800 tracking-wider">Upload Form</label>
		<div class="bg-white rounded-lg px-4 py-3 shadow">
			<div class="mb-4">
				<label for="formStartedAt" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">File Type </label>
				<select class="border-gray-300 bg-gray-100 appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formLocation" >
					<option hidden>Choose one</option>
					<option value="image">Image Embed</option>
					<option value="doc">Google Docs</option>		
				</select>
				@error('started_at') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
			</div>          

			<div class="mb-4">
				<label for="formName" class="block text-gray-500 text-sm font-semibold mb-2">Embed URL :</label>
				<input type="text" class="border-gray-300  appearance-none  rounded-lg w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline bg-gray-100" id="formName" wire:model="name" 
				placeholder="Write url link ..">
				@error('name') <span class="text-red-500">{{ $message }}</span>@enderror
			</div>
			<div class="flex justify-end">
				<button type="button" class="modal-close bg-blue-500 py-2 px-3 text-base rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none flex justify-between items-center " @click="$wire.createRequest()" wire:loading.remove wire:target="createRequest">
					<i class="fas fa-arrow-circle-up mr-3"></i> Upload</button>
					<button type="button" class="modal-close bg-blue-500 py-2 px-5 text-base rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none animate-pulse" wire:loading wire:target="createRequest" readonly>Saving..</button>
				</div>
			</div>

		</div>
		<div class="col-span-4 lg:col-span-3 flex flex-col  space-y-3 ">
			<div class="flex md:flex-row flex-col justify-between items-start md:items-end">
				<label class="text-xl font-semibold text-gray-800 tracking-wider">Guide Result</label>
				<label class="text-sm font-semibold text-gray-500 tracking-wider">Last Update : 11/19/2021</label>
			</div>
			<div class="bg-white rounded-lg h-screen px-4 py-2">
				<iframe class="w-full h-full" src="https://docs.google.com/document/d/e/2PACX-1vTjjMpetIiE_9tb0_cREr4rhh8eZf5jmEE4Vz7vDmGPXFgffsMYB_Q3JaK_GMzguheZ5vD133_DJkVQ/pub?embedded=true"></iframe>
			</div>
		</div>
		

	</div>	