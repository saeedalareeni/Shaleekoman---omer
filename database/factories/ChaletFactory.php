<?php

namespace Database\Factories;

use App\Models\Chalet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ChaletFactory extends Factory
{
    protected $model = Chalet::class;

    public function definition()
    {
        $locations = [
            'مسقط',
            'بركاء',
            'الأشخرة',
            'صحار',
            'الرستاق',
            'صلالة',
            'السيب',
            'بوشر',
            'قريات',
            'العامرات'
        ];
        $categories = [1,2,3];

        $names_ar = [
            'استراحة الفيصل',
            'استراحة الماسة',
            'استراحة الاريام',
            'استراحة شط الغدير',
            'استراحة المحبة',
            'أستراحة السيب',
            'استراحه الطيب',
            'استراحة الأسترخاء',
            'شالية بيت الإجداد',
            'شالية بيت الإجداد',
            'استراحة المسك',
            'إستراحة السالمي',
            'استراحة قصر الرباط',
            'إستراحة عالم الأحلام',
        ];

        $names_en = [
            'Al-Faisal Rest House',
            'Al-Massa Rest House',
            'Al-Aryam Rest House',
            'Shatt Al-Ghadeer Rest House',
            'Al-Mahaba Rest House',
            'Seeb Rest House',
            'Al-Tayeb Rest House',
            'Relaxation Rest House',
            'Grandparents House Chalet',
            'Grandparents House Chalet',
            'Al-Musk Rest House',
            'Al-Salmi Rest House',
            'Al-Ribat Palace Rest House',
            'Dream World Rest House',
        ];

        $video = '<iframe width="560" height="315" src="https://www.youtube.com/embed/YU5wP8S6hPY?si=Trm70U9TKNAKKHV1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';

        return [
            'chalet_name_ar' => $this->faker->randomElement($names_ar),
            'chalet_name_en' => $this->faker->randomElement($names_en),
            'slug' => Str::slug($this->faker->unique()->word),
            'main_image' => 'image.jpg',
            'video' => $video,
            'short_description_ar' => $this->faker->sentence,
            'short_description_en' => $this->faker->sentence,
            'long_description_ar' => $this->faker->paragraph,
            'long_description_en' => $this->faker->paragraph,
            'location' => $this->faker->randomElement($locations),
            'map_link' => '<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d5554.854510409998!2d54.73059386786713!3d16.971782974705217!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTbCsDU4JzI0LjIiTiA1NMKwNDQnMDQuOCJF!5e0!3m2!1sen!2som!4v1695701928359!5m2!1sen!2som" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'default_day_price' => $this->faker->randomFloat(2, 50, 100),
            'holiday_day_price' => $this->faker->randomFloat(2, 100, 300),
            'seo_keywords_ar' => implode(', ', $this->faker->words(5, false)),
            'seo_keywords_en' => implode(', ', $this->faker->words(5, false)),
            'seo_meta_description_ar' => $this->faker->sentence,
            'seo_meta_description_en' => $this->faker->sentence,
            'stay_price' => $this->faker-> randomFloat(2, 10, 30),
            'half_day_price' => $this->faker-> randomFloat(2, 10, 50),
            'city_id' => 2,
            'area_id' => 7,
            'owner_id' => 1,
            'category_id' =>  $this->faker->randomElement($categories),
            'status'=> 'approved',
        ];
    }
}
