<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginCustomerRequest;
use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginCustomerController extends Controller
{

    public function customer_login(Request $request)
    {
        // Ø§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† Ù…Ø¹Ø§Ù…Ù„ intended ÙÙŠ URL
        if ($request->has('intended')) {
            session(['url.intended' => $request->intended]);
        } 
        // Ø­ÙØ¸ URL Ø§Ù„Ø³Ø§Ø¨Ù‚ Ø¥Ø°Ø§ Ù„Ù… ÙŠÙƒÙ† ØµÙØ­Ø© ØªØ³Ø¬ÙŠÙ„ Ø§Ù„Ø¯Ø®ÙˆÙ„ Ø£Ùˆ Ø§Ù„ØªØ³Ø¬ÙŠÙ„
        elseif ($request->headers->get('referer')) {
            $previousUrl = $request->headers->get('referer');
            $excludedRoutes = ['login', 'register', 'logout', 'password'];
            
            $shouldSave = true;
            foreach ($excludedRoutes as $route) {
                if (str_contains($previousUrl, $route)) {
                    $shouldSave = false;
                    break;
                }
            }
            
            if ($shouldSave) {
                session(['url.intended' => $previousUrl]);
            }
        }
        
        // Get Google login setting
        $setting = Setting::first();
        $googleLoginEnabled = $setting && $setting->google_login_enabled;
        
        return view('auth.customer_login', compact('googleLoginEnabled'));
    }



    public function customer_Store(LoginCustomerRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Ø¥Ø°Ø§ ÙƒØ§Ù† Ù‡Ù†Ø§Ùƒ Ø¨ÙŠØ§Ù†Ø§Øª Ø­Ø¬Ø² Ù…Ø¹Ù„Ù‚Ø©ØŒ Ø§Ù„Ø¹ÙˆØ¯Ø© Ù„ØµÙØ­Ø© ØªØ£ÙƒÙŠØ¯ Ø§Ù„Ø­Ø¬Ø²
        if (session()->has('pending_booking')) {
            return redirect()->route('booking.confirm');
        }
        
        // Ø§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† ÙˆØ¬ÙˆØ¯ URL Ù…Ù‚ØµÙˆØ¯ ØªÙ… Ø­ÙØ¸Ù‡
        $intendedUrl = session()->pull('url.intended', null);
        
        if ($intendedUrl) {
            return redirect($intendedUrl);
        }
        
        // Ø§Ù„Ø¹ÙˆØ¯Ø© Ù„Ù„ØµÙØ­Ø© Ø§Ù„Ø±Ø¦ÙŠØ³ÙŠØ© Ø£Ùˆ Ø§Ù„Ù…Ù„Ù Ø§Ù„Ø´Ø®ØµÙŠ
        return redirect()->route('user-index.index');
    }




    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('customer')->logout();
        $request->session()->regenerateToken();
        return redirect()->route('shaleek.home');
    }
}

