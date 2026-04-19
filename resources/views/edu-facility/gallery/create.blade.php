@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<div class="mb-4">
    <h4 class="text-xl font-semibold mb-2">@lang('lang.gallery')</h4>
    <nav aria-label="breadcrumb">
        <ol class="flex text-sm text-gray-500 space-x-2 mb-4">
            <li><a href="{{url('/edu-facility')}}" class="hover:underline">@lang('lang.home')</a></li>
            <li>/</li>
            <li><a href="{{url('/edu-facility/gallery')}}" class="hover:underline">@lang('lang.gallery')</a></li>
            <li>/</li>
            <li class="text-gray-700">@lang('lang.add_new')</li>
        </ol>
    </nav>
</div>

<div class="overflow-x-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <form method="post" action="{{route('edu-facility.galleryUpload')}}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="flex flex-col md:flex-row items-center gap-4">
                <label class="w-full md:w-1/12 font-medium">@lang('lang.image') <span class="text-red-500 font-extrabold">*</span></label>
                
                <div class="w-full md:w-5/6">
                    <input type="file" accept="image/png, image/gif, image/jpeg, image/webp" name="image" required class="w-full border rounded-lg px-3 py-2"
                        onchange="loadPreview(this);">
                    <span class="text-red-600 text-sm">{{ $errors->first('image') }}</span>
                </div>

                <div class="w-full md:w-1/6">
                    <img id="preview_img" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="w-full h-auto rounded-lg border" />
                </div>
            </div>

            <div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">@lang('lang.add_new')</button>
            </div>
        </form>
    </div>
</div>

</main> 
    <script>
        function loadPreview(input, id) {
            id = id || '#preview_img';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width(200)
                        .height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection 