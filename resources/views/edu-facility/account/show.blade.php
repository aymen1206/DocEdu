@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
 <div class="mb-6">
    <div class="flex flex-col">
        <h4 class="text-2xl font-bold">{{ $data->name}}</h4>

        <nav class="mt-2 text-sm text-gray-600">
            <ol class="flex items-center gap-2">
                <li>
                    <a href="{{url('/edu-facility')}}" class="text-blue-600 hover:underline">
                        @lang('lang.home')
                    </a>
                </li>
                <li>/</li>
                <li class="text-gray-500">{{ $data->name }}</li>
            </ol>
        </nav>

        <a href="{{url('edu-facility/profile')}}"
           class="mt-3  inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm">
            <i class="fa fa-edit"></i> @lang('lang.edit')
        </a>
    </div>
</div>

<div class="w-full">
    <div class="bg-white shadow-md rounded-xl p-6">

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg">
                <tbody class="divide-y divide-gray-200">

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium w-1/3">@lang('lang.name')</td>
                        <td class="p-3">{{$data->name}}</td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.english_name')</td>
                        <td class="p-3">{{$data->name_en}}</td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.logo')</td>
                        <td class="p-3">
                            <img src="{{asset($data->logo)}}" class="w-14 h-14 object-contain"
                                 onerror="this.src='{{ asset('images/facility_default_logo.png') }}'">
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.type')</td>
                        <td class="p-3">{{ $data->type->name }}</td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.services')</td>
                        <td class="p-3">
                            @foreach($current_types as $ct)
                                <span class="px-2 py-1 bg-cyan-600 text-white rounded text-xs mr-1">
                                    {{ $ct->name }}
                                </span>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.status')</td>
                        <td class="p-3">
                            @if ($data->status == 1)
                                <a
                                   class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">
                                    @lang('lang.active')
                                </a>
                            @else
                                <a  
                                   class="px-2 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600">
                                    @lang('lang.inactive')
                                </a>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.Subscription_date')</td>
                        <td class="p-3">{{$data->created_at}}</td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.phone')</td>
                        <td class="p-3">{{$data->phone}}</td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.mobile')</td>
                        <td class="p-3">{{$data->mobile}}</td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.email')</td>
                        <td class="p-3">{{$data->email}}</td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.city')</td>
                        <td class="p-3">
                            @if(LaravelLocalization::getCurrentLocaleNative() == 'العربية')
                                {{DB::table('cities')->where('id',$data->city)->first()->nameAr}}
                            @else
                                {{DB::table('cities')->where('id',$data->city)->first()->nameEn}}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.address')</td>
                        <td class="p-3">{{$data->address}}</td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.address_en')</td>
                        <td class="p-3">{{$data->address_en}}</td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.map_location')</td>
                        <td class="p-3">
                            <script src="https://maps.google.com/maps/api/js?key=AIzaSyBYk-bPGA2YW221CLysrZW7_4od9x5G90Y"></script>
                            <div id="map" class="w-full h-52 rounded border"></div>
                        </td>
                    </tr>

                    {{-- Attachments --}}
                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.commercial_attach')</td>
                        <td class="p-3">
                            <img src="{{asset($data->commercial_record)}}" class="w-64 rounded border">
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.owner_id_attach')</td>
                        <td class="p-3">
                            <img src="{{asset($data->owner_id)}}" class="w-64 rounded border">
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.logo_attach')</td>
                        <td class="p-3">
                            <img src="{{asset($data->logo)}}" class="w-64 rounded border">
                        </td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.text')</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="p-3">{!! $data->about !!}</td>
                    </tr>

                    <tr>
                        <td class="p-3 bg-gray-50 font-medium">@lang('lang.text_en')</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="p-3">{!! $data->about_en !!}</td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</div>
</main>
@endsection