<div>
	
	<div class="flex space-x-1 justify-around">
    @if($request->status == 'Waiting')
		@if($request->type == 'Overtime')
		    <button class="modal-open p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded" onclick="toggleModal('edit{{$id}}')">
		    	Accept
		    </button>
		@else
		    <button class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded" onclick="toggleModal('accept{{$id}}')">
		    	Accept
		    </button>

		@endif
	    <button class="p-1 text-red-600 hover:bg-red-600 hover:text-white rounded" onclick="toggleModal('decline{{$id}}')">
	    	Decline
	    </button>
    @elseif($request->status == 'Accept')
      <i  class="modal-open fas fa-trash-alt cursor-pointer ml-2 focus:outline-none bg-transparent border border-red-500 hover:bg-red-500 text-red-500 hover:text-white font-bold py-3 px-3 rounded-full" onclick="toggleModal('delete{{$id}}')"></i>
    @endif
	</div>

  <!-- Accept/Decline except Overtime request -->
  <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="decline{{$id}}">
    <div class="z-40 overflow-auto left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-black opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto">
      
      <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50" onclick="toggleModal('decline{{$id}}')">
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
                      Do you really want to decline request {{$request->type}} from {{$request->employee_name}} at {{Carbon\Carbon::parse($request->date)->format('d F Y')}} ?<br>@if($order == null) Cancel order request doesn't work because {{$request->employee_name}} did't have a catering schedule @endif<br> This process cannot be undone.
                  </div>
                  <div class="flex justify-center">
                      <button class="modal-close bg-gray-300 text-gray-900 rounded hover:bg-gray-200 px-6 py-2 focus:outline-none mx-1" onclick="toggleModal('decline{{$id}}')">Cancel</button>
                      <button wire:click="actionRequest({{ $id }}, 'Decline')" class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-6 py-2 focus:outline-none mx-1">Decline</button>
                  </div>
              </div>
          </div>
         
        </div>
    </div>
  </div>
  <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="accept{{$id}}">
    <div class="z-40 overflow-auto left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-black opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto">
      
      <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50" onclick="toggleModal('accept{{$id}}')">
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
                          class="material-icons border-4 rounded-full p-4 text-blue-500 font-bold border-blue-500 text-4xl">
                          done
                      </span>
                  </div>
                  <div class="text-center py-6 text-2xl text-gray-700">Are you sure ?</div>
                  <div class="text-center font-light text-gray-700 mb-8">
                      Do you really want to accept request {{$request->type}} from {{$request->employee_name}} at {{Carbon\Carbon::parse($request->date)->format('d F Y')}} ?<br>@if($order == null) Cancel order request doesn't work because {{$request->employee_name}} did't have a catering schedule @endif<br> This process cannot be undone.
                  </div>
                  <div class="flex justify-center">
                      <button class="modal-close bg-gray-300 text-gray-900 rounded hover:bg-gray-200 px-6 py-2 focus:outline-none mx-1" onclick="toggleModal('accept{{$id}}')">Cancel</button>
                      <button wire:click="actionRequest({{ $id }}, 'Accept')" class="bg-blue-500 text-gray-200 rounded hover:bg-blue-400 px-6 py-2 focus:outline-none mx-1">Accept</button>
                  </div>
              </div>
          </div>
         
        </div>
    </div>
  </div>

<!--Modal overtime -->
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
          <p class="text-xl font-semibold leading-tight">Overtime Agreement <span class="font-bold"></span> </p>
        
          </div>
          <div class="modal-close cursor-pointer z-50" onclick="toggleModal('edit{{$id}}')">
            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
              <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
            </svg>
          </div>
        </div>
            @if(auth()->user()->roles == 'Admin')
            <form action="{{route('admin.request.accept', $request->id)}}" method="POST">
            @else
            <form action="{{route('manager.request.accept', $request->id)}}" method="POST">
            @endif
            @csrf
            
                <div class="bg-white px-4 pb-4 sm:p-6 sm:pb-4 font-semibold">

                    <div class=""> 
                       
                        <div class="mb-4 px-2">
                            <label for="formType" class="block text-gray-500 text-sm  mb-2">Request Type</label>
                            <select class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formType" name="type" disabled>
                                <option hidden>Choose here...</option>
                                <option @if($request->type == 'Sick') selected @endif>Sick</option>
                                <option @if($request->type == 'Annual Leave') selected @endif>Annual Leave</option>
                                <option @if($request->type == 'Overtime') selected @endif>Overtime</option>
                            </select>
                            @error('type') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4 px-2">
                            <label for="formDate" class="block text-gray-500 text-sm  mb-2">Date </label>
                            <input type="date" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" name="date" value="{{Carbon\Carbon::parse($request->date)->format('Y-m-d')}}" id="formDate" min="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" readonly>
                            @error('date') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4 px-2">
                            <label for="formDesc" class="block text-gray-500 text-sm  mb-2">Description </label>
                            <input type="text" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" name="desc" value="{{$request->desc}}" id="formDesc" placeholder="fill in here..." readonly>
                            @error('desc') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4 px-2">
                            <label for="formTime" class="block text-gray-500 text-sm  mb-2">Time (minute) :</label>
                            <input type="number" class="shadow appearance-none hover:pointer border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="formTime" value="{{$request->time}}" placeholder="fill in here..." name="time">
                            @error('time_overtime') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
    
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Send
                            </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        
                        <button onclick="toggleModal('edit{{$id}}')" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Cancel
                        </button>
                    </span>
                </div>
            </form>
      </div>
    </div>
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
                  <div>
                      <span
                          class="material-icons border-4 rounded-full p-4 text-red-500 font-bold border-red-500 text-4xl">
                          close
                      </span>
                  </div>
                  <div class=" py-6 text-2xl text-gray-700">Are you sure ?</div>
                  <div class=" font-light text-gray-700 mb-8">
                      Do you really want to Delete request <span class="font-semibold">{{$request->type}}</span> from {{$request->employee_name}} at {{Carbon\Carbon::parse($request->date)->format('d F Y')}} ? This process cannot be undone.
                  </div>
                  <div class="flex justify-center gap-2  ">
                      <button class="modal-close bg-gray-300 text-gray-900 rounded hover:bg-gray-200 px-6 py-2 focus:outline-none mx-1 tracking-wider" onclick="toggleModal('delete{{$id}}')">Cancel</button>
                      <form action="{{route('admin.request.destroy',$id)}}" method="POST">
                      @csrf
                      @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white rounded hover:bg-red-700 px-6 py-2 focus:outline-none mx-1 tracking-wider">Delete Request</button>
                      </form>
                  </div>
              </div>
          </div>
         
        </div>
    </div>
  </div>

	<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="edit{{$id}}-backdrop"></div>

	<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="decline{{$id}}-backdrop"></div>
	<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="accept{{$id}}-backdrop"></div>
  <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="delete{{$id}}-backdrop"></div>
</div>