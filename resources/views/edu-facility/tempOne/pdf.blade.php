<!doctype html>
@php
        
        use ArPHP\I18N\Arabic;
        $Arabic = new Arabic();
        $schoolname =  $Arabic->utf8Glyphs($data['schoolname']);      
        $student =  $Arabic->utf8Glyphs($data['name']); 
        
        
        $content =$Arabic->utf8Glyphs('يسر ادارة مدرسة ');
        $contentp2=$Arabic->utf8Glyphs(' ان تتقدم بخالص الشكر والتقدير للطالب/ة  ');
        $contentp3 = $Arabic->utf8Glyphs('  على تفوقه/ها الدراسي وسلوكه/ها المتميز خلال العام الدراسي الحالي. لقد كان/ت مثالاً يحتذى به في الاجتهاد والالتزام، مما ساهم في رفع مستوى المدرسة وتحقيق نتائج مميزة. نتمنى له/ها دوام النجاح والتفوق في مسيرته/ها التعليمية والمستقبلية.');
        $date = $Arabic->utf8Glyphs('التاريخ: ' . \Carbon\Carbon::now()->format('Y/m/d'));
        $closing = $Arabic->utf8Glyphs('مع خالص الشكر والتقدير،');
        $signature = $Arabic->utf8Glyphs('إدارة'. $schoolname);                    
        $bodyText3 = $Arabic->utf8Glyphs("وتفضلوا بقبول فائق الاحترام والتقدير."); 
        
        $Manname =  $Arabic->utf8Glyphs( "مدير المدرسة ".$mang );
        $FRAME = 'assets/Templates/1.jpg';
@endphp
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
            padding: 0;
        }
        * { margin: 0; padding: 0; }
        html, body { 
            width: 100%; 
            height: 100%; 
            margin: 0; 
            padding: 0;
            overflow: hidden;
        }
        body { 
            font-family: "dejavusans", "DejaVu Sans", sans-serif; 
            direction: rtl; 
            text-align: right; 
            color: #0f172a;
            background-image: url('{{ public_path($FRAME) }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }
        .page-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            margin: 0;
            padding: 0;
        }
        .header { 
            text-align: center;
            position: absolute;
            top: 30px;
            right: 40px;
        }
        .content { 
            font-size: 15px; 
            line-height: 1.8; 
            text-align: center; 
            direction: rtl; 
            padding: 20px;
            max-width: 600px;
            text-align: center;
            margin: 0 auto;
        }
        .school-name { font-size: 24px; font-weight: bold; color: #1f2937; }
        .letter-title { margin-top: 4px; font-size: 20px; font-weight: bold; color: #1f2937; }
        .meta { margin: 18px 0; font-size: 14px; text-align: right; }
        .meta p { margin: 4px 0; text-align: right; }
        .signature { 
            margin-top: 24px; 
            font-size: 15px; 
            text-align: center;
            position: absolute;
            bottom: 40px;
            width: 100%;
        }
    </style>
</head>

<body dir="rtl">
    <div class="page-wrapper">
        <div class="header">
            <img src="{{ public_path($Logo) }}" width="100" height="100" alt="Logo">
        </div>

        <div class="content">
            <p>{{$content}} <strong>{{$schoolname}}</strong> {{$contentp2}} <strong>{{$student}}</strong> {{$contentp3}}</p>
            <p style="margin-top: 30px;">{{$closing}}</p>
        </div>

        <div class="signature">
            <p>{{$Manname}}</p>
        </div>
    </div>
</body>
</html>