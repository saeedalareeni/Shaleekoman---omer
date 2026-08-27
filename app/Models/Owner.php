<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Owner extends Authenticatable
{
    use HasFactory;

    protected $guarded = [];

    public function chalets()
    {
        return $this->hasMany(Chalet::class);
    }

    public function expenses()
    {
        return $this->hasMany(OwnersExpense::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    public function getUnreadNotificationsCountAttribute()
    {
        return $this->unreadNotifications()->count();
    }

    /**
     * The owner's avatar: their own uploaded photo, or — if they never set one —
     * the first photo of one of their own properties, so the profile picture is
     * never a blank placeholder.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->image) {
            return asset($this->image);
        }

        $chalet = $this->chalets()->whereNotNull('main_image')->first();
        if ($chalet && $chalet->main_image) {
            return asset($chalet->main_image);
        }

        $chaletImage = \App\Models\ChaletImage::whereIn('chalet_id', $this->chalets()->pluck('id'))->whereNotNull('image')->first();
        if ($chaletImage) {
            return asset($chaletImage->image);
        }

        return null;
    }
}
