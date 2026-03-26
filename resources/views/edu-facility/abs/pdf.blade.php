<!doctype html>
@php
    use ArPHP\I18N\Arabic;
    $Arabic = new Arabic();
    
        $schoolname =  $data['schoolname'];
        $apsdate =  $data['apsdate'];
        $Schoolname = $Arabic->utf8Glyphs( $schoolname);
        $title = $Arabic->utf8Glyphs('إشعار غياب');
        $subtitle = $Arabic->utf8Glyphs('إلى ولي امر الطالب/ة : ' . $data['name']);
        $date = $Arabic->utf8Glyphs('التاريخ: ' . \Carbon\Carbon::now()->format('Y/m/d'));
        $closing = $Arabic->utf8Glyphs('مع خالص الشكر والتقدير،');
        $signature = $Arabic->utf8Glyphs('إدارة'. $schoolname);        
        $parenta =  $data['name']  ;        
        $parent = $Arabic->utf8Glyphs($parenta);
        $bodyP1 = "السلام عليكم ورحمة الله وبركاته،";    
        $bodyP2 = " نود إشعاركم بأن الطالب  / ";                        
        $bodyP3 = "قد تغيب عن المدرسة في يوم/ ";                   
        $bodyP4 = " وذلك دون تقديم عذر رسمي ";                   
        $bodyP5 = "نأمل منكم التكرم بمتابعة الأمر والتأكد لإفادتنا ";
        $bodyP6 = " بسبب الغياب في أقرب وقت ممكن وذلك حرصًا ";
        $bodyP7 = " على مستواه الدراسي.";
           
        $bodyText1 = $Arabic->utf8Glyphs($bodyP1);        
        $bodyText2 = $Arabic->utf8Glyphs($bodyP2);    
        $bodyText3 = $Arabic->utf8Glyphs($bodyP3);  
        $bodyText4 = $Arabic->utf8Glyphs($bodyP4);  
        $bodyText5 = $Arabic->utf8Glyphs($bodyP5);
        $bodyText6 = $Arabic->utf8Glyphs($bodyP6);
        $bodyText7 = $Arabic->utf8Glyphs($bodyP7);

@endphp 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        body { font-family: "dejavusans", "DejaVu Sans", sans-serif; direction: rtl; text-align: right; margin: 0; padding: 10px; color: #0f172a; }
        .header { text-align: center; margin-bottom: 18px; }
        .school-name { font-size: 24px; font-weight: bold; color: #1f2937; }
        .letter-title { margin-top: 4px; font-size: 20px; font-weight: bold; color: #1f2937; }
        .meta { margin: 18px 0; font-size: 14px; text-align: right; }
        .meta p { text-align: right; }
        .content { font-size: 15px;  text-align: right; direction: rtl; }
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
        <p> <strong>{{$parent}}</strong> {{$bodyText2}}</p>
        <p><strong>{{$apsdate}}</strong>{{$bodyText3}}</p>
        <p> {{$bodyText5}} , {{$bodyText4}}</p>
        <p>  {{$bodyText7}} {{$bodyText6}}</p>
    </div>

    <div class="signature">
        <p>{{$closing}}</p>
        <p>{{$signature}}</p>
    </div>
</body>
</html>
