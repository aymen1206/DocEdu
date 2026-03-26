<!doctype html>
@php
    use ArPHP\I18N\Arabic;
    $Arabic = new Arabic();
    
        $schoolname =  $data['schoolname'];
        $Schoolname = $Arabic->utf8Glyphs( $schoolname);
        $title = $Arabic->utf8Glyphs('استدعاء ولي الأمر');
        $subtitle = $Arabic->utf8Glyphs('إلى ولي امر الطالب/ة : ' . $data['name']);
        $date = $Arabic->utf8Glyphs('التاريخ: ' . \Carbon\Carbon::now()->format('Y/m/d'));
        $closing = $Arabic->utf8Glyphs('مع خالص الشكر والتقدير،');
        $signature = $Arabic->utf8Glyphs('إدارة'. $schoolname);        
        $parenta =  $data['name']  ;        
        $parent = $Arabic->utf8Glyphs($parenta);
        $bodyP1 = "السلام عليكم ورحمة الله وبركاته،";    

        $bodyP2a = "نود إبلاغكم بأنه بناءً على المتابعة التعليمية  ";          
        $bodyP2b = " لسلوك وأداء الطالب ";
        $bodyP2e=" فإن المدرسة بحاجة إلى ";          
        $bodyP2c = "حضور ولي أمره  في أقرب وقت ممكن";          
        $bodyP2d = " لمناقشة الأمر مع إدارة المدرسة ";                    
        $bodyP3 = "وتفضلوا بقبول فائق الاحترام والتقدير.";       
        $bodyText1 = $Arabic->utf8Glyphs($bodyP1);
        $bodyText2a = $Arabic->utf8Glyphs($bodyP2a);   
        $bodyText2b = $Arabic->utf8Glyphs($bodyP2b);   
        $bodyText2c = $Arabic->utf8Glyphs($bodyP2c);   
        $bodyText2d = $Arabic->utf8Glyphs($bodyP2d); 
        $bodyText2e = $Arabic->utf8Glyphs($bodyP2e);        
        $bodyText3 = $Arabic->utf8Glyphs($bodyP3);

@endphp
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        body { font-family: "dejavusans", "DejaVu Sans", sans-serif; direction: rtl; text-align: right; margin: 0; padding: 24px; color: #0f172a; }
        .header { text-align: center; margin-bottom: 18px; }
        .school-name { font-size: 24px; font-weight: bold; color: #1f2937; }
        .letter-title { margin-top: 4px; font-size: 20px; font-weight: bold; color: #1f2937; }
        .meta { margin: 18px 0; font-size: 14px; text-align: right; }
        .meta p { margin: 4px 0; text-align: right; }
        .content { font-size: 15px; line-height: 1.8; text-align: right; direction: rtl; }
        .signature { margin-top: 24px; font-size: 15px; text-align: right; }
    </style>
</head>

<body dir="rtl">
    <div class="header">
        
        <p>
           <img src="{{ public_path('assets/images/schoollogo.png') }}" width="50" height="50" >  
        </p>
        <div class="school-name">{{$Schoolname}}</div>
        <div class="letter-title">{{$title}}</div>
    </div>

    <div  >
         
        <p>{{$subtitle}}</p>
        <p>{{$date}}</p>
        <p>{{$bodyText1}}</p>
        <p style="text-align:right"><strong>{{$parent}}</strong> {{$bodyText2b}} {{$bodyText2a}}</p>       
        <label>{{$bodyText2d}} {{$bodyText2c}} {{$bodyText2e}} </label>
        <p>{{$bodyText3}}</p>
    </div>

    <div class="signature">
        <p>{{$closing}}</p>
        <p>{{$signature}}</p>
    </div>
</body>
</html>
