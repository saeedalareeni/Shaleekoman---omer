@extends('frontend.layouts.weekend_master')

@section('page_title', app()->getLocale() == 'ar' ? 'من نحن' : 'About Us')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
<style>
    /* Force Tajwal Font for Arabic */
    @if(app()->getLocale() == 'ar')
    * {
        font-family: 'Tajawal', sans-serif !important;
    }
    @endif
    
    /* Hero Section */
    .about-hero {
        background: linear-gradient(135deg, #127664 0%, #159265 100%);
        padding: 80px 0;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .about-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: rotate 30s linear infinite;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .company-logo {
        max-height: 80px;
        margin-bottom: 30px;
    }
    
    /* Content Section */
    .content-section {
        padding: 80px 0;
    }
    
    .about-text {
        font-size: 1.1rem;
        line-height: 1.9;
        color: #4a4a4a;
        text-align: justify;
    }
    
    .about-image {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .about-image:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    
    /* Vision & Mission Cards */
    .vision-mission-section {
        background: #f8f9fa;
        padding: 80px 0;
    }
    
    .vm-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        height: 100%;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .vm-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #127664, #159265);
    }
    
    .vm-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }
    
    .vm-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #127664, #159265);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        font-size: 30px;
        color: white;
    }
    
    .vm-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
    }
    
    .vm-text {
        color: #666;
        line-height: 1.8;
        font-size: 1rem;
    }
    
    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, #127664, #159265);
        padding: 50px 0;
        color: white;
    }
    
    .cta-btn {
        background: white;
        color: #127664;
        padding: 12px 35px;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        color: #127664;
        text-decoration: none;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .about-hero {
            padding: 50px 0;
        }
        
        .company-logo {
            max-height: 60px;
        }
        
        .content-section,
        .vision-mission-section {
            padding: 50px 0;
        }
        
        .about-text {
            font-size: 1rem;
        }
        
        .vm-card {
            padding: 30px;
            margin-bottom: 20px;
        }
    }
</style>
@endsection

@section('content')

<!-- Hero Section -->
<section class="about-hero">
    <div class="container">
        <div class="hero-content text-center">
            @if($about->logo)
            <img src="{{ asset($about->logo) }}" alt="Logo" class="company-logo">
            @endif
            
            <h1 class="display-4 fw-bold mb-3">
                {{ app()->getLocale() == 'ar' ? ($about->company_name_ar ?? 'شاليك عُمان') : ($about->company_name_en ?? 'Shaleek Oman') }}
            </h1>
            
            @if($about->slogan_ar || $about->slogan_en)
            <p class="lead mb-0">
                {{ app()->getLocale() == 'ar' ? $about->slogan_ar : $about->slogan_en }}
            </p>
            @endif
        </div>
    </div>
</section>

<!-- About Content Section -->
<section class="content-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="display-5 fw-bold mb-4">
                    {{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}
                </h2>
                <div class="about-text">
                    @if(app()->getLocale() == 'ar')
                        {!! nl2br(e($about->about_ar ?? 'نحن منصة رائدة في عرض الشاليهات والاستراحات في عُمان')) !!}
                    @else
                        {!! nl2br(e($about->about_en ?? 'We are a leading platform for booking chalets and rest houses in Oman')) !!}
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                @if($about->image_about_us)
                <img src="{{ asset($about->image_about_us) }}" alt="About" class="about-image">
                @elseif($about->hero_image)
                <img src="{{ asset($about->hero_image) }}" alt="About" class="about-image">
                @else
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80" alt="About" class="about-image">
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
@if(($about->vision_ar && app()->getLocale() == 'ar') || ($about->vision_en && app()->getLocale() == 'en') || 
    ($about->mission_ar && app()->getLocale() == 'ar') || ($about->mission_en && app()->getLocale() == 'en'))
<section class="vision-mission-section">
    <div class="container">
        <div class="row g-4">
            @if((app()->getLocale() == 'ar' && $about->vision_ar) || (app()->getLocale() == 'en' && $about->vision_en))
            <div class="col-md-6">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="vm-title">{{ app()->getLocale() == 'ar' ? 'الرؤية' : 'Vision' }}</h3>
                    <p class="vm-text">
                        {{ app()->getLocale() == 'ar' ? $about->vision_ar : $about->vision_en }}
                    </p>
                </div>
            </div>
            @endif
            
            @if((app()->getLocale() == 'ar' && $about->mission_ar) || (app()->getLocale() == 'en' && $about->mission_en))
            <div class="col-md-6">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="vm-title">{{ app()->getLocale() == 'ar' ? 'الرسالة' : 'Mission' }}</h3>
                    <p class="vm-text">
                        {{ app()->getLocale() == 'ar' ? $about->mission_ar : $about->mission_en }}
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="text-center">
            <h3 class="mb-3">
                {{ app()->getLocale() == 'ar' ? 'هل تريد الانضمام إلينا؟' : 'Want to Join Us?' }}
            </h3>
            <p class="mb-4">
                {{ app()->getLocale() == 'ar' ? 'ابدأ رحلتك معنا اليوم' : 'Start your journey with us today' }}
            </p>
            <a href="{{ route('owner.login') }}" class="cta-btn">
                {{ app()->getLocale() == 'ar' ? 'سجل كمالك' : 'Register as Owner' }}
                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} ms-2"></i>
            </a>
        </div>
    </div>
</section>

@endsection
