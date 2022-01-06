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
  <script src="{{ mix('js/app.js') }}" defer></script>

  <style type="text/css">   
    @-moz-document url-prefix() {
     .backdrop-blur-xl {  
      background : #fff;
    }
  }
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

    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
  }

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
  #loader {
   position: sticky;
   z-index: 1;
   top: 50%;
   margin: auto;
 }

 

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}



</style>
</head>

<body class="antialiased" >

 <div id="loader-bk" class="z-40 w-screen h-screen absolute bg-gradient-to-r from-white to-gray-100"  >
  <div id="loader">
    <div class="animate-spin w-28 h-28 relative m-auto">
      <svg version="1.1" id="L3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
      <circle fill="none" stroke="#66A3FA" stroke-width="5" cx="50" cy="50" r="44"/>
      <circle fill="#66A3FA" stroke="#fff" stroke-width="3" cx="8" cy="54" r="6" >
       <animateTransform
       attributeName="transform"
       dur="2s"
       type="rotate"
       from="0 50 48"
       to="360 50 52"
       repeatCount="indefinite" />

     </circle>
   </svg>
 </div>

</div>
</div>
<div style="display:none;" id="showBody" class="animate-bottom contents" id="showBody"> 


  <div class="min-h-screen bg-gradient-to-r from-gray-100 to-gray-200"  > 
    <x-jet-banner />

    @livewire('navigation-menu')

    <!-- Page Heading -->
    @if (isset($header))
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $header }}
      </div>
    </header>
    @endif

    <!-- Page Content -->
    @php

    $user_agent = $_SERVER['HTTP_USER_AGENT']; 
    @endphp
    @if((stripos( $user_agent, 'Chrome') !== false) || (preg_match('/Firefox/i', $user_agent))  || strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== false || (stripos( $user_agent, 'Safari') == false))
   
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

   
    @elseif (stripos( $user_agent, 'Safari') !== false)

    <div class="p-4 flex justify-center flex flex-col h-screen space-y-4 text-center">
      <label>
        Sorry Attendance app doesn't support on Safari Browser now
      </label>
      <a href="https://pahlawandesignstudio.com" class="mx-auto bg-blue-500 px-5 py-2 rounded-lg text-white font-semibold tracking-wider w-max shadow-lg hover:bg-blue-700 duration-300 text-sm">Back to Homepage</a>
    </div>
    @else
    {{$user_agent}}

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
</div>
@stack('modals')

@livewireScripts
<script type="text/javascript">    


</script>

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
  @if($errors->any())
  Swal.fire({
    titleText: "{{ implode('', $errors->all(':message')) }}",
    icon: 'error',
    position: 'center', 
    timer: 3000,
    toast: false,
    showConfirmButton: false,
  });
  @endif
</script>
<script >
  window.onload = function loader() {
    myVar = setTimeout(showPage, 300);
  }
  function showPage() {
    document.getElementById("loader-bk").style.display = "none";
    document.getElementById("loader").style.display = "none";  
    document.getElementById("showBody").style.display = "block";
    if(Notification.permission === 'denied' || Notification.permission === 'default') {
      document.getElementById("Notificationbtn").className = 'shadow-md md:fixed w-full bottom-0 bg-white border-t hidden md:block text-center py-4 z-50 flex flex-row space-x-3 hidden';
    } else {
      document.getElementById("Notificationbtn").className = 'hidden';
    }

  }

</script>
</body>
</html>
