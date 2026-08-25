<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Chalet;

$chalet = Chalet::where('slug', 'chalet-10-1758984757593')->first();

if ($chalet) {
    echo "Chalet found:\n";
    echo "ID: " . $chalet->id . "\n";
    echo "Name AR: " . $chalet->chalet_name_ar . "\n";
    echo "Name EN: " . $chalet->chalet_name_en . "\n";
    echo "Short Description AR: " . $chalet->short_description_ar . "\n";
    echo "Short Description EN: " . $chalet->short_description_en . "\n";
    echo "Long Description AR: " . $chalet->long_description_ar . "\n";
    echo "Long Description EN: " . $chalet->long_description_en . "\n";
    echo "Location: " . $chalet->location . "\n";
    echo "Default Day Price: " . $chalet->default_day_price . "\n";
    echo "Holiday Day Price: " . $chalet->holiday_day_price . "\n";
    echo "Half Day Price: " . $chalet->half_day_price . "\n";
    echo "Stay Price: " . $chalet->stay_price . "\n";
    echo "City ID: " . $chalet->city_id . "\n";
    echo "Area ID: " . $chalet->area_id . "\n";
    echo "Category ID: " . $chalet->category_id . "\n";
    echo "Owner ID: " . $chalet->owner_id . "\n";
    echo "Status: " . $chalet->status . "\n";
} else {
    echo "Chalet not found with slug: chalet-10-1758984757593\n";
}
