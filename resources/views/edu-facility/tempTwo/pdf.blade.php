@php
        use ArPHP\I18N\Arabic;
        $Arabic = new Arabic();
        $schoolname =  $Arabic->utf8Glyphs($data['schoolname']);      
        $student =  $Arabic->utf8Glyphs($data['name']); 
        
        
        $content =$Arabic->utf8Glyphs('يسر ادارة مدرسة ');
        $contentp2=$Arabic->utf8Glyphs(' ان تتقدم بخالص الشكر والتقدير للطالب/ة  ');

        $contentp3 = $Arabic->utf8Glyphs('  على تفوقه/ها ');
        $contentp4 = $Arabic->utf8Glyphs('الدراسي وسلوكه/ها المتميز لقد كان مثالاً يحتذى به ');
        $contentp5 = $Arabic->utf8Glyphs(' الاجتهاد والالتزام مما ساهم في رفع مستوى المدرسة في');
        $contentp6 = $Arabic->utf8Glyphs('وتحقيق نتائج مميزة  خلال العام الدراسي الحالي');
        $contentp7 = $Arabic->utf8Glyphs(' نتمنى له/ها دوام النجاح والتفوق ');
        $contentp8 = $Arabic->utf8Glyphs('في مسيرته/ها التعليمية والمستقبلية');
        
        $date = $Arabic->utf8Glyphs('التاريخ: ' . \Carbon\Carbon::now()->format('Y/m/d'));
        $closing = $Arabic->utf8Glyphs('مع خالص الشكر والتقدير،');
        $signature = $Arabic->utf8Glyphs('إدارة'. $schoolname);                    
        $bodyText3 = $Arabic->utf8Glyphs("وتفضلوا بقبول فائق الاحترام والتقدير.");         
        $Mannam =  $Arabic->utf8Glyphs( "مدير المدرسة " );
        $Manname =  $Arabic->utf8Glyphs($mang );
        $FRAME = 'assets/Templates/2.jpg';
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

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: "dejavusans", "DejaVu Sans", sans-serif; 
            direction: rtl; 
            text-align: center; 
            color: #0f172a;
        }

        .page-bg {
            width: 100%;
            height: 100%;
            background-image: url('{{ public_path($FRAME) }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: contain; /* مهم: عشان ما ينقص شي من الصورة */
        }
        .page-wrapper {
            direction: rtl;
            position: absolute;
            width: 100%;
            height: 100%; 
            margin: 0;
            padding: 0;
        }
        .header { 
            text-align: center;
            position: absolute;
            top: 30%;
            right: 15%;
        }
        .content { 
            font-size: 11px; 
            line-height: 1.8; 
            padding: 0 15%;
            direction: rtl;
            unicode-bidi: plaintext; 
            text-align: center;
            margin: 0 auto;            
            position: absolute;
            top: 45%;
        }
        
        .school-name { font-size: 24px; font-weight: bold; color: #1f2937; }
        .letter-title { margin-top: 4px; font-size: 20px; font-weight: bold; color: #1f2937; }
     
        .signature {  
            font-size: 15px;  
            position: absolute;
            width: 100%;
            text-align: left;
            left: 10%;
            bottom: 30%;
        }
    </style>
</head>

<body dir="rtl">
 <div class="page-bg">
    <!-- محتوى الصفحة -->
       <div class="page-wrapper">
        <div class="header">
            <img src="{{ public_path($Logo) }}" width="100" height="100" alt="Logo">
        </div>

        <div class="content"> 
               <p > <strong>{{$student}}</strong> {{$contentp2}}<strong>{{$schoolname}}</strong>{{$content}} </p>
                
     
                   
                <p> {{$contentp5}} {{$contentp4}} {{$contentp3}}</p>   
                <p>{{$contentp7}} {{$contentp6}}</p>   
          
                <p> {{$contentp8}}</p>        
           
               <p style="margin-top: 30px;">{{$closing}}</p>
        </div>

        <div class="signature">
            <p>{{$Mannam}}</p>
            <p>{{$Manname}}</p>
        </div>
    </div>
</div>
</body>
</html>