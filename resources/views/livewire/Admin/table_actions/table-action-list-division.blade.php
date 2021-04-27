 <i class="modal-open fas fa-pencil-alt focus:outline-none bg-transparent border border-yellow-500 hover:bg-yellow-400 text-yellow-500 hover:text-white font-bold py-3 px-3 rounded-full pointer cursor-pointer" onclick="toggleModal('edit{{$id}}')"></i>
  <i  class="modal-open fas fa-trash-alt cursor-pointer ml-2 focus:outline-none bg-transparent border border-red-500 hover:bg-red-500 text-red-500 hover:text-white font-bold py-3 px-3 rounded-full" onclick="toggleModal('delete{{$id}}')"></i>
  <!--Modal edit -->

  <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="edit{{$id}}">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto">
      
      <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50" onclick="toggleModal('edit{{$id}}')">
        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
          <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
        </svg>
        <span class="text-sm">(Esc)</span>
      </div>

      <!-- Add margin if you want to see some of the overlay behind the modal-->
      <div class="modal-content py-4 text-left">
        <!--Title-->
        <div class="flex justify-between items-center pb-3 border-b px-6">
          <p class="text-2xl font-base text-gray-700">Editing <span class="font-semibold">{{$division->name}}</span></p>
          <div class="modal-close cursor-pointer z-50" onclick="toggleModal('edit{{$id}}')">
            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
              <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
            </svg>
          </div>
        </div>
       
            <form action="{{route('admin.division.update',$id)}}" method="POST" >
            @csrf
            @method('PUT')
                <div class="bg-white  pt-5 pb-4 sm:p-6 sm:pb-4 ">
                        <div class="mb-4">
                            <label for="formName" class="block text-gray-600 text-sm font-semibold mb-2">Division Name:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-600 leading-tight focus:outline-none focus:shadow-outline" id="formName" name="name" value="{{$division->name}}">
                            @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="formDesc" class="block text-gray-600 text-sm font-semibold mb-2">Division Description:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-600 leading-tight focus:outline-none focus:shadow-outline" id="formDesc" name="desc" value="{{$division->desc}}">
                            @error('desc') <span class="text-red-500">{{ $message }}</span>@enderror
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
                      Do you really want to delete <span class="font-semibold">{{$division->name}}</span> ? This process cannot be undone.
                  </div>
                  <div class="flex justify-center gap-2  ">
                      <button class="modal-close bg-gray-300 text-gray-900 rounded hover:bg-gray-200 px-6 py-2 focus:outline-none mx-1 tracking-wider" onclick="toggleModal('delete{{$id}}')">Cancel</button>
                      <form method="POST" action="{{route('admin.division.destroy',$id)}}">
                      @csrf
                      @method('delete')
                        <button type="submit" class="bg-red-500 text-white rounded hover:bg-red-700 px-6 py-2 focus:outline-none mx-1 tracking-wider">Delete</button>
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

   <!--  @php  
   if($id==count($this->results)){ 
   @endphp
    <script type="text/javascript">

      var openmodal = document.querySelectorAll('.modal-open')
      let selectedModalTargetId = ''
      for (var i = 0; i < openmodal.length; i++) {
        openmodal[i].addEventListener('click', function(event){
         selectedModalTargetId = event.target.attributes.getNamedItem('data-target').value
         event.preventDefault()
         toggleModal()
       })
      }


      const overlay = document.querySelector('.modal-overlay')
      if (overlay) {
        overlay.addEventListener('click', toggleModal)
      }
      var closemodal = document.querySelectorAll('.modal-close')
      for (var i = 0; i < closemodal.length; i++) {
        closemodal[i].addEventListener('click', toggleModal)
      }

      document.onkeydown = function(evt) {
        evt = evt || window.event
        var isEscape = false
        if ("key" in evt) {
          isEscape = (evt.key === "Escape" || evt.key === "Esc")
        } else {
          isEscape = (evt.keyCode === 27)
        }
        if (isEscape && document.body.classList.contains('modal-active')) {
          toggleModal()
        }
      }

      function toggleModal () {
        if(!selectedModalTargetId) {
          return
        }
        const body = document.querySelector('body')
        const modal = document.getElementById(selectedModalTargetId)
        modal.classList.toggle('opacity-0')
        modal.classList.toggle('pointer-events-none')
        body.classList.toggle('modal-active')
      }
    </script>

     @php
  }  @endphp
 -->