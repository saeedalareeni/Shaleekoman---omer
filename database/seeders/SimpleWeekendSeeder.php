<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Area;
use App\Models\Category;
use App\Models\Chalet;
use App\Models\Owner;
use Illuminate\Support\Str;

class SimpleWeekendSeeder extends Seeder
{
    public function run()
    {
        // Create Cities
        $cities = [
            ['name_ar' => 'مسقط', 'name_en' => 'Muscat'],
            ['name_ar' => 'صلالة', 'name_en' => 'Salalah'],
            ['name_ar' => 'صحار', 'name_en' => 'Sohar'],
            ['name_ar' => 'صور', 'name_en' => 'Sur'],
        ];

        foreach ($cities as $cityData) {
            $city = City::create($cityData);
            
            // Create 2-3 areas for each city
            for ($i = 1; $i <= 2; $i++) {
                Area::create([
                    'name_ar' => 'منطقة ' . $i . ' - ' . $city->name_ar,
                    'name_en' => 'Area ' . $i . ' - ' . $city->name_en,
                    'city_id' => $city->id,
                ]);
            }
        }

        // Create Categories
        $categories = [
            ['name_ar' => 'شاليهات بحرية', 'name_en' => 'Beachfront Chalets'],
            ['name_ar' => 'شاليهات جبلية', 'name_en' => 'Mountain Chalets'],
            ['name_ar' => 'شاليهات فاخرة', 'name_en' => 'Luxury Chalets'],
            ['name_ar' => 'شاليهات عائلية', 'name_en' => 'Family Chalets'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create Owner
        $owner = Owner::firstOrCreate(
            ['email' => 'owner@example.com'],
            [
                'name' => 'أحمد محمد',
                'phone' => '96891234567',
                'password' => bcrypt('password123'),
            ]
        );

        // Get all areas and categories for random selection
        $allCities = City::all();
        $allAreas = Area::all();
        $allCategories = Category::all();

        // Create 10 sample chalets
        for ($i = 1; $i <= 10; $i++) {
            $city = $allCities->random();
            $area = Area::where('city_id', $city->id)->first() ?? $allAreas->first();
            $category = $allCategories->random();

            Chalet::create([
                'chalet_name_ar' => 'شاليه رقم ' . $i,
                'chalet_name_en' => 'Chalet Number ' . $i,
                'slug' => 'chalet-' . $i . '-' . Str::random(5),
                'short_description_ar' => 'شاليه مميز مع جميع الخدمات والمرافق',
                'short_description_en' => 'Special chalet with all services and facilities',
                'long_description_ar' => 'شاليه فاخر مع إطلالة رائعة وخدمات متميزة. يتضمن جميع وسائل الراحة الحديثة ومناسب للعائلات.',
                'long_description_en' => 'Luxury chalet with amazing views and premium services. Includes all modern amenities and suitable for families.',
                'location' => 'شارع الشاطئ، ' . $area->name_ar,
                'default_day_price' => rand(80, 300),
                'half_day_price' => rand(40, 150),
                'stay_price' => rand(100, 400),
                'holiday_day_price' => rand(120, 500),
                'status' => 'approved',
                'is_feature' => ($i <= 5) ? 1 : 0,
                'city_id' => $city->id,
                'area_id' => $area->id,
                'category_id' => $category->id,
                'owner_id' => $owner->id,
            ]);
        }

        echo "Simple weekend data seeded successfully!\n";
    }
}
