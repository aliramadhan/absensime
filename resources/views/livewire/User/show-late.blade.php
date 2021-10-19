<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-start justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class=" py-4 px-6 sm:flex border-b flex ">
                <h1 class=" font-semibold text-2xl text-gray-600">Late entry form</h1>                 
                </div>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        <div class="mb-4">
                            <label for="formNote" class="block text-gray-500 text-sm font-semibold mb-3">Because you are late for more than 1 hour and please write your reasons in the following form</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 mb-2 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formNote" wire:model="note" required placeholder="Fill your reason here ..">
                            @error('note') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
    
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="lateOn()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-6 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow transition ease-in-out duration-150 sm:text-sm sm:leading-5 items-center">
                        <i class="fas fa-paper-plane mr-2 -ml-2" wire:loading.remove wire:target="lateOn"></i>
                        <i class="fas fa-circle-notch animate-spin mr-2 -ml-2 tracking-wider" wire:loading wire:target="lateOn"></i> Send and Start Record
                        </button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>