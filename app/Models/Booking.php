<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'checkin_date' => 'date',
        'checkout_date' => 'date',
        'checkin_time' => 'datetime:H:i',
        'checkout_time' => 'datetime:H:i',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chalet()
    {
        return $this->belongsTo(Chalet::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function PaymentMethod()
    {
        return $this->belongsTo(Payment_method::class, 'payment_method_id');
    }

    public function dates()
    {
        return $this->hasMany(BookingDate::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->slug)) {
                $booking->slug = Str::random(30); // توليد رقم  عشوائي
            }
        });
    }

    public function bookingDates()
    {
        return $this->hasMany(BookingDate::class, 'booking_id');
    }
    public function getCancellationStatusAttribute()
{
    return $this->status === 'canceled' ? 'تم إلغاء الحجز' : null;
}

}
