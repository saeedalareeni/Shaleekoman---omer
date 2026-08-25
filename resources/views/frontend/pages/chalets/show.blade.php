@extends('frontend.layouts.weekend_master')

@php
    $isArabic = app()->getLocale() == 'ar';

    // حساب التقييم الحقيقي من جدول reviews
    $reviews = \App\Models\Review::where('chalet_id', $chalet->id)->get();
    $averageRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 4.5;
    $totalReviews = $reviews->count() ?: rand(15, 87);

    // تحديث قيم التقييم في قاعدة البيانات
    if ($reviews->count() > 0) {
        $chalet->rating = $averageRating;
        $chalet->total_reviews = $totalReviews;
        $chalet->save();
    }

    // حساب تقييم المالك من جميع عقاراته
    $ownerChalets = \App\Models\Chalet::where('owner_id', $chalet->owner_id)->pluck('id');
    $ownerReviews = \App\Models\Review::whereIn('chalet_id', $ownerChalets)->get();
    $ownerRating = $ownerReviews->count() > 0 ? round($ownerReviews->avg('rating'), 1) : 4.2;
    $ownerTotalReviews = $ownerReviews->count() ?: rand(25, 150);

    $contactMessage = urlencode($isArabic
        ? 'مرحباً، أرغب في الاستفسار عن: ' . $chalet->chalet_name_ar
        : 'Hello, I would like to inquire about: ' . $chalet->chalet_name_en);
    $callPhone = $chalet->phone ?: $chalet->whatsapp_number;
    $callPhoneLink = $chalet->phone_link ?: ($chalet->whatsapp_number ? 'tel:+' . preg_replace('/\D/', '', $chalet->whatsapp_number) : null);
    $whatsappPhone = $chalet->whatsapp_number;
    $whatsappLink = $chalet->whatsapp_link ? $chalet->whatsapp_link . '?text=' . $contactMessage : null;
    $hasDirectContact = filled($callPhoneLink) || filled($whatsappLink);
@endphp

@section('title', $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en)

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <link rel="stylesheet" href="{{ asset('frontend/css/chalet-details.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/mobile-responsive.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <style>

    .report-btn {
    background: #fde2e2;
    color: #b91c1c;
    border-radius: 20px;
    font-size: 13px;
    border: 1px solid #fca5a5;
}
.report-btn:hover {
    background: #fca5a5;
    color: #7f1d1d;
}


        /* ========== CSS إصلاحات أساسية ========== */

        /* إزالة جميع display: none !important للمحتوى */
        .property-card-section {
            display: block !important;
        }

        /* إصلاح الشكل العام للصفحة */
        .chalet-details-page {
            background: #f8f9fa;
            min-height: 100vh;
        }

        /* Desktop Layout */
        .desktop-images-layout {
            margin-bottom: 30px;
        }

        .desktop-grid-wrapper {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 12px;
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
        }

        .main-image-container {
            height: 100%;
            overflow: hidden;
            border-radius: 12px 0 0 12px;
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .main-image:hover {
            transform: scale(1.05);
        }

        .side-images-container {
            display: grid;
            grid-template-rows: repeat(4, 1fr);
            gap: 12px;
            height: 100%;
        }

        .side-image-item {
            overflow: hidden;
        }

        .side-image-item:first-child {
            border-radius: 0 12px 0 0;
        }

        .side-image-item:last-child {
            border-radius: 0 0 12px 0;
        }

        .side-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .side-image:hover {
            transform: scale(1.1);
        }

        /* Mobile Layout */
        .mobile-images-layout {
            margin-bottom: 20px;
        }

        .mobile-main-image-container {
            width: 100%;
            height: 280px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .mobile-main-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mobile-thumbnails-container {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 10px 0;
            -webkit-overflow-scrolling: touch;
        }

        .mobile-thumbnails-container::-webkit-scrollbar {
            display: none;
        }

        .mobile-thumbnail-item {
            flex: 0 0 80px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .mobile-thumbnail-item.active {
            border-color: #127664;
        }

        .mobile-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mobile-thumb-link {
            text-decoration: none;
        }

        .mobile-main-link {
            display: block;
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .mobile-main-image-container {
                height: 220px;
            }

            .mobile-thumbnail-item {
                flex: 0 0 70px;
                height: 50px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .mobile-main-image-container {
                height: 320px;
            }
        }

        @media (min-width: 992px) {
            .mobile-images-layout {
                display: none !important;
            }
        }

        @media (max-width: 991px) {
            .desktop-images-layout {
                display: none !important;
            }

            /* إصلاحات الموبايل العامة */
            .property-card-section {
                padding: 0 !important;
                margin: 0 !important;
            }

            .container-fluid {
                padding: 0 !important;
                margin: 0 !important;
            }

            .row {
                margin: 0 !important;
            }

            .col-lg-8, .col-lg-4, [class*="col-"] {
                padding: 0 !important;
                width: 100% !important;
            }
        }

        /* English Language Mobile Fixes for Chalet Details Page */
        @if(app()->getLocale() == 'en')
        @media (max-width: 768px) {
            /* Fix mobile layout direction */
            .mobile-layout {
                direction: ltr !important;
                text-align: left !important;
            }

            /* Fix mobile header */
            .mobile-header {
                direction: ltr !important;
                text-align: left !important;
            }

            /* Fix mobile sections */
            .mobile-layout > div {
                direction: ltr !important;
                text-align: left !important;
            }

            /* Fix mobile booking bar */
            .mobile-booking-bar {
                direction: ltr !important;
                text-align: left !important;
            }

            /* Fix WhatsApp button position */
            a[href*="wa.me"] {
                right: 20px !important;
                left: auto !important;
            }

            /* Fix badges and labels */
            .discount-badge, .featured-badge {
                left: 15px !important;
                right: auto !important;
            }

            /* Fix icons in lists */
            ul li i, .fa, .fas, .far {
                margin-right: 8px !important;
                margin-left: 0 !important;
            }

            /* Fix modal content */
            .mobile-booking-modal {
                direction: ltr !important;
                text-align: left !important;
            }
        }
        @endif

        /* مساحة أسفل المحتوى على الموبايل حتى لا يختفي خلف شريط الحجز + دعم safe-area */
        @media (max-width: 991px) {
            .booking-card-section {
                padding-bottom: 120px;
                padding-bottom: calc(100px + env(safe-area-inset-bottom, 0px));
            }
        }

        /* تنسيق مقاسات عرض المواضيع - هاتف وكمبيوتر */
        .property-card-section .container-fluid,
        .booking-card-section .container-fluid {
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
        }
        @media (min-width: 576px) {
            .property-card-section .container-fluid,
            .booking-card-section .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }
        }
        @media (min-width: 992px) {
            .property-card-section .container-fluid,
            .booking-card-section .container-fluid {
                max-width: 1320px;
            }
        }
        @media (max-width: 575px) {
            .property-card-title { font-size: 1.25rem; }
            .price-in-content .fs-4 { font-size: 1.35rem !important; }
        }
        /* تأكد ظهور أيقونات Font Awesome على الموبايل */
        @media (max-width: 991px) {
            .contact-buttons-wrap .fas,
            .contact-buttons-wrap .fab {
                display: inline-block !important;
                font-style: normal !important;
                font-variant: normal !important;
            }
        }

        /* باقي الـ CSS الأصلي */
        /* Guarantee Card */
        .guarantee-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Booking Card Styles */
        .booking-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .sticky-card {
            position: sticky;
            top: 100px;
        }

        /* Tabs Navigation - على الهاتف تبقى التبويبات في سطر واحد (flex جمب بعضها) */
        .specs-tabs-navigation {
            display: flex;
            flex-wrap: nowrap;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
            padding: 0 20px;
            background: #f8f9fa;
            border-radius: 12px 12px 0 0;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        /* Hide scrollbar but keep functionality */
        .specs-tabs-navigation::-webkit-scrollbar {
            display: none;
        }

        .specs-tabs-navigation {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        .tab-btn {
            padding: 16px 24px;
            background: transparent;
            border: none;
            color: #666;
            font-weight: 500;
            font-size: 15px;
            cursor: pointer;
            position: relative;
            transition: all 0.3s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .tab-btn:hover {
            color: #127664;
            background: rgba(18, 118, 100, 0.05);
        }

        .tab-btn.active {
            color: #127664;
            font-weight: 600;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: #127664;
            border-radius: 3px 3px 0 0;
        }

        /* Price Section */
        .price-section {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .price-main {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .price-amount {
            font-size: 28px;
            font-weight: 700;
            color: #127664;
        }

        .price-currency {
            font-size: 16px;
            color: #666;
        }

        /* WhatsApp Button */
        .whatsapp-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #25D366;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            width: 100%;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .whatsapp-button:hover {
            background: #20BD5C;
            color: white;
            transform: translateY(-2px);
        }

        /* Date Selection */
        .date-selection {
            margin-bottom: 20px;
        }

        .date-input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .date-input {
            display: flex;
            flex-direction: column;
            min-width: 0; /* Prevent overflow */
        }

        .date-input label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .date-input input,
        .date-input textarea {
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            width: 100%;
            box-sizing: border-box;
        }

        .date-input input:focus,
        .date-input textarea:focus {
            border-color: #127664;
            outline: none;
            box-shadow: 0 0 0 3px rgba(18, 118, 100, 0.1);
        }

        /* Full width for guest number and special requests */
        .date-selection:has(.date-input:only-child) .date-input-group {
            grid-template-columns: 1fr;
        }

        /* Time Selection */
        .time-selection-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .time-item {
            display: flex;
            flex-direction: column;
            min-width: 0; /* Prevent overflow */
        }

        .time-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .time-item input {
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        /* Confirm Button */
        .btn-confirm {
            width: 100%;
            padding: 14px;
            background: #127664;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin: 20px 0;
        }

        .btn-confirm:hover {
            background: #0f5c4d;
            transform: translateY(-2px);
        }

        /* Price Breakdown */
        .price-breakdown {
            padding: 20px 0;
            border-top: 1px solid #e5e7eb;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            color: #666;
            font-size: 14px;
        }

        .breakdown-value {
            font-weight: 500;
        }

        /* Total Section */
        .total-section {
            padding: 20px 0;
            border-top: 2px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .total-value {
            font-size: 24px;
            font-weight: 700;
            color: #127664;
        }

        /* Insurance Note */
        .insurance-note {
            margin-top: 15px;
            padding: 10px;
            background: #fef3c7;
            border-radius: 6px;
            color: #92400e;
            font-size: 13px;
            text-align: center;
        }

        /* Ensure proper layout */
        .booking-card-section .row {
            display: flex !important;
            flex-wrap: nowrap !important;
            gap: 40px !important;
        }

        .booking-card-section .col-lg-8 {
            flex: 0 0 65% !important;
            max-width: 65% !important;
        }

        .booking-card-section .col-lg-4 {
            flex: 0 0 32% !important;
            max-width: 32% !important;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .booking-card {
                padding: 20px;
            }

            .date-input label,
            .time-label {
                font-size: 13px;
            }
        }

        /* موبايل: عمود المحتوى والجانبي بعرض كامل */
        @media (max-width: 991px) {
            .booking-card-section .row {
                flex-wrap: wrap !important;
            }

            .booking-card-section .col-lg-8,
            .booking-card-section .col-lg-4 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            
            .sticky-card {
                position: relative;
                top: 0;
            }

            .date-input-group {
                grid-template-columns: 1fr;
            }

            .time-selection-section {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .booking-card {
                padding: 15px;
            }

            .price-amount {
                font-size: 24px;
            }

            .whatsapp-button {
                padding: 10px 15px;
                font-size: 14px;
            }

            .btn-confirm {
                padding: 12px;
                font-size: 14px;
            }

            .tab-btn {
                padding: 14px 20px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .date-input-group,
            .time-selection-section {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .date-input input,
            .time-item input {
                font-size: 16px; /* Prevent zoom on iOS */
            }
        }

        /* Modal Styles */
        #bookingModal .modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }

        #bookingModal .modal-header {
            padding: 20px 20px 0;
        }

        #bookingModal .modal-body {
            padding: 30px 40px;
        }

        #bookingModal .btn-close {
            background: #f0f0f0;
            border-radius: 50%;
            opacity: 1;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            right: 20px;
            top: 20px;
        }

        #bookingModal .modal-title {
            color: #333;
            font-weight: 600;
            font-size: 1.5rem;
        }

        #bookingModal .btn {
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }

        #bookingModal .btn-primary {
            background: #127664;
            border: none;
        }

        #bookingModal .btn-primary:hover {
            background: #0f5c4d;
            transform: translateY(-2px);
        }

        #bookingModal .btn-success {
            background: #25D366;
            border: none;
        }

        #bookingModal .btn-success:hover {
            background: #20BD5C;
            transform: translateY(-2px);
        }

        #bookingModal .btn-secondary {
            background: #6c757d;
            border: none;
        }

        #modalIcon {
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tab Content General Styles */
        .tab-content {
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            margin-top: 20px;
        }

        .tab-content.active {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Specifications Tab Styles */
        .spec-section {
            padding: 25px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* على الهاتف: قسم المواصفات والمميزات scroll عمودي (ترتيب عمودي) */
        @media (max-width: 768px) {
            .tab-content[data-content="0"] .specs-sections-wrap {
                display: flex;
                flex-direction: column;
                overflow-y: auto;
                overflow-x: hidden;
                gap: 16px;
                padding-bottom: 12px;
                -webkit-overflow-scrolling: touch;
            }
            .tab-content[data-content="0"] .specs-sections-wrap .spec-section,
            .tab-content[data-content="0"] .specs-sections-wrap .spec-item.insurance-item {
                flex: 0 0 auto;
                width: 100%;
                min-width: 0;
                margin-bottom: 0;
            }
        }

        .spec-section-header {
            display: flex;
            margin: 0;
        }

        .spec-list li {
            padding: 12px 15px;
            margin-bottom: 10px;
            background: white;
            border-radius: 8px;
            border-right: 3px solid #127664;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .spec-list li:before {
            content: "✓";
            color: #127664;
            font-weight: bold;
            margin-left: 10px;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #fff3cd;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #ffc107;
        }

        .spec-item .spec-icon {
            flex-shrink: 0;
        }

        .spec-item .spec-text {
            color: #856404;
            font-weight: 500;
        }

        /* Reviews Tab Styles */
        .reviews-placeholder {
            padding: 40px;
            text-align: center;
            background: #f8f9fa;
            border-radius: 10px;
            color: #666;
        }

        /* Add Review Form Styles */
        .add-review-section {
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .add-review-section:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .rating-input {
            display: flex;
            align-items: center;
        }

        .stars-input {
            display: inline-flex;
            gap: 5px;
        }

        .star-clickable {
            transition: all 0.2s ease;
        }

        .star-clickable:hover {
            transform: scale(1.2);
        }

        .star-clickable.active {
            color: #FFA500 !important;
        }

        .star-clickable.inactive {
            color: #d3d3d3 !important;
        }

        .rating-text {
            font-weight: 600;
            color: #127664;
        }

        .review-item {
            transition: all 0.3s ease;
        }

        .review-item:hover {
            background-color: #f8f9fa;
            padding-left: 10px;
        }

        /* Map Styles */
        .location-section {
            padding: 20px;
        }

        .address-section {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .address-section h4 {
            color: #127664;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .address-section p {
            margin: 0;
            color: #333;
            font-size: 16px;
        }

        .nearby-section {
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            margin-bottom: 25px;
        }

        .nearby-section h4 {
            color: #127664;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .map-section {
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .map-section h4 {
            color: #127664;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Terms Tab Styles */
        .terms-section {
            padding: 20px;
        }

        .terms-section h4 {
            color: #127664;
            font-weight: 600;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .terms-section .spec-list {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .rules-content {
            padding: 25px;
            background: #f8f9fa;
            border-radius: 10px;
            line-height: 2;
            color: #333;
            white-space: pre-line;
        }

        .location-section .map-container {
            margin-top: 20px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .location-section .map-container iframe {
            width: 100%;
            height: 450px;
            border: none;
        }

        .nearby-places-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .nearby-place-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #127664;
        }

        .nearby-place-item .place-icon {
            color: #127664;
            font-size: 20px;
        }

        .nearby-place-item .place-info {
            flex: 1;
        }

        .nearby-place-item .place-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }

        .nearby-place-item .place-distance {
            font-size: 13px;
            color: #666;
        }

        /* Property Card Responsive Fixes */
        .property-card-section {
            overflow-x: hidden;
        }

        .property-card-header {
            flex-wrap: wrap;
            gap: 15px;
        }

        .property-card-title {
            word-break: break-word;
            max-width: 100%;
        }

        .container-fluid {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        @media (min-width: 768px) {
            .container-fluid {
                padding-left: 40px !important;
                padding-right: 40px !important;
            }
        }

        @media (min-width: 1200px) {
            .container-fluid {
                padding-left: 80px !important;
                padding-right: 80px !important;
            }
        }

        /* Host Details Link Styles */
        .host-details-link {
            transition: all 0.3s ease;
        }

        .host-details-link:hover {
            background: #e8f5f2 !important;
            transform: translateX(-5px);
        }

        .host-details-link a {
            transition: all 0.3s ease;
        }

        .host-details-link a:hover {
            color: #0e5c4e !important;
        }

        /* Action Buttons Styles */
        .property-card-actions {
            display: flex;
            gap: 15px;
        }

        .btn-action {
            background: white;
            border: 1.5px solid #e5e7eb;
            color: #333;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-action.btn-favorite:hover {
            background: #fff5f5;
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-action.btn-favorite:hover svg path {
            stroke: #dc3545;
            fill: #dc3545;
        }

        .btn-action.btn-share:hover {
            background: #f0f9ff;
            border-color: #127664;
            color: #127664;
        }

        .btn-action.btn-share:hover svg path {
            stroke: #127664;
        }

        .btn-action.active {
            background: #fff5f5;
            border-color: #dc3545;
            color: #dc3545;
        }

        .toast-notification {
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
        }

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

        .toast-notification.success {
            border-left: 4px solid #28a745;
        }

        .toast-notification.error {
            border-left: 4px solid #dc3545;
        }

        .toast-icon {
            font-size: 24px;
        }

        .toast-notification.success .toast-icon {
            color: #28a745;
        }

        .toast-notification.error .toast-icon {
            color: #dc3545;
        }

        /* شاشات متوسطة فقط (من 992px إلى 1400px) - لا نطبّق على الموبايل */
        @media (min-width: 992px) and (max-width: 1400px) {
            .booking-card-section .col-lg-8 {
                flex: 0 0 60% !important;
                max-width: 60% !important;
            }

            .booking-card-section .col-lg-4 {
                flex: 0 0 38% !important;
                max-width: 38% !important;
            }
        }

        @media (max-width: 768px) {
            .property-card-header {
                flex-direction: column;
                align-items: stretch;
            }

            .property-card-title {
                font-size: 20px;
                margin-bottom: 15px;
            }

            .btn-wishlist-main {
                width: 100%;
                justify-content: center;
            }

            .property-features-row {
                flex-direction: column;
                gap: 10px;
            }

            .feature-item {
                width: 100%;
            }

            .property-card-actions {
                width: 100%;
                display: flex;
                gap: 10px;
                margin-top: 15px;
            }

            .btn-action {
                flex: 1;
                padding: 8px 12px;
                font-size: 13px;
            }
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .booking-card {
                padding: 15px !important;
            }

            .date-input-group,
            .time-selection-section {
                grid-template-columns: 1fr !important;
            }

            .whatsapp-button {
                font-size: 14px;
                padding: 10px;
            }

            .whatsapp-button svg {
                width: 20px;
                height: 20px;
            }

            .price-amount {
                font-size: 22px;
            }

            .specs-tabs-navigation {
                padding: 0 10px;
                gap: 8px;
                margin-bottom: 15px;
                flex-wrap: nowrap;
            }

            .tab-btn {
                padding: 12px 14px;
                font-size: 13px;
                flex-shrink: 0;
            }
        }

        /* Fix for booking form inputs on small screens */
        @media (max-width: 400px) {
            .date-input label,
            .time-label {
                font-size: 12px;
            }

            .date-input input,
            .time-item input {
                padding: 8px 10px;
                font-size: 14px;
            }

            .btn-confirm {
                padding: 12px;
                font-size: 14px;
            }
        }

        /* Ensure booking card doesn't overflow */
        .booking-card {
            max-width: 100%;
            overflow: hidden;
        }

        .booking-card * {
            max-width: 100%;
        }

        /* New Booking Card Styles */
        .booking-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
        }

        .sticky-card {
            position: sticky;
            top: 20px;
        }

        .price-section {
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }

        .price-main {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .price-amount {
            font-size: 32px;
            font-weight: 700;
            color: #127664;
        }

        .price-currency {
            font-size: 16px;
            color: #666;
        }

        .price-total {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .whatsapp-contact-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #25D366;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        .whatsapp-contact-btn:hover {
            background: #20BD5C;
            color: white;
            transform: translateY(-2px);
        }

        .call-contact-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #3b82f6;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        .call-contact-btn:hover {
            background: #2563eb;
            color: white;
            transform: translateY(-2px);
        }

        .contact-sidebar-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .contact-card-title {
            color: #127664;
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .contact-card-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .contact-card-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .contact-card-btn {
            width: 100%;
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .contact-card-btn:hover {
            transform: translateY(-1px);
        }

        .contact-card-btn--whatsapp {
            background: #25D366;
            color: #fff;
            border: 1px solid #25D366;
        }

        .contact-card-btn--whatsapp:hover {
            background: #20BD5C;
            color: #fff;
        }

        .contact-card-btn--call {
            background: #fff;
            color: #127664;
            border: 1px solid #127664;
        }

        .contact-card-btn--call:hover {
            background: rgba(18, 118, 100, 0.08);
            color: #127664;
        }

      

        .contact-buttons-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .instagram-contact-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }
        .instagram-contact-btn:hover {
            color: white;
            transform: translateY(-2px);
            opacity: 0.95;
        }

        .tiktok-contact-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #000000;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }
        .tiktok-contact-btn:hover {
            color: white;
            background: #333;
            transform: translateY(-2px);
        }

        .date-selection-section {
            margin-bottom: 20px;
        }

        .section-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .date-modify-text {
            font-size: 12px;
            color: #999;
        }

        .date-picker-wrapper {
            display: flex;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .date-item {
            flex: 1;
            padding: 12px;
            cursor: pointer;
            position: relative;
            transition: background 0.3s;
        }

        .date-item:hover {
            background: #f8f9fa;
        }

        .date-divider {
            width: 1px;
            background: #e5e7eb;
        }

        .date-label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 4px;
        }

        .date-value {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .time-selection-section {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .time-item {
            flex: 1;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .time-label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 4px;
        }

        .time-value {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .btn-confirm {
            width: 100%;
            padding: 14px;
            background: #127664;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
        }

        .btn-confirm:hover {
            background: #0f5c4d;
            transform: translateY(-2px);
        }

        .price-breakdown {
            padding: 16px 0;
            border-top: 1px solid #e5e7eb;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .breakdown-value {
            font-weight: 600;
        }

        .total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-top: 1px solid #e5e7eb;
            margin-top: 12px;
        }

        .total-label {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .total-value {
            font-size: 20px;
            font-weight: 700;
            color: #127664;
        }

        .insurance-note {
            margin: 16px 0;
            padding: 12px;
            background: #fff3cd;
            border-radius: 8px;
            font-size: 13px;
            color: #856404;
            border: 1px solid #ffc107;
        }

        .payment-options {
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
        }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            margin-bottom: 8px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 13px;
            color: #666;
        }

        .payment-option img {
            height: 24px;
            width: auto;
        }

       /* ============================= */
/* Desktop Chalet Images Layout */
/* ============================= */

.desktop-grid-wrapper {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 12px;
    width: 100%;
}

/* الصورة الرئيسية */
.main-image-container {
    width: 100%;
    height: 100%;
}

.main-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

/* الصور الجانبية */
.side-images-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-auto-rows: 1fr;
    gap: 12px;
    height: 100%;
}

.side-image-item {
    width: 100%;
    height: 100%;
}

.side-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

/* ============================= */
/* Mobile (نتركه كما هو شغال) */
/* ============================= */

@media (max-width: 991px) {
    .desktop-images-layout {
        display: none !important;
    }
}


    </style>
@endsection

@section('content')

<!-- Success and Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mx-auto" style="max-width: 1200px; margin-top: 20px;" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mx-auto" style="max-width: 1200px; margin-top: 20px;" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mx-auto" style="max-width: 1200px; margin-top: 20px;" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Property Card Section -->
<div class="property-card-section chalet-details-page">
    <div class="container-fluid">
        <!-- Property Card Header -->
        <div class="property-card-header">
            <h2 class="property-card-title">{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}</h2>
        </div>

        <!-- Property Features Row -->


        <!-- ========== صور الشاليه ========== -->
        <div class="property-images-section">

            <!-- Desktop Layout - يظهر فقط على الشاشات الكبيرة -->
            <div class="desktop-images-layout d-none d-lg-block">
                @php
                    $additionalImages = $chalet->images->take(4);
                    $imageCount = $additionalImages->count();
                @endphp

                <div class="desktop-grid-wrapper">
                    <!-- الصورة الرئيسية -->
                    <div class="main-image-container">
                        <a href="{{ asset($chalet->main_image ?? 'no_image.png') }}"
                           class="glightbox"
                           data-gallery="chalet-gallery"
                           data-title="{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}">
                            <img src="{{ asset($chalet->main_image ?? 'no_image.png') }}"
                                 alt="{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}"
                                 class="main-image">
                        </a>
                    </div>

                    <!-- الصور الجانبية -->
                    <div class="side-images-container">
                        @if($imageCount > 0)
                            @foreach($additionalImages as $image)
                                <div class="side-image-item">
                                    <a href="{{ asset($image->image_path) }}"
                                       class="glightbox"
                                       data-gallery="chalet-gallery"
                                       data-title="{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}">
                                        <img src="{{ asset($image->image_path) }}"
                                             alt="{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}"
                                             class="side-image">
                                    </a>
                                </div>
                            @endforeach
                        @else
                            @for($i = 0; $i < 4; $i++)
                                <div class="side-image-item">
                                    <a href="{{ asset('no_image.png') }}"
                                       class="glightbox"
                                       data-gallery="chalet-gallery">
                                        <img src="{{ asset('no_image.png') }}"
                                             alt="No Image"
                                             class="side-image">
                                    </a>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            </div>

            <!-- Mobile Layout - يظهر فقط على الشاشات الصغيرة -->
            <div class="mobile-images-layout d-lg-none">
                @php
                    // جمع كل الصور في مصفوفة واحدة للموبايل
                    $allImages = collect([]);
                    if($chalet->main_image) {
                        $allImages->push([
                            'url' => asset($chalet->main_image),
                            'path' => $chalet->main_image,
                            'title' => $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en
                        ]);
                    }

                    if($chalet->images && $chalet->images->count() > 0) {
                        foreach($chalet->images as $image) {
                            $allImages->push([
                                'url' => asset($image->image_path),
                                'path' => $image->image_path,
                                'title' => $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en
                            ]);
                        }
                    }

                    if($allImages->isEmpty()) {
                        $allImages->push([
                            'url' => asset('no_image.png'),
                            'path' => 'no_image.png',
                            'title' => 'No Image'
                        ]);
                    }
                @endphp

                <!-- الصورة الرئيسية على الموبايل -->
                <div class="mobile-main-image-container">
                    <a href="{{ $allImages[0]['url'] }}"
                       class="glightbox mobile-main-link"
                       data-gallery="chalet-gallery-mobile"
                       data-title="{{ $allImages[0]['title'] }}">
                        <img src="{{ $allImages[0]['url'] }}"
                             id="mobile-main-image"
                             alt="{{ $allImages[0]['title'] }}"
                             class="mobile-main-img">
                    </a>
                </div>

                <!-- الثمبنات المصغرة -->
                @if($allImages->count() > 1)
                <div class="mobile-thumbnails-container">
                    @foreach($allImages as $index => $image)
                    <a href="{{ $image['url'] }}"
                       class="glightbox mobile-thumb-link"
                       data-gallery="chalet-gallery-mobile"
                       data-title="{{ $image['title'] }}">
                        <div class="mobile-thumbnail-item {{ $index == 0 ? 'active' : '' }}"
                             onclick="changeMobileImage('{{ $image['url'] }}', '{{ $image['title'] }}', this)">
                            <img src="{{ $image['url'] }}"
                                 alt="Image {{ $index + 1 }}"
                                 class="mobile-thumb-img">
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        <!-- ========== نهاية صور الشاليه ========== -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="property-features-row">
                <div class="feature-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 1.66667L12.575 6.88333L18.3333 7.725L14.1667 11.7833L15.15 17.5167L10 14.8083L4.85 17.5167L5.83333 11.7833L1.66667 7.725L7.425 6.88333L10 1.66667Z" fill="#FFA500" stroke="#FFA500" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="feature-value">{{ $averageRating }}</span>
                    <span class="feature-label rating-count">({{ $totalReviews }} {{ $isArabic ? 'تقييم' : 'reviews' }})</span>
                </div>
                <div class="feature-item">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.8 6.6C5.3464 6.6 6.6 5.3464 6.6 3.8C6.6 2.2536 5.3464 1 3.8 1C2.2536 1 1 2.2536 1 3.8C1 5.3464 2.2536 6.6 3.8 6.6Z" stroke="#127664" stroke-width="1.5"/>
                        <path d="M13.0004 11.4H15.4004C16.2804 11.4 17.0004 12.12 17.0004 13V15.4C17.0004 16.28 16.2804 17 15.4004 17H13.0004C12.1204 17 11.4004 16.28 11.4004 15.4V13C11.4004 12.12 12.1204 11.4 13.0004 11.4Z" stroke="#127664" stroke-width="1.5"/>
                        <path d="M9.02417 3.40002H11.1682C12.6482 3.40002 13.3362 5.23202 12.2242 6.20802L5.83217 11.8C4.72017 12.768 5.40817 14.6 6.88017 14.6H9.02417" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.81358 3.80002H3.82283" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14.214 14.2H14.2232" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="feature-label">{{ $isArabic ? $chalet->city->name_ar : $chalet->city->name_en }} - {{ $isArabic ? $chalet->area->name_ar : $chalet->area->name_en }}</span>
                </div>
                <div class="feature-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="feature-label">{{ $isArabic ? 'العقار مخصص: ' . $chalet->dedicated_to_label : 'Dedicated to: ' . $chalet->dedicated_to_label }}</span>
                </div>
                <div class="feature-item">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.8204 5.12022C13.7723 5.11221 13.7162 5.11221 13.6681 5.12022C12.5622 5.08015 11.6807 4.17457 11.6807 3.0526C11.6807 1.9066 12.6023 0.984985 13.7483 0.984985C14.8943 0.984985 15.8159 1.91461 15.8159 3.0526C15.8079 4.17457 14.9263 5.08015 13.8204 5.12022Z" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12.9947 10.9545C14.0927 11.1388 15.3028 10.9465 16.1523 10.3775C17.2823 9.62415 17.2823 8.38999 16.1523 7.63667C15.2948 7.06768 14.0686 6.87534 12.9707 7.06767" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4.18006 5.12022C4.22815 5.11221 4.28424 5.11221 4.33233 5.12022C5.43826 5.08015 6.31981 4.17457 6.31981 3.0526C6.31981 1.9066 5.3982 0.984985 4.25219 0.984985C3.10618 0.984985 2.18457 1.91461 2.18457 3.0526C2.19258 4.17457 3.07413 5.08015 4.18006 5.12022Z" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.00501 10.9545C3.90709 11.1388 2.69697 10.9465 1.84748 10.3775C0.717506 9.62415 0.717506 8.38999 1.84748 7.63667C2.70498 7.06768 3.93113 6.87534 5.02905 7.06767" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.01181 11.1067C8.96373 11.0987 8.90763 11.0987 8.85955 11.1067C7.75361 11.0666 6.87207 10.161 6.87207 9.03905C6.87207 7.89305 7.79368 6.97144 8.93969 6.97144C10.0857 6.97144 11.0073 7.90106 11.0073 9.03905C10.9993 10.161 10.1177 11.0746 9.01181 11.1067Z" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.67951 13.6311C5.54954 14.3844 5.54954 15.6185 6.67951 16.3719C7.96176 17.2294 10.0614 17.2294 11.3437 16.3719C12.4737 15.6185 12.4737 14.3844 11.3437 13.6311C10.0694 12.7816 7.96176 12.7816 6.67951 13.6311Z" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="feature-label">{{ $isArabic ? 'يتسع لـ ' . ($chalet->max_guests ?? 20) . ' ضيف' : 'Accommodates ' . ($chalet->max_guests ?? 20) . ' guests' }}</span>
                </div>
            </div>
            <div class="property-card-actions">
                @php
                    $isInWishlist = auth('customer')->check()
                        ? auth('customer')->user()->wishlist()->where('chalet_id', $chalet->id)->exists()
                        : false;
                @endphp
                    <button class="btn-action btn-favorite" id="wishlistBtn" data-chalet-id="{{ $chalet->id }}">
                        @if($isInWishlist)
                            <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.275 22.8888C13.85 23.0371 13.15 23.0371 12.725 22.8888C9.1 21.6652 1 16.5607 1 7.90899C1 4.08989 4.1125 1 7.95 1C10.225 1 12.2375 2.08764 13.5 3.76854C14.7625 2.08764 16.7875 1 19.05 1C22.8875 1 26 4.08989 26 7.90899C26 16.5607 17.9 21.6652 14.275 22.8888Z" fill="#dc3545" stroke="#dc3545" stroke-width="2"/>
                            </svg>
                            <span>{{ $isArabic ? 'في المفضلة' : 'In Favorites' }}</span>
                        @else
                            <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.275 22.8888C13.85 23.0371 13.15 23.0371 12.725 22.8888C9.1 21.6652 1 16.5607 1 7.90899C1 4.08989 4.1125 1 7.95 1C10.225 1 12.2375 2.08764 13.5 3.76854C14.7625 2.08764 16.7875 1 19.05 1C22.8875 1 26 4.08989 26 7.90899C26 16.5607 17.9 21.6652 14.275 22.8888Z" stroke="#159265" stroke-width="2"/>
                            </svg>
                            <span>{{ $isArabic ? 'المفضلة' : 'Favorite' }}</span>
                        @endif
                    </button>

                <button class="btn-action btn-share" onclick="shareChalet()">
                    <svg width="23" height="25" viewBox="0 0 23 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.5 2.53333V15.5667M16 5.6L11.5 1L7 5.6M1 13.2667V20.9333C1 21.7467 1.31607 22.5267 1.87868 23.1018C2.44129 23.6769 3.20435 24 4 24H19C19.7956 24 20.5587 23.6769 21.1213 23.1018C21.6839 22.5267 22 21.7467 22 20.9333V13.2667" stroke="#127664" stroke-width="1.8"/>
                    </svg>
                    <span>{{ $isArabic ? 'مشاركة' : 'Share' }}</span>
                </button>

                <button type="button"
                        class="btn btn-sm report-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#reportModal">
                    <i class="fa fa-flag"></i>
                    {{ $isArabic ? 'الإبلاغ عن مخالفة عقارية' : 'Report Violation' }}
                </button>

            </div>
        </div>
<!-- باقي الكود كما هو في الملف الأصلي -->
        <!-- Mobile Header -->
{{--    <div class="mobile-header" style="padding: 15px; background: white; border-bottom: 1px solid #e5e7eb;">--}}
{{--        <h1 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 8px; color: #1a1a1a;">--}}
{{--            {{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}--}}
{{--        </h1>--}}
{{--        <div style="display: flex; align-items: center; gap: 8px; color: #666; font-size: 0.9rem;">--}}
{{--            <i class="fas fa-map-marker-alt" style="color: #127664;"></i>--}}
{{--            <span>{{ $isArabic ? $chalet->city->name_ar : $chalet->city->name_en }} - {{ $isArabic ? $chalet->area->name_ar : $chalet->area->name_en }}</span>--}}
{{--        </div>--}}
{{--        <div style="display: flex; align-items: center; gap: 15px; margin-top: 10px;">--}}
{{--            <div style="display: flex; align-items: center; gap: 5px;">--}}
{{--                <div style="color: #FFA500;">--}}
{{--                    @for($i = 1; $i <= 5; $i++)--}}
{{--                        @if($i <= floor($averageRating))--}}
{{--                            <i class="fas fa-star"></i>--}}
{{--                        @elseif($i - 0.5 <= $averageRating)--}}
{{--                            <i class="fas fa-star-half-alt"></i>--}}
{{--                        @else--}}
{{--                            <i class="far fa-star"></i>--}}
{{--                        @endif--}}
{{--                    @endfor--}}
{{--                </div>--}}
{{--                <span style="font-weight: 600;">{{ $averageRating }}</span>--}}
{{--                <span style="color: #999; font-size: 0.85rem;">({{ $totalReviews }})</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Mobile Features - تنسيق الأيقونات -->
    <div class="property-mobile-features" style="display: flex; flex-wrap: wrap; justify-content: space-around; gap: 12px; padding: 15px; background: #f8f9fa; border-bottom: 1px solid #e5e7eb;">
        @if($chalet->max_guests)
        <div style="text-align: center;">
            <i class="fas fa-users" style="color: #127664; font-size: 1.2rem;"></i>
            <div style="font-size: 0.75rem; color: #666; margin-top: 5px;">{{ $chalet->max_guests }} {{ $isArabic ? 'ضيف' : 'Guests' }}</div>
        </div>
        @endif
        @if($chalet->bedrooms)
        <div style="text-align: center;">
            <i class="fas fa-bed" style="color: #127664; font-size: 1.2rem;"></i>
            <div style="font-size: 0.75rem; color: #666; margin-top: 5px;">{{ $chalet->bedrooms }} {{ $isArabic ? 'غرف' : 'Rooms' }}</div>
        </div>
        @endif
        @if($chalet->bathrooms)
        <div style="text-align: center;">
            <i class="fas fa-bath" style="color: #127664; font-size: 1.2rem;"></i>
            <div style="font-size: 0.75rem; color: #666; margin-top: 5px;">{{ $chalet->bathrooms }} {{ $isArabic ? 'حمامات' : 'Baths' }}</div>
        </div>
        @endif
        @if($chalet->dedicated_to)
        <div style="text-align: center;">
            <i class="fas fa-user-friends" style="color: #127664; font-size: 1.2rem;"></i>
            <div style="font-size: 0.75rem; color: #666; margin-top: 5px;">{{ $chalet->dedicated_to_label }}</div>
        </div>
        @endif
        @if($chalet->councils_count)
        <div style="text-align: center;">
            <i class="fas fa-couch" style="color: #127664; font-size: 1.2rem;"></i>
            <div style="font-size: 0.75rem; color: #666; margin-top: 5px;">{{ $chalet->councils_count }} {{ $isArabic ? 'مجلس' : 'Majlis' }}</div>
        </div>
        @endif
    </div>



    <!-- Mobile Similar Chalets Section -->
    @php
        $similarChalets = \App\Models\Chalet::where('city_id', $chalet->city_id)
            ->where('id', '!=', $chalet->id)
            ->where('status', 'active')
            ->take(4)
            ->get();
    @endphp
    @if($similarChalets->count() > 0)
    <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
        <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
            {{ $isArabic ? 'شاليهات مشابهة' : 'Similar Chalets' }}
        </h2>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
            @foreach($similarChalets->take(4) as $similar)
            <a href="{{ route('chalet.show', $similar->slug) }}" style="text-decoration: none; color: inherit;">
                <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                    <img src="{{ asset($similar->main_image ?? 'no_image.png') }}"
                         style="width: 100%; height: 100px; object-fit: cover;">
                    <div style="padding: 8px;">
                        <div style="font-size: 0.85rem; font-weight: 500; color: #1a1a1a; margin-bottom: 4px;
                                    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $isArabic ? $similar->chalet_name_ar : $similar->chalet_name_en }}
                        </div>
                        <div style="font-size: 0.75rem; color: #666; margin-bottom: 4px;">
                            <i class="fas fa-map-marker-alt" style="font-size: 0.7rem;"></i>
                            {{ $isArabic ? $similar->area->name_ar : $similar->area->name_en }}
                        </div>
                        <div style="font-size: 0.9rem; font-weight: 600; color: #127664;">
                            {{ number_format($similar->price_per_night, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- WhatsApp Floating Button -->
    @if($whatsappLink)
    <a href="{{ $whatsappLink }}"
       target="_blank"
       class="whatsapp-fab-mobile"
       style="position: fixed; bottom: calc(72px + env(safe-area-inset-bottom, 0px)); right: 16px; width: 52px; height: 52px; background: #25D366; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 999; text-decoration: none;">
        <i class="fab fa-whatsapp" style="color: white; font-size: 26px;"></i>
    </a>
    @endif

    <!-- Mobile Booking Bar (Fixed Bottom) - يظهر على الموبايل فقط -->
    {{-- <div class="mobile-booking-bar d-lg-none" style="position: fixed; bottom: 0; left: 0; right: 0; background: white; padding: 12px 15px; padding-bottom: calc(12px + env(safe-area-inset-bottom, 0px)); box-shadow: 0 -2px 10px rgba(0,0,0,0.1); z-index: 1000; display: flex; justify-content: space-between; align-items: center; min-height: 64px;">
        <div class="mobile-price" style="display: flex; flex-direction: column; justify-content: center; min-height: 44px;">
            <span class="mobile-price-amount" style="font-size: 1.25rem; font-weight: 700; color: #127664; line-height: 1.2;">
                @if($chalet->default_day_price)
                    {{ number_format($chalet->default_day_price, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}
                @else
                    {{ $isArabic ? 'السعر غير محدد' : 'Price not set' }}
                @endif
            </span>
            <span class="mobile-price-period" style="font-size: 0.75rem; color: #666; line-height: 1.3;">{{ $isArabic ? 'لليلة الواحدة' : 'per night' }}</span>
        </div>
        <button type="button" onclick="window.showMobileBookingModal()" style="background: #127664; color: white; padding: 12px 20px; border-radius: 8px; font-weight: 600; border: none; font-size: 0.95rem; cursor: pointer; flex-shrink: 0;">
            {{ $isArabic ? 'اعرض الآن' : 'Book Now' }}
        </button>
    </div> --}}
</div>

<!-- Main Content + Booking Sidebar (Content visible on mobile, sidebar only on desktop) -->
<div class="booking-card-section">
    <div class="container-fluid px-2 px-sm-3">
        <div class="row">
            <div class="col-12 col-lg-8 mb-4">

                <!-- سعر واضح + خيارات نوع السعر (للموبايل فقط) -->
                {{-- <div class="price-in-content d-lg-none mb-3" style="padding: 16px; background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <span class="d-block small fw-600 mb-2" style="color: #333;">{{ $isArabic ? 'اختر نوع السعر' : 'Select price type' }}</span>
                    <div class="mobile-price-options-inline d-flex flex-column gap-2 mb-3">
                        <label class="mobile-price-inline-opt border rounded-2 p-3 mb-0 d-flex align-items-center justify-content-between" data-type="fullDay" data-price="{{ $chalet->default_day_price ?? 0 }}" style="cursor: pointer; border-width: 2px !important; border-color: #127664 !important; background: rgba(18, 118, 100, 0.08);">
                            <span>{{ $isArabic ? 'يوم كامل' : 'Full day' }}</span>
                            <span class="fw-bold" style="color: #127664;">{{ number_format($chalet->default_day_price ?? 0, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                        </label>
                        <label class="mobile-price-inline-opt border rounded-2 p-3 mb-0 d-flex align-items-center justify-content-between" data-type="stayDay" data-price="{{ $chalet->stay_price ?? 0 }}" style="cursor: pointer; border-color: #e5e7eb;">
                            <span>{{ $isArabic ? 'يوم كامل مع مبيت' : 'Full day with overnight' }}</span>
                            <span class="fw-bold" style="color: #127664;">{{ number_format($chalet->stay_price ?? 0, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                        </label>
                        <label class="mobile-price-inline-opt border rounded-2 p-3 mb-0 d-flex align-items-center justify-content-between" data-type="halfDay" data-price="{{ $chalet->half_day_price ?? 0 }}" style="cursor: pointer; border-color: #e5e7eb;">
                            <span>{{ $isArabic ? 'نصف يوم' : 'Half day' }}</span>
                            <span class="fw-bold" style="color: #127664;">{{ number_format($chalet->half_day_price ?? 0, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                        </label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <span class="d-block text-muted small">{{ $isArabic ? 'السعر المختار' : 'Selected price' }}</span>
                            <span class="fs-4 fw-bold mobile-selected-price" style="color: #127664 !important;">{{ number_format($chalet->default_day_price ?? 0, 0) }}</span>
                            <span class="text-muted small">{{ $isArabic ? ' ر.ع' : ' OMR' }}</span>
                        </div>
                        <button type="button" onclick="window.showMobileBookingModal()" class="btn btn-success d-none d-md-inline-block" style="background: #127664; border-color: #127664;">{{ $isArabic ? 'اعرض الآن' : 'Book Now' }}</button>
                    </div>
                </div>
                <input type="hidden" id="mobile-selected-booking-type" value="fullDay">
                <input type="hidden" id="mobile-selected-price" value="{{ $chalet->default_day_price ?? 0 }}"> --}}

                <!-- Mobile Description Section -->
                <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
                    <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
                        {{ $isArabic ? 'أبرز المميزات ولمحة عن المكان' : 'Highlights & Overview' }}
                    </h2>
                    @php
                        $mobileDescription = $chalet->long_description_ar ?: $chalet->long_description_en ?? null;
                    @endphp
                    @if($mobileDescription)
                        <div style="font-size: 0.9rem; line-height: 1.6; color: #444; white-space: pre-line;">{!! nl2br(e($mobileDescription)) !!}</div>
                    @else
                        <p style="font-size: 0.9rem; color: #888;">{{ $isArabic ? 'لا يوجد وصف مفصل حالياً.' : 'No detailed description available.' }}</p>
                    @endif
                </div>


                @php
                    // Check if amenities is a string (JSON) or array
                    if (is_string($chalet->amenities)) {
                        $amenities = json_decode($chalet->amenities, true) ?? [];
                    } elseif (is_array($chalet->amenities)) {
                        $amenities = $chalet->amenities;
                    } else {
                        $amenities = [];
                    }
                @endphp

                @if(!empty($amenities))
                    <!-- Mobile Amenities Section -->
                    <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
                        <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
                            {{ $isArabic ? 'المرافق والخدمات' : 'Amenities & Services' }}
                        </h2>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                            @foreach($amenities as $amenity)
                                @php
                                    $amenityData = [
                                        'wifi' => ['icon' => 'fa-wifi', 'name_ar' => 'واي فاي', 'name_en' => 'WiFi'],
                                        'pool' => ['icon' => 'fa-swimming-pool', 'name_ar' => 'مسبح', 'name_en' => 'Pool'],
                                        'ac' => ['icon' => 'fa-snowflake', 'name_ar' => 'تكييف', 'name_en' => 'AC'],
                                        'parking' => ['icon' => 'fa-parking', 'name_ar' => 'موقف', 'name_en' => 'Parking'],
                                        'kitchen' => ['icon' => 'fa-utensils', 'name_ar' => 'مطبخ', 'name_en' => 'Kitchen'],
                                        'tv' => ['icon' => 'fa-tv', 'name_ar' => 'تلفزيون', 'name_en' => 'TV'],
                                        'garden' => ['icon' => 'fa-tree', 'name_ar' => 'حديقة', 'name_en' => 'Garden'],
                                        'bbq' => ['icon' => 'fa-fire', 'name_ar' => 'شواء', 'name_en' => 'BBQ'],
                                        'washing_machine' => ['icon' => 'fa-tshirt', 'name_ar' => 'غسالة', 'name_en' => 'Washer'],
                                        'balcony' => ['icon' => 'fa-building', 'name_ar' => 'شرفة', 'name_en' => 'Balcony'],
                                        'beach' => ['icon' => 'fa-umbrella-beach', 'name_ar' => 'شاطئ', 'name_en' => 'Beach'],
                                        'gym' => ['icon' => 'fa-dumbbell', 'name_ar' => 'صالة رياضية', 'name_en' => 'Gym']
                                    ];

                                    // Get amenity info or use default
                                    $info = $amenityData[$amenity] ?? ['icon' => 'fa-check', 'name_ar' => $amenity, 'name_en' => $amenity];
                                @endphp
                                <div style="text-align: center; padding: 10px; background: #f8f9fa; border-radius: 8px;">
                                    <i class="fas {{ $info['icon'] }}" style="font-size: 1.5rem; color: #127664; margin-bottom: 5px;"></i>
                                    <div style="font-size: 0.7rem; color: #666;">{{ $isArabic ? $info['name_ar'] : $info['name_en'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Mobile Additional Details Section -->
                @if($chalet->check_in_time || $chalet->check_out_time || $chalet->minimum_stay || $chalet->maximum_stay)
                    <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
                        <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
                            {{ $isArabic ? 'تواقيت العرض' : 'Booking Times' }}
                        </h2>
                        <div style="display: grid; gap: 10px;">
                            @if($chalet->check_in_time)
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-sign-in-alt" style="color: #127664; width: 20px;"></i>
                                    <span style="font-size: 0.9rem; color: #444;">{{ $isArabic ? 'وقت تسجيل الدخول:' : 'Check-in:' }} {{ date('g:i A', strtotime($chalet->check_in_time ?? '15:00')) }}</span>
                                </div>
                            @endif
                            @if($chalet->check_out_time)
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-sign-out-alt" style="color: #127664; width: 20px;"></i>
                                    <span style="font-size: 0.9rem; color: #444;">{{ $isArabic ? 'وقت تسجيل الخروج:' : 'Check-out:' }} {{ date('g:i A', strtotime($chalet->check_out_time ?? '12:00')) }}</span>
                                </div>
                            @endif
                            @if($chalet->minimum_stay)
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-calendar-minus" style="color: #127664; width: 20px;"></i>
                                    <span style="font-size: 0.9rem; color: #444;">{{ $isArabic ? 'الحد الأدنى للإقامة:' : 'Minimum stay:' }} {{ $chalet->minimum_stay }} {{ $isArabic ? 'ليالي' : 'nights' }}</span>
                                </div>
                            @endif
                            @if($chalet->maximum_stay)
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-calendar-plus" style="color: #127664; width: 20px;"></i>
                                    <span style="font-size: 0.9rem; color: #444;">{{ $isArabic ? 'الحد الأقصى للإقامة:' : 'Maximum stay:' }} {{ $chalet->maximum_stay }} {{ $isArabic ? 'ليالي' : 'nights' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Mobile Rules Section -->
                @if($chalet->house_rules_ar || $chalet->house_rules_en || $chalet->cancellation_policy_ar || $chalet->cancellation_policy_en)
                    <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
                        <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
                            {{ $isArabic ? 'قواعد الإقامة' : 'House Rules' }}
                        </h2>
                        @if(($isArabic && $chalet->house_rules_ar) || (!$isArabic && $chalet->house_rules_en))
                            <div style="font-size: 0.9rem; color: #444; line-height: 1.6;">
                                {!! nl2br($isArabic ? $chalet->house_rules_ar : $chalet->house_rules_en) !!}
                            </div>
                        @endif

                        @if(($isArabic && $chalet->cancellation_policy_ar) || (!$isArabic && $chalet->cancellation_policy_en))
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #f0f0f0;">
                                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 8px; color: #1a1a1a;">
                                    {{ $isArabic ? 'سياسة الإلغاء' : 'Cancellation Policy' }}
                                </h3>
                                <div style="font-size: 0.9rem; color: #444; line-height: 1.6;">
                                    {!! nl2br($isArabic ? $chalet->cancellation_policy_ar : $chalet->cancellation_policy_en) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                @endif



                <!-- Mobile Owner Section (المالك + بيانات التواصل بداخله) -->
                <div class="d-lg-none" style="padding: 20px 15px; background: white; margin-bottom: 8px;">
                    <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
                        {{ $isArabic ? 'المالك' : 'Owner' }}
                    </h2>
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <img src="{{ asset($chalet->owner->image) }}" class="host-avatar" style="width: 40px;height: 40px;border-radius: 50%;object-fit: cover;">
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: #1a1a1a; margin-bottom: 4px;">{{ $chalet->owner->name ?? '' }}</div>
                            <div style="display: flex; align-items: center; gap: 5px; color: #666; font-size: 0.85rem;">
                                <div style="color: #FFA500;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($ownerRating))
                                            <i class="fas fa-star" style="font-size: 0.8rem;"></i>
                                        @else
                                            <i class="far fa-star" style="font-size: 0.8rem;"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span>{{ $ownerRating }} ({{ $ownerTotalReviews }} {{ $isArabic ? 'تقييم' : 'reviews' }})</span>
                            </div>
                            <div style="font-size: 0.8rem; color: #127664; margin-top: 4px;">
                                <i class="fas fa-shield-alt"></i> {{ $isArabic ? 'مالك موثق' : 'Verified Owner' }}
                            </div>
                        </div>
                    </div>
                    @if($chalet->show_contact_icon && ($chalet->phone_link || $chalet->whatsapp_link) || $chalet->instagram_url || $chalet->tiktok_url)
                    <div class="contact-buttons-wrap" style="flex-wrap: wrap; gap: 10px; padding-top: 12px; border-top: 1px solid #eee;">
                        @if($chalet->show_contact_icon && $chalet->phone_link)
                            <a href="{{ $chalet->phone_link }}" class="call-contact-btn d-flex align-items-center">
                                <i class="fas fa-phone" style="color: white; font-size: 18px;"></i>
                                <span style="margin-left:5px;">{{ $isArabic ? 'اتصال' : 'Call' }}</span>
                            </a>
                        @endif
                        @if($chalet->show_contact_icon && $chalet->whatsapp_link)
                            <a href="{{ $chalet->whatsapp_link }}?text={{ urlencode($isArabic ? 'مرحباً، أرغب في الاستفسار عن: ' . $chalet->chalet_name_ar : 'Hello, I would like to inquire about: ' . $chalet->chalet_name_en) }}" class="whatsapp-contact-btn d-flex align-items-center" target="_blank">
                                <i class="fab fa-whatsapp" style="font-size: 18px;"></i>
                                <span style="margin-left:5px;">{{ $isArabic ? 'واتساب' : 'WhatsApp' }}</span>
                            </a>
                        @endif
                        @if($chalet->instagram_url)
                            <a href="{{ $chalet->instagram_url }}" class="instagram-contact-btn d-flex align-items-center" target="_blank" rel="noopener">
                                <i class="fab fa-instagram" style="font-size: 18px;"></i>
                                <span style="margin-left:5px;">{{ $isArabic ? 'انستجرام' : 'Instagram' }}</span>
                            </a>
                        @endif
                        @if($chalet->tiktok_url)
                            <a href="{{ $chalet->tiktok_url }}" class="tiktok-contact-btn d-flex align-items-center" target="_blank" rel="noopener">
                                <i class="fab fa-tiktok" style="font-size: 18px;"></i>
                                <span style="margin-left:5px;">{{ $isArabic ? 'تيك توك' : 'TikTok' }}</span>
                            </a>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Mobile Guarantee Section -->
                {{--    <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">--}}
                {{--        <div style="background: linear-gradient(135deg, #127664 0%, #0d5a4f 100%); padding: 20px; border-radius: 12px; color: white;">--}}
                {{--            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">--}}
                {{--                <i class="fas fa-shield-alt" style="font-size: 1.5rem;"></i>--}}
                {{--                <div>--}}
                {{--                    <h3 style="margin: 0; font-size: 1rem; font-weight: 600;">{{ $isArabic ? 'ضمان ويكند عمان' : 'Weekend Oman Guarantee' }}</h3>--}}
                {{--                    <p style="margin: 0; font-size: 0.75rem; opacity: 0.9;">{{ $isArabic ? 'حجزك محمي بضماناتنا' : 'Your booking is protected by our guarantees' }}</p>--}}
                {{--                </div>--}}
                {{--            </div>--}}
                {{--            <div style="display: grid; grid-template-columns: 1fr; gap: 10px;">--}}
                {{--                <div style="display: flex; align-items: center; gap: 8px;">--}}
                {{--                    <i class="fas fa-check-circle" style="font-size: 0.9rem;"></i>--}}
                {{--                    <span style="font-size: 0.85rem;">{{ $isArabic ? 'دفع آمن 100%' : '100% Secure Payment' }}</span>--}}
                {{--                </div>--}}
                {{--                <div style="display: flex; align-items: center; gap: 8px;">--}}
                {{--                    <i class="fas fa-check-circle" style="font-size: 0.9rem;"></i>--}}
                {{--                    <span style="font-size: 0.85rem;">{{ $isArabic ? 'ضمان استرجاع المبلغ' : 'Money Back Guarantee' }}</span>--}}
                {{--                </div>--}}
                {{--                <div style="display: flex; align-items: center; gap: 8px;">--}}
                {{--                    <i class="fas fa-check-circle" style="font-size: 0.9rem;"></i>--}}
                {{--                    <span style="font-size: 0.85rem;">{{ $isArabic ? 'دعم على مدار الساعة' : '24/7 Support' }}</span>--}}
                {{--                </div>--}}
                {{--                <div style="display: flex; align-items: center; gap: 8px;">--}}
                {{--                    <i class="fas fa-check-circle" style="font-size: 0.9rem;"></i>--}}
                {{--                    <span style="font-size: 0.85rem;">{{ $isArabic ? 'عقارات مفحوصة' : 'Verified Properties' }}</span>--}}
                {{--                </div>--}}
                {{--            </div>--}}
                {{--        </div>--}}
                {{--    </div>--}}

                <!-- Mobile Reviews Section -->
                <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
                    <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
                        {{ $isArabic ? 'التقييمات' : 'Reviews' }}@if($totalReviews > 0) ({{ $totalReviews }})@endif
                    </h2>
                    @if($reviews && $reviews->count() > 0)
                        @foreach($reviews->take(3) as $review)
                            <div style="padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                    <div>
                                        <div style="font-weight: 500; color: #1a1a1a;">{{ $review->customer->name ?? 'Guest' }}</div>
                                        <div style="color: #FFA500; font-size: 0.8rem;">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <div style="font-size: 0.75rem; color: #999;">{{ $review->created_at->diffForHumans() }}</div>
                                </div>
                                <p style="font-size: 0.85rem; color: #666; margin: 0;">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    @else
                        <p style="font-size: 0.9rem; color: #666;">{{ $isArabic ? 'لا توجد تقييمات بعد' : 'No reviews yet' }}</p>
                    @endif
                </div>

                <!-- Mobile Location Section -->
                <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
                    <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
                        {{ $isArabic ? 'الموقع' : 'Location' }}
                    </h2>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <i class="fas fa-map-marker-alt" style="color: #127664; font-size: 1.2rem;"></i>
                            <div>
                                <div style="font-weight: 500; color: #1a1a1a;">{{ $isArabic ? $chalet->city->name_ar : $chalet->city->name_en }}</div>
                                <div style="font-size: 0.85rem; color: #666;">{{ $isArabic ? $chalet->area->name_ar : $chalet->area->name_en }}</div>
                            </div>
                        </div>
                        @php
                            $mapUrl = null;
                            if ($chalet->latitude && $chalet->longitude) {
                                $mapUrl = 'https://www.google.com/maps/search/?api=1&query=' . $chalet->latitude . ',' . $chalet->longitude;
                            } elseif ($chalet->map_link) {
                                $mapUrl = $chalet->map_link;
                            }
                        @endphp
                        @if($mapUrl)
                            <a href="{{ $mapUrl }}" target="_blank" rel="noopener"
                               style="display: inline-flex; align-items: center; gap: 8px; background: #127664; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; margin-top: 10px;">
                                <i class="fas fa-map-marked-alt"></i>
                                {{ $isArabic ? 'فتح في الخريطة' : 'Open in Maps' }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Guarantee Card -->
{{--                <div class="guarantee-card">--}}
{{--                    <div class="d-flex align-items-start justify-content-between">--}}
{{--                        <div class="guarantee-header">--}}
{{--                            <div class="guarantee-icon">--}}
{{--                                <img src="{{ asset('frontend/images/guarantee-logo.png') }}" alt="guarantee_logo">--}}
{{--                            </div>--}}
{{--                            <div class="guarantee-title mt-2">--}}
{{--                              --}}
{{--                                --}}
{{-- <div class="d-flex align-items-center gap-2">--}}
{{--    <h3 class="mb-0">--}}
{{--        {{ $isArabic ? 'ضمان ويكند عمان' : 'Weekend Oman Guarantee' }}--}}
{{--    </h3>--}}

{{--    <!-- Report Button -->--}}
{{--    <button type="button"--}}
{{--            class="btn btn-sm report-btn"--}}
{{--            data-bs-toggle="modal"--}}
{{--            data-bs-target="#reportModal">--}}
{{--        <i class="fa fa-flag"></i>--}}
{{--        {{ $isArabic ? 'الإبلاغ عن مخالفة عقارية' : 'Report Violation' }}--}}
{{--    </button>--}}
{{--</div>--}}
{{--                               --}}
{{--                                --}}
{{--                                <p>{{ $isArabic ? 'نضمن لك صحة المعلومات ونظافة المكان' : 'We guarantee accurate information and clean place' }}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <span>--}}
{{--                                <svg width="10" height="20" viewBox="0 0 10 20" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path d="M8.0975 18.2236L1.5775 11.1341C0.8075 10.2968 0.8075 8.92675 1.5775 8.0895L8.0975 1" stroke="#464B52" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                </svg>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="guarantee-content">--}}
{{--                        <p>{{ $isArabic ? 'نضمـن لك صحة المعلومات في هذه الصفحة ونضمن لك نظافة المكان و في حال لم تطابق المعلومـات 80% أو وجـدت المكان غـير نظيف نوفر لك أحد الخيارات' : 'We guarantee the accuracy of information on this page and cleanliness of the place. If the information does not match 80% or the place is not clean, we provide you with one of the options' }}</p>--}}
{{--                        <ul class="guarantee-list">--}}
{{--                            <li>{{ $isArabic ? 'حجز بديل بنفس المواصفات أو أفضل' : 'Alternative booking with same or better specifications' }}</li>--}}
{{--                            <li>{{ $isArabic ? 'إلغاء الحجز و نسترجع المبلغ بغض النظر عن سياسة الإرفاع و الاسترجاع' : 'Cancel booking and refund regardless of cancellation policy' }}</li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="description-card" style="background: #fff; padding: 30px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #e5e7eb;">
                    <h3 class="section-title" style="color: #127664; font-size: 22px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #e5e7eb;">{{ $isArabic ? 'أبرز المميزات ولمحة عن المكان' : 'Highlights & Overview' }}</h3>
                    <div class="description-content" style="line-height: 1.8; color: #333; font-size: 16px;">
                        <p>{{ $chalet->long_description_ar ?? '' }}</p>
                    </div>
                </div>

                <!-- Specifications and Features Card -->
                <div class="specifications-card" style="background: #fff; padding: 30px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #e5e7eb;">
                    <!-- About Host Section -->
                    <div class="about-host-section">
                        <h3 class="section-title">{{ $isArabic ? 'عن المضيف' : 'About Host' }}</h3>
                        <div class="host-info-wrapper">
                            <div class="host-profile">
                                <div class="host-avatar">
                                    <div class="avatar-circle">
                                        <img src="{{ asset($chalet->owner->image) }}"  style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;">
{{--                                        <img height="50px" src="{{ asset('frontend/images/green-profile-image.png') }}" alt="profile_image">--}}
                                    </div>
                                </div>
                                <div class="host-details">
                                    <div class="host-name-rating">
                                        <span class="host-name">{{ $chalet->owner->name ?? ($isArabic ? 'محمد الرشيدي' : 'Mohammed Alrashidi') }}</span>
                                        <div class="host-rating">
                                            <span class="icon-placeholder">
                                                <svg width="13" height="14" viewBox="0 0 13 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.62296 1.43872L8.76684 3.74537C8.92282 4.06647 9.33877 4.37446 9.68974 4.43343L11.763 4.78074C13.0889 5.00354 13.4008 5.97339 12.4454 6.93012L10.8336 8.55526C10.5606 8.83049 10.4112 9.36128 10.4956 9.74135L10.9571 11.7531C11.3211 13.3455 10.4826 13.9615 9.0853 13.1293L7.14202 11.9694C6.79106 11.7597 6.21262 11.7597 5.85516 11.9694L3.91187 13.1293C2.52103 13.9615 1.67612 13.3389 2.04008 11.7531L2.50153 9.74135C2.58602 9.36128 2.43654 8.83049 2.16357 8.55526L0.551745 6.93012C-0.39715 5.97339 -0.0916836 5.00354 1.23417 4.78074L3.30744 4.43343C3.6519 4.37446 4.06786 4.06647 4.22384 3.74537L5.36771 1.43872C5.99164 0.187095 7.00553 0.187095 7.62296 1.43872Z" fill="black"/>
                                                </svg>
                                            </span>
                                            <span class="rating-value">{{ $ownerRating }}</span>
                                            <span class="rating-count">({{ $ownerTotalReviews }} {{ $isArabic ? 'تقييم' : 'reviews' }})</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="host-details-link" style="padding: 15px; background: #f8f9fa; border-radius: 8px; margin-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                @php
                    $ownerChaletsCount = \App\Models\Chalet::where('owner_id', $chalet->owner_id)->where('status', 'approved')->count();
                @endphp
                <span style="font-weight: 600; color: #333;">{{ $isArabic ? $ownerChaletsCount . ' وحدة على المنصة' : $ownerChaletsCount . ' units on platform' }}</span>
                <a href="{{ route('owner.chalets', $chalet->owner_id) }}" class="details-text" style="color: #127664; text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 5px;">
                    {{ $isArabic ? 'عرض جميع الوحدات' : 'View all units' }}
                    <span class="icon-placeholder">
                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 11L1.4882 6.88384C0.837267 6.39773 0.837267 5.60227 1.4882 5.11616L7 1" stroke="#127664" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            </div>
                        </div>
                    </div>

                    <!-- بيانات التواصل (ديسكتوب فقط - الموبايل يظهرها داخل قسم المالك) -->
                    @if($chalet->show_contact_icon && ($chalet->phone_link || $chalet->whatsapp_link) || $chalet->instagram_url || $chalet->tiktok_url)
                    <div class="d-none d-lg-block" style="margin-top: 20px; padding-top: 20px; padding-bottom: 25px;">
                        <h4 class="mb-3" style="font-size: 1rem; font-weight: 600; color: #1a1a1a;">{{ $isArabic ? 'التواصل' : 'Contact' }}</h4>
                        <div class="contact-buttons-wrap d-flex flex-wrap gap-2" style="gap: 10px;">
                            @if($chalet->show_contact_icon && $chalet->phone_link)
                                <a href="{{ $chalet->phone_link }}" class="call-contact-btn d-flex align-items-center">
                                    <i class="fas fa-phone" style="color: white; font-size: 16px;"></i>
                                    <span class="ms-2">{{ $isArabic ? 'اتصال' : 'Call' }}</span>
                                </a>
                            @endif
                            @if($chalet->show_contact_icon && $chalet->whatsapp_link)
                                <a href="{{ $chalet->whatsapp_link }}?text={{ urlencode($isArabic ? 'مرحباً، أرغب في الاستفسار عن: ' . $chalet->chalet_name_ar : 'Hello, I would like to inquire about: ' . $chalet->chalet_name_en) }}" class="whatsapp-contact-btn d-flex align-items-center" target="_blank">
                                    <i class="fab fa-whatsapp" style="font-size: 16px;"></i>
                                    <span class="ms-2">{{ $isArabic ? 'واتساب' : 'WhatsApp' }}</span>
                                </a>
                            @endif
                            @if($chalet->instagram_url)
                                <a href="{{ $chalet->instagram_url }}" class="instagram-contact-btn d-flex align-items-center" target="_blank" rel="noopener">
                                    <i class="fab fa-instagram" style="font-size: 16px;"></i>
                                    <span class="ms-2">{{ $isArabic ? 'انستجرام' : 'Instagram' }}</span>
                                </a>
                            @endif
                            @if($chalet->tiktok_url)
                                <a href="{{ $chalet->tiktok_url }}" class="tiktok-contact-btn d-flex align-items-center" target="_blank" rel="noopener">
                                    <i class="fab fa-tiktok" style="font-size: 16px;"></i>
                                    <span class="ms-2">{{ $isArabic ? 'تيك توك' : 'TikTok' }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- شروط الحجز - ظاهر في الصفحة -->
                    <!-- @if($chalet->booking_terms_ar)
                        <div class="booking-requirements-section" style="background: #fff; padding: 30px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #e5e7eb;">
                            <h3 class="section-title specs-title" style="margin-bottom: 20px;">{{ $isArabic ? 'شروط العرض' : 'Booking Terms' }}</h3>
                            <div class="rules-content" style="color: #555; line-height: 1.7;">
                                {!! nl2br(e($chalet->booking_terms_ar)) !!}
                            </div>
                        </div>
                    @endif -->

                    <!-- Tabs Navigation -->
                    <div class="specs-tabs-navigation">
                        <button class="tab-btn active" data-tab="0">{{ $isArabic ? 'المواصفات والمميزات' : 'Specifications and Features' }}</button>
                        <button class="tab-btn" data-tab="1">{{ $isArabic ? 'تقييمات الضيوف' : 'Reviews' }}</button>
                        <button class="tab-btn" data-tab="2">{{ $isArabic ? 'الموقع والخريطة' : 'Location' }}</button>
                        <button class="tab-btn" data-tab="3">{{ $isArabic ? 'شروط العرض والإلغاء' : 'Booking and Cancellation' }}</button>
                    </div>

                    <!-- Tab Content 1: Specifications -->
                    <div class="tab-content active" data-content="0">

                        <!-- Specifications Title -->
                        <h3 class="section-title specs-title">{{ $isArabic ? 'المواصفات و المميزات' : 'Specifications and Features' }}</h3>

                        <div class="specs-sections-wrap">
                        <!-- Insurance Deposit -->
                        <div class="spec-item insurance-item">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.0802 8.58003V15.42C21.0802 16.54 20.4802 17.58 19.5102 18.15L13.5702 21.58C12.6002 22.14 11.4002 22.14 10.4202 21.58L4.48016 18.15C3.51016 17.59 2.91016 16.55 2.91016 15.42V8.58003C2.91016 7.46003 3.51016 6.41999 4.48016 5.84999L10.4202 2.42C11.3902 1.86 12.5902 1.86 13.5702 2.42L19.5102 5.84999C20.4802 6.41999 21.0802 7.45003 21.0802 8.58003Z" stroke="#848484" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.9999 11.0001C13.2867 11.0001 14.3299 9.95687 14.3299 8.67004C14.3299 7.38322 13.2867 6.34009 11.9999 6.34009C10.7131 6.34009 9.66992 7.38322 9.66992 8.67004C9.66992 9.95687 10.7131 11.0001 11.9999 11.0001Z" stroke="#848484" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16 16.6601C16 14.8601 14.21 13.4001 12 13.4001C9.79 13.4001 8 14.8601 8 16.6601" stroke="#848484" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
<span class="spec-text">
    {{ $isArabic
        ? 'مبلغ تأمين العرض بقيمة ' . number_format((float)($chalet->insurance_amount ?? 0), 0) . ' ر.ع (قابل للاسترداد بعد تطبيق الشروط)'
        : 'Booking security deposit ' . number_format((float)($chalet->insurance_amount ?? 0), 0) . ' OMR (refundable after terms apply)'
    }}
</span>
                        </div>

                        <!-- Councils and Sessions -->
                        <div class="spec-section">
                            <div class="spec-section-header">
                                <svg width="17" height="24" viewBox="0 0 17 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.7 2.58235C1.7 1.15616 2.84168 0 4.25 0H12.75C14.1584 0 15.3 1.15616 15.3 2.58235V3.44314C15.3 5.0475 14.2164 6.39557 12.75 6.7778V9.46862C13.4243 9.46862 14.0264 9.76482 14.5121 10.1378C15.0024 10.5144 15.434 11.0137 15.7885 11.5373C16.4761 12.5528 17 13.8532 17 14.8485C17 15.9626 16.2399 16.897 15.2163 17.1489L16.3277 22.7071C16.5759 23.982 15.4364 24.8287 14.7932 22.7071L12.9882 17.2157H12.7231L12.647 20.6437C12.6097 21.9629 11.5476 21.7913 11.4985 20.6437L11.1611 17.2157H5.83967L5.50222 20.6437C5.45318 21.7913 4.39102 21.9629 4.35379 20.6437L4.27763 17.2157H4.01183L2.20679 22.7071C1.56358 24.8287 0.42415 23.982 0.672257 22.7071L1.78375 17.1489C0.76007 16.897 0 15.9626 0 14.8485C0 13.8532 0.523838 12.5528 1.21148 11.5373C1.56601 11.0137 1.99762 10.5144 2.48796 10.1378C2.97363 9.76482 3.5757 9.46862 4.25 9.46862V6.7778C2.78355 6.39557 1.7 5.0475 1.7 3.44314V2.58235ZM4.25 11.1902C4.07431 11.1902 3.82636 11.2706 3.51518 11.5095C3.20863 11.745 2.89649 12.093 2.61352 12.5109C2.02616 13.3783 1.7 14.3375 1.7 14.8485C1.7 15.2051 1.98542 15.4941 2.3375 15.4941H14.6625C15.0146 15.4941 15.3 15.2051 15.3 14.8485C15.3 14.3375 14.9739 13.3783 14.3865 12.5109C14.1035 12.093 13.7913 11.745 13.4848 11.5095C13.1736 11.2706 12.9257 11.1902 12.75 11.1902H4.25ZM11.05 9.46862V6.88627H5.95V9.46862H11.05ZM13.6 3.44314V2.58235C13.6 2.10696 13.2195 1.72157 12.75 1.72157H4.25C3.78055 1.72157 3.4 2.10696 3.4 2.58235V3.44314C3.4 4.39393 4.16109 5.1647 5.1 5.1647H11.9C12.8389 5.1647 13.6 4.39393 13.6 3.44314Z" fill="#848484"/>
                                </svg>
                                <h4 class="spec-section-title">{{ $isArabic ? 'المجالس والجلسات' : 'Councils and Sessions' }}</h4>
                            </div>
                            <ul class="spec-list">
                                <li>{{ $isArabic ? 'صالة استقبال تتسع لـ ' . $chalet->max_guests . ' شخص' : 'Reception hall for ' . $chalet->max_guests . ' people' }}</li>
                                <li>{{ $isArabic ? 'جلسة خارجية مع منطقة شواء' : 'Outdoor seating with BBQ area' }}</li>
                                <li>{{ $isArabic ? 'طاولة طعام تتسع لـ 8 أشخاص' : 'Dining table for 8 people' }}</li>
                                <li>{{ $isArabic ? $chalet->bedrooms . ' غرف نوم مكيفة' : $chalet->bedrooms . ' air-conditioned bedrooms' }}</li>
                                <li>{{ $isArabic ? $chalet->bathrooms . ' دورات مياه' : $chalet->bathrooms . ' bathrooms' }}</li>
                            </ul>
                        </div>

                        <!-- Pools -->
                        <div class="spec-section">
                            <div class="spec-section-header">
                                <svg width="17" height="24" viewBox="0 0 17 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.3722 0.413559C9.15544 0.151208 8.83626 0 8.5 0C8.16374 0 7.84456 0.151208 7.62781 0.413559C7.31604 0.790072 0 9.70539 0 15.3425C0 20.1162 3.81316 24 8.5 24C13.1868 24 17 20.1162 17 15.3425C17 9.70993 9.68396 0.790823 9.3722 0.413559ZM8.5 21.6774C5.07061 21.6774 2.28032 18.8354 2.28032 15.3425C2.28032 11.8632 6.19889 6.01739 8.5 3.01058C10.8019 6.01739 14.7197 11.8616 14.7197 15.3425C14.7197 18.8354 11.9294 21.6774 8.5 21.6774Z" fill="#848484"/>
                                </svg>
                                <h4 class="spec-section-title">{{ $isArabic ? 'المسابح' : 'Pools' }}</h4>
                            </div>
                            <ul class="spec-list">
                                <li>{{ $isArabic ? 'مسبح خاص نظيف مع فلتر' : 'Clean private pool with filter' }}</li>
                                <li>{{ $isArabic ? 'عمق المسبح 140 سم' : 'Pool depth 140 cm' }}</li>
                                <li>{{ $isArabic ? 'أبعاد المسبح 6 م × 4 م' : 'Pool dimensions 6m x 4m' }}</li>
                                <li>{{ $isArabic ? 'مناسب للأطفال والكبار' : 'Suitable for children and adults' }}</li>
                            </ul>
                        </div>

                        <!-- Facilities -->
                        <div class="spec-section">
                            <div class="spec-section-header">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.93157 15.7565C10.4905 12.8275 14.2294 11.1478 18.1894 11.1478C22.1501 11.1478 25.8891 12.8282 28.4473 15.7572C28.5091 15.8288 28.5846 15.8873 28.6692 15.9296C28.7539 15.9718 28.8461 15.9969 28.9405 16.0033C29.0348 16.0097 29.1296 15.9974 29.2192 15.967C29.3088 15.9367 29.3914 15.8888 29.4625 15.8263C29.6061 15.7008 29.6941 15.5234 29.7071 15.333C29.72 15.1427 29.6569 14.955 29.5316 14.8111C26.6998 11.5675 22.5663 9.70776 18.1894 9.70776C13.8133 9.70776 9.67973 11.5668 6.84725 14.809C6.72278 14.9529 6.66035 15.1403 6.67363 15.3301C6.68691 15.52 6.77481 15.6968 6.91811 15.8221C7.06141 15.9473 7.24847 16.0107 7.43838 15.9984C7.62829 15.9861 7.80561 15.8991 7.93157 15.7565Z" fill="#848484"/>
                                    <path d="M25.4639 18.6112C25.5234 18.6847 25.5968 18.7458 25.68 18.7908C25.7632 18.8359 25.8544 18.864 25.9485 18.8737C26.0426 18.8833 26.1377 18.8742 26.2283 18.847C26.3188 18.8197 26.4031 18.7748 26.4763 18.7148C26.6242 18.5944 26.7184 18.4201 26.738 18.2303C26.7575 18.0405 26.701 17.8506 26.5807 17.7025C24.5359 15.189 21.4766 13.7476 18.1891 13.7476C14.9023 13.7476 11.8437 15.189 9.79745 17.7011C9.73774 17.7744 9.69306 17.8588 9.66596 17.9494C9.63885 18.04 9.62986 18.135 9.63948 18.2291C9.65893 18.4191 9.75305 18.5935 9.90113 18.7141C10.0492 18.8347 10.2391 18.8915 10.4291 18.8721C10.6191 18.8526 10.7936 18.7585 10.9142 18.6104C12.6854 16.4353 15.3379 15.1868 18.1891 15.1868C21.0417 15.1876 23.6935 16.4353 25.4639 18.6112Z" fill="#848484"/>
                                    <path d="M22.4091 21.4005C22.5228 21.5458 22.6878 21.642 22.8703 21.6693C23.0527 21.6967 23.2387 21.6531 23.39 21.5475C23.5413 21.4419 23.6464 21.2824 23.6837 21.1018C23.721 20.9211 23.6877 20.733 23.5906 20.5761C22.3716 18.8294 20.3528 17.7869 18.1892 17.7869C15.9932 17.7869 13.9577 18.8539 12.7431 20.6409C12.6422 20.799 12.6069 20.9902 12.6447 21.1739C12.6824 21.3576 12.7903 21.5193 12.9454 21.6248C13.1005 21.7302 13.2906 21.771 13.4753 21.7385C13.66 21.7061 13.8248 21.6029 13.9347 21.4509C14.8808 20.0577 16.4712 19.2269 18.1899 19.2269C19.8819 19.2269 21.4601 20.0397 22.4091 21.4005Z" fill="#848484"/>
                                    <path d="M18.189 25.5478C18.9843 25.5478 19.629 24.913 19.629 24.1301C19.629 23.3471 18.9843 22.7124 18.189 22.7124C17.3937 22.7124 16.749 23.3471 16.749 24.1301C16.749 24.913 17.3937 25.5478 18.189 25.5478Z" fill="#848484"/>
                                </svg>
                                <h4 class="spec-section-title">{{ $isArabic ? 'المرافق' : 'Facilities' }}</h4>
                            </div>
                            <ul class="spec-list">
                                @php
                                    $amenitiesList = $chalet->amenities;
                                    if (is_string($amenitiesList)) {
                                        $amenitiesList = json_decode($amenitiesList, true);
                                    }
                                    if (!is_array($amenitiesList)) {
                                        $amenitiesList = [];
                                    }
                                @endphp
                                @if(!empty($amenitiesList))
                                    @foreach($amenitiesList as $key => $amenity)
                                        @if(is_array($amenity))
                                            <li>{{ $isArabic ? $amenity[0] : $amenity[1] }}</li>
                                        @elseif(is_string($amenity))
                                            @php
                                                $amenityLower = strtolower(trim($amenity));
                                            @endphp
                                            @if(__('amenities.' . $amenityLower) !== 'amenities.' . $amenityLower)
                                                <li>{{ __('amenities.' . $amenityLower) }}</li>
                                            @else
                                                <li>{{ $amenity }}</li>
                                            @endif
                                        @endif
                                    @endforeach
                                @else
                                    <li>{{ $isArabic ? 'حديقة واسعة' : 'Spacious garden' }}</li>
                                    <li>{{ $isArabic ? 'منطقة شواء مجهزة' : 'Equipped BBQ area' }}</li>
                                    <li>{{ $isArabic ? 'مواقف سيارات خاصة' : 'Private parking' }}</li>
                                    <li>{{ $isArabic ? 'تكييف مركزي' : 'Central AC' }}</li>
                                    <li>{{ $isArabic ? 'واي فاي عالي السرعة' : 'High-speed WiFi' }}</li>
                                    <li>{{ $isArabic ? 'شاشات ذكية' : 'Smart TVs' }}</li>
                                    <li>{{ $isArabic ? 'مطبخ مجهز بالكامل' : 'Fully equipped kitchen' }}</li>
                                @endif
                            </ul>
                        </div>

                        </div><!-- /.specs-sections-wrap -->
                    </div>

                    <!-- Tab Content 2: Guest Reviews -->
                    <div class="tab-content" data-content="1">
                        <h3 class="section-title specs-title">{{ $isArabic ? 'تقييمات الضيوف' : 'Guest Reviews' }}</h3>
                        <div class="reviews-section">
                            <!-- Reviews Summary -->
                            <div class="reviews-summary mb-4 p-3 bg-light rounded">
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center">
                                        <h2 class="mb-0" style="color: #127664;">{{ $averageRating }}</h2>
                                        <div class="stars mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($averageRating))
                                                    <i class="fas fa-star text-warning"></i>
                                                @elseif($i - 0.5 <= $averageRating)
                                                    <i class="fas fa-star-half-alt text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="text-muted">{{ $totalReviews }} {{ $isArabic ? 'تقييم' : 'reviews' }}</p>
                                    </div>
                                    <div class="col-md-9">
                                        @php
                                            $ratingDistribution = [
                                                5 => $reviews->where('rating', 5)->count(),
                                                4 => $reviews->where('rating', 4)->count(),
                                                3 => $reviews->where('rating', 3)->count(),
                                                2 => $reviews->where('rating', 2)->count(),
                                                1 => $reviews->where('rating', 1)->count(),
                                            ];
                                        @endphp
                                        @foreach($ratingDistribution as $stars => $count)
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="me-2">{{ $stars }}</span>
                                                <i class="fas fa-star text-warning me-2"></i>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" style="width: {{ $totalReviews > 0 ? ($count / $totalReviews * 100) : 0 }}%"></div>
                                                </div>
                                                <span class="ms-2 text-muted">{{ $count }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews List -->
                            <div class="reviews-list">
                                @forelse($reviews->take(5) as $review)
                                    <div class="review-item border-bottom pb-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">{{ $review->customer->name ?? ($isArabic ? 'زائر' : 'Guest') }}</h6>
                                                <div class="stars-small">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 14px;"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0">{{ $review->comment }}</p>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="far fa-comment-dots fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">{{ $isArabic ? 'لا توجد تقييمات بعد. كن أول من يقيم هذا العقار!' : 'No reviews yet. Be the first to review this property!' }}</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Add Review Form -->
                            @auth('customer')
                                @php
                                    $userReview = $reviews->where('customer_id', Auth::guard('customer')->id())->first();
                                @endphp

                                @if($userReview)
                                    <!-- User's Existing Review -->
                                    <div class="user-review-section mt-4 p-4 bg-warning bg-opacity-10 border border-warning rounded">
                                        <h5 class="mb-3">
                                            <i class="fas fa-edit me-2"></i>
                                            {{ $isArabic ? 'تقييمك الحالي' : 'Your Current Review' }}
                                        </h5>
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <div class="stars-small mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $userReview->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 18px;"></i>
                                                    @endfor
                                                </div>
                                                <p class="mb-2">{{ $userReview->comment }}</p>
                                                <small class="text-muted">{{ $userReview->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editReview()">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('review.destroy', $userReview->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('{{ $isArabic ? 'هل أنت متأكد من حذف تقييمك؟' : 'Are you sure you want to delete your review?' }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Edit Form (Hidden by default) -->
                                        <div id="editReviewForm" style="display: none;" class="mt-3 pt-3 border-top">
                                            <form action="{{ route('review.update', $userReview->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <!-- Rating Stars -->
                                                <div class="mb-3">
                                                    <label class="form-label">{{ $isArabic ? 'التقييم' : 'Rating' }}</label>
                                                    <div class="rating-input">
                                                        <input type="hidden" name="rating" id="editRatingInput" value="{{ $userReview->rating }}" required>
                                                        <div class="stars-input" id="editStarsInput">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star star-edit-clickable {{ $i <= $userReview->rating ? 'active' : 'inactive' }}"
                                                                   data-rating="{{ $i }}"
                                                                   style="font-size: 24px; cursor: pointer;"></i>
                                                            @endfor
                                                        </div>
                                                        <span class="edit-rating-text ms-2">
                                                            @php
                                                                $ratingTexts = $isArabic ?
                                                                    ['', 'سيء', 'مقبول', 'جيد', 'جيد جداً', 'ممتاز'] :
                                                                    ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
                                                            @endphp
                                                            {{ $ratingTexts[$userReview->rating] }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Comment -->
                                                <div class="mb-3">
                                                    <label for="editComment" class="form-label">{{ $isArabic ? 'تعليقك' : 'Your Comment' }}</label>
                                                    <textarea class="form-control" id="editComment" name="comment" rows="4" maxlength="1000">{{ $userReview->comment }}</textarea>
                                                    <small class="text-muted">
                                                        <span id="editCharCount">{{ strlen($userReview->comment) }}</span>/1000 {{ $isArabic ? 'حرف' : 'characters' }}
                                                    </small>
                                                </div>

                                                <!-- Buttons -->
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save me-2"></i>
                                                        {{ $isArabic ? 'حفظ التعديلات' : 'Save Changes' }}
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" onclick="cancelEdit()">
                                                        {{ $isArabic ? 'إلغاء' : 'Cancel' }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <!-- Add New Review Form -->
                                    <div class="add-review-section mt-4 p-4 bg-light rounded">
                                        <h5 class="mb-3">{{ $isArabic ? 'أضف تقييمك' : 'Add Your Review' }}</h5>
                                        <form action="{{ route('review.store') }}" method="POST" id="reviewForm">
                                            @csrf
                                            <input type="hidden" name="chalet_id" value="{{ $chalet->id }}">

                                        <!-- Rating Stars -->
                                        <div class="mb-3">
                                            <label class="form-label">{{ $isArabic ? 'التقييم' : 'Rating' }}</label>
                                            <div class="rating-input">
                                                <input type="hidden" name="rating" id="ratingInput" value="5" required>
                                                <div class="stars-input" id="starsInput">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star star-clickable" data-rating="{{ $i }}" style="font-size: 24px; cursor: pointer; color: #FFA500;"></i>
                                                    @endfor
                                                </div>
                                                <span class="rating-text ms-2">{{ $isArabic ? 'ممتاز' : 'Excellent' }}</span>
                                            </div>
                                        </div>

                                        <!-- Comment -->
                                        <div class="mb-3">
                                            <label for="comment" class="form-label">{{ $isArabic ? 'تعليقك' : 'Your Comment' }}</label>
                                            <textarea class="form-control" id="comment" name="comment" rows="4"
                                                placeholder="{{ $isArabic ? 'شاركنا تجربتك مع هذا العقار...' : 'Share your experience with this property...' }}"
                                                maxlength="1000"></textarea>
                                            <small class="text-muted">
                                                <span id="charCount">0</span>/1000 {{ $isArabic ? 'حرف' : 'characters' }}
                                            </small>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            {{ $isArabic ? 'إرسال التقييم' : 'Submit Review' }}
                                        </button>
                                    </form>
                                </div>
                                @endif
                            @else
                                <div class="alert alert-info mt-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ $isArabic ? 'يجب عليك' : 'You must' }}
                                    <a href="{{ route('login', ['intended' => url()->current()]) }}" class="alert-link">{{ $isArabic ? 'تسجيل الدخول' : 'login' }}</a>
                                    {{ $isArabic ? 'لإضافة تقييم' : 'to add a review' }}
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Tab Content 3: Location and Map -->
                    <div class="tab-content" data-content="2">
                        <h3 class="section-title specs-title">{{ $isArabic ? 'الموقع والخريطة' : 'Location and Map' }}</h3>
                        <div class="location-section">
                            <div class="address-section mb-4">
                                <h4 class="mb-3">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    {{ $isArabic ? 'العنوان' : 'Address' }}
                                </h4>
                                <p class="ps-4">{{ $chalet->location }}</p>
                            </div>

                            @if($chalet->latitude && $chalet->longitude)
                                <div class="map-section">
                                    <h4 class="mb-3">
                                        <i class="fas fa-map text-primary me-2"></i>
                                        {{ $isArabic ? 'الموقع على الخريطة' : 'Location on Map' }}
                                    </h4>
                                    <div class="map-container">
                                        <div id="chalet-map" style="width: 100%; height: 450px; border-radius: 12px;"></div>
                                    </div>
                                    <div class="mt-3 d-flex gap-2">
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $chalet->latitude }},{{ $chalet->longitude }}"
                                           target="_blank" class="btn btn-primary">
                                            <i class="fas fa-map-marked-alt me-2"></i>
                                            {{ $isArabic ? 'عرض في خرائط جوجل' : 'View in Google Maps' }}
                                        </a>
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $chalet->latitude }},{{ $chalet->longitude }}"
                                           target="_blank" class="btn btn-outline-primary">
                                            <i class="fas fa-directions me-2"></i>
                                            {{ $isArabic ? 'احصل على الاتجاهات' : 'Get Directions' }}
                                        </a>
                                    </div>
                                </div>
                            @elseif($chalet->map_link)
                                <div class="map-section">
                                    <h4 class="mb-3">
                                        <i class="fas fa-map text-primary me-2"></i>
                                        {{ $isArabic ? 'الموقع على الخريطة' : 'Location on Map' }}
                                    </h4>
                                    <div class="map-container">
                                        <a href="{{ $chalet->map_link }}" target="_blank" rel="noopener" class="btn btn-primary">
                                            <i class="fas fa-map-marked-alt me-2"></i>
                                            {{ $isArabic ? 'فتح في خرائط جوجل / أبل ماب' : 'Open in Google Maps / Apple Maps' }}
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ $isArabic ? 'الخريطة غير متوفرة حالياً' : 'Map is not available at the moment' }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tab Content 4: Booking and Cancellation Terms -->
                    <div class="tab-content" data-content="3">
                        <h3 class="section-title specs-title">{{ $isArabic ? 'شروط العرض و الإلغاء' : 'Booking and Cancellation Terms' }}</h3>
                        <div class="terms-section">
                            <h4 class="mb-3">{{ $isArabic ? 'أوقات الدخول والخروج:' : 'Check-in and Check-out Times:' }}</h4>
                            <ul class="spec-list">
                                <li>{{ $isArabic ? 'وقت الدخول: ' . date('g:i A', strtotime($chalet->check_in_time ?? '15:00')) : 'Check-in: ' . date('g:i A', strtotime($chalet->check_in_time ?? '15:00')) }}</li>
                                <li>{{ $isArabic ? 'وقت الخروج: ' . date('g:i A', strtotime($chalet->check_out_time ?? '13:00')) : 'Check-out: ' . date('g:i A', strtotime($chalet->check_out_time ?? '13:00')) }}</li>
                            </ul>

                            @if($chalet->booking_terms_ar)
                                <h4 class="mt-4 mb-3">{{ $isArabic ? 'شروط العرض:' : 'Booking Terms:' }}</h4>
                                <div class="rules-content">
                                    {!! nl2br(e($chalet->booking_terms_ar)) !!}
                                </div>
                            @endif

                            @if($chalet->phone || $chalet->whatsapp_number)
                                <div class="mt-4">
                                    <p><strong>{{ $isArabic ? 'للتواصل المباشر:' : 'For direct contact:' }}</strong></p>
                                    <div class="d-flex flex-wrap gap-2">
                                        @if($chalet->phone)
                                            <a href="{{ $chalet->phone_link }}" class="btn btn-primary">
                                                <i class="fas fa-phone" style="color: white;"></i> {{ $chalet->phone }}
                                            </a>
                                        @endif
                                        @if($chalet->whatsapp_number)
                                            <a href="{{ $chalet->whatsapp_link }}" class="btn btn-success" target="_blank">
                                                <i class="fab fa-whatsapp"></i> {{ $chalet->whatsapp_number }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4 d-none d-lg-block">
    <div class="contact-sidebar-card sticky-card">
        <h3 class="contact-card-title">{{ $isArabic ? 'تواصل مع صاحب الإعلان' : 'Contact the Host' }}</h3>
        <p class="contact-card-description">{{ $isArabic ? 'للعرض أو الاستفسار يمكنك التواصل مباشرة عبر الواتساب أو الاتصال.' : 'For booking or inquiries, you can contact the host directly via WhatsApp or phone call.' }}</p>

        <div class="contact-card-actions">
            <a href="{{ $whatsappLink }}" target="_blank" rel="noopener" class="contact-card-btn contact-card-btn--whatsapp">
                <i class="fab fa-whatsapp"></i>
                <span>{{ $isArabic ? 'تواصل واتساب' : 'WhatsApp Contact' }}</span>
            </a>
            <a href="{{ $callPhoneLink }}" class="contact-card-btn contact-card-btn--call">
                <i class="fas fa-phone-alt"></i>
                <span>{{ $isArabic ? 'اتصال مباشر' : 'Direct Call' }}</span>
            </a>
        </div>

    
    </div>
    {{--
    <div class="booking-card sticky-card">
        <form action="{{ route('chalet.book', $chalet->id) }}" method="POST" id="booking-form">
            @csrf
            <input type="hidden" name="booking_type" id="booking-type-input" value="fullDay">
            <!-- Price Section: اختيار نوع السعر -->
            <div class="price-section">
                <div class="mb-3">
                    <label class="d-block small fw-600 mb-2" style="color: #333;">{{ $isArabic ? 'اختر نوع السعر' : 'Select price type' }}</label>
                    <div class="price-type-options d-flex flex-column gap-2">
                        <label class="price-type-option rounded-2 border cursor-pointer d-flex align-items-center justify-content-between p-3 mb-0 active" data-type="fullDay" data-price="{{ $chalet->default_day_price ?? 0 }}" style="border-width: 2px !important; border-color: #127664 !important; background: rgba(18, 118, 100, 0.08); cursor: pointer;">
                            <span>{{ $isArabic ? 'يوم كامل' : 'Full day' }}</span>
                            <span class="fw-bold text-success">{{ number_format($chalet->default_day_price ?? 0, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                        </label>
                        <label class="price-type-option rounded-2 border cursor-pointer d-flex align-items-center justify-content-between p-3 mb-0" data-type="stayDay" data-price="{{ $chalet->stay_price ?? 0 }}" style="border-color: #e5e7eb; cursor: pointer;">
                            <span>{{ $isArabic ? 'يوم كامل مع مبيت' : 'Full day with overnight' }}</span>
                            <span class="fw-bold text-success">{{ number_format($chalet->stay_price ?? 0, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                        </label>
                        <label class="price-type-option rounded-2 border cursor-pointer d-flex align-items-center justify-content-between p-3 mb-0" data-type="halfDay" data-price="{{ $chalet->half_day_price ?? 0 }}" style="border-color: #e5e7eb; cursor: pointer;">
                            <span>{{ $isArabic ? 'نصف يوم' : 'Half day' }}</span>
                            <span class="fw-bold text-success">{{ number_format($chalet->half_day_price ?? 0, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                        </label>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="price-main">
                        <span class="price-amount" data-price="{{ $chalet->default_day_price }}">{{ number_format($chalet->default_day_price ?? 0, 0) }}</span>
                        <span class="price-currency">{{ $isArabic ? 'ر.ع/ليلة' : 'OMR/night' }}</span>
                    </div>
                </div>

                <!-- Total Price -->
                <div class="price-total mt-2">
                    <span>{{ $isArabic ? 'إجمالي ليلة واحدة' : 'Total for one night' }}
                        <span class="text-dark fw-bold" id="price-per-night">{{ number_format($chalet->default_day_price * 1.04, 0) }}</span>
                        {{ $isArabic ? 'ر.ع' : 'OMR' }}
                    </span>
                </div>
            </div>




                        <!-- Date Selection -->
                        <div class="date-selection-section">
                            <div class="section-label">
                                <span id="nights-count-label">{{ $isArabic ? 'ليلة واحدة' : 'One night' }}</span>
                                <span class="date-modify-text">{{ $isArabic ? 'بإمكانك تعديل التاريخ' : 'You can modify the date' }}</span>
                            </div>
                            <div class="date-picker-wrapper">
                                <div class="date-item" onclick="document.getElementById('checkin-date').showPicker()">
                                    <span class="date-label">{{ $isArabic ? 'تاريخ الوصول' : 'Check-in Date' }}</span>
                                    <span class="date-value" id="checkin-display">{{ $isArabic ? 'اختر التاريخ' : 'Select Date' }}</span>
                                    <input type="date" id="checkin-date" name="checkin_date" min="{{ date('Y-m-d') }}" required style="position: absolute; opacity: 0; pointer-events: none;">
                                </div>
                                <div class="date-divider"></div>
                                <div class="date-item" onclick="document.getElementById('checkout-date').showPicker()">
                                    <span class="date-label">{{ $isArabic ? 'تاريخ المغادرة' : 'Check-out Date' }}</span>
                                    <span class="date-value" id="checkout-display">{{ $isArabic ? 'اختر التاريخ' : 'Select Date' }}</span>
                                    <input type="date" id="checkout-date" name="checkout_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required style="position: absolute; opacity: 0; pointer-events: none;">
                                </div>
                            </div>
                        </div>

                        <!-- أوقات الحجز يحددها صاحب العقار فقط (مخفية) -->
                        <input type="hidden" name="checkin_time" value="{{ $chalet->check_in_time ?? '15:00' }}">
                        <input type="hidden" name="checkout_time" value="{{ $chalet->check_out_time ?? '12:00' }}">

                        <!-- Hidden inputs for guest number and special requests -->
                        <input type="hidden" name="number_of_guests" value="2">
                        <input type="hidden" name="special_requests" value="">

                        <!-- Confirm Button -->
                        <button type="submit" class="btn-confirm">{{ $isArabic ? 'تأكيد' : 'Confirm' }}</button>

                        <!-- Price Breakdown -->
                        <div class="price-breakdown" id="price-breakdown">
                            <div class="breakdown-item">
                                <span><span id="nights-count">1</span> {{ $isArabic ? 'ليلة' : 'night(s)' }} × <span id="breakdown-unit-price">{{ number_format($chalet->default_day_price ?? 0, 0) }}</span> {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                                <span class="breakdown-value" id="subtotal">{{ number_format($chalet->default_day_price ?? 0, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="text-secondary">{{ $isArabic ? 'رسوم الخدمات' : 'Service Fees' }}</span>
                                <span class="breakdown-value text-secondary" id="service-fee">+{{ number_format(($chalet->default_day_price ?? 0) * 0.04, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                            </div>
                        </div>

                        <!-- Total Section -->
                        <div class="total-section">
                            <span class="total-label">{{ $isArabic ? 'الإجمالي' : 'Total' }}</span>
                            <span class="total-value" id="total-price">{{ number_format(($chalet->default_day_price ?? 0) * 1.04, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                        </div>

                        <!-- Insurance Note -->
    <p class="insurance-note">
        * {{ app()->getLocale() === 'ar'
            ? 'مبلغ تأمين العرض بقيمة ' . number_format((float)($chalet->insurance_amount ?? 0), 0) . ' ر.ع (قابل للاسترداد بعد تطبيق الشروط)'
            : 'Booking security deposit ' . number_format((float)($chalet->insurance_amount ?? 0), 0) . ' OMR (refundable after terms apply)'
        }}
    </p>

        </form>



     <!-- Payment Options - سلطنة عُمان (Thawani Pay، Visa، Mastercard) -->
<div class="payment-options">
    <div class="payment-option">
        <div class="payment-logo" style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('frontend/assets/images/thawani_logo-green.png') }}" alt="Thawani Pay" style="height: 34px;">
            <div>
                <h5 style="margin:0;">Thawani Pay</h5>
                <span class="badge bg-warning text-dark">الأفضل في عُمان</span>
            </div>
        </div>
    </div>
    <div class="payment-option" style="flex-wrap: wrap;">
        <span style="font-size: 0.9rem; color: #666;">{{ $isArabic ? 'Visa و Mastercard مقبولة في سلطنة عُمان عبر Thawani Pay' : 'Visa & Mastercard accepted in Oman via Thawani Pay' }}</span>
    </div>
</div>
--}}
<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pb-5">
                <div id="modalIcon" class="mb-4">
                    <!-- Icon will be inserted here -->
                </div>
                <h4 class="modal-title mb-3" id="modalTitle">
                    <!-- Title will be inserted here -->
                </h4>
                <p class="text-muted mb-4" id="modalMessage">
                    <!-- Message will be inserted here -->
                </p>
                <div class="d-flex justify-content-center gap-3" id="modalButtons">
                    <!-- Buttons will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    const lightbox = GLightbox({
        touchNavigation: true,
        loop: true,
        zoomable: true,
    });
</script>

<script>
// ========================================
// FIXED JavaScript Code - All Issues Resolved
// ========================================

// 1. Global Functions (Available immediately)
window.showMobileBookingModal = function() {
    console.log('Opening mobile booking modal...');

    // Remove existing modal/overlay if any
    const existingModal = document.querySelector('.mobile-booking-modal');
    if (existingModal) existingModal.remove();

    const existingOverlay = document.querySelector('.booking-overlay');
    if (existingOverlay) existingOverlay.remove();

    // Create booking modal
    const modal = document.createElement('div');
    modal.className = 'mobile-booking-modal';
    modal.style.cssText = `
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        top: 10%;
        background: white;
        border-radius: 20px 20px 0 0;
        z-index: 10000;
        padding: 20px;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.2);
        overflow-y: auto;
        max-height: 90vh;
    `;

    modal.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e5e7eb; padding-bottom: 15px;">
            <h3 style="margin: 0; font-size: 1.3rem; color: #1a1a1a; font-weight: 600;">{{ $isArabic ? "تواقيت العرض" : "Booking Times" }}</h3>
            <button class="close-modal-btn" style="background: none; border: none; font-size: 28px; color: #666; cursor: pointer; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form action="{{ route('chalet.book', $chalet->id) }}" method="POST" id="mobile-booking-form">
            @csrf
            <input type="hidden" name="booking_type" id="mobile-booking-type" value="fullDay">

            <!-- اختيار نوع السعر (موبايل) -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #333; margin-bottom: 10px;">{{ $isArabic ? 'اختر نوع السعر' : 'Select price type' }}</label>
                <div class="mobile-price-type-options" style="display: flex; flex-direction: column; gap: 8px;">
                    <label class="mobile-price-opt rounded-2 border p-3 mb-0 d-flex align-items-center justify-content-between" data-type="fullDay" data-price="{{ $chalet->default_day_price ?? 0 }}" style="border: 2px solid #127664; background: rgba(18, 118, 100, 0.08); cursor: pointer;">
                        <span>{{ $isArabic ? 'يوم كامل' : 'Full day' }}</span>
                        <span style="font-weight: bold; color: #127664;">{{ number_format($chalet->default_day_price ?? 0, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                    </label>
                    <label class="mobile-price-opt rounded-2 border p-3 mb-0 d-flex align-items-center justify-content-between" data-type="stayDay" data-price="{{ $chalet->stay_price ?? 0 }}" style="border: 1px solid #e5e7eb; cursor: pointer;">
                        <span>{{ $isArabic ? 'يوم كامل مع مبيت' : 'Full day with overnight' }}</span>
                        <span style="font-weight: bold; color: #127664;">{{ number_format($chalet->stay_price ?? 0, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                    </label>
                    <label class="mobile-price-opt rounded-2 border p-3 mb-0 d-flex align-items-center justify-content-between" data-type="halfDay" data-price="{{ $chalet->half_day_price ?? 0 }}" style="border: 1px solid #e5e7eb; cursor: pointer;">
                        <span>{{ $isArabic ? 'نصف يوم' : 'Half day' }}</span>
                        <span style="font-weight: bold; color: #127664;">{{ number_format($chalet->half_day_price ?? 0, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                    </label>
                </div>
            </div>

            <!-- Date Selection -->
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="font-weight: 600; color: #333;" id="mobile-nights-label">{{ $isArabic ? 'ليلة واحدة' : 'One night' }}</span>
                    <span style="color: #127664; font-size: 0.85rem;">{{ $isArabic ? 'بإمكانك تعديل التاريخ' : 'You can modify the date' }}</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div style="border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; cursor: pointer;" onclick="document.getElementById('mobile-checkin-date').showPicker()">
                        <label style="display: block; color: #666; font-size: 0.75rem; margin-bottom: 4px;">{{ $isArabic ? "تاريخ الوصول" : "Check-in" }}</label>
                        <span style="color: #333; font-weight: 500; font-size: 0.95rem;" id="mobile-checkin-display">{{ $isArabic ? 'اختر التاريخ' : 'Select Date' }}</span>
                        <input type="date" id="mobile-checkin-date" name="checkin_date" min="{{ date('Y-m-d') }}" required style="position: absolute; opacity: 0; pointer-events: none;">
                    </div>

                    <div style="border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; cursor: pointer;" onclick="document.getElementById('mobile-checkout-date').showPicker()">
                        <label style="display: block; color: #666; font-size: 0.75rem; margin-bottom: 4px;">{{ $isArabic ? "تاريخ المغادرة" : "Check-out" }}</label>
                        <span style="color: #333; font-weight: 500; font-size: 0.95rem;" id="mobile-checkout-display">{{ $isArabic ? 'اختر التاريخ' : 'Select Date' }}</span>
                        <input type="date" id="mobile-checkout-date" name="checkout_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required style="position: absolute; opacity: 0; pointer-events: none;">
                    </div>
                </div>
            </div>

            <!-- أوقات الحجز يحددها صاحب العقار فقط (مخفية) -->
            <input type="hidden" name="checkin_time" value="{{ $chalet->check_in_time ?? '15:00' }}">
            <input type="hidden" name="checkout_time" value="{{ $chalet->check_out_time ?? '12:00' }}">

            <!-- Hidden inputs -->
            <input type="hidden" name="number_of_guests" value="2">
            <input type="hidden" name="special_requests" value="">

            <!-- Price Breakdown -->
            <div style="border-top: 1px solid #e5e7eb; padding-top: 15px; margin-bottom: 15px;" id="mobile-price-breakdown">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #666;"><span id="mobile-nights-count">1</span> {{ $isArabic ? 'ليلة' : 'night(s)' }} × {{ number_format($chalet->default_day_price, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                    <span style="font-weight: 500;" id="mobile-subtotal">{{ number_format($chalet->default_day_price, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <span style="color: #666;">{{ $isArabic ? 'رسوم الخدمات' : 'Service Fees' }}</span>
                    <span style="color: #666;" id="mobile-service-fee">+{{ number_format($chalet->default_day_price * 0.04, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
                </div>
            </div>

            <!-- Total Section -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 10px; margin-bottom: 20px;">
                <span style="font-weight: 600; font-size: 1.1rem;">{{ $isArabic ? 'الإجمالي' : 'Total' }}</span>
                <span style="font-weight: bold; font-size: 1.3rem; color: #127664;" id="mobile-total-price">{{ number_format($chalet->default_day_price * 1.04, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
            </div>

            <!-- Insurance Note -->
            <p style="color: #666; font-size: 0.85rem; margin-bottom: 20px; padding: 10px; background: #f8f9fa; border-radius: 8px;">
                * {{ $isArabic ? 'مبلغ تأمين العرض بقيمة ' . number_format((float)($chalet->insurance_amount ?? 0), 0) . ' ر.ع (قابل للاسترداد بعد تطبيق الشروط)' : 'Booking security deposit ' . number_format((float)($chalet->insurance_amount ?? 0), 0) . ' OMR (refundable after terms apply)' }}
            </p>

            <!-- Payment Options - سلطنة عُمان -->
            <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ asset('frontend/assets/images/thawani_logo-green.png') }}" alt="Thawani" style="height: 24px !important;">
                    <span style="font-size: 0.85rem; color: #666;">{{ $isArabic ? 'الدفع بالبطاقة في سلطنة عُمان عبر Thawani Pay (Visa و Mastercard)' : 'Card payment in Oman via Thawani Pay (Visa & Mastercard)' }}</span>
                </div>
            </div>

            <!-- Confirm Button -->
            <button type="submit" style="width: 100%; background: #127664; color: white; padding: 16px; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer;">
                {{ $isArabic ? 'تأكيد العرض' : 'Confirm Booking' }}
            </button>
        </form>
    `;

    document.body.appendChild(modal);

    // مزامنة نوع السعر من الصفحة إن وُجد (اختيار المستخدم من خيارات الموبايل الظاهرة)
    var pageType = document.getElementById('mobile-selected-booking-type');
    var pagePrice = document.getElementById('mobile-selected-price');
    if (pageType && pagePrice) {
        mobilePricePerNight = parseFloat(pagePrice.value) || {{ $chalet->default_day_price ?? 0 }};
        var typeVal = pageType.value || 'fullDay';
        var modalTypeInput = document.getElementById('mobile-booking-type');
        if (modalTypeInput) modalTypeInput.value = typeVal;
        modal.querySelectorAll('.mobile-price-opt').forEach(function(o) {
            o.style.border = '1px solid #e5e7eb';
            o.style.background = '';
            if (o.getAttribute('data-type') === typeVal) {
                o.style.border = '2px solid #127664';
                o.style.background = 'rgba(18, 118, 100, 0.08)';
            }
        });
    }

    // اختيار نوع السعر في مودال الموبايل
    const mobileBookingTypeInput = document.getElementById('mobile-booking-type');
    modal.querySelectorAll('.mobile-price-opt').forEach(function(opt) {
        opt.addEventListener('click', function() {
            modal.querySelectorAll('.mobile-price-opt').forEach(function(o) {
                o.style.border = '1px solid #e5e7eb';
                o.style.background = '';
            });
            this.style.border = '2px solid #127664';
            this.style.background = 'rgba(18, 118, 100, 0.08)';
            if (mobileBookingTypeInput) mobileBookingTypeInput.value = this.getAttribute('data-type');
            mobilePricePerNight = parseFloat(this.getAttribute('data-price')) || 0;
            var pageTypeEl = document.getElementById('mobile-selected-booking-type');
            var pagePriceEl = document.getElementById('mobile-selected-price');
            if (pageTypeEl) pageTypeEl.value = this.getAttribute('data-type');
            if (pagePriceEl) pagePriceEl.value = this.getAttribute('data-price');
            if (mobileCheckinInput && mobileCheckinInput.value && mobileCheckoutInput && mobileCheckoutInput.value) {
                calculateMobilePrice();
            } else {
                document.getElementById('mobile-nights-count').textContent = '1';
                document.getElementById('mobile-subtotal').textContent = Math.round(mobilePricePerNight).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
                document.getElementById('mobile-service-fee').textContent = '+' + Math.round(mobilePricePerNight * 0.04).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
                document.getElementById('mobile-total-price').textContent = Math.round(mobilePricePerNight * 1.04).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
                document.getElementById('mobile-price-per-night').textContent = Math.round(mobilePricePerNight * 1.04).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
            }
        });
    });

    // Add close button event
    const closeBtn = modal.querySelector('.close-modal-btn');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.remove();
            if (document.querySelector('.booking-overlay')) {
                document.querySelector('.booking-overlay').remove();
            }
        });
    }

    // Add overlay
    const overlay = document.createElement('div');
    overlay.className = 'booking-overlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
    `;
    overlay.onclick = function() {
        modal.remove();
        overlay.remove();
    };
    document.body.appendChild(overlay);

    // Setup date inputs and price calculation for mobile modal
    let mobilePricePerNight = {{ $chalet->default_day_price ?? 0 }};
    const mobileCheckinInput = document.getElementById('mobile-checkin-date');
    const mobileCheckoutInput = document.getElementById('mobile-checkout-date');
    const mobileCheckinDisplay = document.getElementById('mobile-checkin-display');
    const mobileCheckoutDisplay = document.getElementById('mobile-checkout-display');

    // Format date for display
    function formatMobileDate(dateStr) {
        if (!dateStr) return '{{ $isArabic ? "اختر التاريخ" : "Select Date" }}';
        const date = new Date(dateStr);
        const options = { day: 'numeric', month: 'short' };
        const locale = '{{ $isArabic ? "ar-SA" : "en-US" }}';
        return date.toLocaleDateString(locale, options);
    }

    // Calculate price for mobile
    function calculateMobilePrice() {
        if (!mobileCheckinInput.value || !mobileCheckoutInput.value) return;

        const checkin = new Date(mobileCheckinInput.value);
        const checkout = new Date(mobileCheckoutInput.value);

        if (checkout <= checkin) {
            mobileCheckoutInput.value = '';
            mobileCheckoutDisplay.textContent = '{{ $isArabic ? "اختر التاريخ" : "Select Date" }}';
            return;
        }

        const nights = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
        const subtotal = nights * mobilePricePerNight;
        const serviceFee = subtotal * 0.04;
        const total = subtotal + serviceFee;

        // Update mobile modal elements
        document.getElementById('mobile-nights-count').textContent = nights;
        document.getElementById('mobile-nights-label').textContent = nights > 1 ?
            '{{ $isArabic ? "ليالي" : "nights" }} ' + nights :
            '{{ $isArabic ? "ليلة واحدة" : "One night" }}';
        document.getElementById('mobile-subtotal').textContent = Math.round(subtotal).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
        document.getElementById('mobile-service-fee').textContent = '+' + Math.round(serviceFee).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
        document.getElementById('mobile-total-price').textContent = Math.round(total).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
        document.getElementById('mobile-price-per-night').textContent = Math.round(total).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
    }

    // Add event listeners for mobile date inputs
    if (mobileCheckinInput) {
        mobileCheckinInput.addEventListener('change', function() {
            mobileCheckinDisplay.textContent = formatMobileDate(this.value);
            if (this.value && mobileCheckoutInput) {
                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                mobileCheckoutInput.min = nextDay.toISOString().split('T')[0];
            }
            calculateMobilePrice();
        });
    }

    if (mobileCheckoutInput) {
        mobileCheckoutInput.addEventListener('change', function() {
            mobileCheckoutDisplay.textContent = formatMobileDate(this.value);
            calculateMobilePrice();
        });
    }

    // Handle mobile form submission
    const mobileBookingForm = document.getElementById('mobile-booking-form');
    if (mobileBookingForm) {
        mobileBookingForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!mobileCheckinInput.value || !mobileCheckoutInput.value) {
                alert('{{ $isArabic ? "يرجى اختيار تواريخ العرض" : "Please select booking dates" }}');
                return;
            }

            // Check if user is logged in
            @auth('customer')
                this.submit();
            @else
                // Save form data to localStorage
                localStorage.setItem('pendingBooking', JSON.stringify({
                    chalet_id: {{ $chalet->id }},
                    checkin_date: mobileCheckinInput.value,
                    checkout_date: mobileCheckoutInput.value,
                    return_url: window.location.href
                }));

                // Close modal and redirect to login
                modal.remove();
                overlay.remove();

                if (confirm('{{ $isArabic ? "يجب تسجيل الدخول أولاً. هل تريد الذهاب إلى صفحة تسجيل الدخول؟" : "You need to login first. Do you want to go to login page?" }}')) {
                    window.location.href = '{{ route("login") }}';
                }
            @endauth
        });
    }
};

// Google Maps Integration
window.initMap = function() {
    console.log('Initializing Google Map...');
    @if($chalet->latitude && $chalet->longitude)
        const chaletLocation = { lat: {{ $chalet->latitude }}, lng: {{ $chalet->longitude }} };

        const mapElement = document.getElementById("chalet-map");
        if (!mapElement) {
            console.error('Map element not found');
            return;
        }

        const map = new google.maps.Map(mapElement, {
            zoom: 15,
            center: chaletLocation,
            mapTypeControl: true,
            streetViewControl: true,
            fullscreenControl: true,
        });

        const marker = new google.maps.Marker({
            position: chaletLocation,
            map: map,
            title: "{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}",
            animation: google.maps.Animation.DROP,
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="padding: 10px;">
                    <h5>{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}</h5>
                    <p>{{ $chalet->location }}</p>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $chalet->latitude }},{{ $chalet->longitude }}"
                       target="_blank" class="btn btn-sm btn-primary mt-2">
                        {{ $isArabic ? 'احصل على الاتجاهات' : 'Get Directions' }}
                    </a>
                </div>
            `
        });

        marker.addListener("click", () => {
            infoWindow.open(map, marker);
        });
    @endif
};

// Show notification function
window.showNotification = function(type, message) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} notification-popup`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        min-width: 300px;
        animation: slideIn 0.3s ease;
    `;
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
};

// Show login alert
window.showLoginAlert = function() {
    if (confirm('{{ $isArabic ? "يجب تسجيل الدخول أولاً. هل تريد الذهاب إلى صفحة تسجيل الدخول؟" : "You need to login first. Do you want to go to login page?" }}')) {
        window.location.href = '{{ route("login") }}';
    }
};

// Edit Review Functions
window.editReview = function() {
    const editForm = document.getElementById('editReviewForm');
    if (editForm) editForm.style.display = 'block';
};

window.cancelEdit = function() {
    const editForm = document.getElementById('editReviewForm');
    if (editForm) editForm.style.display = 'none';
};

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - Initializing tabs and booking functionality');

    // خيارات السعر الظاهرة على الموبايل (في المحتوى)
    var mobileSelectedType = document.getElementById('mobile-selected-booking-type');
    var mobileSelectedPrice = document.getElementById('mobile-selected-price');
    var mobilePriceAmountBar = document.querySelector('.mobile-booking-bar .mobile-price-amount');
    var mobileSelectedPriceEl = document.querySelector('.mobile-selected-price');
    document.querySelectorAll('.mobile-price-inline-opt').forEach(function(opt) {
        opt.addEventListener('click', function() {
            document.querySelectorAll('.mobile-price-inline-opt').forEach(function(o) {
                o.style.borderColor = '#e5e7eb';
                o.style.borderWidth = '1px';
                o.style.background = '';
            });
            this.style.borderColor = '#127664';
            this.style.borderWidth = '2px';
            this.style.background = 'rgba(18, 118, 100, 0.08)';
            var type = this.getAttribute('data-type');
            var price = parseFloat(this.getAttribute('data-price')) || 0;
            if (mobileSelectedType) mobileSelectedType.value = type;
            if (mobileSelectedPrice) mobileSelectedPrice.value = price;
            if (mobilePriceAmountBar) mobilePriceAmountBar.textContent = Math.round(price).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
            if (mobileSelectedPriceEl) mobileSelectedPriceEl.textContent = Math.round(price).toLocaleString();
        });
    });

    // Tab functionality - Fixed selector
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    console.log('Found tabs:', tabButtons.length, 'Found contents:', tabContents.length);

    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const tabIndex = this.getAttribute('data-tab');
            console.log('Tab clicked:', tabIndex);

            // Remove active from all tabs and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Add active to clicked tab
            this.classList.add('active');

            // Find and activate the corresponding content
            const targetContent = document.querySelector(`.tab-content[data-content="${tabIndex}"]`);
            if (targetContent) {
                targetContent.classList.add('active');
                console.log('Activated tab content:', tabIndex);
            } else {
                console.error('Tab content not found for index:', tabIndex);
            }
        });
    });

    // Booking calculation - Check if elements exist
    const priceAmountElement = document.querySelector('.price-amount');
    let pricePerNight = priceAmountElement ? parseFloat(priceAmountElement.dataset.price || 0) : 0;
    const checkinInput = document.getElementById('checkin-date');

    // اختيار نوع السعر في الشريط الجانبي
    document.querySelectorAll('.price-type-option').forEach(function(opt) {
        opt.addEventListener('click', function() {
            document.querySelectorAll('.price-type-option').forEach(function(o) {
                o.classList.remove('active');
                o.style.borderColor = '#e5e7eb';
                o.style.background = '';
            });
            this.classList.add('active');
            this.style.borderColor = '#127664';
            this.style.background = 'rgba(18, 118, 100, 0.08)';
            const type = this.getAttribute('data-type');
            const price = parseFloat(this.getAttribute('data-price')) || 0;
            const bookingTypeInput = document.getElementById('booking-type-input');
            if (bookingTypeInput) bookingTypeInput.value = type;
            if (priceAmountElement) {
                priceAmountElement.dataset.price = price;
                priceAmountElement.textContent = Math.round(price).toLocaleString();
            }
            pricePerNight = price;
            if (document.getElementById('nights-count') && checkinInput && checkinInput.value && document.getElementById('checkout-date').value) {
                calculatePrice();
            } else {
                const nightsCountEl = document.getElementById('nights-count');
                const subtotalEl = document.getElementById('subtotal');
                const serviceFeeEl = document.getElementById('service-fee');
                const totalPriceEl = document.getElementById('total-price');
                const pricePerNightEl = document.getElementById('price-per-night');
                const breakdownUnit = document.getElementById('breakdown-unit-price');
                const oneNight = pricePerNight * 1.04;
                if (nightsCountEl) nightsCountEl.textContent = '1';
                if (subtotalEl) subtotalEl.textContent = Math.round(pricePerNight).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
                if (serviceFeeEl) serviceFeeEl.textContent = '+' + Math.round(pricePerNight * 0.04).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
                if (totalPriceEl) totalPriceEl.textContent = Math.round(oneNight).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
                if (pricePerNightEl) pricePerNightEl.textContent = Math.round(oneNight).toLocaleString();
                if (breakdownUnit) breakdownUnit.textContent = Math.round(pricePerNight).toLocaleString();
            }
        });
    });
    const checkoutInput = document.getElementById('checkout-date');
    const checkinDisplay = document.getElementById('checkin-display');
    const checkoutDisplay = document.getElementById('checkout-display');

    // Format date for display
    function formatDate(dateStr) {
        if (!dateStr) return '{{ $isArabic ? "اختر التاريخ" : "Select Date" }}';
        const date = new Date(dateStr);
        const options = { weekday: 'long', day: 'numeric', month: 'long' };
        const locale = '{{ $isArabic ? "ar-SA" : "en-US" }}';
        return date.toLocaleDateString(locale, options);
    }

    // Update date displays - Check if elements exist
    if (checkinInput) {
        checkinInput.addEventListener('change', function() {
            if (checkinDisplay) {
                checkinDisplay.textContent = formatDate(this.value);
            }
            // Update checkout min date
            if (this.value && checkoutInput) {
                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                checkoutInput.min = nextDay.toISOString().split('T')[0];
            }
            calculatePrice();
        });
    }

    if (checkoutInput) {
        checkoutInput.addEventListener('change', function() {
            if (checkoutDisplay) {
                checkoutDisplay.textContent = formatDate(this.value);
            }
            calculatePrice();
        });
    }

    function calculatePrice() {
        if (!checkinInput || !checkoutInput || !checkinInput.value || !checkoutInput.value) return;
        const currentPriceEl = document.querySelector('.price-amount');
        const currentPrice = currentPriceEl ? parseFloat(currentPriceEl.dataset.price || 0) : pricePerNight;

        const checkin = new Date(checkinInput.value);
        const checkout = new Date(checkoutInput.value);

        if (checkout <= checkin) {
            checkoutInput.value = '';
            checkoutDisplay.textContent = '{{ $isArabic ? "اختر التاريخ" : "Select Date" }}';
            alert('{{ $isArabic ? "تاريخ المغادرة يجب أن يكون بعد تاريخ الوصول" : "Checkout date must be after checkin date" }}');
            return;
        }

        const nights = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
        const subtotal = nights * currentPrice;
        const serviceFee = subtotal * 0.04; // 4% service fee
        const total = subtotal + serviceFee;

        // Update price breakdown - Check if elements exist
        const nightsCountEl = document.getElementById('nights-count');
        const nightsLabelEl = document.getElementById('nights-count-label');
        const subtotalEl = document.getElementById('subtotal');
        const serviceFeeEl = document.getElementById('service-fee');
        const totalPriceEl = document.getElementById('total-price');
        const pricePerNightEl = document.getElementById('price-per-night');

        if (nightsCountEl) nightsCountEl.textContent = nights;
        if (nightsLabelEl) {
            nightsLabelEl.textContent = nights > 1 ?
                '{{ $isArabic ? "ليالي" : "nights" }} ' + nights :
                '{{ $isArabic ? "ليلة واحدة" : "One night" }}';
        }
        const breakdownUnit = document.getElementById('breakdown-unit-price');
        if (breakdownUnit) breakdownUnit.textContent = Math.round(currentPrice).toLocaleString();
        if (subtotalEl) subtotalEl.textContent = Math.round(subtotal).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
        if (serviceFeeEl) serviceFeeEl.textContent = '+' + Math.round(serviceFee).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
        if (totalPriceEl) totalPriceEl.textContent = Math.round(total).toLocaleString() + ' {{ $isArabic ? "ر.ع" : "OMR" }}';
        if (pricePerNightEl) pricePerNightEl.textContent = Math.round(total).toLocaleString();
    }

    // Function to check availability
    function checkChaletAvailability(chaletId, checkinDate, checkoutDate, callback) {
        console.log('Checking availability for:', {
            chalet_id: chaletId,
            checkin_date: checkinDate,
            checkout_date: checkoutDate
        });

        fetch('{{ route("chalet.check.availability") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                chalet_id: chaletId,
                checkin_date: checkinDate,
                checkout_date: checkoutDate
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Availability response:', data);
            callback(data);
        })
        .catch(error => {
            console.error('Error checking availability:', error);
            callback({ available: false, message: '{{ $isArabic ? "حدث خطأ في التحقق من التوفر" : "Error checking availability" }}' });
        });
    }

    // Form submission handling - Check if form exists
    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();

        // Format date for display
        function formatDate(dateStr) {
            if (!dateStr) return '{{ $isArabic ? "اختر التاريخ" : "Select Date" }}';
            const date = new Date(dateStr);
            const options = { weekday: 'long', day: 'numeric', month: 'long' };
            const locale = '{{ $isArabic ? "ar-SA" : "en-US" }}';
            return date.toLocaleDateString(locale, options);
        }

        // Update date displays - Check if elements exist
        if (checkinInput) {
            checkinInput.addEventListener('change', function() {
                if (checkinDisplay) {
                    checkinDisplay.textContent = formatDate(this.value);
                }
                // Update checkout min date
                if (this.value && checkoutInput) {
                    const nextDay = new Date(this.value);
                    nextDay.setDate(nextDay.getDate() + 1);
                    checkoutInput.min = nextDay.toISOString().split('T')[0];
                }
                calculatePrice();
            });
        }

        if (checkoutInput) {
            checkoutInput.addEventListener('change', function() {
                if (checkoutDisplay) {
                    checkoutDisplay.textContent = formatDate(this.value);
                }
                calculatePrice();
            });
        }

        function calculatePrice() {
            if (!checkinInput || !checkoutInput || !checkinInput.value || !checkoutInput.value) return;

            const checkin = new Date(checkinInput.value);
            const checkout = new Date(checkoutInput.value);

            if (checkout <= checkin) {
                checkoutInput.value = '';
                checkoutDisplay.textContent = '{{ $isArabic ? "اختر التاريخ" : "Select Date" }}';
                alert('{{ $isArabic ? "تاريخ المغادرة يجب أن يكون بعد تاريخ الوصول" : "Checkout date must be after checkin date" }}');
                return;
            }

            const nights = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
            const subtotal = nights * pricePerNight;
            const serviceFee = subtotal * 0.04; // 4% service fee
            const total = subtotal + serviceFee;

            // Update price breakdown - Check if elements exist
            const nightsCountEl = document.getElementById('nights-count');
            const nightsLabelEl = document.getElementById('nights-count-label');
            const subtotalEl = document.getElementById('subtotal');
            const serviceFeeEl = document.getElementById('service-fee');
            const totalPriceEl = document.getElementById('total-price');
            const pricePerNightEl = document.getElementById('price-per-night');

            if (nightsCountEl) nightsCountEl.textContent = nights;
            if (nightsLabelEl) {
                nightsLabelEl.textContent = nights > 1 ?
                    '{{ $isArabic ? "ليالي" : "nights" }} ' + nights :
                    '{{ $isArabic ? "ليلة واحدة" : "One night" }}';
            }
            if (subtotalEl) subtotalEl.textContent = Math.round(subtotal).toLocaleString() + ' {{ $isArabic ? "ريال" : "SAR" }}';
            if (serviceFeeEl) serviceFeeEl.textContent = '+' + Math.round(serviceFee).toLocaleString() + ' {{ $isArabic ? "ريال" : "SAR" }}';
            if (totalPriceEl) totalPriceEl.textContent = Math.round(total).toLocaleString() + ' {{ $isArabic ? "ريال" : "SAR" }}';
            if (pricePerNightEl) pricePerNightEl.textContent = Math.round(total).toLocaleString();
        }

        if (!checkinInput.value || !checkoutInput.value) {
                // Show error in modal instead of alert
                document.getElementById('modalTitle').textContent = '{{ $isArabic ? "تنبيه" : "Alert" }}';
                document.getElementById('modalMessage').textContent = '{{ $isArabic ? "يرجى اختيار تواريخ العرض" : "Please select booking dates" }}';
                document.getElementById('modalIcon').innerHTML = `
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                `;
                document.getElementById('modalButtons').innerHTML = `
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $isArabic ? "حسناً" : "OK" }}</button>
                `;
                new bootstrap.Modal(document.getElementById('bookingModal')).show();
                return;
            }

            // Show loading modal
            document.getElementById('modalTitle').textContent = '{{ $isArabic ? "جاري التحقق..." : "Checking..." }}';
            document.getElementById('modalMessage').textContent = '{{ $isArabic ? "يرجى الانتظار، جاري التحقق من توفر الشاليه..." : "Please wait, checking chalet availability..." }}';
            document.getElementById('modalIcon').innerHTML = `
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            `;
            document.getElementById('modalButtons').innerHTML = '';
            const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
            modal.show();

            // Check availability
            checkChaletAvailability({{ $chalet->id }}, checkinInput.value, checkoutInput.value, function(data) {
                if (!data.available) {
                    // Show unavailable message
                    document.getElementById('modalTitle').textContent = '{{ $isArabic ? "الشاليه محجوز" : "Chalet Unavailable" }}';
                    document.getElementById('modalMessage').textContent = data.message;
                    document.getElementById('modalIcon').innerHTML = `
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    `;
                    document.getElementById('modalButtons').innerHTML = `
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ $isArabic ? "اختر تواريخ أخرى" : "Choose Different Dates" }}</button>
                    `;
                    return;
                }

                // Check if user is logged in
                @auth('customer')
                    // User is logged in, submit the form
                    bookingForm.submit();
                @else
                    // User is not logged in, show login modal
                    // Save form data to localStorage
                    var btInput = document.getElementById('booking-type-input');
                    localStorage.setItem('pendingBooking', JSON.stringify({
                        chalet_id: {{ $chalet->id }},
                        checkin_date: checkinInput.value,
                        checkout_date: checkoutInput.value,
                        checkin_time: (document.querySelector('[name="checkin_time"]') && document.querySelector('[name="checkin_time"]').value) || '{{ $chalet->check_in_time ?? "15:00" }}',
                        checkout_time: (document.querySelector('[name="checkout_time"]') && document.querySelector('[name="checkout_time"]').value) || '{{ $chalet->check_out_time ?? "12:00" }}',
                        number_of_guests: document.querySelector('[name="number_of_guests"]').value,
                        special_requests: document.querySelector('[name="special_requests"]').value,
                        booking_type: btInput ? btInput.value : 'fullDay',
                        return_url: window.location.href
                    }));

                    // Show the login modal
                    document.getElementById('modalTitle').textContent = '{{ $isArabic ? "تسجيل الدخول مطلوب" : "Login Required" }}';
                    document.getElementById('modalMessage').textContent = '{{ $isArabic ? "للمتابعة في عملية العرض، يرجى تسجيل الدخول أو إنشاء حساب جديد" : "To continue with your booking, please login or create a new account" }}';
                    document.getElementById('modalIcon').innerHTML = '<i class="fas fa-user-lock text-primary" style="font-size: 48px;"></i>';
                    document.getElementById('modalButtons').innerHTML = `
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            {{ $isArabic ? "تسجيل الدخول" : "Login" }}
                        </a>
                        <a href="{{ route('customer_register') }}" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i>
                            {{ $isArabic ? "حساب جديد" : "Register" }}
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ $isArabic ? "إلغاء" : "Cancel" }}
                        </button>
                    `;
                    new bootstrap.Modal(document.getElementById('bookingModal')).show();
                @endauth
            });
        });
    }

    // Check for pending booking after login
    @auth('customer')
        // If user is logged in and there's pending booking data
        const pendingBooking = localStorage.getItem('pendingBooking');
        if (pendingBooking && bookingForm) {
            const data = JSON.parse(pendingBooking);
            if (data.chalet_id == {{ $chalet->id }}) {
                // Restore all form values
                checkinInput.value = data.checkin_date;
                checkoutInput.value = data.checkout_date;
                document.querySelectorAll('[name="checkin_time"]').forEach(function(el) { el.value = data.checkin_time || '{{ $chalet->check_in_time ?? "15:00" }}'; });
                document.querySelectorAll('[name="checkout_time"]').forEach(function(el) { el.value = data.checkout_time || '{{ $chalet->check_out_time ?? "12:00" }}'; });
                document.querySelector('[name="number_of_guests"]').value = data.number_of_guests || 2;
                document.querySelector('[name="special_requests"]').value = data.special_requests || '';
                var btInput = document.getElementById('booking-type-input');
                if (btInput && data.booking_type) btInput.value = data.booking_type;
                var opt = document.querySelector('.price-type-option[data-type="' + (data.booking_type || 'fullDay') + '"]');
                if (opt) opt.click();
                calculatePrice();

                // Show success modal and auto-submit
                setTimeout(() => {
                    document.getElementById('modalTitle').textContent = '{{ $isArabic ? "مرحباً بعودتك!" : "Welcome back!" }}';
                    document.getElementById('modalMessage').textContent = '{{ $isArabic ? "جاري إكمال عرضك..." : "Completing your booking..." }}';
                    document.getElementById('modalIcon').innerHTML = '<i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>';
                    document.getElementById('modalButtons').innerHTML = '';
                    new bootstrap.Modal(document.getElementById('bookingModal')).show();

                    // Submit the form after a short delay
                    setTimeout(() => {
                        bookingForm.submit();
                    }, 1500);
                }, 500);

                localStorage.removeItem('pendingBooking');
            }
        } else if (pendingBooking && !bookingForm) {
            localStorage.removeItem('pendingBooking');
        }
    @endauth
});

// Show notification function
function showNotification(type, message) {
    const notification = document.createElement('div');
    notification.className = `toast-notification ${type}`;
    notification.innerHTML = `
        <div class="toast-icon">
            ${type === 'success' ? '✓' : '✕'}
        </div>
        <div class="toast-message">${message}</div>
    `;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Share functionality
function shareChalet() {
    const chaletName = "{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}";
    const chaletUrl = window.location.href;

    if (navigator.share) {
        // Use Web Share API if available (mobile)
        navigator.share({
            title: chaletName,
            text: '{{ $isArabic ? "شاهد هذا الشاليه الرائع على شاليك عمان" : "Check out this amazing chalet on Shaleek Oman" }}',
            url: chaletUrl
        }).catch(err => console.log('Error sharing:', err));
    } else {
        // Fallback: Copy link to clipboard
        navigator.clipboard.writeText(chaletUrl).then(() => {
            showNotification('success', '{{ $isArabic ? "تم نسخ الرابط بنجاح" : "Link copied successfully" }}');
        }).catch(() => {
            // Fallback for older browsers
            const textArea = document.createElement("textarea");
            textArea.value = chaletUrl;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showNotification('success', '{{ $isArabic ? "تم نسخ الرابط بنجاح" : "Link copied successfully" }}');
        });
    }
}

// Show login alert for non-authenticated users
function showLoginAlert() {
    if (confirm('{{ $isArabic ? "يجب تسجيل الدخول أولاً. هل تريد الانتقال لصفحة تسجيل الدخول؟" : "You need to login first. Do you want to go to login page?" }}')) {
        window.location.href = "{{ route('login') }}";
    }
}

// Functions for edit review
function editReview() {
    document.getElementById('editReviewForm').style.display = 'block';
}

function cancelEdit() {
    document.getElementById('editReviewForm').style.display = 'none';
}

// Review Form JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Rating stars interaction
    const stars = document.querySelectorAll('.star-clickable');
    const ratingInput = document.getElementById('ratingInput');
    const ratingText = document.querySelector('.rating-text');

    const ratingTexts = {
        ar: ['', 'سيء', 'مقبول', 'جيد', 'جيد جداً', 'ممتاز'],
        en: ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent']
    };

    const isArabic = '{{ $isArabic }}' === '1';

    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            ratingInput.value = rating;

            // Update stars appearance
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('active');
                    s.classList.remove('inactive');
                } else {
                    s.classList.add('inactive');
                    s.classList.remove('active');
                }
            });

            // Update rating text
            if (ratingText) {
                ratingText.textContent = isArabic ? ratingTexts.ar[rating] : ratingTexts.en[rating];
            }
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.style.color = '#FFA500';
                } else {
                    s.style.color = '#d3d3d3';
                }
            });
        });
    });

    // Reset stars on mouse leave
    const starsContainer = document.getElementById('starsInput');
    if (starsContainer) {
        starsContainer.addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value);
            stars.forEach((s, i) => {
                if (i < currentRating) {
                    s.style.color = '#FFA500';
                } else {
                    s.style.color = '#d3d3d3';
                }
            });
        });
    }

    // Character counter for comment
    const commentTextarea = document.getElementById('comment');
    const charCount = document.getElementById('charCount');

    if (commentTextarea && charCount) {
        commentTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }

    // Form submission with validation
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            const rating = document.getElementById('ratingInput').value;
            if (!rating || rating < 1 || rating > 5) {
                e.preventDefault();
                alert(isArabic ? 'الرجاء اختيار تقييم' : 'Please select a rating');
                return false;
            }
        });
    }

    // Edit form stars interaction
    const editStars = document.querySelectorAll('.star-edit-clickable');
    const editRatingInput = document.getElementById('editRatingInput');
    const editRatingText = document.querySelector('.edit-rating-text');

    editStars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            if (editRatingInput) {
                editRatingInput.value = rating;
            }

            // Update stars appearance
            editStars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('active');
                    s.classList.remove('inactive');
                } else {
                    s.classList.add('inactive');
                    s.classList.remove('active');
                }
            });

            // Update rating text
            if (editRatingText) {
                editRatingText.textContent = isArabic ? ratingTexts.ar[rating] : ratingTexts.en[rating];
            }
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            editStars.forEach((s, i) => {
                if (i < rating) {
                    s.style.color = '#FFA500';
                } else {
                    s.style.color = '#d3d3d3';
                }
            });
        });
    });

    // Reset edit stars on mouse leave
    const editStarsContainer = document.getElementById('editStarsInput');
    if (editStarsContainer) {
        editStarsContainer.addEventListener('mouseleave', function() {
            const currentRating = editRatingInput ? parseInt(editRatingInput.value) : 0;
            editStars.forEach((s, i) => {
                if (i < currentRating) {
                    s.style.color = '#FFA500';
                } else {
                    s.style.color = '#d3d3d3';
                }
            });
        });
    }

    // Character counter for edit comment
    const editCommentTextarea = document.getElementById('editComment');
    const editCharCount = document.getElementById('editCharCount');

    if (editCommentTextarea && editCharCount) {
        editCommentTextarea.addEventListener('input', function() {
            editCharCount.textContent = this.value.length;
        });
    }

    // ========================================
    // WISHLIST FUNCTIONALITY
    // ========================================
    const wishlistBtn = document.getElementById('wishlistBtn');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            const btn = this;
            const chaletId = btn.dataset.chaletId;
            const svgPath = btn.querySelector('svg path');
            const span = btn.querySelector('span');

            if (!@json(auth('customer')->check())) {
                if (confirm('{{ $isArabic ? "يجب تسجيل الدخول أولاً لإضافة الشاليه إلى المفضلة. هل تريد الذهاب إلى صفحة تسجيل الدخول؟" : "Please login first to add this chalet to wishlist. Do you want to go to login page?" }}')) {
                    window.location.href = '{{ route("login") }}';
                }
                return;
            }

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
                    svgPath.setAttribute('fill', '#dc3545');
                    svgPath.setAttribute('stroke', '#dc3545');
                    span.textContent = '{{ $isArabic ? "في المفضلة" : "In Favorites" }}';
                    showNotification('success', data.message || '{{ $isArabic ? "تم إضافة الشاليه إلى المفضلة" : "Chalet added to favorites" }}');
                } else if (data.status === 'removed') {
                    svgPath.setAttribute('fill', 'none');
                    svgPath.setAttribute('stroke', '#159265');
                    span.textContent = '{{ $isArabic ? "المفضلة" : "Favorite" }}';
                    showNotification('success', data.message || '{{ $isArabic ? "تم إزالة الشاليه من المفضلة" : "Chalet removed from favorites" }}');
                }
                btn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', '{{ $isArabic ? "حدث خطأ. يرجى المحاولة مرة أخرى" : "An error occurred. Please try again" }}');
                btn.disabled = false;
            });
        });
    }

    // ========================================
    // MOBILE ENHANCEMENTS
    // ========================================
    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
        console.log('Mobile mode activated');
        document.body.classList.add('is-mobile-device');
        document.body.classList.add('chalet-details-page');

        // Create floating book button
        const bookingCard = document.querySelector('.booking-card');
        if (bookingCard && !document.querySelector('.book-now-floating')) {
            // Hide booking card initially
            bookingCard.classList.remove('show');

            // Create floating button
            const floatingBtn = document.createElement('button');
            floatingBtn.className = 'book-now-floating';
            floatingBtn.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span>{{ $isArabic ? 'اعرض الآن' : 'Book Now' }}</span>
                    <span style="font-size: 1.2rem; font-weight: bold;">
                        {{ $chalet->price_per_night }} {{ $isArabic ? 'ر.ع' : 'OMR' }}
                    </span>
                </div>
            `;
            document.body.appendChild(floatingBtn);

            // Toggle booking card on button click
            floatingBtn.addEventListener('click', function() {
                bookingCard.classList.toggle('show');
                if (bookingCard.classList.contains('show')) {
                    floatingBtn.style.display = 'none';
                    // Add overlay
                    const overlay = document.createElement('div');
                    overlay.className = 'booking-overlay';
                    overlay.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: rgba(0,0,0,0.5);
                        z-index: 999;
                    `;
                    document.body.appendChild(overlay);

                    overlay.addEventListener('click', function() {
                        bookingCard.classList.remove('show');
                        floatingBtn.style.display = 'block';
                        document.body.removeChild(overlay);
                    });
                }
            });
        }

        // Improve image gallery on mobile - make images clickable
        const imageGrid = document.querySelector('.property-images-grid');
        if (imageGrid) {
            const images = imageGrid.querySelectorAll('img');
            images.forEach(img => {
                img.style.cursor = 'pointer';
                img.addEventListener('click', function() {
                    // Create fullscreen viewer
                    const viewer = document.createElement('div');
                    viewer.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: rgba(0,0,0,0.95);
                        z-index: 10000;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 20px;
                    `;

                    const fullImg = document.createElement('img');
                    fullImg.src = this.src;
                    fullImg.style.cssText = `
                        max-width: 100%;
                        max-height: 100%;
                        object-fit: contain;
                    `;

                    const closeBtn = document.createElement('button');
                    closeBtn.innerHTML = '×';
                    closeBtn.style.cssText = `
                        position: absolute;
                        top: 20px;
                        right: 20px;
                        background: white;
                        border: none;
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        font-size: 30px;
                        cursor: pointer;
                        z-index: 10001;
                    `;

                    viewer.appendChild(fullImg);
                    viewer.appendChild(closeBtn);
                    document.body.appendChild(viewer);

                    // Close on click
                    viewer.addEventListener('click', function() {
                        document.body.removeChild(viewer);
                    });

                    closeBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        document.body.removeChild(viewer);
                    });
                });
            });
        }

        // Function is now global and can be called from onclick

        // Fix tabs scrolling on mobile
        const tabsNav = document.querySelector('.specs-tabs-navigation');
        if (tabsNav) {
            tabsNav.style.overflowX = 'auto';
            tabsNav.style.WebkitOverflowScrolling = 'touch';
        }

        // Smooth scroll to sections
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
    }
});
</script>

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST"
                  action="{{ route('chalet.report') }}"
                  enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="chalet_id" value="{{ $chalet->id }}">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $isArabic ? 'الإبلاغ عن مخالفة عقارية' : 'Report Property Violation' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Reason -->
                    <div class="mb-3">
                        <label class="form-label">{{ $isArabic ? 'سبب البلاغ' : 'Reason' }}</label>
                        <select name="reason" class="form-select" required id="reportReason">
                            <option value="">{{ $isArabic ? 'اختر السبب' : 'Select reason' }}</option>
                            <option>عدم تطابق العقار مع الوصف</option>
                            <option>بلاغ احتيال عقاري</option>
                            <option>بلاغ إعلان مضلل</option>
                            <option>عدم وجود العقار على أرض الواقع</option>
                            <option>انتحال صفة مالك</option>
                            <option>تأخير تسليم العقار</option>
                            <option>سوء معاملة من المعلن</option>
                            <option>عقار بدون ترخيص</option>
                            <option value="other">غير ذلك</option>
                        </select>
                    </div>

                    <!-- Other reason -->
                    <div class="mb-3 d-none" id="otherReasonBox">
                        <textarea name="other_reason"
                                  class="form-control"
                                  placeholder="{{ $isArabic ? 'اذكر السبب' : 'Mention the reason' }}"></textarea>
                    </div>

                    <!-- Attachments -->
                    <div class="mb-3">
                        <label class="form-label">{{ $isArabic ? 'إرفاق مستندات (اختياري)' : 'Attachments (optional)' }}</label>
                        <input type="file" name="attachments[]" class="form-control" multiple>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        {{ $isArabic ? 'إرسال البلاغ' : 'Submit Report' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.getElementById('reportReason').addEventListener('change', function () {
    document.getElementById('otherReasonBox')
        .classList.toggle('d-none', this.value !== 'other');
});
</script>


{{-- Load Google Maps API with async loading --}}
@if($chalet->latitude && $chalet->longitude)
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&callback=initMap&language={{ $isArabic ? 'ar' : 'en' }}&loading=async">
</script>
@endif

@endsection
