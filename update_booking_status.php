<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// تحديث حالة جميع الحجوزات القديمة
$bookings = \App\Models\Booking::whereNull('status')->orWhere('status', '')->get();

echo "Found " . $bookings->count() . " bookings without proper status\n";

foreach ($bookings as $booking) {
    // تحديد الحالة بناءً على payment_status
    if ($booking->payment_status == 'paid') {
        $booking->status = 'confirmed';
    } elseif ($booking->payment_status == 'unpaid') {
        $booking->status = 'pending';
    } else {
        $booking->status = 'new';
    }
    
    $booking->save();
    echo "Updated booking {$booking->booking_number} to status: {$booking->status}\n";
}

echo "Done!\n";
