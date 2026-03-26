@extends('site.master.master')

@section('content') 
<!-- Register Page -->
<div class="min-h-screen bg-gradient-to-br from-[#F5F6FA] via-white to-[#F5F6FA] dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-20 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md mx-auto">
    <!-- Header -->
    <div class="text-center mb-8">
      <h1 class="text-4xl md:text-5xl font-bold text-[#1C1C1C] dark:text-white mb-4 tracking-tight transition-colors duration-300">
        {{__('lang.signup')}}
      </h1>
      <div class="flex items-center justify-center mt-4 mb-6">
        <div class="h-px w-16 bg-gradient-to-r from-transparent to-[#7D3CFF] dark:to-purple-400"></div>
        <div class="h-0.5 w-24 bg-[#7D3CFF] dark:bg-purple-400"></div>
        <div class="h-px w-16 bg-gradient-to-l from-transparent to-[#7D3CFF] dark:to-purple-400"></div>
      </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-[#E5E7EB] dark:border-gray-700 overflow-hidden">
      <!-- Tab Headers --> 
    

      <!-- Tab Content -->
      <div class="p-8">
        <!-- Interest Registration Form (Active) -->
        <div   class="tab-content">
        <form method="post" action="{{ route('registerTenant') }}" enctype="multipart/form-data">
        @csrf
     
      @if(Request::getHost() == config('services.Central_HOST') )   
        <!-- Phone Number -->
        <div class="mb-6">
          <label for="st_r_mobile" class="block text-sm font-semibold text-[#1C1C1C] dark:text-white mb-2">
            {{__('lang.schoolId')}}
          </label>
          <div class="relative">
            <input type="text"
                   name="tenant"
                   class="block w-full px-4 py-3 rounded-xl border-2 border-[#E5E7EB] dark:border-gray-600 bg-white dark:bg-gray-700 text-[#1C1C1C] dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#7D3CFF] dark:focus:ring-purple-400 focus:border-[#7D3CFF] dark:focus:border-purple-400 transition-all duration-300"
                   placeholder=" {{__('lang.schoolId')}}"
                   required />
          </div>
        </div>
@endif
        <!-- Name -->
        <div class="mb-6">
          <label for="st_r_name" class="block text-sm font-semibold text-[#1C1C1C] dark:text-white mb-2">
            {{__('lang.usname')}}
          </label>
          <div class="relative">
            <input type="text"
                   name="usname" 
                   class="block w-full px-4 py-3 rounded-xl border-2 border-[#E5E7EB] dark:border-gray-600 bg-white dark:bg-gray-700 text-[#1C1C1C] dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#7D3CFF] dark:focus:ring-purple-400 focus:border-[#7D3CFF] dark:focus:border-purple-400 transition-all duration-300"
                   placeholder="{{__('lang.usname')}}"
                   required />
          </div>
        </div>
@if(Request::getHost() == config('services.Central_HOST'))
        <!-- Name -->
        <div class="mb-6">
          <label for="st_r_name" class="block text-sm font-semibold text-[#1C1C1C] dark:text-white mb-2">
            {{__('lang.scname')}}
          </label>
          <div class="relative">
            <input type="text"
                   name="scname" 
                   class="block w-full px-4 py-3 rounded-xl border-2 border-[#E5E7EB] dark:border-gray-600 bg-white dark:bg-gray-700 text-[#1C1C1C] dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#7D3CFF] dark:focus:ring-purple-400 focus:border-[#7D3CFF] dark:focus:border-purple-400 transition-all duration-300"
                   placeholder="{{__('lang.name')}}"
                   required />
          </div>
        </div>
@endif
        <!-- Name -->
        <div class="mb-6">
          <label for="st_r_name" class="block text-sm font-semibold text-[#1C1C1C] dark:text-white mb-2">
            {{__('lang.password')}}
          </label>
          <div class="relative">
            <input type="password"
                   name="password" 
                   class="block w-full px-4 py-3 rounded-xl border-2 border-[#E5E7EB] dark:border-gray-600 bg-white dark:bg-gray-700 text-[#1C1C1C] dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#7D3CFF] dark:focus:ring-purple-400 focus:border-[#7D3CFF] dark:focus:border-purple-400 transition-all duration-300"
                   placeholder="{{__('lang.password')}}"
                   required />
          </div>
        </div>
        <!-- Legal Agreement -->
        <div class="mb-6">
          <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" 
                   name="legal_agreement" 
                   id="st_r_legal_agreement" 
                   checked
                   class="w-5 h-5 rounded border-2 border-[#E5E7EB] dark:border-gray-600 text-[#7D3CFF] dark:text-purple-400 focus:ring-2 focus:ring-[#7D3CFF] dark:focus:ring-purple-400 focus:ring-offset-0 transition-all duration-300">
            <span class="text-sm text-[#6B7280] dark:text-gray-300">
              {{__('lang.accept')}}  <a href="{{asset('assets/Terms_and_condition.pdf')}}" class="text-blue-500" download> {{__('lang.terms_conditions')}}</a>
            </span>
          </label>
        </div>

        <!-- Error Message -->
        @if(isset($resp) && $resp != 0)
          @if($resp[0]==='success')
            <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-2 border-green-200 dark:border-green-800">
              <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-semibold text-green-800 dark:text-green-300">{{__('lang.Interrested_add')}}</p>
              </div>
            </div>
            @else
            <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-2 border-red-200 dark:border-red-800">
              <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-semibold text-red-800 dark:text-red-300">{{ $resp[0] }}</p>
              </div>
            </div>
          @endif
        @endif

         <!-- Submit Button -->
            <button type="submit"
                    class="w-full flex items-center justify-center gap-3 px-6 py-4 rounded-xl bg-gradient-to-r from-[#7D3CFF] to-[#6B2FE8] dark:from-purple-600 dark:to-purple-700 text-white font-semibold text-base hover:from-[#6B2FE8] hover:to-[#5A27D4] dark:hover:from-purple-700 dark:hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-[#7D3CFF] dark:focus:ring-purple-400 focus:ring-offset-2 transition-all duration-300 shadow-lg hover:shadow-[#7D3CFF]/50 dark:hover:shadow-purple-400/50 hover:scale-105">
              <svg xmlns="http://www.w3.org/2000/svg"
                   class="w-5 h-5"
                   fill="none"
                   viewBox="0 0 24 24"
                   stroke="currentColor"
                   stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
              </svg>
              {{ __('lang.send') }}
            </button>
          </form>
      </div>
    </div>
 
  </div>
</div>
</div>

@endsection
