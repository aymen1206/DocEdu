@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<div class="mb-6">
    <h4 class="text-2xl font-semibold mb-2">@lang('lang.orders')</h4>
    <nav class="text-sm text-gray-500">
        <ol class="flex space-x-2">
            <li><a href="{{url('/edu-facility')}}" class="hover:underline">@lang('lang.home')</a></li>
            <li>/</li>
            <li><a href="{{url('/edu-facility/orders')}}" class="hover:underline">@lang('lang.orders')</a></li>
            <li>/</li>
            <li class="font-medium">@lang('lang.view_order_data')</li>
        </ol>
    </nav>
</div>

<div class="space-y-6">

    {{-- Update Order Status --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h4 class="text-xl font-semibold mb-4">@lang('lang.orders')</h4>

        <form  method="post" action="{{route('edu-facility.order.update')}}"  enctype="multipart/form-data" class="space-y-4">
            @csrf 

            <div class="flex flex-col space-y-2">
                <label class="font-medium">@lang('lang.change_order_status')</label>
                <select name="status" class="border rounded-md p-2" @if($data->status == 'is_paid') disabled @endif>
                    <option value="new" @if($data->status == 'new') selected @endif> @lang('lang.new')</option>
                    <option value="under_revision" @if($data->status == 'under_revision') selected @endif> @lang('lang.processing')</option>
                    <option value="rejected" @if($data->status == 'rejected') selected @endif>@lang('lang.rejected')</option>
                    <option value="accepted" @if($data->status == 'accepted') selected @endif>@lang('lang.accepted')</option>
                    <option value="is_paid" @if($data->status == 'is_paid') selected @endif> @lang('lang.complete')</option>
                </select>
                <input type="hidden" name="id" value="{{$data->id}}">
                <span class="text-red-500 text-sm">{{ $errors->first('status') }}</span>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 disabled:bg-gray-300" @if($data->status == 'is_paid') disabled @endif>
                @lang('lang.update')
            </button>
        </form>
    </div>

    {{-- Order Data --}}
    <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <h4 class="text-xl font-semibold text-center">@lang('lang.order_data')</h4>

        <div  >
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                <tbody>
                    <tr class="text-gray-700">
                        <th class="px-4 py-2 text-left border">@lang('lang.order_num') : {{$data->id}}</th>
                        <th class="px-4 py-2 text-left border">@lang('lang.the_date_of_application') : {{$data->created_at}}</th>
                        <th class="px-4 py-2 text-left border">@lang('lang.latest_order_status_update') : {{$data->updated_at}}</th>
                        <th class="px-4 py-2 text-left border">@lang('lang.status') : 
                            @if($data->status == 'new') @lang('lang.new')
                            @elseif($data->status == 'under_revision') @lang('lang.processing')
                            @elseif($data->status == 'rejected') @lang('lang.rejected')
                            @elseif($data->status == 'accepted') @lang('lang.accepted')
                            @elseif($data->status == 'is_paid') @lang('lang.complete') @endif
                        </th>
                        @if(isset($data->invoice))
                        <th class="px-4 py-2 text-left border">@lang('lang.bill_num') : 
                            <a href="{{ url('/edu-facility/invoice/'.$data->InvoiceId.'/'.$data->id) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{$data->InvoiceId}}
                            </a>
                        </th>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
 

    {{-- Account Details --}}
    <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <h4 class="text-center text-lg font-semibold">@lang('lang.Account_details')</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                <tbody>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.name')</th>
                        <td class="px-4 py-2 border">{{$data->studentdata->name}}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.id_number')</th>
                        <td class="px-4 py-2 border">{{$data->studentdata->id_number}}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.phone')</th>
                        <td class="px-4 py-2 border">{{$data->studentdata->phone}}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.email')</th>
                        <td class="px-4 py-2 border">{{$data->studentdata->email}}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.city')</th>
                        <td class="px-4 py-2 border">
                            @if(LaravelLocalization::getCurrentLocaleNative() == 'العربية')
                                {{ DB::table('cities')->where('id',$data->studentdata->city)->first()->nameAr }}
                            @else
                                {{ DB::table('cities')->where('id',$data->studentdata->city)->first()->nameEn }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Subscriber Data --}}
    <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <h4 class="text-center text-lg font-semibold">@lang('lang.Subscriber_data')</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                <tbody>
                @if ($data->children == 0 || $data->children == null )
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.Subtype')</th>
                        <td class="px-4 py-2 border">@lang('lang.by_personal_account')</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.profile_image')</th>
                        <td class="px-4 py-2 border"><a href="{{ asset('/'.$data->studentdata->image) }}" class="text-blue-600 hover:underline fancybox">@lang('lang.view')</a></td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.id_number_photo')</th>
                        <td class="px-4 py-2 border"><a href="{{ asset('/'.$data->studentdata->id_image) }}" class="text-blue-600 hover:underline fancybox">@lang('lang.view')</a></td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.scientific_certificate_photo')</th>
                        <td class="px-4 py-2 border"><a href="{{ asset('/'.$data->studentdata->certificate_image) }}" class="text-blue-600 hover:underline fancybox">@lang('lang.view')</a></td>
                    </tr>
                @else
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.Subtype')</th>
                        <td class="px-4 py-2 border">@lang('lang.subscribe_to_one_of_the_dependents')</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.st_name')</th>
                        <td class="px-4 py-2 border">{{ $data->childrendata->name }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.gender')</th>
                        <td class="px-4 py-2 border">
                            @if ($data->childrendata->gender == 'male') @lang('lang.male') @else @lang('lang.female') @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.st_birth_date')</th>
                        <td class="px-4 py-2 border">{{ $data->childrendata->birth_date }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.st_profile_photo')</th>
                        <td class="px-4 py-2 border"><a href="{{ asset('/'.$data->childrendata->image) }}" class="text-blue-600 hover:underline fancybox">@lang('lang.view')</a></td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.family_id')</th>
                        <td class="px-4 py-2 border"><a href="{{ asset('/'.$data->studentdata->family_id_image) }}" class="text-blue-600 hover:underline fancybox">@lang('lang.view')</a></td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.st_ID_num')</th>
                        <td class="px-4 py-2 border">{{$data->childrendata->id_number}}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.st_ID')</th>
                        <td class="px-4 py-2 border"><a href="{{ asset('/'.$data->childrendata->id_image) }}" class="text-blue-600 hover:underline fancybox">@lang('lang.view')</a></td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 border">@lang('lang.scientific_certificate_photo')</th>
                        <td class="px-4 py-2 border"><a href="{{ asset('/'.$data->childrendata->certificate_image) }}" class="text-blue-600 hover:underline fancybox">@lang('lang.view')</a></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Subscription Package --}}
    <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <h4 class="text-center text-lg font-semibold">@lang('lang.subscription_package_data')</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                <tbody>
                    <tr><th class="px-4 py-2 border w-1/3">@lang('lang.package')</th><td class="px-4 py-2 border">{{$data->pricelist->name}}</td></tr>
                    <tr><th class="px-4 py-2 border w-1/3">@lang('lang.stage')</th><td class="px-4 py-2 border">{{$data->pricelist->_type->name}}</td></tr>
                    <tr><th class="px-4 py-2 border">@lang('lang.class')</th><td class="px-4 py-2 border">{{$data->pricelist->_stage->name}}</td></tr>
                    <tr><th class="px-4 py-2 border">@lang('lang.payment_method')</th><td class="px-4 py-2 border">{{$data->pricelist->subscriptionperiod->name}}</td></tr>
                    <tr><th class="px-4 py-2 border">@lang('lang.price')</th><td class="px-4 py-2 border">{{$data->pricelist->price}}</td></tr>
                    <tr><th class="px-4 py-2 border">@lang('lang.The_total_number_of_students')</th><td class="px-4 py-2 border">{{$data->pricelist->allowed_number}}</td></tr>
                    <tr><th class="px-4 py-2 border">@lang('lang.Reserved_places')</th><td class="px-4 py-2 border">{{ $data->pricelist->booked }}</td></tr>
                    <tr><th class="px-4 py-2 border">@lang('lang.vacancies')</th><td class="px-4 py-2 border">{{ $data->pricelist->free }}</td></tr>
                    <tr><th class="px-4 py-2 border">@lang('lang.note')</th><td class="px-4 py-2 border">{{$data->pricelist->note}}</td></tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
</main>
@endsection
