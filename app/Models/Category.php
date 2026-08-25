<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // الأفضل استخدام fillable بدل guarded = []
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
    ];

    /**
     * العلاقة مع الشاليهات
     */
    public function chalets()
    {
        return $this->hasMany(Chalet::class);
    }

    /**
     * إرجاع الاسم حسب اللغة
     */
    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->name_ar
            : $this->name_en;
    }

    /**
     * إرجاع الوصف حسب اللغة
     */
    public function getDescriptionAttribute()
    {
        return app()->getLocale() == 'ar'
            ? ($this->description_ar ?? '')
            : ($this->description_en ?? '');
    }
}
