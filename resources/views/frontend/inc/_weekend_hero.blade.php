<!-- Hero Booking Section -->
<section class="hero-booking-section">
    <div class="container-fluid">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                @if(isset($sliders) && $sliders->count() > 0)
                    @foreach($sliders as $index => $slider)
                    <div class="swiper-slide" style="background-image: url('{{ asset($slider->image ?? 'frontend/images/hero-bg.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="slide-overlay"></div>
                        <div class="slide-content">
                            <div class="d-flex align-items-start gap-4 mb-4">
                                <div class="logo-circle mt-4">
                                    <img src="{{ asset('frontend/images/logo-without-text.png') }}" alt="website_logo_without_text">
                                </div>
                                <div class="hero-text">
                                    @php
                                        $title = $slider->title ?? '';
                                        $customerName = auth('customer')->check() ? auth('customer')->user()->name : (app()->getLocale() == 'ar' ? 'ضيفنا' : 'Guest');
                                        $title = str_replace('{{NAME}}', '<span class="text-success">' . $customerName . '</span>', $title);
                                    @endphp
                                    <h1 class="mb-0">{!! $title !!}</h1>
                                    <p class="mb-4">{{ $slider->description ?? '' }}</p>
                                    @php
                                        $buttonText = $slider->button_text ?? (app()->getLocale() == 'ar' ? 'اكتشف المزيد' : 'Learn More');
                                        $isCustomerLoginButton = app()->getLocale() == 'ar' && in_array(trim($buttonText), ['اعرض الآن', 'اعرض الان']);
                                    @endphp
                                    @if($slider->link || $isCustomerLoginButton)
                                    <a href="{{ $isCustomerLoginButton ? route('login') : $slider->link }}" class="btn-orange-primary btn-join text-decoration-none">
                                        {{ $isCustomerLoginButton ? 'دخول المستخدمين' : $buttonText }}
                                        <span>
                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2.5C6.48 2.5 2 6.98 2 12.5C2 18.02 6.48 22.5 12 22.5C17.52 22.5 22 18.02 22 12.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M13 11.5L21.2 3.29999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M22 7.33V2.5H17.17" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </a>
                                    @else
                                    <a href="{{ app()->getLocale() == 'ar' ? route('login') : route('showAllChalet') }}" class="btn-orange-primary btn-join text-decoration-none">
                                        {{ app()->getLocale() == 'ar' ? 'دخول المستخدمين' : 'Book Now' }}
                                        <span>
                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2.5C6.48 2.5 2 6.98 2 12.5C2 18.02 6.48 22.5 12 22.5C17.52 22.5 22 18.02 22 12.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M13 11.5L21.2 3.29999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M22 7.33V2.5H17.17" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Default slides if no sliders from database -->
                    <!-- Slide 1 -->
                    <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1600&q=80'); background-size: cover; background-position: center;">
                        <div class="slide-overlay"></div>
                        <div class="slide-content">
                            <div class="d-flex align-items-start gap-4 mb-4">
                                <div class="logo-circle mt-4">
                                    <img src="{{ asset('frontend/images/logo-without-text.png') }}" alt="website_logo_without_text">
                                </div>
                                <div class="hero-text">
                                    <h1 class="mb-0">{{ app()->getLocale() == 'ar' ? 'أهلاً، ' : 'Ahlan, ' }}<span class="text-success">{{ auth('customer')->check() ? auth('customer')->user()->name : (app()->getLocale() == 'ar' ? 'ضيفنا' : 'Guest') }}!</span></h1>
                                    <p class="mb-4">{{ app()->getLocale() == 'ar' ? 'أين تريد أن نعرض لك؟' : 'Where would you like us to book for you?' }}</p>
                                    <a href="{{ route('showAllChalet') }}" class="btn-orange-primary btn-join text-decoration-none">
                                        {{ app()->getLocale() == 'ar' ? 'انضم إلينا' : 'Join us' }}
                                        <span>
                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2.5C6.48 2.5 2 6.98 2 12.5C2 18.02 6.48 22.5 12 22.5C17.52 22.5 22 18.02 22 12.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M13 11.5L21.2 3.29999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M22 7.33V2.5H17.17" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 - Arabic -->
                    <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1600&q=80'); background-size: cover; background-position: center;">
                        <div class="slide-overlay"></div>
                        <div class="slide-content">
                            <div class="d-flex align-items-start gap-4 mb-4">
                                <div class="logo-circle mt-4">
                                    <img src="{{ asset('frontend/images/logo-without-text.png') }}" alt="website_logo_without_text">
                                </div>
                                <div class="hero-text" {{ app()->getLocale() == 'ar' ? 'dir="rtl"' : '' }}>
                                    <h1 class="mb-0">{{ app()->getLocale() == 'ar' ? 'مرحباً، ' : 'Hello, ' }}<span class="text-success">{{ auth('customer')->check() ? auth('customer')->user()->name : (app()->getLocale() == 'ar' ? 'ضيفنا' : 'Guest') }}!</span></h1>
                                    <p class="mb-4">{{ app()->getLocale() == 'ar' ? 'اكتشف أماكن رائعة مع شاليك' : 'Discover amazing places with Shaleek' }}</p>
                                    <a href="{{ route('showAllChalet') }}" class="btn-orange-primary btn-join text-decoration-none">
                                        {{ app()->getLocale() == 'ar' ? 'انضم إلينا' : 'Join us' }}
                                        <span>
                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2.5C6.48 2.5 2 6.98 2 12.5C2 18.02 6.48 22.5 12 22.5C17.52 22.5 22 18.02 22 12.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M13 11.5L21.2 3.29999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M22 7.33V2.5H17.17" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1600&q=80'); background-size: cover; background-position: center;">
                        <div class="slide-overlay"></div>
                        <div class="slide-content">
                            <div class="d-flex align-items-start gap-4 mb-4">
                                <div class="logo-circle mt-4">
                                    <img src="{{ asset('frontend/images/logo-without-text.png') }}" alt="website_logo_without_text">
                                </div>
                                <div class="hero-text">
                                    <h1 class="mb-0">{{ app()->getLocale() == 'ar' ? 'شاليك ' : 'Shaleek ' }}<span class="text-success">{{ app()->getLocale() == 'ar' ? 'مثالي!' : 'Perfect!' }}</span></h1>
                                    <p class="mb-4">{{ app()->getLocale() == 'ar' ? 'اعرض مكانك المفضل الآن' : 'Book your favorite place now' }}</p>
                                    <a href="{{ route('showAllChalet') }}" class="btn-orange-primary btn-join text-decoration-none">
                                        {{ app()->getLocale() == 'ar' ? 'تصفح الآن' : 'Browse Now' }}
                                        <span>
                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2.5C6.48 2.5 2 6.98 2 12.5C2 18.02 6.48 22.5 12 22.5C17.52 22.5 22 18.02 22 12.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M13 11.5L21.2 3.29999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M22 7.33V2.5H17.17" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Navigation Buttons -->
            <div class="hero-nav-buttons {{ app()->getLocale() == 'ar' ? 'rtl' : '' }}">
                <div class="swiper-button-prev btn-circular-green-outline">
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                </div>
                <div class="swiper-button-next btn-circular-green">
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                </div>
            </div>

            <!-- Pagination Dots -->
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Include Simple Filters -->
    @include('frontend.inc.simple_filters')

    <!-- Filter Pills Mobile -->
    <div class="filter-pills-mobile">
        <div class="mobile-search-section">
            <div class="mobile-filter-grid">
                <button class="filter-pill-mobile">
                    <span>{{ app()->getLocale() == 'ar' ? 'المحافظة' : 'gov' }}</span>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="filter-pill-mobile">
                    <span>{{ app()->getLocale() == 'ar' ? 'المنطقة' : 'area' }}</span>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="filter-pill-mobile">
                    <span>{{ app()->getLocale() == 'ar' ? 'العقار' : 'property' }}</span>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="filter-pill-mobile">
                    <span>{{ app()->getLocale() == 'ar' ? 'السعر' : 'price' }}</span>
                    <i class="fas fa-chevron-left"></i>
                </button>

{{--                <button class="filter-pill-mobile">--}}
{{--                    <span>{{ app()->getLocale() == 'ar' ? 'الحجز' : 'booking' }}</span>--}}
{{--                    <i class="fas fa-chevron-left"></i>--}}
{{--                </button>--}}
{{--                <button class="filter-pill-mobile">--}}
{{--                    <span>{{ app()->getLocale() == 'ar' ? 'المنطقة' : 'area' }}</span>--}}
{{--                    <i class="fas fa-chevron-left"></i>--}}
{{--                </button>--}}


            </div>
            <button class="search-btn-mobile">
                <span>
                    <svg width="35" height="34" viewBox="0 0 35 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 32.7503L9.6003 25.331M9.6003 25.331C10.9003 26.6001 12.4437 27.6068 14.1423 28.2936C15.8409 28.9805 17.6614 29.334 19.5 29.334C21.3386 29.334 23.1591 28.9805 24.8577 28.2937C26.5563 27.6068 28.0997 26.6001 29.3998 25.331C30.6998 24.0619 31.7311 22.5553 32.4347 20.8971C33.1382 19.239 33.5004 17.4618 33.5004 15.667C33.5004 13.8722 33.1382 12.095 32.4347 10.4368C31.7311 8.7787 30.6998 7.272 29.3998 6.0029C26.7742 3.4399 23.2131 2 19.5 2C15.7869 2 12.2258 3.4399 9.6003 6.0029C6.9747 8.566 5.4996 12.0423 5.4996 15.667C5.4996 19.2917 6.9747 22.7679 9.6003 25.331Z" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </button>
        </div>
    </div>
</section>

<style>
/* Hero Section Width Adjustments for Desktop */
@media (min-width: 1200px) {
    .hero-booking-section .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
        padding-left: 30px;
        padding-right: 30px;
    }
}

@media (min-width: 1400px) {
    .hero-booking-section .container-fluid {
        max-width: 1600px;
    }
}

@media (min-width: 1600px) {
    .hero-booking-section .container-fluid {
        max-width: 1800px;
    }
}

/* Ensure slide content is properly positioned */
.hero-booking-section .slide-content {
    width: 100%;
    max-width: 1800px;
    margin: 0 auto;
    padding: 0 30px;
}

/* Adjust filter section width to match */
.hero-booking-section .simple-filters,
.hero-booking-section .filter-pills-mobile {
    max-width: 1800px;
    margin: 0 auto;
}

@media (min-width: 1200px) {
    .hero-booking-section .simple-filters {
        padding: 0 30px;
    }
}


.mobile-filter-content {
    display: flex;
    flex-direction: column;
    height: 100vh; /* مهم */
}

.mobile-filter-body {
    flex: 1;
    overflow-y: auto;
}

.mobile-filter-footer {
    position: sticky;
    bottom: 0;
    background: #fff;
    padding: 12px;
    border-top: 1px solid #eee;
    z-index: 10;
}
</style>
