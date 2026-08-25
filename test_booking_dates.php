<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// فحص آخر 5 حجوزات
$bookings = \App\Models\Booking::with('dates')->latest()->take(5)->get();

foreach ($bookings as $booking) {
    echo "Booking: {$booking->booking_number}\n";
    echo "  Status: {$booking->status}\n";
    echo "  Payment Method: {$booking->payment_method}\n";
    echo "  Checkin: {$booking->checkin_date}\n";
    echo "  Checkout: {$booking->checkout_date}\n";
    echo "  Total Nights: {$booking->total_nights}\n";
    echo "  Dates Count: " . $booking->dates->count() . "\n";
    
    if ($booking->dates->count() > 0) {
        echo "  Dates:\n";
        foreach ($booking->dates as $date) {
            echo "    - {$date->date} (Price: {$date->price})\n";
        }
    }
    echo "\n";
}
