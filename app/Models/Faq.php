<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'question_ar',
        'question_en',
        'answer_ar',
        'answer_en',
        'category',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Accessors
    public function getQuestionAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->question_ar : $this->question_en;
    }

    public function getAnswerAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->answer_ar : $this->answer_en;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'asc');
    }

    // Get category label
    public function getCategoryLabelAttribute()
    {
        $categories = [
            'general' => app()->getLocale() == 'ar' ? 'عام' : 'General',
            'booking' => app()->getLocale() == 'ar' ? 'الحجز' : 'Booking',
            'payment' => app()->getLocale() == 'ar' ? 'الدفع' : 'Payment',
            'cancellation' => app()->getLocale() == 'ar' ? 'الإلغاء' : 'Cancellation',
            'owner' => app()->getLocale() == 'ar' ? 'المالك' : 'Owner',
        ];

        return $categories[$this->category] ?? $this->category;
    }
}
