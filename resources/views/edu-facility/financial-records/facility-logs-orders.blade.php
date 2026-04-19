@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
    <div class="p-4">
    <!-- Breadcrumb -->
    <div class="mb-4">
        <h4 class="text-xl font-semibold">السجلات المالية | {{ $facility->name }}</h4>
        <nav class="text-sm text-gray-500 mt-1" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li>
                    <a href="{{ url('/edu-facility') }}" class="text-blue-600 hover:underline">@lang('lang.home')</a>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">السجلات المالية | {{ $facility->name }}</li>
            </ol>
        </nav>
    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded p-6">
        <h4 class="text-lg font-semibold mb-4">الرصيد المتاح سحبه</h4>

        <input type="hidden" name="facility_id" value="{{ $financialLogs->facility_id }}">

        <div class="overflow-x-auto mb-4">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">رقم الفاتورة</th>
                        <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">تاريخ العملية</th>
                        <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">بواسطة</th>
                        <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">قيمة الفاتورة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($data as $log)
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
                    <tr class="bg-green-100 hover:bg-green-200">
                        <td class="px-3 py-2 text-gray-700">{{ $log->InvoiceId }}</td>
                        <td class="px-3 py-2 text-gray-700">{{ $log->created_at }}</td>
                        <td class="px-3 py-2 text-gray-700">{{ $paymentType }}</td>
                        <td class="px-3 py-2 text-gray-700">{{ $log->addition }} ريال</td>
                    </tr>
                    @endforeach

                    @foreach($notcollected as $order)
                    @php
                        $financialLog = \App\Models\Financiallog::where('InvoiceId', $order->id)->first();
                        $paymentType = '';
                        if($order->payment_type){
                            switch($order->payment_type){
                                case 'pg': $paymentType = 'الدفع الالكتروني'; break;
                                case 'tamara': $paymentType = 'تمارا'; break;
                                case 'tabby': $paymentType = 'تابي'; break;
                                case 'jeel': $paymentType = 'جيل'; break;
                            }
                        }
                    @endphp
                    <tr class="bg-green-100 hover:bg-green-200">
                        <td class="px-3 py-2 text-gray-700">{{ $order->id }}</td>
                        <td class="px-3 py-2 text-gray-700">{{ $order->created_at }}</td>
                        <td class="px-3 py-2 text-gray-700">{{ $paymentType }}</td>
                        <td class="px-3 py-2 text-gray-700">{{ $financialLog?->addition ?? '-' }} ريال</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Balance -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <tbody>
                    <tr class="bg-green-100">
                        <td class="px-3 py-2 font-medium text-gray-700">اجمالي الرصيد</td>
                        <td class="px-3 py-2 text-gray-700"></td>
                        <td class="px-3 py-2 text-gray-700"></td>
                        <td class="px-3 py-2 text-gray-700 font-semibold">{{ $financialLogs->total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</main>
@endsection