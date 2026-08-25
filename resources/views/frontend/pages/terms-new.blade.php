@extends('frontend.layouts.weekend_master')

@section('page_title', app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions')

@section('css')
<style>
    /* Hero Section */
    .terms-hero {
        background: linear-gradient(135deg, rgba(18, 118, 100, 0.95) 0%, rgba(18, 118, 100, 0.85) 100%);
        padding: 100px 0 60px;
        color: white;
    }
    
    /* Terms Navigation */
    .terms-nav {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        position: sticky;
        top: 100px;
    }
    
    .terms-nav .nav-link {
        color: #333;
        padding: 12px 20px;
        margin-bottom: 5px;
        border-radius: 10px;
        transition: all 0.3s;
        border-left: 3px solid transparent;
    }
    
    .terms-nav .nav-link:hover,
    .terms-nav .nav-link.active {
        background: #f8f9fa;
        color: #127664;
        border-left-color: #127664;
    }
    
    /* Content Section */
    .terms-content {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }
    
    .terms-content h2 {
        color: #127664;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
    }
    
    .terms-content h3 {
        color: #333;
        margin-top: 25px;
        margin-bottom: 15px;
        font-size: 1.3rem;
    }
    
    .terms-content p {
        line-height: 1.8;
        color: #6c757d;
        margin-bottom: 15px;
    }
    
    .terms-content ul {
        padding-left: 30px;
        margin-bottom: 20px;
    }
    
    .terms-content ul li {
        margin-bottom: 10px;
        color: #6c757d;
        line-height: 1.8;
    }
    
    /* Version Badge */
    .version-badge {
        display: inline-block;
        background: #e7f5f2;
        color: #127664;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
    
    /* Last Updated */
    .last-updated {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border-left: 4px solid #127664;
    }
    
    /* Tab Pills */
    .nav-pills .nav-link {
        background: #f8f9fa;
        color: #333;
        margin: 0 5px;
        border-radius: 25px;
        padding: 10px 25px;
        transition: all 0.3s;
    }
    
    .nav-pills .nav-link.active {
        background: #127664;
        color: white;
    }
    
    /* Accordion */
    .accordion-item {
        border: 1px solid #e9ecef;
        border-radius: 10px !important;
        margin-bottom: 15px;
        overflow: hidden;
    }
    
    .accordion-button {
        background: white;
        color: #333;
        font-weight: 600;
        padding: 20px;
        border: none;
    }
    
    .accordion-button:not(.collapsed) {
        background: #f8f9fa;
        color: #127664;
        box-shadow: none;
    }
    
    .accordion-button:focus {
        box-shadow: none;
    }
    
    .accordion-body {
        padding: 20px;
        line-height: 1.8;
        color: #6c757d;
    }
    
    @media (max-width: 768px) {
        .terms-nav {
            position: relative;
            top: 0;
            margin-bottom: 30px;
        }
        
        .terms-content {
            padding: 25px;
        }
    }
</style>
@endsection

@section('content')

<!-- Hero Section -->
<section class="terms-hero">
    <div class="container">
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3">{{ app()->getLocale() == 'ar' ? 'الشروط والسياسات' : 'Terms & Policies' }}</h1>
            <p class="lead">{{ app()->getLocale() == 'ar' ? 'كل ما تحتاج معرفته حول استخدام منصتنا' : 'Everything you need to know about using our platform' }}</p>
        </div>
    </div>
</section>

<!-- Terms Tabs -->
<section class="py-5">
    <div class="container">
        <!-- Tab Navigation -->
        <ul class="nav nav-pills justify-content-center mb-5" id="termsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="terms-tab" data-bs-toggle="tab" data-bs-target="#terms" type="button" role="tab">
                    <i class="fas fa-gavel"></i> {{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy" type="button" role="tab">
                    <i class="fas fa-shield-alt"></i> {{ app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="refund-tab" data-bs-toggle="tab" data-bs-target="#refund" type="button" role="tab">
                    <i class="fas fa-undo"></i> {{ app()->getLocale() == 'ar' ? 'سياسة الاسترداد' : 'Refund Policy' }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cookies-tab" data-bs-toggle="tab" data-bs-target="#cookies" type="button" role="tab">
                    <i class="fas fa-cookie"></i> {{ app()->getLocale() == 'ar' ? 'سياسة الكوكيز' : 'Cookies Policy' }}
                </button>
            </li>
        </ul>
        
        <!-- Tab Content -->
        <div class="tab-content" id="termsTabContent">
            <!-- Terms & Conditions Tab -->
            <div class="tab-pane fade show active" id="terms" role="tabpanel">
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        <div class="terms-nav">
                            <h5 class="mb-3">{{ app()->getLocale() == 'ar' ? 'الأقسام' : 'Sections' }}</h5>
                            <nav class="nav flex-column">
                                <a class="nav-link active" href="#intro">{{ app()->getLocale() == 'ar' ? 'مقدمة' : 'Introduction' }}</a>
                                <a class="nav-link" href="#usage">{{ app()->getLocale() == 'ar' ? 'استخدام الموقع' : 'Site Usage' }}</a>
                                <a class="nav-link" href="#booking">{{ app()->getLocale() == 'ar' ? 'الحجوزات' : 'Bookings' }}</a>
                                <a class="nav-link" href="#payment">{{ app()->getLocale() == 'ar' ? 'المدفوعات' : 'Payments' }}</a>
                                <a class="nav-link" href="#cancellation">{{ app()->getLocale() == 'ar' ? 'الإلغاء' : 'Cancellation' }}</a>
                                <a class="nav-link" href="#liability">{{ app()->getLocale() == 'ar' ? 'المسؤولية' : 'Liability' }}</a>
                            </nav>
                        </div>
                    </div>
                    
                    <div class="col-lg-9">
                        @if(isset($terms) && $terms->count() > 0)
                            @foreach($terms as $term)
                            <div class="terms-content">
                                @if($term->version)
                                <span class="version-badge">
                                    <i class="fas fa-code-branch"></i> {{ app()->getLocale() == 'ar' ? 'الإصدار' : 'Version' }} {{ $term->version }}
                                </span>
                                @endif
                                
                                @if($term->effective_date)
                                <div class="last-updated">
                                    <i class="fas fa-calendar-check"></i> 
                                    {{ app()->getLocale() == 'ar' ? 'تاريخ السريان:' : 'Effective Date:' }} 
                                    {{ $term->effective_date->format('Y-m-d') }}
                                </div>
                                @endif
                                
                                <h2>{{ app()->getLocale() == 'ar' ? $term->title_ar : $term->title_en }}</h2>
                                <div>{!! app()->getLocale() == 'ar' ? $term->content_ar : $term->content_en !!}</div>
                            </div>
                            @endforeach
                        @else
                            <!-- Default Terms Content -->
                            <div class="terms-content">
                                <span class="version-badge">
                                    <i class="fas fa-code-branch"></i> {{ app()->getLocale() == 'ar' ? 'الإصدار' : 'Version' }} 1.0
                                </span>
                                
                                <h2 id="intro">{{ app()->getLocale() == 'ar' ? 'مقدمة' : 'Introduction' }}</h2>
                                <p>{{ app()->getLocale() == 'ar' ? 
                                    'مرحباً بكم في شاليك عُمان. باستخدامك لموقعنا، فإنك توافق على الالتزام بهذه الشروط والأحكام.' : 
                                    'Welcome to Shaleek Oman. By using our website, you agree to comply with these terms and conditions.' }}</p>
                                
                                <h3 id="usage">{{ app()->getLocale() == 'ar' ? 'استخدام الموقع' : 'Site Usage' }}</h3>
                                <ul>
                                    <li>{{ app()->getLocale() == 'ar' ? 'يجب أن يكون عمرك 18 عاماً أو أكثر لاستخدام خدماتنا' : 'You must be 18 years or older to use our services' }}</li>
                                    <li>{{ app()->getLocale() == 'ar' ? 'يجب تقديم معلومات صحيحة ودقيقة' : 'You must provide accurate and truthful information' }}</li>
                                    <li>{{ app()->getLocale() == 'ar' ? 'أنت مسؤول عن الحفاظ على سرية حسابك' : 'You are responsible for maintaining your account confidentiality' }}</li>
                                </ul>
                                
                                <h3 id="booking">{{ app()->getLocale() == 'ar' ? 'سياسة الحجوزات' : 'Booking Policy' }}</h3>
                                <p>{{ app()->getLocale() == 'ar' ? 
                                    'جميع العروض تخضع للتوافر والتأكيد. نحتفظ بالحق في رفض أو إلغاء أي عرض لا يتوافق مع سياساتنا.' : 
                                    'All bookings are subject to availability and confirmation. We reserve the right to refuse or cancel any booking that does not comply with our policies.' }}</p>
                                
                                <h3 id="payment">{{ app()->getLocale() == 'ar' ? 'المدفوعات' : 'Payments' }}</h3>
                                <ul>
                                    <li>{{ app()->getLocale() == 'ar' ? 'جميع المدفوعات آمنة ومشفرة' : 'All payments are secure and encrypted' }}</li>
                                    <li>{{ app()->getLocale() == 'ar' ? 'نقبل البطاقات الائتمانية والتحويل البنكي' : 'We accept credit cards and bank transfers' }}</li>
                                    <li>{{ app()->getLocale() == 'ar' ? 'الأسعار شاملة الضرائب ما لم يُذكر خلاف ذلك' : 'Prices include taxes unless otherwise stated' }}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Privacy Policy Tab -->
            <div class="tab-pane fade" id="privacy" role="tabpanel">
                <div class="terms-content">
                    @if(isset($privacy) && $privacy->count() > 0)
                        @foreach($privacy as $policy)
                            <h2>{{ app()->getLocale() == 'ar' ? $policy->title_ar : $policy->title_en }}</h2>
                            <div>{!! app()->getLocale() == 'ar' ? $policy->content_ar : $policy->content_en !!}</div>
                        @endforeach
                    @else
                        <h2>{{ app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</h2>
                        <p>{{ app()->getLocale() == 'ar' ? 
                            'نحن نحترم خصوصيتك ونلتزم بحماية بياناتك الشخصية. هذه السياسة توضح كيف نجمع ونستخدم ونحمي معلوماتك.' : 
                            'We respect your privacy and are committed to protecting your personal data. This policy explains how we collect, use, and protect your information.' }}</p>
                        
                        <h3>{{ app()->getLocale() == 'ar' ? 'المعلومات التي نجمعها' : 'Information We Collect' }}</h3>
                        <ul>
                            <li>{{ app()->getLocale() == 'ar' ? 'المعلومات الشخصية (الاسم، البريد الإلكتروني، رقم الهاتف)' : 'Personal information (name, email, phone number)' }}</li>
                            <li>{{ app()->getLocale() == 'ar' ? 'معلومات العرض والدفع' : 'Booking and payment information' }}</li>
                            <li>{{ app()->getLocale() == 'ar' ? 'معلومات الاستخدام وملفات تعريف الارتباط' : 'Usage information and cookies' }}</li>
                        </ul>
                    @endif
                </div>
            </div>
            
            <!-- Refund Policy Tab -->
            <div class="tab-pane fade" id="refund" role="tabpanel">
                <div class="terms-content">
                    @if(isset($refund) && $refund->count() > 0)
                        @foreach($refund as $policy)
                            <h2>{{ app()->getLocale() == 'ar' ? $policy->title_ar : $policy->title_en }}</h2>
                            <div>{!! app()->getLocale() == 'ar' ? $policy->content_ar : $policy->content_en !!}</div>
                        @endforeach
                    @else
                        <h2>{{ app()->getLocale() == 'ar' ? 'سياسة الاسترداد' : 'Refund Policy' }}</h2>
                        <p>{{ app()->getLocale() == 'ar' ? 
                            'نسعى لضمان رضاك التام. إذا لم تكن راضياً عن عرضك، يمكنك طلب استرداد وفقاً للشروط التالية:' : 
                            'We strive to ensure your complete satisfaction. If you are not satisfied with your booking, you can request a refund according to the following conditions:' }}</p>
                        
                        <h3>{{ app()->getLocale() == 'ar' ? 'شروط الاسترداد' : 'Refund Conditions' }}</h3>
                        <ul>
                            <li>{{ app()->getLocale() == 'ar' ? 'الإلغاء قبل 48 ساعة: استرداد كامل' : 'Cancellation 48 hours before: Full refund' }}</li>
                            <li>{{ app()->getLocale() == 'ar' ? 'الإلغاء قبل 24 ساعة: استرداد 50%' : 'Cancellation 24 hours before: 50% refund' }}</li>
                            <li>{{ app()->getLocale() == 'ar' ? 'الإلغاء في نفس اليوم: لا يوجد استرداد' : 'Same day cancellation: No refund' }}</li>
                        </ul>
                    @endif
                </div>
            </div>
            
            <!-- Cookies Policy Tab -->
            <div class="tab-pane fade" id="cookies" role="tabpanel">
                <div class="terms-content">
                    <h2>{{ app()->getLocale() == 'ar' ? 'سياسة ملفات تعريف الارتباط' : 'Cookies Policy' }}</h2>
                    <p>{{ app()->getLocale() == 'ar' ? 
                        'نستخدم ملفات تعريف الارتباط لتحسين تجربتك على موقعنا. هذه السياسة توضح كيف نستخدم هذه الملفات.' : 
                        'We use cookies to improve your experience on our website. This policy explains how we use these files.' }}</p>
                    
                    <h3>{{ app()->getLocale() == 'ar' ? 'أنواع ملفات تعريف الارتباط' : 'Types of Cookies' }}</h3>
                    <ul>
                        <li>{{ app()->getLocale() == 'ar' ? 'ملفات تعريف الارتباط الأساسية' : 'Essential cookies' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'ملفات تعريف الارتباط التحليلية' : 'Analytics cookies' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'ملفات تعريف الارتباط التسويقية' : 'Marketing cookies' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center">
            <h3 class="mb-3">{{ app()->getLocale() == 'ar' ? 'هل لديك أسئلة؟' : 'Have Questions?' }}</h3>
            <p class="text-muted mb-4">{{ app()->getLocale() == 'ar' ? 'فريقنا جاهز لمساعدتك' : 'Our team is ready to help you' }}</p>
            <a href="{{ route('contact_us') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-envelope"></i> {{ app()->getLocale() == 'ar' ? 'تواصل معنا' : 'Contact Us' }}
            </a>
        </div>
    </div>
</section>

@endsection

@section('js')
<script>
// Smooth scroll for navigation links
document.querySelectorAll('.terms-nav a').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
        
        // Update active class
        document.querySelectorAll('.terms-nav a').forEach(link => {
            link.classList.remove('active');
        });
        this.classList.add('active');
    });
});

// Update active link on scroll
window.addEventListener('scroll', () => {
    let current = '';
    const sections = document.querySelectorAll('h2[id], h3[id]');
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });
    
    document.querySelectorAll('.terms-nav a').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').slice(1) === current) {
            link.classList.add('active');
        }
    });
});
</script>
@endsection
