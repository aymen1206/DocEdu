@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<div class="p-4">
    <!-- Breadcrumb -->
    <div class="mb-4">
        <h4 class="text-xl font-semibold">INV_EDK-{{$invoice_id}}</h4>
        <nav class="text-sm text-gray-500 mt-1" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li>
                    <a href="{{ url('/edu-facility') }}" class="text-blue-600 hover:underline">@lang('lang.home')</a>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">فاتورة رقم INV_EDK-{{$invoice_id}}</li>
            </ol>
        </nav>
    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded p-6">
        <h4 class="text-lg font-semibold mb-4">الفواتير</h4>

        <div class="overflow-x-auto mb-4">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-red-100">
                    <tr>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">رقم الاشتراك</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">ولي الامر</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">الطالب</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">الاشتراك</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">بواسطة</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">اجمالي العملية</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">العمولة</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">العملية</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">قيمة العملية بعد الخصم</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">قيمة عمولة التسويق</th>
                        <th class="px-3 py-2  text-sm font-medium text-gray-700">إجمالي الفاتورة بعد خصم عمولة التسويق</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $total = 0;
                        $comsTotal = 0;
                    @endphp

                    @foreach($data as $order)
                        @php
                            $financialLog = \App\Models\Financiallog::where('InvoiceId',$order->id)->first();
                            $total += $financialLog->addition ?? 0;

                            $gname = DB::table('students')->where('id',$order->student)->value('name');
                            $childName = '';
                            if($order->children != null && $order->children != 0){
                                $child = DB::table('childrens')->where('id',$order->children)->first();
                                $childName = $child ? $child->name : '';
                            }

                            $paymentType = '';
                            if($order->payment_type){
                                switch($order->payment_type){
                                    case 'pg': $paymentType = 'الدفع الالكتروني'; break;
                                    case 'tamara': $paymentType = 'تمارا'; break;
                                    case 'tabby': $paymentType = 'تابي'; break;
                                    case 'jeel': $paymentType = 'جيل'; break;
                                }
                            }

                            $coms = $order->facility?->theedukeycommssion ?? 0;
                            $comsTotal += $coms;
                            $afterCommission = ($financialLog->addition ?? 0) - $coms;
                        @endphp

                        <tr class="bg-red-100 hover:bg-red-200">
                            <td class="px-3 py-2 text-gray-700">{{ $order->id }}</td>
                            <td class="px-3 py-2 text-gray-700">{{ $gname }}</td>
                            <td class="px-3 py-2 text-gray-700">
                                @if($order->children == null || $order->children == 0)
                                    @lang('lang.main_account')
                                @else
                                    @lang('lang.children'): {{ $childName }}
                                @endif
                            </td>
                            <td class="px-3 py-2 text-gray-700">{{ $order->pricelist->name }}</td>
                            <td class="px-3 py-2 text-gray-700">{{ $paymentType }}</td>
                            <td class="px-3 py-2 text-gray-700">{{ $financialLog->Invoice_value ?? '-' }} ريال</td>
                            <td class="px-3 py-2 text-gray-700">{{ $financialLog->commission_rate ?? '-' }} %</td>
                            <td class="px-3 py-2 text-gray-700">{{ $financialLog->text ?? '-' }}</td>
                            <td class="px-3 py-2 text-gray-700">{{ $financialLog->addition ?? '-' }} ريال</td>
                            <td class="px-3 py-2 text-gray-700">{{ $coms }} ريال</td>
                            <td class="px-3 py-2 text-gray-700">{{ $afterCommission }} ريال</td>
                        </tr>
                    @endforeach

                    <!-- Total row -->
                    <tr class="bg-gray-100 font-semibold">
                        <td class="px-3 py-2">اجمالي الفاتورة</td>
                        <td class="px-3 py-2"></td>
                        <td class="px-3 py-2"></td>
                        <td class="px-3 py-2"></td>
                        <td class="px-3 py-2"></td>
                        <td class="px-3 py-2"></td>
                        <td class="px-3 py-2"></td>
                        <td class="px-3 py-2"></td>
                        <td class="px-3 py-2">{{ $total }} ريال</td>
                        <td class="px-3 py-2">{{ $comsTotal }} ريال</td>
                        <td class="px-3 py-2">{{ $total - $comsTotal }} ريال</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="bg-gray-100 p-4 rounded mt-4 text-gray-700">
            اجمالي مبلغ الفاتورة <strong>{{ $total }}</strong> تم خصم <strong>{{ $comsTotal }}</strong> كعمولة تسويق، اصبح المبلغ المستحق للمنشأة هو <strong>{{ $total - $comsTotal }}</strong>
        </div>
    </div>
</div>
</main>
@endsection

