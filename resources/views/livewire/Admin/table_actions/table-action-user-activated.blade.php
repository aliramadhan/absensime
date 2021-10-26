  <i  class="modal-open fas fa-check cursor-pointer ml-2 focus:outline-none bg-transparent border border-green-500 hover:bg-green-500 text-green-500 hover:text-white font-bold py-3 px-3 rounded-full" onclick="toggleModal('activate{{$id}}')"></i>
  <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="activate{{$id}}">
    <div class="z-40 overflow-auto left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-black opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto">
      
      <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50" onclick="toggleModal('activate{{$id}}')">
        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
          <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
        </svg>
        <span class="text-sm">(Esc)</span>
      </div>

      <!-- Add margin if you want to see some of the overlay behind the modal-->
        <div x-show="showDeleteModal" tabindex="0" class="z-40 w-full h-full ">
          <div class="z-50 relative p-3 mx-auto my-0 max-w-full">
            <form method="POST" action="{{route('admin.users.activation',$user)}}">
            @csrf
              <div class="text-center flex flex-col overflow-hidden px-10 py-10 my-auto">
                  <div>
                      <span
                          class="material-icons border-4 rounded-full p-4 text-green-500 font-bold border-green-500 text-4xl">
                          done
                      </span>
                  </div>
                  <div class=" py-6 text-2xl text-gray-700">Are you sure ?</div>
                  <div class=" font-light text-gray-700 mb-8">
                      Do you really want to activate <span class="font-semibold">{{$user->name}}</span>? This process cannot be undone.
                  </div>
                  <div class="flex justify-center gap-2  ">
                      <button class="modal-close bg-gray-300 text-gray-900 rounded hover:bg-gray-200 px-6 py-2 focus:outline-none mx-1 tracking-wider" onclick="toggleModal('activate{{$id}}')">Cancel</button>
                      <button type="submit" class="bg-green-500 text-white rounded hover:bg-green-700 px-6 py-2 focus:outline-none mx-1 tracking-wider">Activate</button>
                  </div>
              </div>
            </form>
          </div>
         
        </div>
    </div>
  </div>

<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="activate{{$id}}-backdrop"></div>
<!-- iki tambahan -->

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