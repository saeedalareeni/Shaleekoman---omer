<?php

// app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

use App\Mail\Notify;
use App\Models\Booking;
use App\Models\Chalet;
use App\Models\ChaletPrice;
use App\Models\Coupon;
use App\Models\Payment_method;
use App\Models\Setting;
use App\Services\ThawaniPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{



   // Ø¯Ø§Ù„Ø© Ù„Ù„ØªØ­Ù‚Ù‚ Ù…Ù† ØªÙˆÙØ± Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡ ÙˆÙ…Ù†Ø¹ Ø§Ù„Ø­Ø¬Ø² Ø§Ù„Ù…ØªØ¯Ø§Ø®Ù„ Ø¬Ø²Ø¦ÙŠÙ‹Ø§
private function checkChaletAvailability($chaletId, $checkinDate, $checkoutDate, $excludeBookingId = null)
{
    // Ø­Ù…Ø§ÙŠØ© Ù…Ù† Ø§Ù„Ù‚ÙŠÙ… Ø§Ù„ÙØ§Ø±ØºØ© Ø£Ùˆ ØºÙŠØ± Ø§Ù„ØµØ§Ù„Ø­Ø©
    if (!$checkinDate || !$checkoutDate) {
        return false;
    }

    $query = Booking::where('chalet_id', $chaletId)
        ->whereIn('status', ['new', 'pending', 'confirmed'])
        ->where(function ($q) use ($checkinDate, $checkoutDate) {

            /**
             * Ù…Ù†Ø¹ Ø£ÙŠ ØªØ¯Ø§Ø®Ù„ Ø¬Ø²Ø¦ÙŠ Ø£Ùˆ ÙƒÙ„ÙŠ
             *
             * Ø§Ù„Ø­Ø§Ù„Ø© Ø§Ù„Ù…Ù…Ù†ÙˆØ¹Ø©:
             * (existing.checkin < new.checkout)
             * AND
             * (existing.checkout > new.checkin)
             */
            $q->where('checkin_date', '<', $checkoutDate)
              ->where('checkout_date', '>', $checkinDate);
        });

    // Ø§Ø³ØªØ¨Ø¹Ø§Ø¯ Ø­Ø¬Ø² Ù…Ø¹ÙŠÙ† (ÙÙŠ Ø­Ø§Ù„Ø© Ø§Ù„ØªØ¹Ø¯ÙŠÙ„)
    if ($excludeBookingId) {
        $query->where('id', '!=', $excludeBookingId);
    }

    return $query->exists();
}

    
    // Ø¯Ø§Ù„Ø© Ø¹Ø§Ù…Ø© Ù„Ù„ØªØ­Ù‚Ù‚ Ù…Ù† Ø§Ù„ØªÙˆÙØ± Ø¹Ø¨Ø± AJAX
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'chalet_id' => 'required|exists:chalets,id',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date'
        ]);
        
        $isBooked = $this->checkChaletAvailability(
            $request->chalet_id,
            $request->checkin_date,
            $request->checkout_date
        );
        
        if ($isBooked) {
            // Ø¬Ù„Ø¨ Ø§Ù„ØªÙˆØ§Ø±ÙŠØ® Ø§Ù„Ù…Ø­Ø¬ÙˆØ²Ø© Ù„Ø¹Ø±Ø¶Ù‡Ø§ Ù„Ù„Ù…Ø³ØªØ®Ø¯Ù…
            $bookedDates = Booking::where('chalet_id', $request->chalet_id)
                ->whereIn('status', ['new', 'pending', 'confirmed'])
                ->where(function($q) use ($request) {
                    $q->whereDate('checkout_date', '>', $request->checkin_date)
                      ->whereDate('checkin_date', '<', $request->checkout_date);
                })
                ->select('checkin_date', 'checkout_date', 'status')
                ->get();
            
            return response()->json([
                'available' => false,
                'message' => app()->getLocale() == 'ar' ? 
                    'Ø¹Ø°Ø±Ø§Ù‹ØŒ Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡ Ù…Ø­Ø¬ÙˆØ² ÙÙŠ Ø§Ù„ØªÙˆØ§Ø±ÙŠØ® Ø§Ù„Ù…Ø­Ø¯Ø¯Ø©. ÙŠØ±Ø¬Ù‰ Ø§Ø®ØªÙŠØ§Ø± ØªÙˆØ§Ø±ÙŠØ® Ø£Ø®Ø±Ù‰.' : 
                    'Sorry, the chalet is already booked for the selected dates. Please choose different dates.',
                'booked_dates' => $bookedDates
            ]);
        }
        
        return response()->json([
            'available' => true,
            'message' => app()->getLocale() == 'ar' ? 
                'Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡ Ù…ØªØ§Ø­ Ù„Ù„Ø­Ø¬Ø² ÙÙŠ Ø§Ù„ØªÙˆØ§Ø±ÙŠØ® Ø§Ù„Ù…Ø­Ø¯Ø¯Ø©.' : 
                'The chalet is available for booking on the selected dates.'
        ]);
    }
    
    // ØµÙØ­Ø© Ø§Ù„Ø­Ø¬Ø² Ø§Ù„Ø¬Ø¯ÙŠØ¯Ø© Ù…Ù† ØµÙØ­Ø© ØªÙØ§ØµÙŠÙ„ Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡
    public function createBooking(Request $request, $id)
    {
        $chalet = Chalet::findOrFail($id);
        
        // Ø§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† ØªÙˆÙØ± Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡ Ø£ÙˆÙ„Ø§Ù‹
        if ($this->checkChaletAvailability($id, $request->checkin_date, $request->checkout_date)) {
            return redirect()->back()->with('error', 
                app()->getLocale() == 'ar' ? 
                'Ø¹Ø°Ø±Ø§Ù‹ØŒ Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡ Ù…Ø­Ø¬ÙˆØ² ÙÙŠ Ø§Ù„ØªÙˆØ§Ø±ÙŠØ® Ø§Ù„Ù…Ø­Ø¯Ø¯Ø©. ÙŠØ±Ø¬Ù‰ Ø§Ø®ØªÙŠØ§Ø± ØªÙˆØ§Ø±ÙŠØ® Ø£Ø®Ø±Ù‰.' : 
                'Sorry, the chalet is already booked for the selected dates. Please choose different dates.'
            )->withInput();
        }
        
        $bookingType = $request->get('booking_type', 'fullDay');
        $pricePerNight = match ($bookingType) {
            'fullDay' => $chalet->default_day_price,
            'halfDay' => $chalet->half_day_price,
            'stayDay' => $chalet->stay_price,
            default => $chalet->default_day_price,
        };

        // ØªØ®Ø²ÙŠÙ† Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ø­Ø¬Ø² ÙÙŠ Ø§Ù„Ø³ÙŠØ´Ù†
        $bookingData = [
            'chalet_id' => $id,
            'checkin_date' => $request->checkin_date,
            'checkout_date' => $request->checkout_date,
            'checkin_time' => $request->checkin_time,
            'checkout_time' => $request->checkout_time,
            'number_of_guests' => $request->number_of_guests,
            'special_requests' => $request->special_requests,
            'booking_type' => $bookingType,
            'price_per_night' => $pricePerNight,
            'payment_method' => $request->payment_method ?? 'cash',
        ];
        
        // Ø­Ø³Ø§Ø¨ Ø§Ù„Ø£ÙŠØ§Ù… ÙˆØ§Ù„Ø³Ø¹Ø± Ø§Ù„Ø¥Ø¬Ù…Ø§Ù„ÙŠ
        $checkin = \Carbon\Carbon::parse($request->checkin_date);
        $checkout = \Carbon\Carbon::parse($request->checkout_date);
        $nights = $checkin->diffInDays($checkout);
        
        $bookingData['total_nights'] = $nights;
        $bookingData['subtotal'] = $nights * $pricePerNight;
        $bookingData['service_fee'] = $bookingData['subtotal'] * 0.05; // 5% Ø±Ø³ÙˆÙ… Ø®Ø¯Ù…Ø©
        $bookingData['vat'] = $bookingData['subtotal'] * 0.15; // 15% Ø¶Ø±ÙŠØ¨Ø©
        $bookingData['total_price'] = $bookingData['subtotal'] + $bookingData['service_fee'] + $bookingData['vat'];
        
        // Ø§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† ØªØ³Ø¬ÙŠÙ„ Ø§Ù„Ø¯Ø®ÙˆÙ„
        if (!auth('customer')->check()) {
            session(['pending_booking' => $bookingData]);
            // Ø­ÙØ¸ Ø§Ù„Ø±Ø§Ø¨Ø· Ù„Ù„Ø¹ÙˆØ¯Ø© Ø¥Ù„ÙŠÙ‡ Ø¨Ø¹Ø¯ ØªØ³Ø¬ÙŠÙ„ Ø§Ù„Ø¯Ø®ÙˆÙ„
            session(['url.intended' => route('booking.confirm')]);
            return redirect()->route('login')->with('message', 'ÙŠØ±Ø¬Ù‰ ØªØ³Ø¬ÙŠÙ„ Ø§Ù„Ø¯Ø®ÙˆÙ„ Ù„Ø¥ØªÙ…Ø§Ù… Ø¹Ù…Ù„ÙŠØ© Ø§Ù„Ø­Ø¬Ø²');
        }
        
        // ØªØ®Ø²ÙŠÙ† Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ø­Ø¬Ø² ÙÙŠ Ø§Ù„Ø³ÙŠØ´Ù† ÙˆØ§Ù„ØªÙˆØ¬ÙŠÙ‡ Ø¥Ù„Ù‰ ØµÙØ­Ø© Ø§Ù„ØªØ£ÙƒÙŠØ¯
        session(['pending_booking' => $bookingData]);
        session()->save(); // ÙØ±Ø¶ Ø­ÙØ¸ Ø§Ù„Ø³ÙŠØ´Ù†
        
        \Log::info('Session saved with booking data', ['session_id' => session()->getId()]);
        
        // Ø§Ù„ØªÙˆØ¬ÙŠÙ‡ Ø¥Ù„Ù‰ ØµÙØ­Ø© ØªØ£ÙƒÙŠØ¯ Ø§Ù„Ø­Ø¬Ø²
        return redirect()->route('booking.confirm')->with('booking_data_saved', true);
    }
    
    // ØµÙØ­Ø© ØªØ£ÙƒÙŠØ¯ Ø§Ù„Ø­Ø¬Ø²
    public function confirmBookingPage()
    {
        \Log::info('=== confirmBookingPage START ===');
        \Log::info('Session ID:', ['session_id' => session()->getId()]);
        \Log::info('All session data:', session()->all());
        
        if (!auth()->check()) {
            \Log::warning('User not authenticated in confirmBookingPage');
            return redirect()->route('login');
        }
        
        $bookingData = session('pending_booking');
        \Log::info('Booking data from session:', ['bookingData' => $bookingData]);
        
        if (!$bookingData) {
            \Log::error('No booking data found in session');
            return redirect()->route('shaleek.home')->with('error', 'Ù„Ø§ ØªÙˆØ¬Ø¯ Ø¨ÙŠØ§Ù†Ø§Øª Ø­Ø¬Ø². ÙŠØ±Ø¬Ù‰ Ø§Ù„Ø¨Ø¯Ø¡ Ù…Ù† Ø¬Ø¯ÙŠØ¯.');
        }
        
        $chalet = Chalet::findOrFail($bookingData['chalet_id']);
        
        return view('frontend.pages.booking.confirm', compact('bookingData', 'chalet'));
    }
    
    // ØµÙØ­Ø© ØªØ£ÙƒÙŠØ¯ Ø­Ø¬Ø² Ù…ÙˆØ¬ÙˆØ¯
    public function confirmExistingBooking($booking_number)
    {
        if (!auth('customer')->check()) {
            return redirect()->route('login');
        }
        
        // Ø§Ù„Ø¨Ø­Ø« Ø¹Ù† Ø§Ù„Ø­Ø¬Ø²
        $booking = Booking::where('booking_number', $booking_number)
                         ->where(function($query) {
                             $query->where('customer_id', auth('customer')->id())
                                   ->orWhere('user_id', auth('customer')->id());
                         })
                         ->firstOrFail();
        
        // Ø§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† Ø£Ù† Ø§Ù„Ø­Ø¬Ø² ÙŠØ­ØªØ§Ø¬ ØªØ£ÙƒÙŠØ¯
        if (!in_array($booking->status, ['new', 'pending'])) {
            return redirect()->route('account.orders')->with('info', 'Ù‡Ø°Ø§ Ø§Ù„Ø­Ø¬Ø² Ù…Ø¤ÙƒØ¯ Ø¨Ø§Ù„ÙØ¹Ù„ Ø£Ùˆ ØªÙ… Ø¥Ù„ØºØ§Ø¤Ù‡');
        }
        
        // Ø­Ø³Ø§Ø¨ Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ù…Ø§Ù„ÙŠØ©
        $total_nights = $booking->checkin_date->diffInDays($booking->checkout_date);
        $price_per_night = $booking->price_per_night ?? $booking->chalet->default_day_price ?? 100;
        $subtotal = $booking->subtotal ?? ($price_per_night * $total_nights);
        $service_fee = $booking->service_fee ?? ($subtotal * 0.05);
        $vat = $booking->vat ?? (($subtotal + $service_fee) * 0.15);
        $total = $booking->total_amount ?? ($subtotal + $service_fee + $vat);
        
        // ØªØ­Ø¶ÙŠØ± Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ø­Ø¬Ø² Ù„Ù„Ø¹Ø±Ø¶
        $bookingData = [
            'chalet_id' => $booking->chalet_id,
            'checkin_date' => $booking->checkin_date->format('Y-m-d'),
            'checkout_date' => $booking->checkout_date->format('Y-m-d'),
            'checkin_time' => $booking->checkin_time ?? '15:00',
            'checkout_time' => $booking->checkout_time ?? '08:00',
            'number_of_guests' => $booking->number_of_guests ?? 2,
            'special_requests' => $booking->special_requests ?? '',
            'total_nights' => $total_nights,
            'price_per_night' => $price_per_night,
            'subtotal' => $subtotal,
            'service_fee' => $service_fee,
            'vat' => $vat,
            'total_price' => $total,
            'booking_number' => $booking->booking_number,
            'existing_booking' => true
        ];
        
        $chalet = $booking->chalet;
        
        return view('frontend.pages.booking.confirm', compact('bookingData', 'chalet', 'booking'));
    }
    
    // ØªØ­Ø¯ÙŠØ« Ø­Ø§Ù„Ø© Ø§Ù„Ø­Ø¬Ø²
    public function updateBookingStatus(Request $request, $booking_number)
    {
        if (!auth('customer')->check()) {
            return redirect()->route('login');
        }
        
        // Ø§Ù„Ø¨Ø­Ø« Ø¹Ù† Ø§Ù„Ø­Ø¬Ø²
        $booking = Booking::where('booking_number', $booking_number)
                         ->where(function($query) {
                             $query->where('customer_id', auth('customer')->id())
                                   ->orWhere('user_id', auth('customer')->id());
                         })
                         ->firstOrFail();
        
        // ØªØ­Ø¯ÙŠØ« Ø­Ø§Ù„Ø© Ø§Ù„Ø­Ø¬Ø²
        $booking->status = $request->status ?? 'confirmed';
        $booking->payment_method = $request->payment_method ?? 'cash';
        $booking->save();
        
        return redirect()->route('account.orders')->with('success', 
            app()->getLocale() == 'ar' ? 
            'ØªÙ… ØªØ£ÙƒÙŠØ¯ Ø§Ù„Ø­Ø¬Ø² Ø¨Ù†Ø¬Ø§Ø­! Ø±Ù‚Ù… Ø§Ù„Ø­Ø¬Ø²: ' . $booking_number : 
            'Booking confirmed successfully! Booking number: ' . $booking_number
        );
    }
    
    // Ø­ÙØ¸ Ø§Ù„Ø­Ø¬Ø² Ø§Ù„Ù†Ù‡Ø§Ø¦ÙŠ
    public function storeNewBooking(Request $request)
    {
        \Log::info('=== storeNewBooking START ===');
        \Log::info('Request data:', $request->all());
        \Log::info('Session data:', ['pending_booking' => session('pending_booking')]);
        \Log::info('Auth check:', ['authenticated' => auth('customer')->check()]);
        
        if (!auth('customer')->check()) {
            \Log::warning('User not authenticated');
            return redirect()->route('login')->with('error', 'ÙŠØ¬Ø¨ ØªØ³Ø¬ÙŠÙ„ Ø§Ù„Ø¯Ø®ÙˆÙ„ Ø£ÙˆÙ„Ø§Ù‹');
        }
        
        // Ø§Ø³ØªØ®Ø¯Ù… Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ù…Ù† Ø§Ù„ÙÙˆØ±Ù… Ù…Ø¨Ø§Ø´Ø±Ø©
        if ($request->has('chalet_id')) {
            \Log::info('Using form data directly');
            
            // Ø§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† ØªÙˆÙØ± Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡ Ù‚Ø¨Ù„ Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ø­Ø¬Ø²
            if ($this->checkChaletAvailability($request->chalet_id, $request->checkin_date, $request->checkout_date)) {
                return redirect()->back()->with('error', 
                    app()->getLocale() == 'ar' ? 
                    'Ø¹Ø°Ø±Ø§Ù‹ØŒ Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡ Ù…Ø­Ø¬ÙˆØ² ÙÙŠ Ø§Ù„ØªÙˆØ§Ø±ÙŠØ® Ø§Ù„Ù…Ø­Ø¯Ø¯Ø©. ÙŠØ±Ø¬Ù‰ Ø§Ø®ØªÙŠØ§Ø± ØªÙˆØ§Ø±ÙŠØ® Ø£Ø®Ø±Ù‰.' : 
                    'Sorry, the chalet is already booked for the selected dates. Please choose different dates.'
                )->withInput();
            }
            
            $bookingData = [
                'chalet_id' => $request->chalet_id,
                'checkin_date' => $request->checkin_date,
                'checkout_date' => $request->checkout_date,
                'checkin_time' => $request->checkin_time ?? '15:00',
                'checkout_time' => $request->checkout_time ?? '08:00',
                'number_of_guests' => $request->number_of_guests ?? 2,
                'special_requests' => $request->special_requests ?? '',
                'total_nights' => $request->total_nights,
                'price_per_night' => $request->price_per_night,
                'subtotal' => $request->subtotal,
                'service_fee' => $request->service_fee,
                'vat' => $request->vat,
                'total_price' => $request->total_price,
                'payment_method' => $request->payment_method ?? 'cash'
            ];
        } else {
            // Ø§Ù„Ø¨Ø­Ø« Ø¹Ù† Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª ÙÙŠ Ø§Ù„Ø³ÙŠØ´Ù† ÙƒØ®ÙŠØ§Ø± Ø«Ø§Ù†ÙˆÙŠ
            \Log::info('Trying to use session data');
            $bookingData = session('pending_booking');
        }
        
        \Log::info('Final booking data', ['bookingData' => $bookingData]);
        
        if (!$bookingData || !isset($bookingData['chalet_id'])) {
            \Log::error('No valid booking data available');
            return redirect()->route('shaleek.home')->with('error', 'Ù„Ø§ ØªÙˆØ¬Ø¯ Ø¨ÙŠØ§Ù†Ø§Øª Ø­Ø¬Ø² ØµØ­ÙŠØ­Ø©. ÙŠØ±Ø¬Ù‰ Ø§Ù„Ù…Ø­Ø§ÙˆÙ„Ø© Ù…Ø±Ø© Ø£Ø®Ø±Ù‰.');
        }
        
        // Ø¥Ø¶Ø§ÙØ© Ø·Ø±ÙŠÙ‚Ø© Ø§Ù„Ø¯ÙØ¹ Ù…Ù† Ø§Ù„ÙÙˆØ±Ù…
        $bookingData['payment_method'] = $request->payment_method ?? $bookingData['payment_method'] ?? 'cash';
        
        try {
            \DB::beginTransaction();
            
            // Generate unique booking number
            $bookingNumber = 'BK-' . date('Ymd') . '-' . rand(1000, 9999);
            
            \Log::info('Creating booking with data', [
                'booking_number' => $bookingNumber,
                'chalet_id' => $bookingData['chalet_id'],
                'customer_id' => auth('customer')->id()
            ]);

            // Ø£ÙˆÙ‚Ø§Øª Ø§Ù„Ø­Ø¬Ø² ÙŠØ­Ø¯Ø¯Ù‡Ø§ ØµØ§Ø­Ø¨ Ø§Ù„Ø¹Ù‚Ø§Ø± ÙÙ‚Ø· â€” Ø§Ø³ØªØ®Ø¯Ø§Ù… Ø£ÙˆÙ‚Ø§Øª Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡ Ø¹Ù†Ø¯ Ø¹Ø¯Ù… ÙˆØ¬ÙˆØ¯Ù‡Ø§ ÙÙŠ Ø§Ù„Ø·Ù„Ø¨
            $chaletForTimes = Chalet::find($bookingData['chalet_id']);
            $checkinTime = $bookingData['checkin_time'] ?? $chaletForTimes->check_in_time ?? '15:00';
            $checkoutTime = $bookingData['checkout_time'] ?? $chaletForTimes->check_out_time ?? '08:00';
            
            // Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ø­Ø¬Ø²
            $booking = Booking::create([
                // user_id Ù…Ø±ØªØ¨Ø· Ø¨Ø¬Ø¯ÙˆÙ„ usersØŒ Ø¨ÙŠÙ†Ù…Ø§ Ø§Ù„Ø¹Ù…ÙŠÙ„ Ù…Ø³Ø¬Ù„ Ø¹Ø¨Ø± auth:customer
                // Ù„Ø°Ù„Ùƒ Ù†Ø®Ù„ÙŠÙ‡ null Ù„ØªØ¬Ù†Ø¨ ÙƒØ³Ø± FKØŒ ÙˆÙ†Ø³ØªØ®Ø¯Ù… customer_id Ù„Ù„Ø±Ø¨Ø· Ø§Ù„ØµØ­ÙŠØ­
                'user_id' => null,
                'customer_id' => auth('customer')->id(),
                'chalet_id' => $bookingData['chalet_id'],
                'booking_number' => $bookingNumber,
                'slug' => $bookingNumber,
                'customer_name' => auth('customer')->user()->name,
                'phone_number' => auth('customer')->user()->phone ?? '',
                'email' => auth('customer')->user()->email,
                'checkin_date' => $bookingData['checkin_date'],
                'checkout_date' => $bookingData['checkout_date'],
                'checkin_time' => $checkinTime,
                'checkout_time' => $checkoutTime,
                'number_of_guests' => $bookingData['number_of_guests'] ?? 2,
                'price_per_night' => $bookingData['price_per_night'],
                'total_nights' => $bookingData['total_nights'],
                'subtotal' => $bookingData['subtotal'],
                'service_fee' => $bookingData['service_fee'],
                'vat' => $bookingData['vat'],
                'total_amount' => $bookingData['total_price'],
                'status' => 'pending', // Ø­Ø§Ù„Ø© Ù…Ø¹Ù„Ù‚Ø© Ø­ØªÙ‰ ÙŠØªÙ… Ø§Ù„Ø¯ÙØ¹
                'payment_status' => 'unpaid',
                'payment_method_id' => $bookingData['payment_method_id'] ?? null,
                'payment_method' => $bookingData['payment_method'] ?? 'cash',
                'special_requests' => !empty($bookingData['special_requests']) ? $bookingData['special_requests'] : null,
                'message' => !empty($bookingData['special_requests']) ? $bookingData['special_requests'] : null,
                'booking_type' => 'fullDay', // Ø§Ø³ØªØ®Ø¯Ø§Ù… Ù‚ÙŠÙ…Ø© ØµØ­ÙŠØ­Ø© Ù„Ù†ÙˆØ¹ Ø§Ù„Ø­Ø¬Ø²
            ]);
            
            // Ø¥Ø¶Ø§ÙØ© Ø§Ù„ØªÙˆØ§Ø±ÙŠØ® Ø§Ù„Ù…Ø­Ø¬ÙˆØ²Ø©
            $checkin = \Carbon\Carbon::parse($bookingData['checkin_date']);
            $checkout = \Carbon\Carbon::parse($bookingData['checkout_date']);
            
            \Log::info('Creating booking dates', [
                'booking_id' => $booking->id,
                'checkin' => $checkin->format('Y-m-d'),
                'checkout' => $checkout->format('Y-m-d'),
                'price_per_night' => $bookingData['price_per_night']
            ]);
            
            // Ø­ÙØ¸ ÙƒÙ„ Ù„ÙŠÙ„Ø© Ù…Ø­Ø¬ÙˆØ²Ø© (Ù…Ù† ØªØ§Ø±ÙŠØ® Ø§Ù„ÙˆØµÙˆÙ„ Ø­ØªÙ‰ ØªØ§Ø±ÙŠØ® Ø§Ù„Ù…ØºØ§Ø¯Ø±Ø© - 1)
            $datesCreated = 0;
            while ($checkin->lt($checkout)) {
                $booking->dates()->create([
                    'date' => $checkin->format('Y-m-d'),
                    'price' => $bookingData['price_per_night']
                ]);
                $datesCreated++;
                $checkin->addDay();
            }
            
            \Log::info('Booking dates created', ['count' => $datesCreated]);
            
            // Ù…Ø³Ø­ Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ø³ÙŠØ´Ù†
            session()->forget('pending_booking');
            
            // Ø§Ù„ØªØ¹Ø§Ù…Ù„ Ù…Ø¹ Ø·Ø±Ù‚ Ø§Ù„Ø¯ÙØ¹ Ø§Ù„Ù…Ø®ØªÙ„ÙØ©
            if ($request->payment_method == 'card') {
                // Ø§Ù„ØªÙˆØ¬ÙŠÙ‡ Ø¥Ù„Ù‰ Ø¨ÙˆØ§Ø¨Ø© Ø§Ù„Ø¯ÙØ¹ Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ
                // Ø§Ù„Ø¨Ø­Ø« Ø¹Ù† Ø·Ø±ÙŠÙ‚Ø© Ø§Ù„Ø¯ÙØ¹ Ø¨Ø§Ù„Ø¨Ø·Ø§Ù‚Ø©
                $paymentMethod = Payment_method::where('name_en', 'Card payment')->first();
                if (!$paymentMethod) {
                    $paymentMethod = Payment_method::where('name_en', 'LIKE', '%card%')->first();
                }
                
                if ($paymentMethod) {
                    $products = json_encode([
                        [
                            'name' => 'Booking-' . $bookingNumber,
                            'unit_amount' => round($bookingData['total_price'] * 1000),
                            'quantity' => 1,
                        ]
                    ]);
                    
                    // ØªØ®Ø²ÙŠÙ† Ù…Ø¹Ù„ÙˆÙ…Ø§Øª Ø§Ù„Ø­Ø¬Ø² Ù„Ù„Ø§Ø³ØªØ®Ø¯Ø§Ù… Ø¨Ø¹Ø¯ Ø§Ù„Ø¯ÙØ¹
                    session(['payment_booking_id' => $booking->id]);
                    
                    \DB::commit();
                    
                    // Ø¥Ø±Ø³Ø§Ù„ Ø¥Ø´Ø¹Ø§Ø± Ù…Ø¨Ø¯Ø¦ÙŠ Ù„Ù„Ù…Ø§Ù„Ùƒ (Ø³ÙŠØªÙ… Ø§Ù„ØªØ£ÙƒÙŠØ¯ Ø¨Ø¹Ø¯ Ø§Ù„Ø¯ÙØ¹)
                    $this->sendOwnerNotification($booking, $bookingData, $bookingNumber);
                    
                    $paymentService = new ThawaniPaymentService();
                    $payUrl = $paymentService->pay(
                        $bookingNumber, 
                        $products, 
                        auth('customer')->user()->name,
                        auth('customer')->user()->email,
                        auth('customer')->user()->phone ?? ''
                    );
                    
                    return redirect()->away($payUrl);
                } else {
                    // Ø¥Ø°Ø§ Ù„Ù… ØªØªÙˆÙØ± Ø¨ÙˆØ§Ø¨Ø© Ø¯ÙØ¹ØŒ Ø§Ø¹ØªØ¨Ø±Ù‡ Ø¯ÙØ¹ Ù†Ù‚Ø¯ÙŠ
                    $booking->payment_method = 'cash';
                    $booking->status = 'confirmed';
                    $booking->save();
                    
                    \DB::commit();
                    
                    return redirect()->route('account.orders')->with('success', 
                        'ØªÙ… ØªØ£ÙƒÙŠØ¯ Ø§Ù„Ø­Ø¬Ø² Ø¨Ù†Ø¬Ø§Ø­! Ø±Ù‚Ù… Ø§Ù„Ø­Ø¬Ø²: ' . $bookingNumber . 
                        '. Ø³ÙŠØªÙ… Ø§Ù„Ø¯ÙØ¹ Ø¹Ù†Ø¯ Ø§Ù„ÙˆØµÙˆÙ„.'
                    );
                }
                
            } elseif ($request->payment_method == 'bank_transfer') {
                // Ø¹Ø±Ø¶ Ù…Ø¹Ù„ÙˆÙ…Ø§Øª Ø§Ù„Ø­Ø³Ø§Ø¨ Ø§Ù„Ø¨Ù†ÙƒÙŠ
                $booking->payment_method = 'bank_transfer';
                $booking->save();
                
                \DB::commit();
                
                // Ø¥Ø±Ø³Ø§Ù„ Ø¥Ø´Ø¹Ø§Ø± Ù„Ù„Ù…Ø§Ù„Ùƒ
                $this->sendOwnerNotification($booking, $bookingData, $bookingNumber);
                
                return redirect()->route('showInvoice', $booking->slug)->with('success', 
                    'ØªÙ… Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ø­Ø¬Ø² Ø¨Ù†Ø¬Ø§Ø­! Ø±Ù‚Ù… Ø§Ù„Ø­Ø¬Ø²: ' . $bookingNumber . 
                    '. ÙŠØ±Ø¬Ù‰ ØªØ­ÙˆÙŠÙ„ Ø§Ù„Ù…Ø¨Ù„Øº Ø¥Ù„Ù‰ Ø§Ù„Ø­Ø³Ø§Ø¨ Ø§Ù„Ø¨Ù†ÙƒÙŠ ÙˆØ¥Ø±Ø³Ø§Ù„ Ø¥ÙŠØµØ§Ù„ Ø§Ù„ØªØ­ÙˆÙŠÙ„.'
                )->with('show_bank_details', true);
                
            } else {
                // Ø§Ù„Ø¯ÙØ¹ Ù†Ù‚Ø¯Ø§Ù‹ Ø¹Ù†Ø¯ Ø§Ù„ÙˆØµÙˆÙ„
                $booking->payment_method = 'cash';
                $booking->status = 'confirmed';
                $booking->save();
                
                \DB::commit();
                
                // Ø¥Ø±Ø³Ø§Ù„ Ø¥Ø´Ø¹Ø§Ø± Ù„Ù„Ù…Ø§Ù„Ùƒ (Ù‡Ø°Ø§ Ù„Ø§ ÙŠØ¹ØªÙ…Ø¯ Ø¹Ù„Ù‰ Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ)
                $this->sendOwnerNotification($booking, $bookingData, $bookingNumber);
                
                // Ø¥Ø±Ø³Ø§Ù„ Ø¥ÙŠÙ…ÙŠÙ„Ø§Øª Ø§Ù„ØªØ£ÙƒÙŠØ¯
                try {
                    $chalet = Chalet::find($bookingData['chalet_id']);
                    
                    // Ù„Ù„Ø¹Ù…ÙŠÙ„
                    $customerData = [
                        'title' => 'ØªØ£ÙƒÙŠØ¯ Ø­Ø¬Ø² Ø´Ø§Ù„ÙŠÙ‡',
                        'message' => 'ØªÙ… ØªØ£ÙƒÙŠØ¯ Ø­Ø¬Ø²Ùƒ Ù„Ù„Ø´Ø§Ù„ÙŠÙ‡ ' . $chalet->chalet_name_ar . '. Ø±Ù‚Ù… Ø§Ù„Ø­Ø¬Ø²: ' . $bookingNumber,
                    ];
                    Mail::to(auth('customer')->user()->email)->send(new Notify($customerData, 'ØªØ£ÙƒÙŠØ¯ Ø­Ø¬Ø²'));
                    
                    // Ù„Ù„Ø¥Ø¯Ø§Ø±Ø©
                    $adminData = [
                        'title' => 'Ø­Ø¬Ø² Ø´Ø§Ù„ÙŠÙ‡ Ø¬Ø¯ÙŠØ¯',
                        'message' => 'ØªÙ… Ø­Ø¬Ø² Ø´Ø§Ù„ÙŠÙ‡ Ø¬Ø¯ÙŠØ¯. Ø±Ù‚Ù… Ø§Ù„Ø­Ø¬Ø²: ' . $bookingNumber . ', Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡: ' . $chalet->chalet_name_ar,
                    ];
                    $adminEmail = Setting::first()->email ?? 'admin@weekendoman.com';
                    if ($adminEmail) {
                        Mail::to($adminEmail)->send(new Notify($adminData, 'Ø­Ø¬Ø² Ø¬Ø¯ÙŠØ¯'));
                    }
                    
                } catch (\Exception $e) {
                    Log::error('ÙØ´Ù„ Ø¥Ø±Ø³Ø§Ù„ Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ: ' . $e->getMessage());
                }
                
                return redirect()->route('account.orders')->with('success', 
                    'ØªÙ… ØªØ£ÙƒÙŠØ¯ Ø§Ù„Ø­Ø¬Ø² Ø¨Ù†Ø¬Ø§Ø­! Ø±Ù‚Ù… Ø§Ù„Ø­Ø¬Ø²: ' . $bookingNumber . 
                    '. Ø³ÙŠØªÙ… Ø§Ù„Ø¯ÙØ¹ Ù†Ù‚Ø¯Ø§Ù‹ Ø¹Ù†Ø¯ Ø§Ù„ÙˆØµÙˆÙ„.'
                );
            }
            
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Booking creation error: ' . $e->getMessage());
            \Log::error('Booking data: ' . json_encode($bookingData));
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Ø­Ø¯Ø« Ø®Ø·Ø£ Ø£Ø«Ù†Ø§Ø¡ Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ø­Ø¬Ø²: ' . $e->getMessage())->withInput();
        }
    }

    // Ø¯Ø§Ù„Ø© Ù…Ø³Ø§Ø¹Ø¯Ø© Ù„Ø¥Ø±Ø³Ø§Ù„ Ø¥Ø´Ø¹Ø§Ø± Ù„Ù„Ù…Ø§Ù„Ùƒ
    private function sendOwnerNotification($booking, $bookingData, $bookingNumber)
    {
        \Log::info('=== sendOwnerNotification START ===');
        
        try {
            $chalet = Chalet::with('owner')->find($bookingData['chalet_id']);
            
            \Log::info('Chalet and owner check', [
                'chalet_id' => $bookingData['chalet_id'],
                'chalet_found' => $chalet ? true : false,
                'has_owner' => $chalet ? ($chalet->owner ? true : false) : false,
                'owner_id' => $chalet && $chalet->owner ? $chalet->owner->id : null,
                'owner_name' => $chalet && $chalet->owner ? $chalet->owner->name : null
            ]);
            
            if ($chalet && $chalet->owner) {
                $ownerData = [
                    'title' => 'Ø­Ø¬Ø² Ø¬Ø¯ÙŠØ¯ Ù„Ø´Ø§Ù„ÙŠÙ‡Ùƒ',
                    'message' => 'ØªÙ… Ø­Ø¬Ø² Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡ ' . $chalet->chalet_name_ar . 
                               ' Ù…Ù† ØªØ§Ø±ÙŠØ® ' . $bookingData['checkin_date'] . 
                               ' Ø¥Ù„Ù‰ ' . $bookingData['checkout_date'] . 
                               '. Ø±Ù‚Ù… Ø§Ù„Ø­Ø¬Ø²: ' . $bookingNumber .
                               '. Ø§Ø³Ù… Ø§Ù„Ø¹Ù…ÙŠÙ„: ' . auth('customer')->user()->name .
                               '. Ø±Ù‚Ù… Ø§Ù„Ù‡Ø§ØªÙ: ' . (auth('customer')->user()->phone ?? 'ØºÙŠØ± Ù…Ø­Ø¯Ø¯'),
                ];
                
                // Ø¥Ù†Ø´Ø§Ø¡ Ø¥Ø´Ø¹Ø§Ø± ÙÙŠ Ù‚Ø§Ø¹Ø¯Ø© Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ù„Ù„Ù…Ø§Ù„Ùƒ Ø£ÙˆÙ„Ø§Ù‹
                $notification = \App\Models\Notification::create([
                    'owner_id' => $chalet->owner->id,
                    'type' => 'booking',
                    'title_ar' => 'Ø­Ø¬Ø² Ø¬Ø¯ÙŠØ¯',
                    'title_en' => 'New Booking',
                    'message_ar' => $ownerData['message'],
                    'message_en' => 'New booking for ' . $chalet->chalet_name_en . 
                                   ' from ' . $bookingData['checkin_date'] . 
                                   ' to ' . $bookingData['checkout_date'] . 
                                   '. Booking number: ' . $bookingNumber .
                                   '. Customer: ' . auth('customer')->user()->name,
                    'icon_type' => 'success',
                    'data' => [
                        'booking_id' => $booking->id,
                        'booking_number' => $bookingNumber,
                        'chalet_id' => $chalet->id,
                        'chalet_name' => $chalet->chalet_name_ar,
                        'customer_name' => auth('customer')->user()->name,
                        'checkin_date' => $bookingData['checkin_date'],
                        'checkout_date' => $bookingData['checkout_date'],
                        'total_amount' => $bookingData['total_price']
                    ],
                    'is_read' => false
                ]);
                
                \Log::info('Owner notification created in database', [
                    'notification_id' => $notification->id,
                    'owner_id' => $chalet->owner->id,
                    'booking_number' => $bookingNumber
                ]);
                
                // Ù…Ø­Ø§ÙˆÙ„Ø© Ø¥Ø±Ø³Ø§Ù„ Ø¥ÙŠÙ…ÙŠÙ„ Ù„Ù„Ù…Ø§Ù„Ùƒ (Ø§Ø®ØªÙŠØ§Ø±ÙŠ)
                try {
                    if ($chalet->owner->email) {
                        Mail::to($chalet->owner->email)->send(new Notify($ownerData, 'Ø­Ø¬Ø² Ø¬Ø¯ÙŠØ¯'));
                        \Log::info('Email sent to owner', ['email' => $chalet->owner->email]);
                    }
                } catch (\Exception $emailException) {
                    \Log::warning('Could not send email to owner: ' . $emailException->getMessage());
                    // Ù„Ø§ Ù†ÙˆÙ‚Ù Ø§Ù„Ø¹Ù…Ù„ÙŠØ© Ø¥Ø°Ø§ ÙØ´Ù„ Ø§Ù„Ø¥ÙŠÙ…ÙŠÙ„
                }
            } else {
                \Log::warning('Chalet has no owner', ['chalet_id' => $bookingData['chalet_id']]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to create owner notification: ' . $e->getMessage());
        }
    }

    public function bookChalet(Request $request)
{
    $validated = $request->validate([
        'chalet_id' => 'required|exists:chalets,id',
        'customer_name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'data_booking' => 'required|string',
        'payment_method_id' => 'required',
        'booking_type' => 'required|in:fullDay,halfDay,stayDay',
    ]);

    $chalet = Chalet::findOrFail($validated['chalet_id']);
    $dates = explode(', ', $validated['data_booking']);

    $defaultPrice = match ($validated['booking_type']) {
        'fullDay' => $chalet->default_day_price,
        'halfDay' => $chalet->half_day_price,
        'stayDay' => $chalet->stay_price,
        default => 0,
    };

    $calculatedTotal = 0;
    foreach ($dates as $date) {
        $specialPrice = $chalet->prices()->where('date', $date)->value('price');
        $calculatedTotal += $specialPrice ?? $defaultPrice;
    }
    // ØªØ·Ø¨ÙŠÙ‚ Ø§Ù„ÙƒÙˆØ¨ÙˆÙ† Ø¥Ø°Ø§ ÙƒØ§Ù† Ù…ÙˆØ¬ÙˆØ¯
    $calculatedTotal = $this->applyCouponIfValid($request, $calculatedTotal);


    if ($calculatedTotal <= 0) {
        toast('Ø§Ù„Ø¥Ø¬Ù…Ø§Ù„ÙŠ ØºÙŠØ± ØµØ­ÙŠØ­','error');
        return redirect()->back();
    }

    $paymentMethod = Payment_method::find($validated['payment_method_id']);

    // ØªØ®Ø²ÙŠÙ† Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ù…Ø¤Ù‚ØªØ§Ù‹ ÙÙŠ session
    session([
        'booking_data' => [
            ...$validated,
            'email' => $request->email,
            'message' => $request->message,
            'customer_id' => auth()->user()->id,
            'dates' => $dates,
            'total_amount' => $calculatedTotal,
            'coupon_code' => $request->coupon_code,
            'payment_method' => $request->payment_method ?? 'cash',
        ]
    ]);

    // Ø§Ù„Ø¯ÙØ¹ Ø§Ù„ÙƒØ§Ù…Ù„
    if($paymentMethod->name_en == 'Card payment') {
        $products = json_encode([
            [
                'name' => 'ORDER-TEMP',
                'unit_amount' => round($calculatedTotal  * 1000),
                'quantity'=> 1,
            ]
        ]);
    } elseif($paymentMethod->name_en == 'Advance amount') {
        $advance = Setting::first()->advance_amount;
        $products = json_encode([
            [
                'name' => 'ORDER-TEMP',
                'unit_amount' => round($advance  * 1000),
                'quantity'=> 1,
            ]
        ]);    
    }
    else{
        $this->storeBooking(session('booking_data'), false);
        session()->forget('booking_data');
        toast('ØªÙ… Ø§Ù„Ø­Ø¬Ø² Ø¨Ù†Ø¬Ø§Ø­','success');
        return redirect()->route('account.orders');
    }

    $payments = new ThawaniPaymentService();
    $payUrl = $payments->pay('TEMP', $products, $validated['customer_name'], $request->email, $validated['phone_number']);

    return redirect()->away($payUrl);
}

    public function storeBooking($data, $isCOD = false)
{
    $booking_number = Booking::count() ? Booking::latest()->first()->id + 1 : 1;

    $booking = Booking::create([
        'booking_number' => 'BN-000'.$booking_number,
        'chalet_id' => $data['chalet_id'],
        'customer_name' => $data['customer_name'],
        'phone_number' => $data['phone_number'],
        'total_amount' => $data['total_amount'],
        'payment_amount' => $isCOD ? 0 : 0,
        'email' => $data['email'],
        'user_id' => null,
        'customer_id' => $data['customer_id'],
        'message' => $data['message'],
        'payment_method_id' => $data['payment_method_id'] ?? null,
        'payment_method' => $data['payment_method'] ?? 'cash',
        'payment_status' => $isCOD ? 'paid' : 'unpaid',
    ]);

    foreach ($data['dates'] as $date) {
        $specialPrice = ChaletPrice::where('chalet_id', $data['chalet_id'])
            ->where('date', $date)
            ->value('price');
        $price = $specialPrice ?? match ($data['booking_type']) {
            'fullDay' => Chalet::find($data['chalet_id'])->default_day_price,
            'halfDay' => Chalet::find($data['chalet_id'])->half_day_price,
            'stayDay' => Chalet::find($data['chalet_id'])->stay_price,
            default => 0,
        };
        $booking->dates()->create([
            'date' => $date,
            'price' => $price,
        ]);
    }

    // Ø¥Ø±Ø³Ø§Ù„ Ø§Ù„Ø¥ÙŠÙ…ÙŠÙ„Ø§Øª
    $chalet = Chalet::find($data['chalet_id']);
    try {
        $chalet = Chalet::find($data['chalet_id']);

        // Ù„Ù„Ø¥Ø¯Ø§Ø±Ø©
        $adminData = [
            'title' => 'Ø­Ø¬Ø² Ø´Ø§Ù„ÙŠÙ‡ Ø¬Ø¯ÙŠØ¯',
            'message' => 'ØªÙ… Ø­Ø¬Ø² Ø´Ø§Ù„ÙŠÙ‡ Ø¬Ø¯ÙŠØ¯. ØªÙØ§ØµÙŠÙ„ Ø§Ù„Ø­Ø¬Ø²: ' . $chalet->chalet_name_ar,
        ];
        Mail::to(Setting::first()->email)->send(new Notify($adminData, 'Ø­Ø¬Ø² Ø¬Ø¯ÙŠØ¯'));
    } catch (\Exception $e) {
        Log::error('ÙØ´Ù„ Ø¥Ø±Ø³Ø§Ù„ Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ: ' . $e->getMessage());
    }
    try {
        // Ù„Ù„Ø¹Ù…ÙŠÙ„
        $customerData = [
            'title' => 'ØªØ£ÙƒÙŠØ¯ Ø­Ø¬Ø² Ø´Ø§Ù„ÙŠÙ‡',
            'message' => 'ØªÙ… ØªØ£ÙƒÙŠØ¯ Ø­Ø¬Ø²Ùƒ Ù„Ù„Ø´Ø§Ù„ÙŠÙ‡. ØªÙØ§ØµÙŠÙ„ Ø§Ù„Ø­Ø¬Ø²: ' . $chalet->chalet_name_ar,
        ];
        Mail::to($data['email'])->send(new Notify($customerData, 'Ø­Ø¬Ø² Ø¬Ø¯ÙŠØ¯'));
    } catch (\Exception $e) {
        Log::error('ÙØ´Ù„ Ø¥Ø±Ø³Ø§Ù„ Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ: ' . $e->getMessage());
    }
    try {
        // Ù„Ù„Ù…Ø§Ù„Ùƒ
        $ownerData = [
            'title' => 'Ø­Ø¬Ø² Ø´Ø§Ù„ÙŠÙ‡ Ø¬Ø¯ÙŠØ¯',
            'message' => 'ØªÙ… Ø­Ø¬Ø² Ø´Ø§Ù„ÙŠÙ‡Ùƒ. ØªÙØ§ØµÙŠÙ„ Ø§Ù„Ø­Ø¬Ø²: ' . $chalet->chalet_name_ar,
        ];
        Mail::to($chalet->owner->email)->send(new Notify($ownerData, 'Ø­Ø¬Ø² Ø¬Ø¯ÙŠØ¯'));
    } catch (\Exception $e) {
        Log::error('ÙØ´Ù„ Ø¥Ø±Ø³Ø§Ù„ Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ: ' . $e->getMessage());
    }

    return $booking;
}
    public function payments_success()
{
    // Ø§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† ÙˆØ¬ÙˆØ¯ Ù…Ø¹Ø±Ù Ø§Ù„Ø­Ø¬Ø² ÙÙŠ Ø§Ù„Ø³ÙŠØ´Ù† (Ù„Ù„Ø­Ø¬ÙˆØ²Ø§Øª Ø§Ù„Ø¬Ø¯ÙŠØ¯Ø© Ù…Ù† ØµÙØ­Ø© Ø§Ù„ØªÙØ§ØµÙŠÙ„)
    $bookingId = session('payment_booking_id');
    
    if ($bookingId) {
        // ØªØ­Ø¯ÙŠØ« Ø­Ø§Ù„Ø© Ø§Ù„Ø­Ø¬Ø² Ø§Ù„Ù…ÙˆØ¬ÙˆØ¯
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->payment_status = 'paid';
            $booking->status = 'confirmed';
            $booking->payment_amount = $booking->total_amount;
            $booking->save();
            
            // Ø¥Ø±Ø³Ø§Ù„ Ø¥ÙŠÙ…ÙŠÙ„ Ø§Ù„ØªØ£ÙƒÙŠØ¯
            try {
                $chalet = $booking->chalet;
                
                // Ù„Ù„Ø¹Ù…ÙŠÙ„
                $customerData = [
                    'title' => 'ØªØ£ÙƒÙŠØ¯ Ø¯ÙØ¹ Ø§Ù„Ø­Ø¬Ø²',
                    'message' => 'ØªÙ… Ø§Ø³ØªÙ„Ø§Ù… Ø¯ÙØ¹ØªÙƒ Ø¨Ù†Ø¬Ø§Ø­ Ù„Ù„Ø´Ø§Ù„ÙŠÙ‡ ' . $chalet->chalet_name_ar . '. Ø±Ù‚Ù… Ø§Ù„Ø­Ø¬Ø²: ' . $booking->booking_number,
                ];
                Mail::to($booking->email)->send(new Notify($customerData, 'ØªØ£ÙƒÙŠØ¯ Ø¯ÙØ¹'));
                
                // Ù„Ù„Ø¥Ø¯Ø§Ø±Ø©
                $adminData = [
                    'title' => 'Ø¯ÙØ¹Ø© Ø¬Ø¯ÙŠØ¯Ø© Ù…Ø³ØªÙ„Ù…Ø©',
                    'message' => 'ØªÙ… Ø§Ø³ØªÙ„Ø§Ù… Ø¯ÙØ¹Ø© Ù„Ù„Ø­Ø¬Ø² Ø±Ù‚Ù…: ' . $booking->booking_number . ', Ø§Ù„Ø´Ø§Ù„ÙŠÙ‡: ' . $chalet->chalet_name_ar,
                ];
                Mail::to(Setting::first()->email)->send(new Notify($adminData, 'Ø¯ÙØ¹Ø© Ø¬Ø¯ÙŠØ¯Ø©'));
                
            } catch (\Exception $e) {
                Log::error('ÙØ´Ù„ Ø¥Ø±Ø³Ø§Ù„ Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ: ' . $e->getMessage());
            }
            
            session()->forget('payment_booking_id');
            toast('ØªÙ… Ø§Ù„Ø¯ÙØ¹ Ø¨Ù†Ø¬Ø§Ø­ ÙˆØªØ£ÙƒÙŠØ¯ Ø§Ù„Ø­Ø¬Ø²','success');
            return redirect()->route('account.orders');
        }
    }
    
    // Ø§Ù„ÙƒÙˆØ¯ Ø§Ù„Ù‚Ø¯ÙŠÙ… Ù„Ù„Ø­Ø¬ÙˆØ²Ø§Øª Ù…Ù† Ø§Ù„ØµÙØ­Ø© Ø§Ù„Ù‚Ø¯ÙŠÙ…Ø©
    $data = session('booking_data');

    if (!$data) {
        toast('Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ø­Ø¬Ø² ØºÙŠØ± Ù…ØªÙˆÙØ±Ø©','error');
        return redirect()->route('shaleek.home');
    }

    // Ø£Ù†Ø´Ø¦ Ø§Ù„Ø­Ø¬Ø²
    $booking = $this->storeBooking($data, false);
    // Ø­Ø¯Ù‘Ø« Ø­Ø§Ù„Ø© Ø§Ù„Ø¯ÙØ¹
    if ($booking->PaymentMethod && $booking->PaymentMethod->name_en == 'Card payment') {
        $booking->payment_amount = $booking->total_amount;
        $booking->payment_status = 'paid';
    } elseif ($booking->PaymentMethod && $booking->PaymentMethod->name_en == 'Advance amount') {
        $booking->payment_amount = Setting::first()->advance_amount;
        $booking->payment_status = 'paid';
    }
    $booking->save();
    if (isset($data['coupon_code'])) {
        $coupon = Coupon::where('code', $data['coupon_code'])->first();
        if ($coupon) {
            $coupon->increment('used_count');
        }
    }

    session()->forget('booking_data');
    toast('ØªÙ… Ø§Ù„Ø­Ø¬Ø² Ø¨Ù†Ø¬Ø§Ø­','success');
    return redirect()->route('account.orders');
}

private function applyCouponIfValid(Request $request, float $total)
{
    $code = $request->coupon_code;

    if (!$code) return $total;

    $coupon = Coupon::where('code', $code)->first();

    if (!$coupon || !$coupon->is_active) return $total;
    if ($coupon->expires_at && now()->greaterThan($coupon->expires_at)) return $total;
    if ($coupon->used_count >= $coupon->max_uses) return $total;

    // Ø­Ø³Ø§Ø¨ Ø§Ù„Ø®ØµÙ…
    $discount = ($total * $coupon->discount_percentage) / 100;
    $newTotal = $total - $discount;

    // ØªØ­Ø¯ÙŠØ« Ø§Ù„Ø§Ø³ØªØ®Ø¯Ø§Ù…
    $coupon->increment('used_count');

    return $newTotal;
}

    public function showInvoice($slug)
    {
        $booking = Booking::with(['dates', 'PaymentMethod', 'chalet'])->where('slug',$slug)->first();
        return view('frontend.pages.invoice', compact('booking'));
    }

    // Ø§Ù„ØºØ§Ø¡ Ø§Ù„Ø·Ù„Ø¨
    public function payments_cancel(Request $request, $order_no = null)
    {
        session()->forget('booking_data');
        session()->forget('payment_booking_id');
        toast(' ØªÙ… Ø§Ù„ØºØ§Ø¡ Ø§Ù„Ø­Ø¬Ø² Ø¨Ù†Ø¬Ø§Ø­ ','success');
        return redirect()->route('shaleek.home');
    }
}


