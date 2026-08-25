<?php

use Illuminate\Support\Facades\Log;


if (!function_exists('getRatingText')) {


    function getRatingText($rating)
    {
        if ($rating >= 9) {
            return 'رائع';
        } elseif ($rating >= 7) {
            return 'ممتاز';
        } elseif ($rating >= 5) {
            return 'مقبول';
        } else {
            return 'مقبول';
        }
    }
}

if (!function_exists('trackChaletView')) {
    /**
     * دالة لتسجيل مشاهدة الشاليه.
     *
     * @param  int  $chaletId
     * @return void
     */
    function trackChaletView($chaletId)
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();

        // تحقق من أن الـ IP لم يشاهد نفس الشاليه من قبل
        try {
            $alreadyViewed = \App\Models\View::where('chalet_id', $chaletId)
                ->where('ip_address', $ip)
                ->exists();

            if (!$alreadyViewed) {
                \App\Models\View::create([
                    'chalet_id' => $chaletId,
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to track chalet view', [
                'chalet_id' => $chaletId,
                'ip_address' => $ip,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

if (!function_exists('trackSiteView')) {
    /**
     * دالة لتسجيل زيارة الموقع العامة.
     *
     * @return void
     */
    function trackSiteView()
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();

        // تحقق من أن الـ IP لم يشاهد الموقع من قبل
        $alreadyVisited = \App\Models\View::whereNull('chalet_id')
            ->where('ip_address', $ip)
            ->exists();

        if (!$alreadyVisited) {
            \App\Models\View::create([
                'chalet_id' => null, // لأن الزيارة ليست لشاليه
                'ip_address' => $ip,
                'user_agent' => $userAgent,
            ]);
        }
    }
}

if (!function_exists('trackChaletView')) {
    /**
     * دالة لتسجيل مشاهدة الشاليه.
     *
     * @param  int  $chaletId
     * @return void
     */
    function trackChaletView($chaletId)
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();

        // تحقق من أن الـ IP لم يشاهد نفس الشاليه من قبل
        $alreadyViewed = \App\Models\View::where('chalet_id', $chaletId)
            ->where('ip_address', $ip)
            ->exists();

        if (!$alreadyViewed) {
            \App\Models\View::create([
                'chalet_id' => $chaletId,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
            ]);
        }
    }
}

if (!function_exists('trackSiteView')) {
    /**
     * دالة لتسجيل زيارة الموقع العامة.
     *
     * @return void
     */
    function trackSiteView()
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();

        // تحقق من أن الـ IP لم يشاهد الموقع من قبل
        $alreadyVisited = \App\Models\View::whereNull('chalet_id')
            ->where('ip_address', $ip)
            ->exists();

        if (!$alreadyVisited) {
            \App\Models\View::create([
                'chalet_id' => null, // لأن الزيارة ليست لشاليه
                'ip_address' => $ip,
                'user_agent' => $userAgent,
            ]);
        }
    }
}




if (!function_exists('generateAppleClientSecret')) {
    /**
     * دالة لتوليد client_secret لأبل باستخدام المفتاح الخاص.
     *
     * @return string
     */
    function generateAppleClientSecret()
    {
        // جلب البيانات من البيئة
        $privateKey = env('APPLE_PRIVATE_KEY'); // تأكد من أنك قد خزنت المفتاح بشكل صحيح في ملف .env
        $clientID = env('APPLE_CLIENT_ID');
        $teamID = env('APPLE_TEAM_ID');
        $keyID = env('APPLE_KEY_ID');

        // إعداد وقت الإصدار والانتهاء للرمز
        $issuedAt = time();
        $expirationTime = $issuedAt + 86400 * 180; // 6 شهور

        // إعداد بيانات الحمولة
        $payload = [
            'iss' => $teamID,
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'aud' => 'https://appleid.apple.com',
            'sub' => $clientID,
        ];

        // تحميل حزمة JWT وتوليد client_secret
        try {
            $clientSecret = \Firebase\JWT\JWT::encode($payload, $privateKey, 'ES256', $keyID);
            return $clientSecret;
        } catch (\Exception $e) {
            Log::error('Failed to generate Apple client secret', ['exception' => $e]);
            return null; // إرجاع قيمة فارغة في حال حدوث خطأ
        }
    }
}
