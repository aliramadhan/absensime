<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
   <link rel="shortcut icon" href="{{ asset('image/favicon.png') }}">
    <title>{{ config('app.name', 'Attendence App') }}</title>
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
      width: 6px;

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
    
    
    
  </style>

</style>
</head>
<body class="antialiased">
  
  <div>
    @if (session()->has('success'))
    <div class="flex absolute bottom-10 " x-data="{ show: true }" x-show="show" x-transition:leave="transition duration-100 transform ease-in" x-transition:leave-end="opacity-0 scale-90" x-init="setTimeout(() => show = false, 1000)">
      <div class="m-auto">
        <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-lg">
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
    <div class="flex absolute bottom-10 " x-data="{ show: true }" x-show.transition="show" x-init="setTimeout(() => show = false, 1000)">
      <div class="m-auto">
        <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-lg">
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
  </div>
  <x-jet-banner />

  <div class="min-h-screen bg-gray-100">

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
    <main>
      {{ $slot }}
    </main>
  </div>

  @stack('modals')

  @livewireScripts
</body>
</html>
