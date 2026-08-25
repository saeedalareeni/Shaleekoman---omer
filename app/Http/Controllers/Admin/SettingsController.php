<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class SettingsController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? new Setting();
        return view('backend.pages.setting.admin_settings', compact('setting'));
    }

    public function updateGeneral(Request $request)
    {
        try {
            $setting = Setting::first() ?? new Setting();
            
            $data = $request->except(['_token', '_method']);
            
            // Handle file uploads
            if ($request->hasFile('logo')) {
                $data['logo'] = $this->uploadFile($request->file('logo'), 'settings');
            }
            
            if ($request->hasFile('logo_white')) {
                $data['logo_white'] = $this->uploadFile($request->file('logo_white'), 'settings');
            }
            
            if ($request->hasFile('favicon')) {
                $data['favicon'] = $this->uploadFile($request->file('favicon'), 'settings');
            }
            
            // تصفية الحقول الموجودة فقط في قاعدة البيانات
            $fillableData = [];
            foreach ($data as $key => $value) {
                if (\Schema::hasColumn('settings', $key)) {
                    $fillableData[$key] = $value;
                }
            }
            
            $setting->fill($fillableData);
            $setting->save();
            Cache::forget('site_settings');
            
            return response()->json([
                'success' => true,
                'message' => 'تم حفظ الإعدادات العامة بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating general settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ الإعدادات. التفاصيل: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePayment(Request $request)
    {
        try {
            $setting = Setting::first() ?? new Setting();
            
            $data = $request->except(['_token', '_method']);
            
            // Convert checkboxes to boolean
            $data['paypal_enabled'] = $request->has('paypal_enabled');
            $data['stripe_enabled'] = $request->has('stripe_enabled');
            $data['thawani_enabled'] = $request->has('thawani_enabled');
            $data['cash_enabled'] = $request->has('cash_enabled');
            
            // تصفية الحقول الموجودة فقط في قاعدة البيانات
            $fillableData = [];
            foreach ($data as $key => $value) {
                if (\Schema::hasColumn('settings', $key)) {
                    $fillableData[$key] = $value;
                }
            }
            
            $setting->fill($fillableData);
            $setting->save();
            Cache::forget('site_settings');
            
            // Update .env file for payment settings
            $this->updateEnvFile([
                'PAYPAL_CLIENT_ID' => $request->paypal_client_id,
                'PAYPAL_SECRET' => $request->paypal_secret,
                'PAYPAL_MODE' => $request->paypal_mode,
                'STRIPE_KEY' => $request->stripe_publishable_key,
                'STRIPE_SECRET' => $request->stripe_secret_key,
                'THAWANI_SECRET_KEY' => $request->thawani_secret_key,
                'THAWANI_PUBLISHABLE_KEY' => $request->thawani_publishable_key,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم حفظ إعدادات الدفع بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating payment settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ إعدادات الدفع. التفاصيل: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateOAuth(Request $request)
    {
        try {
            $setting = Setting::first() ?? new Setting();
            
            $data = $request->except(['_token', '_method']);
            
            // Convert checkboxes to boolean
            $data['google_login_enabled'] = $request->has('google_login_enabled');
            $data['google_auto_register'] = $request->has('google_auto_register');
            $data['google_sync_profile'] = $request->has('google_sync_profile');
            
            // تصفية الحقول الموجودة فقط في قاعدة البيانات
            $fillableData = [];
            foreach ($data as $key => $value) {
                if (\Schema::hasColumn('settings', $key)) {
                    $fillableData[$key] = $value;
                }
            }
            
            $setting->fill($fillableData);
            $setting->save();
            Cache::forget('site_settings');
            
            // Update .env file for Google OAuth settings
            if ($request->has('google_client_id') || $request->has('google_client_secret')) {
                $this->updateEnvFile([
                    'GOOGLE_CLIENT_ID' => $request->google_client_id,
                    'GOOGLE_CLIENT_SECRET' => $request->google_client_secret,
                    'GOOGLE_REDIRECT' => $request->google_redirect_url,
                ]);
                
                // Clear config cache after updating .env
                Artisan::call('config:clear');
            }
            
            return response()->json([
                'success' => true,
                'message' => 'تم حفظ إعدادات Google OAuth بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating OAuth settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ إعدادات OAuth. التفاصيل: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateEmail(Request $request)
    {
        try {
            $setting = Setting::first() ?? new Setting();
            
            $data = $request->except(['_token', '_method']);
            
            // Convert checkboxes to boolean
            $data['email_notifications_enabled'] = $request->has('email_notifications_enabled');
            $data['sms_notifications_enabled'] = $request->has('sms_notifications_enabled');
            $data['notify_new_booking'] = $request->has('notify_new_booking');
            $data['notify_booking_confirmed'] = $request->has('notify_booking_confirmed');
            $data['notify_booking_cancelled'] = $request->has('notify_booking_cancelled');
            $data['notify_payment_confirmed'] = $request->has('notify_payment_confirmed');
            $data['notify_new_review'] = $request->has('notify_new_review');
            $data['notify_new_owner'] = $request->has('notify_new_owner');
            
            // تصفية الحقول الموجودة فقط في قاعدة البيانات
            $fillableData = [];
            foreach ($data as $key => $value) {
                if (\Schema::hasColumn('settings', $key)) {
                    $fillableData[$key] = $value;
                }
            }
            
            $setting->fill($fillableData);
            $setting->save();
            Cache::forget('site_settings');
            
            // Update .env file for email settings
            $this->updateEnvFile([
                'MAIL_MAILER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
                'MAIL_FROM_NAME' => $request->mail_from_name,
            ]);
            
            // Clear config cache
            Artisan::call('config:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'تم حفظ إعدادات البريد الإلكتروني بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating email settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ إعدادات البريد الإلكتروني. التفاصيل: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateCommission(Request $request)
    {
        try {
            $setting = Setting::first() ?? new Setting();
            
            $data = $request->except(['_token', '_method']);
            
            // تصفية الحقول الموجودة فقط في قاعدة البيانات
            $fillableData = [];
            foreach ($data as $key => $value) {
                if (\Schema::hasColumn('settings', $key)) {
                    $fillableData[$key] = $value;
                }
            }
            
            $setting->fill($fillableData);
            $setting->save();
            Cache::forget('site_settings');
            
            return response()->json([
                'success' => true,
                'message' => 'تم حفظ إعدادات العمولات والضرائب بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating commission settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ إعدادات العمولات. التفاصيل: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSocial(Request $request)
    {
        $setting = Setting::first() ?? new Setting();
        
        $data = $request->except(['_token', '_method']);
        
        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->uploadFile($request->file('og_image'), 'settings');
        }
        
        $setting->fill($data);
        $setting->save();
        Cache::forget('site_settings');
        
        return response()->json([
            'success' => true,
            'message' => 'تم حفظ إعدادات التواصل الاجتماعي بنجاح'
        ]);
    }

    public function testEmail(Request $request)
    {
        try {
            Mail::raw('This is a test email from your application.', function ($message) {
                $message->to(auth()->user()->email)
                        ->subject('Test Email - ' . config('app.name'));
            });
            
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال بريد تجريبي بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل إرسال البريد: ' . $e->getMessage()
            ], 500);
        }
    }

    private function uploadFile($file, $folder)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/' . $folder), $fileName);
        return '/uploads/' . $folder . '/' . $fileName;
    }

    private function updateEnvFile($data)
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);
        
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $pattern = "/^{$key}=.*/m";
                $replacement = "{$key}={$value}";
                
                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, $replacement, $envContent);
                } else {
                    $envContent .= "\n{$replacement}";
                }
            }
        }
        
        File::put($envPath, $envContent);
    }
}
