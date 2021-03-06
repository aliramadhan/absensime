<x-guest-layout>
  <div class="flex flex-row justify-between px-10 top-4 absolute md:inline-flex hidden w-screen items-center">
   <img src="{{ asset('/image/logo2.png')}}" class="img-fluid " width="138px" height="138px">
   <label class="text-xl font-semibold text-gray-600 hover:text-red-500 duration-300"><span class="text-red-500">A</span>ttendance <span class="text-red-500">A</span>pplication</label>
 </div>

   <div class="h-screen md:min-h-screen flex flex-col sm:justify-center items-center pt-0 md:pt-6 sm:pt-0 " 
   style="background-image: linear-gradient(to top, #cfd9df 0%, #e2ebf0 100%);">   
   <div class="md:h-auto h-full w-full sm:max-w-sm m-0 md:mt-6 px-7 py-12 md:py-7 bg-white shadow-xl overflow-hidden sm:rounded-2xl grid">
   <x-jet-validation-errors />     
        
      <button class="modal-open visible absolute" id="modal-click" data-toggle="modal" data-target="login-danger"></button>
       @if (session('status'))
       <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="grid text-gray-600 gap-2 md:pb-0 pb-8">
        @csrf
         <img src="{{ asset('/image/logo.png')}}" class="img-fluid mx-auto my-auto h-40 md:h-28">   
         <div class="flex flex-col space-y-2 justify-center">
            <label class="font-semibold text-2xl leading-none text-gray-800">Sign in </label>
            <label class="font-base  text-lg leading-tight">Sign in and start recording your attendance.</label>
        </div>
        <div class="grid gap-2">
            <div class="relative flex w-full flex-wrap items-stretch my-1">
                <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-10 pl-3 flex items-center md:py-3">
                    <img src="{{ asset('/image/name.svg')}}" alt="icon" class="w-6 opacity-50" >
                </span>
                <x-jet-input type="email" name="email" autocomplete="username" :value="old('email')" required autofocus placeholder="{{ __('Email') }}" class="px-3 py-2 placeholder-gray-400 text-gray-700 relative bg-white bg-white rounded text-sm shadow outline-none focus:outline-none focus:shadow-outline w-full pl-12 text-lg hover:border-blue-400 duration-1000" min="5" max="30"/>
            </div>     

            <div class="relative flex w-full flex-wrap items-stretch ">
                <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 flex items-center md:py-3">
                    <img src="{{ asset('/image/padlock.svg')}}" alt="lock" class="w-6 opacity-50" >
                </span>
                <x-jet-input  type="password" id="password" name="password" autocomplete="current-password" required autofocus placeholder="{{ __('Password') }}" class="px-3 py-2 placeholder-gray-400 text-gray-700 relative bg-white bg-white rounded text-sm shadow outline-none focus:outline-none focus:shadow-outline w-full pl-12 text-lg hover:border-blue-400 duration-1000" min="5" max="30"/>
            </div>      
        </div>   
        <div class="block mb-3 mt-1">
            <label for="remember_me" class="flex items-center">
                <x-jet-checkbox id="remember_me" name="remember" />
                <span class="ml-2 text-base text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="flex md:flex-row flex-col items-center justify-between gap-2">
         
            @if (Route::has('password.request'))
            <a class="underline text-base text-right text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif
            <x-jet-button class="font-semibold md:text-base text-xl bg-blue-400 text-center md:py-2 py-4 px-8 hover:bg-blue-600 md:w-auto w-full focus:border-yellow-100 duration-500">
                {{ __('Sign In') }}
            </x-jet-button>
        </div>
    </form>

</div>
</div>
</x-guest-layout>
