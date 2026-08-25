<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تقرير الشاليهات - {{ date('Y-m-d') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            direction: rtl;
            padding: 20px;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #2c8e3d 0%, #17a2b8 100%);
            color: white;
            border-radius: 10px;
        }
        
        .header img {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .info-section h3 {
            color: #2c8e3d;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        
        .info-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #e9ecef;
        }
        
        .info-card .number {
            font-size: 24px;
            font-weight: bold;
            color: #2c8e3d;
        }
        
        .info-card .label {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        thead {
            background: #2c8e3d;
            color: white;
        }
        
        th, td {
            padding: 12px;
            text-align: right;
            border: 1px solid #dee2e6;
        }
        
        th {
            font-weight: bold;
            font-size: 14px;
        }
        
        td {
            font-size: 13px;
        }
        
        tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        tbody tr:hover {
            background: #e9ecef;
        }
        
        .status-approved {
            background: #d4edda;
            color: #155724;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 12px;
            display: inline-block;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 12px;
            display: inline-block;
        }
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 12px;
            display: inline-block;
        }
        
        .footer {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: center;
        }
        
        .footer p {
            color: #6c757d;
            font-size: 12px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .header {
                background: #2c8e3d !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        @if($setting && $setting->logo)
            <img src="{{ asset($setting->logo) }}" alt="Logo" style="width: 100px; height: 100px;">
        @endif
        <h1>{{ $setting ? (app()->getLocale() == 'ar' ? $setting->website_name_ar : $setting->website_name_en) : 'Shaleek' }}</h1>
        <p>تقرير الشاليهات - {{ date('Y-m-d H:i') }}</p>
    </div>
    
    <!-- Statistics -->
    <div class="info-section">
        <h3>الإحصائيات</h3>
        <div class="info-grid">
            <div class="info-card">
                <div class="number">{{ $totalChalets ?? $chalets->count() }}</div>
                <div class="label">إجمالي الشاليهات</div>
            </div>
            <div class="info-card">
                <div class="number">{{ $approvedChalets ?? $chalets->where('status', 'approved')->count() }}</div>
                <div class="label">الشاليهات المعتمدة</div>
            </div>
            <div class="info-card">
                <div class="number">{{ $pendingChalets ?? $chalets->where('status', 'pending')->count() }}</div>
                <div class="label">قيد المراجعة</div>
            </div>
            <div class="info-card">
                <div class="number">{{ $featuredChalets ?? $chalets->where('is_feature', 1)->count() }}</div>
                <div class="label">الشاليهات المميزة</div>
            </div>
        </div>
    </div>
    
    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th width="30">#</th>
                <th>اسم الشاليه</th>
                <th>المالك</th>
                <th>الموقع</th>
                <th>السعر/ليلة</th>
                <th>الحجوزات</th>
                <th>الإيرادات</th>
                <th>الحالة</th>
                <th>مميز</th>
                <th>تاريخ الإضافة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chalets as $index => $chalet)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}</strong></td>
                    <td>{{ $chalet->owner ? $chalet->owner->name : 'غير محدد' }}</td>
                    <td>
                        {{ app()->getLocale() == 'ar' ? $chalet->city->name_ar : $chalet->city->name_en }} - 
                        {{ app()->getLocale() == 'ar' ? $chalet->area->name_ar : $chalet->area->name_en }}
                    </td>
                    <td>{{ number_format($chalet->price_per_night, 2) }} ريال</td>
                    <td>{{ $chalet->bookings->count() }}</td>
                    <td>{{ number_format($chalet->bookings->sum('payment_amount'), 2) }} ريال</td>
                    <td>
                        @if($chalet->status == 'approved')
                            <span class="status-approved">معتمد</span>
                        @elseif($chalet->status == 'pending')
                            <span class="status-pending">قيد المراجعة</span>
                        @else
                            <span class="status-rejected">مرفوض</span>
                        @endif
                    </td>
                    <td>{{ $chalet->is_feature ? 'نعم' : 'لا' }}</td>
                    <td>{{ $chalet->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Footer -->
    <div class="footer">
        <p>تم إنشاء هذا التقرير بتاريخ {{ date('Y-m-d H:i:s') }}</p>
        <p>{{ $setting ? (app()->getLocale() == 'ar' ? $setting->website_name_ar : $setting->website_name_en) : 'Shaleek' }} © {{ date('Y') }}</p>
    </div>
    
    <script>
        // Auto print for PDF
        if (window.location.search.includes('print=true')) {
            window.print();
        }
    </script>
</body>
</html>
