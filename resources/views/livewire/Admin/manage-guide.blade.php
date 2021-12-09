<x-slot name="header">

	<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
		{{ __('Manage Guide') }}
	</h2>

</x-slot>

<div class="grid grid-cols-4 gap-8 max-w-7xl mx-auto py-12 lg:px-8 md:px-5 px-3  ">
<div class="flex flex-col space-y-6 col-span-4 lg:col-span-1">
		<div class="flex flex flex-col space-y-3">
			<label class="text-xl font-semibold text-gray-800 tracking-wider">Upload Form</label>
			<div class="bg-white rounded-lg px-4 py-3 shadow">
				<div class="mb-4">
					<label for="formStartedAt" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">File Type </label>
					<select class="border-gray-300 bg-gray-100 appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formLocation" wire:model="type_upload">
						<option hidden>Choose one</option>
						<option value="image">Image Embed</option>
						<option value="doc">Google Docs</option>		
					</select>
					@error('started_at') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
				</div>          

				<div class="mb-4">
					@if($type_upload == 'doc')
						<label for="formName" class="block text-gray-500 text-sm font-semibold mb-2">Embed URL :</label>
						<input type="text" class="border-gray-300  appearance-none  rounded-lg w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline bg-gray-100" id="formName"
						placeholder="Write url link .." wire:model="link">
						@error('link') <span class="text-red-500">{{ $message }}</span>@enderror
					@elseif($type_upload == 'image')
						<label for="formName" class="block text-gray-500 text-sm font-semibold mb-2">Embed URL :</label>
						<input type="file" class="border-gray-300  appearance-none  rounded-lg w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline bg-gray-100" id="formName"
						placeholder="Write url link .." wire:model="file">
						@error('file') <span class="text-red-500">{{ $message }}</span>@enderror
					@endif
				</div>
				<div class="flex justify-end">
					<button type="button" class="modal-close bg-blue-500 py-2 px-3 text-base rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none flex justify-between items-center " @if($type_upload != 'doc') wire:click="store()" wire:target="store()" @else wire:click="updateGuide()" wire:target="updateGuide()" @endif wire:loading.remove>
						<i class="fas fa-arrow-circle-up mr-3"></i> Upload</button>
						<button type="button" class="modal-close bg-blue-500 py-2 px-5 text-base rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none animate-pulse" wire:loading wire:target="updateGuide()" readonly>Saving..</button>
					</div>
				</div>
			</div>

			<div class="flex flex flex-col space-y-3">
				<label class="text-xl font-semibold text-gray-800 tracking-wider">Upload Tutorial</label>
				<div class="bg-white rounded-lg px-4 py-3 shadow">			

					<div class="mb-4 flex flex-col space-y-1">
						@if($type_upload == 'doc')
						<label>Google Docs</label>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">1.</label> 
							<label>Open your document on Google Docs </label>
						</div>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">2.</label> 
							<label>Click File</label>
						</div>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">3.</label> 
							<label>Click Publikasikan di web</label>
						</div>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">4.</label> 
							<label>Copy Script embed pada Tautan</label>		
						</div>		
						<div class="block text-gray-500 text-sm flex space-x-2">
							<label class="w-5"> </label> 
							<label>Atau<br> pada tab Sematkan, contoh iframe src="(copy this)" </label>		
						</div>	
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">5.</label> 
							<label> Paste your embed to app on embed URL field</label>
						</div>
						@elseif($type_upload == 'image')
						<label>Image embed</label>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">1.</label> 
							<label>Open your picture </label>
						</div>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">2.</label> 
							<label>Copy Embed Url from your web provider</label>
						</div>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">3.</label> 
							<label> Paste your embed to app on embed URL field</label>
						</div>
						@endif
						</div>

					</div>
				</div>


			</div>

			</div>


		</div>	
