
<!doctype html>
@php
    
        $schoolname =  $data['schoolname'];
        $title ='استدعاء ولي الأمر';
        $subtitle = 'إلى ولي امر الطالب/ة : ' . $data['name'];
        $date = 'التاريخ: ' . \Carbon\Carbon::now()->format('Y/m/d');
        $closing = 'مع خالص الشكر والتقدير،';
        $signature = 'إدارة'. $schoolname;        
        $parent =  $data['name']  ;        
        $bodyText1 = "السلام عليكم ورحمة الله وبركاته،";    

        $bodyText2a = "نود إبلاغكم بأنه بناءً على المتابعة التعليمية  ";          
        $bodyText2b = " لسلوك وأداء الطالب ";
        $bodyText2e=" فإن المدرسة بحاجة إلى ";          
        $bodyText2c = "حضور ولي أمره  في أقرب وقت ممكن";          
        $bodyText2d = " لمناقشة الأمر مع إدارة المدرسة ";                    
        $bodyText3 = "وتفضلوا بقبول فائق الاحترام والتقدير."; 
        
        $Manname = "مدير المدرسة ".$mang;

@endphp
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        body { font-family: "dejavusans", "DejaVu Sans", sans-serif; direction: rtl; text-align: right; margin: 0; padding: 44px; color: #0f172a; }
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
           <img src="/{{$Logo}}" width="100" height="100" >  
        </p>
        <div class="school-name">{{$schoolname}}</div>
        <div class="letter-title">{{$title}}</div>
    </div>

    <div  >
         
        <p>{{$subtitle}}  </p>
        <p>{{$date}}</p>
        <p>{{$bodyText1}}</p>
        <p style="text-align:right"> {{$bodyText2a}} {{$bodyText2b}}<strong>{{$parent}}</strong></p>       
        <label>{{$bodyText2e}} {{$bodyText2c}} {{$bodyText2d}}  </label>
        <p>{{$bodyText3}}</p>
    </div>

    <div class="signature">
        <p>{{$closing}}</p>
        <p>{{$signature}}</p>
        <p>{{$Manname}}</p>
    </div>
</body>
</html>