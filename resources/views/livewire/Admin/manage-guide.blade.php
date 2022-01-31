<x-slot name="header">

	<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
		{{ __('Manage Guide') }}
	</h2>

</x-slot>

<div class="grid grid-cols-4 gap-8 max-w-7xl mx-auto py-12 lg:px-8 md:px-5 px-3  ">
<div class="flex flex-col md:flex-row lg:flex-col lg:space-x-0 space-x-0 md:space-x-4 space-y-4 md:space-y-0 lg:space-y-6 col-span-4 lg:col-span-1">
		<div class="flex flex flex-col space-y-3">
			<label class="text-xl font-semibold text-gray-800 tracking-wider">Upload Form</label>
			<div class="bg-white rounded-lg px-4 py-3 shadow">
				<div class="mb-4">
					<label for="formStartedAt" class="block text-gray-500 text-sm tracking-wide font-semibold mb-2">File Type </label>
					<select class="border-gray-300 bg-gray-100 appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formLocation" wire:model="type_upload">
						<option hidden>Choose here</option>
						<option value="image">Image File</option>
						<option value="document">Image File</option>
						<option value="link">Link Embed</option>		
					</select>
					@error('started_at') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
				</div>          

				<div class="mb-4">
					@if($type_upload == 'link')
						<label for="formName" class="block text-gray-500 text-sm font-semibold mb-2">Embed URL :</label>
						<input type="text" class="border-gray-300  appearance-none  rounded-lg w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline bg-gray-100" id="formName"
						placeholder="Write url link .." wire:model="link">
						@error('link') <span class="text-red-500">{{ $message }}</span>@enderror
					@else
						<label for="formName" class="block text-gray-500 text-sm font-semibold mb-2">Select Image File :</label>
						<input type="file" class="border-gray-300  appearance-none  rounded-lg w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline bg-gray-100" id="formName"
						placeholder="Write url link .." wire:model="file">
						@error('file') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
					@endif
				</div>
				<div class="flex justify-end">
					@if($type_upload == 'link' || $type_upload == 'image')
					<button type="button" class="modal-close bg-blue-500 py-2 px-3 text-base rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none flex justify-between items-center duration-300" @if($type_upload != 'link') wire:click="store()" wire:target="store()" @else wire:click="updateGuide()" wire:target="updateGuide()" @endif wire:loading.remove>
						<i class="fas fa-arrow-circle-up mr-3"></i> Upload</button>
						<button type="button" class="modal-close bg-blue-500 py-2 px-5 text-base rounded-lg text-white hover:bg-blue-600 font-semibold tracking-wider focus:outline-none animate-pulse" wire:loading wire:target="updateGuide()" readonly>Saving..</button>
					@endif
				</div>

				</div>
			</div>

			<div class="flex flex flex-col space-y-3">
				<label class="text-xl font-semibold text-gray-800 tracking-wider">Upload Tutorial</label>
				<div class="bg-white rounded-lg px-4 py-3 shadow">			

					<div class="mb-4 flex flex-col space-y-1">
						@if($type_upload == 'image')
						<label class="mb-2 font-semibold tracking-wider">Image File</label>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">1.</label> 
							<label>Select choose file</label>
						</div>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">2.</label> 
							<label>Click your image file</label>
						</div>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">3.</label> 
							<label>Check your file must be a file of type: jpeg, jpg, png, gif.</label>
						</div>
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">4.</label> 
							<label>Click upload</label>		
						</div>							
						<div class="block text-gray-500 text-sm flex">
							<label class="w-5">5.</label> 
							<label> The guide already updated</label>
						</div>
						@elseif($type_upload == 'link')
						<label class="mb-2 font-semibold tracking-wider">Image Embed</label>
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

			<div class="col-span-4 lg:col-span-3 flex flex-col  space-y-3 ">
			<div class="flex md:flex-row flex-col justify-between items-start md:items-end">
				<label class="text-xl font-semibold text-gray-800 tracking-wider">Guide Result</label>
				<label class="text-sm font-semibold text-gray-500 tracking-wider">Last Update : <span class="text-gray-700">@if(Cache::has('guide_time')) {{Carbon\Carbon::parse(Cache::get('guide_time'))->format('D, d M Y');}} @endif</span></label>
			</div>
			<div class="bg-white rounded-lg h-screen px-4 py-2">
				@if(Cache::has('guide_link'))
					@if(file_exists(public_path('image/guide.jpg')))
		                <img src="{{ asset('image/guide.jpg') }}">
		            @elseif(file_exists(public_path('image/guide.pdf')))
		            	<embed src="{{ asset('image/guide.pdf') }}" alt="pdf" />
		            @else
		                <iframe class="w-full h-full" src="{{Cache::get('guide_link');}}"></iframe>
		            @endif
				@else
					<iframe class="w-full h-full" src="https://docs.google.com/document/d/e/2PACX-1vTjjMpetIiE_9tb0_cREr4rhh8eZf5jmEE4Vz7vDmGPXFgffsMYB_Q3JaK_GMzguheZ5vD133_DJkVQ/pub?embedded=true"></iframe>
				@endif
			</div>
		</div>

			</div>


		</div>	
