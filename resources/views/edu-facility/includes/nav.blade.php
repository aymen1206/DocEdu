 <div class="flex  h-screen ">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-blue-800 text-white">
                <div class="flex items-center justify-center h-16 px-4 bg-blue-900">
                    <span class="text-xl font-semibold whitespace-nowrap overflow-hidden">
                        {{auth()->guard('edu_facility')->user()->name}}
                    </span>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <nav class="flex-1 space-y-2">
                    <!-- ACTIVE Example -->
                    
                    @if(Request::getHost() == config('services.Central_HOST'))
                        <a href="{{url('edu-facility/users')}}"
                            class="flex items-center w-full px-4 py-2 text-sm font-medium rounded-md hover:bg-blue-700 text-white">
                            <i class="fa-solid fa-pen-to-square mx-3"></i>
                                        {{__('lang.tenants')}}
                        </a>                        
                    @else
                        <a href="{{url('edu-facility/ParentCallNotice')}}"
                        class="flex items-center w-full px-4 py-2 text-sm font-medium rounded-md
                        hover:bg-blue-700 text-white">
                        <i class="fa-solid fa-pen-to-square mx-3"></i>
                            {{__('lang.callgradiant')}}
                        </a>
        
                        <!-- Contacts -->
                        <a href="{{url('edu-facility/AbsenceNotification')}}"
                        class="flex items-center w-full px-4 py-2 text-sm font-medium rounded-md hover:bg-blue-700 text-white">
                            <i class="fa-solid fa-pen-to-square mx-3"></i>
                            {{__('lang.atencncNot')}}
                        </a>


                        <!-- APPRECIATION -->
                        <a href="{{url('edu-facility/APPRECIATION')}}"
                        class="flex items-center w-full px-4 py-2 text-sm font-medium rounded-md hover:bg-blue-700 text-white">
                            <i class="fa-solid fa-pen-to-square mx-3"></i>
                            {{__('lang.CertAPPRECIA')}}
                        </a>
                    @endif
                </nav>

                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
           <!-- Top Navigation -->
<header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 relative">
    <div class="flex items-center">
        <button class="md:hidden text-gray-500 focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
        
    </div>

    <h1>{{$schoolname}}</h1>

    <div class="flex items-center space-x-4 relative">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @if($localeCode != LaravelLocalization::getCurrentLocale())
                @php
                    $currentUrl = url()->current();
                    $localizedUrl = LaravelLocalization::getLocalizedURL($localeCode, $currentUrl, [], true);
                @endphp
                <a rel="alternate" hreflang="{{ $localeCode }}" class="text-gray-500 focus:outline-none"
                   href="{{ $localizedUrl }}">
                    <i class="fas fa-globe"></i>
                    {{ $properties['native'] ?? ($localeCode == 'en' ? 'EN' : 'AR') }}
                </a>
            @endif
        @endforeach

        <!-- Notifications -->
        <div class="">
            <button id="notifBtn" class="text-gray-500 focus:outline-none">
            </button>
            <div id="notifMenu" class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                <div class="p-4 text-sm text-gray-700">
                    
                </div>
            </div>
        </div>

        <!-- Profile -->
        <div class="">
            <button id="profileBtn" class="flex items-center focus:outline-none">
                <img class="w-8 h-8 rounded-full border" src="{{ asset(auth()->guard('edu_facility')->user()->logo)}}" alt="User">
            </button>
            <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                <a href="{{url('edu-facility/profile/show')}}" class=" block w-full text-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                    @lang('lang.Account_details')
                </a>
                <form method="get" action="{{ route('edu-facility.logout') }}">
                    @csrf
                    <button type="submit" class="w-full   px-4 py-2 text-gray-700 hover:bg-gray-100">
                        @lang('lang.logout')
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const notifBtn = document.getElementById("notifBtn");
    const notifMenu = document.getElementById("notifMenu");
    const profileBtn = document.getElementById("profileBtn");
    const profileMenu = document.getElementById("profileMenu");

    function closeAll() {
        notifMenu.classList.add("hidden");
        profileMenu.classList.add("hidden");
    }

    notifBtn.addEventListener("click", function(e) {
        e.stopPropagation();
        notifMenu.classList.toggle("hidden");
        profileMenu.classList.add("hidden");
    });

    profileBtn.addEventListener("click", function(e) {
        e.stopPropagation();
        profileMenu.classList.toggle("hidden");
        notifMenu.classList.add("hidden");
    });

    document.addEventListener("click", closeAll);
});
</script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


