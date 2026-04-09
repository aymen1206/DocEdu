<!doctype html>
@php
        $schoolname =  $data['schoolname'];
        $apsdate =  $data['apsdate'];
        $Schoolname =  $schoolname;
        $title = 'إشعار غياب';
        $subtitle = 'إلى ولي امر الطالب/ة : ' . $data['name'];
        $date = 'التاريخ: ' . \Carbon\Carbon::now()->format('Y/m/d');
        $closing = 'مع خالص الشكر والتقدير،';
        $signature = 'إدارة '. $schoolname;        
        $parenta =  $data['name']  ;        
        $parent =$parenta;
        $bodyP1 = "السلام عليكم ورحمة الله وبركاته،";    
        $bodyP2 = " نود إشعاركم بأن الطالب  / ";                        
        $bodyP3 = "قد تغيب عن المدرسة في يوم/ ";                   
        $bodyP4 = " وذلك دون تقديم عذر رسمي ";                   
        $bodyP5 = "نأمل منكم التكرم بمتابعة الأمر والتأكد لإفادتنا ";
        $bodyP6 = " بسبب الغياب في أقرب وقت ممكن وذلك حرصًا ";
        $bodyP7 = " على مستواه الدراسي.";           
        $Manname = "مدير المدرسة ".$mang;           
        $bodyText1 = $bodyP1;        
        $bodyText2 = $bodyP2;    
        $bodyText3 = $bodyP3;  
        $bodyText4 = $bodyP4;  
        $bodyText5 = $bodyP5;
        $bodyText6 = $bodyP6;
        $bodyText7 = $bodyP7;
        $Managname = $Manname;

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
           <img src="/{{$Logo}}" width="80" height="80" >  
        </p>
        <div class="school-name">{{$Schoolname}}</div>
        <div class="letter-title">{{$title}}</div>
    </div>

    <div  >
         
        <p>{{$subtitle}}</p>
        <p>{{$date}}</p>
        <p>{{$bodyText1}}</p>
        <p>{{$bodyText2}}<strong>{{$parent}}</strong></p>
        <p>{{$bodyText3}}<strong>{{$apsdate}}</strong></p>
        <p> {{$bodyText4}} , {{$bodyText5}}</p>
        <p>  {{$bodyText6}} {{$bodyText7}}</p>
    </div>

    <div class="signature">
        <p>{{$closing}}</p>
        <p>{{$signature}}</p>
        <p>{{$Managname}}</p>
    </div>
</body>
</html>
