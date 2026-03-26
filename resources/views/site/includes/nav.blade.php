<!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> -->


<header class="sticky top-0 z-50 relative bg-white/95 dark:bg-gray-900/95 backdrop-blur-md border-b border-[#E5E7EB] dark:border-gray-700 shadow-sm">
 
  <nav aria-label="Global" class="relative mx-auto flex max-w-7xl items-center justify-between py-2 px-4 lg:px-1">
    <!-- Logo - Right Side (RTL) -->
    <div class="flex-shrink-0">
      <a href="/" class="group -m-1.5 p-1.5 transition-transform duration-300 hover:scale-105">
        <span class="sr-only">DocEdu</span>
        <div class="flex items-center space-x-3 rtl:space-x-reverse">
          <!-- Logo for Light Mode -->
          <img src="{{asset('assets/images/logo.png')}}" alt="DocEdu Logo" class="h-10 w-auto block dark:hidden" />
          <!-- Logo for Dark Mode -->
          <img src="{{asset('assets/images/logo.png')}}" alt="DocEdu Logo" class="h-10 w-auto hidden dark:block" />
        </div>
      </a>
    </div>
    
    <!-- Navigation Links - Center -->
    <el-popover-group class="hidden lg:flex lg:flex-1 lg:justify-center lg:gap-x-6 rtl:gap-x-reverse">
     <a href="{{ url('/') }}" class="text-sm font-semibold text-[#1C1C1C] dark:text-gray-200 px-3 py-2 rounded-lg transition-all duration-300 hover:text-[#7D3CFF] dark:hover:text-[#7D3CFF] hover:bg-[#F5F6FA] dark:hover:bg-gray-800">
       {{__('lang.home')}}
     </a>
      <a href="#features" class="text-sm font-semibold text-[#1C1C1C] dark:text-gray-200 px-3 py-2 rounded-lg transition-all duration-300 hover:text-[#7D3CFF] dark:hover:text-[#7D3CFF] hover:bg-[#F5F6FA] dark:hover:bg-gray-800">
       {{__('lang.features')}}
      </a>
      <a href="#Contact" class="text-sm font-semibold text-[#1C1C1C] dark:text-gray-200 px-3 py-2 rounded-lg transition-all duration-300 hover:text-[#7D3CFF] dark:hover:text-[#7D3CFF] hover:bg-[#F5F6FA] dark:hover:bg-gray-800">
       {{__('lang.contact_us')}}
      </a> 
    </el-popover-group>
    
    <!-- Mobile Menu Button - Left Side -->
    <div class="flex lg:hidden">
      <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-lg p-2.5 text-[#1C1C1C] dark:text-gray-200 hover:bg-[#F5F6FA] dark:hover:bg-gray-800 transition-all duration-200">
        <span class="sr-only">Open main menu</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" data-slot="icon" aria-hidden="true" class="size-6">
          <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </div>
    
    <!-- Actions - Right Side (Language, Dark Mode, Create Account, Login, Search) -->
    <div class="hidden lg:flex lg:flex-shrink-0 items-center gap-3 rtl:gap-x-reverse">
       <!-- Language Selector -->
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
      @if($localeCode != LaravelLocalization::getCurrentLocale())
        @php
          // Get current URL and convert it to the new locale
          $currentUrl = url()->current();
          $localizedUrl = LaravelLocalization::getLocalizedURL($localeCode, $currentUrl, [], true);
        @endphp
        <a rel="alternate" hreflang="{{ $localeCode }}" 
           class="flex items-center gap-2 text-[#6B7280] dark:text-gray-400 font-medium text-base hover:text-[#1C1C1C] dark:hover:text-gray-200 transition-colors duration-300"
           href="{{ $localizedUrl }}">
          <span>{{ $properties['native'] ?? ($localeCode == 'en' ? 'English' : 'العربية') }}</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
          </svg>
        </a>
      @endif
    @endforeach
    
    <!-- Vertical Separator -->
    <div class="h-6 w-px bg-[#E5E7EB] dark:bg-gray-700"></div>
    
    <!-- Dark Mode Toggle -->
    <button id="theme-toggle" class="flex items-center justify-center p-2 rounded-lg text-[#6B7280] dark:text-gray-400 hover:text-[#1C1C1C] dark:hover:text-gray-200 hover:bg-[#F5F6FA] dark:hover:bg-gray-800 transition-all duration-300">
      <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m8.66-8.66l-.707.707M4.05 4.05l-.707.707M21 12h-1M4 12H3m16.66 4.66l-.707-.707M4.05 19.95l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
      </svg>
      <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
      </svg>
    </button> 
  
    
    
    <!-- Vertical Separator -->
    <div class="h-6 w-px bg-[#E5E7EB] dark:bg-gray-700"></div>
    
    @if(Request::getHost() == config('services.Central_HOST'))
      <!-- Create Account Button -->
      <a href="{{ route('rigisterStudent') }}" class="px-4 py-2 rounded-lg bg-[#1C1C1C] dark:bg-gray-800 dark:hover:bg-gray-700 text-white font-semibold text-sm hover:bg-[#2D2D2D] transition-all duration-300">
        {{__('lang.signup')}}
      </a>
    @endif
     <!-- Login Button -->
    <!-- Login Button -->
    <a href="{{ url('/LoginStudent') }}" class="px-4 py-2 rounded-lg bg-white dark:bg-gray-800 border border-[#6B7280] dark:border-gray-700 text-[#6B7280] dark:text-gray-300 font-semibold text-sm hover:bg-[#F5F6FA] dark:hover:bg-gray-700 transition-all duration-300">
      {{__('lang.login')}}
    </a>              
   
   </div>
  </nav>
  <el-dialog>
    <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
      <div tabindex="0" class="fixed inset-0 focus:outline-none">
        <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white dark:bg-gray-900 border-l border-[#E5E7EB] dark:border-gray-700 p-6 sm:max-w-sm">
          <div class="flex items-center justify-between">
            <a href="#" class="-m-1.5 p-1.5">
              <span class="sr-only">Reporta App</span>
              <!-- Logo for Light Mode -->
              <img src="{{asset('assets/images/schoollogo.png')}}?color=indigo&shade=600" alt="" class="h-8 w-auto drop-shadow-lg block dark:hidden" />
              <!-- Logo for Dark Mode -->
              <img src="{{asset('assets/images/schoollogo.png')}}" alt="" class="h-8 w-auto drop-shadow-lg hidden dark:block" />
            </a>
            <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-lg p-2.5 text-[#1C1C1C] dark:text-gray-200 hover:bg-[#F5F6FA] dark:hover:bg-gray-800 transition-all duration-200">
              <span class="sr-only">Close menu</span>
              <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" data-slot="icon" aria-hidden="true" class="size-6">
                <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>
          </div>
          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-[#E5E7EB] dark:divide-gray-700">
              <div class="space-y-2 py-6">                
                <a href="{{ url('/') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-[#1C1C1C] dark:text-gray-200 hover:bg-[#F5F6FA] dark:hover:bg-gray-800 hover:text-[#7D3CFF] transition-all duration-200">{{__('lang.home')}}</a>
                <a href="#features" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-[#1C1C1C] dark:text-gray-200 hover:bg-[#F5F6FA] dark:hover:bg-gray-800 hover:text-[#7D3CFF] transition-all duration-200">{{__('lang.features')}}</a>                   
                <a href="#Contact" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-[#1C1C1C] dark:text-gray-200 hover:bg-[#F5F6FA] dark:hover:bg-gray-800 hover:text-[#7D3CFF] transition-all duration-200">{{__('lang.Contact')}}</a>                   
               
              </div><div class="py-6">                                 
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                          @if($localeCode != LaravelLocalization::getCurrentLocale())
                              @php
                                // Get current URL and convert it to the new locale
                                $currentUrl = url()->current();
                                $localizedUrl = LaravelLocalization::getLocalizedURL($localeCode, $currentUrl, [], true);
                              @endphp
                              <a rel="alternate" hreflang="{{ $localeCode }}" class="flex items-center px-4 py-2 text-sm text-[#1C1C1C] dark:text-gray-200 hover:bg-[#F5F6FA] dark:hover:bg-gray-800 hover:rounded-lg transition-all duration-200"
                                href="{{ $localizedUrl }}">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 rtl:ml-0 rtl:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                                  </svg>
                                  {{ $properties['native'] ?? ($localeCode == 'en' ? 'English' : 'العربية') }}
                              </a>
                          @endif
                      @endforeach
                              <a href="{{ route('rigisterStudent') }}" class="block px-4 py-2 text-sm text-[#1C1C1C] dark:text-gray-200 hover:bg-[#F5F6FA] dark:hover:bg-gray-800 hover:rounded-lg transition-all duration-200">{{__('lang.signup')}}</a>
                              <a href="{{ url('/LoginStudent') }}" class="block px-4 py-2 text-sm text-[#1C1C1C] dark:text-gray-200 hover:bg-[#F5F6FA] dark:hover:bg-gray-800 hover:rounded-lg transition-all duration-200">{{__('lang.login')}}</a>      
                           
                              <a href="{{ url('student/profile') }}" class="block px-4 py-2 text-sm text-[#1C1C1C] dark:text-gray-200 hover:bg-[#F5F6FA] dark:hover:bg-gray-800 hover:rounded-lg transition-all duration-200">{{__('lang.profile')}}</a>
                              <a href="{{url('student/logout')}}" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:rounded-lg transition-all duration-200">{{__('lang.logout')}}</a>                                    
                             
              </div>
            </div>
          </div>
        </el-dialog-panel>
      </div>
    </dialog>
  </el-dialog>
</header>
 