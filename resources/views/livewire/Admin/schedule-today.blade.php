<div class="bg-white shadow">
    <div class="flex gap-4 justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
         <h2 class="font-normal text-2xl text-gray-700 leading-tight">
            {{ __('Attendance Detail Report') }}
        </h2>
    </div>   
</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif


            <livewire:tables.schedule-today
                searchable="employee_name"
                exportable
             >
        </div>
    </div>
</div>


