<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل مالك جديد</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            direction: rtl;
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
            background: linear-gradient(135deg, #2c8e3d 0%, #ff8c42 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header .icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        .info-box {
            background: #f8f9fa;
            border-right: 4px solid #2c8e3d;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
            width: 120px;
            flex-shrink: 0;
        }
        .info-value {
            color: #212529;
            flex: 1;
        }
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #2c8e3d 0%, #3fb054 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: transform 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .footer a {
            color: #2c8e3d;
            text-decoration: none;
        }
        .alert {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">👤</div>
            <h1>تسجيل مالك جديد</h1>
        </div>
        
        <div class="content">
            <p>السلام عليكم ورحمة الله وبركاته،</p>
            
            <div class="alert">
                <strong>⚠️ تنبيه:</strong> قام مالك جديد بالتسجيل في الموقع ويحتاج إلى المراجعة والموافقة.
            </div>
            
            <h3>📋 معلومات المالك:</h3>
            
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">الاسم:</span>
                    <span class="info-value">{{ $owner->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">البريد الإلكتروني:</span>
                    <span class="info-value">{{ $owner->email }}</span>
                </div>
                @if($owner->phone)
                <div class="info-row">
                    <span class="info-label">رقم الهاتف:</span>
                    <span class="info-value">{{ $owner->phone }}</span>
                </div>
                @endif
                @if($owner->address)
                <div class="info-row">
                    <span class="info-label">العنوان:</span>
                    <span class="info-value">{{ $owner->address }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">تاريخ التسجيل:</span>
                    <span class="info-value">{{ $owner->created_at->format('Y-m-d H:i:s') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">الحالة:</span>
                    <span class="info-value">
                        @if($owner->is_active)
                            <span style="color: green;">✅ نشط</span>
                        @else
                            <span style="color: orange;">⏳ في انتظار التفعيل</span>
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="{{ url('/owners') }}" class="btn">
                    عرض جميع المالكين
                </a>
            </div>
            
            <p><strong>ملاحظة:</strong> يرجى مراجعة بيانات المالك والتحقق منها قبل تفعيل الحساب.</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.</p>
            <p>هذا البريد الإلكتروني تم إرساله تلقائياً من النظام.</p>
            <p>
                <a href="{{ url('/') }}">زيارة الموقع</a> |
                <a href="{{ url('/admin') }}">لوحة التحكم</a>
            </p>
        </div>
    </div>
</body>
</html>
