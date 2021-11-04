<div class="flex">
  <i class="modal-open fas fa-pencil-alt focus:outline-none bg-transparent border border-yellow-500 hover:bg-yellow-400 text-yellow-500 hover:text-white font-bold py-3 px-3 rounded-full pointer cursor-pointer" onclick="toggleModal('edit{{$id}}')"></i>
  <i  class="modal-open fas fa-trash-alt cursor-pointer ml-2 focus:outline-none bg-transparent border border-red-500 hover:bg-red-500 text-red-500 hover:text-white font-bold py-3 px-3 rounded-full" onclick="toggleModal('delete{{$id}}')"></i>
</div>
  <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="delete{{$id}}">
    <div class="z-40 overflow-auto left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-black opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto">
      
      <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50" onclick="toggleModal('delete{{$id}}')">
        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
          <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
        </svg>
        <span class="text-sm">(Esc)</span>
      </div>

      <!-- Add margin if you want to see some of the overlay behind the modal-->
      <div x-show="showDeleteModal" tabindex="0" class="z-40 w-full h-full ">
          <div class="z-50 relative p-3 mx-auto my-0 max-w-full">
              <div class="text-center flex flex-col overflow-hidden px-10 py-10 my-auto">
                  <div class="text-center">
                      <span
                          class="material-icons border-4 rounded-full p-4 text-red-500 font-bold border-red-500 text-4xl">
                          close
                      </span>
                  </div>
                  <div class="text-center py-6 text-2xl text-gray-700">Are you sure ?</div>
                  <div class="text-center font-light text-gray-700 mb-8">
                      Do you really want to delete <b class="font-semibold">{{$schedule->employee_name}}</b> Schedule at <b class="font-semibold">{{Carbon\Carbon::parse($schedule->date)->format('D, d F Y')}}</b>?<br> This process cannot be undone.
                  </div>
                  <div class="flex justify-center">
                      <button class="modal-close bg-gray-300 text-gray-900 rounded hover:bg-gray-200 px-6 py-2 focus:outline-none mx-1" onclick="toggleModal('delete{{$id}}')">Cancel</button>
                      <form @if(auth()->user()->roles == 'Admin') action="{{route('admin.schedule.destroy',$id)}}" @elseif(auth()->user()->roles == 'Manager') action="{{route('manager.schedule.destroy',$id)}}" @endif method="POST">
                      @csrf
                      @method('DELETE')
                        
                      <button type="submit" class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-6 py-2 focus:outline-none mx-1">Delete</button>
                      </form>
                  </div>
              </div>
          </div>
         
        </div>
    </div>
  </div>
  <!--Modal edit -->
  <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="edit{{$id}}">
  <!--<div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-20" id="edit{{$id}}">-->
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
      
      <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50" onclick="toggleModal('edit{{$id}}')">
        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
          <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
        </svg>
        <span class="text-sm">(Esc)</span>
      </div>

      <!-- Add margin if you want to see some of the overlay behind the modal-->
      <div class="modal-content py-4 text-left px-4 z-50">
        <!--Title-->
        <div class="flex justify-between items-center pb-2 border-b text-gray-700 px-4 ">
          <div class="flex flex-col ">
          <p class="text-xl font-semibold leading-tight">Editing <span class="font-bold">{{$employee->name}}</span> </p>
          <p class="text-sm"><i class="fas fa-calendar-alt text-blue-500"></i> {{Carbon\Carbon::parse($date)->format('D, d F Y')}}</p>
          </div>
          <div class="modal-close cursor-pointer z-50" onclick="toggleModal('edit{{$id}}')">
            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
              <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
            </svg>
          </div>
        </div>
            <form @if(auth()->user()->roles == 'Admin') action="{{route('admin.schedule.update',$id)}}" @elseif(auth()->user()->roles == 'Manager') action="{{route('manager.schedule.update',$id)}}" @endif method="POST">
            @csrf
            @method('PUT')
                <div class=" px-2 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        <div class="mb-4">
                            <label for="forEmployee" class="block text-gray-500 text-sm font-bold mb-2">Employee:</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="forEmployee" name="employee_id">
                              <option value="{{$employee->id}}">{{$employee->name}}</option>
                            </select>
                            @error('employee_id') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="forDate" class="block text-gray-500 text-sm font-bold mb-2">Date:</label>
                            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="forDate" name="date" value="{{$date}}">
                            @error('date') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="forShift" class="block text-gray-500 text-sm font-bold mb-2">Shift:</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="forShift" name="shift_id">
                                @foreach($shifts as $shiftList)
                                    <option value="{{$shiftList->id}}" @if($shiftList->id == $shift->id) selected @endif >{{$shiftList->name}}</option>
                                @endforeach
                            </select>
                            @error('shift_id') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
    
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-yellow-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-yellow-600 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Update
                        </button>
                    </span>
              </div>
            </form>
      </div>
    </div>
  </div>

<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="edit{{$id}}-backdrop"></div>
<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="delete{{$id}}-backdrop"></div>
<!-- iki tambahan -->