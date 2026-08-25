<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $defaultHomeTitle = $siteTitle ?? $siteName ?? 'shaleek';
        $defaultHomeDescription = $siteMetaDescription
            ?? $siteDescription
            ?? config('app.site_description', 'A booking platform for chalets, farms, resorts, and cabins.');
    @endphp
    <meta name="description" content="{{ $defaultHomeDescription }}">
    <title>{{ $defaultHomeTitle }}</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Tajawal for Arabic, Poppins for English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<meta name="google-site-verification" content="2EDMdlj1fYrkMmXXCyJRkdqDrwa9wka7-TcLdv3r_Io" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />

    <!-- Fallback for Font Awesome if primary CDN fails -->
    <script>
        // Test if Font Awesome loaded
        window.addEventListener('DOMContentLoaded', function() {
            var testIcon = document.createElement('i');
            testIcon.className = 'fas fa-check';
            testIcon.style.display = 'none';
            document.body.appendChild(testIcon);

            var width = window.getComputedStyle(testIcon, ':before').getPropertyValue('font-family');

            if (!width || width.indexOf('Font Awesome') === -1) {
                // Fallback to alternative CDN
                var link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://use.fontawesome.com/releases/v6.5.1/css/all.css';
                document.head.appendChild(link);
            }

            document.body.removeChild(testIcon);
        });
    </script>

    <!-- Font Loading Check -->
    <script>
        document.fonts.ready.then(function() {
            var isArabic = document.documentElement.getAttribute('dir') === 'rtl';
            var fontToCheck = isArabic ? 'Tajawal' : 'Poppins';

            // Check if the appropriate font loaded
            if (document.fonts.check('1em ' + fontToCheck)) {
                console.log('Ã¢Å“â€¦ ' + fontToCheck + ' font loaded successfully');
            } else {
                console.error('Ã¢ÂÅ’ ' + fontToCheck + ' font failed to load');
                // Try to reload the fonts
                var link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap';
                document.head.appendChild(link);
            }
        });
    </script>

    <!-- Main Styles -->
    <link rel="stylesheet" href="{{ asset('frontend/scss/main.css') }}">

    <!-- Header Fix CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/header-fix.css') }}">

    <!-- Mobile Responsive Styles -->
    <link rel="stylesheet" href="{{ asset('frontend/css/mobile-responsive.css') }}">

    <style>
        /* Hero Section Styles */
        .hero-booking-section {
            position: relative;
            padding: 0 0.8rem;
            margin-bottom: 80px;
            overflow: visible;
        }

        .hero-booking-section .container-fluid {
            max-width: 1465px;
            margin: 0 auto;
            padding-left: 0;
            padding-right: 0;
            position: relative;
        }

        .hero-booking-section .heroSwiper {
            width: 100%;
            height: 430px;
            border-radius: 40px;
            overflow: hidden;
            border-bottom: 22px solid #127664;
        }

        .hero-booking-section .heroSwiper .swiper-wrapper {
            height: 100%;
        }

        .hero-booking-section .heroSwiper .swiper-slide {
            position: relative;
            background-size: cover;
            background-position: center;
            border-radius: 40px;
            height: 100%;
        }

        .hero-booking-section .heroSwiper .swiper-slide .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.75) 0%, rgba(255, 255, 255, 0.35) 100%);
            border-radius: 40px;
        }

        .hero-booking-section .heroSwiper .swiper-slide .slide-content {
            position: relative;
            z-index: 2;
            padding: 60px 65px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero-booking-section .heroSwiper .swiper-slide .slide-content .logo-circle {
            width: 92px;
            height: 92px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .hero-booking-section .heroSwiper .swiper-slide .slide-content .logo-circle img {
            width: 60%;
            height: 60%;
            object-fit: contain;
        }

        .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text h1 {
            font-size: 60px;
            font-weight: 600;
            color: #1a1a1a;
            line-height: 1.2;
        }

        .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text h1 .text-success {
            color: #127664;
        }

        .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text p {
            font-size: 40px;
            color: #1a1a1a;
            font-weight: 400;
            margin: 0;
        }

        .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text .btn-join,
        .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text .btn-orange-primary {
            background: linear-gradient(180deg, #FF6341 0%, #EB5432 100%);
            border: none;
            padding: 14px 35px;
            border-radius: 50px;
            font-size: 20px;
            color: white;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text .btn-join:hover,
        .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text .btn-orange-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(235, 84, 50, 0.3);
        }

        /* Hero Navigation Buttons */
        .hero-booking-section .hero-nav-buttons {
            position: absolute;
            bottom: 30px;
            right: 30px;
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .hero-booking-section .swiper-button-prev,
        .hero-booking-section .swiper-button-next {
            position: static;
            width: 50px;
            height: 50px;
            margin: 0;
        }

        .hero-booking-section .swiper-button-prev:after,
        .hero-booking-section .swiper-button-next:after {
            display: none;
        }

        .hero-booking-section .swiper-pagination {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            width: auto;
        }

        .hero-booking-section .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            background: white;
            opacity: 0.5;
        }

        .hero-booking-section .swiper-pagination-bullet-active {
            opacity: 1;
            background: #127664;
        }

        /* Mobile Responsive for Hero */
        @media (max-width: 768px) {
            .hero-booking-section {
                padding: 0 0.5rem;
                margin-bottom: 60px;
            }

            .hero-booking-section .heroSwiper {
                height: 350px;
                border-radius: 20px;
                border-bottom-width: 15px;
            }

            .hero-booking-section .heroSwiper .swiper-slide .slide-content {
                padding: 30px 25px;
            }

            .hero-booking-section .heroSwiper .swiper-slide .slide-content .logo-circle {
                width: 70px;
                height: 70px;
            }

            .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text h1 {
                font-size: 32px;
            }

            .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text p {
                font-size: 20px;
            }

            .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text .btn-join,
            .hero-booking-section .heroSwiper .swiper-slide .slide-content .hero-text .btn-orange-primary {
                font-size: 16px;
                padding: 10px 25px;
            }

            .hero-booking-section .hero-nav-buttons {
                bottom: 20px;
                right: 20px;
            }

            .hero-booking-section .swiper-button-prev,
            .hero-booking-section .swiper-button-next {
                width: 40px;
                height: 40px;
            }
        }

        /* Mobile Responsive Improvements */
        @media (max-width: 768px) {
            /* Filter Section Mobile */
            .search-section,
            .filter-container {
                padding: 10px !important;
                margin: 10px 5px !important;
            }

            .search-form .row {
                margin: 0 !important;
            }

            .search-form .col-md-3,
            .search-form .col-md-2,
            .search-form .col-md-4 {
                width: 100% !important;
                padding: 5px !important;
                margin-bottom: 10px !important;
            }

            .search-form input,
            .search-form select {
                width: 100% !important;
                height: 45px !important;
                font-size: 14px !important;
            }

            .search-form button {
                width: 100% !important;
                height: 50px !important;
                font-size: 16px !important;
                margin-top: 10px !important;
            }

            /* Property Cards Mobile */
            .property-card {
                margin-bottom: 20px !important;
            }

            .property-card .card-img-top {
                height: 200px !important;
                object-fit: cover !important;
            }

            .property-card .card-body {
                padding: 15px !important;
            }

            .property-card .card-title {
                font-size: 1.1rem !important;
            }

            .property-card .price {
                font-size: 1.2rem !important;
            }

            /* Categories Section */
            .categories-section {
                padding: 20px 10px !important;
            }

            .category-card {
                margin-bottom: 15px !important;
            }

            /* Hero Section */
            .hero-section {
                padding: 30px 15px !important;
                min-height: auto !important;
            }

            .hero-title {
                font-size: 1.5rem !important;
            }

            .hero-subtitle {
                font-size: 0.9rem !important;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 480px) {
            .search-form button {
                padding: 12px !important;
            }

            .property-card .card-img-top {
                height: 180px !important;
            }

            /* Hide some elements on very small screens */
            .hide-xs {
                display: none !important;
            }

            /* Deal Cards Mobile */
            .deal-card {
                min-width: calc(50vw - 20px) !important;
            }

            .deal-image {
                height: 140px !important;
            }

            .deal-title {
                font-size: 13px !important;
            }

            .deal-location {
                font-size: 11px !important;
            }

            .deal-price-tag {
                font-size: 14px !important;
            }

            .btn-view-details {
                font-size: 12px !important;
                padding: 8px 12px !important;
            }
        }

        /* iPhone SE and similar */
        @media (max-width: 375px) {
            .container,
            .container-fluid {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .property-card .card-body {
                padding: 10px !important;
            }

            .property-card .card-title {
                font-size: 1rem !important;
            }


            /* Deal Cards very small */
            .deal-card {
                min-width: calc(50vw - 15px) !important;
            }

            .deal-content {
                padding: 10px !important;
            }

            .deal-host {
                display: none !important;
            }
        }

        /* Destinations Section Styles */
        .destinations-section {
            padding: 60px 30px;
            overflow: hidden;
        }
        @media (max-width: 768px) {
            .destinations-section {
                overflow: visible;
            }
        }

        .destinations-section .destinationsSwiper .destination-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .destinations-section .destinationsSwiper .destination-card:hover {
            transform: translateY(-5px);
        }

        .destinations-section .destinationsSwiper .destination-card .destination-image {
            width: 140px;
            height: 140px;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .destinations-section .destinationsSwiper .destination-card .destination-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .destinations-section .destinationsSwiper .destination-card .destination-image:hover img {
            transform: scale(1.1);
        }

        .destinations-section .destinationsSwiper .destination-card .destination-name {
            font-size: 18px;
            font-weight: 500;
            color: #1a1a1a;
            margin: 0;
            text-align: center;
        }

        /* Desktop Destinations - Keep Original Sizes */
        @media (min-width: 769px) {
            .destinations-section .destinationsSwiper .destination-card .destination-image {
                width: 140px;
                height: 140px;
            }

            .destinations-section .destinationsSwiper .destination-card .destination-name {
                font-size: 18px;
            }
        }

        /* Mobile Responsive for Destinations - Ã˜ÂµÃ™Ë†Ã˜Â± Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â­Ã˜Â§Ã™ÂÃ˜Â¸Ã˜Â§Ã˜Âª Ã˜ÂªÃ˜Â¸Ã™â€¡Ã˜Â± Ã™Æ’Ã˜Â§Ã™â€¦Ã™â€žÃ˜Â© */
        @media (max-width: 768px) {
            .destinations-section {
                padding: 40px 0;
            }

            .destinations-section .container-fluid.px-4 {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            .destinations-section .destinationsSwiper {
                overflow: visible !important;
                margin: 0 -8px;
                padding: 0 8px;
            }

            .destinations-section .destinationsSwiper .swiper-slide {
                width: 88px !important;
                flex-shrink: 0;
                display: flex;
                justify-content: center;
                box-sizing: border-box;
            }

            .destinations-section .destinationsSwiper .destination-card {
                gap: 8px !important;
                width: 100%;
                align-items: center;
            }

            .destinations-section .destinationsSwiper .destination-card .destination-image {
                width: 72px !important;
                height: 72px !important;
                min-width: 72px;
                min-height: 72px;
                border-radius: 15px !important;
                background: #f0f0f0;
                overflow: hidden;
            }
            .destinations-section .destinationsSwiper .destination-card .destination-image img {
                width: 100% !important;
                height: 100% !important;
                display: block !important;
            }

            .destinations-section .destinationsSwiper .destination-card .destination-name {
                font-size: 12px !important;
                max-width: 72px !important;
                text-align: center !important;
                line-height: 1.2 !important;
            }
        }

        @media (max-width: 480px) {
            .destinations-section .section-title {
                font-size: 18px !important;
            }

            .destinations-section .destinationsSwiper .swiper-slide {
                width: 80px !important;
            }

            .destinations-section .destinationsSwiper .destination-card .destination-image {
                width: 64px !important;
                height: 64px !important;
                min-width: 64px;
                min-height: 64px;
                border-radius: 12px !important;
                background: #f0f0f0;
            }

            .destinations-section .destinationsSwiper .destination-card .destination-name {
                font-size: 11px !important;
                max-width: 64px !important;
            }
        }

        @media (max-width: 360px) {
            .destinations-section .destinationsSwiper .swiper-slide {
                width: 74px !important;
            }

            .destinations-section .destinationsSwiper .destination-card .destination-image {
                width: 58px !important;
                height: 58px !important;
                min-width: 58px;
                min-height: 58px;
                border-radius: 10px !important;
                background: #f0f0f0;
            }

            .destinations-section .destinationsSwiper .destination-card .destination-name {
                font-size: 10px !important;
                max-width: 58px !important;
            }
        }

        /* Ã˜Â§Ã™â€žÃ˜Â³Ã™â€žÃ˜Â§Ã™Å Ã˜Â¯Ã˜Â± Ã˜Â¹Ã™â€žÃ™â€° Ã˜Â§Ã™â€žÃ™â€¦Ã™Ë†Ã˜Â¨Ã˜Â§Ã™Å Ã™â€ž - Ã™â€žÃ˜Â§ Ã™â€ Ã˜ÂªÃ˜Â¯Ã˜Â®Ã™â€ž Ã˜Â¨Ã˜Â¹Ã˜Â±Ã˜Â¶ Swiper Ã˜Â§Ã™â€žÃ˜Â¯Ã˜Â§Ã˜Â®Ã™â€žÃ™Å  */
        @media (max-width: 767px) {
            .deals-section .container-fluid {
                overflow: hidden;
                padding-left: 12px;
                padding-right: 12px;
            }
            .deals-section .dealsSwiper {
                overflow: hidden;
                width: 100%;
                touch-action: pan-y;
                -webkit-overflow-scrolling: touch;
            }
            .dealsSwiper .swiper-slide {
                height: auto !important;
                min-height: 185px;
                box-sizing: border-box;
                width: 100% !important;
                max-width: 100% !important;
            }
            .dealsSwiper .deal-card {
                width: 100%;
                min-width: 0;
            }
            /* Ã™â€žÃ˜Â§ Ã™â€ Ã™â€šÃ™Å Ã™â€˜Ã˜Â¯ Ã˜Â§Ã˜Â±Ã˜ÂªÃ™ÂÃ˜Â§Ã˜Â¹ Ã˜ÂµÃ™Ë†Ã˜Â±Ã˜Â© Ã˜Â§Ã™â€žÃ˜Â¹Ã™â€šÃ˜Â§Ã˜Â± Ã™â€¡Ã™â€ Ã˜Â§Ã˜â€º Ã™Å Ã˜ÂªÃ™â€¦ Ã˜Â§Ã™â€žÃ˜ÂªÃ˜Â­Ã™Æ’Ã™â€¦ Ã˜Â¨Ã™â€¡Ã˜Â§ Ã˜Â¯Ã˜Â§Ã˜Â®Ã™â€ž _weekend_deals Ã˜Â­Ã˜ÂªÃ™â€° Ã˜ÂªÃ˜ÂªÃ™â€¦Ã˜Â¯Ã™â€˜Ã˜Â¯ Ã™â€¦Ã˜Â¹ Ã˜Â§Ã˜Â±Ã˜ÂªÃ™ÂÃ˜Â§Ã˜Â¹ Ã˜Â§Ã™â€žÃ˜Â¨Ã˜Â·Ã˜Â§Ã™â€šÃ˜Â© */
            .deals-section .deal-card .deal-image {
                height: auto !important;
                min-height: 0 !important;
                max-height: none !important;
            }
            .deals-section .deal-card .deal-image img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
                object-position: center !important;
            }
        }

        /* Fix wishlist button - only heart icon */
        .btn-wishlist-circle {
            width: 30px !important;
            height: 30px !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .btn-wishlist-circle:hover {
            background: transparent !important;
            transform: scale(1.1);
        }

        .btn-wishlist-circle:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .btn-wishlist-circle.active {
            background: transparent !important;
        }

        .btn-wishlist-circle svg {
            width: 24px;
            height: 24px;
            transition: all 0.3s ease;
        }

        .btn-wishlist-circle svg path {
            transition: all 0.3s ease;
        }

        .btn-wishlist-circle:hover svg path {
            stroke: #dc3545;
        }

        .btn-wishlist-circle.active svg path {
            fill: #dc3545;
            stroke: #dc3545;
        }

        /* Service tags styles - Original colors */
        .services-section .service-tags {
            display: flex !important;
            gap: 8px !important;
            flex-wrap: wrap !important;
            margin-bottom: 15px !important;
        }

        .services-section .service-tags .tag {
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            white-space: nowrap !important;
        }

        /* Pool tag - Blue */
        .services-section .service-tags .tag-pool {
            background: #E6F7FF !important;
            color: #1890FF !important;
            border: 1px solid #91D5FF !important;
        }

        /* Beachfront tag - Teal */
        .services-section .service-tags .tag-beachfront {
            background: #E6FFFB !important;
            color: #13C2C2 !important;
            border: 1px solid #87E8DE !important;
        }

        /* Beach tag - Orange */
        .services-section .service-tags .tag-beach {
            background: #FFF7E6 !important;
            color: #FA8C16 !important;
            border: 1px solid #FFD591 !important;
        }

        /* Garden tag - Green */
        .services-section .service-tags .tag-garden {
            background: #F6FFED !important;
            color: #52C41A !important;
            border: 1px solid #B7EB8F !important;
        }

        /* Mountain tag - Purple */
        .services-section .service-tags .tag-mountain {
            background: #F9F0FF !important;
            color: #722ED1 !important;
            border: 1px solid #D3ADF7 !important;
        }

        /* Fix service card white space issue */
        .services-section .service-card {
            background: white !important;
            overflow: hidden !important;
            margin-bottom: 0 !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            border: none !important;
        }

        .services-section .service-card:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .services-section .service-card .service-content {
            padding: 15px !important;
            background: white !important;
            border-radius: 0 0 15px 15px !important;
        }

        .services-section .service-image {
            height: 200px !important;
            overflow: hidden !important;
            margin: 0 !important;
            position: relative !important;
            border-radius: 15px 15px 0 0 !important;
            background: white !important;
        }

        .services-section .service-image img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
        }

        /* Fix deal card issues - Ã˜Â§Ã˜Â±Ã˜ÂªÃ™ÂÃ˜Â§Ã˜Â¹ Ã˜Â§Ã™â€žÃ˜Â¨Ã˜Â·Ã˜Â§Ã™â€šÃ˜Â§Ã˜Âª Ã™â€¦Ã™Ë†Ã˜Â­Ã™â€˜Ã˜Â¯ Ã™â€¦Ã™â€  _weekend_deals (Ã˜Â¯Ã™Å Ã˜Â³Ã™Æ’Ã˜ÂªÃ™Ë†Ã˜Â¨ Ã™Ë†Ã™â€¦Ã™Ë†Ã˜Â¨Ã˜Â§Ã™Å Ã™â€ž) */
        .deals-section .deal-card {
            background: white !important;
            overflow: hidden !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
        }

        .deals-section .deal-card:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .deals-section .deal-card .deal-content {
            padding: 15px !important;
            padding-top: 10px !important;
            background: white !important;
            justify-content: space-between;
        }

        /* .deals-section .deal-card .deal-image {
            height: 200px !important;
            overflow: hidden !important;
            margin: 0 !important;
            position: relative !important;
        } */

        .deals-section .deal-card .deal-image img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }

        /* Remove any extra padding/margin from card actions */
        .service-actions, .deal-actions {
            margin-top: 15px !important;
            padding-top: 15px !important;
            border-top: 1px solid #f0f0f0 !important;
        }

        /* Toast animation */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Default font for English (LTR) */
        :root {
            --font-primary: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif;
        }

        /* Apply Poppins for English by default */
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
            text-align: right;
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


        /* Destination link styles */
        .destination-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .destination-link:hover .destination-card {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        /* Mobile Filter Modal Styles */
        .mobile-filter-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10000;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            pointer-events: none;
        }

        .mobile-filter-modal.active {
            pointer-events: all;
        }

        .mobile-filter-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-filter-modal.active .mobile-filter-overlay {
            opacity: 1;
        }

        .mobile-filter-content {
            position: relative;
            background: white;
            width: 100%;
            max-height: 70vh;
            border-radius: 20px 20px 0 0;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .mobile-filter-modal.active .mobile-filter-content {
            transform: translateY(0);
        }

        .mobile-filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            background: #f8f9fa;
            position: relative;
        }

        .mobile-filter-header h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #127664;
        }

        .mobile-filter-count {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            color: #999;
        }

        .close-mobile-filter {
            background: none;
            border: none;
            font-size: 28px;
            color: #666;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-filter-footer {
            display: flex;
            gap: 10px;
            padding: 15px 20px;
            border-top: 1px solid #e0e0e0;
            background: white;
        }

        .btn-clear-filter {
            flex: 1;
            padding: 12px;
            border: 2px solid #e0e0e0;
            background: white;
            color: #666;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-clear-filter:hover {
            background: #f8f9fa;
        }

        .btn-apply-filter {
            flex: 2;
            padding: 12px;
            border: none;
            background: #e0e0e0;
            color: #999;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-apply-filter.active {
            background: linear-gradient(180deg, #26CA8E 0%, #27A173 100%);
            color: white;
        }

        .btn-apply-filter.active:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(39, 161, 115, 0.3);
        }

        .mobile-filter-body {
            padding: 20px;
            max-height: calc(70vh - 80px);
            overflow-y: auto;
            position: relative;
            z-index: 1;
        }

        .mobile-filter-body * {
            pointer-events: auto !important;
        }

        .mobile-filter-body .checkbox-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            position: relative;
        }

        .mobile-filter-body .checkbox-item:last-child {
            border-bottom: none;
        }

        .mobile-filter-body .checkbox-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            cursor: pointer;
            z-index: 2;
            position: relative;
        }

        .mobile-filter-body .checkbox-item span {
            font-size: 16px;
            color: #333;
            flex: 1;
        }

        .mobile-filter-body label {
            display: flex;
            align-items: center;
            width: 100%;
            cursor: pointer;
        }

        /* Mobile Responsive */
        @media (min-width: 768px) {
            .filter-pills-mobile {
                display: none;
            }

            .mobile-filter-modal {
                display: none !important;
            }
        }

        @media (max-width: 767px) {
            .filter-pills-container {
                display: none !important;
            }

            .filter-pills-mobile {
                display: block;
                padding: 15px;
                background: white;
                margin-top: -10px;
                position: relative;
                z-index: 100;
            }

            .mobile-search-section {
                display: flex;
                gap: 10px;
                align-items: center;
            }

            .mobile-filter-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                flex: 1;
            }

            .filter-pill-mobile {
                background: white;
                border: 1px solid #e5e7eb;
                padding: 8px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
                color: #374151;
                display: flex;
                align-items: center;
                justify-content: space-between;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .filter-pill-mobile:hover {
                background: #e3f0e9;
                border-color: #127664;
                color: #127664;
            }

            .filter-pill-mobile i {
                font-size: 10px;
                opacity: 0.5;
            }

            .search-btn-mobile {
                background: #127664;
                border: none;
                width: 45px;
                height: 45px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                flex-shrink: 0;
            }

            .search-btn-mobile:hover {
                background: #0e5a4c;
            }

            .search-btn-mobile svg {
                width: 20px;
                height: 20px;
            }
        }

        @media (max-width: 480px) {
            .mobile-filter-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-pill-mobile {
                font-size: 11px;
                padding: 6px 10px;
            }
        }

        [dir="ltr"] body {
            text-align: left;
            font-family: 'Poppins', sans-serif !important;
        }
        /* Fix Bootstrap RTL issues */
        [dir="rtl"] .ms-auto {
            margin-right: auto!important;
            margin-left: 0!important;
        }

        /* Ensure proper spacing */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Fix dropdown menu styles */
        .dropdown-menu {
            min-width: 200px !important;
            margin-top: 10px !important;
            border: 1px solid #e0e0e0 !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
            border-radius: 8px !important;
            padding: 8px 0 !important;
            background: white !important;
            z-index: 1050 !important;
        }

        .dropdown-item {
            padding: 10px 20px !important;
            color: #333 !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa !important;
            color: #127664 !important;
            padding-left: 25px !important;
        }

        .dropdown-divider {
            margin: 8px 0 !important;
            border-color: #e0e0e0 !important;
        }

        /* Fix RTL dropdown alignment */
        [dir="rtl"] .dropdown-menu {
            text-align: right !important;
            right: 0 !important;
            left: auto !important;
        }

        [dir="rtl"] .dropdown-item:hover {
            padding-right: 25px !important;
            padding-left: 20px !important;
        }

        /* Fix dropdown toggle arrow position */
        .dropdown-toggle::after {
            margin-left: 5px !important;
        }

        [dir="rtl"] .dropdown-toggle::after {
            margin-right: 5px !important;
            margin-left: 0 !important;
        }

        /* Filter Dropdown Styles */
        .filter-dropdown {
            position: relative;
            display: inline-block;
        }

        .filter-dropdown .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 250px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            z-index: 9999;
            top: 100%;
            margin-top: 5px;
            padding: 0;
            max-height: 400px;
            overflow: hidden;
        }

        [dir="rtl"] .filter-dropdown .dropdown-content {
            right: 0;
        }

        [dir="ltr"] .filter-dropdown .dropdown-content {
            left: 0;
        }

        .filter-dropdown.active .dropdown-content {
            display: block;
        }

        .filter-header {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
        }

        .filter-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .close-dropdown {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s;
        }

        .close-dropdown:hover {
            color: #000;
        }

        .filter-body {
            padding: 15px;
            max-height: 300px;
            overflow-y: auto;
        }

        .checkbox-item {
            display: block;
            padding: 8px 0;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .checkbox-item:hover {
            background-color: #f8f9fa;
            margin: 0 -15px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .checkbox-item input[type="checkbox"] {
            margin-right: 10px;
            cursor: pointer;
        }

        [dir="rtl"] .checkbox-item input[type="checkbox"] {
            margin-right: 0;
            margin-left: 10px;
        }

        .checkbox-item span {
            font-size: 14px;
            color: #333;
        }

        /* Ensure dropdown stays on top */
        .filter-pills-container {
            position: relative;
            z-index: 100;
        }

        /* Scrollbar styling for filter body */
        .filter-body::-webkit-scrollbar {
            width: 6px;
        }

        .filter-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .filter-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .filter-body::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Filter count badge */
        .filter-count {
            background: #127664;
            color: white;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 600;
            margin: 0 5px;
        }

        /* Date range styling */
        .date-range-container {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .date-input-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .date-input-group label {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        .date-input {
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            width: 100%;
            cursor: pointer;
        }

        .date-input:focus {
            outline: none;
            border-color: #127664;
        }

        .btn-apply-dates {
            width: 100%;
            padding: 10px;
            background: #127664;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-apply-dates:hover {
            background: #0e5a4c;
        }

        /* Active filter pill styling */
        .filter-pill.has-selection {
            background: #e3f0e9;
            border-color: #127664;
            color: #127664;
        }

        /* Services Tabs Styles - Desktop and Mobile */
        .services-tabs .tab-btn {
            background: white;
            border: 2px solid #e0e0e0;
            color: #333;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s;
            cursor: pointer;
        }

        .services-tabs .tab-btn:hover {
            background: #f8f8f8;
            border-color: #127664;
            color: #127664;
        }

        .services-tabs .tab-btn.active {
            background: #127664;
            color: white;
            border-color: #127664;
        }

        /* Services Section Mobile Styles */
        @media (max-width: 768px) {
            .services-section {
                position: relative;
                overflow: hidden;
            }

            .services-section .row {
                display: flex !important;
                flex-wrap: wrap !important;
                min-height: 400px;
            }

            .services-section .col-12.col-sm-6 {
                flex: 0 0 50% !important;
                max-width: 50% !important;
                padding: 0 8px !important;
            }

            .services-section .col-12.col-sm-6.d-none {
                display: none !important;
                visibility: hidden !important;
                position: absolute !important;
                pointer-events: none !important;
            }

            .services-section .col-12.col-sm-6.d-block {
                display: block !important;
                visibility: visible !important;
                position: relative !important;
            }

            .services-section .service-card {
                margin-bottom: 15px;
                height: 100%;
            }

            .services-section .service-image {
                height: 180px !important;
            }

            .services-section .service-content {
                padding: 12px !important;
            }

            .services-section .service-title {
                font-size: 14px !important;
            }

            .services-section .service-location {
                font-size: 12px !important;
            }

            .services-section .service-tags {
                display: flex !important;
                gap: 3px !important;
                margin: 5px 0 8px !important;
                flex-wrap: wrap !important;
                overflow: visible !important;
                max-height: 28px !important;
                align-items: flex-start !important;
            }

            .services-section .service-tags::-webkit-scrollbar {
                display: none !important;
            }

            .services-section .tag {
                font-size: 7px !important;
                padding: 1px 4px !important;
                white-space: nowrap !important;
                flex-shrink: 0 !important;
                border-radius: 6px !important;
                line-height: 1.3 !important;
                display: inline-block !important;
                font-weight: 600 !important;
                background: #f0f0f0 !important;
                color: #555 !important;
                border: 0.5px solid transparent !important;
                letter-spacing: -0.2px !important;
            }

            /* Specific tag colors */
            .services-section .tag:contains("Ã™â€¦Ã˜Â³Ã˜Â¨Ã˜Â­"),
            .services-section .tag:contains("Pool") {
                background: #e3f4ff !important;
                color: #0066cc !important;
                border-color: #b3d9ff !important;
            }

            .services-section .tag:contains("Ã˜Â´Ã˜Â§Ã˜Â·Ã˜Â¦"),
            .services-section .tag:contains("Beach") {
                background: #fff3e0 !important;
                color: #ff6b00 !important;
                border-color: #ffd9b3 !important;
            }

            .services-section .tag:contains("Ã˜Â­Ã˜Â¯Ã™Å Ã™â€šÃ˜Â©"),
            .services-section .tag:contains("Garden") {
                background: #e8f5e9 !important;
                color: #2e7d32 !important;
                border-color: #b3e5b5 !important;
            }

            .services-section .service-host {
                display: none !important;
            }

            .services-section .btn-view-details {
                font-size: 10px !important;
                padding: 6px 8px !important;
                font-weight: 500 !important;
            }

            /* Browse More button in mobile */
            .btn-browse.btn-orange-primary {
                font-size: 12px !important;
                padding: 10px 16px !important;
            }

            .btn-browse.btn-orange-primary svg {
                width: 18px !important;
                height: 18px !important;
            }

            /* Navigation buttons for mobile */
            .services-nav-mobile {
                display: flex !important;
                justify-content: center !important;
                gap: 15px !important;
                margin-top: 20px !important;
            }

            .services-nav-mobile button {
                width: 40px !important;
                height: 40px !important;
                border-radius: 50% !important;
                border: 2px solid #127664 !important;
                background: white !important;
                color: #127664 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                cursor: pointer !important;
                transition: all 0.3s !important;
            }

            .services-nav-mobile button:hover {
                background: #127664 !important;
                color: white !important;
            }

            .services-nav-mobile button:disabled {
                opacity: 0.5 !important;
                cursor: not-allowed !important;
            }
        }

        /* Hide navigation on desktop */
        @media (min-width: 769px) {
            .services-nav-mobile {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .services-section .service-image {
                height: 150px !important;
            }

            .services-section .service-title {
                font-size: 13px !important;
                line-height: 1.2 !important;
            }

            .services-section .service-price-tag {
                font-size: 13px !important;
            }

            .services-section .col-12.col-sm-6 {
                width: 50% !important;
                padding: 0 5px !important;
            }

            /* Even smaller tags for very small screens */
            .services-section .service-tags {
                gap: 2px !important;
                margin: 4px 0 6px !important;
                max-width: 100% !important;
                height: 14px !important;
                align-items: center !important;
            }

            .services-section .tag {
                font-size: 6.5px !important;
                padding: 1px 3px !important;
                border-radius: 5px !important;
                font-weight: 600 !important;
                height: 12px !important;
                line-height: 10px !important;
                letter-spacing: -0.3px !important;
            }

            /* Smaller buttons for very small screens */
            .services-section .btn-view-details {
                font-size: 9px !important;
                padding: 5px 6px !important;
            }

            .btn-browse.btn-orange-primary {
                font-size: 11px !important;
                padding: 8px 12px !important;
                border-radius: 20px !important;
            }

            .btn-browse.btn-orange-primary svg {
                width: 16px !important;
                height: 16px !important;
            }

            /* Smaller navigation buttons */
            .services-nav-mobile button {
                width: 35px !important;
                height: 35px !important;
            }

            .services-nav-mobile button i {
                font-size: 12px !important;
            }
        }

        /* Services Tabs Mobile */
        @media (max-width: 768px) {
            .services-tabs {
                overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;
                padding: 10px 0;
                -webkit-overflow-scrolling: touch;
            }

            .services-tabs::-webkit-scrollbar {
                height: 3px;
            }

            .services-tabs::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .services-tabs::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 10px;
            }

            .services-tabs .tab-btn {
                font-size: 12px !important;
                padding: 8px 16px !important;
                margin: 0 4px !important;
                background: white !important;
                border: 2px solid #e0e0e0 !important;
                color: #333 !important;
                border-radius: 25px !important;
                transition: all 0.3s !important;
            }

            .services-tabs .tab-btn:hover {
                background: #f8f8f8 !important;
                border-color: #127664 !important;
            }

            .services-tabs .tab-btn.active {
                background: #127664 !important;
                color: white !important;
                border-color: #127664 !important;
            }
        }
        /* Unified Section Spacing */
        section {
            margin-bottom: 30px !important;
            padding: 20px 0 !important;
        }

        /* Section Titles Spacing */
        .section-title,
        h2.mb-4,
        h2.mb-5 {
            margin-bottom: 20px !important;
        }

        /* Mobile Section Spacing */
        @media (max-width: 768px) {
            section {
                margin-bottom: 20px !important;
                padding: 15px 0 !important;
            }

            .hero-booking-section {
                margin-bottom: 40px !important; /* Extra space for filter */
            }

            .destinations-section,
            .deals-section,
            .services-section,
            .newsletter-section {
                margin-top: 0 !important;
                margin-bottom: 20px !important;
            }

            /* Section titles in mobile */
            .section-title,
            h2.mb-4,
            h2.mb-5 {
                margin-bottom: 15px !important;
                font-size: 20px !important;
            }

            /* Container padding */
            .container,
            .container-fluid {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
        }

        @media (max-width: 480px) {
            section {
                margin-bottom: 15px !important;
                padding: 10px 0 !important;
            }

            .hero-booking-section {
                margin-bottom: 35px !important;
            }

            .destinations-section,
            .deals-section,
            .services-section,
            .newsletter-section {
                margin-bottom: 15px !important;
            }

            /* Smaller titles */
            .section-title,
            h2.mb-4,
            h2.mb-5 {
                margin-bottom: 12px !important;
                font-size: 18px !important;
            }

            /* Tighter container padding */
            .container,
            .container-fluid {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            /* Remove extra margins */
            .row {
                margin-left: -5px !important;
                margin-right: -5px !important;
            }

            .col, [class*="col-"] {
                padding-left: 5px !important;
                padding-right: 5px !important;
            }
        }

        .footer-section .footer-links .footer-column .footer-menu li a {
            color: #159265;
            text-decoration: none;
            font-size: 20px;
            font-weight: 400;
            transition: color 0.3s ease;
            white-space: nowrap !important;
        }
        .footer-section .footer-links .footer-column .footer-menu li{margin-bottom:1px !important;}
        .footer-section .footer-links .footer-column .contact-info .phone-number {

            margin-bottom: 0px !important;
        }
        .footer-section .footer-bottom {
            padding: 10px 0 !important;
            background: #f9f9f9;
        }
        .oman-clock-container{display:none !important;}
        .simple-oman-time{display:none !important;}
        .clock-wrapper{display:none !important;}

    </style>

    <!-- Mobile Enhancements -->
    <link rel="stylesheet" href="{{ asset('frontend/css/mobile-filter.css') }}">
    
    <!-- Google Ads -->
   <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6223635494524694"
     crossorigin="anonymous"></script>
</head>
<body>
    @include('frontend.inc._weekend_header')
    @include('frontend.inc._weekend_hero')
    @include('frontend.inc._weekend_destinations')
    @include('frontend.inc._weekend_deals')
    @if((!isset($newChalets) || $newChalets->count() == 0) &&
        (!isset($popularChalets) || $popularChalets->count() == 0) &&
        (!isset($categoriesWithChalets) || count($categoriesWithChalets ?? []) == 0))
        @include('frontend.inc._weekend_services_default')
    @else
        @include('frontend.inc._weekend_services')
    @endif
    @include('frontend.inc._weekend_newsletter')
    @include('frontend.inc._weekend_footer')
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        // Toggle Side Navigation
        function toggleSideNav() {
            const sideNav = document.querySelector('.side-nav');
            const overlay = document.querySelector('.overlay');

            if (sideNav && overlay) {
                sideNav.classList.toggle('active');
                overlay.classList.toggle('active');
            }
        }

        // Initialize Swipers
        document.addEventListener('DOMContentLoaded', function() {
            @php
                $wishlistChaletIds = auth('customer')->check()
                    ? auth('customer')->user()->wishlist()->pluck('chalets.id')->toArray()
                    : [];
            @endphp
            const wishlistChaletIds = @json($wishlistChaletIds);

            // Mark active wishlist buttons
            document.querySelectorAll('.btn-wishlist-circle').forEach(btn => {
                const chaletId = btn.dataset.chaletId;
                if (chaletId && wishlistChaletIds.includes(parseInt(chaletId))) {
                    btn.classList.add('active');
                }
            });

            // Hero Swiper
            const heroSwiper = new Swiper('.heroSwiper', {
                loop: true,
                speed: 800,
                effect: 'slide',
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });

            // Destinations Swiper - Ã˜Â¹Ã™â€žÃ™â€° Ã˜Â§Ã™â€žÃ™â€¦Ã™Ë†Ã˜Â¨Ã˜Â§Ã™Å Ã™â€ž Ã˜Â¥Ã˜Â²Ã˜Â§Ã˜Â­Ã˜Â© Ã˜Â­Ã˜ÂªÃ™â€° Ã˜ÂªÃ˜Â¸Ã™â€¡Ã˜Â± Ã˜Â§Ã™â€žÃ˜Â¨Ã˜Â·Ã˜Â§Ã™â€šÃ˜Â§Ã˜Âª Ã™Æ’Ã˜Â§Ã™â€¦Ã™â€žÃ˜Â©
            const destinationsSwiper = new Swiper('.destinationsSwiper', {
                slidesPerView: 'auto',
                spaceBetween: 30,
                freeMode: true,
                navigation: {
                    nextEl: '.destinations-next',
                    prevEl: '.destinations-prev',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 'auto',
                        spaceBetween: 14,
                    },
                    400: {
                        slidesPerView: 'auto',
                        spaceBetween: 16,
                    },
                    480: {
                        slidesPerView: 'auto',
                        spaceBetween: 18,
                    },
                    640: {
                        slidesPerView: 'auto',
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 'auto',
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 'auto',
                        spaceBetween: 25,
                    },
                    1400: {
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                    },
                },
            });

            // Deals Swiper Ã¢â‚¬â€ Ã™Å Ã™ÂÃ™ÂÃ˜Â¹Ã™â€˜Ã™â€ž Ã™ÂÃ™â€šÃ˜Â· Ã™â€¦Ã™â€  Ã˜Â§Ã™â€žÃ˜ÂªÃ˜Â§Ã˜Â¨Ã™â€žÃ˜Âª Ã™ÂÃ™â€¦Ã˜Â§ Ã™ÂÃ™Ë†Ã™â€šÃ˜â€º Ã˜Â¹Ã™â€žÃ™â€° Ã˜Â§Ã™â€žÃ™â€¦Ã™Ë†Ã˜Â¨Ã˜Â§Ã™Å Ã™â€ž Ã˜Â§Ã™â€žÃ˜Â¹Ã™â€šÃ˜Â§Ã˜Â±Ã˜Â§Ã˜Âª Ã˜ÂªÃ˜Â¸Ã™â€¡Ã˜Â± Ã™Æ’Ã™â€šÃ˜Â§Ã˜Â¦Ã™â€¦Ã˜Â© Ã˜Â«Ã˜Â§Ã˜Â¨Ã˜ÂªÃ˜Â© Ã˜Â¨Ã˜Â¯Ã™Ë†Ã™â€  Ã˜Â³Ã™â€žÃ˜Â§Ã™Å Ã˜Â¯Ã˜Â±
            let dealsSwiper = null;
            function initDealsSwiper() {
                if (document.querySelector('#dealsSwiper') && !dealsSwiper) {
                    dealsSwiper = new Swiper('.dealsSwiper', {
                        slidesPerView: 2,
                        spaceBetween: 16,
                        freeMode: false,
                        allowTouchMove: true,
                        navigation: {
                            nextEl: '.deals-next',
                            prevEl: '.deals-prev',
                        },
                        breakpoints: {
                            768: {
                                slidesPerView: 2,
                                spaceBetween: 16,
                                slidesPerGroup: 2,
                            },
                            992: {
                                slidesPerView: 3,
                                spaceBetween: 20,
                                slidesPerGroup: 3,
                            },
                            1200: {
                                slidesPerView: 4,
                                spaceBetween: 24,
                                slidesPerGroup: 4,
                            },
                            1400: {
                                slidesPerView: 5,
                                spaceBetween: 24,
                                slidesPerGroup: 5,
                            },
                        },
                    });
                }
            }
            function destroyDealsSwiper() {
                if (dealsSwiper) {
                    dealsSwiper.destroy(true, true);
                    dealsSwiper = null;
                }
            }
            if (window.innerWidth > 767) initDealsSwiper();
            window.addEventListener('resize', function() {
                if (window.innerWidth > 767) initDealsSwiper();
                else destroyDealsSwiper();
                setTimeout(function() {
                    if (destinationsSwiper) destinationsSwiper.update();
                    if (dealsSwiper) dealsSwiper.update();
                }, 100);
            });

            // Tabs Logic for Services Section
            const tabButtons = document.querySelectorAll(".services-tabs .tab-btn");
            const tabContents = document.querySelectorAll(".tab-content");

            tabButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    const targetTab = button.getAttribute("data-tab");

                    // Remove active state from all buttons
                    tabButtons.forEach((btn) => btn.classList.remove("active"));

                    // Hide all tab contents
                    tabContents.forEach((tab) => tab.classList.remove("active"));

                    // Activate clicked button
                    button.classList.add("active");

                    // Show the matching tab
                    const activeTab = document.getElementById(targetTab);
                    if (activeTab) {
                        activeTab.classList.add("active");
                    }
                });
            });


            // Wishlist functionality
            document.querySelectorAll('.wishlist-btn, .btn-wishlist-circle').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const chaletId = this.dataset.chaletId;

                    if (!chaletId) {
                        console.error('No chalet ID found');
                        return;
                    }

                    if (!@json(auth('customer')->check())) {
                        if (confirm('{{ app()->getLocale() == "ar" ? "يجب تسجيل الدخول أولاً لإضافة الشاليه إلى المفضلة. هل تريد الذهاب إلى صفحة تسجيل الدخول؟" : "Please login first to add this chalet to wishlist. Do you want to go to login page?" }}')) {
                            window.location.href = '{{ route("login") }}';
                        }
                        return;
                    }

                    const btn = this;
                    btn.disabled = true;

                    const wishlistUrl = @json(route('wishlist.toggle', ['chalet' => '__CHALET_ID__']));

                    fetch(wishlistUrl.replace('__CHALET_ID__', encodeURIComponent(chaletId)), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'added') {
                            btn.classList.add('active');
                            showToastNotification('success', data.message || '{{ app()->getLocale() == "ar" ? "تم إضافة الشاليه إلى المفضلة" : "Chalet added to wishlist" }}');
                        } else if (data.status === 'removed') {
                            btn.classList.remove('active');
                            showToastNotification('success', data.message || '{{ app()->getLocale() == "ar" ? "تم إزالة الشاليه من المفضلة" : "Chalet removed from wishlist" }}');
                        }
                        btn.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToastNotification('error', '{{ app()->getLocale() == "ar" ? "حدث خطأ. يرجى المحاولة مرة أخرى" : "An error occurred. Please try again" }}');
                        btn.disabled = false;
                    });
                });
            });

            // Ã˜Â¬Ã˜Â¹Ã™â€ž Ã˜Â¨Ã˜Â·Ã˜Â§Ã™â€šÃ˜Â© Ã˜Â§Ã™â€žÃ˜Â¹Ã™â€šÃ˜Â§Ã˜Â± Ã™â€šÃ˜Â§Ã˜Â¨Ã™â€žÃ˜Â© Ã™â€žÃ™â€žÃ™â€ Ã™â€šÃ˜Â± Ã˜Â¨Ã˜Â§Ã™â€žÃ™Æ’Ã˜Â§Ã™â€¦Ã™â€ž (Ã™Å Ã˜Â³Ã˜ÂªÃ˜Â«Ã™â€ Ã™Å  Ã˜Â£Ã˜Â²Ã˜Â±Ã˜Â§Ã˜Â± Ã˜Â§Ã™â€žÃ˜ÂªÃ™Ë†Ã˜Â§Ã˜ÂµÃ™â€ž Ã™Ë†Ã˜Â§Ã™â€žÃ™â€¦Ã™ÂÃ˜Â¶Ã™â€žÃ˜Â©)
            document.querySelectorAll('.deal-card-clickable').forEach(function(card) {
                card.style.cursor = 'pointer';
                card.addEventListener('click', function(e) {
                    if (e.target.closest('.deal-contact') || e.target.closest('.btn-wishlist-circle')) {
                        return;
                    }
                    const href = card.getAttribute('data-href');
                    if (href) {
                        window.location.href = href;
                    }
                });
            });

            // Toast notification function
            function showToastNotification(type, message) {
                // Remove existing toast if any
                const existingToast = document.querySelector('.toast-notification');
                if (existingToast) {
                    existingToast.remove();
                }

                // Create new toast
                const toast = document.createElement('div');
                toast.className = `toast-notification ${type}`;
                toast.style.cssText = `
                    position: fixed;
                    top: 100px;
                    right: 20px;
                    z-index: 9999;
                    min-width: 300px;
                    background: white;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
                    padding: 15px 20px;
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    animation: slideInRight 0.3s ease;
                    border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'};
                `;

                toast.innerHTML = `
                    <div style="font-size: 24px; color: ${type === 'success' ? '#28a745' : '#dc3545'};">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    </div>
                    <div>${message}</div>
                `;

                document.body.appendChild(toast);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    toast.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);
            }

            // Filter Dropdown functionality
            const filterButtons = document.querySelectorAll('.filter-pill[data-filter]');
            const filterDropdowns = document.querySelectorAll('.filter-dropdown');
            const searchBtn = document.querySelector('.search-btn');

            // Function to update filter count
            function updateFilterCount(dropdown) {
                const filterType = dropdown.querySelector('.filter-pill').getAttribute('data-filter');
                const countBadge = dropdown.querySelector('.filter-count');
                const filterPill = dropdown.querySelector('.filter-pill');

                if (filterType === 'booking') {
                    // Handle date range
                    const fromDate = dropdown.querySelector('#booking_from').value;
                    const toDate = dropdown.querySelector('#booking_to').value;

                    if (fromDate && toDate) {
                        countBadge.textContent = 'Ã¢Å“â€œ';
                        countBadge.style.display = 'inline-block';
                        filterPill.classList.add('has-selection');
                    } else {
                        countBadge.style.display = 'none';
                        filterPill.classList.remove('has-selection');
                    }
                } else {
                    // Handle checkboxes
                    const checkedBoxes = dropdown.querySelectorAll('input[type="checkbox"]:checked');
                    const count = checkedBoxes.length;

                    if (count > 0) {
                        countBadge.textContent = count;
                        countBadge.style.display = 'inline-block';
                        filterPill.classList.add('has-selection');
                    } else {
                        countBadge.style.display = 'none';
                        filterPill.classList.remove('has-selection');
                    }
                }
            }

            // Open dropdown when clicking filter button
            filterButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdown = this.closest('.filter-dropdown');

                    // Close all other dropdowns
                    filterDropdowns.forEach(dd => {
                        if (dd !== dropdown) {
                            dd.classList.remove('active');
                        }
                    });

                    // Toggle current dropdown
                    dropdown.classList.toggle('active');
                });
            });

            // Update count when checkbox changes
            /*document.querySelectorAll('.filter-dropdown input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const dropdown = this.closest('.filter-dropdown');
                    updateFilterCount(dropdown);
                });
            });*/

            document.addEventListener('change', function (e) {
                if (e.target.matches('.filter-dropdown input[type="checkbox"]')) {
                    const dropdown = e.target.closest('.filter-dropdown');
                    updateFilterCount(dropdown);
                }
            });

            // Handle date apply button
            document.querySelectorAll('.btn-apply-dates').forEach(btn => {
                btn.addEventListener('click', function() {

                    const dropdown = this.closest('.filter-dropdown');
                    updateFilterCount(dropdown);
                    dropdown.classList.remove('active');
                });
            });

            // Close dropdown when clicking close button
            document.querySelectorAll('.close-dropdown').forEach(closeBtn => {
                closeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdown = this.closest('.filter-dropdown');
                    dropdown.classList.remove('active');
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.filter-dropdown')) {
                    filterDropdowns.forEach(dropdown => {
                        dropdown.classList.remove('active');
                    });
                }
            });

            // Prevent dropdown from closing when clicking inside
            document.querySelectorAll('.dropdown-content').forEach(content => {
                content.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            // Cascading Filters - Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â­Ã˜Â§Ã™ÂÃ˜Â¸Ã˜Â© Ã¢â€ â€™ Ã˜Â§Ã™â€žÃ™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â© Ã¢â€ â€™ Ã˜Â§Ã™â€žÃ™â€¦Ã™â€ Ã˜Â·Ã™â€šÃ˜Â©
            const govCheckboxes = document.querySelectorAll('input[name="gov[]"]');
            const stateFilter = document.getElementById('state-filter');
            const stateButton = stateFilter?.querySelector('.filter-pill');
            const stateOptions = document.getElementById('state-options');

            const areaFilter = document.getElementById('area-filter');
            const areaButton = areaFilter?.querySelector('.filter-pill');
            const areaOptions = document.getElementById('area-options');

            // Ã˜Â¹Ã™â€ Ã˜Â¯ Ã˜Â§Ã˜Â®Ã˜ÂªÃ™Å Ã˜Â§Ã˜Â± Ã™â€¦Ã˜Â­Ã˜Â§Ã™ÂÃ˜Â¸Ã˜Â©
            govCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const selectedGovs = Array.from(document.querySelectorAll('input[name="gov[]"]:checked'))
                        .map(cb => cb.value);

                    if (selectedGovs.length > 0) {
                        // Ã˜ÂªÃ™ÂÃ˜Â¹Ã™Å Ã™â€ž Ã™ÂÃ™â€žÃ˜ÂªÃ˜Â± Ã˜Â§Ã™â€žÃ™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â©
                        stateButton.disabled = false;
                        stateButton.style.opacity = '1';
                        stateButton.style.cursor = 'pointer';
                        const govId = selectedGovs[selectedGovs.length - 1];
                        // Ã˜Â¬Ã™â€žÃ˜Â¨ Ã˜Â§Ã™â€žÃ™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â§Ã˜Âª
                        fetch(`/api/states/${govId}`)
                            .then(response => response.json())
                            .then(states => {
                                stateOptions.innerHTML = '';
                                if (states.length > 0) {
                                    states.forEach(state => {
                                        const label = document.createElement('label');
                                        label.className = 'checkbox-item';
                                        label.innerHTML = `
                                            <input type="checkbox" name="state[]" value="${state.id}" class="state-checkbox">
                                            <span>${'{{ app()->getLocale() }}' == 'ar' ? state.name_ar : state.name_en}</span>
                                        `;
                                        stateOptions.appendChild(label);
                                    });

                                    // Ã˜Â¥Ã˜Â¶Ã˜Â§Ã™ÂÃ˜Â© event listeners Ã™â€žÃ™â€žÃ™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â¬Ã˜Â¯Ã™Å Ã˜Â¯Ã˜Â©
                                    attachStateListeners();
                                } else {
                                    stateOptions.innerHTML = '<p class="text-muted text-center">{{ app()->getLocale() == "ar" ? "Ã™â€žÃ˜Â§ Ã˜ÂªÃ™Ë†Ã˜Â¬Ã˜Â¯ Ã™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â§Ã˜Âª" : "No states available" }}</p>';
                                }
                            });
                    } else {
                        // Ã˜ÂªÃ˜Â¹Ã˜Â·Ã™Å Ã™â€ž Ã™ÂÃ™â€žÃ˜ÂªÃ˜Â± Ã˜Â§Ã™â€žÃ™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â© Ã™Ë†Ã˜Â§Ã™â€žÃ™â€¦Ã™â€ Ã˜Â·Ã™â€šÃ˜Â©
                        stateButton.disabled = true;
                        stateButton.style.opacity = '0.5';
                        stateButton.style.cursor = 'not-allowed';
                        stateOptions.innerHTML = '<p class="text-muted text-center">{{ app()->getLocale() == "ar" ? "Ã˜Â§Ã˜Â®Ã˜ÂªÃ˜Â± Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â­Ã˜Â§Ã™ÂÃ˜Â¸Ã˜Â© Ã˜Â£Ã™Ë†Ã™â€žÃ˜Â§Ã™â€¹" : "Select Governorate first" }}</p>';

                        areaButton.disabled = true;
                        areaButton.style.opacity = '0.5';
                        areaButton.style.cursor = 'not-allowed';
                        areaOptions.innerHTML = '<p class="text-muted text-center">{{ app()->getLocale() == "ar" ? "Ã˜Â§Ã˜Â®Ã˜ÂªÃ˜Â± Ã˜Â§Ã™â€žÃ™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â© Ã˜Â£Ã™Ë†Ã™â€žÃ˜Â§Ã™â€¹" : "Select State first" }}</p>';
                    }
                });
            });

            // Ã˜Â¯Ã˜Â§Ã™â€žÃ˜Â© Ã™â€žÃ˜Â¥Ã˜Â¶Ã˜Â§Ã™ÂÃ˜Â© listeners Ã™â€žÃ™â€žÃ™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â§Ã˜Âª
            function attachStateListeners() {
                const stateCheckboxes = document.querySelectorAll('.state-checkbox');
                stateCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const selectedStates = Array.from(document.querySelectorAll('.state-checkbox:checked'))
                            .map(cb => cb.value);

                        if (selectedStates.length > 0) {
                            // Ã˜ÂªÃ™ÂÃ˜Â¹Ã™Å Ã™â€ž Ã™ÂÃ™â€žÃ˜ÂªÃ˜Â± Ã˜Â§Ã™â€žÃ™â€¦Ã™â€ Ã˜Â·Ã™â€šÃ˜Â©
                            areaButton.disabled = false;
                            areaButton.style.opacity = '1';
                            areaButton.style.cursor = 'pointer';

                            // Ã˜Â¬Ã™â€žÃ˜Â¨ Ã˜Â§Ã™â€žÃ™â€¦Ã™â€ Ã˜Â§Ã˜Â·Ã™â€š
                            fetch(`/api/areas/${selectedStates[0]}`)
                                .then(response => response.json())
                                .then(areas => {
                                    areaOptions.innerHTML = '';
                                    if (areas.length > 0) {
                                        areas.forEach(area => {
                                            const label = document.createElement('label');
                                            label.className = 'checkbox-item';
                                            label.innerHTML = `
                                                <input type="checkbox" name="area[]" value="${area.id}">
                                                <span>${'{{ app()->getLocale() }}' == 'ar' ? area.name_ar : area.name_en}</span>
                                            `;
                                            areaOptions.appendChild(label);
                                        });
                                    } else {
                                        areaOptions.innerHTML = '<p class="text-muted text-center">{{ app()->getLocale() == "ar" ? "Ã™â€žÃ˜Â§ Ã˜ÂªÃ™Ë†Ã˜Â¬Ã˜Â¯ Ã™â€¦Ã™â€ Ã˜Â§Ã˜Â·Ã™â€š" : "No areas available" }}</p>';
                                    }
                                });
                        } else {
                            // Ã˜ÂªÃ˜Â¹Ã˜Â·Ã™Å Ã™â€ž Ã™ÂÃ™â€žÃ˜ÂªÃ˜Â± Ã˜Â§Ã™â€žÃ™â€¦Ã™â€ Ã˜Â·Ã™â€šÃ˜Â©
                            areaButton.disabled = true;
                            areaButton.style.opacity = '0.5';
                            areaButton.style.cursor = 'not-allowed';
                            areaOptions.innerHTML = '<p class="text-muted text-center">{{ app()->getLocale() == "ar" ? "Ã˜Â§Ã˜Â®Ã˜ÂªÃ˜Â± Ã˜Â§Ã™â€žÃ™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â© Ã˜Â£Ã™Ë†Ã™â€žÃ˜Â§Ã™â€¹" : "Select State first" }}</p>';
                        }
                    });
                });
            }

            // Mobile filter functionality
            const mobileFilterButtons = document.querySelectorAll('.filter-pill-mobile');
            const mobileSearchBtn = document.querySelector('.search-btn-mobile');

            // Create mobile filter modal
            function createMobileFilterModal(filterType, content, filterDataType) {
                // Remove any existing modal
                const existingModal = document.querySelector('.mobile-filter-modal');
                if (existingModal) {
                    existingModal.remove();
                }

                // Create modal HTML
                const modal = document.createElement('div');
                modal.className = 'mobile-filter-modal';
                modal.setAttribute('data-filter-type', filterDataType);
                modal.innerHTML = `
                    <div class="mobile-filter-overlay"></div>
                    <div class="mobile-filter-content">
                        <div class="mobile-filter-header">
                            <h5>${filterType}</h5>
                            <span class="mobile-filter-count">0 selected</span>
                            <button class="close-mobile-filter">&times;</button>
                        </div>
                        <div class="mobile-filter-body">
                            ${content}
                        </div>
                        <div class="mobile-filter-footer">
                            <button class="btn-clear-filter">Clear</button>
                            <button class="btn-apply-filter">Apply <span class="apply-count"></span></button>
                        </div>
                    </div>
                `;

                document.body.appendChild(modal);

                // Function to update count
                function updateModalCount() {
                    const checkedCount = modal.querySelectorAll('input[type="checkbox"]:checked').length;
                    const countElement = modal.querySelector('.mobile-filter-count');
                    const applyCountElement = modal.querySelector('.apply-count');
                    const isArabic = document.documentElement.lang === 'ar' || document.documentElement.dir === 'rtl';

                    if (checkedCount > 0) {
                        countElement.textContent = isArabic ? `${checkedCount} Ã™â€¦Ã˜Â­Ã˜Â¯Ã˜Â¯` : `${checkedCount} selected`;
                        countElement.style.color = '#127664';
                        countElement.style.fontWeight = '600';
                        applyCountElement.textContent = `(${checkedCount})`;
                        modal.querySelector('.btn-apply-filter').classList.add('active');
                    } else {
                        countElement.textContent = isArabic ? 'Ã™â€žÃ˜Â§ Ã™Å Ã™Ë†Ã˜Â¬Ã˜Â¯ Ã˜Â§Ã˜Â®Ã˜ÂªÃ™Å Ã˜Â§Ã˜Â±' : '0 selected';
                        countElement.style.color = '#999';
                        countElement.style.fontWeight = 'normal';
                        applyCountElement.textContent = '';
                        modal.querySelector('.btn-apply-filter').classList.remove('active');
                    }
                }

                // Add close handlers
                modal.querySelector('.close-mobile-filter').addEventListener('click', () => {
                    modal.remove();
                });

                modal.querySelector('.mobile-filter-overlay').addEventListener('click', () => {
                    modal.remove();
                });

                // Show modal with animation
                setTimeout(() => {
                    modal.classList.add('active');
                }, 10);

                // Clear button handler
                modal.querySelector('.btn-clear-filter').addEventListener('click', function() {
                    modal.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                        cb.checked = false;
                        // Sync with desktop
                        const desktopCb = document.querySelector(`.filter-dropdown input[type="checkbox"][value="${cb.value}"]`);
                        if (desktopCb) {
                            desktopCb.checked = false;
                            desktopCb.dispatchEvent(new Event('change'));
                        }
                    });
                    updateModalCount();
                });

                // Apply button handler
                modal.querySelector('.btn-apply-filter').addEventListener('click', function() {
                    console.log('Filters applied');
                    modal.remove();
                });

                // Re-attach event listeners to cloned elements
                // Handle checkboxes
                modal.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    // Make sure checkbox is clickable
                    checkbox.style.pointerEvents = 'auto';

                    // Add change event
                    checkbox.addEventListener('change', function(e) {
                        e.stopPropagation();
                        console.log('Checkbox changed in mobile modal:', this.value, this.checked);

                        // Update count
                        updateModalCount();

                        // Add visual feedback
                        const label = this.closest('label') || this.closest('.checkbox-item');
                        if (label) {
                            if (this.checked) {
                                label.style.backgroundColor = '#e3f0e9';
                                label.style.borderLeft = '3px solid #127664';
                                label.style.paddingLeft = '17px';
                            } else {
                                label.style.backgroundColor = '';
                                label.style.borderLeft = '';
                                label.style.paddingLeft = '';
                            }
                        }

                        // Find the corresponding checkbox in the desktop filter and sync it
                        const desktopCheckbox = document.querySelector(`.filter-dropdown input[type="checkbox"][value="${this.value}"]`);
                        if (desktopCheckbox) {
                            desktopCheckbox.checked = this.checked;
                            // Trigger change event on desktop checkbox
                            desktopCheckbox.dispatchEvent(new Event('change'));
                        }
                    });

                    // Make label clickable too
                    const label = checkbox.closest('label');
                    if (label) {
                        label.style.cursor = 'pointer';
                        label.addEventListener('click', function(e) {
                            if (e.target.tagName !== 'INPUT') {
                                e.preventDefault();
                                checkbox.checked = !checkbox.checked;
                                checkbox.dispatchEvent(new Event('change'));
                            }
                        });
                    }
                });

                // Handle date inputs if present
                modal.querySelectorAll('input[type="date"]').forEach(dateInput => {
                    dateInput.style.pointerEvents = 'auto';
                    dateInput.addEventListener('change', function(e) {
                        e.stopPropagation();
                        console.log('Date changed in mobile modal:', this.value);

                        // Find the corresponding date input in desktop and sync
                        const desktopDateInput = document.querySelector(`.filter-dropdown input[type="date"][id="${this.id}"]`);
                        if (desktopDateInput) {
                            desktopDateInput.value = this.value;
                            desktopDateInput.dispatchEvent(new Event('change'));
                        }
                    });
                });

                // Handle apply buttons if present
                modal.querySelectorAll('.btn-apply-dates, .btn-apply').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('Apply button clicked in mobile modal');
                        modal.remove();
                    });
                });

                // Initial count update
                updateModalCount();

                // Check already selected items and apply visual feedback
                modal.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                    const label = checkbox.closest('label') || checkbox.closest('.checkbox-item');
                    if (label) {
                        label.style.backgroundColor = '#e3f0e9';
                        label.style.borderLeft = '3px solid #127664';
                        label.style.paddingLeft = '17px';
                    }
                });
            }

            // Add click handlers for mobile filter buttons
            mobileFilterButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const filterText = this.querySelector('span').textContent.trim().toLowerCase();
                    console.log('Mobile filter clicked:', filterText);

                    // Find corresponding desktop filter dropdown content
                    let filterDropdown = null;
                    let filterTitle = '';

                    const isArabic = document.documentElement.lang === 'ar' || document.documentElement.dir === 'rtl';

                    if (filterText.includes('price') || filterText.includes('Ã˜Â³Ã˜Â¹Ã˜Â±')) {
                        filterDropdown = document.querySelector('.filter-dropdown .filter-pill[data-filter="price"]')?.closest('.filter-dropdown');
                        filterTitle = isArabic ? 'Ã˜Â§Ã™â€žÃ˜Â³Ã˜Â¹Ã˜Â±' : 'Price';
                    } else if (filterText.includes('property') || filterText.includes('Ã˜Â¹Ã™â€šÃ˜Â§Ã˜Â±')) {
                        filterDropdown = document.querySelector('.filter-dropdown .filter-pill[data-filter="property"]')?.closest('.filter-dropdown');
                        filterTitle = isArabic ? 'Ã™â€ Ã™Ë†Ã˜Â¹ Ã˜Â§Ã™â€žÃ˜Â¹Ã™â€šÃ˜Â§Ã˜Â±' : 'Property Type';
                    } else if (filterText.includes('booking') || filterText.includes('Ã˜Â­Ã˜Â¬Ã˜Â²')) {
                        filterDropdown = document.querySelector('.filter-dropdown .filter-pill[data-filter="booking"]')?.closest('.filter-dropdown');
                        filterTitle = isArabic ? 'Ã™Ë†Ã™â€šÃ˜Âª Ã˜Â§Ã™â€žÃ˜Â­Ã˜Â¬Ã˜Â²' : 'Booking Time';
                    } else if (filterText.includes('area') || filterText.includes('Ã™â€¦Ã™â€ Ã˜Â·Ã™â€šÃ˜Â©')) {
                        filterDropdown = document.querySelector('.filter-dropdown .filter-pill[data-filter="state"]')?.closest('.filter-dropdown');
                        filterTitle = isArabic ? 'Ã˜Â§Ã™â€žÃ™â€¦Ã™â€ Ã˜Â·Ã™â€šÃ˜Â©' : 'Area';
                    } /*else if (filterText.includes('state') || filterText.includes('Ã™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â©')) {
                        alert('f');
                        filterDropdown = document.querySelector('.filter-dropdown .filter-pill[data-filter="state"]')?.closest('.filter-dropdown');
                        filterTitle = isArabic ? 'Ã˜Â§Ã™â€žÃ™Ë†Ã™â€žÃ˜Â§Ã™Å Ã˜Â©' : 'State';
                    } */else if (filterText.includes('gov') || filterText.includes('Ã™â€¦Ã˜Â­Ã˜Â§Ã™ÂÃ˜Â¸Ã˜Â©')) {
                        filterDropdown = document.querySelector('.filter-dropdown .filter-pill[data-filter="gov"]')?.closest('.filter-dropdown');
                        filterTitle = isArabic ? 'Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â­Ã˜Â§Ã™ÂÃ˜Â¸Ã˜Â©' : 'Governorate';
                    }

                    if (filterDropdown) {
                        const dropdownContent = filterDropdown.querySelector('.dropdown-content .filter-body');
                        if (dropdownContent) {
                            // Clone the content and show in mobile modal
                            const content = dropdownContent.innerHTML;
                            const filterDataType = filterDropdown.querySelector('.filter-pill').getAttribute('data-filter');
                            createMobileFilterModal(filterTitle, content, filterDataType);
                        }
                    }
                });
            });

            // Mobile search button
            if (mobileSearchBtn) {
                mobileSearchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Mobile search clicked');
                    // Trigger the same search as desktop
                    if (searchBtn) {
                        searchBtn.click();
                    }
                });
            }

            // Search button functionality
            if (searchBtn) {
                searchBtn.addEventListener('click', function() {
                    const filters = {};

                    // Collect all filter data
                    filterDropdowns.forEach(dropdown => {
                        const filterType = dropdown.querySelector('.filter-pill').getAttribute('data-filter');

                        if (filterType === 'booking') {
                            const fromDate = dropdown.querySelector('#booking_from').value;
                            const toDate = dropdown.querySelector('#booking_to').value;
                            if (fromDate && toDate) {
                                filters.booking_from = fromDate;
                                filters.booking_to = toDate;
                            }
                        } else {
                            const checkedBoxes = dropdown.querySelectorAll('input[type="checkbox"]:checked');
                            if (checkedBoxes.length > 0) {
                                filters[filterType] = Array.from(checkedBoxes).map(cb => cb.value);
                            }
                        }
                    });

                    console.log('Search with filters:', filters);

                    // Build query string from filters
                    const queryParams = new URLSearchParams();

                    Object.keys(filters).forEach(key => {
                        if (Array.isArray(filters[key])) {
                            filters[key].forEach(value => {
                                queryParams.append(key + '[]', value);
                            });
                        } else {
                            queryParams.append(key, filters[key]);
                        }
                    });

                    // Redirect to premium chalets page with query parameters
                    const searchUrl = '{{ route("showPremiumChalets") }}' + '?' + queryParams.toString();
                    window.location.href = searchUrl;
                });
            }
        });

        // Close side nav when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sideNav = document.querySelector('.side-nav');
                const overlay = document.querySelector('.overlay');

                if (sideNav && overlay && sideNav.classList.contains('active')) {
                    sideNav.classList.remove('active');
                    overlay.classList.remove('active');
                }
            }
        });

    </script>

    <!-- Mobile Filter JavaScript -->
    <script src="{{ asset('frontend/js/mobile-filter.js') }}"></script>

</body>
</html>

