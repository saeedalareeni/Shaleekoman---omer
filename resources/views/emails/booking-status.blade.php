<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $notification->title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #127664 0%, #0e5a4c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 15px;
            font-size: 14px;
        }
        .status-confirmed {
            background-color: #28a745;
            color: white;
        }
        .status-rejected {
            background-color: #dc3545;
            color: white;
        }
        .status-cancelled {
            background-color: #ffc107;
            color: #333;
        }
        .content {
            padding: 30px;
        }
        .message-box {
            background-color: #f8f9fa;
            border-right: 4px solid #127664;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .booking-details {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #666;
        }
        .detail-value {
            color: #333;
            font-weight: 500;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #127664 0%, #0e5a4c 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            opacity: 0.9;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .success-icon {
            color: #28a745;
        }
        .error-icon {
            color: #dc3545;
        }
        .warning-icon {
            color: #ffc107;
        }
        @media (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .header h1 {
                font-size: 22px;
            }
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ __('شاليك عُمان') }}</h1>
            @if($status == 'confirmed')
                <span class="status-badge status-confirmed">{{ __('عرض مؤكد') }}</span>
            @elseif($status == 'rejected')
                <span class="status-badge status-rejected">{{ __('عرض مرفوض') }}</span>
            @elseif($status == 'cancelled')
                <span class="status-badge status-cancelled">{{ __('عرض ملغي') }}</span>
            @endif
        </div>

        <div class="content">
            <div style="text-align: center;">
                @if($status == 'confirmed')
                    <div class="icon success-icon">✓</div>
                @elseif($status == 'rejected')
                    <div class="icon error-icon">✗</div>
                @elseif($status == 'cancelled')
                    <div class="icon warning-icon">⚠</div>
                @endif
            </div>

            <h2 style="text-align: center; color: #333;">{{ $notification->title }}</h2>
            
            <div class="message-box">
                <p style="margin: 0;">{{ $notification->message }}</p>
            </div>

            <div class="booking-details">
                <h3 style="color: #127664; margin-top: 0;">{{ __('تفاصيل العرض') }}</h3>
                
                <div class="detail-row">
                    <span class="detail-label">{{ __('رقم العرض') }}:</span>
                    <span class="detail-value">{{ $booking->booking_number }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">{{ __('الشاليه') }}:</span>
                    <span class="detail-value">{{ app()->getLocale() == 'ar' ? $booking->chalet->name : $booking->chalet->name_en }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">{{ __('تاريخ الوصول') }}:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->checkin_date)->format('Y/m/d') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">{{ __('تاريخ المغادرة') }}:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->checkout_date)->format('Y/m/d') }}</span>
                </div>

                @if($status == 'confirmed')
                    <div class="detail-row">
                        <span class="detail-label">{{ __('وقت الوصول') }}:</span>
                        <span class="detail-value">{{ $booking->checkin_time ? \Carbon\Carbon::parse($booking->checkin_time)->format('g:i A') : '2:00 PM' }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">{{ __('وقت المغادرة') }}:</span>
                        <span class="detail-value">{{ $booking->checkout_time ? \Carbon\Carbon::parse($booking->checkout_time)->format('g:i A') : '12:00 PM' }}</span>
                    </div>
                @endif
                
                <div class="detail-row">
                    <span class="detail-label">{{ __('المبلغ الإجمالي') }}:</span>
                    <span class="detail-value" style="color: #127664; font-size: 18px;">{{ number_format($booking->total_amount, 2) }} {{ __('ر.ع') }}</span>
                </div>
            </div>

            @if($status == 'confirmed')
                <div style="background-color: #e3f0e9; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <p style="margin: 0; color: #127664;">
                        <strong>{{ __('ملاحظات مهمة:') }}</strong><br>
                        • {{ __('يرجى الاحتفاظ برقم العرض للرجوع إليه عند الحاجة') }}<br>
                        • {{ __('يمكنك عرض تفاصيل العرض من خلال حسابك على الموقع') }}<br>
                        • {{ __('في حالة وجود أي استفسار، لا تتردد في التواصل معنا') }}
                    </p>
                </div>
            @elseif($status == 'cancelled')
                <div style="background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <p style="margin: 0; color: #856404;">
                        <strong>{{ __('معلومات الاسترداد:') }}</strong><br>
                        {{ __('سيتم استرداد المبلغ المدفوع خلال 3-5 أيام عمل حسب سياسة البنك الخاص بك.') }}
                    </p>
                </div>
            @elseif($status == 'rejected')
                <div style="background-color: #f8d7da; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <p style="margin: 0; color: #721c24;">
                        {{ __('نأسف لعدم إمكانية تأكيد عرضك في الوقت الحالي. يمكنك البحث عن شاليهات أخرى متاحة على موقعنا.') }}
                    </p>
                </div>
            @endif

            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="button">{{ __('زيارة الموقع') }}</a>
            </div>
        </div>

        <div class="footer">
            <p style="margin: 5px 0;">{{ __('شكراً لاستخدامك شاليك عُمان') }}</p>
            <p style="margin: 5px 0;">{{ __('للمساعدة والاستفسارات:') }} support@weekendoman.com</p>
            <p style="margin: 5px 0; font-size: 12px; color: #999;">
                © {{ date('Y') }} {{ __('شاليك عُمان. جميع الحقوق محفوظة.') }}
            </p>
        </div>
    </div>
</body>
</html>
