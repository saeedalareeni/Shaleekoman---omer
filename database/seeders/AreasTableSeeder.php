<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            // مناطق محافظة مسقط
            ['name_ar' => 'مسقط', 'name_en' => 'Muscat', 'city_id' => 1],
            ['name_ar' => 'مطرح', 'name_en' => 'Muttrah', 'city_id' => 1],
            ['name_ar' => 'العامرات', 'name_en' => 'Al Amarat', 'city_id' => 1],
            ['name_ar' => 'بوشر', 'name_en' => 'Bawshar', 'city_id' => 1],
            ['name_ar' => 'السيب', 'name_en' => 'Seeb', 'city_id' => 1],
            ['name_ar' => 'قريات', 'name_en' => 'Qurayyat', 'city_id' => 1],

            // مناطق محافظة ظفار
            ['name_ar' => 'صلالة', 'name_en' => 'Salalah', 'city_id' => 2],
            ['name_ar' => 'طاقة', 'name_en' => 'Taqah', 'city_id' => 2],
            ['name_ar' => 'مرباط', 'name_en' => 'Mirbat', 'city_id' => 2],
            ['name_ar' => 'رخيوت', 'name_en' => 'Rakhyut', 'city_id' => 2],
            ['name_ar' => 'ثمريت', 'name_en' => 'Thumrait', 'city_id' => 2],
            ['name_ar' => 'ضلكوت', 'name_en' => 'Dalkut', 'city_id' => 2],
            ['name_ar' => 'المزيونة', 'name_en' => 'Al Mazyunah', 'city_id' => 2],
            ['name_ar' => 'مقشن', 'name_en' => 'Muqshin', 'city_id' => 2],
            ['name_ar' => 'شليم وجزر الحلانيات', 'name_en' => 'Shalim and the Hallaniyat Islands', 'city_id' => 2],
            ['name_ar' => 'سدح', 'name_en' => 'Sadah', 'city_id' => 2],

            // مناطق محافظة مسندم
            ['name_ar' => 'خصب', 'name_en' => 'Khasab', 'city_id' => 3],
            ['name_ar' => 'دبا', 'name_en' => 'Daba', 'city_id' => 3],
            ['name_ar' => 'بخاء', 'name_en' => 'Bukha', 'city_id' => 3],
            ['name_ar' => 'مدحاء', 'name_en' => 'Madha', 'city_id' => 3],

            // مناطق محافظة البريمي
            ['name_ar' => 'البريمي', 'name_en' => 'Al Buraimi', 'city_id' => 4],
            ['name_ar' => 'محضة', 'name_en' => 'Mahdha', 'city_id' => 4],
            ['name_ar' => 'السنينة', 'name_en' => 'As Sunaynah', 'city_id' => 4],

            // مناطق محافظة الداخلية
            ['name_ar' => 'نزوى', 'name_en' => 'Nizwa', 'city_id' => 5],
            ['name_ar' => 'بهلاء', 'name_en' => 'Bahla', 'city_id' => 5],
            ['name_ar' => 'منح', 'name_en' => 'Manah', 'city_id' => 5],
            ['name_ar' => 'الحمراء', 'name_en' => 'Al Hamra', 'city_id' => 5],
            ['name_ar' => 'أدم', 'name_en' => 'Adam', 'city_id' => 5],
            ['name_ar' => 'إزكي', 'name_en' => 'Izki', 'city_id' => 5],
            ['name_ar' => 'سمائل', 'name_en' => 'Samail', 'city_id' => 5],
            ['name_ar' => 'بدبد', 'name_en' => 'Bidbid', 'city_id' => 5],
            ['name_ar' => 'الجبل الأخضر', 'name_en' => 'Al Jabal Al Akhdar', 'city_id' => 5],

            // مناطق محافظة شمال الباطنة
            ['name_ar' => 'صحار', 'name_en' => 'Sohar', 'city_id' => 6],
            ['name_ar' => 'شناص', 'name_en' => 'Shinas', 'city_id' => 6],
            ['name_ar' => 'لوى', 'name_en' => 'Liwa', 'city_id' => 6],
            ['name_ar' => 'صحم', 'name_en' => 'Saham', 'city_id' => 6],
            ['name_ar' => 'الخابورة', 'name_en' => 'Al Khaboura', 'city_id' => 6],
            ['name_ar' => 'السويق', 'name_en' => 'As Suwaiq', 'city_id' => 6],

            // مناطق محافظة جنوب الباطنة
            ['name_ar' => 'الرستاق', 'name_en' => 'Rustaq', 'city_id' => 7],
            ['name_ar' => 'العوابي', 'name_en' => 'Al Awabi', 'city_id' => 7],
            ['name_ar' => 'نخل', 'name_en' => 'Nakhal', 'city_id' => 7],
            ['name_ar' => 'وادي المعاول', 'name_en' => 'Wadi Al Maawil', 'city_id' => 7],
            ['name_ar' => 'بركاء', 'name_en' => 'Barka', 'city_id' => 7],
            ['name_ar' => 'المصنعة', 'name_en' => 'Al Musannah', 'city_id' => 7],

            // مناطق   الوسطي
            ['name_ar' => 'هيما', 'name_en' => 'Haima', 'city_id' => 8],
            ['name_ar' => 'محوت', 'name_en' => 'Mahout', 'city_id' => 8],
            ['name_ar' => 'الدقم', 'name_en' => 'Duqm', 'city_id' => 8],
            ['name_ar' => 'الجازر', 'name_en' => 'Jazer', 'city_id' => 8],


            // مناطق محافظة شمال الشرقية
            ['name_ar' => 'إبراء', 'name_en' => 'Ibra', 'city_id' => 9],
            ['name_ar' => 'المضيبي', 'name_en' => 'Al Mudhaibi', 'city_id' => 9],
            ['name_ar' => 'بدية', 'name_en' => 'Bidiyah', 'city_id' => 9],
            ['name_ar' => 'القابل', 'name_en' => 'Al Qabil', 'city_id' => 9],
            ['name_ar' => 'وادي بني خالد', 'name_en' => 'Wadi Bani Khalid', 'city_id' => 9],
            ['name_ar' => 'دماء والطائيين', 'name_en' => 'Dima Wa At Taiyyin', 'city_id' => 9],

            // مناطق محافظة جنوب الشرقية
            ['name_ar' => 'صور', 'name_en' => 'Sur', 'city_id' => 10],
            ['name_ar' => 'جعلان بني بو علي', 'name_en' => 'Jalan Bani Bu Ali', 'city_id' => 10],
            ['name_ar' => 'جعلان بني بو حسن', 'name_en' => 'Jalan Bani Bu Hassan', 'city_id' => 10],
            ['name_ar' => 'الكامل والوافي', 'name_en' => 'Al Kamil Wal Wafi', 'city_id' => 10],
            ['name_ar' => 'مصيرة', 'name_en' => 'Masirah', 'city_id' => 10],
            ['name_ar' => 'المنطقة الوسطى', 'name_en' => 'Al Wusta', 'city_id' => 10],

            // مناطق محافظة الظاهرة
            ['name_ar' => 'عبري', 'name_en' => 'Ibri', 'city_id' => 11],
            ['name_ar' => 'ينقل', 'name_en' => 'Yanqul', 'city_id' => 11],
            ['name_ar' => 'ضنك', 'name_en' => 'Dakhiliyah', 'city_id' => 11],
            ['name_ar' => 'البريمي', 'name_en' => 'Buraimi', 'city_id' => 11],
            ['name_ar' => 'محضة', 'name_en' => 'Mahdha', 'city_id' => 11],
            ['name_ar' => 'السنينة', 'name_en' => 'As Sunaynah', 'city_id' => 11],
        ];
        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
