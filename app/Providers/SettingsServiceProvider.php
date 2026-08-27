<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }

        if (!Schema::hasTable('settings')) {
            return;
        }

        try {
            $settings = Cache::remember('site_settings', 60 * 24, function () {
                return Setting::first() ?? new Setting();
            });

            View::share('siteSettings', $settings);

            config([
                'app.name' => $settings->getSiteNameAttribute() ?: config('app.name'),
                'app.logo' => asset('assets/images/shaleek_logo.jpg'),
                'app.logo_white' => asset('assets/images/shaleek_logo.jpg'),
                'app.favicon' => asset('assets/images/shaleek_logo.jpg'),
                'app.site_name_ar' => $settings->site_name_ar,
                'app.site_name_en' => $settings->site_name_en,
                'app.site_title' => $settings->getSiteTitleAttribute(),
                'app.site_description' => $settings->getSiteDescriptionAttribute(),
                'app.company_name' => $settings->getCompanyNameAttribute(),
                'app.company_email' => $settings->email,
                'app.company_phone' => $settings->phone,
                'app.company_address' => $settings->getAddressAttribute(),
                'app.facebook_url' => $settings->facebook_url,
                'app.twitter_url' => $settings->twitter_url,
                'app.instagram_url' => $settings->instagram_url,
                'app.youtube_url' => $settings->youtube_url,
                'app.linkedin_url' => $settings->linkedin_url,
                'app.whatsapp_number' => $settings->whatsapp_number,
                'app.google_login_enabled' => $settings->google_login_enabled ?? false,
            ]);

            View::composer('*', function ($view) use ($settings) {
                $locale = app()->getLocale();
                $siteName = $locale === 'ar'
                    ? ($settings->site_name_ar ?: 'شاليك')
                    : ($settings->site_name_en ?: 'shaleek');

                $siteTitle = $locale === 'ar'
                    ? ($settings->site_title_ar ?: 'شاليك')
                    : ($settings->site_title_en ?: 'shaleek');

                $siteDescription = $locale === 'ar'
                    ? ($settings->site_description_ar ?: 'منصة عرض الشاليهات والمزارع والاستراحات والأكواخ')
                    : ($settings->site_description_en ?: 'A booking platform for chalets, farms, resorts, and cabins.');

                $metaDescription = $locale === 'ar'
                    ? ($settings->meta_description_ar ?: $siteDescription)
                    : ($settings->meta_description_en ?: $siteDescription);

                $companyName = $locale === 'ar'
                    ? ($settings->company_name_ar ?: 'شاليك')
                    : ($settings->company_name_en ?: 'shaleek');

                $view->with([
                    'siteName' => $siteName,
                    'siteTitle' => $siteTitle,
                    'siteDescription' => $siteDescription,
                    'siteMetaDescription' => $metaDescription,
                    'siteLogo' => asset('assets/images/shaleek_logo.jpg'),
                    'siteLogoWhite' => asset('assets/images/shaleek_logo.jpg'),
                    'siteFavicon' => asset('assets/images/shaleek_logo.jpg'),
                    'companyName' => $companyName,
                    'googleLoginEnabled' => $settings->google_login_enabled ?? false,
                ]);
            });
        } catch (\Exception $e) {
            View::share('siteSettings', new Setting());
            View::composer('*', function ($view) {
                $locale = app()->getLocale();
                $siteName = $locale === 'ar' ? 'شاليك' : 'shaleek';
                $siteDescription = $locale === 'ar'
                    ? 'منصة عرض الشاليهات والمزارع والاستراحات والأكواخ'
                    : 'A booking platform for chalets, farms, resorts, and cabins.';

                $view->with([
                    'siteName' => $siteName,
                    'siteTitle' => $siteName,
                    'siteDescription' => $siteDescription,
                    'siteMetaDescription' => $siteDescription,
                    'siteLogo' => asset('assets/images/shaleek_logo.jpg'),
                    'siteLogoWhite' => asset('assets/images/shaleek_logo.jpg'),
                    'siteFavicon' => asset('assets/images/shaleek_logo.jpg'),
                    'companyName' => $siteName,
                    'googleLoginEnabled' => false,
                ]);
            });
        }
    }
}
