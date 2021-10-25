<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('image/favicon.png') }}">
  <title>Attendance - 24Slides Indonesia</title>
  <title> @if (isset($title)){{ $title }} @endif</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Roboto@100;300;500" rel="stylesheet">  

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  @livewireStyles

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}" defer></script>
  <style type="text/css">   
  
  /* width */
  ::-webkit-scrollbar {
    width: 6px !important;

  }

  /* Track */
  ::-webkit-scrollbar-track {
    box-shadow: inset 0 0 1px grey;  
  }
  
  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: gray; 
    border-radius: 14px;
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #74b9ff; 
  }
  .scroll::-webkit-scrollbar{
    height: 5px;
  }
  .backdrop-blur-xl {
    --tw-backdrop-blur: blur(24px);
  }
  .backdrop-filter {
   
    --tw-backdrop-brightness: var(--tw-empty, );
    --tw-backdrop-contrast: var(--tw-empty, );
    --tw-backdrop-grayscale: var(--tw-empty, );
    --tw-backdrop-hue-rotate: var(--tw-empty, );
    --tw-backdrop-invert: var(--tw-empty, );
    --tw-backdrop-opacity: var(--tw-empty, );
    --tw-backdrop-saturate: var(--tw-empty, );
    --tw-backdrop-sepia: var(--tw-empty, );
    -webkit-backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);
    backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);
  }
</style>
<style type="text/css">
html,body,table{
  font-family: 'Poppins', sans-serif;       
}
.text-orange-500{
  color: #FF5B27;
}
.bg-orange-500{
  background-color: #FF5B27;
}
.toggle-checkbox:checked {
  @apply: right-0 border-green-400;
  right: 0;
  border-color: #D1D5DB;
  border: 2px solid #fff;
}
.toggle-checkbox:checked + .toggle-label {
  @apply: bg-green-400;
  background-color: #D1D5DB;
}
.progress-ring {

}
.modal {
  transition: opacity 0.25s ease;
}

.progress-ring__circle {
  transition: 0.35s stroke-dashoffset;

  transform: rotate(-90deg);
  transform-origin: 50% 50%;
}
.hover-trigger .hover-target {
  display: none;
}

.hover-trigger:hover .hover-target {
  display: block;
}
.hide-scroll {  
  overflow-y: scroll; /* Add the ability to scroll */
  overflow-x: scroll;
}

/* Hide scrollbar for Chrome, Safari and Opera */
.hide-scroll::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.hide-scroll {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}

.form-input {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background-color: #fff;
  border-color: #d2d6dc;
  border-width: 1px;
  border-radius: .375rem;      
  line-height: 1.5;
}


</style>

</style>
</head>

<body class="antialiased">
  <x-jet-banner />

  <div class="min-h-screen bg-gradient-to-r from-gray-100 to-gray-200">

    @livewire('navigation-menu')

    <!-- Page Heading -->
    @if (isset($header))
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if (session()->has('success'))    
        <div class="flex fixed bottom-10 z-20 left-10" x-data="{ showNotif: true }" x-show="showNotif" x-transition:leave="transition duration-100 transform ease-in" x-transition:leave-end="opacity-0 scale-90" x-init="setTimeout(() => showNotif = false, 5000)">
          <div class="m-auto">
            <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-xl">
              <div class="flex flex-row">
                <div class="px-2">
                  <svg width="24" height="24" viewBox="0 0 1792 1792" fill="#44C997" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1299 813l-422 422q-19 19-45 19t-45-19l-294-294q-19-19-19-45t19-45l102-102q19-19 45-19t45 19l147 147 275-275q19-19 45-19t45 19l102 102q19 19 19 45t-19 45zm141 83q0-148-73-273t-198-198-273-73-273 73-198 198-73 273 73 273 198 198 273 73 273-73 198-198 73-273zm224 0q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z"/>
                  </svg>
                </div>
                <div class="ml-2 mr-6">
                  <span class="font-semibold">Processing was Successful!</span>
                  <span class="block text-gray-500">{{ session('success') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>      
        @endif

        @if (session()->has('failure'))
        <div class="flex fixed bottom-10 z-20 left-10" x-data="{ showNotif: true }" x-show.transition="showNotif" x-init="setTimeout(() => showNotif = false, 5000)">
          <div class="m-auto">
            <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-xl">
              <div class="flex flex-row">
                <div class="px-2">
                  <i class="fas fa-times-circle text-red-600"></i>
                </div>
                <div class="ml-2 mr-6">
                  <span class="font-semibold">Somethings wrong!</span>
                  <span class="block text-gray-500">{{ session('failure') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>          
        @endif
        
        
        {{ $header }}
      </div>
    </header>
    @endif

    <!-- Page Content -->
    @php
    $user_agent = $_SERVER['HTTP_USER_AGENT']; 
    @endphp
    @if((stripos( $user_agent, 'Chrome') !== false) || (preg_match('/Firefox/i', $user_agent)))

    
    <main>
     
     <script type="text/javascript">       
       
       function notifyMe() {
      // Let's check if the browser supports notifications
      
      
      if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
      }

      // Let's check whether notification permissions have already been granted
      else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        notify = new Notification("Attendance Notification",{
            // judul notifikasi
            body : "Windows Notification is active now",
            // icon notifikasi
            icon : "{{ asset('image/logo.png') }}"
          });
        
      }

      // Otherwise, we need to ask the user for permission
      else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
          // If the user accepts, let's create a notification
          if (permission === "granted") {
           notify = new Notification("Attendance Notification",{
            // judul notifikasi
            body : "Windows Notification is active now",
            // icon notifikasi
            icon : "{{ asset('image/logo.png') }}"
          });
         }
       });

      }
    }
    setInterval(function(){
      if (Notification.permission === "granted" ){
        document.getElementById("Notificationbtn").className = 'hidden';
      }
    }, 1000);
  </script>
  <div x-data="{ notify: true }">
    <div class="hidden" id="Notificationbtn"  x-show="notify" x-transition>
      <label>Now we have added a new feature, If you want to enable windows notification please allow our permission</label>
      <button onclick="notifyMe()" class="rounded-lg px-4 text-sm border font-semibold border-gray-400 hover:text-white tracking-wide hover:bg-gray-600  py-2 duration-300">Notify me!</button>
      <button @click="notify = !notify" class="absolute -top-3 right-20 rounded-full bg-gray-900 text-white h-6 w-6 hover:bg-white hover:text-gray-900 hover:border duration-300 flex focus:rounded-full focus:outline-none" ><i class="fas fa-times m-auto"></i></button>
    </div>
  </div>
  {{ $slot }}
</main>



@elseif(stripos( $user_agent, 'Safari') !== false)    
<div class="p-4 flex justify-center flex flex-col h-screen space-y-4 text-center">
  <label>
    Sorry Attendance app doesn't support on Safari Browser now
  </label>
  <a href="https://pahlawandesignstudio.com" class="mx-auto bg-blue-500 px-5 py-2 rounded-lg text-white font-semibold tracking-wider w-max shadow-lg hover:bg-blue-700 duration-300 text-sm">Back to Homepage</a>
</div>
@endif

</div>
<footer class="text-gray-600 body-font z-0">
  <div class="container lg:px-5 md:px-4 px-2 py-8 mx-auto flex items-center flex-col md:flex-row">
    <a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
     <img class="mb-1 logo-login h-10" src="{{ asset('/image/logo2.png')}}" alt="24Slides-logo" height="38px">
     <span class="ml-3 text-xl">Indonesia</span>
   </a>
   <p class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">© 2021 24Slides —
    <a href="#" class="text-gray-600 ml-1" rel="ADN Dev" target="_blank">ADN</a>
  </p>
  <span class="flex-col text-center sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start lg:w-auto md:w-4/12">
    You have problem or suggestion about app ? 
    <a href="mailto:sigit@24slides.com?&cc=fajarfaz@gmail.com&subject=My%20Ask&body=your subject" class="ml-2 font-semibold hover:text-blue-400"> Email Us</a>
  </span> 
</div>
</footer>
@stack('modals')

@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10">
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
<script type="text/javascript">
  @if(Session::has('success'))
  Swal.fire({
    titleText: "{{ session('success') }}",
    icon: 'success',
    position: 'center', 
    timer: 3000,
    toast: false,
    showConfirmButton: false,
  });
  @endif
  @if(Session::has('failure'))
  Swal.fire({
    titleText: "{{ session('failure') }}",
    icon: 'error',
    position: 'center', 
    timer: 3000,
    toast: false,
    showConfirmButton: false,
  });
  @endif
</script>
<script >
  window.onload = function checkBtnNotif() {

   if(Notification.permission === 'denied' || Notification.permission === 'default') {
    document.getElementById("Notificationbtn").className = 'shadow-md md:fixed w-full bottom-0 bg-white border-t hidden md:block text-center py-4 z-50 flex flex-row space-x-3 hidden';
  } else {
    document.getElementById("Notificationbtn").className = 'hidden';
  }

}
</script>
</body>
</html>
