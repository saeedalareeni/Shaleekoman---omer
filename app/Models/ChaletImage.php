<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChaletImage extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    // إضافة accessor للتوافق مع الكود القديم
    protected $appends = ['image'];
    
    public function getImageAttribute()
    {
        return $this->image_path;
    }

    public function chalet()
    {
        return $this->belongsTo(Chalet::class);
    }


}
