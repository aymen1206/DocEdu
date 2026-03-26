@extends('site.master.master')

@section('content')

<!-- Login Page -->
<div class="min-h-screen bg-gradient-to-br from-[#F5F6FA] via-white to-[#F5F6FA] dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-20 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md mx-auto">
    <!-- Header -->
    <div class="text-center mb-8">
      <h1 class="text-4xl md:text-5xl font-bold text-[#1C1C1C] dark:text-white mb-4 tracking-tight transition-colors duration-300">
        {{__('lang.login')}}
      </h1>
      <div class="flex items-center justify-center mt-4 mb-6">
        <div class="h-px w-16 bg-gradient-to-r from-transparent to-[#7D3CFF] dark:to-purple-400"></div>
        <div class="h-0.5 w-24 bg-[#7D3CFF] dark:bg-purple-400"></div>
        <div class="h-px w-16 bg-gradient-to-l from-transparent to-[#7D3CFF] dark:to-purple-400"></div>
      </div>
      <p class="text-[#6B7280] dark:text-gray-300 text-base">
        {{__('lang.enter_phone_to_login')}}
      </p>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 border border-[#E5E7EB] dark:border-gray-700">
      <form method="post" action="{{url('loginVerifiey')}}">
        @csrf
        
        <!-- School Number -->
        <div class="mb-6">
          <label for="phone-input" class="block text-sm font-semibold text-[#1C1C1C] dark:text-white mb-2">
            {{__('lang.School_ID')}}
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
              <svg class="w-5 h-5 text-[#6B7280] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
              </svg>
            </div>
            <input type="text"
                   name="tenant_id" 
                   class="block w-full px-4 py-3 pr-12 rounded-xl border-2 border-[#E5E7EB] dark:border-gray-600 bg-white dark:bg-gray-700 text-[#1C1C1C] dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#7D3CFF] dark:focus:ring-purple-400 focus:border-[#7D3CFF] dark:focus:border-purple-400 transition-all duration-300"
                   placeholder="  {{__('lang.School_ID')}}"
                   required />
          </div> 
        </div>
        <!-- Password -->
        <div class="mb-6">
          <label for="phone-input" class="block text-sm font-semibold text-[#1C1C1C] dark:text-white mb-2">
            {{__('lang.password')}}
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
              <svg class="w-5 h-5 text-[#6B7280] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
              </svg>
            </div>
            <input type="password"
                   name="password" 
                   class="block w-full px-4 py-3 pr-12 rounded-xl border-2 border-[#E5E7EB] dark:border-gray-600 bg-white dark:bg-gray-700 text-[#1C1C1C] dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#7D3CFF] dark:focus:ring-purple-400 focus:border-[#7D3CFF] dark:focus:border-purple-400 transition-all duration-300"
                   placeholder="  {{__('lang.password')}}"
                   required />
          </div> 
        </div>

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

        <!-- Register Link -->
        <div class="mt-6 text-center">
          <p class="text-sm text-[#6B7280] dark:text-gray-300">
            {{__('lang.dont_have_account')}} 
            <a href="{{ url('/rigisterStudent') }}" class="font-semibold text-[#7D3CFF] dark:text-purple-400 hover:text-[#6B2FE8] dark:hover:text-purple-500 transition-colors duration-300">
              {{__('lang.create_new_account')}}
            </a>
          </p>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
