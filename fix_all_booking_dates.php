<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// إصلاح جميع الحجوزات التي لا تحتوي على تواريخ
$bookings = \App\Models\Booking::whereDoesntHave('dates')->get();

echo "Found " . $bookings->count() . " bookings without dates\n";

foreach ($bookings as $booking) {
    if ($booking->checkin_date && $booking->checkout_date) {
        $checkin = \Carbon\Carbon::parse($booking->checkin_date);
        $checkout = \Carbon\Carbon::parse($booking->checkout_date);
        
        $count = 0;
        while ($checkin->lt($checkout)) {
            $booking->dates()->create([
                'date' => $checkin->format('Y-m-d'),
                'price' => $booking->price_per_night ?? $booking->total_amount ?? 100
            ]);
            $checkin->addDay();
            $count++;
        }
        
        echo "Added {$count} dates for booking {$booking->booking_number}\n";
    }
}

echo "Done!\n";
