<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// تحديث الحجوزات القديمة التي لا تحتوي على حالة
$bookings = \App\Models\Booking::whereNull('status')->get();
foreach ($bookings as $booking) {
    if ($booking->payment_status == 'paid') {
        $booking->status = 'confirmed';
    } else {
        $booking->status = 'pending';
    }
    $booking->save();
    echo "Updated booking {$booking->booking_number} to status: {$booking->status}\n";
}

echo "Total bookings updated: " . $bookings->count() . "\n";
