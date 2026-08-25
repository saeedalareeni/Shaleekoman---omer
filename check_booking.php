<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$booking = \App\Models\Booking::latest()->first();
if ($booking) {
    echo "Booking Number: " . $booking->booking_number . "\n";
    echo "Status: " . $booking->status . "\n";
    echo "Payment Status: " . $booking->payment_status . "\n";
    echo "Payment Method: " . $booking->payment_method . "\n";
    echo "Dates Count: " . $booking->dates()->count() . "\n";
} else {
    echo "No bookings found\n";
}
