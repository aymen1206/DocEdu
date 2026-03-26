<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // تأكد أن الـ locale موجود في session
        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');

            // تحقق من أن الـ locale مدعوم
            $supportedLocales = ['en', 'ar']; // ضع هنا كل اللغات المدعومة
            if (in_array($locale, $supportedLocales)) {
                App::setLocale($locale);
            }
        }

        return $next($request);
    }
}
