<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'user_type',
        'reset_code',
        'created_at',
    ];
    protected static function booted()
    {
        static::creating(function ($resetPasswordHotAdmin) {
            $resetPasswordHotAdmin->created_at = now();
        });
    }
    public function isExpire()
    {
        if ($this->created_at > now()->addHour()) {
            $this->delete();
        }
    }
}
