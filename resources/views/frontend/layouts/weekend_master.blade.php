<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#127664">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    @php
        $defaultMetaTitle = $siteTitle ?? $siteName ?? 'shaleek';
        $defaultMetaDescription = $siteMetaDescription
            ?? $siteDescription
            ?? ($siteSettings->getMetaDescriptionAttribute() ?? config('app.site_description', 'A booking platform for chalets, farms, resorts, and cabins.'));
    @endphp
    <meta name="description" content="@yield('meta_description', $defaultMetaDescription)">
    <title>@yield('page_title', $defaultMetaTitle){{ !empty(trim($__env->yieldContent('page_title'))) ? ' - ' . ($siteName ?? 'shaleek') : '' }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Tajawal for Arabic, Poppins for English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet">

    <!-- Complete Icons Fix -->
    @include('layouts.icons-fix')

    <!-- Main Styles (cache-busted) -->
    <link rel="stylesheet" href="{{ asset('frontend/scss/main.css') }}?v={{ @filemtime(public_path('frontend/scss/main.css')) ?: time() }}">
    
    <!-- Mobile Responsive Styles (cache-busted) -->
    <link rel="stylesheet" href="{{ asset('frontend/css/mobile-responsive.css') }}?v={{ @filemtime(public_path('frontend/css/mobile-responsive.css')) ?: time() }}">
    
    <!-- Arabic Font Styles (cache-busted) -->
    <link rel="stylesheet" href="{{ asset('frontend/css/arabic-font.css') }}?v={{ @filemtime(public_path('frontend/css/arabic-font.css')) ?: time() }}">
    
    <style>
        /* Font Family Settings */
        @if(app()->getLocale() == 'ar')
        /* Arabic Font - Tajwal */
        body, 
        h1, h2, h3, h4, h5, h6,
        p, span, div, a, button, input, select, textarea,
        .btn, .form-control, .form-select,
        .navbar, .nav-link, .dropdown-item,
        .card, .card-title, .card-text,
        .breadcrumb, .page-link,
        .modal-title, .modal-body,
        .alert, .badge, .toast,
        * {
            font-family: 'Tajawal', sans-serif !important;
        }
        @else
        /* English Font - Poppins */
        body,
        h1, h2, h3, h4, h5, h6,
        p, span, div, a, button, input, select, textarea,
        .btn, .form-control, .form-select,
        .navbar, .nav-link, .dropdown-item,
        .card, .card-title, .card-text,
        .breadcrumb, .page-link,
        .modal-title, .modal-body,
        .alert, .badge, .toast,
        * {
            font-family: 'Poppins', sans-serif !important;
        }
        @endif
        
        /* Complete Mobile Fixes for English Language */
        @if(app()->getLocale() == 'en')
        @media (max-width: 768px) {
            /* Global LTR fixes */
            body, html, * {
                direction: ltr !important;
                text-align: left !important;
            }
            
            /* Fix Bootstrap utilities for LTR */
            .text-start { text-align: left !important; }
            .text-end { text-align: right !important; }
            .text-center { text-align: center !important; }
            
            .ms-auto { margin-left: auto !important; margin-right: 0 !important; }
            .me-auto { margin-right: auto !important; margin-left: 0 !important; }
            
            .ps-0 { padding-left: 0 !important; }
            .pe-0 { padding-right: 0 !important; }
            .ps-1 { padding-left: 0.25rem !important; }
            .pe-1 { padding-right: 0.25rem !important; }
            .ps-2 { padding-left: 0.5rem !important; }
            .pe-2 { padding-right: 0.5rem !important; }
            .ps-3 { padding-left: 1rem !important; }
            .pe-3 { padding-right: 1rem !important; }
            
            .float-start { float: left !important; }
            .float-end { float: right !important; }
            
            /* Fix forms and inputs */
            input, select, textarea, button {
                direction: ltr !important;
                text-align: left !important;
            }
            
            /* Fix select dropdown arrow position */
            select.form-select {
                background-position: right 0.75rem center !important;
                padding-right: 2.25rem !important;
                padding-left: 0.75rem !important;
            }
            
            /* Fix cards and content */
            .card, .deal-card, .property-card {
                direction: ltr !important;
                text-align: left !important;
            }
            
            /* Fix badges positioning */
            .badge, .discount-badge {
                left: 15px !important;
                right: auto !important;
            }
            
            /* Fix icons spacing */
            i.fa, i.fas, i.far, i.fab, i.bi {
                margin-right: 5px !important;
                margin-left: 0 !important;
            }
            
            /* Fix floating buttons */
            .floating-btn, .whatsapp-btn {
                right: 20px !important;
                left: auto !important;
            }
            
            /* Fix dropdown menus */
            .dropdown-menu {
                left: 0 !important;
                right: auto !important;
                text-align: left !important;
            }
            
            /* Fix offcanvas menu for English */
            .offcanvas-start {
                left: 0 !important;
                right: auto !important;
            }
            
            .offcanvas.offcanvas-start {
                transform: translateX(-100%) !important;
            }
            
            .offcanvas.offcanvas-start.show {
                transform: translateX(0) !important;
            }
            
            .offcanvas-nav {
                direction: ltr !important;
                text-align: left !important;
            }
            
            .offcanvas-body {
                direction: ltr !important;
                text-align: left !important;
            }
            
            .offcanvas-header {
                direction: ltr !important;
                text-align: left !important;
            }
            
            /* Fix close button position */
            .offcanvas-header .btn-close {
                margin-left: auto !important;
                margin-right: 0 !important;
            }
            
            /* Fix navbar items in offcanvas */
            .offcanvas .navbar-nav {
                direction: ltr !important;
                text-align: left !important;
            }
            
            .offcanvas .nav-item {
                direction: ltr !important;
                text-align: left !important;
            }
            
            .offcanvas .nav-link {
                direction: ltr !important;
                text-align: left !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            /* Fix hamburger menu button */
            .hamburger.offcanvas-nav-btn {
                margin-left: 0 !important;
                margin-right: auto !important;
            }
            
            /* Fix side-nav for English */
            .side-nav {
                left: -100% !important;
                right: auto !important;
                direction: ltr !important;
                text-align: left !important;
                transition: all 0.3s ease !important;
            }
            
            .side-nav.active {
                left: 0 !important;
                right: auto !important;
                transform: translateX(0) !important;
            }
            
            .side-nav-header {
                direction: ltr !important;
                text-align: left !important;
            }
            
            .side-nav-header .close-btn {
                right: 20px !important;
                left: auto !important;
            }
            
            .side-nav ul li a {
                direction: ltr !important;
                text-align: left !important;
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
            
            .side-nav ul li a:hover {
                padding-left: 30px !important;
                padding-right: 20px !important;
            }
            
            /* Fix header-side-nav for unified header */
            .header-side-nav {
                left: -100% !important;
                right: auto !important;
                direction: ltr !important;
                text-align: left !important;
                transition: all 0.3s ease !important;
            }
            
            .header-side-nav.active {
                left: 0 !important;
                right: auto !important;
                transform: translateX(0) !important;
            }
            
            .header-side-nav-header {
                direction: ltr !important;
                text-align: left !important;
            }
            
            .header-close-btn {
                right: 20px !important;
                left: auto !important;
            }
        }
        @endif
        /* Default font for English (LTR) */
        :root {
            --font-primary: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif;
        }
        
        * {
            font-family: var(--font-primary) !important;
        }
        
        body, html {
            font-family: var(--font-primary) !important;
        }
        
        h1, h2, h3, h4, h5, h6, p, span, a, button, input, select, textarea, label, div {
            font-family: var(--font-primary) !important;
        }
        
        
        /* Arabic (RTL) - Use Tajawal font */
        [dir="rtl"] {
            --font-primary: 'Tajawal', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif;
        }
        
        [dir="rtl"] * {
            font-family: 'Tajawal', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif !important;
        }
        
        [dir="rtl"] body,
        [dir="rtl"] html {
            font-family: 'Tajawal', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif !important;
        }
        
        [dir="rtl"] h1, [dir="rtl"] h2, [dir="rtl"] h3, 
        [dir="rtl"] h4, [dir="rtl"] h5, [dir="rtl"] h6, 
        [dir="rtl"] p, [dir="rtl"] span, [dir="rtl"] a, 
        [dir="rtl"] button, [dir="rtl"] input, [dir="rtl"] select, 
        [dir="rtl"] textarea, [dir="rtl"] label, [dir="rtl"] div {
            font-family: 'Tajawal', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif !important;
        }
        
        /* Ensure Font Awesome icons display properly */
        .fas, .far, .fab, .fa {
            font-family: 'Font Awesome 6 Free', 'Font Awesome 6 Brands' !important;
        }
        
        [dir="ltr"] body {
            text-align: left;
            font-family: 'Poppins', sans-serif !important;
        }
        
        /* Additional styles for dropdown menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px 0;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: #f0f8f6;
            color: #127664;
        }
    </style>
    
    @yield('css')
</head>
<body>
    @include('frontend.inc._weekend_header')
    
    <main class="main">
        @yield('content')
    </main>
    
    @include('frontend.inc._weekend_footer')
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <!-- Mobile Enhancements -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Detect if mobile
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            if (isMobile) {
                document.body.classList.add('is-mobile');
            }
            
            // Fix viewport height on mobile (for browsers with dynamic toolbars)
            function setViewportHeight() {
                let vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
            }
            
            setViewportHeight();
            window.addEventListener('resize', setViewportHeight);
            window.addEventListener('orientationchange', setViewportHeight);
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Improve touch responsiveness
            if ('ontouchstart' in window) {
                document.addEventListener('touchstart', function() {}, {passive: true});
            }
            
            // Fix iOS input zoom
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="number"], select, textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    if (isMobile && window.innerWidth < 768) {
                        setTimeout(() => {
                            window.scrollTo(0, this.offsetTop - 100);
                        }, 300);
                    }
                });
            });
            
            // Lazy loading for images
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.add('loaded');
                                observer.unobserve(img);
                            }
                        }
                    });
                });
                
                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }
        });
    </script>
    
    @yield('js')
    
</body>
</html>

