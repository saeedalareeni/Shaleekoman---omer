<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// فحص الحجوزات مع PaymentMethod
$bookings = \App\Models\Booking::with('PaymentMethod')->latest()->take(5)->get();

foreach ($bookings as $booking) {
    echo "Booking: {$booking->booking_number}\n";
    echo "  payment_method: {$booking->payment_method}\n";
    echo "  payment_method_id: {$booking->payment_method_id}\n";
    if ($booking->PaymentMethod) {
        echo "  PaymentMethod->name_ar: {$booking->PaymentMethod->name_ar}\n";
        echo "  PaymentMethod->name_en: {$booking->PaymentMethod->name_en}\n";
    } else {
        echo "  PaymentMethod: NULL\n";
    }
    echo "\n";
}
