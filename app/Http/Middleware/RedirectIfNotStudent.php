<?php
// app/Http/Middleware/RedirectIfNotStudent.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotStudent
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('LoginStudent');
        }
        return $next($request);
    }
}
