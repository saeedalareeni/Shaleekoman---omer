<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'user_id',
        'type',
        'title_ar',
        'title_en',
        'message_ar',
        'message_en',
        'url',
        'icon',
        'color',
        'icon_type',
        'is_read',
        'data',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
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
            default => '#17a2b8'
        };
    }

    public function getIconClassAttribute()
    {
        return match($this->icon_type) {
            'success' => 'fas fa-check',
            'warning' => 'fas fa-exclamation-triangle',
            'error' => 'fas fa-times-circle',
            default => 'fas fa-info-circle'
        };
    }
}
