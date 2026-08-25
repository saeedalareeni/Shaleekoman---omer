<!-- Exclusive Weekend Deals Section -->
<section class="deals-section">

  <style>
.deals-section .swiper {
    overflow: hidden;
}
.deals-section .swiper-wrapper {
    align-items: stretch;
}
.deal-card{
    border-radius: 22px;
    overflow: hidden;
    background:#fff;
    box-shadow: 0 8px 25px rgba(0,0,0,.08);
    height: 100%;
}

.deal-image{
    position: relative;
}
.deal-image img{
    width:100%;
    height:230px;
    object-fit:cover;
}

/* مقاسات ثابتة على الكمبيوتر - height البطاقة 100% من الشريحة والزر ملزق تحت */
@media (min-width: 992px) {
    .deals-section .swiper-wrapper {
        align-items: stretch;
    }
    .deals-section .swiper-slide {
        height: 560px;
        display: flex;
    }
    .deals-section .deal-card {
        height: 100% !important;
        min-height: 100% !important;
        max-height: 100% !important;
        display: flex;
        flex-direction: column;
        width: 100%;
        padding-bottom: 0;
    }
    .deals-section .deal-image {
        flex-shrink: 0;
        height: 200px;
    }
    .deals-section .deal-image img {
        object-fit: cover;
    }
    .deals-section .deal-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
        padding: 12px;
    }
    .deals-section .deal-content .deal-contact {
        min-height: 44px;
        flex-shrink: 0;
    }
    .deals-section .deal-content .deal-title {
        flex-shrink: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .deals-section .deal-content .deal-location {
        flex-shrink: 0;
    }
    /* المميزات: ارتفاع ثابت حتى يكون height البطاقات موحد */
    .deals-section .deal-content .deal-features {
        flex-shrink: 0;
        min-height: 40px;
        max-height: 56px;
        overflow: hidden;
    }
    .deals-section .deal-content .deal-host {
        flex-shrink: 0;
    }
    /* زر عرض التفاصيل ملزق تحت آخر شيء في البطاقة */
    .deals-section .deal-content .deal-actions {
        margin-top: auto;
        padding-top: 10px;
        padding-bottom: 0;
        flex-shrink: 0;
    }
    .deals-section .deal-card .btn-view-details {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
}

/* موبايل/تابلت: ارتفاع موحد لجميع البطاقات في قسم جميع العقارات */
@media (max-width: 991px) {
    .deals-section .swiper-wrapper {
        align-items: stretch;
    }
    .deals-section .swiper-slide {
        height: 520px;
        display: flex;
    }
    .deals-section .deal-card {
        height: 100% !important;
        min-height: 100% !important;
        display: flex !important;
        flex-direction: column;
        width: 100%;
    }
    .deals-section .deal-image {
        flex-shrink: 0;
        height: 180px !important;
        min-height: 180px !important;
        max-height: 180px !important;
    }
   
    .deals-section .deal-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
        padding: 12px 15px;
    }
    .deals-section .deal-content .deal-contact {
        flex-shrink: 0;
    }
    .deals-section .deal-content .deal-title {
        flex-shrink: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .deals-section .deal-content .deal-features {
        flex-shrink: 0;
        min-height: 36px;
        max-height: 48px;
        overflow: hidden;
    }
    .deals-section .deal-content .deal-host {
        flex-shrink: 0;
    }
    .deals-section .deal-content .deal-actions {
        margin-top: auto !important;
        padding-top: 12px !important;
        flex-shrink: 0;
    }
}

/* موبايل: إلغاء السلايدر — قائمة ثابتة مرتبة، بطاقات أفقية */
@media (max-width: 767px) {
    .deals-section .deals-arrows {
        display: none !important;
    }
    .deals-section .dealsSwiper {
        height: auto !important;
        overflow: visible !important;
    }
    .deals-section .dealsSwiper .swiper-wrapper {
        display: flex !important;
        flex-direction: column !important;
        gap: 12px;
        transform: none !important;
        width: 100% !important;
    }
    .deals-section .dealsSwiper .swiper-slide {
        width: 100% !important;
        height: auto !important;
        min-height: 185px;
    }
    .deals-section .swiper-slide {
        height: auto !important;
        min-height: 185px;
    }
    /* البطاقة كاملة (صورة + محتوى): حدود وزوايا مستديرة على الكل */
    .deals-section .deal-card {
        flex-direction: row !important;
        height: 100% !important;
        min-height: 185px;
        align-items: stretch;
        overflow: hidden;
        border: 2px solid #159265 !important;
        border-radius: 16px !important;
        box-shadow: 0 2px 12px rgba(21, 146, 101, 0.15) !important;
    }
    /* صورة العقار: تملأ ارتفاع البطاقة بالكامل (cover) */
    .deals-section .deal-image {
        width: 42% !important;
        min-width: 140px !important;
        max-width: 220px !important;
        height: 100% !important;
        min-height: 100% !important;
        max-height: 100% !important;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
        background: #eee;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    [dir="rtl"] .deals-section .deal-image {
        border-radius: 0 14px 14px 0;
    }
    [dir="ltr"] .deals-section .deal-image {
        border-radius: 14px 0 0 14px;
    }
    .deals-section .deal-image img {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100% !important;
        height: 100% !important;
        max-width: none !important;
        max-height: none !important;
        object-fit: cover !important;
        object-position: center !important;
        display: block !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .deals-section .deal-content {
        flex: 1 !important;
        min-width: 0 !important;
        width: auto !important;
        padding: 12px 14px !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between;
        text-align: right;
        overflow: hidden;
        gap: 0;
    }
    .deals-section .deal-content .deal-price-tag {
        margin: 0 0 8px 0;
        padding: 5px 12px;
        flex-shrink: 0;
        border-radius: 20px;
    }
    .deals-section .deal-content .deal-price-tag .new-price {
        font-size: 1.05rem;
        font-weight: 700;
    }
    .deals-section .deal-content .deal-contact {
        margin: 0 0 8px 0;
        flex-shrink: 0;
    }
    .deals-section .deal-content .deal-contact .contact-btn {
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 8px;
    }
    .deals-section .deal-content .deal-title {
        font-size: 0.95rem;
        font-weight: 600;
        -webkit-line-clamp: 2;
        margin: 0 0 4px 0;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        flex-shrink: 0;
        line-height: 1.4;
    }
    .deals-section .deal-content .deal-location {
        font-size: 0.8rem;
        margin: 0 0 8px 0;
        color: #555;
        flex-shrink: 0;
        line-height: 1.5;
        min-height: 2.25em;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .deals-section .deal-content .deal-features {
        display: none !important;
    }
    .deals-section .deal-content .deal-host {
        display: none !important;
    }
    .deals-section .deal-content .deal-actions {
        margin-top: auto !important;
        padding-top: 10px !important;
        gap: 8px;
        flex-shrink: 0;
        border-top: 1px solid #eee;
    }
    .deals-section .deal-content .deal-actions .btn-view-details {
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 600;
        min-height: 40px;
        border-radius: 25px;
    }
    .deals-section .deal-card .discount-badge {
        font-size: 11px;
        padding: 4px 8px;
    }
}

.discount-badge{
    position:absolute;
    top:15px;
    left:15px;
    background:#e84c2c;
    color:#fff;
    padding:6px 14px;
    border-radius:20px;
    font-weight:700;
    font-size:14px;
}

.deal-content{
    padding:16px;
    text-align:center;
    direction: rtl;
    display: flex;
    flex-direction: column;
}

/* السعر */
.deal-price-tag{
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:6px 18px;
    border:2px solid #2bb673;
    border-radius:30px;
    margin-bottom:12px;
    background:#fff;
}

.deal-price-tag del{
    color:#9ca3af;
    font-size:14px;
}

.deal-price-tag span{
    color:#2bb673;
    font-weight:700;
    font-size:18px;
}

/* أزرار التواصل - بطاقات أنيقة */
.deal-contact{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    align-items:center;
    gap:10px;
    margin: 0px 0 8px;
}

.deal-contact a.contact-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    padding:10px 16px;
    font-weight:600;
    font-size:14px;
    text-decoration:none;
    border-radius:50px;
    transition: all 0.25s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    min-height:44px;
}

.deal-contact a.contact-btn:hover{
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0,0,0,.12);
    opacity:1;
}

.deal-contact a.contact-btn i{
    font-size:18px;
}

/* واتساب - خلفية خضراء */
.deal-contact a.contact-btn.whatsapp{
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color:#fff;
    border: none;
}

.deal-contact a.contact-btn.whatsapp:hover{
    background: linear-gradient(135deg, #2ee66a 0%, #0d7a6f 100%);
    color:#fff;
}

/* اتصال - أزرق */
.deal-contact a.contact-btn.call{
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color:#fff;
    border: none;
}

.deal-contact a.contact-btn.call:hover{
    background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
    color:#fff;
}

/* انستجرام - تدرج وردي */
.deal-contact a.contact-btn.instagram{
    background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    color:#fff;
    border: none;
}

.deal-contact a.contact-btn.instagram:hover{
    opacity: 0.95;
    filter: brightness(1.08);
    color:#fff;
}

/* تيك توك - أسود أنيق */
.deal-contact a.contact-btn.tiktok{
    background: #000000;
    color:#fff;
    border: none;
}

.deal-contact a.contact-btn.tiktok:hover{
    background: #333;
    color:#fff;
}

/* على الشاشات الصغيرة: أزرار واتساب واتصال بلون مميز (أخضر) */
@media (max-width: 768px) {
    .deal-contact.listing-contact-mobile a.contact-btn.whatsapp {
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: #fff;
        font-weight: 700;
        border: none;
    }
    .deal-contact.listing-contact-mobile a.contact-btn.call {
        background: linear-gradient(135deg, #159265 0%, #127664 100%);
        color: #fff;
        font-weight: 700;
        border: none;
    }
}
@media (max-width: 480px) {
    .deal-contact {
        gap: 8px;
        margin: 10px 0 6px;
    }
    .deal-contact a.contact-btn {
        padding: 8px 12px;
        font-size: 13px;
        min-height: 40px;
    }
    .deal-contact a.contact-btn i {
        font-size: 16px;
    }
}

.deal-title{
    font-size:18px;
    font-weight:700;
    margin:6px 0;
}

.deal-location{
    color:#666;
    font-size:14px;
}

.deal-features{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:6px;
    margin:10px 0;
}

.deal-features span{
    padding:4px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

.f-blue{background:#e9f3ff;color:#2b6cb0;}
.f-green{background:#e6fff3;color:#1f9254;}
.f-orange{background:#fff2e5;color:#d97706;}
.f-purple{background:#f3e8ff;color:#7e22ce;}

.deal-actions{
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:14px;
}
@media (min-width: 992px) {
    .deals-section .deal-actions {
        margin-top: auto;
    }
}

.btn-view-details{
    flex:1;
    background:#159265;
    color:#fff;
    border:none;
    border-radius:30px;
    padding:12px;
    font-weight:700;
}

.btn-wishlist-circle{
    width:42px;
    height:42px;
    border-radius:50%;
    border:2px solid #159265;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
}
</style>



    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4 deals-nav-wrap">
         <!--    <h2 class="section-title">{{ app()->getLocale() == 'ar' ? 'عروض نهاية الأسبوع الحصرية' : 'Exclusive Weekend Deals' }}</h2>  -->
            <div class="d-flex gap-3 deals-arrows">
                <button class="btn-circular-green deals-prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn-circular-green-outline deals-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
        <h3>{{ app()->getLocale() == 'ar' ? 'جميع العقارات' : 'All properties' }}</h3>
        <div class="swiper dealsSwiper" id="dealsSwiper">
            <div class="swiper-wrapper">
                @forelse($featuredChalets ?? [] as $chalet)
                <div class="swiper-slide">
                    <div class="deal-card deal-card-clickable" data-href="{{ route('showChalet', $chalet->slug) }}">
                        <div class="deal-image">
                            @php
                                $imageUrls = [
                                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80',
                                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80',
                                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80',
                                    'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=600&q=80',
                                    'https://images.unsplash.com/photo-1602343168117-bb8ffe3e2e9f?w=600&q=80',
                                    'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=600&q=80',
                                ];
                                $randomImage = $imageUrls[($loop->index ?? 0) % count($imageUrls)];
                            @endphp
{{--                            <img src="{{ $randomImage }}" alt="{{ $chalet->name }}">--}}
                                <img src="{{ asset($chalet->main_image) }}">
                            @php
                                $defaultPrice = $chalet->default_day_price ?? 100;
                                $holidayPrice = $chalet->holiday_day_price ?? 150;
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
                            @else
                                <span class="discount-badge">50% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                            @endif
                        </div>


 <div class="deal-content">

    {{-- السعر --}}
    <div class="deal-price-tag">
        <del class="old-price">
            {{ number_format($chalet->holiday_day_price ?? 80, 0) }}
        </del>

        <span class="new-price">
            {{ number_format($chalet->default_day_price ?? 60, 0) }} ر.ع
        </span>
    </div>

    {{-- واتساب واتصال فقط في الصفحة الرئيسية والأقسام (انستجرام وتيك توك داخل المواضيع فقط) --}}
    @if($chalet->show_contact_icon && ($chalet->whatsapp_link || $chalet->phone_link))
    <div class="deal-contact listing-contact-mobile">

        @if($chalet->whatsapp_link)
            <a href="{{ $chalet->whatsapp_link }}" class="contact-btn whatsapp" target="_blank" rel="noopener">
                <i class="fab fa-whatsapp"></i>
                واتساب
            </a>
        @endif

        @if($chalet->phone_link)
            <a href="{{ $chalet->phone_link }}" class="contact-btn call">
                <i class="fas fa-phone"></i>
                اتصال
            </a>
        @endif

    </div>
    @endif



                            <h3 class="deal-title">{{ $chalet->name }}</h3>
                            <p class="deal-location">{{ $chalet->city ? $chalet->city->name : '' }}{{ $chalet->area ? ' / '.$chalet->area->name : '' }}</p>
{{-- الخصائص --}}
   <div class="deal-features">

    @if($chalet->has_pool)
        <span class="f-blue">مسبح</span>
    @endif

    @if($chalet->has_garden)
        <span class="f-green">حديقة</span>
    @endif

    @if($chalet->has_beachfront)
        <span class="f-blue">يرى البحر</span>
    @endif

    @if($chalet->has_beach || $chalet->has_beachfront)
        <span class="f-orange">شاطئ خاص</span>
    @endif

    @if($chalet->has_mountain_view)
        <span class="f-purple">إطلالة جبلية</span>
    @endif

    @if($chalet->dedicated_to)
        <span class="f-green">{{ $chalet->dedicated_to_label }}</span>
    @endif

</div>


                            <div class="deal-host">
                                @if($chalet->owner->image !='')
                                    <img src="{{ asset($chalet->owner->image) }}" class="host-avatar">
                                @else
                                    <img src="https://i.pravatar.cc/150?img={{ $loop->iteration ?? rand(1, 50) }}" alt="Host" class="host-avatar">
                                @endif

                                <div class="host-info">
                                    <span class="host-name">{{ $chalet->owner->name ?? 'أحمد محمد' }}</span>
                                    <span class="host-label">{{ app()->getLocale() == 'ar' ? 'مالك العقار' : 'Real estate owner' }}</span>
                                </div>
                            </div>

                            <div class="deal-actions">
                                <button class="btn-view-details" onclick="window.location.href='{{ route('showChalet', $chalet->slug) }}'">
                                    {{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}
                                </button>
                                <button class="btn-wishlist-circle" data-chalet-id="{{ $chalet->id }}">
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
                <!-- Default cards if no chalets -->
                @php
                    $defaultCards = [
                        [
                            'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80',
                            'title_ar' => 'شاليه اللؤلؤة',
                            'title_en' => 'Pearl Chalet',
                            'location_ar' => 'صور / قلهات',
                            'location_en' => 'Sur Quiastis / Qalhot',
                            'discount' => '50%',
                            'price' => 410,
                            'original_price' => 645,
                            'host_img' => 12
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80',
                            'title_ar' => 'زهرة الأوركيد',
                            'title_en' => 'Orchid Flower',
                            'location_ar' => 'الباطنة الجنوبية (بركاء)',
                            'location_en' => 'South Al Batinah (Barka)',
                            'discount' => '50%',
                            'price' => 410,
                            'original_price' => 645,
                            'host_img' => 33
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80',
                            'title_ar' => 'شاليه روزيلا',
                            'title_en' => 'Rosella Chalet',
                            'location_ar' => 'جبل شمس',
                            'location_en' => 'Jebel Shams',
                            'discount' => '40%',
                            'price' => 410,
                            'original_price' => 645,
                            'host_img' => 8,
                            'discount_class' => 'discount-orange'
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=600&q=80',
                            'title_ar' => 'استراحة رأس الحد',
                            'title_en' => 'Ras Al Hadd',
                            'location_ar' => 'نزوى / رستاق',
                            'location_en' => 'Niwa / Rustom',
                            'discount' => '50%',
                            'price' => 410,
                            'original_price' => 645,
                            'host_img' => 15
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1602343168117-bb8ffe3e2e9f?w=600&q=80',
                            'title_ar' => 'مزرعة الأحلام',
                            'title_en' => 'Dream Farm',
                            'location_ar' => 'البريمي',
                            'location_en' => 'Barh',
                            'discount' => '50%',
                            'price' => 410,
                            'original_price' => 645,
                            'host_img' => 68
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=600&q=80',
                            'title_ar' => 'شاليه روزيلا',
                            'title_en' => 'Rosella Chalet',
                            'location_ar' => 'جبل شمس',
                            'location_en' => 'Jebel Shams',
                            'discount' => '40%',
                            'price' => 410,
                            'original_price' => 645,
                            'host_img' => 52,
                            'discount_class' => 'discount-orange'
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=600&q=80',
                            'title_ar' => 'فيلا الساحل',
                            'title_en' => 'Coast Villa',
                            'location_ar' => 'السيب',
                            'location_en' => 'Seeb',
                            'discount' => '35%',
                            'price' => 350,
                            'original_price' => 540,
                            'host_img' => 23,
                            'discount_class' => 'discount-orange'
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=600&q=80',
                            'title_ar' => 'منتجع النخيل',
                            'title_en' => 'Palm Resort',
                            'location_ar' => 'الموالح',
                            'location_en' => 'Al Mawaleh',
                            'discount' => '45%',
                            'price' => 480,
                            'original_price' => 870,
                            'host_img' => 41
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=600&q=80',
                            'title_ar' => 'بيت الجبل',
                            'title_en' => 'Mountain House',
                            'location_ar' => 'الجبل الأخضر',
                            'location_en' => 'Jebel Akhdar',
                            'discount' => '30%',
                            'price' => 320,
                            'original_price' => 460,
                            'host_img' => 17,
                            'discount_class' => 'discount-orange'
                        ],
                        [
                            'image' => 'https://images.unsplash.com/photo-1523217582562-09d0def993a6?w=600&q=80',
                            'title_ar' => 'شقة البحر',
                            'title_en' => 'Sea Apartment',
                            'location_ar' => 'القرم',
                            'location_en' => 'Qurum',
                            'discount' => '55%',
                            'price' => 290,
                            'original_price' => 640,
                            'host_img' => 29
                        ]
                    ];
                @endphp
                @foreach($defaultCards as $card)
                <div class="swiper-slide">
                    <div class="deal-card">
                        <div class="deal-image">
                            <img src="{{ $card['image'] }}" alt="{{ app()->getLocale() == 'ar' ? $card['title_ar'] : $card['title_en'] }}">
                            <span class="discount-badge {{ $card['discount_class'] ?? '' }}">{{ $card['discount'] }} {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                        </div>
                        <div class="deal-content">
                            <div class="deal-price-tag">
                                                            <del class="per-night">{{ $card['original_price'] }}</del>

                            <span class="fw-medium">{{ $card['price'] }} ر.ع</span>
                            </div>
                            <h3 class="deal-title">{{ app()->getLocale() == 'ar' ? $card['title_ar'] : $card['title_en'] }}</h3>
                            <p class="deal-location">{{ app()->getLocale() == 'ar' ? $card['location_ar'] : $card['location_en'] }}</p>
                            <div class="deal-host">
                                <img src="https://i.pravatar.cc/150?img={{ $card['host_img'] }}" alt="Mo. Sayed" class="host-avatar">
                                <div class="host-info">
                                    <span class="host-name">{{ app()->getLocale() == 'ar' ? 'محمد سعيد' : 'Mo. Sayed' }}</span>
                                    <span class="host-label">{{ app()->getLocale() == 'ar' ? 'مالك العقار' : 'Real estate owner' }}</span>
                                </div>
                            </div>
                            <div class="deal-actions">
                                <button class="btn-view-details">{{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}</button>
                                <button class="btn-wishlist-circle">
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
                @endforeach
                @endforelse
            </div>
        </div>
    </div>
</section>
