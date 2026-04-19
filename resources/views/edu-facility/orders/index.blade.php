@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<h2 class=" m-2">@lang('lang.orders')</h2>
<section class="bg-white mt-4 p-1 xs:p-8">
  <div class="   mx-auto border  border-[#4D7C0F] rounded-lg p-8">
    <h2 class="sm:text-xl text-[12px] font-bold mb-6">@lang('lang.filter')</h2>
    <form>
      <div class="space-y-6">
        <div class="grid sm:grid-cols-5 grid-cols-1 gap-6">
            
          <div>
            <label for="from" class="text-xs xs:text-sm font-medium text-gray-700 mb-1">@lang('lang.stage')</label>            
            <select name="type" id="type" class="h-[50px] rounded-[5px] text-xs xs:text-sm border border-[#D1D5DB] w-full px-2">
                    <option value=""> @lang('lang.all') </option>
                    @foreach ($facility['types'] as $type)
                        <option @if ($_type != null && $_type == $type->id ) selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach    
            </select>
          </div>
          <div>
            <label for="category" class="text-xs xs:text-sm font-medium text-gray-700 mb-1">@lang('lang.status')</label>
            <select name="status" id="status" class="h-[50px] rounded-[5px] text-xs xs:text-sm border border-[#D1D5DB] w-full px-2">
                    <option value=""> @lang('lang.all') </option>
                    <option @if ($_status != null && $_status == "new") selected @endif   value="new"> @lang('lang.new') </option>
                    <option @if ($_status != null && $_status == "accepted") selected @endif  value="accepted">@lang('lang.accepted')</option>
                    <option @if ($_status != null && $_status == "under_revision" ) selected @endif  value="under_revision">@lang('lang.processing')</option>
                    <option @if ($_status != null && $_status == "rejected") selected @endif  value="rejected">@lang('lang.rejected')</option>
                    <option @if ($_status != null && $_status == "is_paid") selected @endif  value="is_paid">@lang('lang.complete')</option>
            </select>
          </div>
          
          <div>
            <label for="from" class="text-xs xs:text-sm font-medium text-gray-700 mb-1">@lang('lang.Starting_from')</label>
            <div class="relative max-w-xs">
              <input type="date" class="h-[50px] rounded-[5px] text-xs xs:text-sm border border-[#D1D5DB] w-full px-2 pl-8 font-light" 
              name="from" value="{{ $_from }}" >
            </div>
          </div>
          
          <div>
            <label for="from" class="text-xs xs:text-sm font-medium text-gray-700 mb-1">@lang('lang.To')</label>
            <div class="relative max-w-xs">
              <input type="date" class="h-[50px] rounded-[5px] text-xs xs:text-sm border border-[#D1D5DB] w-full px-2 pl-8 font-light" 
              name="to" value="{{ $_to }}">
            </div>
          </div>
          <div>
            <label for="to" class="text-xs xs:text-sm font-medium text-gray-700 mb-1">  <span class="font-light">@lang('lang.filter') </span></label>
            <div class="relative max-w-xs"> 
            <button type="submit" class="  w-full h-[50px] text-xs sm:text-base bg-[#4D7C0F] rounded-[5px] p-[3px_5px] gap-[10px] text-white">@lang('lang.filter') </button>
            </div>
          </div>
        </div>
      </div>
    </form>

  </div>
</section>
<div class=" w-full-screen  "> 
            <table class="min-w-full border border-gray-300 divide-y divide-gray-300">
                <thead class="bg-gray-100">
            <tr>
                <th
                    class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap">
                   رقم الطلب</th>
                <th
                    class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap">
                    حالة الاشتراك</th>
                <th
                    class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap">
                    التفاصيل</th>
                <th
                    class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
                عرض الطلب </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
        @if(!empty($data))
            @foreach($data as $key => $dt)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-center">
                    {{$dt->id}}</td>
                    <td class="px-4 py-3 text-center">
                      @if($dt->status == 'is_paid')
                        <div class="py-1.5 px-3 bg-emerald-50 rounded-full  inline-flex justify-center w-20 items-center gap-1">
                                <svg width="5" height="6" viewBox="0 0 5 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="2.5" cy="3" r="2.5" fill="#059669"></circle>
                                </svg>
                            <span class="font-medium text-xs text-emerald-600 "> @lang('lang.complete') </span>
                        </div>
                        @elseif($dt->status == 'accepted')
                        <div class="py-1.5 px-3 bg-emerald-50 rounded-full  inline-flex justify-center w-20 items-center gap-1">
                            <svg width="5" height="6" viewBox="0 0 5 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="2.5" cy="3" r="2.5" fill="#059669"></circle>
                            </svg>
                            <span class="font-medium text-xs text-emerald-600 "> @lang('lang.order_accepted') </span>
                        </div> 
                        @elseif($dt->status == 'new')
                        <div class="py-1.5 p3.5 bg-amber-50 rounded-full  inline-flex items-center justify-center w-20 gap-1">
                            <svg width="5" height="6" viewBox="0 0 5 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="2.5" cy="3" r="2.5" fill="#D97706"></circle>
                            </svg>
                            <span class="font-medium text-xs text-amber-600 "> @lang('lang.new')</span>
                        </div>
                        @elseif($dt->status == 'under_revision') 
                        <div class="py-1.5 p3.5 bg-amber-50 rounded-full  inline-flex items-center justify-center w-20 gap-1">
                            <svg width="5" height="6" viewBox="0 0 5 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="2.5" cy="3" r="2.5" fill="#D97706"></circle>
                            </svg>
                            <span class="font-medium text-xs text-amber-600 ">@lang('lang.processing')</span>
                        </div>
                        @elseif($dt->status == 'rejected') 
                        <div class="py-1.53-2.5 bg-red-50 rounded-full  inline-flex w-20 justify-center items-center gap-1">
                            <svg width="5" height="6" viewBox="0 0 5 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="2.5" cy="3" r="2.5" fill="#DC2626"></circle>
                            </svg>
                            <span class="font-medium text-xs text-red-600 ">@lang('lang.rejected')</span>
                        </div>
                        @endif
                    </td>
                <td class="px-4 py-3 text-center">
                 <button onclick="openModal('modelConfirm-{{ $key }}')" >   <i class="fa fa-info-circle text-2xl text-blue-400"></button></td>
                <td class="px-4 py-3 text-center">
                   <a href="{{url('edu-facility/orders/'.$dt->id)}}"><i class="fas fa-eye  text-2xl text-blue-400"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    
    <div class="flex justify-center mt-6">
    {{ $data->links('pagination::tailwind') }}
</div>
</div>



@foreach($data as  $key => $order)
<div id="modelConfirm-{{ $key }}" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 ">
    <div class=" relative top-40 mx-auto shadow-xl rounded-md bg-white max-w-md">

        <div class="flex justify-end p-2">
            <button onclick="closeModal('modelConfirm-{{ $key }}')" type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <div class="p-6 pt-0 text-center">
              <div class="bg-white overflow-hidden shadow rounded-lg border mx-4 box">
        
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">                      
                            <th>@lang('lang.Applicant')</th>
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $order->studentdata->name }}
                    </dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                       @lang('lang.phone')
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                         {{ $order->studentdata->phone }}
                    </dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                       @lang('lang.date')
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                         {{ $order->updated_at}}
                    </dd>
                </div> 
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                       <th>@lang('lang.order_type')</th> 
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">                        
                         {{ $order->pricelist->subscriptionperiod->name  }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
        </div>

    </div>
</div>
</main>
@endforeach



<script>
document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("table");
    const headers = table.querySelectorAll("th");
    let sortDirection = {};

    headers.forEach((header, index) => {
        header.style.cursor = "pointer";

        header.addEventListener("click", () => {
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            // تحديد اتجاه الترتيب
            sortDirection[index] = !sortDirection[index];

            // ترتيب الصفوف
            const sortedRows = rows.sort((a, b) => {
                let tdA = a.querySelectorAll("td, th")[index].innerText.trim();
                let tdB = b.querySelectorAll("td, th")[index].innerText.trim();

                // لو أرقام — ترتيب رقمي
                if (!isNaN(tdA) && !isNaN(tdB)) {
                    tdA = Number(tdA);
                    tdB = Number(tdB);
                }

                if (sortDirection[index]) {
                    return tdA > tdB ? 1 : -1;
                } else {
                    return tdA < tdB ? 1 : -1;
                }
            });

            // إعادة الصفوف للجدول
            tbody.innerHTML = "";
            sortedRows.forEach(row => tbody.appendChild(row));
        });
    });
});
</script>

@endsection
