@extends('edu-facility.includes.master')    
@section('content') 
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
    <div class="bg-gray-100 border-b">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center py-4">
            
            <!-- العنوان -->
            <div class="md:w-5/12">
                <h4 class="text-2xl font-semibold text-gray-800">
                    @lang('lang.Profile_settings')
                </h4>

                <!-- Breadcrumb -->
                <div class="flex items-center mt-2">
                    <nav aria-label="breadcrumb">
                        <ol class="flex gap-2 text-sm text-gray-600">
                            <li>
                                <a href="{{url('/edu-facility')}}" class="hover:text-blue-600">
                                    @lang('lang.home')
                                </a>
                            </li>

                            <li>/</li>

                            <li class="text-blue-600 font-medium">
                                <a href="{{url('/edu-facility/profile')}}" class="hover:text-blue-700">
                                    @lang('lang.Profile_settings')
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="p-6 max-w-3xl mx-auto"> 

    <form method="POST" action="{{ route('edu-facility.profile.update') }}"  enctype="multipart/form-data" >
        @csrf
{{-- Name --}}
                <div>
                    <label class="block font-medium mb-1">@lang('lang.username_ar') <span class="text-red-500 font-extrabold">*</span></label>
                    <input type="text" name="name"
                           class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                           value="{{ $data->name }}" required placeholder="@lang('lang.name')">
                    <span class="text-red-600 text-sm">{{ $errors->first('name') }}</span>
                </div>

                {{-- English Name --}}
                <div>
                    <label class="block font-medium mb-1">@lang('lang.english_name') <span class="text-red-500 font-extrabold">*</span></label>
                    <input type="text" name="name_en"
                           class="w-full border border-gray-900 border-gray-900 "
                           value="{{ $data->name_en }}" required>
                    <span class="text-red-600 text-sm">{{ $errors->first('name_en') }}</span>
                </div>

                {{-- About --}}
                <div>
                    <label class="block font-medium mb-1">@lang('lang.about') <span class="text-red-500 font-extrabold">*</span></label>
                    <textarea name="about" rows="5"
                              class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                              required>{{ $data->about }}</textarea>
                    <span class="text-red-600 text-sm">{{ $errors->first('about') }}</span>
                </div>

                {{-- About EN --}}
                <div>
                    <label class="block font-medium mb-1">@lang('lang.text_en') <span class="text-red-500 font-extrabold">*</span></label>
                    <textarea name="about_en" rows="5"
                              class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                              required>{{ $data->about_en }}</textarea>
                    <span class="text-red-600 text-sm">{{ $errors->first('about_en') }}</span>
                </div>

                {{-- Facility Type --}}
                <div>
                    <label class="block font-medium mb-1">@lang('lang.type') <span class="text-red-500 font-extrabold">*</span></label>
                    <select name="type_id"
                            class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                            required>
                        <option disabled selected>@lang('lang.please_select_the_type_of_educational_facility')</option>
                        @foreach($data2 as $dt)
                            <option value="{{ $dt->id }}" @if($data->facility_type == $dt->id) selected @endif>
                                {{ $dt->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm">{{ $errors->first('type_id') }}</span>
                </div>

                {{-- Stages (select2 multiple) --}}
                <div>
                    <label class="block font-medium mb-1">@lang('lang.stage') <span class="text-red-500 font-extrabold">*</span></label>
                    <select name="facility_types[]" id="select_2" multiple
                            class="select2 w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900">
                        @foreach($current_types as $ct)
                            <option selected value="{{ $ct->id }}">{{ $ct->name }}</option>
                        @endforeach
                        @foreach($data3 as $dt3)
                            <option value="{{ $dt3->id }}">{{ $dt3->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm">{{ $errors->first('stages') }}</span>
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block font-medium mb-1">@lang('lang.phone') <span class="text-red-500 font-extrabold">*</span></label>
                    <input type="tel" name="phone"
                           class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                           value="{{ $data->phone }}" required placeholder="05XXXXXXXXX">
                    <span class="text-red-600 text-sm">{{ $errors->first('phone') }}</span>
                </div>

                {{-- Mobile --}}
                <div>
                    <label class="block font-medium mb-1">@lang('lang.mobile') <span class="text-red-500 font-extrabold">*</span></label>
                    <input type="text" name="mobile"
                           class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                           value="{{ $data->mobile }}" required>
                    <span class="text-red-600 text-sm">{{ $errors->first('mobile') }}</span>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block font-medium mb-1">@lang('lang.email') <span class="text-red-500 font-extrabold">*</span></label>
                    <input type="email" name="email"
                           class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                           value="{{ $data->email }}" required>
                    <span class="text-red-600 text-sm">{{ $errors->first('email') }}</span>
                </div>

                {{-- City --}}
                <div>
                    <label class="block font-medium mb-1">@lang('lang.city') <span class="text-red-500 font-extrabold">*</span></label>
                    <select name="city"
                            class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                            required>
                        @foreach(DB::table('cities')->get() as $city)
                            <option value="{{ $city->id }}" @if($data->city == $city->id) selected @endif>
                                @if(LaravelLocalization::getCurrentLocaleNative() == 'العربية')
                                    {{ $city->nameAr }}
                                @else
                                    {{ $city->nameEn }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm">{{ $errors->first('city') }}</span>
                </div>

                
        {{-- حقل عنوان اختياري --}}
        <label class="block mb-2 text-sm font-medium">العنوان  </label>
        <input type="text" name="address" id="addressInput" value="{{ $data->address }}"
               class="w-full border rounded px-3 py-2 mb-3" readonly placeholder="ابحث بعنوان أو اضغط على الخريطة">

        {{-- خريطة --}}
        <div id="map" class="w-full h-72 rounded border" ></div>

        {{-- إحداثيات مرئية للمستخدم (يمكن جعلها readonly) --}}
        <div class="mt-3 grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm">Latitude</label>
                <input type="text" id="lat" name="latitude" readonly class="w-full border rounded px-3 py-2 bg-gray-50">
            </div>
            <div>
                <label class="block text-sm">Longitude</label>
                <input type="text" id="lng" name="longitude" readonly class="w-full border rounded px-3 py-2 bg-gray-50">
                <input type="text" name="map_location" id="location" value="{{ $data->map_location }}" readonly class="w-full border rounded px-3 py-2 bg-gray-50" hidden>
                 
            </div>
        </div>

                {{-- Facility Attachments (commercial, owner_id, logo) --}}
                <div class="space-y-6 is_facility_1_3_5">

                    <div>
                        <label class="block font-medium mb-1">@lang('lang.commercial_attach') <span class="text-red-500 font-extrabold">*</span></label>
                        <img src="{{ asset($data->commercial_record) }}" class="w-64 rounded-lg mb-3">
                        <input type="file" name="commercial_record"
                               class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                               >
                        <span class="text-red-600 text-sm">{{ $errors->first('commercial_record') }}</span>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">@lang('lang.owner_id_attach') <span class="text-red-500 font-extrabold">*</span></label>
                        <img src="{{ asset($data->owner_id) }}" class="w-64 rounded-lg mb-3">
                        <input type="file" name="owner_id"
                               class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                               >
                        <span class="text-red-600 text-sm">{{ $errors->first('owner_id') }}</span>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">@lang('lang.logo_attach') <span class="text-red-500 font-extrabold">*</span></label>
                        <img src="{{ asset($data->logo) }}" class="w-64 rounded-lg mb-3">
                        <input type="file" name="logo"
                               class="w-full rounded-lg  border border-gray-900 border-gray-900 ring-gray-900"
                               >
                        <span class="text-red-600 text-sm">{{ $errors->first('logo') }}</span>
                    </div>
                </div>

                {{-- Submit --}}
                <div>
                    <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        @lang('lang.update')
                    </button>
                </div>

            </form>
</div>

</main>
 
{{-- Google Maps JS: استبدل YOUR_GOOGLE_MAPS_API_KEY بالمفتاح الفعلي --}}
<script>
    let map;
    let marker;
    let geocoder;
    let autocomplete;
    
    let locat= document.getElementById('location').value ;
    const [lat,lng] = locat.split(",").map(Number);
    function initMap() {
        
        const defaultPos = { lat ,lng}; 

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultPos,
            zoom: 12,
        });

        geocoder = new google.maps.Geocoder();

        // Marker قابل للسحب
        marker = new google.maps.Marker({
            position: defaultPos,
            map: map,
            draggable: true,
        });

        // ضع القيم الافتراضية إذا أردت إرسال قيمة افتراضية للباك
        setInputs(defaultPos.lat, defaultPos.lng);

        // عند سحب الماركر
        marker.addListener('dragend', function() {
            const pos = marker.getPosition();
            setInputs(pos.lat(), pos.lng());
            // (اختياري) اعمل Reverse Geocode لعرض العنوان في input
            reverseGeocode(pos);
        });

        // عند النقر على الخريطة: انقل الماركر
        map.addListener('click', function(e) {
            const clickedPos = { lat: e.latLng.lat(), lng: e.latLng.lng() };
            marker.setPosition(clickedPos);
            setInputs(clickedPos.lat, clickedPos.lng);
            reverseGeocode(e.latLng);
        });

        // Autocomplete للبحث بالعنوان (اختياري)
        const addressInput = document.getElementById('addressInput');
        autocomplete = new google.maps.places.Autocomplete(addressInput);
        autocomplete.bindTo('bounds', map);
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;
            const loc = place.geometry.location;
            map.panTo(loc);
            map.setZoom(15);
            marker.setPosition(loc);
            setInputs(loc.lat(), loc.lng());
        });
    }

    function setInputs(lat, lng) {
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
        document.getElementById('location').value = lat+','+lng;
    }

    function reverseGeocode(latlng) {
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK" && results[0]) {
                document.getElementById('addressInput').value = results[0].formatted_address;
            }
        });
    }
</script>

<script  
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRYgXbnwFrKQnKcggeZvkoKxuOWtvGYOU&libraries=places&callback=initMap"  async
    defer>
</script> 
@endsection
 