@extends('edu-facility.includes.master')    
@section('content') 
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
@php
    $dt = json_decode($data->json , true);
@endphp

<div class="p-4">
    <div class="mb-4">
        <h4 class="text-xl font-semibold">@lang('lang.Profile_finance_settings')</h4>
        <nav class="text-sm text-gray-500 mt-1" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li>
                    <a href="{{ url('/edu-facility') }}" class="text-blue-600 hover:underline">@lang('lang.home')</a>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">
                    <a href="{{ url('/edu-facility/finance') }}" class="hover:underline">@lang('lang.Profile_finance_settings')</a>
                </li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow rounded p-6">
        <form method="post" action="{{ route('edu-facility.finance.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">@lang('lang.iban')</label>
                <input type="text" name="iban" placeholder="@lang('lang.iban')" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                       value="{{ $data->iban }}">
                <span class="text-red-600 text-sm">{{ $errors->first('iban') }}</span>
            </div>

            <h6 class="font-semibold mt-4 mb-2">@lang('lang.contact_info')</h6>

            <div>
                <label class="block mb-1 font-medium">@lang('lang.first_name')</label>
                <input type="text" name="first" placeholder="@lang('lang.first_name')" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                       value="{{ $data->first }}">
                <span class="text-red-600 text-sm">{{ $errors->first('first') }}</span>
            </div>

            <div>
                <label class="block mb-1 font-medium">@lang('lang.middle_name')</label>
                <input type="text" name="middle" placeholder="@lang('lang.middle_name')" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                       value="{{ $data->middle }}">
                <span class="text-red-600 text-sm">{{ $errors->first('middle') }}</span>
            </div>

            <div>
                <label class="block mb-1 font-medium">@lang('lang.last_name')</label>
                <input type="text" name="last" placeholder="@lang('lang.last_name')" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                       value="{{ $data->last }}">
                <span class="text-red-600 text-sm">{{ $errors->first('last') }}</span>
            </div>

            <div>
                <label class="block mb-1 font-medium">@lang('lang.email')</label>
                <input type="email" name="email" placeholder="@lang('lang.email')" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                       value="{{ $data->email }}">
                <span class="text-red-600 text-sm">{{ $errors->first('email') }}</span>
            </div>

            <div>
                <label class="block mb-1 font-medium">@lang('lang.phone')</label>
                <input type="text" name="phone" placeholder="@lang('lang.phone')" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                       value="{{ $data->phone }}">
                <span class="text-red-600 text-sm">{{ $errors->first('phone') }}</span>
            </div>

            @if($dt == null)
            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    @lang('lang.update')
                </button>
            </div>
            @endif
        </form>
    </div>

    @if($dt != null)
    <div class="bg-white shadow rounded p-6 mt-4">
        <h6 class="font-semibold mb-2">@lang('lang.status')</h6>

        @if(isset($dt['id']))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
            <ul class="list-disc pl-5">
                <li>معرف المدرسة: {{ $dt['id'] }}</li>
                <li>@lang('lang.status'): {{ $dt['status'] }}</li>
                <li>معرف عملية الدفع: {{ $dt['destination_id'] }}</li>
            </ul>
        </div>
        @else
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
            <h6>حدث خطأ اثناء انشاء بيانات الدفع والتحويل من فضلك تأكد من البيانات الاتية:</h6>
            <ul class="list-disc pl-5">
                <li>يجب التأكد من ان كل الحقول في صفحة البروفايل تم ادخالها بشكل صحيح
                    <a target="_blank" href="{{ url('edu-facility/profile') }}" class="text-blue-600 hover:underline">اضغط هنا</a>
                </li>
            </ul>
        </div>
        @endif
    </div>
    @endif
</div>

</main>
@endsection