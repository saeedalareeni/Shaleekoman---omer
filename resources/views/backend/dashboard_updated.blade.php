@extends('backend.layouts.master')

@section('page_title', trans('back.dashboard'))

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .dashboard-container {
        padding: 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }
    
    .welcome-header {
        background: linear-gradient(135deg, #127664, #0d5d4e);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .welcome-header h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .welcome-header p {
        font-size: 16px;
        opacity: 0.9;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border: none;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .stat-card .icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }
    
    .stat-card.primary .icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .stat-card.success .icon {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: white;
    }
    
    .stat-card.warning .icon {
        background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
        color: white;
    }
    
    .stat-card.danger .icon {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        color: white;
    }
    
    .stat-card.info .icon {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: white;
    }
    
    .stat-card .value {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }
    
    .stat-card .label {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
    }
    
    .stat-card .change {
        font-size: 12px;
        margin-top: 10px;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-block;
    }
    
    .stat-card .change.positive {
        background: #d4edda;
        color: #155724;
    }
    
    .stat-card .change.negative {
        background: #f8d7da;
        color: #721c24;
    }
    
    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .chart-card h5 {
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
    }
    
    .recent-activities {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.3s;
    }
    
    .activity-item:hover {
        background: #f8f9fa;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 3px;
    }
    
    .activity-time {
        font-size: 12px;
        color: #999;
    }
    
    .quick-actions {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 12px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s;
        margin-bottom: 15px;
    }
    
    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        color: #127664;
    }
    
    .action-btn i {
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .action-btn span {
        font-size: 14px;
        font-weight: 500;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 10px;
        }
        
        .welcome-header {
            padding: 20px;
        }
        
        .welcome-header h1 {
            font-size: 24px;
        }
        
        .stat-card {
            padding: 20px;
        }
        
        .stat-card .value {
            font-size: 28px;
        }
        
        .col-md-3 {
            margin-bottom: 15px;
        }
    }
    
    @media (max-width: 576px) {
        .stat-card .value {
            font-size: 24px;
        }
        
        .action-btn {
            padding: 15px;
        }
        
        .action-btn i {
            font-size: 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Welcome Header -->
    <div class="welcome-header">
        <h1>مرحباً بك في لوحة التحكم</h1>
        <p>{{ date('l, d F Y') }} - نظرة عامة على أداء الموقع</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card primary">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="value" id="visitors-count">{{ number_format(\App\Models\View::whereNull('chalet_id')->count()) }}</div>
                <div class="label">زوار الموقع</div>
                <div class="change positive">
                    <i class="fas fa-arrow-up"></i> +12% من الشهر الماضي
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card success">
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="value" id="chalets-count">{{ number_format(\App\Models\Chalet::count()) }}</div>
                <div class="label">الشاليهات المسجلة</div>
                <div class="change positive">
                    <i class="fas fa-arrow-up"></i> +5 جديد هذا الأسبوع
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card warning">
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="value" id="bookings-count">{{ number_format(\App\Models\Booking::count()) }}</div>
                <div class="label">إجمالي الحجوزات</div>
                <div class="change positive">
                    <i class="fas fa-arrow-up"></i> +8% من الشهر الماضي
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card danger">
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="value">{{ number_format(\App\Models\Booking::where('payment_status', 'paid')->sum('total_amount'), 2) }}</div>
                <div class="label">إجمالي الإيرادات (ر.ع)</div>
                <div class="change positive">
                    <i class="fas fa-arrow-up"></i> +15% من الشهر الماضي
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Statistics -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card info">
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="value">{{ number_format(\App\Models\Customer::count()) }}</div>
                <div class="label">العملاء المسجلين</div>
                <div class="change positive">
                    <i class="fas fa-arrow-up"></i> +20 جديد اليوم
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card primary">
                <div class="icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="value">{{ number_format(\App\Models\Owner::count()) }}</div>
                <div class="label">ملاك الشاليهات</div>
                <div class="change positive">
                    <i class="fas fa-arrow-up"></i> +3 جديد هذا الأسبوع
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card success">
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="value">{{ number_format(\App\Models\Review::avg('rating'), 1) }}/5</div>
                <div class="label">متوسط التقييمات</div>
                <div class="change positive">
                    <i class="fas fa-arrow-up"></i> تحسن بنسبة 5%
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card warning">
                <div class="icon">
                    <i class="fas fa-percentage"></i>
                </div>
                @php
                    $totalChalets = \App\Models\Chalet::count();
                    $occupiedToday = \App\Models\Booking::whereDate('checkin_date', '<=', now())
                        ->whereDate('checkout_date', '>=', now())
                        ->whereIn('status', ['confirmed', 'active'])
                        ->count();
                    $occupancyRate = $totalChalets > 0 ? round(($occupiedToday / $totalChalets) * 100) : 0;
                @endphp
                <div class="value">{{ $occupancyRate }}%</div>
                <div class="label">نسبة الإشغال اليوم</div>
                <div class="change {{ $occupancyRate > 50 ? 'positive' : 'negative' }}">
                    <i class="fas fa-{{ $occupancyRate > 50 ? 'arrow-up' : 'arrow-down' }}"></i> 
                    {{ $occupancyRate > 50 ? 'أداء ممتاز' : 'يحتاج تحسين' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="quick-actions">
                <h5 class="mb-3"><i class="fas fa-bolt"></i> إجراءات سريعة</h5>
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('chalets.create') }}" class="action-btn">
                            <i class="fas fa-plus-circle text-success"></i>
                            <span>إضافة شاليه</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('owners.create') }}" class="action-btn">
                            <i class="fas fa-user-plus text-primary"></i>
                            <span>إضافة مالك</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('bookings.index') }}" class="action-btn">
                            <i class="fas fa-list text-warning"></i>
                            <span>عرض الحجوزات</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.settings') }}" class="action-btn">
                            <i class="fas fa-cog text-danger"></i>
                            <span>الإعدادات</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="recent-activities">
                <h5 class="mb-3"><i class="fas fa-history"></i> آخر النشاطات</h5>
                @php
                    $recentBookings = \App\Models\Booking::latest()->take(5)->get();
                @endphp
                @foreach($recentBookings as $booking)
                <div class="activity-item">
                    <div class="activity-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">حجز جديد #{{ $booking->booking_number }}</div>
                        <div class="activity-time">{{ $booking->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="activity-amount">
                        <strong>{{ number_format($booking->total_amount, 2) }} ر.ع</strong>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Auto refresh statistics every 30 seconds
setInterval(function() {
    // You can add AJAX calls here to update statistics in real-time
    console.log('Refreshing statistics...');
}, 30000);

// Animate numbers on page load
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.value');
    counters.forEach(counter => {
        const target = parseInt(counter.innerText.replace(/,/g, ''));
        const increment = target / 100;
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.innerText = Math.ceil(current).toLocaleString();
                setTimeout(updateCounter, 10);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };
        
        updateCounter();
    });
});
</script>
@endpush
