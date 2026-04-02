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

        $parentName = $data['name']  ;
        $content = trim($data['content'] ?? '');
        $schoolname = $data['schoolname']; // يمكنك جلب اسم المدرسة من قاعدة البيانات أو من بيانات المستخدم
        if ($content === '') {
            $content = ",السلام عليكم ورحمة الله وبركاته\n\n   نود إبلاغكم بأنه بناءً على المتابعة التعليمية لسلوك وأداء الطالب/ة {$parentName} ، فإن المدرسة بحاجة إلى حضور ولي أمره  في أقرب وقت ممكن لمناقشة الأمر مع إدارة المدرسة \n.وتفضلوا بقبول فائق الاحترام والتقدير\n ,مع خالص الشكر والتقدير\n إدارة {$schoolname}";
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addImage(public_path('assets/images/schoollogo.png'), // مسار الصورة
        [
            'width' => 50,     // العرض بالبكسل
            'height' => 50,    // الارتفاع بالبكسل
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, // محاذاة الصورة
            'wrappingStyle' => 'inline', // يجعلها ضمن النص
        ]
        );
        // إضافة عنوان (إن وجد)
        $section->addText('مدرستي', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addText('استدعاء ولي أمر', ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $section->addText('إلى ولي الطالب/ة: ' . $parentName, [], ['alignment' => 'right']);
        $section->addText('التاريخ: ' . now()->format('Y/m/d'), [], ['alignment' => 'right']);
        $section->addTextBreak(1);

        // نريد تفسير المحتوى بحيث نسمح بعلامة لصيغة البولد.
        // أبسط طريقة: المستخدم يضع **نص** ليكون بولد (Markdown-like).
        // تحويل أجزاء **bold** إلى أجزاء بولد في Word
        // تقسيم على أجزاء مع الاحتفاظ بالـ bold markers
        $parts = preg_split('/(\*\*.*?\*\*)/s', $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        foreach ($parts as $part) {
            if (preg_match('/^\*\*(.*)\*\*$/s', $part, $m)) {
                $section->addText($m[1], ['bold' => true], ['alignment' => 'right']);
            } else {
                // قد يحتوي على فواصل أسطر نريد تحويلها إلى فقرات
                $lines = preg_split("/\r\n|\n|\r/", $part);
                foreach ($lines as $i => $line) {
                    if ($line !== '') {
                        $section->addText($line, [] , ['alignment' => 'right']);
                    } else {
                        $section->addTextBreak(1);
                    }
                }
            }
        }

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
