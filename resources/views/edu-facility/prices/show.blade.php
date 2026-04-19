@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<div class="mb-6 mt-6 ">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h4 class="text-xl font-semibold">@lang('lang.Subscription_prices')</h4>
        <nav class="flex items-center space-x-2 mt-2 sm:mt-0" aria-label="breadcrumb">
            <ol class="flex space-x-2 text-gray-500 text-sm">
                <li><a href="{{ url('/edu-facility') }}" class="hover:text-gray-700">@lang('lang.home')</a></li>
                <li>/</li>
                <li><a href="{{ url('/edu-facility/prices') }}" class="hover:text-gray-700">@lang('lang.Subscription_prices')</a></li>
            </ol>
        </nav>
    </div>
</div>
<div class="max-w-7xl mx-auto mb-6">
    <div class="bg-white shadow rounded-lg">
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.username_ar')</td>
                        <td class="px-4 py-2">{{ $data->name }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.english_name')</td>
                        <td class="px-4 py-2">{{ $data->name_en }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.stage')</td>
                        <td class="px-4 py-2">{{ $data->_type->name }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.class')</td>
                        <td class="px-4 py-2">{{ $data->_stage->name }}</td>
                    </tr>
                    @if($data->subject != null)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.subject')</td>
                        <td class="px-4 py-2">{{ DB::table('subjects')->where('id',$data->subject)->first()->name }}</td>
                    </tr>
                    @endif
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.payment_method')</td>
                        <td class="px-4 py-2">{{ $data->subscriptionperiod->name }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.before_discount')</td>
                        <td class="px-4 py-2">{{ $data->price_discount }} @lang('lang.sar')</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.saving')</td>
                        <td class="px-4 py-2">
                            @if(isset($data->price_discount) && $data->price_discount > $data->price)
                                {{ $data->price_discount - $data->price }} @lang('lang.sar')<br>
                                ({{ floor((($data->price_discount - $data->price) / $data->price_discount) * 100) }}%)
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.after_discount')</td>
                        <td class="px-4 py-2">{{ $data->price }} @lang('lang.sar')</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.The_total_number_of_students')</td>
                        <td class="px-4 py-2">{{ $data->allowed_number }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.note')</td>
                        <td class="px-4 py-2">{!! nl2br($data->note) !!}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-700">@lang('lang.note_en')</td>
                        <td class="px-4 py-2">{!! nl2br($data->note_en) !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>
@endsection

