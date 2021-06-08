<div class="bg-white shadow">
    <div class="flex justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
         <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Working Request') }}
        </h2>
        
    </div>

</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
  

    <livewire:request-datatable-user
  		 searchable="employee"
        exportable

     />
		</div>
	</div>
</div>
