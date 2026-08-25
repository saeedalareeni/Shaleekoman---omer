<?php

namespace Database\Seeders;

use App\Models\Payment_method;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{

    public function run()
    {
        Payment_method::create([
            'name_ar' => 'الدفع بالبطاقة ',
            'name_en' => 'Card payment',
            'logo' => 'images/paymentMethods/thawani.jpg',
            'is_active' => true,
            'publish_key' => 'HGvTMLDssJghr9tlN9gr4DVYt0qyBy',
            'secret_key' => 'rRQ26GcsZzoEhbrP2HZvLYDbn9C9et',
        ]);

        Payment_method::create([
            'name_ar' => ' دفع عربون ',
            'name_en' => 'Advance amount',
            'is_active' => true,
        ]);

        Payment_method::create([
            'name_ar' => ' الدفع عند الاستراحة ',
            'name_en' => 'Payment at break',
            'is_active' => true,
        ]);

    }
}
