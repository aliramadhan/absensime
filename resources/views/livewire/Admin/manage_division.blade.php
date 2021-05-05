<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <!--Title-->
                <div class="flex justify-between items-center py-3 border-b px-6">
                  <p class="text-2xl font-base text-gray-700">Manage <span class="font-semibold"> Head of Division</span></p>
                  <div class="modal-close cursor-pointer z-50" wire:click="$set('isModal', null)">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                      <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                  </div>
                </div>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        @if (session()->has('notif_update'))
                            <div class="alert alert-success">
                                {{ session('notif_update') }}
                            </div>
                        @endif
                        @foreach($divisions as $division)
                        <div class="mb-4">
                            <label for="formName{{$loop->iteration}}" class="block text-gray-500 text-sm font-semibold mb-2">{{$division->name}}:</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formName{{$loop->iteration}}" wire:change="changeManager({{$division->id}},$event.target.value)">
                              <option hidden></option>
                              @foreach($users->where('role','!=','Admin')->where('role','!=','Catering')->where('division',$division->name) as $manager)
                                <option value="{{$manager->id}}" @if($manager->division == $division->name && $manager->roles == 'Manager') selected @endif>{{$manager->name}}</option>
                              @endforeach
                            </select>
                            @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @endforeach
                    </div>
                </div>
    
                <div class="bg-gray-50 px-4 py-3 flex justify-between items-center  md:flex-row gap-2 flex-col-reverse">
                
                           
                  <div x-data="{ showDivision: false }" > 
                    <button @click="showDivision = true" x-show="!showDivision" type="button" class="inline-flex justify-center w-auto rounded-md border border-transparent px-4 py-2 bg-green-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5 items-center flex tracking-wider">
                      <i class="fas fa-plus mr-1"></i>Division
                    </button>
                    <div x-show="showDivision" class="flex gap-2">
                      <div class="relative text-gray-600 focus-within:text-gray-400 ">
                        <span class="absolute inset-y-0 right-0 flex items-center pl-2">
                          <button type="button" @click="showDivision = false" class="p-1 focus:outline-none focus:shadow-outline">
                          <i class="fas fa-times text-red-400 hover:text-red-600 mr-2"></i>
                          </button>
                        </span>
                        <input type="text" name="" class="rounded-lg" wire:model="divisionName" placeholder="New Division">
                        @error('divisionName') <span class="text-red-500">{{ $message }}</span>@enderror
                      </div>
                    <button wire:click="storeDivision()" @click="showDivision = false" class="rounded-lg bg-green-500 text-white px-4 py-2 ">
                      <i class="fas fa-plus"></i>
                    </button>
                    </div>
                  </div>
                  <button type="submit" class="inline-flex justify-center w-full md:w-auto rounded-md border border-transparent px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5 tracking-wider">
                    Save
                  </button>  
                </div>
            </div>
        </div>
    </div>

