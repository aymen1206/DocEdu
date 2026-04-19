@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<div class="mb-6 mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h4 class="text-xl font-semibold">@lang('lang.Subscription_prices') </h4>
        <nav class="flex items-center space-x-2 mt-2 sm:mt-0" aria-label="breadcrumb">
            <ol class="flex space-x-2 text-gray-500 text-sm">
                <li><a href="{{url('/edu-facility')}}" class="hover:text-gray-700">@lang('lang.home')</a></li>
                <li>/</li>
                <li><a href="{{url('/edu-facility/prices')}}" class="hover:text-gray-700">@lang('lang.Subscription_prices')</a></li>
                <li>/</li>
                <li class="text-gray-700">@lang('lang.update')</li>
            </ol>
        </nav>
    </div>
</div>

<div class="w-full max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-6">
            <form method="post" action="{{route('edu-facility.priceupdate')}}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.username_ar')</label>
                    <input name="name" required value="{{ $data['price']->name }}" placeholder="@lang('lang.write_a_title_like_sixth_grade_subscription')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                    <input name="facilityid" value="{{$data['facility']->id}}" hidden>
                    <span class="text-red-600 text-sm">{{ $errors->first('name') }}</span>
                </div>

                {{-- English Name --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.english_name')</label>
                    <input name="name_en" required value="{{ $data['price']->name_en }}" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                    <span class="text-red-600 text-sm">{{ $errors->first('name_en') }}</span>
                </div>

                {{-- Stage --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.stage')</label>
                    <select class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300" name="type">
                        @foreach($data['types'] as $dt)
                            <option value="{{$dt->id}}" @if($data['price']->type == $dt->id) selected @endif>{{$dt->name}}</option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm">{{ $errors->first('type') }}</span>
                </div>

                {{-- Class --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.class')</label>
                    <select name="stage" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                        @foreach(DB::table("edu_stages")->where("type_id",$data['price']->type)->get() as $v)
                            <option value="{{$v->id}}" @if($general->_stage->id == $v->id) selected @endif>{{$v->name}}</option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm">{{ $errors->first('stage') }}</span>
                </div>

                {{-- Subject --}}
                @if($data['facility']->facility_type == 2)
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.subject')</label>
                    <select name="subject" required class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                        @foreach($data['subjects'] as $subject)
                            <option value="{{$subject->id}}">{{$subject->name}}</option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm">{{ $errors->first('subscription_period') }}</span>
                </div>
                @endif

                {{-- Payment Method --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.payment_method')</label>
                    <select name="subscription_period" required class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                        @foreach($data['subscription_periods'] as $dt)
                            <option value="{{$dt->id}}" @if($data['price']->subscription_period == $dt->id) selected @endif>{{$dt->name}}</option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm">{{ $errors->first('subscription_period') }}</span>
                </div>

                {{-- Before Discount --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.before_discount')</label>
                    <input type="number" min="0" name="price_discount" value="{{$data['price']->price_discount}}" placeholder="@lang('lang.before_discount')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                    <span class="text-red-600 text-sm">{{ $errors->first('price_discount') }}</span>
                </div>

                {{-- After Discount --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.after_discount')</label>
                    <input type="number" min="0" name="price" required value="{{$data['price']->price}}" placeholder="@lang('lang.after_discount')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                    <span class="text-red-600 text-sm">{{ $errors->first('price') }}</span>
                </div>

                {{-- Total Students --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.The_total_number_of_students')</label>
                    <input type="number" min="0" name="allowed_number" required value="{{$data['price']->allowed_number}}" placeholder="@lang('lang.The_total_number_of_students')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                    <span class="text-red-600 text-sm">{{ $errors->first('allowed_number') }}</span>
                </div>

                {{-- Note --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.note')</label>
                    <textarea name="note" rows="5" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">{{$data['price']->note}}</textarea>
                    <span class="text-red-600 text-sm">{{ $errors->first('note') }}</span>
                </div>

                <div>
                    <label class="block mb-1 font-medium">@lang('lang.note_en')</label>
                    <textarea name="note_en" rows="5" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">{{$data['price']->note_en}}</textarea>
                    <span class="text-red-600 text-sm">{{ $errors->first('note_en') }}</span>
                </div>

                <input type="hidden" name="priceid" value="{{$data['price']->id}}">

                {{-- Submit --}}
                <div class="text-right">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-md">@lang('lang.update')</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.querySelector('select[name="type"]');
    const stageSelect = document.querySelector('select[name="stage"]');
    const periodSelect = document.querySelector('select[name="subscription_period"]');

    typeSelect.addEventListener('change', async function () {
        const typeId = this.value;

        // إذا لا توجد قيمة، نظف القوائم
        if (!typeId) {
            stageSelect.innerHTML = '';
            periodSelect.innerHTML = '';
            return;
        }

        try {
            // جلب المراحل
            const stagesRes = await fetch(`/edu-facility/get_stages/${typeId}`);
            const stagesData = await stagesRes.json();
            stageSelect.innerHTML = '';
            for (const [key, value] of Object.entries(stagesData)) {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = value;
                stageSelect.appendChild(option);
            }

            // جلب طرق الدفع
            const paymentRes = await fetch(`/edu-facility/get_payment_methods/${typeId}`);
            const paymentData = await paymentRes.json();
            periodSelect.innerHTML = '';
            for (const [key, value] of Object.entries(paymentData)) {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = value;
                periodSelect.appendChild(option);
            }

        } catch (error) {
            console.error('حدث خطأ عند جلب البيانات:', error);
        }
    });
});
</script>
@endsection 