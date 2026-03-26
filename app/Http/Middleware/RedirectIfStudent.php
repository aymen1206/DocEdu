<?php
// app/Http/Middleware/RedirectIfStudent.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfStudent
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.home');
        }
        return $next($request);
    }
}
