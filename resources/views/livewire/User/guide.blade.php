<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Application Guide') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 hidden sm:block">
       <iframe class="w-full bg-white h-screen rounded-lg shadow-md" src="https://docs.google.com/document/d/e/2PACX-1vTjjMpetIiE_9tb0_cREr4rhh8eZf5jmEE4Vz7vDmGPXFgffsMYB_Q3JaK_GMzguheZ5vD133_DJkVQ/pub?embedded=true"></iframe>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 block md:hidden">
        <label class="px-4 flex text-center flex-col ">Guide content is not compatible on mobile devices, please open it from this link 
            <a href="https://docs.google.com/document/d/1NvqMYOHXEVKNt_gzspzMqttZWG0Q09_crvG9Tm342xU/edit?usp=sharing" class="bg-blue-400 text-white rounded-md px-3 py-1 hover:bg-blue-600 duration-300 cursor-pointer w-max mx-auto mt-2">Go to Google Docs</a> </label>
    </div>
</div>