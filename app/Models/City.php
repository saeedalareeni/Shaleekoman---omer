<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected $fillable = [
        'name_ar',
        'name_en',
        'slug',
        'image'
    ];

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function chalets()
    {
        return $this->hasMany(Chalet::class);
    }
    
    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }
}
