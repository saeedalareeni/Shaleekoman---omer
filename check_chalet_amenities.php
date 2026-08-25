<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Chalet;

// Find the chalet by slug
$slug = 'mokeam-2';
$chalet = Chalet::where('slug', $slug)->first();

if ($chalet) {
    echo "Chalet found: " . $chalet->chalet_name_en . "\n";
    echo "Amenities field type: " . gettype($chalet->amenities) . "\n";
    echo "Amenities raw value: ";
    var_dump($chalet->amenities);
    
    // Check the raw database value
    $rawChalet = \DB::table('chalets')->where('slug', $slug)->first();
    echo "\nRaw amenities from DB: ";
    var_dump($rawChalet->amenities);
    
    // Try to decode if it's a string
    if (is_string($rawChalet->amenities)) {
        echo "\nTrying to decode as JSON: ";
        $decoded = json_decode($rawChalet->amenities, true);
        var_dump($decoded);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON decode error: " . json_last_error_msg() . "\n";
        }
    }
} else {
    echo "Chalet with slug '$slug' not found.\n";
}
