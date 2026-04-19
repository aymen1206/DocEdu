@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
 <div class="mb-6 mt-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <h4 class="text-2xl font-semibold text-gray-800">
            @lang('lang.Subscription_prices')
        </h4>

        <a href="{{url('edu-facility/prices/create')}}"
           class="mt-3 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
            <span class="fa fa-plus-square mr-2"></span> @lang('lang.add_new')
        </a>
    </div>

    <nav class="mt-3">
        <ol class="flex items-center space-x-2 text-gray-600">
            <li>
                <a href="{{url('/edu-facility')}}" class="hover:text-blue-600">
                    @lang('lang.home')
                </a>
            </li>
            <li class="text-gray-500"> / </li>
            <li class="text-blue-600">
                @lang('lang.Subscription_prices')
            </li>
        </ol>
    </nav>
</div>

<div class="w-full">
    <div class="bg-white shadow rounded-xl p-6">
        <h4 class="text-xl mb-4 font-semibold">
            @lang('lang.Subscription_prices')
        </h4>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 divide-y divide-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">@lang('lang.title')</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">@lang('lang.stage')</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">@lang('lang.class')</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">@lang('lang.payment_method')</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">@lang('lang.action')</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @foreach($data as $dt)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center">{{ $dt->name }}</td>
                        <td class="px-4 py-3 text-center">{{ $dt->_type->name }}</td>
                        <td class="px-4 py-3 text-center">{{ $dt->_stage->name }}</td>
                        <td class="px-4 py-3 text-center">{{ $dt->subscriptionperiod->name }}</td>

                        <td class="px-4 py-3 text-center space-x-1 rtl:space-x-reverse">
                            <a href="{{url('edu-facility/prices/'.$dt->id.'/show')}}"
                               class="inline-flex items-center px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded">
                               <i class="fa fa-eye mr-1"></i> @lang('lang.view')
                            </a>

                            <a href="{{url('edu-facility/prices/'.$dt->id.'/edit')}}"
                               class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded">
                               <i class="fa fa-edit mr-1"></i> @lang('lang.edit')
                            </a>

                            <a href="{{url('edu-facility/prices/'.$dt->id.'/delete')}}"
                               class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm rounded delete-confirm">
                               <i class="fa fa-trash mr-1"></i> @lang('lang.delete')
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>                    
            <div class="flex justify-center mt-6">
            {{ $data->links('pagination::tailwind') }}
        </div>
        </div>
    </div>
</div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection

