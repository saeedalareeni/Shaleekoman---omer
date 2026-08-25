<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// الحصول على الإشعارات للمالك 4
$currentOwnerId = 4;
$ownerNotifications = \App\Models\Notification::where('owner_id', $currentOwnerId)
    ->where('is_read', false)
    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get();

echo "عدد الإشعارات غير المقروءة: " . $ownerNotifications->count() . "\n\n";

foreach ($ownerNotifications as $notification) {
    echo "=================================\n";
    echo "إشعار #{$notification->id}:\n";
    echo "العنوان: {$notification->title_ar}\n";
    echo "النوع: {$notification->type}\n";
    
    $data = $notification->data;
    echo "\nالبيانات (data field):\n";
    echo "نوع البيانات: " . gettype($data) . "\n";
    
    if (is_array($data)) {
        echo "عدد العناصر: " . count($data) . "\n";
        if (count($data) > 0) {
            echo "المحتويات:\n";
            foreach ($data as $key => $value) {
                echo "  - {$key}: {$value}\n";
            }
        }
    } else {
        echo "البيانات ليست مصفوفة!\n";
        var_dump($data);
    }
    
    echo "\n";
}
