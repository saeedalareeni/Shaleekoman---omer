<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('owners')->insert([
            [
                'name' => 'أحمد محمد',
                'phone' => '1234567890',
                'email' => 'ahmed@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'address' => '--',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'خالد عبدالله',
                'phone' => '0987654321',
                'email' => 'khaled@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'address' => '--',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
