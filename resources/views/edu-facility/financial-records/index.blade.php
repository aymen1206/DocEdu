@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
    <div class="p-4">
    <!-- Breadcrumb -->
    <div class="mb-4">
        <h4 class="text-xl font-semibold">@lang('lang.Balance')</h4>
        <nav class="text-sm text-gray-500 mt-1" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li>
                    <a href="{{ url('/edu-facility') }}" class="text-blue-600 hover:underline">@lang('lang.home')</a>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">@lang('lang.Balance')</li>
            </ol>
        </nav>
    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded p-6">
        <h4 class="text-lg font-semibold mb-4">@lang('lang.Balance')</h4>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700">@lang('lang.number_of_subscribers')</td>
                        <td class="px-3 py-2 text-gray-700">{{ $total_sucscription }}</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700">@lang('lang.Balance_available_to_withdraw')</td>
                        <td class="px-3 py-2 text-gray-700">
                            @if ($financialLogs != null)
                                <a href="{{ url('edu-facility/financial-logs/orders/'.$financialLogs->facility_id) }}" class="text-blue-600 hover:underline">
                                    {{ $financialLogs->total }}
                                </a>
                            @endif
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-medium text-gray-700">@lang('lang.Previous_withdrawals')</td>
                        <td class="px-3 py-2 text-gray-700">{{ $withdrawas->count() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</main>
@endsection