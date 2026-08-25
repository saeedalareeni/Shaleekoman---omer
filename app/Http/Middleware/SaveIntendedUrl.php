<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SaveIntendedUrl
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
        // حفظ URL الحالي إذا لم يكن المستخدم مسجل دخول
        if (!auth('customer')->check() && 
            !$request->is('login', 'register', 'logout', 'password/*') &&
            $request->method() === 'GET') {
            session(['url.intended' => $request->fullUrl()]);
        }

        return $next($request);
    }
}
