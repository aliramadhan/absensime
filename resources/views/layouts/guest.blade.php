<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('image/favicon.png') }}">
    <title>{{ config('app.name', 'Attendence App') }}</title>

    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <style type="text/css">
       html,body,table{
        font-family: 'Poppins', sans-serif;  
        background-image: linear-gradient(to top, #cfd9df 0%, #e2ebf0 100%);     
    }
    .modal {
      transition: opacity 0.25s ease;
  }
  body.modal-active {
      overflow-x: hidden;
      overflow-y: visible !important;
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

<script type="text/javascript">
  function modalfu() {}
</script>
</head>

<body onload="modalfu();loader24()">
     <div id="loader-bk" class="overflow-x-hidden overflow-y-hidden fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center">
             <section id="loader" class="h-full w-full border-box  transition-all duration-500 flex bg-gray-500 opacity-75"    >   
                <div class="text-6xl text-white m-auto text-center">        
                   <i class="fas fa-circle-notch animate-spin"></i>
               </div>
           </section>
       </div>   
<div style="display:none;" id="myDiv" class="animate-bottom contents">
    <div class="text-gray-900 antialiased">
        {{ $slot }}
    </div>
</div>
</body>
<script src="{{ asset('/js/modal.js') }}" defer></script>
 <script type="text/javascript">        
        var myVar;
        function loader24() {
          myVar = setTimeout(showPage, 300);
        }

        function showPage() {
          document.getElementById("loader-bk").style.display = "none";
          document.getElementById("loader").style.display = "none";
          
          document.getElementById("myDiv").style.display = "block";
        }

      </script>
</html>
