<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            PaymentMethodSeeder::class,
            AboutSeeder::class,
            ContactSeeder::class,
            InfoSeeder::class,
            SliderSeeder::class,
            CitiesTableSeeder::class,
            AreasTableSeeder::class,
            CategoriesTableSeeder::class,
//            ChaletSeeder::class,
//            OwnersTableSeeder::class,
            BannerSeeder::class,
            PagesTableSeeder::class,
            CouponSeeder::class,
        ]);





    }
}
