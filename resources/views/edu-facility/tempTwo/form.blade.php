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
    .letter-form-wrapper label {
        display: block;
        margin-top: 14px;
        font-weight: 600;
        color: #334155;
    }
    .letter-form-wrapper input[type="text"],
    .letter-form-wrapper textarea {
        width: 100%;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        margin-top: 7px;
        background: #ffffff;
        color: #0f172a;
        box-sizing: border-box;
        font-size: 1rem;
    }
    .letter-form-wrapper textarea {
        min-height: 170px;
        resize: vertical;
    }
        .letter-form-wrapper button {
        margin-top: 18px;
        width: 100%;
        background: #2563eb !important;
        color: #fff !important;
        border: 2px solid #1e40af;
        border-radius: 10px;
        padding: 12px;
        font-size: 1.05rem;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.2s ease;
        display: inline-flex !important;
        justify-content: center;
        align-items: center;
        min-height: 46px;
        opacity: 1 !important;
        visibility: visible !important;
    }
    .letter-form-wrapper button:hover {
        background: #1d4ed8;
    }
    .letter-form-actions {
        margin-top: 22px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    .letter-form-actions button {
        width: 100%;
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
                    <a href="{{url('/edu-facility/APPRECIATION')}}" class="text-blue-600 hover:underline">
                        @lang('lang.CertAPPRECIA')
                    </a>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="letter-form-wrapper">
    <h2> نموزج شهادة تقديرية </h2>

    <form method="post" action="{{ route('edu-facility.tempTwo.pdf') }}" id="pdfForm">
        @csrf
        <label>اسم الطالب</label>
        <input id="letter_title" type="text" name="name" placeholder="اكتب اسم الطالب هنا">
        
        <input   type="text" name="schoolname" value="{{$schoolname}}" hidden>
        <button type="submit" style="background:#2563eb;color:#fff;display:inline-block;opacity:1;visibility:visible;border:2px solid #1e40af;border-radius:10px;padding:12px 16px;min-width:180px;">تحميل PDF</button>
    </form>

    <form method="post" action="{{ route('edu-facility.tempTwo.word') }}" style="margin-top: 16px;" onsubmit="document.getElementById('word_title').value=document.getElementById('letter_title').value;document.getElementById('word_content').value=document.getElementById('letter_content').value;">
        @csrf
        <input id="word_title" type="hidden" name="name" value="">
        <input   type="text" name="schoolname" value="{{$schoolname}}" hidden>
        <button type="submit" style="background:#2563eb;color:#fff;display:inline-block;opacity:1;visibility:visible;border:2px solid #1e40af;border-radius:10px;padding:12px 16px;min-width:180px;">تحميل Word</button>
    </form>
    
    <form method="post" action="{{ route('edu-facility.tempTwo.preview') }}" style="margin-top: 16px;" onsubmit="document.getElementById('preview_title').value=document.getElementById('letter_title').value;document.getElementById('preview_content').value=document.getElementById('letter_content').value;">
        @csrf
        <input id="preview_title" type="hidden" name="name" value="">
        <input   type="text" name="schoolname" value="{{$schoolname}}" hidden>
        <button type="submit" style="background:#2563eb;color:#fff;display:inline-block;opacity:1;visibility:visible;border:2px solid #1e40af;border-radius:10px;padding:12px 16px;min-width:180px;">معاينة</button>
    </form>
</div> 
</main>
@endsection