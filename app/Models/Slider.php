<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function status()
    {
        return $this->status ? trans('back.Active') : trans('back.Inactive');
    }

    // Accessors for multi-language fields
    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getButtonTextAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->button_text_ar : $this->button_text_en;
    }
    
    // Check if image is external URL
    public function isExternalImage()
    {
        return $this->image && (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://'));
    }
    
    // Get full image URL
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        
        if ($this->isExternalImage()) {
            return $this->image;
        }
        
        return asset($this->image);
    }
}
