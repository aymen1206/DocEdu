@extends('edu-facility.includes.master')    
@section('content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<div class="mb-4">
    <div class="flex flex-col md:flex-row items-center justify-between mb-4">
        <h4 class="text-xl font-semibold">@lang('lang.gallery')</h4>
        <a href="{{url('edu-facility/gallery/create')}}" class="bg-blue-600 text-white px-4 py-2 rounded flex items-center gap-2 hover:bg-blue-700">
            <span class="fa fa-plus-square"></span> @lang('lang.add_new')
        </a>
    </div>

    <nav class="mb-4" aria-label="breadcrumb">
        <ol class="flex text-sm text-gray-500 space-x-2">
            <li><a href="{{url('/edu-facility')}}" class="hover:underline">@lang('lang.home')</a></li>
            <li>/</li>
            <li class="text-gray-700">@lang('lang.gallery')</li>
        </ol>
    </nav>
</div>

<div class="overflow-x-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-4 border-b">
            <h4 class="text-lg font-medium">@lang('lang.gallery')</h4>
        </div>
        <div class="p-4">
            <table class="min-w-full border-collapse table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-center px-4 py-2 border">@lang('lang.image')</th>
                        <th class="text-center px-4 py-2 border">@lang('lang.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $dt)
                    <tr class="even:bg-gray-50">
                        <td class="text-center px-4 py-2 border">
                            <a data-fancybox="gallery" href="{{asset($dt->image)}}">
                                <img src="{{asset($dt->image)}}" class="mx-auto w-48" />
                            </a>
                        </td>
                        <td class="text-center px-4 py-2 border">
                            <a href="{{url('edu-facility/gallery/'.$dt->id.'/delete')}}" title="@lang('lang.delete')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm flex items-center justify-center gap-1 delete-confirm">
                                <i class="fa fa-trash"></i> @lang('lang.delete')
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</main>
@endsection