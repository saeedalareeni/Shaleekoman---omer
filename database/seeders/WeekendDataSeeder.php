<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Area;
use App\Models\Category;
use App\Models\Chalet;
use App\Models\ChaletImage;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\Owner;
use App\Models\About;
use App\Models\Contact;
use App\Models\Post;
use Illuminate\Support\Str;

class WeekendDataSeeder extends Seeder
{
    public function run()
    {
        // Create Cities
        $muscat = City::create([
            'name_ar' => 'مسقط',
            'name_en' => 'Muscat',
        ]);
        
        $salalah = City::create([
            'name_ar' => 'صلالة',
            'name_en' => 'Salalah',
        ]);
        
        $sohar = City::create([
            'name_ar' => 'صحار',
            'name_en' => 'Sohar',
        ]);
        
        $sur = City::create([
            'name_ar' => 'صور',
            'name_en' => 'Sur',
        ]);

        // Create Areas
        $alSeeb = Area::create([
            'name_ar' => 'السيب',
            'name_en' => 'Al Seeb',
            'city_id' => $muscat->id,
        ]);
        
        $alKhuwair = Area::create([
            'name_ar' => 'الخوير',
            'name_en' => 'Al Khuwair',
            'city_id' => $muscat->id,
        ]);
        
        $qurm = Area::create([
            'name_ar' => 'القرم',
            'name_en' => 'Qurm',
            'city_id' => $muscat->id,
        ]);
        
        $alAwqadain = Area::create([
            'name_ar' => 'العوقدين',
            'name_en' => 'Al Awqadain',
            'city_id' => $salalah->id,
        ]);

        // Create Categories
        $beachfront = Category::create([
            'name_ar' => 'شاليهات بحرية',
            'name_en' => 'Beachfront Chalets',
        ]);
        
        $mountain = Category::create([
            'name_ar' => 'شاليهات جبلية',
            'name_en' => 'Mountain Chalets',
        ]);
        
        $luxury = Category::create([
            'name_ar' => 'شاليهات فاخرة',
            'name_en' => 'Luxury Chalets',
        ]);
        
        $family = Category::create([
            'name_ar' => 'شاليهات عائلية',
            'name_en' => 'Family Chalets',
        ]);

        // Create Owner
        $owner = Owner::create([
            'name' => 'أحمد محمد',
            'email' => 'owner@example.com',
            'phone' => '96891234567',
            'password' => bcrypt('password123'),
        ]);

        // Create Sample Chalets
        $chaletNames = [
            ['ar' => 'شاليه اللؤلؤة', 'en' => 'Pearl Chalet'],
            ['ar' => 'شاليه المرجان', 'en' => 'Coral Chalet'],
            ['ar' => 'شاليه الصدف', 'en' => 'Shell Chalet'],
            ['ar' => 'شاليه النخيل', 'en' => 'Palm Chalet'],
            ['ar' => 'شاليه الواحة', 'en' => 'Oasis Chalet'],
            ['ar' => 'شاليه البحيرة', 'en' => 'Lake Chalet'],
            ['ar' => 'شاليه الجبل الأخضر', 'en' => 'Green Mountain Chalet'],
            ['ar' => 'شاليه الربيع', 'en' => 'Spring Chalet'],
            ['ar' => 'شاليه النسيم', 'en' => 'Breeze Chalet'],
            ['ar' => 'شاليه الفردوس', 'en' => 'Paradise Chalet'],
        ];

        $cities = [$muscat, $salalah, $sohar, $sur];
        $areas = [$alSeeb, $alKhuwair, $qurm, $alAwqadain];
        $categories = [$beachfront, $mountain, $luxury, $family];

        foreach ($chaletNames as $index => $name) {
            $city = $cities[array_rand($cities)];
            $cityAreas = Area::where('city_id', $city->id)->get();
            $area = $cityAreas->count() > 0 ? $cityAreas->random() : $areas[0];
            
            $chalet = Chalet::create([
                'name_ar' => $name['ar'],
                'name_en' => $name['en'],
                'slug' => Str::slug($name['en']),
                'description_ar' => 'شاليه فاخر مع إطلالة رائعة وخدمات متميزة. يتضمن جميع وسائل الراحة الحديثة ومناسب للعائلات.',
                'description_en' => 'Luxury chalet with amazing views and premium services. Includes all modern amenities and suitable for families.',
                'city_id' => $city->id,
                'area_id' => $area->id,
                'category_id' => $categories[array_rand($categories)]->id,
                'owner_id' => $owner->id,
                'default_day_price' => rand(80, 300),
                'holiday_day_price' => rand(120, 400),
                'discount_percentage' => rand(0, 30),
                'address' => 'شارع الشاطئ، ' . $area->name,
                'latitude' => 23.5880 + (rand(-100, 100) / 10000),
                'longitude' => 58.3829 + (rand(-100, 100) / 10000),
                'bedrooms' => rand(2, 5),
                'bathrooms' => rand(2, 4),
                'area_size' => rand(150, 500),
                'max_guests' => rand(6, 15),
                'has_pool' => rand(0, 1),
                'has_wifi' => rand(0, 1),
                'has_parking' => rand(0, 1),
                'has_kitchen' => 1,
                'is_beachfront' => ($categories[array_rand($categories)]->id == $beachfront->id) ? 1 : rand(0, 1),
                'status' => 'approved',
                'is_feature' => ($index < 5) ? 1 : rand(0, 1),
                'views_count' => rand(100, 1000),
            ]);

            // Add sample images for each chalet
            for ($i = 1; $i <= 3; $i++) {
                ChaletImage::create([
                    'chalet_id' => $chalet->id,
                    'path' => 'chalets/sample-' . rand(1, 10) . '.jpg',
                    'is_primary' => ($i == 1) ? 1 : 0,
                ]);
            }
        }

        // Create Sliders
        $sliderTitles = [
            [
                'title' => 'مرحباً بك في Shaleek Oman',
                'description' => 'اكتشف أجمل الشاليهات والمنتجعات في سلطنة عُمان',
                'button_text' => 'ابدأ البحث',
            ],
            [
                'title' => 'عروض نهاية الأسبوع',
                'description' => 'احجز الآن واحصل على خصومات تصل إلى 50%',
                'button_text' => 'شاهد العروض',
            ],
            [
                'title' => 'تجربة لا تُنسى',
                'description' => 'استمتع بأفضل الخدمات والمرافق الفاخرة',
                'button_text' => 'احجز الآن',
            ],
        ];

        foreach ($sliderTitles as $index => $sliderData) {
            Slider::create([
                'title' => $sliderData['title'],
                'description' => $sliderData['description'],
                'button_text' => $sliderData['button_text'],
                'link' => '/all-chalet',
                'image' => 'sliders/slider-' . ($index + 1) . '.jpg',
                'status' => 1,
            ]);
        }

        // Create Banners
        Banner::create([
            'title' => 'عرض خاص',
            'description' => 'خصم 30% على جميع الحجوزات',
            'link' => '/all-chalet',
            'image' => 'banners/banner-1.jpg',
        ]);

        // Create About
        About::create([
            'title_ar' => 'نبذة عن شاليك عُمان',
            'title_en' => 'About Shaleek Oman',
            'description_ar' => 'منصة رائدة لحجز الشاليهات والمنتجعات في سلطنة عُمان. نوفر لك أفضل الخيارات لقضاء عطلة نهاية أسبوع مميزة.',
            'description_en' => 'Leading platform for booking chalets and resorts in Oman. We provide you with the best options for a special Shaleek getaway.',
            'mission_ar' => 'مهمتنا هي توفير تجربة حجز سهلة وموثوقة لعملائنا',
            'mission_en' => 'Our mission is to provide an easy and reliable booking experience for our customers',
            'vision_ar' => 'رؤيتنا أن نكون المنصة الأولى في المنطقة',
            'vision_en' => 'Our vision is to be the leading platform in the region',
        ]);

        // Create Contact
        Contact::create([
            'phone' => '+968 91234567',
            'email' => 'info@weekendoman.com',
            'address_ar' => 'مسقط، سلطنة عُمان',
            'address_en' => 'Muscat, Sultanate of Oman',
            'facebook' => 'https://facebook.com/weekendoman',
            'instagram' => 'https://instagram.com/weekendoman',
            'twitter' => 'https://twitter.com/weekendoman',
        ]);

        // Create Sample Posts
        $postTitles = [
            ['ar' => 'أفضل الشواطئ في عُمان', 'en' => 'Best Beaches in Oman'],
            ['ar' => 'دليلك السياحي في صلالة', 'en' => 'Your Tourist Guide in Salalah'],
            ['ar' => 'نصائح للسفر في الصيف', 'en' => 'Summer Travel Tips'],
        ];

        foreach ($postTitles as $post) {
            Post::create([
                'title' => $post['ar'],
                'title_en' => $post['en'],
                'slug' => Str::slug($post['en']),
                'content' => 'محتوى المقال هنا. هذا نص تجريبي لعرض المقالات في الموقع.',
                'content_en' => 'Article content here. This is sample text for displaying articles on the site.',
                'excerpt' => 'ملخص المقال',
                'excerpt_en' => 'Article summary',
                'image' => 'posts/post-' . rand(1, 3) . '.jpg',
                'status' => 1,
            ]);
        }

        echo "Weekend data seeded successfully!\n";
    }
}
