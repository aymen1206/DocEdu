@extends('edu-facility.includes.master')    
@section('content')

<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<div class="mb-6">
    <div class="flex flex-col">
        <h4 class="text-2xl font-semibold">@lang('lang.callgradiant')</h4>

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
                        @lang('lang.callgradiant')
                    </a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-white shadow rounded-xl p-6">
    <h4 class="text-xl font-semibold mb-4">@lang('lang.callgradiant')</h4>

    <hr class="my-4">
 
    <!-- Table -->
    <div class="mt-8 overflow-x-auto">
        <table class="w-full border rounded-xl overflow-hidden text-center">
            <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2">@lang('lang.name')</th>
                <th class="px-4 py-2">@lang('lang.address')</th>
                <th class="px-4 py-2">@lang('lang.date')</th>
                <th class="px-4 py-2">@lang('lang.action')</th>
            </tr>
            </thead>

            <tbody>
                <tr class="border-b">
                    <td class="py-3"></td>
                    <td class="py-3"></td>
                    <td class="py-3"></td>
                    <td class="py-3"></td>

                </tr>
            </tbody>

        </table>
            <div class="flex justify-center mt-6">
    </div>
    </div>
</div>

</main>

@endsection
