@extends('edu-facility.includes.master')    
@section('content')

<style>
    .letter-form-wrapper {
        max-width: 720px;
        margin: 40px auto;
        background: #f8fafc;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        padding: 24px;
        border: 1px solid #e2e8f0;
        font-family: "Cairo", sans-serif;
    }
    .letter-form-wrapper h2 {
        margin-bottom: 18px;
        color: #1f2937;
        font-size: 1.45rem;
        text-align: center;
    }
    .image-box {
        border-radius: 12px;
        background-color: #e0e7ff;
        overflow: visible;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .image-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }
    .image-box img {
        width: 100%;
        height: 150px; 
    }
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 24px;
    }
    .image-box-link {
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }
</style>
<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
<div class="mb-6">
    <div class="flex flex-col">
        <h4 class="text-2xl font-semibold">@lang('lang.CertAPPRECIA')</h4>

        <nav class="mt-2 text-sm text-gray-500">
            <ol class="flex gap-2">
                <li>
                    <a href="{{url('/edu-facility')}}" class="text-blue-600 hover:underline">
                        @lang('lang.home')
                    </a>
                </li>
                <li>/</li>
                <li>
                    <a href="{{url('/edu-facility/Appreciation')}}" class="text-blue-600 hover:underline">
                        @lang('lang.CertAPPRECIA')
                    </a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="letter-form-wrapper">
    <h2>نماذج شهادات شكر وتقدير للطلاب </h2>

    <div class="image-gallery">
        <a href="{{url('/edu-facility/appreciation/template-1')}}" class="image-box-link">
            <div class="image-box">
                <img src="{{asset('assets/Templates/1.jpg') }}" alt="نموذج شهادة 1" width="500" height="450" class="p-3">
            </div>
        </a>
        <a href="{{url('/edu-facility/appreciation/template-2')}}" class="image-box-link">
            <div class="image-box">
                <img src="{{asset('assets/Templates/2.jpg') }}" alt="نموذج شهادة 2" width="500" height="450" class="p-3">
            </div>
        </a>
        <a href="{{url('/edu-facility/appreciation/template-3')}}" class="image-box-link">
            <div class="image-box">
                <img src="{{asset('assets/Templates/3.jpg') }}" alt="نموذج شهادة 3" width="500" height="450" class="p-3">
            </div>
        </a>
    </div>
</div> 
</main>
@endsection