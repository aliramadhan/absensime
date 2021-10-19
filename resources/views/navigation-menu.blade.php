<nav  class=" border-gray-100 sticky top-0 z-10 " :class="{'border-b border-gray-200 backdrop-filter backdrop-blur-xl bg-opacity-90 ' : !atTop ,'bg-white border-b' : atTop  }" x-data="{open: false, atTop: true   }" @scroll.window="atTop = (window.pageYOffset > 40) ? false : true"
   >
    <!-- Primary Navigation Menu -->

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    @if(auth()->user()->role == 'Admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center cursor-pointer hover:text-gray-700">
                        <img class="h-10" src="{{ asset('image/logo.png') }}" alt="" height="38px">
                        <label class=" text-gray-700 font-semibold text-sm flex flex-col cursor-pointer hover:text-gray-700 duration-300 leading-none"><span>Attendance</span><span>application</span></label>
                    </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="flex items-center cursor-pointer hover:text-gray-700">
                          <img class="h-10" src="{{ asset('image/logo.png') }}" alt="" height="38px">
                        <label class=" text-gray-700 font-semibold text-sm flex flex-col cursor-pointer leading-none"><span>Attendance</span><span>application</span></label>
                        </a>
                    @endif
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-20 lg:flex" :class="{'text-gray-500': atTop, 'text-gray-900' : !atTop}">
                    @if(auth()->user()->roles == 'Admin')
                    <x-jet-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('admin.shift') }}" :active="request()->routeIs('admin.shift')">
                        {{ __('Shift') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('admin.schedule') }}" :active="request()->routeIs('admin.schedule')">
                        {{ __('Schedule') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('admin.request') }}" :active="request()->routeIs('admin.request')">
                        {{ __('Request') }}
                    </x-jet-nav-link>                             
                    <x-jet-nav-link href="{{ route('admin.guide') }}" :active="request()->routeIs('admin.guide')">
                        {{ __('Guide') }}
                    </x-jet-nav-link>                          
                    

                    <div class="hidden lg:flex sm:items-center sm:ml-6 hover:border-gray-300  focus:outline-none focus:text-gray-700 focus:border-gray-300  border-transparent 
                        transition duration-150 ease-in-out  hover:text-gray-700">
                            <x-jet-dropdown align="right" width="48">
                                <x-slot name="trigger">

                                    <button class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 focus:outline-none ">
                                        <div>Additional</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>

                                </x-slot>

                                <x-slot name="content">

                                    <!-- User Management -->
                                    <div class="block px-4 py-2 text-base text-gray-700 font-semibold border-b">
                                        {{ __('Additonal Config') }}
                                    </div>
                                     
                                      <x-jet-dropdown-link  href="{{ route('admin.division') }}">
                                        {{ __('Division') }}
                                    </x-jet-dropdown-link> 
                                      
                                    <x-jet-dropdown-link  href="{{ route('admin.leave') }}">
                                        {{ __('List Leave') }}
                                    </x-jet-dropdown-link>                                   
                                   
                                    <x-jet-dropdown-link  href="{{ route('admin.users') }}">
                                        {{ __('Users Account') }}
                                    </x-jet-dropdown-link>

                                </x-slot>

                            </x-jet-dropdown>
                        </div>

                         <div class="hidden sm:flex sm:items-center sm:ml-6 hover:border-gray-300  focus:outline-none focus:text-gray-700 focus:border-gray-300  border-transparent 
                        transition duration-150 ease-in-out  hover:text-gray-700">
                            <x-jet-dropdown align="right" width="48">
                                <x-slot name="trigger">

                                    <button class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 focus:outline-none ">
                                        <div>Report</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>

                                </x-slot>

                                <x-slot name="content">

                                    <!-- User Management -->
                                    <div class="block px-4 py-2 text-base text-gray-700 font-semibold border-b">
                                        {{ __('Report') }}
                                    </div>
    
                                    <x-jet-dropdown-link  href="{{ route('admin.show.schedule') }}">
                                        {{ __('Show Schedule') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link  href="{{ route('admin.employee_presence.report') }}">
                                        {{ __('Attendance Report') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link  href="{{ route('admin.overtime.report') }}">
                                        {{ __('Overtime Report') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link  href="{{ route('admin.schedule_today') }}">
                                        {{ __('Attend Detail Record ') }}
                                    </x-jet-dropdown-link>                                    
                                    <x-jet-dropdown-link  href="{{ route('admin.weekly.report') }}">
                                        {{ __('Weekly Target Report') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link  href="{{ route('admin.all_late.report') }}">
                                        {{ __('All Late Report') }}
                                    </x-jet-dropdown-link>
                                     

                                </x-slot>

                            </x-jet-dropdown>
                        </div>


                    @elseif(auth()->user()->roles == 'Manager')
                    <x-jet-nav-link href="{{ route('manager.dashboard') }}" :active="request()->routeIs('manager.dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('manager.request') }}" :active="request()->routeIs('manager.request')">
                        {{ __('Request') }}
                    </x-jet-nav-link>
                     <x-jet-nav-link href="{{ route('manager.history.schedule') }}" :active="request()->routeIs('manager.history.schedule')">
                        {{ __('Track Record') }}
                    </x-jet-nav-link>   
                     <x-jet-nav-link href="{{ route('manager.show.schedule') }}" :active="request()->routeIs('manager.show.schedule')">
                        {{ __('Show Schedule') }}
                    </x-jet-nav-link>                         
                    <x-jet-nav-link href="{{ route('manager.guide') }}" :active="request()->routeIs('manager.guide')">
                        {{ __('Guide') }}
                    </x-jet-nav-link>   
                    @else
                    <x-jet-nav-link href="{{ route('user.dashboard') }}" :active="request()->routeIs('user.dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-nav-link>
                   
                    <x-jet-nav-link href="{{ route('user.request') }}" :active="request()->routeIs('user.request')">
                        {{ __('Request') }}
                    </x-jet-nav-link>
                     <x-jet-nav-link href="{{ route('user.history.schedule') }}" :active="request()->routeIs('user.history.schedule')">
                        {{ __('Track Record') }}
                    </x-jet-nav-link>
                     <x-jet-nav-link href="{{ route('user.show.schedule') }}" :active="request()->routeIs('user.show.schedule')">
                        {{ __('Show Schedule') }}
                    </x-jet-nav-link>
                     <x-jet-nav-link href="{{ route('user.guide') }}" :active="request()->routeIs('user.guide')">
                        {{ __('Guide') }}
                    </x-jet-nav-link>   
                    @endif
                </div>
            </div>

            <div class="hidden lg:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-jet-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out relative">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    <span class="absolute w-3 h-3 bg-white rounded-full border-2 border-white -top-1 right-0"></span>
                                    <span id="checkOnline"></span>
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-700 border-b">
                                {{ __('Manage Account') }}<br>
                               <label class="text-gray-400"> Status : <span id="checkOnlineWord" class="font-semibold tracking-wide"></span></label>
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>

                 <div class="relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-base leading-4 font-medium rounded-md text-gray-500  hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" :class="{'bg-none': !atTop, 'bg-white': atTop  }">
                                    <img class="h-8 w-8 object-cover border-2 rounded-lg border-red-400 opacity-75 hover:opacity-100 duration-300" src="{{ asset('image/logo.png') }}" alt="{{ Auth::user()->name }}" />
                                   
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- App Management -->
                            <div class="block px-4 py-2 text-xs text-gray-700 font-semibold border-b">
                                {{ __('Change Application') }}
                            </div>
                            <x-jet-dropdown-link href="https://pahlawandesignstudio.com/">                                
                                <i class="fas fa-tv mr-2"></i>{{ __('Homepage') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="https://attendance.pahlawandesignstudio.com/">
                                <i class="fas fa-briefcase mr-2 "></i>{{ __('Attendance') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="https://catering.pahlawandesignstudio.com/">
                             <i class="fas fa-utensils mr-2"></i>{{ __('Catering') }}
                         </x-jet-dropdown-link>

                           
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
           
           
            <div class="-mr-2 flex items-center lg:hidden space-x-2">
               <div class="flex items-center sm:hidden text-xs border rounded-md px-3 shadow h-8 text-gray-500 font-semibold space-x-1">
                   Status: <span id="checkOnlineWord2" class="ml-1"> </span>
               </div>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="pt-2 pb-3 space-y-1">
             @if(auth()->user()->roles == 'Admin')
                    <x-jet-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('admin.shift') }}" :active="request()->routeIs('admin.shift')">
                        {{ __('Shift') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('admin.schedule') }}" :active="request()->routeIs('admin.schedule')">
                        {{ __('Schedule') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('admin.request') }}" :active="request()->routeIs('admin.request')">
                        {{ __('Request') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link  href="{{ route('admin.employee_presence.report') }}">
                        {{ __('Attendance Report') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link  href="{{ route('admin.schedule_today') }}">
                        {{ __('Attend Detail Record ') }}
                    </x-jet-responsive-nav-link>                                    
                    <x-jet-responsive-nav-link  href="{{ route('admin.weekly.report') }}">
                        {{ __('Weekly Target Report') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link  href="{{ route('admin.all_late.report') }}">
                        {{ __('All Late Report') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                        {{ __('Users') }}
                    </x-jet-responsive-nav-link>
                    @elseif(auth()->user()->roles == 'Employee')
                    <x-jet-responsive-nav-link href="{{ route('user.dashboard') }}" :active="request()->routeIs('user.dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-responsive-nav-link>                   
                    <x-jet-responsive-nav-link href="{{ route('user.request') }}" :active="request()->routeIs('user.request')">
                        {{ __('Request') }}
                    </x-jet-responsive-nav-link>
                     <x-jet-responsive-nav-link href="{{ route('user.history.schedule') }}" :active="request()->routeIs('user.history.schedule')">
                        {{ __('History Schedule') }}
                    </x-jet-responsive-nav-link>
                     <x-jet-responsive-nav-link href="{{ route('user.show.schedule') }}" :active="request()->routeIs('user.schedule')">
                        {{ __('Schedule') }}
                    </x-jet-responsive-nav-link>
                    @elseif(auth()->user()->roles == 'Manager')
                    <x-jet-responsive-nav-link href="{{ route('manager.dashboard') }}" :active="request()->routeIs('manager.dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('manager.request') }}" :active="request()->routeIs('manager.request')">
                        {{ __('Request') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('manager.history.schedule') }}" :active="request()->routeIs('manager.history.schedule')">
                        {{ __('History') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('manager.show.schedule') }}" :active="request()->routeIs('manager.show.schedule')">
                        {{ __('Schedule') }}
                    </x-jet-responsive-nav-link>
               
                   
                    @endif
                    
           
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="flex-shrink-0 mr-3 relative">
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
         <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
              

                <div class="hide-scroll">
                    <div class="font-semibold text-base text-gray-800">Change Application</div>
                 
                </div>
            </div>            

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                 <x-jet-responsive-nav-link href="https://pahlawandesignstudio.com/">
                     <i class="fas fa-tv mr-2"></i>{{ __('Homepage') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link href="https://attendance.pahlawandesignstudio.com/">
                     <i class="fas fa-briefcase mr-2 font-semibold"></i>{{ __('Attendance') }}
                </x-jet-responsive-nav-link>
                   <x-jet-responsive-nav-link href="https://catering.pahlawandesignstudio.com/">
                   <i class="fas fa-utensils mr-2"></i>{{ __('Catering') }}
                </x-jet-responsive-nav-link>
           
            </div>
        </div>
    </div>
</nav>

<script type="text/javascript">

  var ifConnected = window.navigator.onLine;
    if (ifConnected) {
       document.getElementById("checkOnlineWord").innerHTML = " Online";
       document.getElementById("checkOnlineWord2").innerHTML = " Online";
      document.getElementById("checkOnline").classList = "absolute w-3 h-3 bg-green-500 rounded-full border-2 border-white -top-1 right-0 animate-pulse";
    } else {
      document.getElementById("checkOnlineWord").innerHTML = "Offline";
       document.getElementById("checkOnlineWord2").innerHTML = "Offline";
       document.getElementById("checkOnline").classList = "absolute w-3 h-3 bg-red-500 rounded-full border-2 border-white -top-1 right-0 animate-pulse";
    }
setInterval(function(){ 
  var ifConnected = window.navigator.onLine;
    if (ifConnected) {
      document.getElementById("checkOnlineWord").innerHTML = " Online";
      document.getElementById("checkOnlineWord2").innerHTML = " Online";
      document.getElementById("checkOnline").classList = "absolute w-3 h-3 bg-green-500 rounded-full border-2 border-white -top-1 right-0 animate-pulse";
    } else {
      document.getElementById("checkOnlineWord").innerHTML = " Offline";
       document.getElementById("checkOnlineWord2").innerHTML = " Offline";
       document.getElementById("checkOnline").classList = "absolute w-3 h-3 bg-red-500 rounded-full border-2 border-white -top-1 right-0 animate-pulse";
    }
 }, 1000);
</script>