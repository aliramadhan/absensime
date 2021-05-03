<x-guest-layout>
 <div class="flex flex-row justify-between px-10 top-4 absolute md:inline-flex hidden w-screen items-center">
     <img src="{{ asset('/image/logo2.png')}}" class="img-fluid " width="138px" height="138px">
     <label class="text-xl font-semibold text-gray-600"><span class="text-red-500">A</span>ttendance <span class="text-red-500">A</span>pplication</label>
 </div>
  <div class="h-screen md:min-h-screen flex flex-col sm:justify-center items-center pt-0 md:pt-6 sm:pt-0 " 
  style="background-image: linear-gradient(to top, #cfd9df 0%, #e2ebf0 100%);">   
  <div class="md:h-auto h-screen w-full sm:max-w-sm m-0 md:mt-6 px-7 py-7 bg-white shadow-xl overflow-hidden sm:rounded-2xl grid">
  
   <div class="flex items-center gap-4">
     <a href="{{ route('login') }}" class="px-3 py-1 font-semibold hover:bg-gray-400 duration-300 rounded-full text-gray-600 hover:text-white cursor-pointer text-2xl"><i class="fas fa-chevron-left"></i></a>
     <label class="font-bold text-2xl text-gray-700 flex-auto  tracking-wide">Forgot Password</label>        
 </div>
    <img src="{{ asset('/image/logo.png')}}" class="img-fluid mx-auto my-auto" width="100px" height="100px">
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    @if (session('status'))
    <div class="font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
    @endif

    <x-jet-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.email') }}" >
        @csrf       
        <div class="relative flex w-full flex-wrap items-stretch my-1">
            <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-10 pl-3 py-3">
                <img src="{{ asset('/image/name.svg')}}" alt="username" class="w-6 opacity-50" >
            </span>
            <x-jet-input type="email" name="email" :value="old('email')" required autofocus placeholder="{{ __('Email') }}" class="px-3 py-2 placeholder-gray-400 text-gray-700 relative bg-white bg-white rounded text-sm shadow outline-none focus:outline-none focus:shadow-outline w-full pl-12 text-lg hover:border-blue-400 duration-1000"/>
        </div>     


        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="py-3 bg-yellow-500 uppercase tracking-widest text-sm">
                {{ __('Send Reset Link') }}
            </x-jet-button>
        </div>
    </form>

</div>
</div>
</x-guest-layout>
