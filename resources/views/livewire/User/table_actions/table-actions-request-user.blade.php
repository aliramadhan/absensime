
  <i  class="modal-open fas fa-trash-alt cursor-pointer ml-2 focus:outline-none bg-transparent border border-red-500 hover:bg-red-500 text-red-500 hover:text-white font-bold py-3 px-3 rounded-full" onclick="toggleModal('delete{{$id}}')"></i>

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
                      Do you really want to Cancel your request <span class="font-semibold">{{$request->type}}</span> at {{Carbon\Carbon::parse($request->date)->format('d F Y')}} ? This process cannot be undone.
                  </div>
                  <div class="flex justify-center gap-2  ">
                      <button class="modal-close bg-gray-300 text-gray-900 rounded hover:bg-gray-200 px-6 py-2 focus:outline-none mx-1 tracking-wider" onclick="toggleModal('delete{{$id}}')">Cancel</button>
                      <form action="{{route('user.request.destroy',$id)}}" method="POST">
                      @csrf
                      @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white rounded hover:bg-red-700 px-6 py-2 focus:outline-none mx-1 tracking-wider">Cancel Request</button>
                      </form>
                  </div>
              </div>
          </div>
         
        </div>
    </div>
  </div>

<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="edit{{$id}}-backdrop"></div>
<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="delete{{$id}}-backdrop"></div>
<!-- iki tambahan -->
<script type="text/javascript">
  function toggleModal(modalID){
    document.getElementById(modalID).classList.toggle("hidden");
    document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
    document.getElementById(modalID).classList.toggle("flex");
    document.getElementById(modalID + "-backdrop").classList.toggle("flex");
  }
</script>