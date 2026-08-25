<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'booking_id',
        'type',
        'title_ar',
        'title_en',
        'message_ar',
        'message_en',
        'icon_type',
        'is_read',
        'data',
        'read_at',
        'email_sent'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'email_sent' => 'boolean',
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getMessageAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->message_ar : $this->message_en;
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public function getIconColorAttribute()
    {
        return match($this->icon_type) {
            'success' => '#28a745',
            'warning' => '#ffc107',
            'error' => '#dc3545',
            'info' => '#17a2b8',
            default => '#6c757d'
        };
    }

    public function getIconClassAttribute()
    {
        return match($this->icon_type) {
            'success' => 'fas fa-check-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'error' => 'fas fa-times-circle',
            'info' => 'fas fa-info-circle',
            default => 'fas fa-bell'
        };
    }

    public function getTypeTextAttribute()
    {
        $types = [
            'booking_confirmed' => ['ar' => 'تأكيد الحجز', 'en' => 'Booking Confirmed'],
            'booking_rejected' => ['ar' => 'رفض الحجز', 'en' => 'Booking Rejected'],
            'booking_cancelled' => ['ar' => 'إلغاء الحجز', 'en' => 'Booking Cancelled'],
            'booking_cancelled_by_owner' => ['ar' => 'إلغاء الحجز من المالك', 'en' => 'Booking Cancelled by Owner'],
            'payment_confirmed' => ['ar' => 'تأكيد الدفع', 'en' => 'Payment Confirmed'],
            'payment_reminder' => ['ar' => 'تذكير بالدفع', 'en' => 'Payment Reminder'],
            'booking_reminder' => ['ar' => 'تذكير بالحجز', 'en' => 'Booking Reminder'],
            'review_response' => ['ar' => 'رد على التقييم', 'en' => 'Review Response'],
            'special_offer' => ['ar' => 'عرض خاص', 'en' => 'Special Offer'],
        ];

        $locale = app()->getLocale();
        return $types[$this->type][$locale] ?? $this->type;
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
