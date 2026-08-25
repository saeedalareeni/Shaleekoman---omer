<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'google_login_enabled' => 'boolean',
        'email_notifications_enabled' => 'boolean',
        'sms_notifications_enabled' => 'boolean',
        'notify_new_booking' => 'boolean',
        'notify_booking_confirmed' => 'boolean',
        'notify_booking_cancelled' => 'boolean',
        'notify_payment_confirmed' => 'boolean',
        'notify_new_review' => 'boolean',
        'notify_new_owner' => 'boolean',
        'maintenance_mode' => 'boolean',
        'tax' => 'decimal:2',
        'advance_amount' => 'decimal:2',
    ];

    public function getSiteNameAttribute()
    {
        $locale = app()->getLocale();
        $field = 'site_name_' . $locale;

        return $this->$field
            ?: ($locale === 'ar'
                ? ($this->site_name_ar ?: $this->company_name_ar ?: 'شاليك')
                : ($this->site_name_en ?: $this->company_name_en ?: config('app.name', 'shaleek')));
    }

    public function getSiteTitleAttribute()
    {
        $locale = app()->getLocale();
        $field = 'site_title_' . $locale;

        return $this->$field
            ?: $this->getSiteNameAttribute()
            ?: ($locale === 'ar' ? 'شاليك' : 'shaleek');
    }

    public function getSiteDescriptionAttribute()
    {
        $locale = app()->getLocale();
        $field = 'site_description_' . $locale;

        return $this->$field
            ?: ($locale === 'ar'
                ? 'منصة عرض الشاليهات والمزارع والاستراحات والأكواخ'
                : 'A booking platform for chalets, farms, resorts, and cabins.');
    }

    public function getCompanyNameAttribute()
    {
        $locale = app()->getLocale();
        $field = 'company_name_' . $locale;

        return $this->$field
            ?: ($locale === 'ar'
                ? ($this->company_name_ar ?: 'شاليك')
                : ($this->company_name_en ?: 'shaleek'));
    }

    public function getAddressAttribute()
    {
        $locale = app()->getLocale();
        $field = 'address_' . $locale;

        return $this->$field;
    }

    public function getMetaDescriptionAttribute()
    {
        $locale = app()->getLocale();
        $field = 'meta_description_' . $locale;

        return $this->$field ?: $this->getSiteDescriptionAttribute();
    }

    public function getMaintenanceMessageAttribute()
    {
        $locale = app()->getLocale();
        $field = 'maintenance_message_' . $locale;

        return $this->$field
            ?: ($locale === 'ar'
                ? 'الموقع تحت الصيانة، سنعود قريباً'
                : 'The site is under maintenance and will be back soon.');
    }
}
