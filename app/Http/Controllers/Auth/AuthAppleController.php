<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
class AuthAppleController extends Controller
{

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
        $day = date('Ymd');

        $model = $type === 'owner' ? Owner::class : Customer::class;
        $guard = $type === 'owner' ? 'owner' : 'customer';

        $account_number = $model::count() == 0
            ? 1
            : $model::latest()->first()->id + 1;

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

        // تسجيل الدخول باستخدام الحارس المناسب
        Auth::guard($guard)->login($user);

        return $type === 'owner'
            ? redirect()->route('owner.dashboard') // غيرها حسب المسار الفعلي
            : redirect()->route('user-index.index');
    }
}
