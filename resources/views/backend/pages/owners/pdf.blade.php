<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تقرير المالكين - {{ date('Y-m-d') }}</title>
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
            background: linear-gradient(135deg, #2c8e3d 0%, #ff8c42 100%);
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
        
        .status-active {
            background: #d4edda;
            color: #155724;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 12px;
            display: inline-block;
        }
        
        .status-inactive {
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
        <p>تقرير المالكين - {{ date('Y-m-d H:i') }}</p>
    </div>
    
    <!-- Statistics -->
    <div class="info-section">
        <h3>الإحصائيات</h3>
        <div class="info-grid">
            <div class="info-card">
                <div class="number">{{ $totalOwners ?? $owners->count() }}</div>
                <div class="label">إجمالي المالكين</div>
            </div>
            <div class="info-card">
                <div class="number">{{ $activeOwners ?? $owners->where('is_active', 1)->count() }}</div>
                <div class="label">المالكين النشطين</div>
            </div>
            <div class="info-card">
                <div class="number">{{ $inactiveOwners ?? $owners->where('is_active', 0)->count() }}</div>
                <div class="label">غير النشطين</div>
            </div>
            <div class="info-card">
                <div class="number">{{ $totalChalets ?? $owners->sum(function($owner) { return $owner->chalets->count(); }) }}</div>
                <div class="label">إجمالي الشاليهات</div>
            </div>
        </div>
    </div>
    
    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th width="30">#</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الهاتف</th>
                <th>عدد الشاليهات</th>
                <th>العمولة</th>
                <th>إجمالي الحجوزات</th>
                <th>الصافي</th>
                <th>الحالة</th>
                <th>تاريخ التسجيل</th>
            </tr>
        </thead>
        <tbody>
            @foreach($owners as $index => $owner)
                @php
                    $bookings = $owner->chalets()->with('bookings')->get()->pluck('bookings')->flatten();
                    $totalAmount = $bookings->sum('total_amount');
                    $commissionPercentage = $owner->commission ?? 0;
                    $totalCommission = ($totalAmount * $commissionPercentage) / 100;
                    $expenses = $owner->expenses->sum('amount');
                    $netAmount = ($totalAmount - $totalCommission) - $expenses;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $owner->name }}</strong></td>
                    <td>{{ $owner->email ?: 'غير محدد' }}</td>
                    <td>{{ $owner->phone }}</td>
                    <td>{{ $owner->chalets->count() }}</td>
                    <td>{{ $commissionPercentage }}%</td>
                    <td>{{ number_format($totalAmount, 2) }} ريال</td>
                    <td><strong>{{ number_format($netAmount, 2) }} ريال</strong></td>
                    <td>
                        @if($owner->is_active)
                            <span class="status-active">نشط</span>
                        @else
                            <span class="status-inactive">غير نشط</span>
                        @endif
                    </td>
                    <td>{{ $owner->created_at->format('Y-m-d') }}</td>
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
