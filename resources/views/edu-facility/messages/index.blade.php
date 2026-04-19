@extends('edu-facility.includes.master')    
@section('content')

<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<div class="mb-6">
    <h4 class="text-2xl font-semibold">@lang('lang.Support_Center')</h4>

    <nav class="mt-2 text-sm text-gray-500">
        <ol class="flex gap-2">
            <li>
                <a href="{{url('/edu-facility')}}" class="text-blue-600 hover:underline">
                    @lang('lang.home')
                </a>
            </li>
            <li>/</li>
            <li class="text-gray-700">@lang('lang.Support_Center')</li>
        </ol>
    </nav>
</div>

<div class="bg-white shadow rounded-xl p-6">
    <h4 class="text-xl font-semibold mb-4">@lang('lang.Support_Center')</h4>

    <hr class="my-4">

    <h6 class="text-lg font-medium mb-3">@lang('lang.filter_results')</h6>

    <form class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <!-- Status -->
        <div>
            <label class="block mb-1 font-medium">@lang('lang.status')</label>
            <select name="status"
                    class="w-full border rounded-lg px-3 py-2 text-gray-700">
                <option value="all">@lang('lang.all')</option>
                <option value="new" @if ($_status == "new") selected @endif>@lang('lang.new')</option>
                <option value="read" @if ($_status == "read") selected @endif>@lang('lang.seen')</option>
            </select>
        </div>

        <!-- From -->
        <div>
            <label class="block mb-1 font-medium">@lang('lang.Starting_from')</label>
            <input type="date" name="from" value="{{ $_from }}"
                   class="w-full border rounded-lg px-3 py-2 text-gray-700">
        </div>

        <!-- To -->
        <div>
            <label class="block mb-1 font-medium">@lang('lang.To')</label>
            <input type="date" name="to" value="{{ $_to }}"
                   class="w-full border rounded-lg px-3 py-2 text-gray-700">
        </div>

        <!-- Filter -->
        <div>
            <label class="block mb-1 font-medium">@lang('lang.filter_results')</label>
            <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg flex items-center justify-center gap-2">
                <i class="fa fa-filter"></i>
                @lang('lang.filter_results')
            </button>
        </div>
 
    </form>

    <!-- Table -->
    <div class="mt-8 overflow-x-auto">
        <table class="w-full border rounded-xl overflow-hidden text-center">
            <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2">@lang('lang.reference_number')</th>
                <th class="px-4 py-2">@lang('lang.status')</th>
                <th class="px-4 py-2">@lang('lang.name')</th>
                <th class="px-4 py-2">@lang('lang.email')</th>
                <th class="px-4 py-2">@lang('lang.time')</th>
                <th class="px-4 py-2">@lang('lang.action')</th>
            </tr>
            </thead>

            <tbody>
            @foreach($data as $dt)
                <tr class="border-b">
                    <td class="py-3">{{ $dt->id }}</td>

                    <td class="py-3">
                        @if ($dt->status == 'new')
                            <span class="px-3 py-1 rounded-full text-white bg-green-600 text-sm">
                                @lang('lang.new')
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-white bg-yellow-500 text-sm">
                                @lang('lang.seen')
                            </span>
                        @endif
                    </td>

                    <td class="py-3">{{ $dt->name }}</td>
                    <td class="py-3">{{ $dt->email }}</td>
                    <td class="py-3">{{ $dt->created_at }}</td>

                    <td class="py-3 flex flex-col items-center gap-2">

                        <a href="{{url('edu-facility/messages/'.$dt->id)}}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm flex items-center gap-2">
                            <i class="fa fa-eye"></i> @lang('lang.view')
                        </a>

                        <a href="mailto:{{ $dt->email }}"
                           class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm flex items-center gap-2">
                            <i class="fa fa-envelope"></i> @lang('lang.reply')
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
</main>
@endsection
