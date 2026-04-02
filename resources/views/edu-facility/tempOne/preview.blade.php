
<!doctype html>
@php
    
        $schoolname =  $data['schoolname'];      
        $student =  $data['name']  ;          
        $content ='يسر ادارة مدرسة ';
        $contentp2=' ان تتقدم بخالص الشكر والتقدير للطالب/ة  ';
        $contentp3 = '  على تفوقه/ها الدراسي وسلوكه/ها المتميز خلال العام الدراسي الحالي. لقد كان/ت مثالاً يحتذى به في الاجتهاد والالتزام، مما ساهم في رفع مستوى المدرسة وتحقيق نتائج مميزة. نتمنى له/ها دوام النجاح والتفوق في مسيرته/ها التعليمية والمستقبلية.';
        $date = 'التاريخ: ' . \Carbon\Carbon::now()->format('Y/m/d');
        $closing = 'مع خالص الشكر والتقدير،';
        $signature = 'إدارة'. $schoolname;                    
        $bodyText3 = "وتفضلوا بقبول فائق الاحترام والتقدير."; 
        
        $Manname = "مدير المدرسة ".$mang;

@endphp
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        body { 
            font-family: "dejavusans", "DejaVu Sans", sans-serif; 
            direction: rtl; 
            text-align: right; 
            margin: 0; 
            padding: 100px; 
            color: #0f172a;
            max-width: 200vw;
            background:   url('{{asset('assets/Templates/1.jpg') }}') center/cover ;
            max-height: 100vh;
        }
        .header { text-align: center;   }
        .content { font-size: 15px; line-height: 1.8; text-align: center; direction: rtl; padding: 3% }
        .school-name { font-size: 24px; font-weight: bold; color: #1f2937; }
        .letter-title { margin-top: 4px; font-size: 20px; font-weight: bold; color: #1f2937; }
        .meta { margin: 18px 0; font-size: 14px; text-align: right; }
        .meta p { margin: 4px 0; text-align: right; }
        .signature { margin-top: 24px; font-size: 15px; text-align: left; }
    </style>
</head>

<body dir="rtl" >
    <div style="padding-top:15%">
    <div style=" position: absolute; margin-right:5%; top:30px; ">
           <img src="/{{$Logo}}" width="100" height="100" >  
    </div> 

    <div  class="content">
        <p>{{$content}} <strong>{{$schoolname}}</strong> {{$contentp2}} <strong>{{$student}}</strong> {{$contentp3}}</p>
        <p>{{$closing}}</p> 
    </div>

    <div class="signature">
        <p>{{$Manname}}</p>
    </div>
    </div>
</body>
</html>