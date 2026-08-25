@extends('frontend.layouts.weekend_master')

@section('page_title')
    {{ app()->getLocale() == 'ar' ? 'الشاليهات الفاخرة' : 'Premium Chalets' }}
@endsection

@section('css')
    <!-- Premium Chalets Page CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/chalets-page.css') }}">
    <!-- Mobile Filter CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/mobile-filter.css') }}">
    <style>
        /* Enhanced Premium Chalets Styles */
        .page-hero {
            background: linear-gradient(135deg, #127664 0%, #159265 100%);
            padding: 100px 0 60px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .page-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,133.3C960,128,1056,96,1152,96C1248,96,1344,128,1392,144L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }
        
        .page-hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease;
        }
        
        .page-hero p {
            font-size: 1.25rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
            animation: fadeInUp 1s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .chalets-page {
            padding: 40px 0;
            background: #f8f9fa;
            min-height: 80vh;
        }
        
        .breadcrumb-modern {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .breadcrumb-modern .breadcrumb {
            margin: 0;
            padding: 0;
        }
        
        .filter-section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .filter-section h3 {
            color: #333;
            font-size: 1.4rem;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .filter-section h3 i {
            color: #127664;
            margin-right: 10px;
        }
        
        /* Enhanced Chalet Card */
        .chalet-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .chalet-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .chalet-card-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }
        
        .chalet-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .chalet-card:hover .chalet-card-image img {
            transform: scale(1.1);
        }
        
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.7));
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .chalet-card:hover .image-overlay {
            opacity: 1;
        }
        
        .image-overlay h5 {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .price-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, #127664 0%, #159265 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 3px 10px rgba(18, 118, 100, 0.4);
        }
        
        [dir="rtl"] .price-badge {
            left: auto;
            right: 15px;
        }
        
        .wishlist-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        [dir="rtl"] .wishlist-btn {
            right: auto;
            left: 15px;
        }
        
        .wishlist-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .wishlist-btn i {
            font-size: 18px;
            color: #ff4757;
            transition: all 0.3s ease;
        }
        
        .wishlist-btn.active i,
        .wishlist-btn.loading i {
            animation: heartBeat 0.8s;
        }
        
        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.3); }
            50% { transform: scale(1); }
            75% { transform: scale(1.3); }
        }
        
        .wishlist-btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }
        
        .chalet-card-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .chalet-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .chalet-title a {
            color: #333;
            transition: color 0.3s;
        }
        
        .chalet-title a:hover {
            color: #127664;
        }
        
        .chalet-location {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        
        .chalet-location i {
            color: #127664;
            margin-right: 5px;
        }
        
        [dir="rtl"] .chalet-location i {
            margin-right: 0;
            margin-left: 5px;
        }
        
        .btn-view-details {
            background: linear-gradient(135deg, #127664 0%, #159265 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: auto;
            text-align: center;
            justify-content: center;
        }
        
        .btn-view-details:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(18, 118, 100, 0.4);
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .empty-state i {
            font-size: 5rem;
            color: #e0e0e0;
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: #6c757d;
        }
        
        /* Pagination Styles */
        .pagination-wrapper {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }
        
        .pagination {
            background: white;
            padding: 10px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .pagination .page-link {
            color: #127664;
            border: none;
            padding: 10px 15px;
            margin: 0 3px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .pagination .page-link:hover {
            background: #f0faf8;
            color: #127664;
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #127664 0%, #159265 100%);
            color: white;
        }
        
        /* Responsive - Enhanced Mobile Styles */
        @media (max-width: 768px) {
            /* Hero Section Mobile */
            .page-hero {
                padding: 60px 0 30px;
            }
            
            .page-hero h1 {
                font-size: 1.5rem;
                margin-bottom: 15px;
            }
            
            .page-hero p {
                font-size: 0.9rem;
                padding: 0 15px;
            }
            
            /* Main Content Mobile */
            .chalets-page {
                padding: 20px 0;
            }
            
            /* Breadcrumb Mobile */
            .breadcrumb-modern {
                padding: 12px 15px;
                margin-bottom: 20px;
            }
            
            .breadcrumb-modern .breadcrumb {
                font-size: 0.85rem;
            }
            
            /* Filter Section Mobile */
            .filter-section {
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 8px;
            }
            
            .filter-section h3 {
                font-size: 1.1rem;
                margin-bottom: 15px;
            }
            
            .filter-section h3 i {
                font-size: 0.9rem;
                margin-right: 8px;
            }
            
            /* Grid adjustment for 2 cards per row with proper spacing */
            .row.g-4 {
                --bs-gutter-x: 0.75rem;
                --bs-gutter-y: 0.75rem;
                margin: 0 -0.375rem;
            }
            
            .col-6 {
                padding-left: 0.375rem;
                padding-right: 0.375rem;
            }
            
            /* Chalet Cards Mobile - Compact Design for 2 columns */
            .chalet-card {
                border-radius: 10px;
                margin-bottom: 0;
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                height: 100%;
            }
            
            .chalet-card-image {
                height: 140px;
            }
            
            .price-badge {
                font-size: 0.75rem;
                padding: 4px 8px;
                top: 8px;
                left: 8px;
                border-radius: 15px;
            }
            
            [dir="rtl"] .price-badge {
                left: auto;
                right: 8px;
            }
            
            .wishlist-btn {
                width: 30px;
                height: 30px;
                top: 8px;
                right: 8px;
            }
            
            [dir="rtl"] .wishlist-btn {
                right: auto;
                left: 8px;
            }
            
            .wishlist-btn i {
                font-size: 14px;
            }
            
            .chalet-card-body {
                padding: 10px;
            }
            
            .chalet-title {
                font-size: 0.85rem;
                margin-bottom: 6px;
                line-height: 1.2;
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
            }
            
            .chalet-location {
                font-size: 0.75rem;
                margin-bottom: 10px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            
            .chalet-location i {
                font-size: 0.7rem;
            }
            
            .btn-view-details {
                padding: 8px 12px;
                font-size: 0.8rem;
                border-radius: 6px;
            }
            
            .btn-view-details i {
                display: none; /* Hide arrow icon on mobile */
            }
            
            /* Empty State Mobile */
            .empty-state {
                padding: 50px 15px;
            }
            
            .empty-state i {
                font-size: 3.5rem;
            }
            
            .empty-state h3 {
                font-size: 1.2rem;
            }
            
            .empty-state p {
                font-size: 0.9rem;
            }
            
            /* Pagination Mobile */
            .pagination-wrapper {
                margin-top: 25px;
            }
            
            .pagination {
                padding: 8px;
                border-radius: 8px;
            }
            
            .pagination .page-link {
                padding: 8px 12px;
                font-size: 0.85rem;
                margin: 0 2px;
                border-radius: 6px;
            }
            
            /* Toast Mobile */
            .toast-notification {
                bottom: 15px;
                right: 15px;
                left: 15px;
                padding: 12px 15px;
                font-size: 0.85rem;
                border-radius: 6px;
            }
            
            [dir="rtl"] .toast-notification {
                right: 15px;
                left: 15px;
            }
        }
        
        /* Small Mobile Devices */
        @media (max-width: 480px) {
            .page-hero h1 {
                font-size: 1.3rem;
            }
            
            .page-hero p {
                font-size: 0.85rem;
                padding: 0 10px;
            }
            
            .chalets-page {
                padding: 15px 0;
            }
            
            .filter-section {
                padding: 12px;
            }
            
            .filter-section h3 {
                font-size: 1rem;
            }
            
            /* Single Column Layout */
            .col-12.col-md-6.col-lg-4.col-xl-3 {
                padding: 0 10px;
            }
            
            .chalet-card-image {
                height: 160px;
            }
            
            .chalet-card-body {
                padding: 12px;
            }
            
            .chalet-title {
                font-size: 0.95rem;
            }
            
            .chalet-location {
                font-size: 0.8rem;
            }
            
            .btn-view-details {
                padding: 9px 18px;
                font-size: 0.85rem;
            }
            
            .pagination .page-link {
                padding: 6px 10px;
                font-size: 0.8rem;
            }
        }
        
        /* Filter Mobile Styles - Modern Compact Design */
        @media (max-width: 768px) {
            /* Reduce Filter Section Size */
            .filter-section {
                padding: 8px !important;
                margin-bottom: 12px !important;
                background: white;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }
            
            .filter-section h3 {
                display: none; /* Hide filter title on mobile */
            }
            
            .filter-section .bg-light {
                padding: 0 !important;
                background: transparent !important;
            }
            
            .filter-section .border-danger-subtle {
                padding: 8px !important;
                border: none !important;
                background: transparent;
            }
            
            .filter-section .row {
                margin: 0 -2px;
            }
            
            .filter-section .col-md-6,
            .filter-section .col-lg-3 {
                padding: 2px;
                margin-bottom: 4px;
            }
            
            /* Make filters 2 columns on mobile */
            .filter-section .col-md-6.col-lg-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
            
            .filter-section .form-select {
                font-size: 0.75rem !important;
                padding: 8px 10px;
                height: 36px;
                border: 1px solid #e0e0e0;
                background: #f8f9fa;
            }
            
            /* Search button full width on last row */
            .filter-section form > div.ms-2 {
                margin: 6px 0 0 0 !important;
                width: 100%;
                text-align: center;
            }
            
            .filter-section .btn-circle {
                width: 100%;
                height: 38px;
                padding: 0 20px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 20px !important;
                background: linear-gradient(135deg, #127664 0%, #159265 100%);
                color: white;
                border: none;
                font-weight: 600;
            }
            
            .filter-section .btn-circle i {
                font-size: 14px;
                margin-right: 6px;
            }
            
            .filter-section .btn-circle::after {
                content: " " attr(data-text);
                font-size: 0.85rem;
                font-weight: 600;
            }
            
            /* Select2 Mobile Styles - Fixed Width Issues */
            .filter-section .select2-container {
                width: 100% !important;
            }
            
            .filter-section .select2-container--default .select2-selection--single {
                height: auto !important;
                min-height: 36px;
                line-height: 1.4;
                font-size: 0.7rem !important;
                border-radius: 20px;
                background: white;
                border: 1px solid #dee2e6;
                padding: 4px 0;
            }
            
            .filter-section .select2-container--default .select2-selection--single .select2-selection__rendered {
                padding: 4px 25px 4px 8px;
                line-height: 1.4;
                color: #495057 !important;
                white-space: normal !important;
                word-wrap: break-word !important;
                overflow: visible !important;
                text-overflow: initial !important;
                font-size: 0.7rem !important;
                display: block !important;
                text-align: right;
            }
            
            .filter-section .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 100%;
                right: 5px;
                top: 0;
            }
            
            /* Fix dropdown menu */
            .select2-dropdown {
                z-index: 9999 !important;
            }
            
            .select2-results__option {
                font-size: 0.75rem !important;
                padding: 8px !important;
                white-space: normal !important;
                line-height: 1.3 !important;
            }
            
            /* Fix Select2 placeholder text */
            .filter-section .select2-container--default .select2-selection--single .select2-selection__placeholder {
                color: #6c757d !important;
                font-size: 0.75rem !important;
            }
            
            /* Ensure select options are visible */
            .filter-section .form-select option {
                color: #495057 !important;
                font-size: 0.8rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .filter-section .border-danger-subtle {
                padding: 8px !important;
            }
            
            .filter-section .col-md-6,
            .filter-section .col-lg-3 {
                padding: 2px;
                margin-bottom: 4px;
            }
            
            .filter-section .form-select {
                font-size: 0.65rem !important;
                padding: 4px 6px;
                height: 32px;
            }
            
            .filter-section .btn-circle {
                width: 100%;
                height: 32px;
                font-size: 0.75rem;
            }
            
            .filter-section .btn-circle i {
                font-size: 12px;
            }
            
            /* Override Select2 for small screens */
            .filter-section .select2-container--default .select2-selection--single {
                min-height: 32px !important;
                font-size: 0.65rem !important;
                padding: 2px 0;
            }
            
            .filter-section .select2-container--default .select2-selection--single .select2-selection__rendered {
                font-size: 0.65rem !important;
                padding: 2px 20px 2px 6px;
            }
            
            .filter-section .select2-container--default .select2-selection--single .select2-selection__arrow {
                width: 20px;
            }
        }
        
        /* Force mobile styles with !important */
        @media (max-width: 768px) {
            /* Override any conflicting styles */
            .filter-section {
                padding: 6px !important;
                margin-bottom: 10px !important;
            }
            
            .filter-section .bg-light,
            .filter-section .custom-rounded {
                padding: 0 !important;
                margin: 0 !important;
            }
            
            .filter-section .p-5 {
                padding: 6px !important;
            }
            
            .filter-section .p-1 {
                padding: 0 !important;
            }
            
            /* Force 2 columns layout */
            .row.g-4 > .col-6 {
                flex: 0 0 50% !important;
                max-width: 50% !important;
                padding: 4px !important;
            }
            
            /* Ensure cards have spacing */
            .chalet-card {
                margin-bottom: 8px !important;
            }
        }
        
        /* Extra Small Devices */
        @media (max-width: 375px) {
            .page-hero {
                padding: 50px 0 25px;
            }
            
            .page-hero h1 {
                font-size: 1.2rem;
                margin-bottom: 10px;
            }
            
            .page-hero p {
                font-size: 0.8rem;
            }
            
            .breadcrumb-modern {
                padding: 10px 12px;
            }
            
            .breadcrumb-modern .breadcrumb {
                font-size: 0.75rem;
            }
            
            .filter-section {
                padding: 10px;
                margin-bottom: 15px;
            }
            
            .filter-section h3 {
                font-size: 0.95rem;
                margin-bottom: 12px;
            }
            
            /* Filter Extra Small Adjustments */
            .filter-section .border-danger-subtle {
                padding: 10px !important;
            }
            
            .filter-section .col-md-6,
            .filter-section .col-lg-3 {
                padding: 3px;
                margin-bottom: 8px;
            }
            
            .filter-section .form-select {
                font-size: 0.75rem !important;
                height: 32px;
            }
            
            .filter-section .btn-circle {
                width: 32px;
                height: 32px;
            }
            
            .filter-section .btn-circle i {
                font-size: 12px;
            }
            
            .chalet-card-image {
                height: 140px;
            }
            
            .price-badge {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
            
            .wishlist-btn {
                width: 32px;
                height: 32px;
            }
            
            .wishlist-btn i {
                font-size: 14px;
            }
            
            .chalet-card-body {
                padding: 10px;
            }
            
            .chalet-title {
                font-size: 0.9rem;
                margin-bottom: 6px;
            }
            
            .chalet-location {
                font-size: 0.75rem;
                margin-bottom: 10px;
            }
            
            .btn-view-details {
                padding: 8px 16px;
                font-size: 0.8rem;
                border-radius: 6px;
            }
        }
        
        /* Optimize Grid Spacing for Mobile */
        @media (max-width: 768px) {
            .row.g-4 {
                --bs-gutter-x: 0.5rem;
                --bs-gutter-y: 1rem;
            }
            
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }
            
            /* Hide image overlay on mobile for better performance */
            .image-overlay {
                display: none;
            }
            
            /* Optimize card hover effects for mobile */
            .chalet-card:hover {
                transform: none;
                box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            }
            
            .chalet-card:hover .chalet-card-image img {
                transform: none;
            }
        }
        
        /* Toast Notification */
        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: none;
            align-items: center;
            gap: 10px;
            z-index: 1000;
            animation: slideInUp 0.3s ease;
        }
        
        [dir="rtl"] .toast-notification {
            right: auto;
            left: 20px;
        }
        
        .toast-notification.show {
            display: flex;
        }
        
        .toast-notification.success {
            border-left: 4px solid #4caf50;
        }
        
        .toast-notification.error {
            border-left: 4px solid #f44336;
        }
        
        @keyframes slideInUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
@endsection

@section('content')

<!-- Hero Section -->
<section class="page-hero">
    <div class="container text-center">
        <h1>{{ app()->getLocale() == 'ar' ? 'اكتشف شاليهاتنا الفاخرة' : 'Discover Our Premium Chalets' }}</h1>
        <p>{{ app()->getLocale() == 'ar' ? 'استمتع بأفضل الأماكن للإقامة في عمان مع خدمات استثنائية وأسعار تنافسية' : 'Enjoy the best places to stay in Oman with exceptional services and competitive prices' }}</p>
    </div>
</section>

@if(request()->hasAny(['price', 'property', 'booking_from', 'area', 'state', 'gov']))
<div class="container mt-3 active-filters-section d-none d-md-block">
    <div class="alert alert-info">
        <strong>الفلترات النشطة:</strong>
        @if(request()->has('price'))
            <span class="badge bg-primary me-2">السعر: {{ implode(', ', request()->input('price')) }}</span>
        @endif
        @if(request()->has('property'))
            <span class="badge bg-success me-2">نوع العقار: {{ implode(', ', request()->input('property')) }}</span>
        @endif
        @if(request()->has('booking_from'))
            <span class="badge bg-warning me-2">من: {{ request()->input('booking_from') }}</span>
        @endif
        @if(request()->has('booking_to'))
            <span class="badge bg-warning me-2">إلى: {{ request()->input('booking_to') }}</span>
        @endif
        <span class="badge bg-secondary">عدد النتائج: {{ $chalets->total() }}</span>
    </div>
</div>
@endif

<div class="chalets-page">
    <div class="container">
        
        <!-- Breadcrumb -->
        <div class="breadcrumb-modern">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="/">
                            <i class="fas fa-home me-1"></i>
                            {{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ app()->getLocale() == 'ar' ? 'الشاليهات' : 'Chalets' }}
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <h3>
                <i class="fas fa-filter"></i>
                {{ app()->getLocale() == 'ar' ? 'تصفية النتائج' : 'Filter Results' }}
            </h3>
            @include('frontend.inc._filter')
        </div>

        <!-- Chalets Grid -->
        <div class="row g-4">
            @forelse($chalets as $chalet)
                <div class="col-6 col-md-6 col-lg-4 col-xl-3">
                    <article class="chalet-card">
                        
                        <!-- Card Image -->
                        <div class="chalet-card-image">
                            <img src="{{ asset($chalet->main_image ?? 'no_image.png') }}" 
                                 alt="{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}">
                            
                            <!-- Image Overlay -->
                            <div class="image-overlay">
                                <h5>{{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}</h5>
                            </div>
                            
                            <!-- Price Badge -->
                            <span class="price-badge">
                                {{ $chalet->default_day_price }} {{ app()->getLocale() == 'ar' ? 'ر.ع' : 'OMR' }}
                            </span>
                            
                            <!-- Wishlist Button -->
                            @php
                                $isInWishlist = false;
                                if(auth('customer')->check()) {
                                    $isInWishlist = auth('customer')->user()->wishlist()->where('chalet_id', $chalet->id)->exists();
                                }
                            @endphp
                            <button class="wishlist-btn {{ $isInWishlist ? 'active' : '' }}" data-chalet-id="{{ $chalet->id }}">
                                <i class="{{ $isInWishlist ? 'fas' : 'far' }} fa-heart"></i>
                            </button>
                        </div>

                        <!-- Card Body -->
                        <div class="chalet-card-body">
                            <h3 class="chalet-title">
                                <a href="{{ route('showChalet', $chalet->slug) }}" class="text-decoration-none">
                                    {{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}
                                </a>
                            </h3>
                            
                            <p class="chalet-location">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ app()->getLocale() == 'ar' ? $chalet->city->name_ar : $chalet->city->name_en }}
                                ({{ app()->getLocale() == 'ar' ? $chalet->area->name_ar : $chalet->area->name_en }})
                            </p>
                            
                            <a href="{{ route('showChalet', $chalet->slug) }}" class="btn-view-details">
                                {{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}
                                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-home"></i>
                        <h3>{{ app()->getLocale() == 'ar' ? 'لا توجد شاليهات متاحة' : 'No Chalets Available' }}</h3>
                        <p>{{ app()->getLocale() == 'ar' ? 'عذراً، لا توجد نتائج تطابق معايير البحث الخاصة بك' : 'Sorry, no results match your search criteria' }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($chalets->hasPages())
            <div class="pagination-wrapper">
                {!! $chalets->appends(Request::all())->links() !!}
            </div>
        @endif

    </div>
</div>

@endsection

@section('js')
<!-- Mobile Filter JavaScript -->
<script src="{{ asset('frontend/js/mobile-filter.js') }}"></script>

<!-- Toast Notification HTML -->
<div class="toast-notification" id="toastNotification">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage">تمت الإضافة إلى المفضلة</span>
</div>

<script>
    // Show toast notification
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toastNotification');
        const toastMessage = document.getElementById('toastMessage');
        
        toastMessage.textContent = message;
        toast.className = 'toast-notification ' + type + ' show';
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Wishlist functionality
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                if (!@json(auth('customer')->check())) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                
                const button = this;
                const chaletId = button.getAttribute('data-chalet-id');
                const icon = button.querySelector('i');
                
                // Prevent multiple clicks
                if (button.classList.contains('loading')) {
                    return;
                }
                
                button.classList.add('loading');
                
                // Send AJAX request
                const wishlistUrl = @json(route('wishlist.toggle', ['chalet' => '__CHALET_ID__']));

                fetch(wishlistUrl.replace('__CHALET_ID__', encodeURIComponent(chaletId)), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    button.classList.remove('loading');
                    
                    if (data.status === 'added') {
                        button.classList.add('active');
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        showToast(data.message || '{{ app()->getLocale() == "ar" ? "تمت الإضافة إلى المفضلة" : "Added to wishlist" }}', 'success');
                    } else if (data.status === 'removed') {
                        button.classList.remove('active');
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        showToast(data.message || '{{ app()->getLocale() == "ar" ? "تمت الإزالة من المفضلة" : "Removed from wishlist" }}', 'success');
                    } else {
                        showToast(data.message || '{{ app()->getLocale() == "ar" ? "حدث خطأ" : "An error occurred" }}', 'error');
                    }
                })
                .catch(error => {
                    button.classList.remove('loading');
                    console.error('Error:', error);
                    showToast('{{ app()->getLocale() == "ar" ? "حدث خطأ في الاتصال" : "Connection error occurred" }}', 'error');
                });
            });
        });

        // Flatpickr for date filter
        if (document.getElementById('flatpickr')) {
            let selectedDate = document.getElementById('flatpickr').value;
            
            const flatpickrInstance = flatpickr("#flatpickr", {
                mode: "range",
                dateFormat: "Y-m-d",
                minDate: "today",
                inline: false,
                defaultDate: selectedDate ? selectedDate.split(" to ") : []
            });
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection
