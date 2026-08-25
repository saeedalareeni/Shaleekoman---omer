<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{

    public function run()
    {

        DB::table('settings')->insert([
            'logo' => 'logo.png',
            'header' => 'header.png',
            'footer' => 'footer.png',
            'stamp' => 'stamp.png',
            'company_name_ar' => 'اسم الشركة بالعربية',
            'company_name_en' => 'Company Name in English',
            'cr_no' => '123456',
            'address_ar' => 'العنوان بالعربية',
            'address_en' => 'Address in English',
            'email' => 'example@company.com',
            'phone' => '1234567890',
            'tax_no' => 'TAX123456',
            'tax' => 5.00,
            'advance_amount' => 40,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
