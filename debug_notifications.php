<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// الحصول على آخر 5 إشعارات للمالك 4
$notifications = \App\Models\Notification::where('owner_id', 4)
    ->orderBy('id', 'desc')
    ->take(5)
    ->get();

echo "تحليل الإشعارات للمالك 4:\n";
echo "========================\n\n";

foreach ($notifications as $notification) {
    echo "إشعار #{$notification->id}:\n";
    echo "-----------\n";
    echo "النوع: {$notification->type}\n";
    echo "العنوان: {$notification->title_ar}\n";
    
    // تحليل حقل data
    $data = $notification->data;
    echo "نوع البيانات: " . gettype($data) . "\n";
    
    if (is_array($data)) {
        echo "البيانات (array):\n";
        if (empty($data)) {
            echo "  [فارغ]\n";
        } else {
            foreach ($data as $key => $value) {
                echo "  - {$key}: {$value}\n";
            }
        }
    } elseif (is_string($data)) {
        echo "البيانات (string): {$data}\n";
        $decoded = json_decode($data, true);
        if ($decoded !== null) {
            echo "البيانات بعد فك التشفير:\n";
            foreach ($decoded as $key => $value) {
                echo "  - {$key}: {$value}\n";
            }
        }
    } elseif (is_null($data)) {
        echo "البيانات: NULL\n";
    } else {
        echo "البيانات (نوع غير متوقع): " . var_export($data, true) . "\n";
    }
    
    // تحليل الـ Model attributes
    echo "\nالخصائص الأساسية:\n";
    $attributes = $notification->getAttributes();
    echo "  - data (raw): " . substr($attributes['data'] ?? 'NULL', 0, 100) . "\n";
    
    echo "\n----------------------------\n\n";
}
