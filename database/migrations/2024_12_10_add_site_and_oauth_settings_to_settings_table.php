<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Site Identity Settings
            $table->string('site_name_ar')->nullable()->after('company_name_ar');
            $table->string('site_name_en')->nullable()->after('company_name_en');
            $table->string('site_title_ar')->nullable();
            $table->string('site_title_en')->nullable();
            $table->text('site_description_ar')->nullable();
            $table->text('site_description_en')->nullable();
            $table->string('logo_white')->nullable()->after('logo');
            $table->string('favicon')->nullable()->after('logo_white');
            $table->string('website')->nullable();
            
            // Google OAuth Settings
            $table->boolean('google_login_enabled')->default(false);
            $table->string('google_client_id')->nullable();
            $table->string('google_client_secret')->nullable();
            $table->string('google_redirect_url')->nullable();
            
            // Email Settings (Additional)
            $table->boolean('email_notifications_enabled')->default(true);
            $table->boolean('sms_notifications_enabled')->default(false);
            $table->boolean('notify_new_booking')->default(true);
            $table->boolean('notify_booking_confirmed')->default(true);
            $table->boolean('notify_booking_cancelled')->default(true);
            $table->boolean('notify_payment_confirmed')->default(true);
            $table->boolean('notify_new_review')->default(true);
            $table->boolean('notify_new_owner')->default(true);
            
            // Social Media Settings
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('whatsapp_number')->nullable();
            
            // SEO Settings
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description_ar')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->string('facebook_pixel_id')->nullable();
            
            // Additional Location Fields
            $table->string('city')->nullable();
            $table->string('country')->nullable()->default('عمان');
            $table->string('postal_code')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            
            // App Settings
            $table->string('android_app_url')->nullable();
            $table->string('ios_app_url')->nullable();
            $table->string('app_version')->nullable()->default('1.0.0');
            
            // Maintenance Mode
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message_ar')->nullable();
            $table->text('maintenance_message_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_name_ar',
                'site_name_en',
                'site_title_ar',
                'site_title_en',
                'site_description_ar',
                'site_description_en',
                'logo_white',
                'favicon',
                'website',
                'google_login_enabled',
                'google_client_id',
                'google_client_secret',
                'google_redirect_url',
                'email_notifications_enabled',
                'sms_notifications_enabled',
                'notify_new_booking',
                'notify_booking_confirmed',
                'notify_booking_cancelled',
                'notify_payment_confirmed',
                'notify_new_review',
                'notify_new_owner',
                'facebook_url',
                'twitter_url',
                'instagram_url',
                'youtube_url',
                'linkedin_url',
                'whatsapp_number',
                'meta_keywords',
                'meta_description_ar',
                'meta_description_en',
                'google_analytics_id',
                'facebook_pixel_id',
                'city',
                'country',
                'postal_code',
                'latitude',
                'longitude',
                'android_app_url',
                'ios_app_url',
                'app_version',
                'maintenance_mode',
                'maintenance_message_ar',
                'maintenance_message_en'
            ]);
        });
    }
};
