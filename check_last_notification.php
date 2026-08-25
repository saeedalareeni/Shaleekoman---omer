<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// الحصول على آخر إشعار للمالك 4
$lastNotification = \App\Models\Notification::where('owner_id', 4)
    ->orderBy('id', 'desc')
    ->first();

if ($lastNotification) {
    echo "آخر إشعار:\n";
    echo "ID: " . $lastNotification->id . "\n";
    echo "Title AR: " . $lastNotification->title_ar . "\n";
    echo "Message AR: " . $lastNotification->message_ar . "\n";
    echo "Type: " . $lastNotification->type . "\n";
    echo "Created: " . $lastNotification->created_at . "\n";
    echo "\nData field:\n";
    
    $data = $lastNotification->data;
    if (is_array($data)) {
        echo "Data is array with " . count($data) . " items:\n";
        foreach ($data as $key => $value) {
            echo "  - $key: $value\n";
        }
    } else if (is_string($data)) {
        echo "Data is string: $data\n";
        $decoded = json_decode($data, true);
        if ($decoded) {
            echo "Decoded data:\n";
            foreach ($decoded as $key => $value) {
                echo "  - $key: $value\n";
            }
        }
    } else if (is_null($data)) {
        echo "Data is NULL\n";
    } else {
        echo "Data type: " . gettype($data) . "\n";
        echo "Data value: " . var_export($data, true) . "\n";
    }
    
    echo "\nFull record as JSON:\n";
    echo json_encode($lastNotification->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
} else {
    echo "لا توجد إشعارات للمالك 4\n";
}
