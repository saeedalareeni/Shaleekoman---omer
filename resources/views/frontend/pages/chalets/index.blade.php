@extends('frontend.layouts.weekend_master')

@section('page_title')
    @if(isset($selectedCategory) && $selectedCategory)
        @php
            $categoryTitles = [
                1 => ['ar' => 'شقق، استوديوهات، غرف، فلل', 'en' => 'Flats, Studios, Rooms, Villas'],
                2 => ['ar' => 'شاليهات، بيوت راحة، منتجعات', 'en' => 'Chalets, Rest Houses, Resorts'],
                3 => ['ar' => 'مزارع', 'en' => 'Farms'],
                4 => ['ar' => 'مخيمات', 'en' => 'Camps']
            ];
            $title = $categoryTitles[$selectedCategory->id] ?? ['ar' => $selectedCategory->name_ar, 'en' => $selectedCategory->name_en];
        @endphp
        {{ app()->getLocale() == 'ar' ? $title['ar'] : $title['en'] }}
    @else
        {{trans('back.chalets')}}
    @endif
@endsection

@section('css')
<!-- Mobile Filter CSS -->
<link rel="stylesheet" href="{{ asset('frontend/css/mobile-filter.css') }}">
<style>
    /* Language-specific fixes for English */
    @if(app()->getLocale() == 'en')
    body {
        direction: ltr !important;
        text-align: left !important;
    }

    /* Fix mobile layout for English */
    @media (max-width: 768px) {
        /* Fix filter dropdowns for LTR */
        .filter-section select.form-select {
            padding: 8px 30px 8px 12px !important;
            background-position: right 10px center !important;
            direction: ltr !important;
            text-align: left !important;
        }

        /* Fix search button */
        .filter-section button[type="submit"] {
            direction: ltr !important;
            text-align: center !important;
        }

        /* Fix card layouts */
        .deal-card {
            direction: ltr !important;
            text-align: left !important;
        }

        .deal-card .deal-content {
            direction: ltr !important;
            text-align: left !important;
        }

        /* Fix badges positioning */
        .deal-card .discount-badge {
            left: 15px !important;
            right: auto !important;
        }

        /* Fix price alignment */
        .deal-price-tag {
            direction: ltr !important;
        }

        /* Fix navigation and header */
        .navbar {
            direction: ltr !important;
        }

        /* Fix mobile menu */
        .mobile-menu {
            direction: ltr !important;
            text-align: left !important;
        }
    }
    @endif

    /* Language-specific fixes for Arabic */
    @if(app()->getLocale() == 'ar')
    body {
        direction: rtl !important;
        text-align: right !important;
    }

    @media (max-width: 768px) {
        /* Fix filter dropdowns for RTL */
        .filter-section select.form-select {
            padding: 8px 12px 8px 30px !important;
            background-position: left 10px center !important;
            direction: rtl !important;
            text-align: right !important;
        }

        /* Fix card layouts */
        .deal-card {
            direction: rtl !important;
            text-align: right !important;
        }

        /* Fix badges positioning */
        .deal-card .discount-badge {
            right: 15px !important;
            left: auto !important;
        }
    }
    @endif
    :root {
        --primary-color: #127664;   /* الأخضر الأساسي من الموقع */
        --secondary-color: #159265;  /* أخضر فاتح */
        --accent-color: #FF6B35;     /* برتقالي للتمييز */
        --accent-hover: #FF8C42;     /* برتقالي فاتح للـ hover */
        --success-color: #3EAC84;    /* أخضر للنجاح */
        --text-dark: #1E1E1E;
        --text-light: #6C757D;
        --border-color: #E0E6ED;
        --bg-light: #F8F9FA;
        --gradient-start: #006250;   /* أخضر داكن للتدرج */
        --gradient-end: #127664;     /* أخضر للتدرج */
    }

    /* Deal Card Styles - Same as Homepage */
    .deal-card {
        background: white;
        border-radius: 16px;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    }

    .deal-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .deal-card .deal-image {
        position: relative;
        width: 100%;
        height: 240px;
        overflow: hidden;
        border-radius: 16px 16px 0 0;
    }

    .deal-card .deal-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .deal-card .deal-image:hover img {
        transform: scale(1.05);
    }

    .deal-card .deal-image .discount-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--accent-hover) 100%);
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(255, 107, 53, 0.3);
    }

    .deal-card .deal-content {
        padding: 20px;
        border-radius: 0 0 16px 16px;
        border: 1px solid var(--border-color);
        border-top: none;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .deal-card .deal-content .deal-price-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: linear-gradient(135deg, rgba(18, 118, 100, 0.08) 0%, rgba(21, 146, 101, 0.05) 100%);
        border-radius: 12px;
        margin-bottom: 16px;
        width: fit-content;
        border: 1px solid rgba(18, 118, 100, 0.15);
    }

    .deal-card .deal-content .deal-price-tag span {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-color);
    }

    .deal-card .deal-content .deal-price-tag .per-night {
        font-weight: 400;
        font-size: 14px;
        color: var(--text-light);
        text-decoration: line-through;
    }

    .deal-card .deal-content .deal-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 8px 0;
        line-height: 1.4;
    }

    .deal-card .deal-content .deal-location {
        font-size: 14px;
        color: var(--text-light);
        margin: 0 0 16px 0;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .deal-card .deal-content .deal-location::before {
        content: "📍";
        font-size: 16px;
    }

    .deal-card .deal-content .deal-host {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding: 12px 0;
        border-top: 1px solid var(--bg-light);
    }

    .deal-card .deal-content .deal-host .host-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--bg-light);
    }

    .deal-card .deal-content .deal-host .host-info {
        display: flex;
        flex-direction: column;
    }

    .deal-card .deal-content .deal-host .host-info .host-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .deal-card .deal-content .deal-host .host-info .host-label {
        font-size: 12px;
        color: var(--text-light);
    }

    .deal-card .deal-content .deal-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: auto;
    }

    .deal-card .deal-content .deal-actions .btn-view-details {
        flex: 1;
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(18, 118, 100, 0.25);
    }

    .deal-card .deal-content .deal-actions .btn-view-details:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(18, 118, 100, 0.35);
        background: linear-gradient(135deg, var(--gradient-end) 0%, var(--secondary-color) 100%);
    }

    .deal-card .deal-content .deal-actions .btn-wishlist-circle {
        width: 44px;
        height: 44px;
        background: white;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0;
    }

    .deal-card .deal-content .deal-actions .btn-wishlist-circle:hover {
        border-color: var(--accent-color);
        background: rgba(255, 107, 53, 0.08);
    }

    .deal-card .deal-content .deal-actions .btn-wishlist-circle:hover svg path {
        stroke: var(--accent-color);
    }

    .deal-card .deal-content .deal-actions .btn-wishlist-circle.active {
        background: var(--accent-color);
        border-color: var(--accent-color);
    }

    .deal-card .deal-content .deal-actions .btn-wishlist-circle.active svg path {
        stroke: white;
        fill: white;
    }

    /* واتساب واتصال في البطاقات - لون أخضر مميز */
    .deal-card .deal-contact.listing-contact-mobile {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }
    .deal-card .deal-contact a.contact-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .deal-card .deal-contact a.contact-btn.whatsapp {
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: #fff;
        border: none;
    }
    .deal-card .deal-contact a.contact-btn.call {
        background: linear-gradient(135deg, #159265 0%, #127664 100%);
        color: #fff;
        border: none;
    }
    .deal-card .deal-contact a.contact-btn:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }

    /* مقاسات ثابتة على الكمبيوتر */
    @media (min-width: 992px) {
        .deal-card {
            height: 100%;
            min-height: 520px;
        }
        .deal-card .deal-image {
            height: 220px;
            flex-shrink: 0;
        }
        .deal-card .deal-image img {
            height: 220px;
            object-fit: cover;
        }
        .deal-card .deal-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .deal-card .deal-content .deal-price-tag {
            flex-shrink: 0;
        }
    }

    /* على الهاتف: عرض المواضيع بشكل أفقي (سكرول أفقي) */
    @media (max-width: 991px) {
        .listing-cards-row {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 16px;
            padding-bottom: 16px;
            margin: 0 -12px;
            -webkit-overflow-scrolling: touch;
            scroll-snap-type: x mandatory;
        }
        .listing-cards-row .listing-card-col {
            flex: 0 0 85%;
            max-width: 85%;
            scroll-snap-align: start;
        }
        .listing-cards-row .deal-card {
            min-height: auto;
        }
    }
    @media (min-width: 992px) {
        .listing-cards-row {
            display: flex;
            flex-wrap: wrap;
        }
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        /* Section Spacing Mobile */
        section {
            padding-top: 15px !important;
            padding-bottom: 15px !important;
        }

        section.mb-3 {
            margin-bottom: 10px !important;
        }

        section.py-5 {
            padding-top: 20px !important;
            padding-bottom: 20px !important;
        }

        /* Page Header Mobile */
        .page-header {
            padding: 50px 0 25px;
            margin-bottom: 20px !important;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .page-header p {
            font-size: 0.9rem;
        }

        /* Breadcrumb Mobile */
        .breadcrumb {
            font-size: 0.85rem;
            padding: 8px 0;
        }

        /* Enhanced Filter Mobile */
        .filter-container {
            padding: 12px !important;
            border-radius: 12px !important;
            margin-bottom: 15px !important;
        }

        .filter-container .row {
            margin: 0 -4px !important;
        }

        .filter-container .col-md-6,
        .filter-container .col-lg-3 {
            padding: 4px !important;
            margin-bottom: 8px !important;
        }

        /* Make filters 2x2 grid on mobile */
        .filter-container .col-md-6.col-lg-3 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }

        .filter-container .form-select {
            font-size: 0.85rem !important;
            padding: 10px 12px !important;
            height: 42px !important;
            border-width: 1.5px !important;
        }

        .filter-container .btn-circle {
            height: 44px !important;
            font-size: 0.9rem !important;
            margin-top: 8px !important;
        }

        .filter-container .btn-circle i {
            font-size: 16px !important;
        }

        /* Search button full width */
        .filter-container form > div.ms-2 {
            margin: 0 !important;
            width: 100% !important;
            padding: 0 4px !important;
        }

        /* Results Info Mobile */
        .results-info {
            padding: 10px !important;
            margin-bottom: 12px !important;
            flex-direction: column !important;
            gap: 10px !important;
            background: white !important;
            border-radius: 10px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
        }

        .results-info h5 {
            font-size: 0.9rem !important;
            text-align: center !important;
            margin-bottom: 0 !important;
        }

        .results-info h5 i {
            display: none !important; /* Hide icon on mobile */
        }

        .results-info > div:last-child {
            width: 100% !important;
            flex-direction: column !important;
            gap: 8px !important;
        }

        .results-info label {
            font-size: 0.85rem !important;
            text-align: center !important;
            display: block !important;
        }

        .results-info select {
            width: 100% !important;
            font-size: 0.85rem !important;
            padding: 8px 12px !important;
            border-radius: 8px !important;
            border: 1.5px solid #127664 !important;
            background: #f8fffe !important;
        }

        /* Cards Grid - 2 per row */
        .col-12.col-md-6.col-lg-4.col-xl-3 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
            padding: 4px !important;
        }

        /* Ensure proper spacing */
        .row.g-4 {
            --bs-gutter-x: 0.5rem !important;
            --bs-gutter-y: 0.5rem !important;
            margin: 0 -0.25rem !important;
        }

        /* Deal Card Mobile */
        .deal-card {
            margin-bottom: 8px;
        }

        .deal-card .deal-image {
            height: 140px;
        }

        .deal-card .deal-content .deal-actions {
            gap: 6px !important;
        }

        .deal-card .discount-badge {
            padding: 4px 8px;
            font-size: 0.75rem;
        }

        .deal-card .deal-content {
            padding: 10px;
        }

        .deal-card .deal-content h3 {
            font-size: 0.9rem;
            margin-bottom: 6px;
        }

        .deal-card .deal-content .deal-location {
            font-size: 0.75rem;
            margin-bottom: 8px;
        }

        .deal-card .deal-content .deal-price {
            font-size: 0.85rem;
        }

        .deal-card .deal-content .deal-price .price-amount {
            font-size: 1.1rem;
        }

        .deal-card .deal-content .deal-actions .btn-view-details {
            padding: 6px 10px !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            min-height: 32px !important;
        }

        .deal-card .deal-content .deal-actions .btn-wishlist-circle {
            width: 32px !important;
            height: 32px !important;
        }

        .deal-card .deal-content .deal-actions .btn-wishlist-circle svg {
            width: 16px !important;
            height: 16px !important;
        }

        /* Sort Dropdown Mobile */
        .sort-dropdown {
            margin-bottom: 15px;
        }

        .sort-dropdown select {
            font-size: 0.85rem;
            padding: 8px 12px;
        }

        /* Pagination Mobile */
        .pagination {
            font-size: 0.85rem;
        }

        .page-link {
            padding: 6px 10px;
        }
    }

    @media (max-width: 480px) {
        /* Extra Small Screens */
        /* Section Spacing */
        section {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        .page-header {
            padding: 40px 0 20px !important;
            margin-bottom: 15px !important;
        }

        .page-header h1 {
            font-size: 1.3rem;
        }

        /* Filter */
        .filter-container {
            padding: 10px !important;
            margin-bottom: 12px !important;
        }

        .filter-container .form-select {
            font-size: 0.8rem !important;
            padding: 8px 10px !important;
            height: 38px !important;
        }

        .filter-container .btn-circle {
            height: 40px !important;
            font-size: 0.85rem !important;
        }

        /* Results Info */
        .results-info {
            padding: 8px !important;
            margin-bottom: 10px !important;
        }

        .results-info h5 {
            font-size: 0.85rem !important;
        }

        .results-info label {
            font-size: 0.8rem !important;
        }

        .results-info select {
            font-size: 0.8rem !important;
            padding: 6px 10px !important;
        }

        .deal-card .deal-image {
            height: 120px;
        }

        .deal-card .deal-content {
            padding: 8px;
        }

        .deal-card .deal-content h3 {
            font-size: 0.85rem;
        }

        .deal-card .deal-content .deal-actions .btn-view-details {
            padding: 5px 8px !important;
            font-size: 0.7rem !important;
            min-height: 30px !important;
        }

        .deal-card .deal-content .deal-actions .btn-wishlist-circle {
            width: 30px !important;
            height: 30px !important;
        }
    }

    @media (max-width: 375px) {
        /* Very Small Screens */
        .deal-card .deal-image {
            height: 100px;
        }

        .deal-card .discount-badge {
            padding: 3px 6px;
            font-size: 0.7rem;
        }

        .deal-card .deal-content h3 {
            font-size: 0.8rem;
            line-height: 1.2;
        }

        .deal-card .deal-content .deal-location {
            font-size: 0.7rem;
        }

        .deal-card .deal-content .deal-price .price-amount {
            font-size: 1rem;
        }

        .deal-card .deal-content .deal-actions .btn-view-details {
            padding: 4px 6px !important;
            font-size: 0.65rem !important;
            min-height: 28px !important;
            font-weight: 600 !important;
            letter-spacing: 0.3px !important;
        }

        .deal-card .deal-content .deal-actions .btn-wishlist-circle {
            width: 28px !important;
            height: 28px !important;
        }

        .deal-card .deal-content .deal-actions .btn-wishlist-circle svg {
            width: 14px !important;
            height: 14px !important;
        }
    }

    /* Enhanced Filter Styles */
    .filter-container {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }

    .filter-container .bg-light {
        background: transparent !important;
        padding: 0 !important;
    }

    .filter-container .border-danger-subtle {
        border: none !important;
        padding: 0 !important;
    }

    .filter-container .form-select {
        border: 2px solid #e8f5f0;
        background: #f8fffe;
        color: #333;
        font-weight: 500;
        padding: 12px 15px;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .filter-container .form-select:focus {
        border-color: var(--primary-color);
        background: white;
        box-shadow: 0 0 0 4px rgba(18, 118, 100, 0.1);
    }

    .filter-container .btn-circle {
        width: 100%;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(18, 118, 100, 0.3);
    }

    .filter-container .btn-circle:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(18, 118, 100, 0.4);
    }

    .filter-container .btn-circle i {
        font-size: 18px;
    }

    /* Add search text to button */
    .filter-container .btn-circle::after {
        content: attr(data-text);
        margin-left: 5px;
    }

    /* Page Header Styles */
    .page-header {
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--primary-color) 50%, var(--secondary-color) 100%);
        padding: 80px 0 40px;
        color: white;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,112C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 1rem;
    }

    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: white;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    /* RTL Support */
    [dir="rtl"] .deal-card .deal-image .discount-badge {
        left: auto;
        right: 15px;
    }

    /* Pagination Styles */
    .pagination {
        gap: 5px;
    }

    .page-link {
        color: var(--primary-color);
        border: 1px solid var(--border-color);
        border-radius: 8px !important;
        padding: 8px 14px;
        margin: 0 2px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .page-link:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(18, 118, 100, 0.25);
    }

    .page-item.disabled .page-link {
        color: var(--text-light);
        background-color: var(--bg-light);
        border-color: var(--border-color);
    }

    /* Results counter styles */
    .results-info {
        background: linear-gradient(135deg, rgba(236, 240, 241, 0.5) 0%, rgba(189, 195, 199, 0.1) 100%);
        padding: 20px 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px solid var(--border-color);
        backdrop-filter: blur(10px);
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    .border-primary {
        border-color: var(--primary-color) !important;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
    }
</style>
@endsection

@section('content')

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('shaleek.home') }}">
                            <i class="fas fa-home me-1"></i>
                            {{ __('back.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if(isset($selectedCategory) && $selectedCategory)
                            @php
                                $categoryTitles = [
                                    1 => ['ar' => 'شقق، استوديوهات، غرف، فلل', 'en' => 'Flats, Studios, Rooms, Villas'],
                                    2 => ['ar' => 'شاليهات، بيوت راحة، منتجعات', 'en' => 'Chalets, Rest Houses, Resorts'],
                                    3 => ['ar' => 'مزارع', 'en' => 'Farms'],
                                    4 => ['ar' => 'مخيمات', 'en' => 'Camps']
                                ];
                                $title = $categoryTitles[$selectedCategory->id] ?? ['ar' => $selectedCategory->name_ar, 'en' => $selectedCategory->name_en];
                            @endphp
                            {{ app()->getLocale() == 'ar' ? $title['ar'] : $title['en'] }}
                        @else
                            {{ trans('back.chalets') }}
                        @endif
                    </li>
                </ol>
            </nav>
            <h1 class="display-4 fw-bold text-white mb-3">
                @if(isset($selectedCategory) && $selectedCategory)
                    @php
                        $categoryTitles = [
                            1 => ['ar' => 'شقق، استوديوهات، غرف، فلل', 'en' => 'Flats, Studios, Rooms, Villas'],
                            2 => ['ar' => 'شاليهات، بيوت راحة، منتجعات', 'en' => 'Chalets, Rest Houses, Resorts'],
                            3 => ['ar' => 'مزارع', 'en' => 'Farms'],
                            4 => ['ar' => 'مخيمات', 'en' => 'Camps']
                        ];
                        $title = $categoryTitles[$selectedCategory->id] ?? ['ar' => $selectedCategory->name_ar, 'en' => $selectedCategory->name_en];
                    @endphp
                    {{ app()->getLocale() == 'ar' ? $title['ar'] : $title['en'] }}
                @else
                    {{ trans('back.chalets') }}
                @endif
            </h1>
            <p class="lead text-white">
                @if(isset($selectedCategory) && $selectedCategory)
                    @php
                        $categoryDescriptions = [
                            1 => ['ar' => 'اكتشف أفضل الشقق والاستوديوهات والغرف والفلل', 'en' => 'Discover the best flats, studios, rooms and villas'],
                            2 => ['ar' => 'اكتشف أفضل الشاليهات وبيوت الراحة والمنتجعات', 'en' => 'Discover the best chalets, rest houses and resorts'],
                            3 => ['ar' => 'اكتشف أفضل المزارع للإيجار', 'en' => 'Discover the best farms for rent'],
                            4 => ['ar' => 'اكتشف أفضل المخيمات والتجارب البرية', 'en' => 'Discover the best camps and outdoor experiences']
                        ];
                        $description = $categoryDescriptions[$selectedCategory->id] ?? ['ar' => 'اكتشف أفضل العروض المتاحة', 'en' => 'Discover the best available offers'];
                    @endphp
                    {{ app()->getLocale() == 'ar' ? $description['ar'] : $description['en'] }}
                @else
                    {{ app()->getLocale() == 'ar' ? 'اكتشف جميع العروض المتاحة' : 'Discover all available offers' }}
                @endif
            </p>
        </div>
    </section>

    <section class="mb-3">
        <div class="container">
            <div class="filter-container">
                @include('frontend.inc._filter')
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <!-- Results Count -->
            @if($chalets->total() > 0)
            <div class="results-info d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0 text-dark">
                        <i class="fas fa-search me-2 text-primary"></i>
                        {{ app()->getLocale() == 'ar' ? 'عرض' : 'Showing' }}
                        <strong class="text-primary">{{ $chalets->firstItem() }}-{{ $chalets->lastItem() }}</strong>
                        {{ app()->getLocale() == 'ar' ? 'من' : 'of' }}
                        <strong class="text-primary">{{ $chalets->total() }}</strong>
                        {{ app()->getLocale() == 'ar' ? 'نتيجة' : 'results' }}
                    </h5>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 text-dark fw-medium">
                        <i class="fas fa-sort me-1"></i>
                        {{ app()->getLocale() == 'ar' ? 'ترتيب حسب:' : 'Sort by:' }}
                    </label>
                    <select class="form-select form-select-sm border-primary" style="width: auto; color: #127664;" onchange="sortResults(this.value)">
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'السعر: من الأقل للأعلى' : 'Price: Low to High' }}</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'السعر: من الأعلى للأقل' : 'Price: High to Low' }}</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الأحدث' : 'Newest' }}</option>
                    </select>
                </div>
            </div>
            @endif

            <div class="row g-4 listing-cards-row">
                @forelse($chalets as $chalet)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 listing-card-col">
                        <div class="deal-card">
                            <div class="deal-image">
                                <a href="{{ route('showChalet', $chalet->slug) }}">
                                    <img src="{{ asset($chalet->main_image ?? 'no_image.png') }}"
                                         alt="{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}">
                                </a>
                                @php
                                    $defaultPrice = $chalet->default_day_price ?? 100;
                                    $holidayPrice = $chalet->holiday_day_price ?? 150;
                                    $actualDiscount = 0;
                                    if ($holidayPrice > $defaultPrice) {
                                        $actualDiscount = round((($holidayPrice - $defaultPrice) / $holidayPrice) * 100);
                                    }
                                @endphp
                                @if($actualDiscount > 0)
                                    <span class="discount-badge">{{ $actualDiscount }}% {{ app()->getLocale() == 'ar' ? 'خصم' : 'off' }}</span>
                                @endif
                            </div>
                            <div class="deal-content">
                                <div class="deal-price-tag">
                                    @if($holidayPrice > $defaultPrice)
                                        <del class="per-night">{{ number_format($holidayPrice, 0) }}</del>
                                    @endif
                                    <span class="fw-medium">{{ number_format($defaultPrice, 0) }} {{ trans('back.currency') }}</span>
                                </div>
                                <h3 class="deal-title">{{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}</h3>
                                <p class="deal-location">
                                    {{ app()->getLocale()=='ar'? $chalet->city->name_ar:$chalet->city->name_en }}
                                    @if($chalet->area)
                                        / {{ app()->getLocale()=='ar'? $chalet->area->name_ar:$chalet->area->name_en }}
                                    @endif
                                </p>
                                @if($chalet->show_contact_icon && ($chalet->whatsapp_link ?? $chalet->phone_link))
                                <div class="deal-contact listing-contact-mobile mb-2">
                                    @if($chalet->whatsapp_link ?? null)
                                        <a href="{{ $chalet->whatsapp_link }}?text={{ urlencode(app()->getLocale()=='ar' ? 'مرحباً، أريد الاستفسار عن ' . $chalet->chalet_name_ar : 'Hello, I want to inquire about ' . $chalet->chalet_name_en) }}" class="contact-btn whatsapp" target="_blank" rel="noopener">
                                            <i class="fab fa-whatsapp"></i> {{ app()->getLocale() == 'ar' ? 'واتساب' : 'WhatsApp' }}
                                        </a>
                                    @endif
                                    @if($chalet->phone_link ?? null)
                                        <a href="{{ $chalet->phone_link }}" class="contact-btn call">
                                            <i class="fas fa-phone"></i> {{ app()->getLocale() == 'ar' ? 'اتصل' : 'Call' }}
                                        </a>
                                    @endif
                                </div>
                                @endif
                                <div class="deal-host">
                                    <img src="{{ asset($chalet->owner->image) }}" class="host-avatar">
{{--                                    <img src="https://i.pravatar.cc/150?img={{ $chalet->owner->id ?? rand(1, 50) }}" alt="Host" class="host-avatar">--}}
                                    <div class="host-info">
                                        <span class="host-name">{{ $chalet->owner->name ?? 'أحمد محمد' }}</span>
                                        <span class="host-label">{{ app()->getLocale() == 'ar' ? 'مالك العقار' : 'Real estate owner' }}</span>
                                    </div>
                                </div>
                                <div class="deal-actions">
                                    <button class="btn-view-details" onclick="window.location.href='{{ route('showChalet', $chalet->slug) }}'">
                                        {{ trans('back.show_details') }}
                                    </button>
                                    <button class="btn-wishlist-circle {{ auth('customer')->check() && auth('customer')->user()->wishlist()->where('chalet_id', $chalet->id)->exists() ? 'active' : '' }}" data-chalet-id="{{ $chalet->id }}">
                                        <span>
                                            <svg width="30" height="30" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.496 15.0542C9.224 15.1486 8.776 15.1486 8.504 15.0542C6.184 14.2756 1 11.0272 1 5.52163C1 3.09129 2.992 1.125 5.448 1.125C6.904 1.125 8.192 1.81714 9 2.8868C9.808 1.81714 11.104 1.125 12.552 1.125C15.008 1.125 17 3.09129 17 5.52163C17 11.0272 11.816 14.2756 9.496 15.0542Z" stroke="#159265" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-home fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">{{ __('back.not_found') }}</h4>
                            <p class="text-muted">{{ app()->getLocale() == 'ar' ? 'لا توجد شاليهات متاحة حالياً' : 'No chalets available at the moment' }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($chalets->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    {!! $chalets->appends(Request::all())->links('pagination::bootstrap-5') !!}
                </nav>
            </div>
            @endif
        </div>
    </section>
@endsection

@section('js')
    <!-- Mobile Filter JavaScript -->
    <script src="{{ asset('frontend/js/mobile-filter.js') }}"></script>

    <script>
        // Sort functionality
        function sortResults(sortBy) {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sortBy);
            window.location.href = url.toString();
        }

        // Wishlist functionality
        document.querySelectorAll('.btn-wishlist-circle').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const chaletId = this.dataset.chaletId;

                if (!@json(auth('customer')->check())) {
                    if (confirm('{{ app()->getLocale() == "ar" ? "يجب تسجيل الدخول أولاً لإضافة الشاليه إلى المفضلة. هل تريد الذهاب إلى صفحة تسجيل الدخول؟" : "Please login first to add this chalet to wishlist. Do you want to go to login page?" }}')) {
                        window.location.href = '{{ route("login") }}';
                    }
                    return;
                }

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
                        this.classList.add('active');
                    } else {
                        this.classList.remove('active');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Date picker functionality
        document.addEventListener('DOMContentLoaded', function () {
            let selectedDate = document.getElementById('flatpickr')?.value;
            if (document.getElementById('flatpickr')) {
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
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection
