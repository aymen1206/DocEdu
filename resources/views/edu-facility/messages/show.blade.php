@extends('edu-facility.includes.master')    
@section('content')

<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<div class="mb-6">
    <div class="flex flex-col">
        <h4 class="text-2xl font-semibold">@lang('lang.Support_Center')</h4>

        <nav class="mt-2 text-sm text-gray-500">
            <ol class="flex gap-2">
                <li>
                    <a href="{{url('/edu-facility')}}" class="text-blue-600 hover:underline">
                        @lang('lang.home')
                    </a>
                </li>
                <li>/</li>
                <li>
                    <a href="{{url('/edu-facility/messages')}}" class="text-blue-600 hover:underline">
                        @lang('lang.Support_Center')
                    </a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="w-full">
    <div class="bg-white shadow rounded-xl p-6">

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <tbody class="divide-y divide-gray-200">

                    <tr>
                        <td class="p-3 font-medium bg-gray-50 w-1/3">@lang('lang.reference_number')</td>
                        <td class="p-3">{{ $data->id }}</td>
                    </tr>

                    <tr>
                        <td class="p-3 font-medium bg-gray-50">@lang('lang.name')</td>
                        <td class="p-3">{{ $data->name }}</td>
                    </tr>

                    <tr>
                        <td class="p-3 font-medium bg-gray-50">@lang('lang.phone')</td>
                        <td class="p-3">{{ $data->phone }}</td>
                    </tr>

                    <tr>
                        <td class="p-3 font-medium bg-gray-50">@lang('lang.email')</td>
                        <td class="p-3">{{ $data->email }}</td>
                    </tr>

                    <tr>
                        <td class="p-3 font-medium bg-gray-50">@lang('lang.subject')</td>
                        <td class="p-3">{{ $data->subject }}</td>
                    </tr>

                    <tr>
                        <td class="p-3 font-medium bg-gray-50">@lang('lang.message')</td>
                        <td class="p-3">{!! nl2br($data->text) !!}</td>
                    </tr>

                    <tr>
                        <td colspan="2" class="p-4 text-center">
                            <a href="mailto:{{ $data->email }}"
                               class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                                <i class="fa fa-envelope"></i>
                                @lang('lang.reply')
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</div>

</main>

@endsection
