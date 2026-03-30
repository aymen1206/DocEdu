@extends('edu-facility.includes.master')    
@section('content') 
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
    <div class="bg-gray-100 border-b">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center py-4">
            
            <!-- العنوان -->
            <div class="md:w-5/12">
                <h4 class="text-2xl font-semibold text-gray-800">
                    @lang('lang.Profile_settings')
                </h4>

                <!-- Breadcrumb -->
                <div class="flex items-center mt-2">
                    <nav aria-label="breadcrumb">
                        <ol class="flex gap-2 text-sm text-gray-600">
                            <li>
                                <a href="{{url('/edu-facility')}}" class="hover:text-blue-600">
                                    @lang('lang.home')
                                </a>
                            </li>

                            <li>/</li>

                            <li class="text-blue-600 font-medium">
                                <a href="{{url('/edu-facility/profile')}}" class="hover:text-blue-700">
                                    @lang('lang.Profile_settings')
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="p-6 max-w-3xl mx-auto"> 

    <form method="POST" action="{{ route('edu-facility.profile.update') }}"  enctype="multipart/form-data" >
        @csrf
                {{-- Name Group --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Arabic Name --}}
                    <div>
                        <label class="block font-medium mb-1">@lang('lang.username_ar') <span class="text-red-500 font-extrabold">*</span></label>
                        <input type="text" name="name"
                               class="w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                               value="{{ $data->tenant->name }}" required placeholder="@lang('lang.name')">
                        <span class="text-red-600 text-sm">{{ $errors->first('name') }}</span>
                    </div>

                    {{-- English Name --}}
                    <div>
                        <label class="block font-medium mb-1">@lang('lang.english_name') <span class="text-red-500 font-extrabold">*</span></label>
                        <input type="text" name="name_en"
                               class="w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                               value="{{ $data->name_en }}" required placeholder="@lang('lang.english_name')">
                        <span class="text-red-600 text-sm">{{ $errors->first('name_en') }}</span>
                    </div>
                </div>

                {{-- About Group --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    {{-- Arabic About --}}
                    <div>
                        <label class="block font-medium mb-1">@lang('lang.about') <span class="text-red-500 font-extrabold">*</span></label>
                        <textarea name="about" rows="4"
                                  class="w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                  required>{{ $data->about }}</textarea>
                        <span class="text-red-600 text-sm">{{ $errors->first('about') }}</span>
                    </div>
                    
                    {{-- English About --}}
                    <div>
                        <label class="block font-medium mb-1">@lang('lang.text_en') <span class="text-red-500 font-extrabold">*</span></label>
                        <textarea name="about_en" rows="4"
                                  class="w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                  required>{{ $data->about_en }}</textarea>
                        <span class="text-red-600 text-sm">{{ $errors->first('about_en') }}</span>
                    </div>
                </div>

                {{-- Manager Name --}}
                <div class="mt-6">
                    <label class="block font-medium mb-1">@lang('lang.Manger_Name') <span class="text-red-500 font-extrabold">*</span></label>
                    <textarea name="Manger_Name" rows="4"
                              class="w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                              required>{{ $data->Manger_Name }}</textarea>
                    <span class="text-red-600 text-sm">{{ $errors->first('Manger_Name') }}</span>
                </div>
                {{-- Facility Attachments (commercial, owner_id, logo) --}}
                <div class="space-y-6 is_facility_1_3_5">

                    <div>
                        <label class="block font-medium mb-1">@lang('lang.logo_attach') <span class="text-red-500 font-extrabold">*</span></label>
                        <img src="{{ asset($data->logo) }}" class="w-64 rounded-lg mb-3">
                        <input type="file" name="logo"
                               class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                               >
                        <span class="text-red-600 text-sm">{{ $errors->first('logo') }}</span>
                    </div>
                </div>

                {{-- Submit --}}
                <div>
                    <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        @lang('lang.update')
                    </button>
                </div>

            </form>
</div>

</main>
  
@endsection
 