<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Notify;
use App\Models\Owner;
use App\Models\Setting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredOwnerController  extends Controller
{


    public function create(): View
    {
        $settings = Setting::first();
        $googleLoginEnabled = $settings ? $settings->google_login_enabled : false;

        return view('auth.register-owner', compact('settings', 'googleLoginEnabled'));
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                     => 'required|string',
            'email'                    => 'required|email|unique:owners,email',
          //  'phone'                    => 'required|unique:owners,phone',
            'password'                 => ['required', 'confirmed', Rules\Password::defaults()],
            'address'                  => 'required|string',
        ]);

        $request->validate([
            'phone' => ['required','regex:/^\+968\d{8}$/']
        ],[
            'phone.regex' => 'يجب أن يكون رقم الجوال بالشكل +968XXXXXXXX'
        ]);

        $input['user_id'] = $request->name;
        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['address'] = $request->address;
        $input = $request->except(['password_confirmation']); // استبعاد حقل تأكيد كلمة المرور
        $input['password'] = Hash::make($input['password']);

        $owner = Owner::create($input);
        $owner->save();
        event(new Registered($owner));
        Auth::guard('owner')->login($owner);


        $data = [
            'title' => ' انظم مالك شالية جديد  ',
            'message' => 'قام ' . $owner->name . ' بالتسجيل في الموقع ' . $owner->email
        ];

        $data2 = [
            'title' => ' مرحبا بك  ' . $owner->name . '  في  '  . Setting::first()->company_name_ar,
            'message' => 'لقد قمت بالتسجيل بنجاح . نرحب بك في عائلتنا ونتمنى لك تجربة رائعة.',
        ];

        // Email notifications - only if properly configured
        if (config('mail.mailer') != 'log') {
            $email = Setting::first()->email ?? null;

            if ($email) {
                try {
                    Mail::to($email)->send(new Notify($data, ' انظم مالك شالية جديد'));
                } catch (\Exception $e) {
                    Log::error('فشل إرسال البريد الإلكتروني للأدمن: ' . $e->getMessage());
                }
            }

            try {
                Mail::to($owner->email)->send(new Notify($data2, ' تم تسجيل الدخول بنجاح '));
            } catch (\Exception $e) {
                Log::error('فشل إرسال البريد الإلكتروني للمالك: ' . $e->getMessage());
            }
        } else {
            Log::info('Owner registration emails logged - Mail driver is set to log');
            Log::info('Admin notification: ' . json_encode($data));
            Log::info('Owner welcome email: ' . json_encode($data2));
        }


        return redirect()->route('owner.dashboard')->with('success','تم تسجيل بنجاح');
    }
}
