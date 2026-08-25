<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name_ar' => 'مسقط', 'name_en' => 'Muscat'],
            ['name_ar' => 'ظفار', 'name_en' => 'Dhofar'],
            ['name_ar' => 'مسندم', 'name_en' => 'Musandam'],
            ['name_ar' => 'البريمي', 'name_en' => 'Al Buraimi'],
            ['name_ar' => 'الداخلية', 'name_en' => 'Ad Dakhiliyah'],
            ['name_ar' => 'شمال الباطنة', 'name_en' => 'Al Batinah North'],
            ['name_ar' => 'جنوب الباطنة', 'name_en' => 'Al Batinah South'],
            ['name_ar' => 'الوسطى', 'name_en' => 'Al Wusta'],
            ['name_ar' => 'شمال الشرقية', 'name_en' => 'Ash Sharqiyah North'],
            ['name_ar' => 'جنوب الشرقية', 'name_en' => 'Ash Sharqiyah South'],
            ['name_ar' => 'الظاهرة', 'name_en' => 'Ad Dhahirah'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
