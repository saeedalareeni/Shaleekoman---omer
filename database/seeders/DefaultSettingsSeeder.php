<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DefaultSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = Setting::first();

        $defaultValues = [
            'company_name_ar' => 'شاليك',
            'company_name_en' => 'shaleek',
            'site_name_ar' => 'شاليك',
            'site_name_en' => 'shaleek',
            'site_title_ar' => 'شاليك',
            'site_title_en' => 'shaleek',
            'site_description_ar' => 'منصة عرض الشاليهات والمزارع والاستراحات والأكواخ',
            'site_description_en' => 'Platform for booking chalets, farms, retreats, and cabins',
            'email' => 'info@shaleek.com',
            'phone' => '+968 9999 9999',
            'address_ar' => 'مسقط، سلطنة عمان',
            'address_en' => 'Muscat, Sultanate of Oman',
            'cr_no' => '12345678',
            'tax_no' => 'OM123456789',
            'tax' => 5,
            'advance_amount' => 50,
            'city' => 'مسقط',
            'country' => 'سلطنة عمان',
            'logo' => 'uploads/settings/logo.png',
            'logo_white' => 'uploads/settings/logo-white.png',
            'favicon' => 'uploads/settings/favicon.ico',
            'google_login_enabled' => false,
            'email_notifications_enabled' => true,
            'notify_new_booking' => true,
            'notify_booking_confirmed' => true,
            'notify_booking_cancelled' => true,
            'notify_new_review' => true,
            'notify_new_owner' => true,
            'maintenance_mode' => false,
        ];

        if (!$settings) {
            Setting::create($defaultValues);
            echo "تم إنشاء الإعدادات الافتراضية بنجاح\n";
            return;
        }

        if (empty($settings->site_name_ar)) {
            $settings->update([
                'site_name_ar' => $defaultValues['site_name_ar'],
                'site_name_en' => $defaultValues['site_name_en'],
                'site_title_ar' => $defaultValues['site_title_ar'],
                'site_title_en' => $defaultValues['site_title_en'],
                'site_description_ar' => $defaultValues['site_description_ar'],
                'site_description_en' => $defaultValues['site_description_en'],
            ]);

            echo "تم تحديث الإعدادات الموجودة\n";
        }
    }
}
