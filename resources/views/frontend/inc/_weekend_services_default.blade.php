<!-- Services Section with Default Data -->
<section class="services-section">
    <div class="container-fluid px-4">
        <h2 class="section-title text-center mb-4">{{ app()->getLocale() == 'ar' ? 'خدمات شاليك' : 'Shaleek Services' }}</h2>

        <!-- Tabs Navigation -->
        <div class="services-tabs d-flex justify-content-center gap-3 mb-5 flex-wrap">
            <button class="tab-btn active" data-tab="new">{{ app()->getLocale() == 'ar' ? 'جديد' : 'New' }}</button>
            <button class="tab-btn" data-tab="popular">{{ app()->getLocale() == 'ar' ? 'الأكثر شعبية' : 'Popular' }}</button>
            <button class="tab-btn" data-tab="villas">{{ app()->getLocale() == 'ar' ? 'فلل' : 'Villas' }}</button>
            <button class="tab-btn" data-tab="chalets">{{ app()->getLocale() == 'ar' ? 'شاليهات' : 'Chalets' }}</button>
            <button class="tab-btn" data-tab="farms">{{ app()->getLocale() == 'ar' ? 'مزارع' : 'Farms' }}</button>
        </div>

        @php
            $defaultServices = [
                [
                    'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80',
                    'title_ar' => 'فيلا النخيل الفاخرة',
                    'title_en' => 'Luxury Palm Villa',
                    'location_ar' => 'مسقط / السيب',
                    'location_en' => 'Muscat / Seeb',
                    'price' => 450,
                    'original_price' => 750,
                    'discount' => 40,
                    'tags' => ['pool', 'beachfront', 'garden'],
                    'host' => 'أحمد الحارثي'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80',
                    'title_ar' => 'شاليه البحر الأزرق',
                    'title_en' => 'Blue Sea Chalet',
                    'location_ar' => 'صلالة / طاقة',
                    'location_en' => 'Salalah / Taqah',
                    'price' => 320,
                    'original_price' => 500,
                    'discount' => 36,
                    'tags' => ['beach', 'mountain'],
                    'host' => 'سالم البلوشي'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80',
                    'title_ar' => 'مزرعة الواحة',
                    'title_en' => 'Oasis Farm',
                    'location_ar' => 'نزوى / بركة الموز',
                    'location_en' => 'Nizwa / Birkat Al Mouz',
                    'price' => 280,
                    'original_price' => 400,
                    'discount' => 30,
                    'tags' => ['garden', 'pool'],
                    'host' => 'محمد الكندي'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=600&q=80',
                    'title_ar' => 'استراحة الجبل',
                    'title_en' => 'Mountain Rest',
                    'location_ar' => 'الجبل الأخضر',
                    'location_en' => 'Jebel Akhdar',
                    'price' => 380,
                    'original_price' => 600,
                    'discount' => 37,
                    'tags' => ['mountain', 'garden'],
                    'host' => 'علي الشكيلي'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1602343168117-bb8ffe3e2e9f?w=600&q=80',
                    'title_ar' => 'شقة الكورنيش',
                    'title_en' => 'Corniche Apartment',
                    'location_ar' => 'مسقط / القرم',
                    'location_en' => 'Muscat / Qurum',
                    'price' => 250,
                    'original_price' => 350,
                    'discount' => 29,
                    'tags' => ['beachfront'],
                    'host' => 'فاطمة الزدجالي'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=600&q=80',
                    'title_ar' => 'فيلا الياسمين',
                    'title_en' => 'Jasmine Villa',
                    'location_ar' => 'صحار / الملتقى',
                    'location_en' => 'Sohar / Al Multaqa',
                    'price' => 420,
                    'original_price' => 680,
                    'discount' => 38,
                    'tags' => ['pool', 'garden', 'beach'],
                    'host' => 'ياسر العبري'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80',
                    'title_ar' => 'مزرعة النخيل',
                    'title_en' => 'Palm Farm',
                    'location_ar' => 'البريمي',
                    'location_en' => 'Buraimi',
                    'price' => 300,
                    'original_price' => 450,
                    'discount' => 33,
                    'tags' => ['garden', 'pool'],
                    'host' => 'خالد الوهيبي'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80',
                    'title_ar' => 'منتجع الشاطئ',
                    'title_en' => 'Beach Resort',
                    'location_ar' => 'صور / رأس الحد',
                    'location_en' => 'Sur / Ras Al Hadd',
                    'price' => 520,
                    'original_price' => 850,
                    'discount' => 39,
                    'tags' => ['beach', 'pool', 'beachfront'],
                    'host' => 'سعيد الحبسي'
                ]
            ];
        @endphp

        <!-- New Tab Content -->
        <div class="tab-content active" id="new">
            <div class="row g-4">
                @foreach($defaultServices as $service)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2-4">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="{{ $service['image'] }}" alt="{{ app()->getLocale() == 'ar' ? $service['title_ar'] : $service['title_en'] }}">
                            <span class="discount-badge {{ $service['discount'] < 35 ? 'discount-orange' : '' }}">
                                {{ $service['discount'] }}% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}
                            </span>
                        </div>
                        <div class="service-content">
                            <div class="service-price-tag">
                                <del class="per-night">{{ $service['original_price'] }}</del>
                                <span class="fw-medium">{{ $service['price'] }} ر.ع</span>
                            </div>
                            <h3 class="service-title">{{ app()->getLocale() == 'ar' ? $service['title_ar'] : $service['title_en'] }}</h3>
                            <p class="service-location">{{ app()->getLocale() == 'ar' ? $service['location_ar'] : $service['location_en'] }}</p>
                            <div class="service-tags">
                                @foreach($service['tags'] as $tag)
                                    @if($tag == 'pool')
                                        <span class="tag tag-pool">{{ app()->getLocale() == 'ar' ? 'مسبح' : 'Pool' }}</span>
                                    @elseif($tag == 'beachfront')
                                        <span class="tag tag-beachfront">{{ app()->getLocale() == 'ar' ? 'على الشاطئ' : 'Beachfront' }}</span>
                                    @elseif($tag == 'beach')
                                        <span class="tag tag-beach">{{ app()->getLocale() == 'ar' ? 'شاطئ' : 'Beach' }}</span>
                                    @elseif($tag == 'garden')
                                        <span class="tag tag-garden">{{ app()->getLocale() == 'ar' ? 'حديقة' : 'Garden' }}</span>
                                    @elseif($tag == 'mountain')
                                        <span class="tag tag-mountain">{{ app()->getLocale() == 'ar' ? 'إطلالة جبلية' : 'Mountain View' }}</span>
                                    @endif
                                @endforeach
                            </div>
                            <div class="service-host">
                                <img src="https://i.pravatar.cc/150?img={{ $loop->iteration }}" alt="Host" class="host-avatar">
                                <div class="host-info">
                                    <span class="host-name">{{ $service['host'] }}</span>
                                    <span class="host-label">{{ app()->getLocale() == 'ar' ? 'مالك العقار' : 'Real estate owner' }}</span>
                                </div>
                            </div>
                            <div class="service-actions">
                                <button class="btn-view-details">{{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}</button>
                                <button class="btn-wishlist-circle">
                                    <svg width="30" height="30" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.496 14.9292C9.224 15.0236 8.776 15.0236 8.504 14.9292C6.184 14.1506 1 10.9022 1 5.39663C1 2.96629 2.992 1 5.448 1C6.904 1 8.192 1.69214 9 2.7618C9.808 1.69214 11.104 1 12.552 1C15.008 1 17 2.96629 17 5.39663C17 10.9022 11.816 14.1506 9.496 14.9292Z" stroke="#159265" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Popular Tab Content -->
        <div class="tab-content" id="popular">
            <div class="row g-4">
                @foreach(array_reverse($defaultServices) as $service)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2-4">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="{{ $service['image'] }}" alt="{{ app()->getLocale() == 'ar' ? $service['title_ar'] : $service['title_en'] }}">
                            <span class="discount-badge">50% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                        </div>
                        <div class="service-content">
                            <div class="service-price-tag">
                                <del class="per-night">{{ $service['original_price'] + 100 }}</del>
                                <span class="fw-medium">{{ $service['price'] }} ر.ع</span>
                            </div>
                            <h3 class="service-title">{{ app()->getLocale() == 'ar' ? $service['title_ar'] : $service['title_en'] }}</h3>
                            <p class="service-location">{{ app()->getLocale() == 'ar' ? $service['location_ar'] : $service['location_en'] }}</p>
                            <div class="service-tags">
                                @foreach($service['tags'] as $tag)
                                    @if($tag == 'pool')
                                        <span class="tag tag-pool">{{ app()->getLocale() == 'ar' ? 'مسبح' : 'Pool' }}</span>
                                    @elseif($tag == 'beachfront')
                                        <span class="tag tag-beachfront">{{ app()->getLocale() == 'ar' ? 'على الشاطئ' : 'Beachfront' }}</span>
                                    @elseif($tag == 'beach')
                                        <span class="tag tag-beach">{{ app()->getLocale() == 'ar' ? 'شاطئ' : 'Beach' }}</span>
                                    @elseif($tag == 'garden')
                                        <span class="tag tag-garden">{{ app()->getLocale() == 'ar' ? 'حديقة' : 'Garden' }}</span>
                                    @elseif($tag == 'mountain')
                                        <span class="tag tag-mountain">{{ app()->getLocale() == 'ar' ? 'إطلالة جبلية' : 'Mountain View' }}</span>
                                    @endif
                                @endforeach
                            </div>
                            <div class="service-host">
                                <img src="https://i.pravatar.cc/150?img={{ $loop->iteration + 10 }}" alt="Host" class="host-avatar">
                                <div class="host-info">
                                    <span class="host-name">{{ $service['host'] }}</span>
                                    <span class="host-label">{{ app()->getLocale() == 'ar' ? 'مالك العقار' : 'Real estate owner' }}</span>
                                </div>
                            </div>
                            <div class="service-actions">
                                <button class="btn-view-details">{{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}</button>
                                <button class="btn-wishlist-circle">
                                    <svg width="30" height="30" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.496 14.9292C9.224 15.0236 8.776 15.0236 8.504 14.9292C6.184 14.1506 1 10.9022 1 5.39663C1 2.96629 2.992 1 5.448 1C6.904 1 8.192 1.69214 9 2.7618C9.808 1.69214 11.104 1 12.552 1C15.008 1 17 2.96629 17 5.39663C17 10.9022 11.816 14.1506 9.496 14.9292Z" stroke="#159265" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Other tabs with similar content... -->
        @foreach(['villas', 'chalets', 'farms'] as $tabName)
        <div class="tab-content" id="{{ $tabName }}">
            <div class="row g-4">
                @foreach(array_slice($defaultServices, 0, 6) as $service)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2-4">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="{{ $service['image'] }}" alt="{{ app()->getLocale() == 'ar' ? $service['title_ar'] : $service['title_en'] }}">
                            <span class="discount-badge discount-orange">35% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                        </div>
                        <div class="service-content">
                            <div class="service-price-tag">
                                <del class="per-night">{{ $service['original_price'] }}</del>
                                <span class="fw-medium">{{ $service['price'] }} ر.ع</span>
                            </div>
                            <h3 class="service-title">{{ app()->getLocale() == 'ar' ? $service['title_ar'] : $service['title_en'] }}</h3>
                            <p class="service-location">{{ app()->getLocale() == 'ar' ? $service['location_ar'] : $service['location_en'] }}</p>
                            <div class="service-tags">
                                @foreach($service['tags'] as $tag)
                                    @if($tag == 'pool')
                                        <span class="tag tag-pool">{{ app()->getLocale() == 'ar' ? 'مسبح' : 'Pool' }}</span>
                                    @elseif($tag == 'beachfront')
                                        <span class="tag tag-beachfront">{{ app()->getLocale() == 'ar' ? 'على الشاطئ' : 'Beachfront' }}</span>
                                    @elseif($tag == 'beach')
                                        <span class="tag tag-beach">{{ app()->getLocale() == 'ar' ? 'شاطئ' : 'Beach' }}</span>
                                    @elseif($tag == 'garden')
                                        <span class="tag tag-garden">{{ app()->getLocale() == 'ar' ? 'حديقة' : 'Garden' }}</span>
                                    @elseif($tag == 'mountain')
                                        <span class="tag tag-mountain">{{ app()->getLocale() == 'ar' ? 'إطلالة جبلية' : 'Mountain View' }}</span>
                                    @endif
                                @endforeach
                            </div>
                            <div class="service-host">
                                <img src="https://i.pravatar.cc/150?img={{ $loop->iteration + 20 }}" alt="Host" class="host-avatar">
                                <div class="host-info">
                                    <span class="host-name">{{ $service['host'] }}</span>
                                    <span class="host-label">{{ app()->getLocale() == 'ar' ? 'مالك العقار' : 'Real estate owner' }}</span>
                                </div>
                            </div>
                            <div class="service-actions">
                                <button class="btn-view-details">{{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}</button>
                                <button class="btn-wishlist-circle">
                                    <svg width="30" height="30" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.496 14.9292C9.224 15.0236 8.776 15.0236 8.504 14.9292C6.184 14.1506 1 10.9022 1 5.39663C1 2.96629 2.992 1 5.448 1C6.904 1 8.192 1.69214 9 2.7618C9.808 1.69214 11.104 1 12.552 1C15.008 1 17 2.96629 17 5.39663C17 10.9022 11.816 14.1506 9.496 14.9292Z" stroke="#159265" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

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
        if (window.innerWidth > 768) return; // Only work on mobile

        const activeTab = document.querySelector('.tab-content.active');
        if (!activeTab) {
            console.log('No active tab found');
            return;
        }

        const cards = activeTab.querySelectorAll('.col-12.col-sm-6');
        const totalPages = Math.ceil(cards.length / cardsPerPage);

        console.log('Total cards:', cards.length, 'Total pages:', totalPages, 'Current page:', currentServicePage);

        // Update current page
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

        // Show/hide cards based on current page
        showCurrentPageCards();
    }

    function showCurrentPageCards() {
        const activeTab = document.querySelector('.tab-content.active');
        if (!activeTab) return;

        const cards = activeTab.querySelectorAll('.col-12.col-sm-6');
        const startIndex = currentServicePage * cardsPerPage;
        const endIndex = startIndex + cardsPerPage;

        console.log('Showing cards from index', startIndex, 'to', endIndex);

        // For mobile - show only 2 cards
        if (window.innerWidth <= 768) {
            cards.forEach((card, index) => {
                // Remove all inline styles first
                card.removeAttribute('style');

                if (index >= startIndex && index < endIndex) {
                    // Show these cards
                    card.classList.remove('d-none');
                    card.classList.add('d-block');
                    console.log('Showing card', index);
                } else {
                    // Hide these cards completely
                    card.classList.add('d-none');
                    card.classList.remove('d-block');
                    console.log('Hiding card', index);
                }
            });
        } else {
            // Desktop view - show all cards
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

        const cards = activeTab.querySelectorAll('.col-12.col-sm-6');
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

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Tab change handler
        const tabButtons = document.querySelectorAll('.services-tabs .tab-btn');
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all tabs
                tabButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked tab
                this.classList.add('active');

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Show selected tab content
                const tabId = this.getAttribute('data-tab');
                const selectedTab = document.getElementById(tabId);
                if (selectedTab) {
                    selectedTab.classList.add('active');
                }

                // Reset page and show cards
                currentServicePage = 0;
                setTimeout(() => {
                    showCurrentPageCards();
                }, 50);
            });
        });

        // Initialize display on page load
        setTimeout(() => {
            showCurrentPageCards();
        }, 100);

        // Handle window resize
        window.addEventListener('resize', function() {
            showCurrentPageCards();
        });
    });

    // Also initialize when window fully loads
    window.addEventListener('load', function() {
        if (window.innerWidth <= 768) {
            showCurrentPageCards();
        }
    });
</script>
