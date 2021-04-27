<x-app-layout>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
	<style type="text/css">
   
    
/* width */
::-webkit-scrollbar {
  width: 6px;

}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 1px grey;  
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: gray; 
  border-radius: 14px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #b30000; 
}
</style>
<div class="bg-white shadow">
  <div class="flex justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
      <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
      </h2>

      @if (session()->has('message'))
          <div class="alert alert-success">
              {{ session('message') }}
          </div>
      @endif



      <button wire:click="showCreateRequest()" class="bg-gradient-to-r from-green-500 to-green-600 duration-200 opacity-80 hover:opacity-100 px-4 py-2 text-lg font-semibold tracking-wider px-6 text-white rounded-xl shadow-md focus:outline-none "><i class="fas fa-file-import mr-2"></i> Import Schedule</button>
    
  </div>
  </div>

  
  	<div class="max-w-full  mx-auto sm:px-6 lg:px-8 ">
  		<div class="grid grid-cols-8 grid-flow-col gap-4 divide-x divide-gray-300">
  			<div class="col-span-2 p-4 pr-0 text-gray-600 text-center h-full mb-5">
  				<label class="text-xl">Employee Activities</label>
  				<div class="flex flex-col gap-4 mt-8 overflow-auto pr-2 h-96 ">
  					<?php for ($i=0; $i < 10; $i++) { 
  						# code...
  					?>
  					<div class="grid grid-cols-4 items-center text-sm gap-4 hover:bg-white hover:border-yellow-300 rounded-lg border border-gray-300 duration-200">
  						<div class="col-span-1 ml-2 relative">
  							<img src="https://kepri.haluan.co/wp-content/uploads/2020/08/Muhammad-Ali.-internet.jpg" class="rounded-full h-12 w-12 object-cover mx-auto">
  							<span class="absolute w-3 h-3 rounded-full bg-green-500 border-2 top-0 right-0 "></span>
  							<span class="absolute w-3 h-3 rounded-full bg-green-500 border-2 top-0 right-0 animate-ping"></span>
  						 </div>
  						<div class="flex flex-col col-span-3 text-left relative py-4 px-2  leading-tight mr-2">
  						<label class="font-semibold ">Muhammad Ali</label>
  						<label>WFO | Tasking .. </label>
  						<label class="absolute bottom-0 right-0 text-xs bg-orange-500 text-white px-2 rounded-tl-lg rounded-br-lg -mr-2">Start at 08.00</label>
  						</div>
  					</div>
  					<?php } ?>
  				</div>
  			</div>
  			<div class="grid grid-rows-8 divide-y divide-gray-300 w-100 col-span-6 ">
  				<div class="flex flex-col place-items-auto gap-2 pt-4 py-2 row-span-1 px-8">
  					<label class="text-xl text-center ">Today Statistic</label>
  					<div class="grid grid-cols-3 gap-10 mt-5 ">

  						<div id="jh-stats-positive" class="flex flex-col justify-center px-4 py-4 bg-white border border-gray-200 rounded-xl relative">
  							<i class="fas fa-check-circle absolute top-2 left-4 text-blue-400 text-xl"></i>
  							<div>
  								<div>
  									<p class="flex items-center justify-end text-green-500 text-md absolute top-2 right-4">
  										<span class="font-bold">6%</span>
  										<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 15a1 1 0 002 0V7a1 1 0 00-1-1h-8a1 1 0 000 2h5.59L13 13.59l-3.3-3.3a1 1 0 00-1.4 0l-6 6a1 1 0 001.4 1.42L9 12.4l3.3 3.3a1 1 0 001.4 0L20 9.4V15z"/></svg>
  									</p>
  								</div>
  								<p class="text-2xl leading-tight font-semibold text-center text-gray-800">43</p>
  								<p class="text-base text-center leading-tight text-gray-500">Attend</p>
  							</div>
  							<div class="relative">
  								<label class="absolute top-0 right-0 text-center text-xs ">43/<span class="font-semibold">50</span>
  								</label>
  								<div class="overflow-hidden h-2 mt-4 text-xs flex rounded bg-gray-200">  							
  									<div style="width: 80%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>  							
  								</div>
  							</div>

  						</div>
  						<div id="jh-stats-negative" class="flex flex-col justify-center px-4 py-4 mt-4 bg-white border border-gray-200 rounded-xl relative sm:mt-0">
  							<i class="fas fa-times-circle absolute top-2 left-4 text-red-400 text-xl"></i>
  							<div>
  								<div>
  									<p class="flex items-center justify-end text-red-500 text-md absolute top-2 right-4">
  										<span class="font-bold">6%</span>
  										<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 9a1 1 0 012 0v8a1 1 0 01-1 1h-8a1 1 0 010-2h5.59L13 10.41l-3.3 3.3a1 1 0 01-1.4 0l-6-6a1 1 0 011.4-1.42L9 11.6l3.3-3.3a1 1 0 011.4 0l6.3 6.3V9z"/></svg>
  									</p>
  								</div>
  								<p class="text-2xl leading-tight font-semibold text-center text-gray-800">3</p>
  								<p class="text-base text-center leading-tight text-gray-500">Not Sign in</p>
  							</div>
  							<div class="relative">
  								<label class="absolute top-0 right-0 text-center text-xs ">3/<span class="font-semibold">50</span>
  								</label>
  								<div class="overflow-hidden h-2 mt-4 text-xs flex rounded bg-gray-200">  							
  									<div style="width: 6%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500"></div>  							
  								</div>
  							</div>
  						</div>
  						<div id="jh-stats-neutral" class="flex flex-col justify-center px-4 py-4 mt-4 bg-white border border-gray-200 rounded-xl relative sm:mt-0">
  							<div>
  								<div>
  									<p class="flex items-center justify-end text-gray-500 text-md absolute top-2 right-4">
  										<span class="font-bold">0%</span>
  										<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M17 11a1 1 0 010 2H7a1 1 0 010-2h10z"/></svg>
  									</p>
  								</div>
  								<p class="text-2xl leading-tight font-semibold text-center text-gray-800">4</p>
  								<p class="text-base text-center leading-tight text-gray-500">Permission</p>
  							</div>
  							<div class="relative">
  								<label class="absolute top-0 right-0 text-center text-xs ">4/<span class="font-semibold">50</span>
  								</label>
  								<div class="overflow-hidden h-2 mt-4 text-xs flex rounded bg-yellow-200">  							
  									<div style="width: 8%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-500"></div>  							
  								</div>
  							</div>
  						</div>
  				
  				</div>
  				</div>
  				<div class="row-span-3 grid grid-cols-3 divide-x">
  					<div class="col-span-2 p-4">
  						<canvas id="myChart"></canvas>
  						
  					</div>
  					<div class="px-2 py-1 flex flex-col ">
  					<label class="text-xl text-center mb-5">Head Office</label>
  					<?php for ($i=0; $i < 6; $i++) { 
  						# code...
  					 ?>
  					<div class="flex justify-between gap-2 items-center text-sm my-2"> 
  						<label class=" font-semibold text-center">Designer Division</label>
  						<span class="border flex-auto h-0.5 bg-gray-900 "></span>
  						<label class=" text-center">Muhammad Ali</label>
  					</div>
  					<?php } ?>
  					<button class="bg-blue-400  py-2 rounded-lg text-sm mt-4 text-white w-52 hover:bg-blue-600 mx-auto">Manage</button>
  					</div>

  				</div>
  				<div class="row-span-3">
            <livewire:admin-datatable-shift
                searchable="name"
                exportable
             /></div>
  				<div class="row-span-1">stat box</div>
  			</div>
  		</div>
  	</div>
  
  	<script type="text/javascript">
  		var ctx = document.getElementById('myChart').getContext('2d');
  		var chart = new Chart(ctx, {
  						// The type of chart we want to create
  						type: 'line',

  						// The data for our dataset
  						data: {
  							labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
  							datasets: [{
  								label: 'Our Employee work',

  								borderColor: '#3498db',
  								data: [0, 10, 5, 2, 20, 30, 145]
  							}]
  						},

  				// Configuration options go here
  				options: {}
  			});
  		</script>
</x-app-layout>