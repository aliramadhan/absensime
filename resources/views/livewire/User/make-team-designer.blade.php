<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Manage Teammates') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
       <div class="w-full h-screen rounded-lg shadow-md grid grid-cols-4 gap-4">
       	@for ($i=0; $i < 12; $i++)        		
       
       	<div class="flex justify-between flex-col bg-white rounded-md px-4 py-3 text-sm">
       		<div class="flex flex-rows justify-between items-center">
       			<label class="w-8 h-8 flex flex-wrap items-center bg-gray-100 text-yellow-500 font-semibold text-lg rounded-full justify-center">1</label>
				<div class="flex justify-center">
				  <!-- Dropdown -->
				  <div x-data="{ open: false }" class="relative">
				    <button x-on:click="open = true" class="block h-8 w-8 overflow-hidden focus:outline-none ">
				    <i class="fas fa-ellipsis-h text-gray-500"></i>
				    </button>
				    <!-- Dropdown Body -->
				    <div x-show.transition="open" x-on:click.away="open = false" class="absolute right-0 w-40 bg-white border rounded shadow-xl">   
				      <a href="#" class="transition-colors duration-200 block px-4 py-2 text-normal text-gray-900 rounded hover:bg-purple-500 hover:text-white">Edit Team</a>
				     
				        <hr></hr>
		
				    <a href="#" class="transition-colors duration-200 block px-4 py-2 text-normal text-gray-900 rounded hover:bg-purple-500 hover:text-white">    
				      Logout
				    </a>
				  </div>
				  <!-- // Dropdown Body -->
				  </div>
				  <!-- // Dropdown -->
				</div>
       		
       		</div>
       		<label class="font-semibold tracking-wider">Nama Team - {Task Yang dikerjakan}
       		
       		</label>
       		<div class="flex flex-row justify-between">
       			<label class="text-white bg-green-500 font-semibold rounded-md px-2 py-1 text-xs"><i class="fas fa-users mr-1"></i> 12 Orang</label>
       			<div class="flex flex-row relative">
       				<img src="https://images.pexels.com/photos/6009274/pexels-photo-6009274.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="w-6 h-6 rounded-full bg-cover bg-white p-0.5">
       				
       				<img src="https://images.pexels.com/photos/6009274/pexels-photo-6009274.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="w-6 h-6 rounded-full bg-cover bg-white p-0.5 absolute right-4">

       			</div>
       		</div>       		
       	</div>
       	@endfor

       </div>
    </div>   
</div>
