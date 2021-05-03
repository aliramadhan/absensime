<!-- @if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


 -->
@if ($errors->any())
<script type="text/javascript">
   function modalfu(){
    document.getElementById('modal-click').click();
    var scriptTag = document.createElement("script");
    scriptTag.src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js";
    document.getElementsByTagName("head")[0].appendChild(scriptTag);
  }          
</script>

<div {{ $attributes }}>
 <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50" id="login-danger">
  <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>  
  <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-xl shadow-lg z-50 overflow-y-auto">
    <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
      <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
      </svg>
      <span class="text-sm">(Esc)</span>
    </div>

    <!-- Add margin if you want to see some of the overlay behind the modal-->
    <div class="modal-content py-4 text-left px-6">
      <!--Title-->
      <div class="flex justify-between items-end pb-3">
       
        
        <div class="modal-close cursor-pointer z-50">
          <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
          </svg>
        </div>
      </div>
      <div class="flex flex-col text-center items-center pb-4">
        <i class="far fa-times-circle bg-gray-50 text-red-400 text-6xl rounded-full"></i>
        <p class="text-2xl font-bold text-red-500 tracking-wide mt-4">Login Failed</p>
        <p class="text-gray-600 font-semibold mt-0 mb-6"> 
          @foreach ($errors->all() as $error)
          {{ $error }}
          @endforeach
      </p>
       <a href="#" class="modal-close bg-red-400 text-white px-7 py-2 rounded-lg hover:bg-red-500 duration-300 font-semibold tracking-wider">Try Again</a>
      </div>

      <!--Footer-->

     
    </div>
  </div>
</div>




</div>
@endif

