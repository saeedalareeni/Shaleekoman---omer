<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{


    public function run()
    {
        DB::table('sliders')->insert([
            'image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1600&q=80',
            'title_ar' => 'أهلاً بك في شاليك عُمان',
            'title_en' => 'Welcome to Shaleek Oman',
            'description_ar' => 'اكتشف أفضل الشاليهات والمزارع للإيجار في عُمان',
            'description_en' => 'Discover the best chalets and farms for rent in Oman',
            'button_text_ar' => 'احجز الآن',
            'button_text_en' => 'Book Now',
            'link' => '/chalets',
            'url' => '#',
            'status' => '1',
        ]);

        DB::table('sliders')->insert([
            'image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1600&q=80',
            'title_ar' => 'عطلة نهاية أسبوع مثالية',
            'title_en' => 'Perfect Shaleek Getaway',
            'description_ar' => 'استمتع بأجواء رائعة مع العائلة والأصدقاء',
            'description_en' => 'Enjoy amazing atmosphere with family and friends',
            'button_text_ar' => 'اكتشف المزيد',
            'button_text_en' => 'Explore More',
            'link' => '/chalets',
            'url' => '#',
            'status' => '1',
        ]);

        DB::table('sliders')->insert([
            'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1600&q=80',
            'title_ar' => 'حجوزات سهلة وآمنة',
            'title_en' => 'Easy & Secure Bookings',
            'description_ar' => 'احجز مكانك المفضل بكل سهولة وأمان',
            'description_en' => 'Book your favorite place easily and securely',
            'button_text_ar' => 'ابدأ البحث',
            'button_text_en' => 'Start Searching',
            'link' => '/chalets',
            'url' => '#',
            'status' => '1',
        ]);

    }
}
