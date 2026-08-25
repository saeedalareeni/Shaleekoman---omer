<?php

namespace Database\Seeders;

use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSeeder extends Seeder
{


    public function run()
    {

        DB::table('abouts')->insert([

            'company_name_ar' => 'شاليهاتي',
            'company_name_en' => 'my chalets',

            'image_about_us' => 'no_image.png',
            'bg' => 'no_image.png',

            'short_about_ar' => 'وصف تعريفي مختصر عن الشركة بالعربي',
            'short_about_en' => 'وصف تعريفي مختصر عن الشركة بالإنجليزي',

            'about_ar' => 'وصف تعريفي مطول عن الشركة بالعربي',
            'about_en' => 'وصف تعريفي مطول عن الشركة بالإنجليزي',

        ]);
    }
}
