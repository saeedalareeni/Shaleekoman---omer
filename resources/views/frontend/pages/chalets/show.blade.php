<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#127664">
    @php
        $isArabic = app()->getLocale() == 'ar';

        $shTitle = $isArabic ? ($chalet->chalet_name_ar ?: $chalet->chalet_name_en) : ($chalet->chalet_name_en ?: $chalet->chalet_name_ar);
        $shDescription = $isArabic ? ($chalet->short_description_ar ?: $chalet->short_description_en) : ($chalet->short_description_en ?: $chalet->short_description_ar);
    @endphp
    <meta name="description" content="{{ $shDescription ?: $shTitle }}">
    <title>{{ $shTitle }} — {{ $siteName ?? 'شاليك' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    <!-- Shaleek Design System (cache-busted) -->
    <link rel="stylesheet" href="{{ asset('frontend/css/shaleek-design.css') }}?v={{ @filemtime(public_path('frontend/css/shaleek-design.css')) ?: time() }}">
</head>
<body class="shaleek shaleek-has-mobile-cta">
    @include('frontend.inc._shaleek_header')

    @php
        // ===== Gallery =====
        $shImages = collect();
        if ($chalet->main_image) { $shImages->push(asset($chalet->main_image)); }
        foreach ($chalet->images as $img) {
            if ($img->image) { $shImages->push(asset($img->image)); }
        }
        $shImages = $shImages->filter()->unique()->values();
        if ($shImages->isEmpty()) { $shImages->push(asset('no_image.png')); }
        $shMainImage = $shImages->first();
        $shSecondaryImages = $shImages->slice(1, 4);

        // ===== Contact links (chalet direct fields, falling back to the owner's phone) =====
        $shWaLink = $chalet->whatsapp_link;
        $shCallLink = $chalet->phone_link;
        if ((!$shWaLink || !$shCallLink) && $chalet->owner && $chalet->owner->phone) {
            $shOwnerDigits = \App\Models\Chalet::normalizeOmaniPhone($chalet->owner->phone);
            if (!$shWaLink && $shOwnerDigits) { $shWaLink = 'https://wa.me/' . $shOwnerDigits; }
            if (!$shCallLink && $shOwnerDigits) { $shCallLink = 'tel:+' . $shOwnerDigits; }
        }
        $shContactMessage = urlencode($isArabic ? 'مرحباً، أرغب في الاستفسار عن: ' . $shTitle : 'Hello, I would like to inquire about: ' . $shTitle);
        if ($shWaLink) { $shWaLink .= (str_contains($shWaLink, '?') ? '&' : '?') . 'text=' . $shContactMessage; }

        // ===== Pricing / discount =====
        $shDiscount = 0;
        if ($chalet->default_day_price && $chalet->holiday_day_price && $chalet->holiday_day_price > $chalet->default_day_price) {
            $shDiscount = round((($chalet->holiday_day_price - $chalet->default_day_price) / $chalet->holiday_day_price) * 100);
        }

        // ===== Location =====
        $shLocation = trim(($chalet->city->name ?? '') . (($chalet->area->name ?? null) ? '، ' . $chalet->area->name : ''));

        // ===== Amenities (real flags + free-form list) =====
        $shAmenityIcons = [
            'pool' => '<path d="M2 12h20"></path><path d="M5 12V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v5"></path><path d="M2 16c2 2 4 0 6 2s4 0 6 2 4 0 6 2"></path>',
            'garden' => '<path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C19 20 22 3 22 3c-1 2-8 2.25-13 3.25S2 11.5 2 13.5s1.75 3.75 1.75 3.75C7 8 17 8 17 8z"></path>',
            'mountain' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>',
            'beach' => '<path d="M2 22s2-2 5-2 5 2 8 2 5-2 5-2V2s-2 2-5 2-5-2-8-2-5 2-5 2z"></path><line x1="2" y1="22" x2="2" y2="2"></line>',
            'wifi' => '<path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>',
            'parking' => '<circle cx="6.5" cy="16.5" r="2.5"></circle><circle cx="17.5" cy="16.5" r="2.5"></circle><path d="M3 17h2m14 0h2M5 17V9a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v8"></path>',
            'kitchen' => '<path d="M3 9l1-5h16l1 5"></path><path d="M5 9v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9"></path><line x1="9" y1="13" x2="15" y2="13"></line>',
            'ac' => '<path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"></path>',
            'majlis' => '<path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>',
            'bedroom' => '<path d="M2 22s2-2 5-2 5 2 8 2 5-2 5-2V2s-2 2-5 2-5-2-8-2-5 2-5 2z"></path><line x1="2" y1="22" x2="2" y2="2"></line>',
            'default' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path>',
        ];
        $shAmenities = [];
        if ($chalet->has_pool) { $shAmenities[] = ['icon' => 'pool', 'label' => $isArabic ? 'مسبح خاص' : 'Private pool']; }
        if ($chalet->has_garden) { $shAmenities[] = ['icon' => 'garden', 'label' => $isArabic ? 'حديقة منسّقة' : 'Landscaped garden']; }
        if ($chalet->has_mountain_view) { $shAmenities[] = ['icon' => 'mountain', 'label' => $isArabic ? 'إطلالة جبلية' : 'Mountain view']; }
        if ($chalet->has_beachfront || $chalet->has_beach) { $shAmenities[] = ['icon' => 'beach', 'label' => $isArabic ? 'قريب من الشاطئ' : 'Near the beach']; }
        if (is_array($chalet->amenities)) {
            foreach ($chalet->amenities as $a) {
                $shAmenities[] = ['icon' => 'default', 'label' => $a];
            }
        }
        if ($chalet->councils_count) {
            $shAmenities[] = ['icon' => 'majlis', 'label' => $isArabic ? $chalet->councils_count . ' مجلس' : $chalet->councils_count . ' councils'];
        }
        if ($chalet->bedrooms) {
            $shAmenities[] = ['icon' => 'bedroom', 'label' => $isArabic ? $chalet->bedrooms . ' غرف نوم' : $chalet->bedrooms . ' bedrooms'];
        }

        // ===== Owner =====
        $shOwner = $chalet->owner;
        $shOwnerName = $shOwner->name ?? ($isArabic ? 'مالك العقار' : 'Property owner');
        $shOwnerInitial = mb_substr($shOwnerName, 0, 1);
        $shOwnerListingsCount = $shOwner ? \App\Models\Chalet::where('owner_id', $shOwner->id)->where('status', 'approved')->count() : 0;
    @endphp

    <main>
        <div class="container">
            <div class="shaleek-breadcrumb">
                <a href="{{ route('shaleek.home') }}">{{ $isArabic ? 'الرئيسية' : 'Home' }}</a>
                <span>›</span>
                <a href="{{ route('showAllChalet', ['category' => $chalet->category_id]) }}">{{ $chalet->category->name ?? '' }}</a>
                <span>›</span>
                <span>{{ $shTitle }}</span>
            </div>

            <section class="shaleek-detail-hero">
                <!-- Gallery -->
                <div class="shaleek-gallery">
                    <img src="{{ $shMainImage }}" alt="{{ $shTitle }}">
                    @foreach($shSecondaryImages as $shImg)
                        <img class="shaleek-gallery-secondary" src="{{ $shImg }}" alt="">
                    @endforeach
                    @if($shImages->count() > 1)
                        <button type="button" class="shaleek-gallery-thumbs-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            {{ $isArabic ? 'عرض جميع الصور (' . $shImages->count() . ')' : 'View all photos (' . $shImages->count() . ')' }}
                        </button>
                    @endif
                </div>

                <div class="shaleek-detail-grid">
                    <!-- Main column -->
                    <div class="shaleek-detail-main">
                        <div class="shaleek-detail-top">
                            <div>
                                <span class="shaleek-detail-cat-badge">{{ $chalet->category->name ?? '' }}</span>
                                <h1 class="shaleek-detail-title">
                                    {{ $shTitle }}
                                    @if($chalet->is_feature)
                                        <span class="shaleek-detail-verified-inline"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 1.8 3 .1 1 2.8 2.4 1.8-1 2.8 1 2.8-2.4 1.8-1 2.8-3 .1L12 22l-2.4-1.8-3-.1-1-2.8L3.2 15l1-2.8-1-2.8 2.4-1.8 1-2.8 3-.1z"/><path d="M9.5 12.5l1.8 1.8 3.5-3.7" fill="none" stroke="#E6F2EF" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>{{ $isArabic ? 'موثّق' : 'Verified' }}</span>
                                    @endif
                                </h1>
                                @if($shLocation)
                                <div class="shaleek-detail-loc">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    {{ $shLocation }}
                                </div>
                                @endif
                            </div>
                            <div class="shaleek-detail-actions">
                                <button type="button" class="shaleek-icon-btn" aria-label="{{ $isArabic ? 'حفظ' : 'Save' }}" onclick="shaleekToggleWishlist(this, '{{ route('wishlist.toggle', $chalet->id) }}')">
                                    <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                </button>
                                <button type="button" class="shaleek-icon-btn" aria-label="{{ $isArabic ? 'مشاركة' : 'Share' }}" onclick="if(navigator.share){navigator.share({title: document.title, url: window.location.href})}">
                                    <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Quick stats -->
                        <div class="shaleek-quick-stats">
                            <div class="shaleek-quick-stat">
                                <div class="shaleek-quick-stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </div>
                                <div class="shaleek-quick-stat-value">{{ $chalet->max_guests ? ($isArabic ? 'حتى ' . $chalet->max_guests : 'Up to ' . $chalet->max_guests) : '—' }}</div>
                                <div class="shaleek-quick-stat-label">{{ $isArabic ? 'شخص' : 'guests' }}</div>
                            </div>
                            <div class="shaleek-quick-stat">
                                <div class="shaleek-quick-stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                                <div class="shaleek-quick-stat-value">{{ $chalet->bedrooms ?: '—' }}</div>
                                <div class="shaleek-quick-stat-label">{{ $isArabic ? 'غرف نوم' : 'bedrooms' }}</div>
                            </div>
                            <div class="shaleek-quick-stat">
                                <div class="shaleek-quick-stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12h16"></path><path d="M4 12a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4"></path><path d="M4 12v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4"></path><path d="M6 8V6a2 2 0 0 1 2-2"></path></svg>
                                </div>
                                <div class="shaleek-quick-stat-value">{{ $chalet->bathrooms ?: '—' }}</div>
                                <div class="shaleek-quick-stat-label">{{ $isArabic ? 'دورة مياه' : 'bathrooms' }}</div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($shDescription || ($isArabic ? $chalet->long_description_ar : $chalet->long_description_en))
                        <div class="shaleek-detail-section">
                            <h2>{{ $isArabic ? 'عن العقار' : 'About this property' }}</h2>
                            <p class="shaleek-detail-text">
                                {{ ($isArabic ? $chalet->long_description_ar : $chalet->long_description_en) ?: $shDescription }}
                            </p>
                        </div>
                        @endif

                        <!-- Amenities -->
                        @if(count($shAmenities))
                        <div class="shaleek-detail-section">
                            <h2>{{ $isArabic ? 'المرافق والخدمات' : 'Amenities & services' }}</h2>
                            <div class="shaleek-amenities-grid">
                                @foreach($shAmenities as $shAmenity)
                                    <div class="shaleek-amenity">
                                        <div class="shaleek-amenity-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $shAmenityIcons[$shAmenity['icon']] ?? $shAmenityIcons['default'] !!}</svg>
                                        </div>
                                        {{ $shAmenity['label'] }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Rules -->
                        @php $shRules = $isArabic ? $chalet->rules_ar : $chalet->rules_en; @endphp
                        @if($shRules || $chalet->booking_terms_ar)
                        <div class="shaleek-detail-section">
                            <h2>{{ $isArabic ? 'شروط وملاحظات' : 'Rules & notes' }}</h2>
                            <p class="shaleek-detail-text">
                                {!! nl2br(e($shRules ?: $chalet->booking_terms_ar)) !!}
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Sidebar (desktop only) -->
                    <aside class="shaleek-detail-sidebar">
                        <!-- Owner card (above price/contact) -->
                        <div class="shaleek-sidebar-owner">
                            <div class="shaleek-sidebar-owner-title">{{ $isArabic ? 'مالك العقار' : 'Property owner' }}</div>
                            <div class="shaleek-owner-card" style="margin-bottom: 0;">
                                <div class="shaleek-owner-avatar">
                                    @if($shOwner && $shOwner->image)
                                        <img src="{{ asset($shOwner->image) }}" alt="{{ $shOwnerName }}">
                                    @else
                                        {{ $shOwnerInitial }}
                                    @endif
                                </div>
                                <div class="shaleek-owner-info">
                                    <div class="shaleek-owner-label">{{ $isArabic ? 'المضيف' : 'Host' }}</div>
                                    <div class="shaleek-owner-name">{{ $shOwnerName }}</div>
                                    <div class="shaleek-owner-meta">
                                        @if($chalet->is_feature)
                                            <span class="shaleek-owner-verified">
                                                <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                                {{ $isArabic ? 'حساب موثّق' : 'Verified account' }}
                                            </span>
                                            •
                                        @endif
                                        {{ $isArabic ? $shOwnerListingsCount . ' عقارات معروضة' : $shOwnerListingsCount . ' listings' }}
                                    </div>
                                </div>
                            </div>
                            @if($chalet->instagram_url || $chalet->tiktok_url)
                            <div class="shaleek-owner-social">
                                <span class="shaleek-owner-social-label">{{ $isArabic ? 'حسابات المالك:' : 'Owner accounts:' }}</span>
                                @if($chalet->instagram_url)
                                <a href="{{ $chalet->instagram_url }}" target="_blank" rel="noopener" class="shaleek-owner-social-btn shaleek-owner-social-ig" aria-label="{{ $isArabic ? 'انستجرام المالك' : 'Owner Instagram' }}">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                </a>
                                @endif
                                @if($chalet->tiktok_url)
                                <a href="{{ $chalet->tiktok_url }}" target="_blank" rel="noopener" class="shaleek-owner-social-btn shaleek-owner-social-tt" aria-label="{{ $isArabic ? 'تيك توك المالك' : 'Owner TikTok' }}">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5.8 20.1a6.34 6.34 0 0 0 10.86-4.43V8.74a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1.84-.17z"/></svg>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="shaleek-cta-card">
                            <div class="shaleek-cta-price-row">
                                <div class="shaleek-cta-price">
                                    <span class="shaleek-cta-price-from">{{ $isArabic ? 'السعر يبدأ من' : 'Starting from' }}</span>
                                    @if($chalet->default_day_price)
                                    <div>
                                        <span class="shaleek-cta-price-current">{{ number_format((float) $chalet->default_day_price, 0) }}</span>
                                        <span class="shaleek-cta-price-unit">{{ $isArabic ? 'ر.ع / ليلة' : 'OMR / night' }}</span>
                                    </div>
                                    @else
                                    <div class="shaleek-cta-price-current" style="font-size:18px;">{{ $isArabic ? 'تواصل لمعرفة الأسعار' : 'Contact for pricing' }}</div>
                                    @endif
                                </div>
                                @if($shDiscount > 0)
                                    <span class="shaleek-cta-discount-tag">{{ $isArabic ? 'خصم ' . $shDiscount . '٪' : $shDiscount . '% off' }}</span>
                                @endif
                            </div>

                            <div class="shaleek-cta-buttons">
                                @if($shWaLink)
                                <a href="{{ $shWaLink }}" target="_blank" rel="noopener" class="shaleek-btn-whatsapp">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    {{ $isArabic ? 'تواصل عبر الواتساب' : 'Contact via WhatsApp' }}
                                </a>
                                @endif
                                @if($shCallLink)
                                <a href="{{ $shCallLink }}" class="shaleek-btn-call">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    {{ $isArabic ? 'اتصل بالمالك' : 'Call the owner' }}
                                </a>
                                @endif
                            </div>

                            <div class="shaleek-cta-note">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>
                                <span>{{ $isArabic ? 'منصة عرض فقط — تتفق مباشرةً مع المالك على التفاصيل والدفع.' : 'A listing platform only — arrange details and payment directly with the owner.' }}</span>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <!-- Similar properties -->
            @if($similarChalets->count())
            <section class="shaleek-section" style="padding-top: 0;">
                <div class="shaleek-section-header">
                    <div class="shaleek-section-title-group">
                        <div class="shaleek-section-eyebrow">{{ $isArabic ? 'عقارات مشابهة' : 'Similar properties' }}</div>
                        <h2 class="shaleek-section-title">{{ $isArabic ? 'قد تعجبك أيضاً' : 'You may also like' }}</h2>
                    </div>
                </div>
                <div class="shaleek-props-grid">
                    @foreach($similarChalets as $shSimilar)
                        @include('frontend.inc._shaleek_property_card', ['chalet' => $shSimilar])
                    @endforeach
                </div>
            </section>
            @endif
        </div>
    </main>

    <!-- Mobile sticky CTA -->
    <div class="shaleek-mobile-cta">
        <div class="shaleek-mobile-cta-price">
            <div class="shaleek-mobile-cta-from">{{ $isArabic ? 'يبدأ من' : 'From' }}</div>
            @if($chalet->default_day_price)
                <div class="shaleek-mobile-cta-price-current">{{ number_format((float) $chalet->default_day_price, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</div>
                <div class="shaleek-mobile-cta-price-unit">{{ $isArabic ? '/ ليلة' : '/ night' }}</div>
            @else
                <div class="shaleek-mobile-cta-price-current" style="font-size:14px;">{{ $isArabic ? 'تواصل' : 'Contact' }}</div>
            @endif
        </div>
        @if($shCallLink)
        <a href="{{ $shCallLink }}" class="shaleek-mobile-cta-call" aria-label="{{ $isArabic ? 'اتصل بالمالك' : 'Call the owner' }}">
            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            {{ $isArabic ? 'اتصال' : 'Call' }}
        </a>
        @endif
        @if($shWaLink)
        <a href="{{ $shWaLink }}" target="_blank" rel="noopener" class="shaleek-mobile-cta-btn">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            {{ $isArabic ? 'تواصل الآن' : 'Message now' }}
        </a>
        @endif
    </div>

    @include('frontend.inc._shaleek_footer')

    <script src="{{ asset('frontend/js/shaleek-design.js') }}?v={{ @filemtime(public_path('frontend/js/shaleek-design.js')) ?: time() }}"></script>
</body>
</html>
