@extends('frontend.layouts.weekend_master')

@php
    $isArabic = app()->getLocale() == 'ar';
@endphp

@section('page_title')
    {{ $isArabic ? 'وحدات ' . $owner->name : $owner->name . ' Units' }}
@endsection

@section('css')
<style>
    /* Page Header */
    .owner-header {
        background: linear-gradient(135deg, #127664 0%, #159265 100%);
        padding: 60px 0;
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
    }
    
    .owner-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .owner-info {
        text-align: center;
        color: white;
        position: relative;
        z-index: 1;
    }
    
    .owner-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    
    .owner-avatar img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .owner-name {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .owner-stats {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-top: 30px;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: 700;
        display: block;
    }
    
    .stat-label {
        font-size: 14px;
        opacity: 0.9;
    }
    
    /* Chalets Grid */
    .chalets-section {
        padding: 0 15px;
    }
    
    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: #FF6B35;
    }
    
    /* Service Card Styles - Same as Homepage */
    .service-card {
        background: white !important;
        border-radius: 15px !important;
        overflow: hidden !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.3s ease !important;
        height: 100% !important;
        border: none !important;
    }
    
    .service-card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15) !important;
    }
    
    .service-image {
        position: relative;
        height: 200px !important;
        overflow: hidden !important;
        margin: 0 !important;
    }
    
    .service-image img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        display: block !important;
    }
    
    .discount-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #127664;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .discount-badge.discount-orange {
        background: #FF6B35;
    }
    
    .service-content {
        padding: 15px !important;
        background: white !important;
    }
    
    .service-price-tag {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }
    
    .service-price-tag del {
        color: #999;
        font-size: 14px;
    }
    
    .service-price-tag .fw-medium {
        color: #127664;
        font-size: 18px;
        font-weight: 600;
    }
    
    .service-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .service-location {
        color: #666;
        font-size: 14px;
        margin-bottom: 12px;
    }
    
    .service-tags {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }
    
    .tag {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }
    
    .tag-pool {
        background: #e3f2fd;
        color: #1976d2;
    }
    
    .tag-beachfront {
        background: #fff3e0;
        color: #f57c00;
    }
    
    .tag-beach {
        background: #e0f2f1;
        color: #00796b;
    }
    
    .tag-garden {
        background: #e8f5e9;
        color: #2e7d32;
    }
    
    .tag-mountain {
        background: #f3e5f5;
        color: #7b1fa2;
    }
    
    .service-host {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 0;
        border-top: 1px solid #f0f0f0;
    }
    
    .host-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .host-info {
        display: flex;
        flex-direction: column;
    }
    
    .host-name {
        font-size: 13px;
        font-weight: 600;
        color: #333;
    }
    
    .host-label {
        font-size: 11px;
        color: #999;
    }
    
    .service-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px !important;
        padding-top: 15px !important;
        border-top: 1px solid #f0f0f0 !important;
    }
    
    .btn-view-details {
        background: #127664;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-view-details:hover {
        background: #0e5a4c;
        transform: translateY(-1px);
    }
    
    .btn-wishlist-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1px solid #e0e0e0;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-wishlist-circle:hover {
        background: #f5f5f5;
        border-color: #127664;
    }
    
    .btn-wishlist-circle.active {
        background: #fff5f5;
        border-color: #ff4444;
    }
    
    .btn-wishlist-circle.active svg path {
        fill: #ff4444;
        stroke: #ff4444;
    }
    
    /* Column Layout for Cards */
    .col-xl-2-4 {
        flex: 0 0 20%;
        max-width: 20%;
    }
    
    @media (max-width: 1399px) {
        .col-xl-2-4 {
            flex: 0 0 25%;
            max-width: 25%;
        }
    }
    
    @media (max-width: 991px) {
        .col-xl-2-4 {
            flex: 0 0 33.333%;
            max-width: 33.333%;
        }
    }
    
    @media (max-width: 767px) {
        .col-xl-2-4 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }
    
    @media (max-width: 575px) {
        .col-xl-2-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }
    
    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 30px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .empty-icon svg {
        width: 60px;
        height: 60px;
        color: #dee2e6;
    }
    
    .empty-title {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }
    
    .empty-text {
        color: #666;
        font-size: 16px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .owner-header {
            padding: 40px 0;
        }
        
        .owner-name {
            font-size: 24px;
        }
        
        .owner-stats {
            gap: 20px;
        }
        
        .stat-number {
            font-size: 22px;
        }
        
        .chalet-features {
            flex-wrap: wrap;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
<!-- Owner Header -->
<div class="owner-header">
    <div class="container">
        <div class="owner-info">
            <div class="owner-avatar">
                <img src="{{ asset('frontend/images/green-profile-image.png') }}" alt="{{ $owner->name }}">
            </div>
            <h1 class="owner-name">{{ $owner->name }}</h1>
            <p style="opacity: 0.9; font-size: 16px;">{{ $isArabic ? 'مضيف موثوق' : 'Verified Host' }}</p>
            
            <div class="owner-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $chalets->count() }}</span>
                    <span class="stat-label">{{ $isArabic ? 'وحدة' : 'Units' }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">4.5</span>
                    <span class="stat-label">{{ $isArabic ? 'التقييم' : 'Rating' }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">87</span>
                    <span class="stat-label">{{ $isArabic ? 'تقييم' : 'Reviews' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chalets Section -->
<div class="container chalets-section">
    <h2 class="section-title">{{ $isArabic ? 'جميع الوحدات' : 'All Units' }}</h2>
    
    <div class="row g-4">
        @forelse($chalets as $chalet)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2-4">
                <div class="service-card">
                    <div class="service-image">
                        @if($chalet->images && $chalet->images->first())
                            <img src="{{ asset($chalet->images->first()->image) }}" alt="{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80" alt="{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}">
                        @endif
                        @php
                            $defaultPrice = $chalet->default_day_price;
                            $holidayPrice = $chalet->holiday_day_price;
                            $discountPercentage = 0;
                            if($holidayPrice > $defaultPrice) {
                                $discountPercentage = round((($holidayPrice - $defaultPrice) / $holidayPrice) * 100);
                            }
                        @endphp
                        @if($discountPercentage > 0)
                            @if($discountPercentage < 30)
                                <span class="discount-badge discount-orange">{{ $discountPercentage }}% {{ $isArabic ? 'خصم' : 'off' }}</span>
                            @else
                                <span class="discount-badge">{{ $discountPercentage }}% {{ $isArabic ? 'خصم' : 'off' }}</span>
                            @endif
                        @endif
                    </div>
                    <div class="service-content">
                        <div class="service-price-tag">
                            @if($holidayPrice > $defaultPrice)
                                <del class="per-night">{{ number_format($holidayPrice, 0) }}</del>
                            @endif
                            <span class="fw-medium">{{ number_format($defaultPrice, 0) }} {{ $isArabic ? 'ر.س' : 'SAR' }}</span>
                        </div>
                        <h3 class="service-title">{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}</h3>
                        <p class="service-location">{{ $isArabic ? $chalet->city->name_ar : $chalet->city->name_en }} - {{ $isArabic ? $chalet->area->name_ar : $chalet->area->name_en }}</p>
                        <div class="service-tags">
                            @if($chalet->has_pool)
                                <span class="tag tag-pool">{{ $isArabic ? 'مسبح' : 'Pool' }}</span>
                            @endif
                            @if($chalet->has_beachfront)
                                <span class="tag tag-beachfront">{{ $isArabic ? 'على الشاطئ' : 'Beachfront' }}</span>
                            @endif
                            @if($chalet->has_beach)
                                <span class="tag tag-beach">{{ $isArabic ? 'شاطئ' : 'Beach' }}</span>
                            @endif
                            @if($chalet->has_garden)
                                <span class="tag tag-garden">{{ $isArabic ? 'حديقة' : 'Garden' }}</span>
                            @endif
                            @if($chalet->has_mountain_view)
                                <span class="tag tag-mountain">{{ $isArabic ? 'إطلالة جبلية' : 'Mountain View' }}</span>
                            @endif
                        </div>
                        <div class="service-host">
                            <img src="{{ asset('frontend/images/green-profile-image.png') }}" alt="Host" class="host-avatar">
                            <div class="host-info">
                                <span class="host-name">{{ $owner->name }}</span>
                                <span class="host-label">{{ $isArabic ? 'مالك العقار' : 'Real estate owner' }}</span>
                            </div>
                        </div>
                        <div class="service-actions">
                            <button class="btn-view-details" onclick="window.location.href='{{ route('showChalet', $chalet->slug) }}'">{{ $isArabic ? 'عرض التفاصيل' : 'View Details' }}</button>
                            <button class="btn-wishlist-circle {{ auth('customer')->check() && auth('customer')->user()->wishlist()->where('chalet_id', $chalet->id)->exists() ? 'active' : '' }}" data-chalet-id="{{ $chalet->id }}">
                                <svg width="30" height="30" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.496 14.9292C9.224 15.0236 8.776 15.0236 8.504 14.9292C6.184 14.1506 1 10.9022 1 5.39663C1 2.96629 2.992 1 5.448 1C6.904 1 8.192 1.69214 9 2.7618C9.808 1.69214 11.104 1 12.552 1C15.008 1 17 2.96629 17 5.39663C17 10.9022 11.816 14.1506 9.496 14.9292Z" stroke="#159265" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <h3 class="empty-title">{{ $isArabic ? 'لا توجد وحدات متاحة' : 'No Units Available' }}</h3>
                    <p class="empty-text">{{ $isArabic ? 'لا توجد وحدات متاحة حالياً من هذا المضيف' : 'No units are currently available from this host' }}</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Wishlist functionality
    document.querySelectorAll('.btn-wishlist-circle').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const chaletId = this.dataset.chaletId;
            
            if (!chaletId) {
                console.error('No chalet ID found');
                return;
            }

            if (!@json(auth('customer')->check())) {
                if (confirm('{{ $isArabic ? "يجب تسجيل الدخول أولاً لإضافة الشاليه إلى المفضلة. هل تريد الذهاب إلى صفحة تسجيل الدخول؟" : "Please login first to add this chalet to wishlist. Do you want to go to login page?" }}')) {
                    window.location.href = '{{ route("login") }}';
                }
                return;
            }
            
            const btn = this;
            btn.disabled = true;
                
            const wishlistUrl = @json(route('wishlist.toggle', ['chalet' => '__CHALET_ID__']));

            fetch(wishlistUrl.replace('__CHALET_ID__', encodeURIComponent(chaletId)), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'added') {
                    btn.classList.add('active');
                    showToastNotification('success', data.message || '{{ $isArabic ? "تم إضافة الشاليه إلى المفضلة" : "Chalet added to wishlist" }}');
                } else if (data.status === 'removed') {
                    btn.classList.remove('active');
                    showToastNotification('success', data.message || '{{ $isArabic ? "تم إزالة الشاليه من المفضلة" : "Chalet removed from wishlist" }}');
                }
                btn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                showToastNotification('error', '{{ $isArabic ? "حدث خطأ. يرجى المحاولة مرة أخرى" : "An error occurred. Please try again" }}');
                btn.disabled = false;
            });
        });
    });
    
    // Toast notification function
    function showToastNotification(type, message) {
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            animation: slideInRight 0.3s ease;
        `;
        
        toast.innerHTML = `
            <div class="toast-icon" style="font-size: 24px; color: ${type === 'success' ? '#28a745' : '#dc3545'};">
                ${type === 'success' ? '✓' : '✕'}
            </div>
            <div class="toast-message">${message}</div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    // Mark wishlist items as active on page load
    @auth('customer')
        @php
            $wishlistChaletIds = auth('customer')->user()->wishlist()->pluck('chalets.id')->toArray();
        @endphp
        const wishlistChaletIds = @json($wishlistChaletIds);
        
        document.querySelectorAll('.btn-wishlist-circle').forEach(btn => {
            const chaletId = btn.dataset.chaletId;
            if (chaletId && wishlistChaletIds.includes(parseInt(chaletId))) {
                btn.classList.add('active');
            }
        });
    @endauth
</script>

<style>
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>
@endsection
