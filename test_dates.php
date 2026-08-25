<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// اختبار إضافة التواريخ لآخر حجز
$booking = \App\Models\Booking::latest()->first();
if ($booking && $booking->dates()->count() == 0) {
    echo "Adding dates for booking: " . $booking->booking_number . "\n";
    
    // إضافة التواريخ بناءً على checkin_date و checkout_date
    if ($booking->checkin_date && $booking->checkout_date) {
        $checkin = \Carbon\Carbon::parse($booking->checkin_date);
        $checkout = \Carbon\Carbon::parse($booking->checkout_date);
        
        echo "Checkin: " . $checkin->format('Y-m-d') . "\n";
        echo "Checkout: " . $checkout->format('Y-m-d') . "\n";
        
        $count = 0;
        while ($checkin->lt($checkout)) {
            $booking->dates()->create([
                'date' => $checkin->format('Y-m-d'),
                'price' => $booking->price_per_night ?? 100
            ]);
            echo "Added date: " . $checkin->format('Y-m-d') . "\n";
            $checkin->addDay();
            $count++;
        }
        
        echo "Total dates added: " . $count . "\n";
    } else {
        echo "No checkin/checkout dates found\n";
    }
} else {
    echo "Booking already has dates or no booking found\n";
}
