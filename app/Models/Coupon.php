<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function isExpired()
    {
        return $this->expires_at && now()->gt(Carbon::parse($this->expires_at));
    }

    public function isUsable()
    {
        return $this->is_active && !$this->isExpired() && $this->used_count < $this->max_uses;
    }
}
