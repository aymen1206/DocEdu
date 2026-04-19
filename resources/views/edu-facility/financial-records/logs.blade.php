@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
    <div class="p-4">
    <!-- Breadcrumb -->
    <div class="mb-4">
        <h4 class="text-xl font-semibold">@lang('lang.financial_records')</h4>
        <nav class="text-sm text-gray-500 mt-1" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li>
                    <a href="{{ url('/edu-facility') }}" class="text-blue-600 hover:underline">@lang('lang.home')</a>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">@lang('lang.financial_records')</li>
            </ol>
        </nav>
    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded p-6">
        <h4 class="text-lg font-semibold mb-4">@lang('lang.financial_records')</h4>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">#</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">@lang('lang.invoice')</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">دفع بواسطة</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">@lang('lang.time')</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">@lang('lang.operation')</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">@lang('lang.total_bill')</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">@lang('lang.commission_rate')</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">@lang('lang.commission')</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">@lang('lang.subtraction')</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">@lang('lang.addition')</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">@lang('lang.Total')</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($data as $key => $log)
                    @if( $log->Invoice_value ==0)
                    <tr class="bg-red-500  ">
                    @else
                    <tr class="hover:bg-gray-50">
                    @endif
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $key + 1 }}</td>
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $log->InvoiceId }}</td>

                        @php
                            $myOrderId = $log->InvoiceId != 0 ? $log->InvoiceId : ($log->OrderId != 0 ? $log->OrderId : 0);
                            $myorder = \App\Models\Order::find($myOrderId);
                            $paymentType = '';
                            if($myorder){
                                switch($myorder->payment_type){
                                    case 'pg': $paymentType = 'الدفع الالكتروني'; break;
                                    case 'tamara': $paymentType = 'تمارا'; break;
                                    case 'tabby': $paymentType = 'تابي'; break;
                                    case 'jeel': $paymentType = 'جيل'; break;
                                }
                            }
                        @endphp
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $paymentType }}</td>

                        <td class="px-3 py-2 text-sm text-gray-700">{{ $log->created_at }}</td>
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $log->text }}</td>
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $log->Invoice_value }} @lang('lang.sar')</td>
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $log->commission_rate }}%</td>
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $log->commission }} @lang('lang.sar')</td>
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $log->withdraw }} @lang('lang.sar')</td>
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $log->addition }} @lang('lang.sar')</td>
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $log->total }} @lang('lang.sar')</td>
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