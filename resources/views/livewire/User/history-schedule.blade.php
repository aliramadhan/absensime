<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Track Record') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
         
            <livewire:user-schedule-table
            searchable="shift_name"
            hide="task"
            times="started_at,stoped_at|g:i A"
            exportable
            />
        </div>
    </div>
</div>