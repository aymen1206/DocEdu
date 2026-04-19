@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
    <div class="p-4">
    <!-- Breadcrumb -->
    <div class="mb-4">
        <h4 class="text-xl font-semibold">@lang('lang.balance_withdrawal_records')</h4>
        <nav class="text-sm text-gray-500 mt-1" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li>
                    <a href="{{ url('/edu-facility') }}" class="text-blue-600 hover:underline">@lang('lang.home')</a>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">@lang('lang.balance_withdrawal_records')</li>
            </ol>
        </nav>
    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded p-6">
        <h4 class="text-lg font-semibold mb-2">@lang('lang.balance_withdrawal_records')</h4>
        <hr class="my-2 border-gray-300">

        <div class="overflow-x-auto mt-4">
            <h6 class="mb-2 font-medium">@lang('lang.export_results')</h6>
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">#</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">رقم الفاتورة</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">مبلغ الفاتورة</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">تاريخ الفاتورة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($data as $key => $invoice)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2  text-sm font-medium text-gray-700">{{ $key + 1 }}</td>
                        <td class="px-3 py-2  text-sm font-medium text-blue-600 hover:underline">
                            <a href="{{ url('edu-facility/invoice/details/'.$invoice->id) }}">
                                INV_EDK-{{ $invoice->id }}
                            </a>
                        </td>
                        <td class="px-3 py-2  text-sm font-medium text-gray-700">{{ $invoice->amount }}</td>
                        <td class="px-3 py-2  text-sm font-medium text-gray-700">{{ $invoice->created_at }}</td>
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
@endsection

