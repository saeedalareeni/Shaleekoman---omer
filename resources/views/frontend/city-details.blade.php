@extends('frontend.layouts.weekend_master')

@section('page_title', $city->name . ' - ' . (app()->getLocale() == 'ar' ? 'الشاليهات والاستراحات' : 'Chalets & Rest Houses'))

@section('css')
<style>
    /* Deal Card Styles - Same as Homepage */
    .deal-card {
        background: white;
        border-radius: 20px;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .deal-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .deal-card .deal-image {
        position: relative;
        width: 100%;
        height: 240px;
        overflow: hidden;
        border-radius: 20px 20px 0 0;
    }

    .deal-card .deal-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .deal-card .deal-image:hover img {
        transform: scale(1.05);
    }

    .deal-card .deal-image .discount-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #159265;
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .deal-card .deal-content {
        padding: 15px;
        border-radius: 0 0 20px 20px;
        border: 2px solid #127664;
        border-top: none;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .deal-card .deal-content .deal-price-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 8px 16px;
        background: rgba(21, 146, 101, 0.1);
        border-radius: 20px;
        margin-bottom: 22px;
        width: fit-content;
    }

    .deal-card .deal-content .deal-price-tag span {
        font-size: 13px;
        font-weight: 600;
        color: #159265;
    }

    .deal-card .deal-content .deal-price-tag .per-night {
        font-weight: 400;
        color: rgba(21, 146, 101, 0.5);
        text-decoration: line-through;
    }

    .deal-card .deal-content .deal-title {
        font-size: 20px;
        font-weight: 500;
        color: #3EAC84;
        margin: 0 0 6px 0;
    }

    .deal-card .deal-content .deal-location {
        font-size: 14px;
        color: #1E1E1E;
        margin: 0 0 16px 0;
        font-weight: 500;
    }

    .deal-card .deal-content .deal-host {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .deal-card .deal-content .deal-host .host-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .deal-card .deal-content .deal-host .host-info {
        display: flex;
        flex-direction: column;
    }

    .deal-card .deal-content .deal-host .host-info .host-name {
        font-size: 16px;
        font-weight: 400;
        color: #1a1a1a;
    }

    .deal-card .deal-content .deal-host .host-info .host-label {
        font-size: 12px;
        color: #999;
    }

    .deal-card .deal-content .deal-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: auto;
    }

    .deal-card .deal-content .deal-actions .btn-view-details {
        flex: 1;
        background: linear-gradient(0deg, #006250 0%, #127664 100%);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .deal-card .deal-content .deal-actions .btn-view-details:hover {
        transform: translateY(-2px);
    }

    .deal-card .deal-content .deal-actions .btn-wishlist-circle {
        width: 44px;
        height: 44px;
        background: transparent;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0;
    }

    .deal-card .deal-content .deal-actions .btn-wishlist-circle:hover {
        border-color: #DF4D2D;
        background: #fff5f3;
    }

    .deal-card .deal-content .deal-actions .btn-wishlist-circle.active svg path {
        stroke: white;
        fill: white;
    }

    /* Hero Section Styles */
    .city-hero-section {
        min-height: 250px;
        display: flex;
        align-items: center;
        position: relative;
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
    }

    .min-vh-50 {
        min-height: 50vh;
    }

    @media (max-width: 767px) {
        .min-vh-50 {
            min-height: auto !important;
        }
    }

    .stat-card {
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.2) !important;
    }

    .area-card:hover {
        background: #f8f9fa !important;
        border-color: #127664 !important;
    }

    .filters-sidebar {
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .filter-group {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 1rem;
    }

    .filter-group:last-child {
        border-bottom: none;
    }

    .form-check-input:checked {
        background-color: #127664;
        border-color: #127664;
    }

    .btn-primary {
        background-color: #127664;
        border-color: #127664;
    }

    .btn-primary:hover {
        background-color: #0e5a4c;
        border-color: #0e5a4c;
    }

    .btn-outline-primary {
        color: #127664;
        border-color: #127664;
    }

    .btn-outline-primary:hover {
        background-color: #127664;
        border-color: #127664;
    }

    .text-primary {
        color: #127664 !important;
    }

    /* RTL Support */
    [dir="rtl"] .deal-card .deal-image .discount-badge {
        left: auto;
        right: 15px;
    }

    /* Mobile Responsive */
    @media (max-width: 767px) {
        /* Hero Section Mobile */
        .city-hero-section {
            min-height: 200px !important;
            padding: 60px 0 40px !important;
        }

        .city-hero-section h1 {
            font-size: 1.75rem !important;
        }

        .city-hero-section .lead {
            font-size: 0.9rem !important;
            margin-bottom: 1.5rem !important;
        }

        /* Statistics Cards Mobile */
        .stat-card {
            padding: 10px !important;
            margin-bottom: 0.5rem;
        }

        .stat-card .d-flex {
            justify-content: center !important;
        }

        .stat-card i {
            font-size: 1.2rem !important;
            margin-right: 8px !important;
        }

        .stat-card .fs-3 {
            font-size: 1.25rem !important;
        }

        .stat-card .small {
            font-size: 0.7rem !important;
        }

        /* Deal Cards Mobile - 2 per row */
        .deal-card {
            margin-bottom: 15px;
        }

        .deal-card .deal-image {
            height: 160px !important;
        }

        .deal-card .deal-content {
            padding: 12px !important;
        }

        .deal-card .deal-title {
            font-size: 16px !important;
        }

        .deal-card .deal-location {
            font-size: 12px !important;
        }

        .deal-card .deal-host {
            display: none !important; /* Hide host info on mobile */
        }

        .deal-card .deal-price-tag {
            margin-bottom: 12px !important;
            padding: 6px 12px !important;
        }

        .deal-card .deal-price-tag span {
            font-size: 12px !important;
        }

        .deal-card .deal-actions .btn-view-details {
            padding: 10px 15px !important;
            font-size: 12px !important;
        }

        .deal-card .deal-actions .btn-wishlist-circle {
            width: 38px !important;
            height: 38px !important;
        }

        .deal-card .deal-actions .btn-wishlist-circle svg {
            width: 20px !important;
            height: 20px !important;
        }

        /* Section padding mobile */
        section.py-5 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }

        /* Container padding mobile */
        .container {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        /* Breadcrumb mobile */
        .breadcrumb {
            font-size: 0.8rem !important;
            margin-bottom: 0.5rem !important;
        }
    }

    @media (max-width: 480px) {
        /* Very Small Screens */
        .city-hero-section {
            padding: 40px 0 30px !important;
        }

        .city-hero-section h1 {
            font-size: 1.5rem !important;
        }

        .city-hero-section .lead {
            font-size: 0.85rem !important;
        }

        .stat-card {
            padding: 8px !important;
        }

        .stat-card i {
            display: none !important; /* Hide icons on very small screens */
        }

        .stat-card .fs-3 {
            font-size: 1.1rem !important;
        }

        .stat-card .small {
            font-size: 0.65rem !important;
        }

        .deal-card .deal-image {
            height: 140px !important;
        }

        .deal-card .deal-content {
            padding: 10px !important;
        }

        .deal-card .deal-title {
            font-size: 14px !important;
            margin-bottom: 4px !important;
        }

        .deal-card .deal-location {
            font-size: 11px !important;
            margin-bottom: 10px !important;
        }

        .deal-card .deal-price-tag {
            padding: 4px 10px !important;
        }

        .deal-card .deal-actions .btn-view-details {
            padding: 8px 12px !important;
            font-size: 11px !important;
        }

        /* Section title mobile */
        section h2 {
            font-size: 1.25rem !important;
            margin-bottom: 1rem !important;
        }

        /* Hide view all button text on very small screens */
        .btn-outline-primary {
            font-size: 0.8rem !important;
            padding: 6px 12px !important;
        }

        .btn-outline-primary .fas {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')

<!-- Hero Section with City Image -->
<section class="city-hero-section" style="background: linear-gradient(135deg, rgba(18, 118, 100, 0.9) 0%, rgba(18, 118, 100, 0.7) 100%), url('{{ $city->image ? asset($city->image) : 'https://images.unsplash.com/photo-1512632578888-169bbbc64f33?w=1920&q=80' }}') center/cover;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('shaleek.home') }}" class="text-white-50">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $city->name }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">{{ $city->name }}</h1>
                <p class="lead text-white mb-4">{{ app()->getLocale() == 'ar' ? 'اكتشف أفضل الشاليهات والاستراحات في' : 'Discover the best chalets and rest houses in' }} {{ $city->name }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Content with All Chalets -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4">{{ app()->getLocale() == 'ar' ? 'جميع الشاليهات' : 'All Chalets' }}</h2>

        <!-- Chalets Grid -->
        <div class="row g-3">
            @forelse($chalets as $chalet)
            <div class="col-6 col-md-6 col-lg-3">
                <div class="deal-card">
                    <div class="deal-image">
                        <a href="{{ route('showChalet', $chalet->slug) }}">
                            <img src="{{ $chalet->images->first() ? asset($chalet->images->first()->image) : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80' }}"
                                 alt="{{ $chalet->name }}">
                        </a>
                        @php
                            $defaultPrice = $chalet->default_day_price ?? 100;
                            $holidayPrice = $chalet->holiday_day_price ?? 150;
                            $actualDiscount = 0;
                            if ($holidayPrice > $defaultPrice) {
                                $actualDiscount = round((($holidayPrice - $defaultPrice) / $holidayPrice) * 100);
                            }
                        @endphp
                        @if($actualDiscount > 0)
                            <span class="discount-badge">{{ $actualDiscount }}% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                        @endif
                    </div>
                    <div class="deal-content">
                        <div class="deal-price-tag">
                            @if($holidayPrice > $defaultPrice)
                                <del class="per-night">{{ number_format($holidayPrice, 0) }}</del>
                            @endif
                            <span class="fw-medium">{{ number_format($defaultPrice, 0) }} ر.ع </span>
                        </div>
                        <h3 class="deal-title">{{ $chalet->name }}</h3>
                        <p class="deal-location">{{ $city->name }}{{ $chalet->area ? ' / '.$chalet->area->name : '' }}</p>
                        <div class="deal-host">
                            <img src="https://i.pravatar.cc/150?img={{ $chalet->owner->id ?? rand(1, 50) }}" alt="Host" class="host-avatar">
                            <div class="host-info">
                                <span class="host-name">{{ $chalet->owner->name ?? 'أحمد محمد' }}</span>
                                <span class="host-label">{{ app()->getLocale() == 'ar' ? 'مالك العقار' : 'Real estate owner' }}</span>
                            </div>
                        </div>
                        <div class="deal-actions">
                            <button class="btn-view-details" onclick="window.location.href='{{ route('showChalet', $chalet->slug) }}'">
                                {{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}
                            </button>
                            <button class="btn-wishlist-circle {{ auth('customer')->check() && auth('customer')->user()->wishlist()->where('chalet_id', $chalet->id)->exists() ? 'active' : '' }}" data-chalet-id="{{ $chalet->id }}">
                                <span>
                                    <svg width="30" height="30" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.496 15.0542C9.224 15.1486 8.776 15.1486 8.504 15.0542C6.184 14.2756 1 11.0272 1 5.52163C1 3.09129 2.992 1.125 5.448 1.125C6.904 1.125 8.192 1.81714 9 2.8868C9.808 1.81714 11.104 1.125 12.552 1.125C15.008 1.125 17 3.09129 17 5.52163C17 11.0272 11.816 14.2756 9.496 15.0542Z" stroke="#159265" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-home fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">{{ app()->getLocale() == 'ar' ? 'لا توجد شاليهات متاحة حالياً' : 'No chalets available at the moment' }}</h4>
                    <p class="text-muted">{{ app()->getLocale() == 'ar' ? 'يرجى المحاولة لاحقاً' : 'Please try again later' }}</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($chalets->hasPages())
        <div class="mt-5">
            {{ $chalets->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</section>

@endsection

@section('js')
<script>
    // Wishlist functionality
    document.querySelectorAll('.btn-wishlist-circle').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const chaletId = this.dataset.chaletId;

            if (!@json(auth('customer')->check())) {
                if (confirm('{{ app()->getLocale() == "ar" ? "يجب تسجيل الدخول أولاً لإضافة الشاليه إلى المفضلة. هل تريد الذهاب إلى صفحة تسجيل الدخول؟" : "Please login first to add this chalet to wishlist. Do you want to go to login page?" }}')) {
                    window.location.href = '{{ route("login") }}';
                }
                return;
            }

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
                    this.classList.add('active');
                } else {
                    this.classList.remove('active');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>
@endsection
