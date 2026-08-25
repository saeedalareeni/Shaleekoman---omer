<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$chalet = \App\Models\Chalet::find(73);
if ($chalet) {
    echo "Chalet Name: " . $chalet->name . "\n";
    echo "Chalet Name AR: " . $chalet->chalet_name_ar . "\n";
    echo "Owner ID: " . $chalet->owner_id . "\n";
    
    if ($chalet->owner) {
        echo "Owner Name: " . $chalet->owner->name . "\n";
        echo "Owner Email: " . $chalet->owner->email . "\n";
    } else {
        echo "No owner associated with this chalet\n";
    }
} else {
    echo "Chalet not found\n";
}

// Check notifications for owner 4
$owner4Notifications = \App\Models\Notification::where('owner_id', 4)->orderBy('id', 'desc')->take(5)->get();
echo "\nNotifications for Owner 4:\n";
if ($owner4Notifications->count() > 0) {
    foreach ($owner4Notifications as $notification) {
        echo "ID: " . $notification->id . "\n";
        echo "Title AR: " . $notification->title_ar . "\n";
        echo "Title EN: " . $notification->title_en . "\n";
        echo "Message AR: " . substr($notification->message_ar, 0, 100) . "...\n";
        echo "Message EN: " . substr($notification->message_en, 0, 100) . "...\n";
        echo "Type: " . $notification->type . "\n";
        echo "Data: " . $notification->data . "\n";
        echo "Created: " . $notification->created_at . "\n";
        echo "-------------------\n";
    }
} else {
    echo "No notifications found for Owner 4\n";
}

// Check all notifications
$notifications = \App\Models\Notification::orderBy('id', 'desc')->take(5)->get();
echo "\nLast 5 notifications (all owners):\n";
foreach ($notifications as $notification) {
    echo "ID: " . $notification->id . ", Owner ID: " . $notification->owner_id . ", Title: " . $notification->title_ar . "\n";
}
