<!DOCTYPE html>
<html>
<head>
    <title>Test Notifications</title>
    <meta charset="utf-8">
    <style>
        .notification {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px;
            background: #f9f9f9;
        }
        .data-field {
            margin: 5px 0;
            padding: 5px;
            background: #fff;
        }
    </style>
</head>
<body>
    <h1>اختبار الإشعارات للمالك 4</h1>
    
    @php
        $notifications = \App\Models\Notification::where('owner_id', 4)
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();
    @endphp
    
    @foreach($notifications as $notification)
        <div class="notification">
            <h3>إشعار #{{ $notification->id }}</h3>
            <p><strong>النوع:</strong> {{ $notification->type }}</p>
            <p><strong>العنوان عربي:</strong> {{ $notification->title_ar }}</p>
            <p><strong>العنوان إنجليزي:</strong> {{ $notification->title_en }}</p>
            <p><strong>الرسالة عربي:</strong> {{ $notification->message_ar }}</p>
            <p><strong>الرسالة إنجليزي:</strong> {{ $notification->message_en }}</p>
            <p><strong>نوع الأيقونة:</strong> {{ $notification->icon_type }}</p>
            <p><strong>مقروء:</strong> {{ $notification->is_read ? 'نعم' : 'لا' }}</p>
            
            <h4>البيانات (Data):</h4>
            @if($notification->data && is_array($notification->data))
                @foreach($notification->data as $key => $value)
                    <div class="data-field">
                        <strong>{{ $key }}:</strong> {{ $value }}
                    </div>
                @endforeach
            @else
                <p>لا توجد بيانات أو البيانات ليست array</p>
                <p>نوع البيانات: {{ gettype($notification->data) }}</p>
                <p>البيانات الخام: {{ json_encode($notification->data) }}</p>
            @endif
            
            <hr>
            <h4>اختبار JSON:</h4>
            <pre>{{ json_encode($notification->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    @endforeach
    
    @if($notifications->count() == 0)
        <p>لا توجد إشعارات للمالك 4</p>
    @endif
</body>
</html>
