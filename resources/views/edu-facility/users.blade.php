@extends('edu-facility.includes.master')    
@section('content')
<div class="welcome-message" style="text-align:center; margin-top:30px;">
    <h1 style="font-size:2rem; color:#2c3e50;">{{ $schoolname ?? 'مدرستنا' }}</h1>
   </div>
    
<div class=" w-full-screen  "> 
            <table class="min-w-full border border-gray-300 divide-y divide-gray-300">
                <thead class="bg-gray-100">
            <tr>
                <th
                    class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap">
                  الاسم</th>
                <th
                    class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap">
                   المنشأة</th>
                <th
                    class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap">
                  رابط التشغيل </th>
              
            </tr>
        </thead>
        
@foreach ($users as $user)
        <tbody class="min-w-full border border-gray-300 divide-y divide-gray-200">
            <tr>
                <th class="px-4 py-3 whitespace-nowrap align-middle text-sm font-medium text-gray-900">
                    {{ $user->name }}
                </th>
                <th class="px-4 py-3 whitespace-nowrap align-middle text-sm text-gray-500">
                    {{ $user->tenant_id ?? 'غير معروف' }}
                </th>
                <th class="px-4 py-3 whitespace-nowrap align-middle text-sm text-gray-500">
                    {{ $user->tenant_id.'.'.config('services.Central_HOST') ?? 'لا توجد تفاصيل' }}
                </th>
            </tr>
        </tbody>
    @endforeach
    </table>
</div>
@endsection
