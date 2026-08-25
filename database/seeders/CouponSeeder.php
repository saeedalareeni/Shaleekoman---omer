<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            Coupon::create([
                'code' => strtoupper(Str::random(8)),
                'discount_percentage' => rand(5, 50),
                'max_uses' => rand(1, 100),
                'used_count' => 0,
                'expires_at' => Carbon::now()->addDays(rand(10, 60)),
                'is_active' => rand(0, 1),
            ]);
        }
    }
}
