<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chalet;

class ChaletSeeder extends Seeder
{
    public function run()
    {
        Chalet::factory()->count(10)->create();
    }
}
