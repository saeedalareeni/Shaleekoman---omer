<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }
    
    public function bookingsByUserId()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
    
    public function getAllBookings()
    {
        // دمج الحجوزات من كلا الحقلين
        $bookingsByCustomerId = $this->bookings;
        $bookingsByUserId = $this->bookingsByUserId;
        
        return $bookingsByCustomerId->merge($bookingsByUserId)->unique('id');
    }
    public function wishlist()
    {
        return $this->belongsToMany(Chalet::class, 'wishlists')->withTimestamps();
    }
    
    public function notifications()
    {
        return $this->hasMany(CustomerNotification::class);
    }


}

