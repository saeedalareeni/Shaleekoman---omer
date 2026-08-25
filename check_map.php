<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Chalet;

$chalet = Chalet::where('slug', 'chalet-10-1758984757593')->first();

if ($chalet) {
    echo "Map Link:\n";
    echo $chalet->map_link . "\n";
} else {
    echo "Chalet not found\n";
}
