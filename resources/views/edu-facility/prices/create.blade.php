@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100"> 
<div class="mb-6 mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h4 class="text-xl font-semibold">@lang('lang.Subscription_prices')</h4>
        <nav class="flex items-center space-x-2 mt-2 sm:mt-0" aria-label="breadcrumb">
            <ol class="flex space-x-2 text-gray-500 text-sm">
                <li><a href="{{ url('/edu-facility') }}" class="hover:text-gray-700">@lang('lang.home')</a></li>
                <li>/</li>
                <li><a href="{{ url('/edu-facility/prices') }}" class="hover:text-gray-700">@lang('lang.Subscription_prices')</a></li>
                <li>/</li>
                <li class="text-gray-700">@lang('lang.add_new')</li>
            </ol>
        </nav>
    </div>
</div>

<div class="w-full max-w-7xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-6">
            <form method="post" action="{{ route('edu-facility.pricecreate') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.username_ar') <span class="text-red-500 font-extrabold">*</span></label>
                    <input name="name" required value="{{ old('name') }}" placeholder="@lang('lang.write_a_title_like_sixth_grade_subscription')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                    <span class="text-red-600 text-sm">{{ $errors->first('name') }}</span>
                </div>

                {{-- English Name --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.english_name') <span class="text-red-500 font-extrabold">*</span></label>
                    <input name="name_en" required value="{{ old('name_en') }}" placeholder="@lang('lang.write_a_title_like_sixth_grade_subscription_en')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                    <span class="text-red-600 text-sm">{{ $errors->first('name_en') }}</span>
                </div>

                {{-- Stage --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.stage') <span class="text-red-500 font-extrabold">*</span></label>
                    <select id="type" name="type" required class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                        <option value="" disabled selected>@lang('lang.stage')</option>
                        @foreach($data['types'] as $dt)
                            <option value="{{ $dt->id }}" @if($data['facility']->type_id == $dt->id) selected @endif>{{ $dt->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm">{{ $errors->first('type') }}</span>
                </div>

                {{-- Class --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.class') <span class="text-red-500 font-extrabold">*</span></label>
                    <select  id="stage"  name="stage" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300"></select>
                    <span class="text-red-600 text-sm">{{ $errors->first('stage') }}</span>
                </div>

                {{-- Subject (only facility_type 2) --}}
                @if(auth()->guard('edu_facility')->user()->facility_type == 2)
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.subject') <span class="text-red-500 font-extrabold">*</span></label>
                    <select id="subject"  name="subject" required class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                        @foreach($data['subjects'] as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm">{{ $errors->first('subscription_period') }}</span>
                </div>
                @endif

                {{-- Payment Method --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.payment_method') <span class="text-red-500 font-extrabold">*</span></label>
                    <select name="subscription_period" required class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300"></select>
                    <span class="text-red-600 text-sm">{{ $errors->first('subscription_period') }}</span>
                </div>

                {{-- Prices --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.before_discount') <span class="text-red-500 font-extrabold">*</span></label>
                    <input type="number" min="0" name="price_discount" value="{{ old('price_discount') }}" placeholder="@lang('lang.before_discount')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                    <span class="text-red-600 text-sm">{{ $errors->first('price_discount') }}</span>
                </div>

                <div>
                    <label class="block mb-1 font-medium">@lang('lang.after_discount') <span class="text-red-500 font-extrabold">*</span></label>
                    <input type="number" min="0" name="price" required value="{{ old('price') }}" placeholder="@lang('lang.after_discount')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                    <span class="text-red-600 text-sm">{{ $errors->first('price') }}</span>
                </div>

                {{-- Total students --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.The_total_number_of_students') <span class="text-red-500 font-extrabold">*</span></label>
                    <input type="number" min="0" name="allowed_number" required value="{{ old('allowed_number') }}" placeholder="@lang('lang.The_total_number_of_students')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300">
                    <span class="text-red-600 text-sm">{{ $errors->first('allowed_number') }}</span>
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block mb-1 font-medium">@lang('lang.note')</label>
                    <textarea name="note" rows="5" placeholder="@lang('lang.note')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300"></textarea>
                    <span class="text-red-600 text-sm">{{ $errors->first('note') }}</span>
                </div>

                <div>
                    <label class="block mb-1 font-medium">@lang('lang.note_en')</label>
                    <textarea name="note_en" rows="5" placeholder="@lang('lang.note_en')" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-300"></textarea>
                    <span class="text-red-600 text-sm">{{ $errors->first('note_en') }}</span>
                </div>

                {{-- Submit --}}
                <div class="text-right">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-md">@lang('lang.add_new')</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
 