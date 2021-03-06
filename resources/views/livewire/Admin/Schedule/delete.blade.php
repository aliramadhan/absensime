<div x-show="showDeleteModal" tabindex="0"
    class="z-40 overflow-auto left-0 top-0 bottom-0 right-0 w-full h-full fixed">
    <div class="z-50 relative p-3 mx-auto my-0 max-w-full"
        style="width: 500px;">
        <div class="bg-white rounded shadow-lg border flex flex-col overflow-hidden px-10 py-10">
            <div class="text-center">
                <span
                    class="material-icons border-4 rounded-full p-4 text-red-500 font-bold border-red-500 text-4xl">
                    close
                </span>
            </div>
            <div class="text-center py-6 text-2xl text-gray-700">Are you sure ?</div>
            <div class="text-center font-light text-gray-700 mb-8">
                Do you really want to delete Schedule for {{$schedule->employee_name}} at {{Carbon\Carbon::parse($schedule->date)->format('d F Y')}} ? This process cannot be undone.
            </div>
            <div class="flex justify-center space-x-4">
                <button wire:click="closeModal()" class="tracking-wide font-semibold bg-gray-300 text-gray-900 rounded hover:bg-gray-200 px-6 py-2 focus:outline-none mx-1">Cancel</button>
                <button wire:click="destroy()" class="tracking-wide font-semibold bg-red-500 text-gray-200 rounded hover:bg-red-400 px-6 py-2 focus:outline-none mx-1">Delete</button>
            </div>
        </div>
    </div>
    <div class="z-40 overflow-auto left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-black opacity-50"></div>
</div>