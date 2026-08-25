<?php
/*

<!-- Services Section -->
<section class="services-section">
    <div class="container-fluid px-4">
   <h2 class="section-title text-center mb-4">{{ app()->getLocale() == 'ar' ? 'خدمات شاليك' : 'Shaleek Services' }}</h2 

 
 @php
            // جلب الفئات التي تحتوي على عقارات نشطة فقط
            $categoriesWithChalets = [];
            if(isset($categories)) {
                foreach($categories as $category) {
                    $activeChaletsCount = \App\Models\Chalet::where('category_id', $category->id)
                        ->where('status', 'approved')
                        ->count();
                    if($activeChaletsCount > 0) {
                        $categoriesWithChalets[] = $category;
                    }
                }
            }
        @endphp

        <!-- Tabs Navigation -->
        <div class="services-tabs d-flex justify-content-center gap-3 mb-5 flex-wrap">
            @if(isset($newChalets) && $newChalets->count() > 0)
                <button class="tab-btn active" data-tab="new">{{ app()->getLocale() == 'ar' ? 'جديد' : 'New' }}</button>
            @endif
            
            @if(isset($popularChalets) && $popularChalets->count() > 0)
                <button class="tab-btn {{ (!isset($newChalets) || $newChalets->count() == 0) ? 'active' : '' }}" data-tab="popular">{{ app()->getLocale() == 'ar' ? 'الأكثر شعبية' : 'Popular' }}</button>
            @endif
            
            @if(count($categoriesWithChalets) > 0)
                @foreach($categoriesWithChalets as $index => $category)
                    <button class="tab-btn {{ (!isset($newChalets) || $newChalets->count() == 0) && (!isset($popularChalets) || $popularChalets->count() == 0) && $index == 0 ? 'active' : '' }}" data-tab="category-{{ $category->id }}">
                        {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                    </button>
                @endforeach
            @endif
        </div>

        <!-- New Chalets Tab Content -->
        @if(isset($newChalets) && $newChalets->count() > 0)
        <div class="tab-content {{ isset($newChalets) && $newChalets->count() > 0 ? 'active' : '' }}" id="new">
            <div class="row g-4">
                @if(isset($newChalets) && $newChalets->count() > 0)
                    @foreach($newChalets as $chalet)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2-4">
                        <div class="service-card">
                            <div class="service-image">
                                @if($chalet->main_image)
                                    <img src="{{ asset($chalet->main_image) }}" alt="{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}" onerror="this.src='https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80'">
                                @else
                                    @php
                                        $serviceImages = [
                                            'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80',
                                            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80',
                                            'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80',
                                            'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=600&q=80',
                                            'https://images.unsplash.com/photo-1602343168117-bb8ffe3e2e9f?w=600&q=80',
                                            'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=600&q=80',
                                            'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80',
                                            'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80',
                                        ];
                                        $imageIndex = ($loop->index ?? rand(0, 7)) % count($serviceImages);
                                    @endphp
                                    <img src="{{ $serviceImages[$imageIndex] }}" alt="{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}">
                                @endif
                                @php
                                    $defaultPrice = $chalet->default_day_price ?? 410;
                                    $holidayPrice = $chalet->holiday_day_price ?? 645;
                                    $actualDiscount = 0;
                                    if ($holidayPrice > $defaultPrice) {
                                        $actualDiscount = round((($holidayPrice - $defaultPrice) / $holidayPrice) * 100);
                                    }
                                @endphp
                                @if($actualDiscount > 0)
                                    @if($actualDiscount < 50)
                                        <span class="discount-badge discount-orange">{{ $actualDiscount }}% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                                    @else
                                        <span class="discount-badge">{{ $actualDiscount }}% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                                    @endif
                                @endif
                            </div>
                            <div class="service-content">
                                <div class="service-price-tag">
                                                                        <del class="per-night">{{ number_format($chalet->holiday_day_price ?? 645, 0) }}</del>

                                    <span class="fw-medium"> {{ number_format($chalet->default_day_price ?? 410, 0) }} ر.ع</span>
                                </div>
                                <h3 class="service-title">{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}</h3>
                                <p class="service-location">{{ $chalet->city ? $chalet->city->name : '' }}{{ $chalet->area ? ' - '.$chalet->area->name : '' }}</p>
                                <div class="service-tags">
                                    @if($chalet->has_pool)
                                        <span class="tag tag-pool">{{ app()->getLocale() == 'ar' ? 'مسبح' : 'Pool' }}</span>
                                    @endif
                                    @if($chalet->has_beachfront)
                                        <span class="tag tag-beachfront">{{ app()->getLocale() == 'ar' ? 'على الشاطئ' : 'Beachfront' }}</span>
                                    @endif
                                    @if($chalet->has_beach)
                                        <span class="tag tag-beach">{{ app()->getLocale() == 'ar' ? 'شاطئ' : 'Beach' }}</span>
                                    @endif
                                    @if($chalet->has_garden)
                                        <span class="tag tag-garden">{{ app()->getLocale() == 'ar' ? 'حديقة' : 'Garden' }}</span>
                                    @endif
                                    @if($chalet->has_mountain_view)
                                        <span class="tag tag-mountain">{{ app()->getLocale() == 'ar' ? 'إطلالة جبلية' : 'Mountain View' }}</span>
                                    @endif
                                </div>
                                <div class="service-host">
                                    <img src="https://i.pravatar.cc/150?img={{ $loop->iteration ?? rand(1, 50) }}" alt="Host" class="host-avatar">
                                    <div class="host-info">
                                        <span class="host-name">{{ $chalet->owner->name ?? 'Mo. Sayed' }}</span>
                                        <span class="host-label">{{ app()->getLocale() == 'ar' ? 'مالك العقار' : 'Real estate owner' }}</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <button class="btn-view-details" onclick="window.location.href='{{ route('showChalet', $chalet->slug) }}'">{{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}</button>
                                    <button class="btn-wishlist-circle" data-chalet-id="{{ $chalet->id }}">
                                        <svg width="30" height="30" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.496 14.9292C9.224 15.0236 8.776 15.0236 8.504 14.9292C6.184 14.1506 1 10.9022 1 5.39663C1 2.96629 2.992 1 5.448 1C6.904 1 8.192 1.69214 9 2.7618C9.808 1.69214 11.104 1 12.552 1C15.008 1 17 2.96629 17 5.39663C17 10.9022 11.816 14.1506 9.496 14.9292Z" stroke="#159265" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p>{{ app()->getLocale() == 'ar' ? 'لا توجد شاليهات جديدة حالياً' : 'No new chalets available' }}</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Popular Chalets Tab Content -->
        @if(isset($popularChalets) && $popularChalets->count() > 0)
        <div class="tab-content {{ (!isset($newChalets) || $newChalets->count() == 0) && isset($popularChalets) && $popularChalets->count() > 0 ? 'active' : '' }}" id="popular">
            <div class="row g-4">
                @if(isset($popularChalets) && $popularChalets->count() > 0)
                    @foreach($popularChalets as $chalet)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2-4">
                        <div class="service-card">
                            <div class="service-image">
                                @if($chalet->main_image)
                                    <img src="{{ asset($chalet->main_image) }}" alt="{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}" onerror="this.src='https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80'">
                                @elseif($chalet->images && $chalet->images->first())
                                    <img src="{{ asset($chalet->images->first()->image_path) }}" alt="{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}" onerror="this.src='https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80'">
                                @else
                                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80" alt="{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}">
                                @endif
                                @if($chalet->discount_percentage && $chalet->discount_percentage > 0)
                                    @if($chalet->discount_percentage < 50)
                                        <span class="discount-badge discount-orange">{{ $chalet->discount_percentage }}% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                                    @else
                                        <span class="discount-badge">{{ $chalet->discount_percentage }}% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                                    @endif
                                @endif
                            </div>
                            <div class="service-content">
                                <div class="service-price-tag">
                                    <del class="per-night">{{ number_format($chalet->holiday_day_price ?? 645, 0) }}</del>
                                                                  <span class="fw-medium"> {{ number_format($chalet->default_day_price ?? 410, 0) }} ر.ع</span>

                                </div>
                                <h3 class="service-title">{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}</h3>
                                <p class="service-location">{{ $chalet->city ? $chalet->city->name : '' }}{{ $chalet->area ? ' - '.$chalet->area->name : '' }}</p>
                                <div class="service-tags">
                                    @if($chalet->has_pool)
                                        <span class="tag tag-pool">{{ app()->getLocale() == 'ar' ? 'مسبح' : 'Pool' }}</span>
                                    @endif
                                    @if($chalet->has_beachfront)
                                        <span class="tag tag-beachfront">{{ app()->getLocale() == 'ar' ? 'على الشاطئ' : 'Beachfront' }}</span>
                                    @endif
                                    @if($chalet->has_beach)
                                        <span class="tag tag-beach">{{ app()->getLocale() == 'ar' ? 'شاطئ' : 'Beach' }}</span>
                                    @endif
                                    @if($chalet->has_garden)
                                        <span class="tag tag-garden">{{ app()->getLocale() == 'ar' ? 'حديقة' : 'Garden' }}</span>
                                    @endif
                                    @if($chalet->has_mountain_view)
                                        <span class="tag tag-mountain">{{ app()->getLocale() == 'ar' ? 'إطلالة جبلية' : 'Mountain View' }}</span>
                                    @endif
                                </div>
                                <div class="service-host">
                                    <img src="https://i.pravatar.cc/150?img={{ $loop->iteration ?? rand(1, 50) }}" alt="Host" class="host-avatar">
                                    <div class="host-info">
                                        <span class="host-name">{{ $chalet->owner->name ?? 'Mo. Sayed' }}</span>
                                        <span class="host-label">{{ app()->getLocale() == 'ar' ? 'مالك العقار' : 'Real estate owner' }}</span>
                                    </div>
                                </div>
                                <div class="service-actions">
                                    <button class="btn-view-details" onclick="window.location.href='{{ route('showChalet', $chalet->slug) }}'">{{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}</button>
                                    <button class="btn-wishlist-circle" data-chalet-id="{{ $chalet->id }}">
                                        <svg width="30" height="30" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.496 14.9292C9.224 15.0236 8.776 15.0236 8.504 14.9292C6.184 14.1506 1 10.9022 1 5.39663C1 2.96629 2.992 1 5.448 1C6.904 1 8.192 1.69214 9 2.7618C9.808 1.69214 11.104 1 12.552 1C15.008 1 17 2.96629 17 5.39663C17 10.9022 11.816 14.1506 9.496 14.9292Z" stroke="#159265" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p>{{ app()->getLocale() == 'ar' ? 'لا توجد شاليهات شعبية حالياً' : 'No popular chalets available' }}</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Category Tab Contents -->
        @if(count($categoriesWithChalets) > 0)
            @foreach($categoriesWithChalets as $index => $category)
                @php
                    $isFirstCategory = (!isset($newChalets) || $newChalets->count() == 0) && (!isset($popularChalets) || $popularChalets->count() == 0) && $index == 0;
                @endphp
                <div class="tab-content {{ $isFirstCategory ? 'active' : '' }}" id="category-{{ $category->id }}">
                    <div class="row g-4">
                        @if($category->chalets && $category->chalets->count() > 0)
                            @foreach($category->chalets->take(8) as $chalet)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2-4">
                                <div class="service-card">
                                    <div class="service-image">
                                        @if($chalet->main_image)
                                            <img src="{{ asset($chalet->main_image) }}" alt="{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}" onerror="this.src='https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80'">
                                        @else
                                            @php
                                                $categoryImages = [
                                                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80',
                                                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80',
                                                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80',
                                                    'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=600&q=80',
                                                    'https://images.unsplash.com/photo-1602343168117-bb8ffe3e2e9f?w=600&q=80',
                                                    'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=600&q=80',
                                                    'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80',
                                                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80',
                                                ];
                                                $catImageIndex = ($loop->index ?? rand(0, 7)) % count($categoryImages);
                                            @endphp
                                            <img src="{{ $categoryImages[$catImageIndex] }}" alt="{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}">
                                        @endif
                                        @php
                                            $catDefaultPrice = $chalet->default_day_price ?? 410;
                                            $catHolidayPrice = $chalet->holiday_day_price ?? 645;
                                            $catActualDiscount = 0;
                                            if ($catHolidayPrice > $catDefaultPrice) {
                                                $catActualDiscount = round((($catHolidayPrice - $catDefaultPrice) / $catHolidayPrice) * 100);
                                            }
                                        @endphp
                                        @if($catActualDiscount > 0)
                                            @if($catActualDiscount < 50)
                                                <span class="discount-badge discount-orange">{{ $catActualDiscount }}% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                                            @else
                                                <span class="discount-badge">{{ $catActualDiscount }}% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                                            @endif
                                        @else
                                            <span class="discount-badge discount-orange">40% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                                        @endif
                                    </div>
                                    <div class="service-content">
                                        <div class="service-price-tag">
                                         <del class="per-night">{{ number_format($chalet->holiday_day_price ?? 645, 0) }}</del>
  
                                        <span class="fw-medium"> {{ number_format($chalet->default_day_price ?? 410, 0) }} ر.ع</span>
                                        </div>
                                        <h3 class="service-title">{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}</h3>
                                        <p class="service-location">{{ $chalet->city ? $chalet->city->name : '' }} / {{ $chalet->area ? $chalet->area->name : '' }}</p>
                                        <div class="service-tags">
                                            @if($chalet->has_pool)
                                                <span class="tag tag-pool">{{ app()->getLocale() == 'ar' ? 'مسبح' : 'Pool' }}</span>
                                            @endif
                                            @if($chalet->has_beachfront)
                                                <span class="tag tag-beachfront">{{ app()->getLocale() == 'ar' ? 'على الشاطئ' : 'Beachfront' }}</span>
                                            @endif
                                            @if($chalet->has_beach)
                                                <span class="tag tag-beach">{{ app()->getLocale() == 'ar' ? 'شاطئ' : 'Beach' }}</span>
                                            @endif
                                            @if($chalet->has_garden)
                                                <span class="tag tag-garden">{{ app()->getLocale() == 'ar' ? 'حديقة' : 'Garden' }}</span>
                                            @endif
                                            @if($chalet->has_mountain_view)
                                                <span class="tag tag-mountain">{{ app()->getLocale() == 'ar' ? 'إطلالة جبلية' : 'Mountain View' }}</span>
                                            @endif
                                        </div>
                                        <div class="service-host">
                                            <img src="https://i.pravatar.cc/150?img={{ $loop->iteration ?? rand(1, 50) }}" alt="Host" class="host-avatar">
                                            <div class="host-info">
                                                <span class="host-name">{{ $chalet->owner->name ?? 'Mo. Sayed' }}</span>
                                                <span class="host-label">{{ app()->getLocale() == 'ar' ? 'مالك العقار' : 'Real estate owner' }}</span>
                                            </div>
                                        </div>
                                        <div class="service-actions">
                                            <button class="btn-view-details" onclick="window.location.href='{{ route('showChalet', $chalet->slug) }}'">{{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}</button>
                                            <button class="btn-wishlist-circle" data-chalet-id="{{ $chalet->id }}">
                                                <svg width="30" height="30" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.496 14.9292C9.224 15.0236 8.776 15.0236 8.504 14.9292C6.184 14.1506 1 10.9022 1 5.39663C1 2.96629 2.992 1 5.448 1C6.904 1 8.192 1.69214 9 2.7618C9.808 1.69214 11.104 1 12.552 1C15.008 1 17 2.96629 17 5.39663C17 10.9022 11.816 14.1506 9.496 14.9292Z" stroke="#159265" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center">
                                <p>{{ app()->getLocale() == 'ar' ? 'لا توجد شاليهات في هذه الفئة' : 'No chalets in this category' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Mobile Navigation for Services -->
        <div class="services-nav-mobile">
            <button class="services-prev-mobile" onclick="navigateServices('prev')">
                <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
            </button>
            <button class="services-next-mobile" onclick="navigateServices('next')">
                <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            </button>
        </div>

        <!-- Browse Button -->
        <div class="text-center mt-5">
            <a href="{{ route('showAllChalet') }}" class="btn-browse btn-orange-primary">
                {{ app()->getLocale() == 'ar' ? 'تصفح المزيد' : 'Browse More' }}
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2.5C6.48 2.5 2 6.98 2 12.5C2 18.02 6.48 22.5 12 22.5C17.52 22.5 22 18.02 22 12.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13 11.5L21.2 3.29999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22 7.33V2.5H17.17" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<script>
    let currentServicePage = 0;
    const cardsPerPage = 2;
    
    function navigateServices(direction) {
        if (window.innerWidth > 768) return;
        
        const activeTab = document.querySelector('.tab-content.active');
        if (!activeTab) {
            console.log('No active tab found');
            return;
        }
        
        const cards = activeTab.querySelectorAll('.col-12.col-sm-6, .col-xl-2-4');
        const totalPages = Math.ceil(cards.length / cardsPerPage);
        
        console.log('Total cards:', cards.length, 'Total pages:', totalPages, 'Current page:', currentServicePage);
        
        if (direction === 'next') {
            if (currentServicePage < totalPages - 1) {
                currentServicePage++;
                console.log('Moving to next page:', currentServicePage);
            }
        } else if (direction === 'prev') {
            if (currentServicePage > 0) {
                currentServicePage--;
                console.log('Moving to previous page:', currentServicePage);
            }
        } else if (direction === 'reset') {
            currentServicePage = 0;
            console.log('Reset to page 0');
        }
        
        showCurrentPageCards();
    }
    
    function showCurrentPageCards() {
        const activeTab = document.querySelector('.tab-content.active');
        if (!activeTab) return;
        
        const cards = activeTab.querySelectorAll('.col-12.col-sm-6, .col-xl-2-4');
        const startIndex = currentServicePage * cardsPerPage;
        const endIndex = startIndex + cardsPerPage;
        
        console.log('Showing cards from index', startIndex, 'to', endIndex);
        
        if (window.innerWidth <= 768) {
            cards.forEach((card, index) => {
                card.removeAttribute('style');
                
                if (index >= startIndex && index < endIndex) {
                    card.classList.remove('d-none');
                    card.classList.add('d-block');
                    console.log('Showing card', index);
                } else {
                    card.classList.add('d-none');
                    card.classList.remove('d-block');
                    console.log('Hiding card', index);
                }
            });
        } else {
            cards.forEach(card => {
                card.classList.remove('d-none');
                card.classList.add('d-block');
                card.removeAttribute('style');
            });
        }
        
        updateNavigationButtons();
    }
    
    function updateNavigationButtons() {
        const activeTab = document.querySelector('.tab-content.active');
        if (!activeTab) return;
        
        const cards = activeTab.querySelectorAll('.col-12.col-sm-6, .col-xl-2-4');
        const totalPages = Math.ceil(cards.length / cardsPerPage);
        
        const prevBtn = document.querySelector('.services-prev-mobile');
        const nextBtn = document.querySelector('.services-next-mobile');
        
        if (prevBtn) {
            prevBtn.disabled = currentServicePage === 0;
            prevBtn.style.opacity = currentServicePage === 0 ? '0.5' : '1';
        }
        
        if (nextBtn) {
            nextBtn.disabled = currentServicePage >= totalPages - 1;
            nextBtn.style.opacity = currentServicePage >= totalPages - 1 ? '0.5' : '1';
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.services-tabs .tab-btn');
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });
                
                const tabId = this.getAttribute('data-tab');
                const selectedTab = document.getElementById(tabId);
                if (selectedTab) {
                    selectedTab.classList.add('active');
                }
                
                currentServicePage = 0;
                setTimeout(() => {
                    showCurrentPageCards();
                }, 50);
            });
        });
        
        setTimeout(() => {
            showCurrentPageCards();
        }, 100);
        
        window.addEventListener('resize', function() {
            showCurrentPageCards();
        });
    });
    
    window.addEventListener('load', function() {
        if (window.innerWidth <= 768) {
            showCurrentPageCards();
        }
    });
</script>
