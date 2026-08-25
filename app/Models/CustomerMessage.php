<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMessage extends Model
{
    use HasFactory;

    // إما تستخدم $guarded أو $fillable، لا داعي لكليهما معًا
    // هنا نستخدم $fillable لتحديد الحقول المسموح بها
    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject',       // جديد: عنوان البلاغ
        'message',
        'is_read',
        'is_replied',
        'reply',
        'replied_at'
    ];

    /**
     * حالة الرسالة: نشط / غير نشط
     */
    public function status()
    {
        return $this->status ? trans('back.Active') : trans('back.Inactive');
    }
}
