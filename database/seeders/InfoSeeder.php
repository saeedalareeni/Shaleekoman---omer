<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('infos')->insert([
            'name_ar' => ' تصميم  ',
            'name_en' => 'Designing  ',
            'icon' => 'flaticon-sketch',
            'body_ar' => ' تصميم الواجهات المتلائمة المتناسبة مع جميع الشاشات بافضل اللغات البرمجية الحديثة  ',
            'body_en' => ' Designing compatible interfaces to fit all screens using the best modern programming languages  ',
        ]);
        DB::table('infos')->insert([
            'name_ar' => ' تطوير  ',
            'name_en' => 'Development ',
            'icon' => 'flaticon-vector',
            'body_ar' => ' تطوير الواجهات المتلائمة المتناسبة مع جميع الشاشات بافضل اللغات البرمجية الحديثة  ',
            'body_en' => ' Designing compatible interfaces to fit all screens using the best modern programming languages  ',
        ]);

        DB::table('infos')->insert([
            'name_ar' => ' إطلاق',
            'name_en' => 'Launching ',
            'icon' => 'flaticon-startup',
            'body_ar' => ' اطلق الواجهات المتلائمة المتناسبة مع جميع الشاشات بافضل اللغات البرمجية الحديثة  ',
            'body_en' => ' Designing compatible interfaces to fit all screens using the best modern programming languages  ',
        ]);

    }
}
