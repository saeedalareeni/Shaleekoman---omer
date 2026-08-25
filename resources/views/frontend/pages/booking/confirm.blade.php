    @extends('frontend.layouts.weekend_master')

@php
    $isArabic = app()->getLocale() == 'ar';
@endphp

@section('page_title')
    {{ $isArabic ? 'تأكيد العرض' : 'Booking Confirmation' }}
@endsection

@section('css')
<style>
    .booking-confirmation {
        padding: 60px 0;
        min-height: calc(100vh - 200px);
        background: #f8f9fa;
    }
    
    .confirmation-card {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }
    
    .booking-summary {
        border: 1px solid #e8ecef;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        background: #fafbfc;
    }
    
    .summary-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e8ecef;
    }
    
    .chalet-image {
        width: 120px;
        height: 90px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .chalet-info h4 {
        color: #127664;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f0f3f5;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        color: #6c757d;
        font-size: 15px;
    }
    
    .detail-value {
        font-weight: 600;
        color: #2c3e50;
        font-size: 15px;
    }
    
    .price-summary {
        background: linear-gradient(135deg, #f0f9f4 0%, #f8f9fa 100%);
        padding: 28px;
        border-radius: 12px;
        margin-top: 24px;
        border: 1px solid #e0f0e8;
    }
    
    .price-summary h4 {
        color: #127664;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.3rem;
        font-weight: bold;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #127664;
        color: #127664;
    }
    
    .payment-methods {
        margin-top: 32px;
    }
    
    .payment-methods h4 {
        color: #127664;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    .payment-option {
        border: 2px solid #e8ecef;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        background: white;
    }
    
    .payment-option:hover {
        border-color: #127664;
        background: #f9fcfa;
        transform: translateX(5px);
    }
    
    [dir="rtl"] .payment-option:hover {
        transform: translateX(-5px);
    }
    
    .payment-option.selected {
        border-color: #127664;
        background: #f0f9f4;
        box-shadow: 0 2px 8px rgba(18,118,100,0.15);
    }
    
    .payment-option input[type="radio"] {
        margin-right: 12px;
        width: 18px;
        height: 18px;
        accent-color: #127664;
    }
    
    [dir="rtl"] .payment-option input[type="radio"] {
        margin-right: 0;
        margin-left: 12px;
    }
    
    .payment-option label {
        margin: 0;
        font-weight: 500;
        color: #333;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
    }
    
    .payment-option label img.payment-logo {
        height: 20px;
        width: auto;
        max-width: 100px;
        display: inline-block;
    }
    
    .payment-option i {
        color: #127664;
        font-size: 20px;
        width: 24px;
    }
    
    .confirm-button {
        background: linear-gradient(135deg, #127664 0%, #159265 100%);
        color: white;
        border: none;
        padding: 16px 40px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        margin-top: 24px;
        box-shadow: 0 4px 15px rgba(18,118,100,0.25);
    }
    
    .confirm-button:hover {
        background: linear-gradient(135deg, #0f5c4d 0%, #127664 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(18,118,100,0.35);
    }
    
    .confirm-button:active {
        transform: translateY(0);
    }
    
    .btn-outline-secondary {
        border: 2px solid #6c757d;
        color: #6c757d;
        background: white;
        padding: 16px 40px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-outline-secondary:hover {
        background: #6c757d;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108,117,125,0.25);
    }
    
    [dir="rtl"] .fas.fa-arrow-left::before {
        content: "\f061";
    }
    
    .alert-info {
        background: linear-gradient(135deg, #e8f4fd 0%, #f0f9ff 100%);
        border: 1px solid #b8daff;
        color: #004085;
        padding: 16px 24px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .alert-info i {
        color: #0066cc;
        font-size: 20px;
    }
    
    /* Page Title */
    h2 {
        color: #127664;
        font-weight: 700;
        margin-bottom: 24px;
        font-size: 28px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .confirmation-card {
            padding: 24px;
        }
        
        .summary-header {
            flex-direction: column;
            text-align: center;
        }
        
        .chalet-image {
            width: 100%;
            height: 200px;
            max-width: 300px;
        }
        
        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        [dir="rtl"] .detail-row {
            align-items: flex-end;
        }
        
        .total-row {
            font-size: 1.1rem;
        }
        
        /* Stack payment option content on mobile */
        .payment-option {
            flex-direction: column;
            align-items: stretch;
            overflow: hidden;
        }
        
        .payment-option label {
            justify-content: center;
            text-align: center;
        }
        
        /* Fix payment card image size on mobile */
        .payment-option label img.payment-logo {
            height: 18px !important;
            width: auto !important;
            max-width: 80px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="booking-confirmation">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="confirmation-card">
                    <h2 class="mb-4">{{ $isArabic ? 'تأكيد عرضك' : 'Confirm Your Booking' }}</h2>
                    
                    <div class="alert-info">
                        <i class="fas fa-info-circle"></i>
                        @if(isset($bookingData['existing_booking']) && $bookingData['existing_booking'])
                            {{ $isArabic ? 'مرحباً ' . auth('customer')->user()->name . '، يرجى تأكيد عرضك رقم ' . $bookingData['booking_number'] : 'Hello ' . auth('customer')->user()->name . ', please confirm your booking number ' . $bookingData['booking_number'] }}
                        @else
                            {{ $isArabic ? 'مرحباً ' . auth('customer')->user()->name . '، يرجى مراجعة تفاصيل العرض والتأكيد' : 'Hello ' . auth('customer')->user()->name . ', please review your booking details and confirm' }}
                        @endif
                    </div>
                    
                    <div class="booking-summary">
                        <div class="summary-header">
                            <img src="{{ asset($chalet->main_image ?? 'no_image.png') }}" alt="{{ $chalet->chalet_name_ar }}" class="chalet-image">
                            <div class="chalet-info">
                                <h4>{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}</h4>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $isArabic ? $chalet->city->name_ar : $chalet->city->name_en }} - 
                                    {{ $isArabic ? $chalet->area->name_ar : $chalet->area->name_en }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">{{ $isArabic ? 'تاريخ الوصول' : 'Check-in Date' }}</span>
                            <span class="detail-value">{{ $bookingData['checkin_date'] }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">{{ $isArabic ? 'تاريخ المغادرة' : 'Check-out Date' }}</span>
                            <span class="detail-value">{{ $bookingData['checkout_date'] }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">{{ $isArabic ? 'وقت الوصول' : 'Check-in Time' }}</span>
                            <span class="detail-value">{{ date('g:i A', strtotime($bookingData['checkin_time'] ?? '15:00')) }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">{{ $isArabic ? 'وقت المغادرة' : 'Check-out Time' }}</span>
                            <span class="detail-value">{{ date('g:i A', strtotime($bookingData['checkout_time'] ?? '08:00')) }}</span>
                        </div>
                        
                        
                        
                        <div class="detail-row">
                            <span class="detail-label">{{ $isArabic ? 'عدد الليالي' : 'Number of Nights' }}</span>
                            <span class="detail-value">{{ $bookingData['total_nights'] }}</span>
                        </div>
                        
                        @if($bookingData['special_requests'])
                        <div class="detail-row">
                            <span class="detail-label">{{ $isArabic ? 'طلبات خاصة' : 'Special Requests' }}</span>
                            <span class="detail-value">{{ $bookingData['special_requests'] }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="price-summary">
                        <h4 class="mb-3">{{ $isArabic ? 'ملخص السعر' : 'Price Summary' }}</h4>
                        
                        <div class="detail-row">
                            <span class="detail-label">{{ $bookingData['total_nights'] }} {{ $isArabic ? 'ليلة × ' : 'night(s) × ' }} {{ number_format($bookingData['price_per_night']) }} {{ $isArabic ? 'ريال' : 'SAR' }}</span>
                            <span class="detail-value">{{ number_format($bookingData['subtotal']) }} {{ $isArabic ? 'ريال' : 'SAR' }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">{{ $isArabic ? 'رسوم الخدمة (5%)' : 'Service Fee (5%)' }}</span>
                            <span class="detail-value">{{ number_format($bookingData['service_fee']) }} {{ $isArabic ? 'ريال' : 'SAR' }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">{{ $isArabic ? 'ضريبة القيمة المضافة (15%)' : 'VAT (15%)' }}</span>
                            <span class="detail-value">{{ number_format($bookingData['vat']) }} {{ $isArabic ? 'ريال' : 'SAR' }}</span>
                        </div>
                        
                        <div class="total-row">
                            <span>{{ $isArabic ? 'المبلغ الإجمالي' : 'Total Amount' }}</span>
                            <span>{{ number_format($bookingData['total_price']) }} {{ $isArabic ? 'ريال' : 'SAR' }}</span>
                        </div>
                    </div>
                    
                    <div class="payment-methods">
                        <h4 class="mb-3">{{ $isArabic ? 'طريقة الدفع' : 'Payment Method' }}</h4>
                        
                        @if(isset($bookingData['existing_booking']) && $bookingData['existing_booking'])
                            <!-- Form for existing booking confirmation -->
                            <form action="{{ route('booking.update.status', $booking->booking_number) }}" method="POST" id="bookingForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                        @else
                            <!-- Form for new booking -->
                            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                                @csrf
                                
                                <!-- Hidden fields for booking data -->
                                <input type="hidden" name="chalet_id" value="{{ $chalet->id }}">
                                <input type="hidden" name="checkin_date" value="{{ $bookingData['checkin_date'] }}">
                                <input type="hidden" name="checkout_date" value="{{ $bookingData['checkout_date'] }}">
                                <input type="hidden" name="checkin_time" value="{{ $bookingData['checkin_time'] ?? '15:00' }}">
                                <input type="hidden" name="checkout_time" value="{{ $bookingData['checkout_time'] ?? '08:00' }}">
                                <input type="hidden" name="total_nights" value="{{ $bookingData['total_nights'] }}">
                                <input type="hidden" name="total_price" value="{{ $bookingData['total_price'] }}">
                                <input type="hidden" name="price_per_night" value="{{ $bookingData['price_per_night'] }}">
                                <input type="hidden" name="subtotal" value="{{ $bookingData['subtotal'] }}">
                                <input type="hidden" name="service_fee" value="{{ $bookingData['service_fee'] }}">
                                <input type="hidden" name="vat" value="{{ $bookingData['vat'] }}">
                                <input type="hidden" name="number_of_guests" value="{{ $bookingData['number_of_guests'] ?? 2 }}">
                                <input type="hidden" name="special_requests" value="{{ $bookingData['special_requests'] ?? '' }}">
                        @endif
                            
                            @php
                                $setting = \App\Models\Setting::first();
                                $defaultPaymentMethod = null;
                                if ($setting && ($setting->cash_enabled ?? true)) {
                                    $defaultPaymentMethod = 'cash';
                                } elseif ($setting && ($setting->thawani_enabled ?? false)) {
                                    $defaultPaymentMethod = 'card';
                                } elseif ($setting && ($setting->paypal_enabled ?? false)) {
                                    $defaultPaymentMethod = 'paypal';
                                } elseif ($setting && ($setting->stripe_enabled ?? false)) {
                                    $defaultPaymentMethod = 'stripe';
                                } elseif ($setting && ($setting->cash_enabled ?? true)) {
                                    $defaultPaymentMethod = 'bank_transfer';
                                }
                            @endphp
                            
                            <!-- Always show cash payment option -->
                            @if($setting && ($setting->cash_enabled ?? true))
                            <div class="payment-option {{ $defaultPaymentMethod === 'cash' ? 'selected' : '' }}" onclick="selectPayment('cash', this)">
                                <input type="radio" name="payment_method" value="cash" id="cash" {{ $defaultPaymentMethod === 'cash' ? 'checked' : '' }} required>
                                <label for="cash">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>{{ __('back.cash') }} - {{ $isArabic ? 'عند الوصول' : 'on Arrival' }}</span>
                                </label>
                            </div>
                            @endif
                            
                            <!-- Show Thawani Pay if enabled -->
                            @if($setting && $setting->thawani_enabled)
                            <div class="payment-option {{ $defaultPaymentMethod === 'card' ? 'selected' : '' }}" onclick="selectPayment('card', this)">
                                <input type="radio" name="payment_method" value="card" id="card" {{ $defaultPaymentMethod === 'card' ? 'checked' : '' }}>
                                <label for="card">
                                    <img class="payment-logo" src="https://wkndoman.com/images/paymentMethods/thawani.jpg" alt="Thawani">
                                    <span>{{ $isArabic ? 'البطاقة البنكية (Thawani Pay)' : 'Credit/Debit Card (Thawani Pay)' }}</span>
                                </label>
                            </div>
                            @endif
                            
                            <!-- Show PayPal if enabled -->
                            @if($setting && $setting->paypal_enabled)
                            <div class="payment-option {{ $defaultPaymentMethod === 'paypal' ? 'selected' : '' }}" onclick="selectPayment('paypal', this)">
                                <input type="radio" name="payment_method" value="paypal" id="paypal" {{ $defaultPaymentMethod === 'paypal' ? 'checked' : '' }}>
                                <label for="paypal">
                                    <i class="fab fa-paypal" style="color: #003087;"></i>
                                    <span>PayPal</span>
                                </label>
                            </div>
                            @endif
                            
                            <!-- Show Stripe if enabled -->
                            @if($setting && $setting->stripe_enabled)
                            <div class="payment-option {{ $defaultPaymentMethod === 'stripe' ? 'selected' : '' }}" onclick="selectPayment('stripe', this)">
                                <input type="radio" name="payment_method" value="stripe" id="stripe" {{ $defaultPaymentMethod === 'stripe' ? 'checked' : '' }}>
                                <label for="stripe">
                                    <i class="fab fa-stripe" style="color: #635BFF;"></i>
                                    <span>Stripe</span>
                                </label>
                            </div>
                            @endif
                            
                            <!-- Show bank transfer option -->
                            @if($setting && ($setting->cash_enabled ?? true))
                            <div class="payment-option {{ $defaultPaymentMethod === 'bank_transfer' ? 'selected' : '' }}" onclick="selectPayment('bank_transfer', this)">
                                <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer" {{ $defaultPaymentMethod === 'bank_transfer' ? 'checked' : '' }}>
                                <label for="bank_transfer">
                                    <i class="fas fa-university"></i>
                                    <span>{{ __('back.bank_transfer') }}</span>
                                </label>
                            </div>
                            @endif
                            
                            <div class="d-flex gap-3 mt-4">
                                <button type="submit" class="confirm-button flex-fill" id="confirmBookingBtn">
                                    <i class="fas fa-check-circle me-2"></i>
                                    @if(isset($bookingData['existing_booking']) && $bookingData['existing_booking'])
                                        {{ $isArabic ? 'تأكيد العرض الآن' : 'Confirm Booking Now' }}
                                    @else
                                        {{ $isArabic ? 'إتمام العرض' : 'Complete Booking' }}
                                    @endif
                                </button>
                                <a href="{{ route('account.orders') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    {{ $isArabic ? 'العودة للحجوزات' : 'Back to Bookings' }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
function selectPayment(method, el) {
    // Remove selected class from all options
    document.querySelectorAll('.payment-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    // Add selected class to clicked option
    if (el) {
        el.classList.add('selected');
    }
    
    // Check the radio button
    document.getElementById(method).checked = true;
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bookingForm');
    if (!form) return;
    const btn = document.getElementById('confirmBookingBtn');

    // Add validation before form submission
    form.addEventListener('submit', function(e) {
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        if (!selectedPayment) {
            e.preventDefault();
            alert('{{ $isArabic ? "الرجاء اختيار طريقة الدفع" : "Please select a payment method" }}');
            return false;
        }

        // UX feedback: prevent double-click + show progress
        if (btn) {
            btn.disabled = true;
            btn.dataset.originalHtml = btn.innerHTML;
            btn.innerHTML = `{{ $isArabic ? 'جاري المعالجة...' : 'Processing...' }}`;
        }
    });

    // If browser blocks submit due to HTML5 validation, re-enable button
    form.addEventListener('invalid', function() {
        if (btn) {
            btn.disabled = false;
            if (btn.dataset.originalHtml) btn.innerHTML = btn.dataset.originalHtml;
        }
    }, true);
});
</script>
@endsection
