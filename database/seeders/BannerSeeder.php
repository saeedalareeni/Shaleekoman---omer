<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{

    public function run(): void
    {
        $banners=[];
        for ($i = 1; $i <= 6; $i++) {
            $banners[] = [
                'image' => 'images/banners/banner.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('banners')->insert($banners);

    }
}
