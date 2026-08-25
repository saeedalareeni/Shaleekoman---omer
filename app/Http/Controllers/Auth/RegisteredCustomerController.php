<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Notify;
use App\Models\Customer;
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

class RegisteredCustomerController  extends Controller
{


    public function create(): View
    {
        return view('auth.customer_register');
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                     => 'required|string',
            'email'                    => 'required|email|unique:customers,email',
            'phone'                    => 'required|unique:customers,phone',
            'password'                 => ['required', 'confirmed', Rules\Password::defaults()],
            'address'                  => 'required|string',
        ]);

        $request->validate([
            'phone' => ['required','regex:/^\+968\d{8}$/']
        ],[
            'phone.regex' => 'يجب أن يكون رقم الجوال بالشكل +968XXXXXXXX'
        ]);

        $day = date('Ymd');

        if (Customer::count() == 0){
            $account_number = 1;
        }else{
            $account_number = Customer::latest()->first()->id + 1;
        }
        $input['user_id'] = $request->name;
        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input = $request->except(['password_confirmation']); // استبعاد حقل تأكيد كلمة المرور
        $input['password'] = Hash::make($input['password']);
        $input['username'] = $request->email;
        $input['account_number'] = $account_number+$day;

        $customer = Customer::create($input);
        $customer->save();
        event(new Registered($customer));
        Auth::guard('customer')->login($customer);

        $data = [
            'title' => ' انظم مستخدم جديد  ',
            'message' => 'قام ' . $customer->name . ' بالتسجيل في الموقع ' . $customer->email
        ];

        $data2 = [
            'title' => ' مرحبا بك  ' . $customer->name . '  في  '  . Setting::first()->company_name_ar,
            'message' => 'لقد قمت بالتسجيل بنجاح . نرحب بك في عائلتنا ونتمنى لك تجربة رائعة.',
        ];

        // Email notifications - only if properly configured
        if (config('mail.mailer') != 'log') {
            $email = Setting::first()->email ?? null;

            if ($email) {
                try {
                    Mail::to($email)->send(new Notify($data, ' انظم مستخدم جديد'));
                } catch (\Exception $e) {
                    Log::error('فشل إرسال البريد الإلكتروني للأدمن: ' . $e->getMessage());
                }
            }

            try {
                Mail::to($customer->email)->send(new Notify($data2, ' تم تسجيل الدخول بنجاح '));
            } catch (\Exception $e) {
                Log::error('فشل إرسال البريد الإلكتروني للعميل: ' . $e->getMessage());
            }
        } else {
            Log::info('Customer registration emails logged - Mail driver is set to log');
            Log::info('Admin notification: ' . json_encode($data));
            Log::info('Customer welcome email: ' . json_encode($data2));
        }
        return redirect()->route('user-index.index');
    }
}
