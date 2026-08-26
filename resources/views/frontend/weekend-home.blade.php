<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#127664">
    @php
        $defaultHomeTitle = $siteTitle ?? $siteName ?? 'shaleek';
        $defaultHomeDescription = $siteMetaDescription
            ?? $siteDescription
            ?? config('app.site_description', 'A booking platform for chalets, farms, resorts, and cabins.');
    @endphp
    <meta name="description" content="{{ $defaultHomeDescription }}">
    <title>{{ $defaultHomeTitle }}</title>
    <meta name="google-site-verification" content="2EDMdlj1fYrkMmXXCyJRkdqDrwa9wka7-TcLdv3r_Io" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    <!-- Shaleek Design System (cache-busted) -->
    <link rel="stylesheet" href="{{ asset('frontend/css/shaleek-design.css') }}?v={{ @filemtime(public_path('frontend/css/shaleek-design.css')) ?: time() }}">

    <!-- Google Ads -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6223635494524694" crossorigin="anonymous"></script>
</head>
<body class="shaleek">
    @include('frontend.inc._shaleek_header')

    <main id="page-home">

        <!-- HERO -->
        <section class="shaleek-hero">
            <div class="shaleek-hero-bg"></div>
            <div class="container shaleek-hero-inner">
                <div class="shaleek-hero-eyebrow">
                    {{ app()->getLocale() == 'ar' ? 'منصة عرض — لا نوفر خدمة حجوزات' : 'A listing platform — bookings are not provided' }}
                </div>
                <h1>
                    {{ app()->getLocale() == 'ar' ? 'مكانك المثالي في عُمان،' : 'Your perfect place in Oman,' }}<br>
                    <span class="accent">{{ app()->getLocale() == 'ar' ? 'على بُعد رسالة واتساب' : 'just one WhatsApp message away' }}</span>
                </h1>
                <p class="shaleek-hero-sub">
                    {{ app()->getLocale() == 'ar'
                        ? 'اكتشف استراحات وشاليهات ومزارع وقاعات أفراح من جميع محافظات السلطنة، وتواصل مباشرةً مع مالك العقار.'
                        : 'Discover chalets, farms, rest houses and wedding halls across every governorate of Oman, then contact the property owner directly.' }}
                </p>

                <form class="shaleek-search-panel" method="GET" action="{{ route('showAllChalet') }}">
                    <div class="shaleek-search-grid">
                        <div class="shaleek-search-field">
                            <label class="shaleek-search-field-label">{{ app()->getLocale() == 'ar' ? 'المحافظة' : 'Governorate' }}</label>
                            <select name="city" id="shHeroCity">
                                <option value="0">{{ app()->getLocale() == 'ar' ? 'جميع المحافظات' : 'All governorates' }}</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="shaleek-search-field">
                            <label class="shaleek-search-field-label">{{ app()->getLocale() == 'ar' ? 'نوع العقار' : 'Property type' }}</label>
                            <select name="category">
                                <option value="0">{{ app()->getLocale() == 'ar' ? 'الكل' : 'All' }}</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="shaleek-search-field">
                            <label class="shaleek-search-field-label">{{ app()->getLocale() == 'ar' ? 'المنطقة' : 'Area' }}</label>
                            <select name="area" id="shHeroArea">
                                <option value="0">{{ app()->getLocale() == 'ar' ? 'اختر المحافظة أولاً' : 'Choose a governorate first' }}</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" data-city="{{ $area->city_id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="shaleek-search-field">
                            <label class="shaleek-search-field-label">{{ app()->getLocale() == 'ar' ? 'السعر' : 'Price' }}</label>
                            <select name="date-price">
                                <option value="0">{{ app()->getLocale() == 'ar' ? 'أي سعر' : 'Any price' }}</option>
                                <option value="0-50">{{ app()->getLocale() == 'ar' ? 'أقل من 50 ر.ع' : 'Under 50 OMR' }}</option>
                                <option value="50-100">50 - 100 {{ app()->getLocale() == 'ar' ? 'ر.ع' : 'OMR' }}</option>
                                <option value="100-200">100 - 200 {{ app()->getLocale() == 'ar' ? 'ر.ع' : 'OMR' }}</option>
                                <option value="200-99999">200+ {{ app()->getLocale() == 'ar' ? 'ر.ع' : 'OMR' }}</option>
                            </select>
                        </div>
                        <button type="submit" class="shaleek-search-submit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            {{ app()->getLocale() == 'ar' ? 'ابحث الآن' : 'Search now' }}
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Categories -->
        @if($categories->count())
        <section class="shaleek-section">
            <div class="container">
                <div class="shaleek-section-header">
                    <div class="shaleek-section-title-group">
                        <div class="shaleek-section-eyebrow">{{ app()->getLocale() == 'ar' ? 'الأقسام' : 'Categories' }}</div>
                        <p class="shaleek-section-desc">{{ app()->getLocale() == 'ar' ? 'اختر ما يناسب مناسبتك من بين خمسة أقسام رئيسية' : 'Choose what fits your occasion from five main categories' }}</p>
                    </div>
                </div>

                <div class="shaleek-cats-grid">
                    @foreach($categories as $cat)
                        @php
                            $catFirst = ($chaletsByCategoryMap[$cat->id] ?? collect())->first();
                            $catThumb = $catFirst && $catFirst->main_image ? asset($catFirst->main_image) : null;
                        @endphp
                        <a href="{{ route('showAllChalet', ['category' => $cat->id]) }}" class="shaleek-cat-mini" style="text-decoration:none;">
                            <div class="shaleek-cat-mini-thumb">
                                @if($catThumb)
                                    <img src="{{ $catThumb }}" alt="{{ $cat->name }}">
                                @endif
                            </div>
                            <div class="shaleek-cat-mini-info">
                                <div class="shaleek-cat-mini-title">{{ $cat->name }}</div>
                                <div class="shaleek-cat-mini-count">{{ $cat->chalets_count }} {{ app()->getLocale() == 'ar' ? 'عقار' : 'listings' }}</div>
                            </div>
                            <span class="shaleek-cat-mini-arrow">←</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Per-category listing sections -->
        @foreach($categories as $index => $cat)
            @php
                $catChalets = $chaletsByCategoryMap[$cat->id] ?? collect();
                $shCategoryEyebrows = [
                    app()->getLocale() == 'ar' ? 'للعائلات والإجازات' : 'For families and holidays',
                    app()->getLocale() == 'ar' ? 'في أحضان الطبيعة' : 'In nature',
                    app()->getLocale() == 'ar' ? 'لمغامرات البر' : 'For outdoor trips',
                    app()->getLocale() == 'ar' ? 'لمناسبتك المميزة' : 'For your special occasion',
                    app()->getLocale() == 'ar' ? 'للسيدات فقط' : 'For women',
                ];
            @endphp
            @if($catChalets->count())
                <section class="shaleek-section" @if($index % 2 == 0) style="background: white;" @endif>
                    <div class="container">
                        <div class="shaleek-section-header">
                            <div class="shaleek-section-title-group">
                                <div class="shaleek-section-eyebrow">{{ $shCategoryEyebrows[$index] ?? (app()->getLocale() == 'ar' ? 'اختيارات شاليك' : 'Shaleek picks') }}</div>
                                <h2 class="shaleek-section-title">{{ $cat->name }}</h2>
                            </div>
                            <a href="{{ route('showAllChalet', ['category' => $cat->id]) }}" class="shaleek-section-link">{{ app()->getLocale() == 'ar' ? 'عرض الكل' : 'View all' }}</a>
                        </div>
                        <div class="shaleek-props-grid">
                            @foreach($catChalets->take(4) as $chalet)
                                @include('frontend.inc._shaleek_property_card', ['chalet' => $chalet])
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endforeach

        <!-- Why Shaleek -->
        <section class="shaleek-section">
            <div class="container">
                <div class="shaleek-section-header">
                    <div class="shaleek-section-title-group">
                        <div class="shaleek-section-eyebrow">{{ app()->getLocale() == 'ar' ? 'لماذا شاليك' : 'Why Shaleek' }}</div>
                        <h2 class="shaleek-section-title">{{ app()->getLocale() == 'ar' ? 'منصة العرض الأبسط في عُمان' : 'The simplest listing platform in Oman' }}</h2>
                    </div>
                </div>

                <div class="shaleek-why-grid">
                    <div class="shaleek-why-card">
                        <div class="shaleek-why-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                        <h3 class="shaleek-why-title">{{ app()->getLocale() == 'ar' ? 'تواصل مباشر بدون وسيط' : 'Direct contact, no middleman' }}</h3>
                        <p class="shaleek-why-desc">{{ app()->getLocale() == 'ar' ? 'تتحدث مع مالك العقار مباشرة عبر الواتساب أو الاتصال — لا رسوم خفية ولا حجوزات معلقة.' : 'Talk to the owner directly by WhatsApp or phone, with no hidden fees or pending platform bookings.' }}</p>
                    </div>

                    <div class="shaleek-why-card">
                        <div class="shaleek-why-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>
                        </div>
                        <h3 class="shaleek-why-title">{{ app()->getLocale() == 'ar' ? 'عقارات معتمدة' : 'Verified listings' }}</h3>
                        <p class="shaleek-why-desc">{{ app()->getLocale() == 'ar' ? 'منصة مرخصة من وزارة التجارة (معروف ٦٠٩)، نراجع بيانات كل مالك قبل النشر.' : 'A platform licensed by the Ministry of Commerce (Maroof 609); owner information is reviewed before publishing.' }}</p>
                    </div>

                    <div class="shaleek-why-card">
                        <div class="shaleek-why-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        </div>
                        <h3 class="shaleek-why-title">{{ app()->getLocale() == 'ar' ? 'تغطية شاملة للسلطنة' : 'Nationwide coverage' }}</h3>
                        <p class="shaleek-why-desc">
                            {{ app()->getLocale() == 'ar'
                                ? 'من مسقط إلى ظفار، ومن مسندم إلى الوسطى — أكثر من ' . number_format($totalApprovedCount) . ' عقاراً موزعة على ' . $totalGovernoratesCount . ' محافظة.'
                                : 'From Muscat to Dhofar, and from Musandam to Al Wusta — over ' . number_format($totalApprovedCount) . ' listings across ' . $totalGovernoratesCount . ' governorates.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Disclaimer -->
        <section class="shaleek-disclaimer-section">
            <div class="container">
                <div class="shaleek-disclaimer-card">
                    <div class="shaleek-disclaimer-header">
                        <div class="shaleek-disclaimer-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                        <div>
                            <div class="shaleek-disclaimer-eyebrow">{{ app()->getLocale() == 'ar' ? 'تنويه هام' : 'Important notice' }}</div>
                            <div class="shaleek-disclaimer-title">{{ app()->getLocale() == 'ar' ? 'شاليك منصة عرض فقط — لا نوفر خدمة حجوزات' : 'Shaleek is a listing platform only — bookings are not provided' }}</div>
                        </div>
                    </div>
                    <div class="shaleek-disclaimer-body">
                        <p>
                            {{ app()->getLocale() == 'ar'
                                ? 'منصة شاليك هي منصة إلكترونية عُمانية متخصصة في عرض وإدراج معلومات الشاليهات والاستراحات والمزارع وقاعات الأفراح والصالونات النسائية في مختلف محافظات سلطنة عُمان. دورنا الأساسي والوحيد يقتصر على إتاحة المجال لأصحاب العقارات لعرض عقاراتهم بصور واضحة وأوصاف تفصيلية ومعلومات تواصل، مع تمكين الزوار من تصفح هذه العقارات والاطلاع على تفاصيلها قبل التواصل مباشرةً مع المُلاك عبر أرقامهم المُدرجة في صفحة كل عقار.'
                                : 'Shaleek is an Omani online platform specialized in listing chalets, rest houses, farms, wedding halls and women salons across the governorates of Oman. Our role is limited to helping owners present their properties with clear photos, descriptions and contact details, so visitors can browse and contact owners directly.' }}
                        </p>
                        <p>
                            {{ app()->getLocale() == 'ar'
                                ? 'نؤكد بوضوح تام أن '
                                : 'We clearly state that ' }}
                            <strong>{{ app()->getLocale() == 'ar' ? 'منصة شاليك لا توفر خدمة حجوزات إلكترونية' : 'Shaleek does not provide online booking services' }}</strong>
                            {{ app()->getLocale() == 'ar'
                                ? ' أو مدفوعات رقمية، ولا تعمل كوسيط بين المستخدم والمالك في أي مرحلة من مراحل التعامل. جميع عمليات الحجز والاتفاق على الأسعار والمواعيد وشروط الاستخدام تتم مباشرةً بين المستخدم ومالك العقار، دون تدخل أو ضمان من قِبل المنصة، سواء عبر الواتساب أو الاتصال الهاتفي أو أي وسيلة تواصل أخرى.'
                                : ' or digital payments, and does not act as a broker between users and owners at any stage. All reservations, price agreements, dates and terms are arranged directly between the user and the property owner, without platform involvement or guarantee.' }}
                        </p>
                        <p>
                            {{ app()->getLocale() == 'ar'
                                ? 'وبناءً على ما سبق، فإن '
                                : 'Accordingly, ' }}
                            <strong>{{ app()->getLocale() == 'ar' ? 'منصة شاليك غير مسؤولة' : 'Shaleek is not responsible' }}</strong>
                            {{ app()->getLocale() == 'ar'
                                ? ' عن دقة تفاصيل الحجز أو مواعيده أو حالة العقار عند الوصول، ولا نتحمل أي التزام قانوني تجاه أي خلاف أو نزاع قد ينشأ بين المستخدم والمالك، سواء تعلّق الخلاف بالسعر أو المرافق أو مدة الإقامة أو جودة الخدمة المُقدَّمة أو أي جانب آخر من جوانب التعامل بين الطرفين.'
                                : ' for booking details, timing, property condition on arrival, or any dispute between the user and the owner regarding price, amenities, stay duration, service quality or any other matter agreed directly between both parties.' }}
                        </p>
                        <p>
                            {{ app()->getLocale() == 'ar'
                                ? 'ننصح جميع الزوار بالتحقق من كافة التفاصيل مع مالك العقار قبل تأكيد أي حجز أو دفع أي مبلغ مالي، وتوثيق كامل الاتفاق كتابياً عبر الرسائل. كما ننصح أصحاب العقارات بتحديث معلوماتهم بشكل دوري وتقديم بيانات دقيقة تعكس الواقع. تجدر الإشارة إلى أن منصة شاليك لا تتقاضى أي عمولات أو رسوم على الحجوزات، ونعمل على تقديم خدمة عرض مجانية تخدم قطاع السياحة الداخلية في السلطنة.'
                                : 'We advise visitors to verify all details with the owner before confirming any reservation or payment, and to keep the agreement documented in writing. Owners are encouraged to keep their information updated and accurate. Shaleek does not charge booking commissions or fees and provides a listing service for local tourism in Oman.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('frontend.inc._shaleek_footer')

    <script src="{{ asset('frontend/js/shaleek-design.js') }}?v={{ @filemtime(public_path('frontend/js/shaleek-design.js')) ?: time() }}"></script>
    <script>
        // Filter the "Area" select to the areas of the chosen governorate.
        (function () {
            var citySelect = document.getElementById('shHeroCity');
            var areaSelect = document.getElementById('shHeroArea');
            if (!citySelect || !areaSelect) return;
            var allOptions = Array.prototype.slice.call(areaSelect.options);

            function applyFilter() {
                var cityId = citySelect.value;
                areaSelect.innerHTML = '';
                allOptions.forEach(function (opt) {
                    if (opt.value === '0' || !opt.dataset.city || opt.dataset.city === cityId) {
                        areaSelect.appendChild(opt);
                    }
                });
            }
            citySelect.addEventListener('change', applyFilter);
        })();
    </script>
</body>
</html>
