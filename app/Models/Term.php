<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
        'type',
        'order',
        'is_active',
        'effective_date',
        'version'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'effective_date' => 'date',
    ];

    // Accessors
    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getContentAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->content_ar : $this->content_en;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'asc');
    }

    // Get type label
    public function getTypeLabelAttribute()
    {
        $types = [
            'terms' => app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions',
            'privacy' => app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy',
            'refund' => app()->getLocale() == 'ar' ? 'سياسة الاسترداد' : 'Refund Policy',
            'cookies' => app()->getLocale() == 'ar' ? 'سياسة ملفات تعريف الارتباط' : 'Cookies Policy',
        ];

        return $types[$this->type] ?? $this->type;
    }
}
