<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chalet;
use App\Models\City;
use App\Models\Area;
use App\Models\Category;
use App\Models\Review;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // إنشاء مدينة الرياض
        $city = City::firstOrCreate(
            ['name_ar' => 'الرياض'],
            [
                'name_en' => 'Riyadh',
                'status' => 1
            ]
        );

        // إنشاء منطقة حي النرجس
        $area = Area::firstOrCreate(
            ['name_ar' => 'حي النرجس', 'city_id' => $city->id],
            [
                'name_en' => 'Al Narjis District',
                'status' => 1
            ]
        );

        // إنشاء فئة شاليه
        $category = Category::firstOrCreate(
            ['name_ar' => 'شاليه'],
            [
                'name_en' => 'Chalet',
                'status' => 1
            ]
        );

        // إنشاء مالك (User)
        $owner = User::firstOrCreate(
            ['email' => 'osama@weekend.com'],
            [
                'name' => 'أسامة',
                'password' => bcrypt('password'),
                'status' => 1
            ]
        );

        // إنشاء الشاليه
        $chalet = Chalet::updateOrCreate(
            ['slug' => 'pearl-chalet-1760774544'],
            [
                'chalet_name_ar' => 'شالية بمسطح اخضر ومسبح',
                'chalet_name_en' => 'Chalet with Green Space and Pool',
                'slug' => 'pearl-chalet-1760774544',
                'short_description_ar' => 'شاليه فاخر بمسطح أخضر ومسبح خارجي',
                'short_description_en' => 'Luxury chalet with green space and outdoor pool',
                'long_description_ar' => 'رقم تصريح وزارة السياحة: 50005948. ملاذ للاستجمام والفخامة بتصميم راقٍ وأنيق يتكون من صالة تتسع لعدد (10) أشخاص وطاولة طعام لعدد (8) أشخاص، ومطبخ داخلي مجهز ب (ثلاجة بلت إن، غلاية ماكيروويف بلت إن ، فرن كهربائي بلت إن)، ودورة مياه مع مغسلة للصلاة، وغرفة نوم ماستر مع دورة مياه خاصة بها، مع إطلالة مباشرة لجميع مرافق الشاليه على المسبح والحديقة، وجلسة خارجية تتسع لعدد (7) أشخاص، ومطبخ خارجي مجهز ب (فرن غاز، ثلاجة كبيرة)، ومغاسل خارجية مع دورة مياه، ومسبح خارجي مع حاجز بنظام أوفر فلو مع شلال وشور خارجي بجانب المسبح، ومسطحات خضراء طبيعية مع نظام ري آلي، وشترات أوتوماتيكية لجميع الواجهات الزجاجية تفتح وتغلق بالريموت من قبل الحارس عند الطلب دون الحاجة لدخوله للشاليه، والعديد من المميزات الأخرى مثل تلفزيون وريسيفر وسماعة كبيرة وموقد حطب وعدد (4) زوايات ومدخل خاص مظلل للسيارة.',
                'long_description_en' => 'Tourism Ministry License: 50005948. A haven for relaxation and luxury with elegant design consisting of a hall for 10 people and dining table for 8 people, indoor kitchen equipped with built-in refrigerator, kettle, microwave, electric oven, bathroom with prayer area, master bedroom with private bathroom, direct view of all chalet facilities to pool and garden, outdoor seating for 7 people, outdoor kitchen with gas oven and large refrigerator, outdoor sinks with bathroom, outdoor pool with overflow system barrier with waterfall and outdoor shower next to pool, natural green spaces with automatic irrigation system, automatic shutters for all glass facades that open and close by remote by guard upon request without needing to enter the chalet, and many other features such as TV, receiver, large speaker, wood stove, 4 corners and private covered car entrance.',
                'city_id' => $city->id,
                'area_id' => $area->id,
                'category_id' => $category->id,
                'user_id' => $owner->id,
                'default_day_price' => 1550,
                'half_day_price' => 800,
                'stay_price' => 2000,
                'main_image' => 'chalets/demo-main.jpg',
                'status' => 1,
                'seo_keywords_ar' => 'شاليه, مسبح, مسطح أخضر, الرياض',
                'seo_keywords_en' => 'chalet, pool, green space, riyadh',
                'seo_meta_description_ar' => 'شاليه فاخر بمسطح أخضر ومسبح في الرياض',
                'seo_meta_description_en' => 'Luxury chalet with green space and pool in Riyadh',
                'location' => 'https://maps.google.com',
                'map_link' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3624.9!2d46.7!3d24.7!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjTCsDQyJzAwLjAiTiA0NsKwNDInMDAuMCJF!5e0!3m2!1sen!2ssa!4v1234567890" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ]
        );

        // إضافة صور للشاليه
        $images = [
            'chalets/demo-1.jpg',
            'chalets/demo-2.jpg',
            'chalets/demo-3.jpg',
            'chalets/demo-4.jpg',
        ];

        foreach ($images as $image) {
            \App\Models\ChaletImage::updateOrCreate(
                ['chalet_id' => $chalet->id, 'image_path' => $image],
                ['image_path' => $image]
            );
        }

        // إنشاء 701 تقييم وهمي
        $this->command->info('Creating 701 reviews...');
        
        $customerNames = [
            'محمد أحمد', 'فاطمة علي', 'عبدالله سعيد', 'نورة خالد', 'سارة محمد',
            'عمر يوسف', 'ريم عبدالرحمن', 'خالد فهد', 'منى إبراهيم', 'أحمد حسن',
            'لينا سالم', 'ماجد عبدالله', 'هند ناصر', 'طارق علي', 'دانة محمد'
        ];

        $comments = [
            'شاليه رائع ونظيف جداً، المسبح ممتاز والمسطح الأخضر جميل',
            'تجربة مميزة، المكان نظيف والخدمة ممتازة',
            'شاليه فخم وراقي، ننصح بزيارته',
            'المكان يطابق الوصف تماماً، تجربة رائعة',
            'شاليه جميل ومريح، المرافق ممتازة',
            'مكان هادئ ومناسب للعائلات',
            'شاليه نظيف جداً والموقع ممتاز',
            'تجربة لا تنسى، المسبح والحديقة رائعين',
            'شاليه فاخر بكل المقاييس',
            'مكان مميز وخدمة احترافية'
        ];

        for ($i = 0; $i < 701; $i++) {
            $customer = Customer::firstOrCreate(
                ['email' => 'customer' . $i . '@demo.com'],
                [
                    'name' => $customerNames[array_rand($customerNames)],
                    'phone' => '966500000' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'password' => bcrypt('password'),
                    'status' => 1
                ]
            );

            // توزيع التقييمات: معظمها 9-10، بعضها 8، قليل 7
            $rating = rand(1, 100);
            if ($rating <= 70) {
                $stars = rand(9, 10);
            } elseif ($rating <= 90) {
                $stars = 8;
            } else {
                $stars = 7;
            }

            Review::create([
                'chalet_id' => $chalet->id,
                'customer_id' => $customer->id,
                'rating' => $stars,
                'comment' => $comments[array_rand($comments)],
                'status' => 1,
                'created_at' => now()->subDays(rand(1, 365))
            ]);

            if ($i % 100 == 0) {
                $this->command->info("Created {$i} reviews...");
            }
        }

        // إضافة مشاهدات وهمية
        for ($i = 0; $i < 1500; $i++) {
            \App\Models\ChaletView::create([
                'chalet_id' => $chalet->id,
                'ip_address' => '192.168.1.' . rand(1, 255),
                'created_at' => now()->subDays(rand(1, 30))
            ]);
        }

        $this->command->info('✅ Demo data created successfully!');
        $this->command->info('Chalet URL: /chalet/pearl-chalet-1760774544');
        $this->command->info('Average Rating: 9.3');
        $this->command->info('Total Reviews: 701');
        $this->command->info('Total Views: 1500');
    }
}
