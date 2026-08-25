<?php

namespace App\Providers;

use App\Models\Review;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Chalet;
use App\Models\Category;
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
        // استخدام Bootstrap للـ Pagination
        Paginator::useBootstrap();

        // مشاركة إعدادات الموقع مع جميع الـ views
        try {
            $settings = Setting::first() ?? new Setting();
            View::share('siteSettings', $settings);
        } catch (\Exception $e) {
            View::share('siteSettings', new Setting());
        }

        // تسجيل Observers
        if (class_exists(Review::class)) {
            Review::observe(ReviewObserver::class);
        }

        if (class_exists(Booking::class)) {
            Booking::observe(BookingObserver::class);
        }

        if (class_exists(\App\Models\Owner::class)) {
            \App\Models\Owner::observe(OwnerObserver::class);
        }

        if (class_exists(Chalet::class)) {
            Chalet::observe(ChaletObserver::class);
        }

        if (class_exists(Contact::class)) {
            Contact::observe(ContactObserver::class);
        }

        // مشاركة بيانات التواصل مع جميع الـ views
        try {
            $contact_info = Contact::first() ?? new Contact();
            View::share('contact_info', $contact_info);
        } catch (\Exception $e) {
            View::share('contact_info', new Contact());
        }

        // مشاركة الأقسام (Categories) مع الهيدر
        try {
            // جلب كل الأقسام التي لها اسم عربي أو إنجليزي، ترتيبها حسب ID تصاعديًا
            $headerCategories = Category::where(function ($q) {
                $q->whereNotNull('name_ar')->where('name_ar', '<>', '')
                  ->orWhere(function ($q2) {
                      $q2->whereNotNull('name_en')->where('name_en', '<>', '');
                  });
            })->orderBy('id', 'asc')->get();
        } catch (\Exception $e) {
            $headerCategories = collect(); // مجموعة فارغة إذا حصل خطأ
        }

        View::share('headerCategories', $headerCategories);
    }
}
