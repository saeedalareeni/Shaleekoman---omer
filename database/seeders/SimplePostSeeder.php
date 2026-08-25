<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class SimplePostSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            [
                'title_ar' => 'أفضل الشاليهات في مسقط',
                'title_en' => 'Best Chalets in Muscat',
                'slug' => 'best-chalets-muscat',
                'body_ar' => 'اكتشف أفضل الشاليهات في مسقط لقضاء عطلة نهاية أسبوع مميزة مع العائلة والأصدقاء. تتميز شاليهات مسقط بإطلالاتها البحرية الخلابة ومرافقها المتكاملة التي تضمن لك إقامة مريحة وممتعة.',
                'body_en' => 'Discover the best chalets in Muscat for a memorable weekend getaway with family and friends. Muscat chalets feature stunning sea views and complete facilities that ensure a comfortable and enjoyable stay.',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80',
                'status' => 1,
                'views' => 150,
            ],
            [
                'title_ar' => 'دليل حجز الشاليهات في صلالة',
                'title_en' => 'Guide to Booking Chalets in Salalah',
                'slug' => 'booking-chalets-salalah',
                'body_ar' => 'موسم الخريف في صلالة من أجمل الأوقات لزيارة هذه المدينة الساحرة. احجز شاليهك مبكراً واستمتع بالطبيعة الخضراء والأجواء الباردة.',
                'body_en' => 'Khareef season in Salalah is one of the best times to visit this enchanting city. Book your chalet early and enjoy the green nature and cool weather.',
                'image' => 'https://images.unsplash.com/photo-1587974928442-77dc3e0dba72?w=800&q=80',
                'status' => 1,
                'views' => 230,
            ],
            [
                'title_ar' => 'أنشطة عائلية في الشاليهات',
                'title_en' => 'Family Activities in Chalets',
                'slug' => 'family-activities-chalets',
                'body_ar' => 'قضاء الوقت في الشاليه مع العائلة فرصة رائعة لخلق ذكريات لا تُنسى. استمتع بحفلات الشواء والسباحة والألعاب الجماعية.',
                'body_en' => 'Spending time at a chalet with family is a great opportunity to create unforgettable memories. Enjoy BBQ parties, swimming, and group games.',
                'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?w=800&q=80',
                'status' => 1,
                'views' => 180,
            ],
            [
                'title_ar' => 'أفضل أوقات زيارة الشاليهات',
                'title_en' => 'Best Times to Visit Chalets',
                'slug' => 'best-times-visit-chalets',
                'body_ar' => 'الشتاء في عُمان (نوفمبر - مارس) هو أفضل وقت لزيارة الشاليهات. الطقس معتدل ومثالي للأنشطة الخارجية.',
                'body_en' => 'Winter in Oman (November - March) is the best time to visit chalets. The weather is moderate and perfect for outdoor activities.',
                'image' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=800&q=80',
                'status' => 1,
                'views' => 120,
            ],
            [
                'title_ar' => 'نصائح لاختيار الشاليه المثالي',
                'title_en' => 'Tips for Choosing the Perfect Chalet',
                'slug' => 'tips-choosing-perfect-chalet',
                'body_ar' => 'عند اختيار الشاليه المناسب، تأكد من مراعاة عدد الضيوف، المرافق المطلوبة، والموقع المناسب. احجز مبكراً للحصول على أفضل الأسعار.',
                'body_en' => 'When choosing the right chalet, make sure to consider the number of guests, required facilities, and suitable location. Book early to get the best prices.',
                'image' => 'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=800&q=80',
                'status' => 1,
                'views' => 95,
            ],
            [
                'title_ar' => 'الشاليهات الفاخرة في عُمان',
                'title_en' => 'Luxury Chalets in Oman',
                'slug' => 'luxury-chalets-oman',
                'body_ar' => 'اكتشف مجموعة من أفخم الشاليهات في عُمان مع مسابح خاصة وإطلالات خلابة وخدمات راقية تضمن لك تجربة لا تُنسى.',
                'body_en' => 'Discover a collection of the most luxurious chalets in Oman with private pools, stunning views, and premium services that guarantee an unforgettable experience.',
                'image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&q=80',
                'status' => 1,
                'views' => 320,
            ],
        ];

        foreach ($posts as $post) {
            // Check if post with same slug doesn't exist
            if (!Post::where('slug', $post['slug'])->exists()) {
                Post::create($post);
            }
        }
    }
}
