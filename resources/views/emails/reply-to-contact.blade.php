<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رد على استفسارك</title>
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
        .content {
            padding: 30px;
        }
        .message-box {
            background: #f8f9fa;
            border-right: 4px solid #2c8e3d;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>رد على استفسارك</h1>
        </div>
        
        <div class="content">
            <p>السلام عليكم ورحمة الله وبركاته،</p>
            
            <p>نشكرك على تواصلك معنا. فيما يلي ردنا على استفسارك:</p>
            
            <div class="message-box">
                <h3>{{ $data['subject'] ?? 'رد على استفسارك' }}</h3>
                <p>{!! nl2br(e($data['message'] ?? '')) !!}</p>
            </div>
            
            <p>إذا كان لديك أي استفسارات إضافية، فلا تتردد في التواصل معنا.</p>
            
            <p>مع أطيب التحيات،<br>
            فريق {{ config('app.name') }}</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.</p>
            <p>
                <a href="{{ url('/') }}">زيارة الموقع</a> |
                <a href="{{ url('/contact-us') }}">اتصل بنا</a>
            </p>
        </div>
    </div>
</body>
</html>
