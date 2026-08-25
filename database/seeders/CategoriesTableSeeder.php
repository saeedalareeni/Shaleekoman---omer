<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name_ar' => 'شاليهات', 'name_en' => 'Chalets'],
            ['name_ar' => 'استراحات', 'name_en' => 'Rest houses'],
            ['name_ar' => 'مزارع', 'name_en' => 'Farms'],
        ];        
        foreach ($cities as $category) {
            Category::create($category);
        }
    }
}
