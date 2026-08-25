<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// فحص آخر 10 حجوزات
$bookings = \App\Models\Booking::latest()->take(10)->get(['id', 'booking_number', 'email']);

echo "Latest 10 bookings:\n";
foreach ($bookings as $booking) {
    echo "ID: {$booking->id}, Number: {$booking->booking_number}, Email: {$booking->email}\n";
}

// البحث عن إيميلات تحتوي على رموز خاصة
$problematicBookings = \App\Models\Booking::whereNotNull('email')
    ->where('email', 'LIKE', '%@gmail.com%')
    ->latest()
    ->take(5)
    ->get(['id', 'booking_number', 'email']);

echo "\nBookings with gmail:\n";
foreach ($problematicBookings as $booking) {
    echo "ID: {$booking->id}, Email: {$booking->email}\n";
    // تحقق من وجود رموز HTML
    if ($booking->email != htmlspecialchars($booking->email)) {
        echo "  WARNING: Email contains special characters!\n";
    }
}
