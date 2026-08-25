<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() == 'ar' ? 'تأكيد الدفع' : 'Payment Confirmation' }}</title>
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
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px;
        }
        .success-icon {
            text-align: center;
            margin: 20px 0;
        }
        .success-icon svg {
            width: 80px;
            height: 80px;
            fill: #28a745;
        }
        .info-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #666;
        }
        .info-value {
            color: #333;
            font-weight: 500;
        }
        .amount-box {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .amount-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        .amount-value {
            font-size: 32px;
            font-weight: bold;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #127664;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        @media (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ app()->getLocale() == 'ar' ? 'تأكيد الدفع' : 'Payment Confirmation' }}</h1>
        </div>
        
        <div class="content">
            <div class="success-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                </svg>
            </div>
            
            <p style="text-align: center; font-size: 18px; color: #28a745;">
                {{ app()->getLocale() == 'ar' ? 'تم تأكيد الدفع بنجاح!' : 'Payment Confirmed Successfully!' }}
            </p>
            
            <p>
                {{ app()->getLocale() == 'ar' ? 'عزيزي' : 'Dear' }} 
                {{ $booking->customer->name ?? $booking->customer_name }},
            </p>
            
            <p>
                {{ app()->getLocale() == 'ar' ? 
                    'نود إعلامكم بأنه تم تأكيد استلام دفعتكم للعرض التالي:' : 
                    'We would like to inform you that we have confirmed receipt of your payment for the following booking:' 
                }}
            </p>
            
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">{{ app()->getLocale() == 'ar' ? 'رقم العرض:' : 'Booking Number:' }}</span>
                    <span class="info-value">{{ $booking->booking_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ app()->getLocale() == 'ar' ? 'اسم الشاليه:' : 'Chalet Name:' }}</span>
                    <span class="info-value">
                        {{ app()->getLocale() == 'ar' ? $booking->chalet->name_ar : $booking->chalet->name_en }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ app()->getLocale() == 'ar' ? 'تاريخ الوصول:' : 'Check-in Date:' }}</span>
                    <span class="info-value">{{ $booking->checkin_date }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ app()->getLocale() == 'ar' ? 'تاريخ المغادرة:' : 'Check-out Date:' }}</span>
                    <span class="info-value">{{ $booking->checkout_date }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ app()->getLocale() == 'ar' ? 'طريقة الدفع:' : 'Payment Method:' }}</span>
                    <span class="info-value">
                        @if($booking->payment_method == 'cash')
                            {{ app()->getLocale() == 'ar' ? 'نقدي' : 'Cash' }}
                        @elseif($booking->payment_method == 'bank_transfer')
                            {{ app()->getLocale() == 'ar' ? 'تحويل بنكي' : 'Bank Transfer' }}
                        @else
                            {{ $booking->payment_method }}
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="amount-box">
                <div class="amount-label">
                    {{ app()->getLocale() == 'ar' ? 'المبلغ المدفوع' : 'Amount Paid' }}
                </div>
                <div class="amount-value">
                    {{ number_format($booking->total_amount, 2) }} {{ app()->getLocale() == 'ar' ? 'ر.ع' : 'OMR' }}
                </div>
            </div>
            
            <p style="text-align: center;">
                {{ app()->getLocale() == 'ar' ? 
                    'شكراً لثقتكم بنا. نتطلع لاستضافتكم قريباً!' : 
                    'Thank you for your trust. We look forward to hosting you soon!' 
                }}
            </p>
            
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="btn">
                    {{ app()->getLocale() == 'ar' ? 'زيارة الموقع' : 'Visit Website' }}
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>
                {{ app()->getLocale() == 'ar' ? 
                    'هذا البريد الإلكتروني تم إرساله تلقائياً. الرجاء عدم الرد عليه.' : 
                    'This is an automated email. Please do not reply.' 
                }}
            </p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ app()->getLocale() == 'ar' ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' }}</p>
        </div>
    </div>
</body>
</html>
