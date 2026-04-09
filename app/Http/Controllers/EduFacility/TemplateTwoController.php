<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF; // facade from barryvdh/laravel-dompdf
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class TemplateTwoController extends Controller
{
    public function form()
    {
        return view('edu-facility.tempTwo.form'); // اختياري: نموذج يدخل المستخدم فيه النص
    }

    public function generate(Request $request)
    {
        // مثلاً نأخذ عنوان وخطاب ونريد بعض الكلام بولد
        $data = $request->validate([
            'name' => 'nullable|string',
        ]);

        // ممكن إعادة توجيه لعرض المعاينة
        return view('edu-facility.tempTwo.preview', compact('data'));
    }

    public function downloadPdf(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'schoolname' => 'nullable|string',
        ]);
       
        // نستخدم Blade لعمل HTML ثم نحوله إلى PDF
        
       
        $Logo = auth()->guard('edu_facility')->user()->logo;
        $mang = auth()->guard('edu_facility')->user()->Manger_Name;
        $html = view('edu-facility.tempTwo.pdf', compact('data','Logo','mang'))->render();

        $pdf = PDF::loadHTML($html);
        // ضبط اسم الملف
        return $pdf->download(($data['name'] ?? 'letter') . '.pdf');
    }

   public function downloadWord(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'schoolname' => 'nullable|string',
        ]);
        
        $Logo = auth()->guard('edu_facility')->user()->logo;
        $mang = auth()->guard('edu_facility')->user()->Manger_Name;
        $parentName = $data['name']  ;
        $schoolname = $data['schoolname']; // يمكنك جلب اسم المدرسة من قاعدة البيانات أو من بيانات المستخدم
      

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
        'marginTop' => 0,
        'marginLeft' => 0,
        'marginRight' => 0,
        'marginBottom' => 0]);
        
        $FRAME = 'assets/Templates/2.jpg'; 
        $section->addImage(public_path($FRAME), [
            'width' => 595,     // العرض بالبكسل (A4 width)
            'height' => 842,            
            'wrappingStyle' => 'behind',
            'positioning' => 'absolute',    
            'posHorizontal' => 'left',
            'posVertical' => 'top',
        ]);
         $section->addImage(public_path($Logo), 
            [
                'width' => 80,
                'height' => 80,
                'positioning' => 'absolute',
                'posHorizontal' => 'absolute',
                'posVertical' => 'absolute',
                'marginLeft' => 460,
                'marginTop' => 200,
                'wrappingStyle' => 'square'
            ]
        );

        
        // إضافة عنوان (إن وجد)
        $section->addTextBreak(15);      
        $section->addText(' يسر ادارة مدرسة ' . $schoolname . ' ان تتقدم بخالص الشكر والتقدير للطالب/ة ' . $parentName . ' على تفوقه/ها الدراسي وسلوكه/ها المتميز لقد كان مثالاً يحتذى به في  الاجتهاد والالتزام مما ساهم في رفع مستوى المدرسة وتحقيق نتائج مميزة  خلال العام الدراسي الحالي  نتمنى له/ها دوام النجاح والتفوق  في مسيرته/ها التعليمية والمستقبلية', ['size' => 14], ['alignment' => 'center']);       
     
        $section->addTextBreak(1); 
        
        $section->addText(',مع خالص الشكر والتقدير', ['size' => 14], ['alignment' => 'center']); 
       
        $section->addTextBreak(2);    
        $section->addText('مدير المدرسة ' , ['size' => 14], ['alignment' => 'left','indent' => -1000 ]);
        $section->addText($mang , ['size' => 14], ['alignment' => 'left','indent' => -1000 ]);
        // نريد تفسير المحتوى بحيث نسمح بعلامة لصيغة البولد.
        // أبسط طريقة: المستخدم يضع **نص** ليكون بولد (Markdown-like).
        // تحويل أجزاء **bold** إلى أجزاء بولد في Word
        // تقسيم على أجزاء مع الاحتفاظ بالـ bold markers


        $writer = IOFactory::createWriter($phpWord, 'Word2007');

        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $writer->save($tempFile);

        $fileName = !empty($data['name']) ? \Illuminate\Support\Str::slug($data['name'], '-') : 'estid3a-wali-amr';
        return response()->download($tempFile, $fileName . '.docx')->deleteFileAfterSend(true);
    }
    
       public function preview(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'schoolname' => 'nullable|string',
        ]);
        
       
        $Logo = auth()->guard('edu_facility')->user()->logo;
        $mang = auth()->guard('edu_facility')->user()->Manger_Name;

        return view('edu-facility.tempTwo.preview', compact('data','Logo','mang'));
    }
}
