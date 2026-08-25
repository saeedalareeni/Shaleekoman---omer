@extends('frontend.layouts.weekend_master')

@section('page_title', app()->getLocale() == 'ar' ? ($about->meta_title_ar ?? 'من نحن') : ($about->meta_title_en ?? 'About Us'))

@section('meta')
<meta name="description" content="{{ app()->getLocale() == 'ar' ? ($about->meta_description_ar ?? '') : ($about->meta_description_en ?? '') }}">
<meta name="keywords" content="{{ $about->keywords ?? '' }}">
<meta property="og:title" content="{{ app()->getLocale() == 'ar' ? ($about->meta_title_ar ?? 'من نحن') : ($about->meta_title_en ?? 'About Us') }}">
<meta property="og:description" content="{{ app()->getLocale() == 'ar' ? ($about->meta_description_ar ?? '') : ($about->meta_description_en ?? '') }}">
@if($about->image_about_us)
<meta property="og:image" content="{{ asset($about->image_about_us) }}">
@endif
@endsection

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
<style>
    /* Force Tajwal Font for Arabic */
    @if(app()->getLocale() == 'ar')
    *, *::before, *::after {
        font-family: 'Tajawal', sans-serif !important;
    }
    body, h1, h2, h3, h4, h5, h6, p, span, div, a, button, input, select, textarea,
    .btn, .card, .card-title, .card-text, .navbar, .nav-link, .breadcrumb,
    .feature-card, .feature-title, .feature-text, .stat-number, .stat-label {
        font-family: 'Tajawal', sans-serif !important;
    }
    @endif
    /* Hero Section */
    .about-hero {
        background: linear-gradient(135deg, rgba(18, 118, 100, 0.95) 0%, rgba(18, 118, 100, 0.85) 100%), 
                    url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1920&q=80') center/cover;
        min-height: 400px;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .about-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/>%3C/g%3E%3C/g%3E%3C/svg%3E');
        opacity: 0.1;
    }
    
    /* Content Sections */
    .about-section {
        padding: 80px 0;
    }
    
    .section-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(18, 118, 100, 0.1);
        color: #127664;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    /* Feature Cards */
    .feature-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #127664, #159265);
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #127664, #159265);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        font-size: 36px;
        color: white;
    }
    
    /* Stats Section */
    .stats-section {
        background: linear-gradient(135deg, #127664, #159265);
        padding: 60px 0;
        position: relative;
        overflow: hidden;
    }
    
    .stat-box {
        text-align: center;
        color: white;
    }
    
    .stat-number {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #fff, rgba(255,255,255,0.8));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .stat-label {
        font-size: 18px;
        opacity: 0.9;
    }
    
    /* Team Section */
    .team-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }
    
    .team-image {
        height: 300px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .team-info {
        padding: 25px;
    }
    
    .team-name {
        font-size: 20px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 5px;
    }
    
    .team-role {
        color: #127664;
        font-size: 14px;
        font-weight: 500;
    }
    
    /* Timeline */
    .timeline {
        position: relative;
        padding: 40px 0;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #127664;
        transform: translateX(-50%);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 50px;
    }
    
    .timeline-item:nth-child(odd) .timeline-content {
        margin-left: auto;
        margin-right: 55%;
    }
    
    .timeline-item:nth-child(even) .timeline-content {
        margin-left: 55%;
    }
    
    .timeline-dot {
        position: absolute;
        left: 50%;
        top: 20px;
        width: 20px;
        height: 20px;
        background: white;
        border: 4px solid #127664;
        border-radius: 50%;
        transform: translateX(-50%);
        z-index: 1;
    }
    
    .timeline-content {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .timeline-year {
        color: #127664;
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    /* Vision & Mission Section */
    .vision-mission-card {
        background: white;
        border-radius: 20px;
        padding: 40px 35px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .vision-mission-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #127664, #159265);
    }
    
    .vision-mission-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .vision-mission-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #127664, #159265);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 30px;
        color: white;
    }
    
    .vision-mission-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
    }
    
    .vision-mission-text {
        color: #666;
        line-height: 1.8;
        font-size: 15px;
    }
    
    /* Company Info Cards */
    .info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        transform: scale(1.05);
    }
    
    .info-card i {
        font-size: 40px;
        margin-bottom: 15px;
        opacity: 0.9;
    }
    
    .info-card .number {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .info-card .label {
        font-size: 14px;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    /* Gallery Section */
    .gallery-card {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 250px;
    }
    
    .gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .gallery-card:hover img {
        transform: scale(1.05);
    }
    
    /* Company Values */
    .value-item {
        text-align: center;
        padding: 20px;
    }
    
    .value-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, rgba(18, 118, 100, 0.1), rgba(21, 146, 101, 0.1));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: #127664;
    }
    
    .value-title {
        font-size: 20px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 10px;
    }
    
    .value-text {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
    }
    
    /* Mobile Responsive - Smaller Cards */
    @media (max-width: 768px) {
        /* Force Tajwal on Mobile */
        * {
            font-family: 'Tajawal', sans-serif !important;
        }
        
        /* Smaller Feature Cards */
        .feature-card {
            padding: 15px !important;
            margin-bottom: 15px !important;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08) !important;
        }
        
        .feature-icon {
            width: 50px !important;
            height: 50px !important;
            font-size: 24px !important;
            margin-bottom: 15px !important;
        }
        
        .feature-title {
            font-size: 16px !important;
            margin-bottom: 8px !important;
        }
        
        .feature-text {
            font-size: 13px !important;
            line-height: 1.5 !important;
        }
        
        /* Smaller Stats */
        .stats-section {
            padding: 40px 0 !important;
        }
        
        .stat-item {
            padding: 15px !important;
        }
        
        .stat-number {
            font-size: 28px !important;
            margin-bottom: 5px !important;
        }
        
        .stat-label {
            font-size: 12px !important;
        }
        
        /* Smaller sections padding */
        .about-section {
            padding: 40px 0 !important;
        }
        
        /* Smaller images */
        .about-image img {
            border-radius: 10px !important;
        }
        
        .image-badge {
            padding: 15px 20px !important;
            border-radius: 10px !important;
        }
        
        .badge-number {
            font-size: 28px !important;
        }
        
        .badge-text {
            font-size: 12px !important;
        }
    }
    
    @media (max-width: 768px) {
        .about-hero {
            min-height: 300px;
        }
        
        .about-hero h1 {
            font-size: 2rem !important;
        }
        
        .about-section {
            padding: 50px 0;
        }
        
        .stat-number {
            font-size: 36px;
        }
        
        .stat-label {
            font-size: 14px;
        }
        
        .timeline::before {
            left: 30px;
        }
        
        .timeline-item:nth-child(odd) .timeline-content,
        .timeline-item:nth-child(even) .timeline-content {
            margin-left: 60px;
            margin-right: 0;
        }
        
        .timeline-dot {
            left: 30px;
        }
        
        .team-card {
            margin-bottom: 20px;
        }
    }
</style>
@endsection

@section('content')

<!-- Hero Section -->
<section class="about-hero" @if($about->hero_image) style="background: linear-gradient(135deg, rgba(18, 118, 100, 0.95) 0%, rgba(18, 118, 100, 0.85) 100%), url('{{ asset($about->hero_image) }}') center/cover;" @elseif($about->bg) style="background: linear-gradient(135deg, rgba(18, 118, 100, 0.95) 0%, rgba(18, 118, 100, 0.85) 100%), url('{{ asset($about->bg) }}') center/cover;" @endif>
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('shaleek.home') }}" class="text-white-50">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                        <li class="breadcrumb-item active text-white">{{ app()->getLocale() == 'ar' ? ($about->hero_title_ar ?? 'من نحن') : ($about->hero_title_en ?? 'About Us') }}</li>
                    </ol>
                </nav>
                @if($about->logo)
                <img src="{{ asset($about->logo) }}" alt="{{ app()->getLocale() == 'ar' ? $about->company_name_ar : $about->company_name_en }}" style="max-height: 60px; margin-bottom: 20px;">
                @endif
                <h1 class="display-4 fw-bold text-white mb-3">
                    {{ app()->getLocale() == 'ar' ? ($about->company_name_ar ?? 'شاليك عُمان') : ($about->company_name_en ?? 'Shaleek Oman') }}
                </h1>
                @if($about->slogan_ar || $about->slogan_en)
                <h3 class="text-white mb-3 fw-light">{{ app()->getLocale() == 'ar' ? $about->slogan_ar : $about->slogan_en }}</h3>
                @endif
                <p class="lead text-white mb-0">{{ app()->getLocale() == 'ar' ? ($about->hero_subtitle_ar ?? 'نحن منصة رائدة في عرض الشاليهات والاستراحات في عُمان') : ($about->hero_subtitle_en ?? 'We are a leading platform for booking chalets and rest houses in Oman') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <span class="section-badge">{{ app()->getLocale() == 'ar' ? ($about->story_badge_ar ?? 'قصتنا') : ($about->story_badge_en ?? 'Our Story') }}</span>
                <h2 class="display-5 fw-bold mb-4">{{ app()->getLocale() == 'ar' ? ($about->story_title_ar ?? 'رحلة نحو تجربة ضيافة استثنائية') : ($about->story_title_en ?? 'Journey Towards Exceptional Hospitality') }}</h2>
                
                {{-- عرض النص الرئيسي "من نحن" --}}
                @if(app()->getLocale() == 'ar')
                    @if($about->about_ar)
                        <div class="mb-4">
                            {!! nl2br(e($about->about_ar)) !!}
                        </div>
                    @endif
                    @if($about->short_about_ar)
                        <p class="lead mb-4">{{ $about->short_about_ar }}</p>
                    @endif
                    @if($about->story_content_ar)
                        <p class="mb-4">{!! nl2br(e($about->story_content_ar)) !!}</p>
                    @endif
                    @if($about->story_content2_ar)
                        <p class="mb-4">{!! nl2br(e($about->story_content2_ar)) !!}</p>
                    @endif
                @else
                    @if($about->about_en)
                        <div class="mb-4">
                            {!! nl2br(e($about->about_en)) !!}
                        </div>
                    @endif
                    @if($about->short_about_en)
                        <p class="lead mb-4">{{ $about->short_about_en }}</p>
                    @endif
                    @if($about->story_content_en)
                        <p class="mb-4">{!! nl2br(e($about->story_content_en)) !!}</p>
                    @endif
                    @if($about->story_content2_en)
                        <p class="mb-4">{!! nl2br(e($about->story_content2_en)) !!}</p>
                    @endif
                @endif
                <div class="row g-4 mt-2">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success fs-4 me-3"></i>
                            <span>{{ app()->getLocale() == 'ar' ? 'عرض آمن ومضمون' : 'Safe & Guaranteed Booking' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success fs-4 me-3"></i>
                            <span>{{ app()->getLocale() == 'ar' ? 'دعم على مدار الساعة' : '24/7 Support' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success fs-4 me-3"></i>
                            <span>{{ app()->getLocale() == 'ar' ? 'أسعار تنافسية' : 'Competitive Prices' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success fs-4 me-3"></i>
                            <span>{{ app()->getLocale() == 'ar' ? 'خيارات متنوعة' : 'Diverse Options' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    @if($about->story_image)
                        <img src="{{ asset($about->story_image) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $about->company_name_ar : $about->company_name_en }}" 
                             class="img-fluid rounded-4 shadow-lg">
                    @elseif($about->image_about_us)
                        <img src="{{ asset($about->image_about_us) }}" 
                             alt="{{ app()->getLocale() == 'ar' ? $about->company_name_ar : $about->company_name_en }}" 
                             class="img-fluid rounded-4 shadow-lg">
                    @else
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80" 
                             alt="About Us" 
                             class="img-fluid rounded-4 shadow-lg">
                    @endif
                    <div class="position-absolute bottom-0 start-0 m-4 bg-white rounded-3 p-3 shadow">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-award text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ app()->getLocale() == 'ar' ? ('+' . ($about->story_years ?? '5') . ' سنوات') : (($about->story_years ?? '5') . '+ Years') }}</h6>
                                <small class="text-muted">{{ app()->getLocale() == 'ar' ? ($about->story_years_text_ar ?? 'من الخبرة') : ($about->story_years_text_en ?? 'Of Experience') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="about-section bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">{{ app()->getLocale() == 'ar' ? ($about->features_badge_ar ?? 'لماذا نحن') : ($about->features_badge_en ?? 'Why Us') }}</span>
            <h2 class="display-5 fw-bold">{{ app()->getLocale() == 'ar' ? ($about->features_title_ar ?? 'ما يميزنا عن الآخرين') : ($about->features_title_en ?? 'What Sets Us Apart') }}</h2>
        </div>
        <div class="row g-4">
            @php
                $defaultFeatures = [
                    ['icon' => 'fas fa-shield-alt', 'title_ar' => 'الأمان والثقة', 'title_en' => 'Safety & Trust', 'desc_ar' => 'نضمن لك عرضاً آمناً وموثوقاً مع حماية كاملة لبياناتك الشخصية والمالية.', 'desc_en' => 'We guarantee safe and reliable booking with complete protection of your personal and financial data.'],
                    ['icon' => 'fas fa-headset', 'title_ar' => 'دعم متواصل', 'title_en' => 'Continuous Support', 'desc_ar' => 'فريق دعم متخصص متاح على مدار الساعة للإجابة على استفساراتك ومساعدتك.', 'desc_en' => 'Specialized support team available 24/7 to answer your questions and help you.'],
                    ['icon' => 'fas fa-star', 'title_ar' => 'جودة مضمونة', 'title_en' => 'Guaranteed Quality', 'desc_ar' => 'نختار بعناية أفضل الشاليهات والاستراحات لضمان تجربة مميزة لعملائنا.', 'desc_en' => 'We carefully select the best chalets and rest houses to ensure a distinctive experience for our customers.'],
                    ['icon' => 'fas fa-mobile-alt', 'title_ar' => 'سهولة الاستخدام', 'title_en' => 'Easy to Use', 'desc_ar' => 'منصة سهلة الاستخدام تمكنك من العرض بخطوات بسيطة من أي جهاز.', 'desc_en' => 'User-friendly platform that allows you to book in simple steps from any device.'],
                    ['icon' => 'fas fa-tags', 'title_ar' => 'أسعار منافسة', 'title_en' => 'Competitive Prices', 'desc_ar' => 'نوفر لك أفضل الأسعار مع عروض وخصومات حصرية على مدار السنة.', 'desc_en' => 'We provide you with the best prices with exclusive offers and discounts throughout the year.'],
                    ['icon' => 'fas fa-map-marked-alt', 'title_ar' => 'تغطية شاملة', 'title_en' => 'Comprehensive Coverage', 'desc_ar' => 'نغطي جميع مناطق السلطنة بمجموعة واسعة من الخيارات المتنوعة.', 'desc_en' => 'We cover all regions of the Sultanate with a wide range of diverse options.']
                ];
            @endphp
            
            @for($i = 1; $i <= 6; $i++)
                @php
                    $icon = $about->{"feature{$i}_icon"} ?? ($defaultFeatures[$i-1]['icon'] ?? 'fas fa-star');
                    $title_ar = $about->{"feature{$i}_title_ar"} ?? ($defaultFeatures[$i-1]['title_ar'] ?? '');
                    $title_en = $about->{"feature{$i}_title_en"} ?? ($defaultFeatures[$i-1]['title_en'] ?? '');
                    $desc_ar = $about->{"feature{$i}_desc_ar"} ?? ($defaultFeatures[$i-1]['desc_ar'] ?? '');
                    $desc_en = $about->{"feature{$i}_desc_en"} ?? ($defaultFeatures[$i-1]['desc_en'] ?? '');
                @endphp
                @if($title_ar || $title_en)
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="{{ $icon }}"></i>
                        </div>
                        <h4 class="mb-3 feature-title">{{ app()->getLocale() == 'ar' ? $title_ar : $title_en }}</h4>
                        <p class="text-muted feature-text">{{ app()->getLocale() == 'ar' ? $desc_ar : $desc_en }}</p>
                    </div>
                </div>
                @endif
            @endfor
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="stat-box stat-item">
                    <div class="stat-number" data-count="{{ $about->stat1_number ?? '500' }}">{{ ($about->stat1_number ?? '500') }}+</div>
                    <div class="stat-label">{{ app()->getLocale() == 'ar' ? ($about->stat1_text_ar ?? 'شاليه واستراحة') : ($about->stat1_text_en ?? 'Chalets & Rest Houses') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box stat-item">
                    <div class="stat-number" data-count="{{ $about->stat2_number ?? '10000' }}">{{ number_format($about->stat2_number ?? 10000) }}+</div>
                    <div class="stat-label">{{ app()->getLocale() == 'ar' ? ($about->stat2_text_ar ?? 'عميل سعيد') : ($about->stat2_text_en ?? 'Happy Customers') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box stat-item">
                    <div class="stat-number" data-count="{{ $about->stat3_number ?? '15000' }}">{{ number_format($about->stat3_number ?? 15000) }}+</div>
                    <div class="stat-label">{{ app()->getLocale() == 'ar' ? ($about->stat3_text_ar ?? 'عرض ناجح') : ($about->stat3_text_en ?? 'Successful Bookings') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box stat-item">
                    <div class="stat-number" data-count="{{ $about->stat4_number ?? '5' }}">{{ $about->stat4_number ?? '5' }}</div>
                    <div class="stat-label">{{ app()->getLocale() == 'ar' ? ($about->stat4_text_ar ?? 'سنوات من الخبرة') : ($about->stat4_text_en ?? 'Years of Experience') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
@if(($about->vision_ar && $about->mission_ar) || ($about->vision_en && $about->mission_en))
<section class="about-section bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">{{ app()->getLocale() == 'ar' ? 'رؤيتنا ورسالتنا' : 'Our Vision & Mission' }}</span>
            <h2 class="display-5 fw-bold">{{ app()->getLocale() == 'ar' ? 'نحو مستقبل أفضل' : 'Towards a Better Future' }}</h2>
        </div>
        <div class="row g-4">
            @if((app()->getLocale() == 'ar' && $about->vision_ar) || (app()->getLocale() == 'en' && $about->vision_en))
            <div class="col-lg-6">
                <div class="vision-mission-card">
                    <div class="vision-mission-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="vision-mission-title">{{ app()->getLocale() == 'ar' ? 'الرؤية' : 'Vision' }}</h3>
                    <p class="vision-mission-text">
                        {{ app()->getLocale() == 'ar' ? $about->vision_ar : $about->vision_en }}
                    </p>
                </div>
            </div>
            @endif
            @if((app()->getLocale() == 'ar' && $about->mission_ar) || (app()->getLocale() == 'en' && $about->mission_en))
            <div class="col-lg-6">
                <div class="vision-mission-card">
                    <div class="vision-mission-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="vision-mission-title">{{ app()->getLocale() == 'ar' ? 'الرسالة' : 'Mission' }}</h3>
                    <p class="vision-mission-text">
                        {{ app()->getLocale() == 'ar' ? $about->mission_ar : $about->mission_en }}
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Company Info Section -->
@if($about->founded_year || $about->employees_count || $about->clients_count)
<section class="about-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">{{ app()->getLocale() == 'ar' ? 'معلومات الشركة' : 'Company Information' }}</span>
            <h2 class="display-5 fw-bold">{{ app()->getLocale() == 'ar' ? 'أرقام تتحدث عن نفسها' : 'Numbers Speak for Themselves' }}</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @if($about->founded_year)
            <div class="col-md-4">
                <div class="info-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-calendar-alt"></i>
                    <div class="number">{{ $about->founded_year }}</div>
                    <div class="label">{{ app()->getLocale() == 'ar' ? 'سنة التأسيس' : 'Founded Year' }}</div>
                </div>
            </div>
            @endif
            @if($about->employees_count)
            <div class="col-md-4">
                <div class="info-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="fas fa-users"></i>
                    <div class="number">{{ number_format($about->employees_count) }}+</div>
                    <div class="label">{{ app()->getLocale() == 'ar' ? 'موظف' : 'Employees' }}</div>
                </div>
            </div>
            @endif
            @if($about->clients_count)
            <div class="col-md-4">
                <div class="info-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-handshake"></i>
                    <div class="number">{{ number_format($about->clients_count) }}+</div>
                    <div class="label">{{ app()->getLocale() == 'ar' ? 'عميل' : 'Clients' }}</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Additional Features Section -->
@if($about->feature1_ar || $about->feature1_en || $about->feature2_ar || $about->feature2_en || $about->feature3_ar || $about->feature3_en)
<section class="about-section bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">{{ app()->getLocale() == 'ar' ? 'خدماتنا المميزة' : 'Our Special Services' }}</span>
            <h2 class="display-5 fw-bold">{{ app()->getLocale() == 'ar' ? 'نقدم لكم الأفضل دائماً' : 'We Always Provide the Best' }}</h2>
        </div>
        <div class="row g-4">
            @if((app()->getLocale() == 'ar' && $about->feature1_ar) || (app()->getLocale() == 'en' && $about->feature1_en))
            <div class="col-md-4">
                <div class="text-center">
                    <div class="feature-icon mx-auto mb-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h5>{{ app()->getLocale() == 'ar' ? $about->feature1_ar : $about->feature1_en }}</h5>
                </div>
            </div>
            @endif
            @if((app()->getLocale() == 'ar' && $about->feature2_ar) || (app()->getLocale() == 'en' && $about->feature2_en))
            <div class="col-md-4">
                <div class="text-center">
                    <div class="feature-icon mx-auto mb-3">
                        <i class="fas fa-award"></i>
                    </div>
                    <h5>{{ app()->getLocale() == 'ar' ? $about->feature2_ar : $about->feature2_en }}</h5>
                </div>
            </div>
            @endif
            @if((app()->getLocale() == 'ar' && $about->feature3_ar) || (app()->getLocale() == 'en' && $about->feature3_en))
            <div class="col-md-4">
                <div class="text-center">
                    <div class="feature-icon mx-auto mb-3">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h5>{{ app()->getLocale() == 'ar' ? $about->feature3_ar : $about->feature3_en }}</h5>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
@if(($about->logo && file_exists(public_path($about->logo))) || 
    ($about->image_about_us && file_exists(public_path($about->image_about_us))) || 
    ($about->bg && file_exists(public_path($about->bg))))
<section class="about-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">{{ app()->getLocale() == 'ar' ? 'معرض الصور' : 'Photo Gallery' }}</span>
            <h2 class="display-5 fw-bold">{{ app()->getLocale() == 'ar' ? 'لحظات من رحلتنا' : 'Moments from Our Journey' }}</h2>
        </div>
        <div class="row g-4">
            @if($about->image_about_us && file_exists(public_path($about->image_about_us)))
            <div class="col-md-6">
                <div class="gallery-card">
                    <img src="{{ asset($about->image_about_us) }}" 
                         alt="{{ app()->getLocale() == 'ar' ? 'صورة تعريفية' : 'About Image' }}">
                </div>
            </div>
            @endif
            @if($about->bg && file_exists(public_path($about->bg)))
            <div class="col-md-6">
                <div class="gallery-card">
                    <img src="{{ asset($about->bg) }}" 
                         alt="{{ app()->getLocale() == 'ar' ? 'الخلفية' : 'Background' }}">
                </div>
            </div>
            @endif
            @if($about->hero_image && file_exists(public_path($about->hero_image)))
            <div class="col-md-12">
                <div class="gallery-card" style="height: 350px;">
                    <img src="{{ asset($about->hero_image) }}" 
                         alt="{{ app()->getLocale() == 'ar' ? 'الصورة الرئيسية' : 'Hero Image' }}">
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Company Values Section -->
<section class="about-section bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">{{ app()->getLocale() == 'ar' ? 'قيمنا' : 'Our Values' }}</span>
            <h2 class="display-5 fw-bold">{{ app()->getLocale() == 'ar' ? 'المبادئ التي نؤمن بها' : 'The Principles We Believe In' }}</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4 class="value-title">{{ app()->getLocale() == 'ar' ? 'الالتزام' : 'Commitment' }}</h4>
                    <p class="value-text">{{ app()->getLocale() == 'ar' ? 'نلتزم بتقديم أفضل خدمة ممكنة لعملائنا وشركائنا' : 'We are committed to providing the best possible service to our customers and partners' }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4 class="value-title">{{ app()->getLocale() == 'ar' ? 'الابتكار' : 'Innovation' }}</h4>
                    <p class="value-text">{{ app()->getLocale() == 'ar' ? 'نسعى دائماً للابتكار وتطوير حلول جديدة تلبي احتياجات السوق' : 'We always strive to innovate and develop new solutions that meet market needs' }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4 class="value-title">{{ app()->getLocale() == 'ar' ? 'الثقة' : 'Trust' }}</h4>
                    <p class="value-text">{{ app()->getLocale() == 'ar' ? 'نبني علاقات طويلة الأمد مبنية على الثقة والشفافية' : 'We build long-term relationships based on trust and transparency' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="about-section">
    <div class="container">
        <div class="bg-gradient rounded-4 p-5" style="background: linear-gradient(135deg, #127664, #159265);">
            <div class="row align-items-center">
                <div class="col-lg-8 text-white">
                    <h3 class="mb-3">{{ app()->getLocale() == 'ar' ? ($about->cta_title_ar ?? 'هل أنت مالك شاليه أو استراحة؟') : ($about->cta_title_en ?? 'Are you a chalet or rest house owner?') }}</h3>
                    <p class="mb-0 opacity-90">{{ app()->getLocale() == 'ar' ? ($about->cta_subtitle_ar ?? 'انضم إلينا اليوم وابدأ في تحقيق أرباح أكثر من خلال منصتنا') : ($about->cta_subtitle_en ?? 'Join us today and start earning more through our platform') }}</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('owner.login') }}" class="btn btn-light btn-lg px-4">
                        {{ app()->getLocale() == 'ar' ? ($about->cta_button_text_ar ?? 'سجل كمالك') : ($about->cta_button_text_en ?? 'Register as Owner') }}
                        <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
