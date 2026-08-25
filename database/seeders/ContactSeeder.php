<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{

    public function run()
    {
        DB::table('contacts')->insert([
            'address_ar' => 'سلطنة عمان - مسقط',
            'address_en' => 'Sultanate of Oman - muscat',
            'map' => ' <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3655.085703412691!2d58.205278915383325!3d23.63710159901094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e8dfce42fb582b9%3A0x28534a8e58d7bc03!2sMazoon%20Company%20Advertising!5e0!3m2!1sen!2som!4v1652127028086!5m2!1sen!2som" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> ',
            'email' => 'email@email.com',
            'phone' => '96897091987',
            'whatsapp' => '96897091987',
            'facebook_url' => '#',
            'instagram_url' => '#',
            'twitter_url' => '#',
            'youtube_url' => '#',
            'linkedin_url' => '#',
        ]);
    }
}
