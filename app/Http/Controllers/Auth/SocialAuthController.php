<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Owner;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Facades\Socialite;
class SocialAuthController extends Controller
{
    // جوجل
    public function redirectToGooglewithType($type = null)
    {
        // Check if Google login is enabled
        $setting = Setting::first();
        if (!$setting || !$setting->google_login_enabled) {
            return redirect()->back()->with('error', 
                app()->getLocale() == 'ar' 
                    ? 'تسجيل الدخول بـ Google غير متاح حالياً' 
                    : 'Google login is not available at the moment'
            );
        }
        
        session(['social_login_type' => $type]);
        return Socialite::driver('google')->redirect();
    }



    public function redirectToGoogle($type = null)
    {
        // Check if Google login is enabled
        $setting = Setting::first();
        if (!$setting || !$setting->google_login_enabled) {
            return redirect()->back()->with('error', 
                app()->getLocale() == 'ar' 
                    ? 'تسجيل الدخول بـ Google غير متاح حالياً' 
                    : 'Google login is not available at the moment'
            );
        }
        
        session(['social_login_type' => $type]); // نحفظ النوع في الجلسة
        return Socialite::driver('google')->redirect();
    }



    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $type = session('social_login_type', 'customer'); // default to customer
            return $this->loginOrCreateUser($googleUser, 'google', $type);
        } catch (InvalidStateException $e) {
            Log::error('Google login failed: Invalid state', ['exception' => $e]);
            return redirect()->route('login')->with('error', 'فشل تسجيل الدخول باستخدام Google. الرجاء المحاولة مرة أخرى.');
        } catch (\Exception $e) {
            Log::error('Google login failed: General exception', ['exception' => $e]);
            return redirect()->route('login')->with('error', 'حدث خطأ غير متوقع أثناء تسجيل الدخول. الرجاء المحاولة لاحقًا.');
        }
    }



    // تسجيل الدخول مع أبل
    public function redirectToAppleewithType($type = null)
    {
        session(['social_login_type' => $type]);
        return Socialite::driver('apple')->redirect();
    }

    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function handleAppleCallback()
    {
        try {
            // الحصول على بيانات المستخدم من أبل
            $appleUser = Socialite::driver('apple')->stateless()->user();

            $type = session('social_login_type', 'customer'); // تحديد نوع المستخدم (افتراضيًا: 'customer')

            // استخدام دالة loginOrCreateUser لإنشاء أو تسجيل الدخول للمستخدم
            return $this->loginOrCreateUser($appleUser, 'apple', $type);
        } catch (\Exception $e) {
            Log::error('Apple login failed', ['exception' => $e]);
            return redirect()->route('login')->with('error', 'فشل تسجيل الدخول باستخدام Apple. الرجاء المحاولة مرة أخرى.');
        }
    }




    protected function loginOrCreateUser($socialUser, $provider, $type = 'customer')
    {
        $setting = Setting::first();
        $day = date('Ymd');

        $model = $type === 'owner' ? Owner::class : Customer::class;
        $guard = $type === 'owner' ? 'owner' : 'customer';

        $account_number = $model::count() == 0
            ? 1
            : $model::latest()->first()->id + 1;

        // Check if user exists
        $existingUser = $model::where('email', $socialUser->getEmail())->first();
        
        if (!$existingUser && $setting && !$setting->google_auto_register) {
            // Auto registration is disabled
            return redirect()->route($type === 'owner' ? 'owner.login' : 'customer_register')
                ->with('info', 
                    app()->getLocale() == 'ar' 
                        ? 'الرجاء إنشاء حساب أولاً قبل تسجيل الدخول بـ Google' 
                        : 'Please create an account first before signing in with Google'
                );
        }

        $user = $model::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name'              => $socialUser->getName() ?? $socialUser->getNickname() ?? ucfirst($type) . ' User',
                'password'          => bcrypt(Str::random(16)),
                'username'          => $socialUser->getEmail(),
                'account_number'    => $account_number + $day,
                'email_verified_at' => now(),
                'provider'          => $provider,
                'provider_id'       => $socialUser->getId(),
                'phone'             => '0000000000',
            ]
        );
        
        // Sync profile if enabled
        if ($setting && $setting->google_sync_profile && $existingUser) {
            $existingUser->name = $socialUser->getName() ?? $existingUser->name;
            $existingUser->save();
            $user = $existingUser;
        }

        // تسجيل الدخول باستخدام الحارس المناسب
        Auth::guard($guard)->login($user);

        return $type === 'owner'
            ? redirect()->route('owner.dashboard') // غيرها حسب المسار الفعلي
            : redirect()->route('user-index.index');
    }
}
