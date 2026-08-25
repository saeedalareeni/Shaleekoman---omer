<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Models\Owner;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth based on user type
     */
    public function redirectToGoogle(Request $request, $type = 'customer')
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

        // Store the user type in session
        session(['google_auth_type' => $type]);
        
        // Store the intended URL if coming from a specific page
        if ($request->has('intended')) {
            session(['url.intended' => $request->intended]);
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $setting = Setting::first();
            
            // Check if Google login is enabled
            if (!$setting || !$setting->google_login_enabled) {
                throw new Exception('Google login is disabled');
            }

            // Get user from Google
            $googleUser = Socialite::driver('google')->user();
            
            // Get the user type from session
            $userType = session('google_auth_type', 'customer');
            
            // Handle based on user type
            switch ($userType) {
                case 'customer':
                    return $this->handleCustomerAuth($googleUser, $setting);
                    
                case 'owner':
                    return $this->handleOwnerAuth($googleUser, $setting);
                    
                case 'admin':
                    return $this->handleAdminAuth($googleUser, $setting);
                    
                default:
                    return $this->handleCustomerAuth($googleUser, $setting);
            }
            
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 
                app()->getLocale() == 'ar' 
                    ? 'حدث خطأ في تسجيل الدخول. حاول مرة أخرى.' 
                    : 'Login failed. Please try again.'
            );
        }
    }

    /**
     * Handle customer authentication
     */
    private function handleCustomerAuth($googleUser, $setting)
    {
        // Find or create customer
        $customer = Customer::where('email', $googleUser->email)->first();
        
        if (!$customer) {
            // Check if auto-registration is enabled
            if (!$setting->google_auto_register) {
                return redirect()->route('customer_register')
                    ->with('info', 
                        app()->getLocale() == 'ar' 
                            ? 'الرجاء إنشاء حساب أولاً قبل تسجيل الدخول بـ Google' 
                            : 'Please create an account first before signing in with Google'
                    );
            }
            
            // Create new customer
            $customer = Customer::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'email_verified_at' => now(),
                'password' => Hash::make(uniqid()), // Random password
                'status' => 'active',
            ]);
            
            // Also create a User record if needed
            $user = User::firstOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'password' => Hash::make(uniqid()),
                ]
            );
            
            $customer->user_id = $user->id;
            $customer->save();
        } else {
            // Update Google ID if not set
            if (!$customer->google_id) {
                $customer->google_id = $googleUser->id;
            }
            
            // Sync profile if enabled
            if ($setting->google_sync_profile) {
                $customer->name = $googleUser->name;
                if ($googleUser->avatar) {
                    $customer->avatar_url = $googleUser->avatar;
                }
            }
            
            $customer->save();
        }
        
        // Login the customer
        Auth::guard('customer')->login($customer, true);
        
        // Check for pending booking
        if (session()->has('pending_booking')) {
            return redirect()->route('booking.confirm');
        }
        
        // Check for intended URL
        $intendedUrl = session()->pull('url.intended', null);
        if ($intendedUrl) {
            return redirect($intendedUrl);
        }
        
        // Redirect to customer dashboard
        return redirect()->route('account.orders')
            ->with('success', 
                app()->getLocale() == 'ar' 
                    ? 'تم تسجيل الدخول بنجاح' 
                    : 'Logged in successfully'
            );
    }

    /**
     * Handle owner authentication
     */
    private function handleOwnerAuth($googleUser, $setting)
    {
        // Find owner
        $owner = Owner::where('email', $googleUser->email)->first();
        
        if (!$owner) {
            return redirect()->route('owner.login')
                ->with('error', 
                    app()->getLocale() == 'ar' 
                        ? 'لا يوجد حساب مالك بهذا البريد الإلكتروني' 
                        : 'No owner account found with this email'
                );
        }
        
        // Update Google ID if not set
        if (!$owner->google_id) {
            $owner->google_id = $googleUser->id;
        }
        
        // Sync profile if enabled
        if ($setting->google_sync_profile) {
            $owner->name = $googleUser->name;
            $owner->save();
        }
        
        // Login the owner
        Auth::guard('owner')->login($owner, true);
        
        // Redirect to owner dashboard
        return redirect()->route('owner.dashboard')
            ->with('success', 
                app()->getLocale() == 'ar' 
                    ? 'تم تسجيل الدخول بنجاح' 
                    : 'Logged in successfully'
            );
    }

    /**
     * Handle admin authentication
     */
    private function handleAdminAuth($googleUser, $setting)
    {
        // Find admin user
        $admin = User::where('email', $googleUser->email)
                    ->whereHas('roles', function($q) {
                        $q->where('name', 'Admin');
                    })
                    ->first();
        
        if (!$admin) {
            return redirect()->route('login')
                ->with('error', 
                    app()->getLocale() == 'ar' 
                        ? 'غير مصرح لك بتسجيل الدخول كمدير' 
                        : 'You are not authorized to login as admin'
                );
        }
        
        // Update Google ID if not set
        if (!$admin->google_id) {
            $admin->google_id = $googleUser->id;
            $admin->save();
        }
        
        // Login the admin
        Auth::login($admin, true);
        
        // Redirect to admin dashboard
        return redirect()->route('dashboard.index')
            ->with('success', 
                app()->getLocale() == 'ar' 
                    ? 'تم تسجيل الدخول بنجاح' 
                    : 'Logged in successfully'
            );
    }
}
