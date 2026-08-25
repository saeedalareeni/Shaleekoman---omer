<?php

namespace App\Providers;

use App\Models\Review;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Chalet;
use App\Observers\ReviewObserver;
use App\Observers\BookingObserver;
use App\Observers\ContactObserver;
use App\Observers\OwnerObserver;
use App\Observers\ChaletObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        
        // مشاركة الإعدادات مع جميع الـ views
        try {
            $settings = Setting::first();
            if (!$settings) {
                $settings = new Setting();
            }
            View::share('siteSettings', $settings);
        } catch (\Exception $e) {
            // في حالة عدم وجود جدول الإعدادات أو خطأ في قاعدة البيانات
            View::share('siteSettings', new Setting());
        }
        
        // تسجيل Observers
        if (class_exists(Review::class)) {
            Review::observe(ReviewObserver::class);
        }
        
        // Register BookingObserver
        if (class_exists(Booking::class)) {
            Booking::observe(BookingObserver::class);
        }
        
        // Register OwnerObserver
        if (class_exists(\App\Models\Owner::class)) {
            \App\Models\Owner::observe(OwnerObserver::class);
        }
        
        // Register ChaletObserver
        if (class_exists(Chalet::class)) {
            Chalet::observe(ChaletObserver::class);
        }
        
        if (class_exists('App\Models\Contact')) {
            Contact::observe(ContactObserver::class);
        }
        
        // مشاركة بيانات التواصل مع جميع الواجهات
try {
    $contact_info = Contact::first(); // استخدم اسم متغير واضح
    if (!$contact_info) {
        $contact_info = new Contact();
    }
    View::share('contact_info', $contact_info);
} catch (\Exception $e) {
    View::share('contact_info', new Contact());
}
        
    }
    
}
