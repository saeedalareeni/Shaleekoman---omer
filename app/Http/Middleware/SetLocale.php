<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
        // Get locale from LaravelLocalization if available
        if (class_exists('\Mcamara\LaravelLocalization\Facades\LaravelLocalization')) {
            $locale = LaravelLocalization::getCurrentLocale();
        } else {
            // Fallback to session or cookie
            $locale = $request->session()->get('locale', $request->cookie('locale', 'ar'));
        }
        
        // Validate locale
        if (!in_array($locale, ['ar', 'en'])) {
            $locale = 'ar';
        }
        
        // Save to session
        $request->session()->put('locale', $locale);
        
        // Set locale everywhere
        App::setLocale($locale);
        
        // Set the locale in config for consistency
        config(['app.locale' => $locale]);
        
        return $next($request);
    }
}
