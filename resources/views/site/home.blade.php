@extends('site.master.master')    
@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-[#7D3CFF] via-[#6B2FE8] to-[#5A1FD8] dark:from-[#6B2FE8] dark:via-[#5A1FD8] dark:to-[#4A0FC8] overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
  </div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <!-- Content -->
      <div class="text-center lg:text-right space-y-8">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20">
          <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
          <span class="text-white text-sm font-medium">منصة إصدار الخطابات التعليمية</span>
        </div>
        
        <h1 class="text-4xl lg:text-6xl font-bold text-white leading-tight">
          مرحباً بك في
          <span class="block text-white bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-300">DocEdu</span>
        </h1>
        
        <h4 class="text-xl text-white leading-relaxed max-w-2xl mx-auto lg:mx-0">
          مساحة خاصة بالمنشآت التعليمية لإصدار الخطابات الرسمية بصيغتين مختلفتين Word و PDF بسهولة واحترافية
        </h4>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
          <a href="#features" class="group inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-[#7D3CFF] rounded-xl font-semibold text-lg hover:bg-gray-50 transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
            <span>ابدأ الآن</span>
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l-5 5 5 5M6 12h12" />
            </svg>
          </a>
          
          <a href="#how-it-works" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold text-lg border-2 border-white/30 hover:bg-white/20 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>شاهد كيف يعمل</span>
          </a>
        </div>
      </div>
      
      <!-- Illustration -->
      <div class="relative">
        <div class="relative z-10 bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 shadow-2xl">
          <div class="space-y-4">
            <!-- Document Preview -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-[#7D3CFF] rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                </div>
                <div>
                  <h3 class="font-bold text-gray-900">خطاب رسمي</h3>
                  <p class="text-sm text-gray-500">جاهز للتحميل</p>
                </div>
              </div>
              <div class="space-y-2">
                <div class="h-2 bg-gray-200 rounded-full w-full"></div>
                <div class="h-2 bg-gray-200 rounded-full w-5/6"></div>
                <div class="h-2 bg-gray-200 rounded-full w-4/6"></div>
              </div>
              <div class="flex gap-2 mt-4">
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-medium">Word</span>
                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium">PDF</span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute -top-6 -right-6 w-24 h-24 bg-yellow-300 rounded-2xl opacity-20 blur-xl animate-pulse"></div>
        <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-orange-300 rounded-2xl opacity-20 blur-xl animate-pulse delay-700"></div>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-gray-50 dark:bg-gray-900">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
        لماذا تختار DocEdu؟
      </h2>
      <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
        نوفر لك أدوات احترافية لإصدار الخطابات بسرعة وكفاءة عالية
      </p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Feature 1 -->
      <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
        <div class="w-16 h-16 bg-gradient-to-br from-[#7D3CFF] to-[#6B2FE8] rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">إصدار سريع</h3>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
          أصدر خطاباتك الرسمية في ثوانٍ معدودة بتنسيق احترافي
        </p>
      </div>
      
      <!-- Feature 2 -->
      <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">صيغتان مختلفتان</h3>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
          احصل على خطاباتك بصيغة Word و PDF في نفس الوقت
        </p>
      </div>
      
      <!-- Feature 3 -->
      <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">آمن وموثوق</h3>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
          حماية كاملة لبياناتك مع نظام تشفير متقدم
        </p>
      </div>
      
      <!-- Feature 4 -->
      <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">قوالب جاهزة</h3>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
          مكتبة شاملة من القوالب الاحترافية الجاهزة للاستخدام
        </p>
      </div>
      
      <!-- Feature 5 -->
      <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
        <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">تخصيص كامل</h3>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
          خصص الخطابات حسب احتياجات منشأتك التعليمية
        </p>
      </div>
      
      <!-- Feature 6 -->
      <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">سرعة فائقة</h3>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
          معالجة فورية وتحميل سريع لجميع المستندات
        </p>
      </div>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-20 bg-white dark:bg-gray-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
        كيف يعمل DocEdu؟
      </h2>
      <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
        ثلاث خطوات بسيطة للحصول على خطاباتك الرسمية
      </p>
    </div>
    
    <div class="grid md:grid-cols-3 gap-8 relative">
      <!-- Step 1 -->
      <div class="relative text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#7D3CFF] to-[#6B2FE8] rounded-full text-white text-3xl font-bold mb-6 shadow-xl">
          1
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">اختر القالب</h3>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
          اختر من بين مجموعة واسعة من القوالب الاحترافية المصممة خصيصاً للمنشآت التعليمية
        </p>
      </div>
      
      <!-- Step 2 -->
      <div class="relative text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full text-white text-3xl font-bold mb-6 shadow-xl">
          2
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">أدخل البيانات</h3>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
          املأ الحقول المطلوبة بسهولة من خلال واجهة بسيطة وسهلة الاستخدام
        </p>
      </div>
      
      <!-- Step 3 -->
      <div class="relative text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full text-white text-3xl font-bold mb-6 shadow-xl">
          3
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">حمّل الخطاب</h3>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
          احصل على خطابك بصيغة Word و PDF جاهز للطباعة أو الإرسال الإلكتروني
        </p>
      </div>
    </div>
  </div>
</section>

@endsection
