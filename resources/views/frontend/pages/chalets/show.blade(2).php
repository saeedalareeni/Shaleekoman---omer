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
        
        /* Images Grid Styles */
        .property-images-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 10px;
            margin-top: 20px;
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .large-image-wrapper {
            position: relative;
            height: 100%;
            overflow: hidden;
            border-radius: 12px 0 0 12px;
        }
        
        .large-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .large-image-wrapper:hover img {
            transform: scale(1.05);
        }
        
        .images-column-small {
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: repeat(4, 1fr);
            gap: 10px;
            height: 100%;
        }
        
        .small-image-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 0 12px 12px 0;
        }
        
        .small-image-wrapper:first-child {
            border-radius: 0 12px 0 0;
        }
        
        .small-image-wrapper:last-child {
            border-radius: 0 0 12px 0;
        }
        
        .small-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        
        .small-image-wrapper:hover img {
            transform: scale(1.1);
        }
        
        /* Mobile Responsive - Complete Redesign */
        @media (max-width: 768px) {
            /* Hide desktop elements */
            .property-card-section {
                display: none !important;
            }
            
            /* Mobile-only layout */
            body {
                padding: 0 !important;
                margin: 0 !important;
            }
            
            .container, .container-fluid {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            
            .row {
                margin: 0 !important;
            }
            
            .col-lg-8, .col-lg-4, [class*="col-"] {
                padding: 0 !important;
                width: 100% !important;
            }
            
            /* Images Section */
            .property-images-grid {
                display: block !important;
                margin: 0 !important;
                padding: 0 !important;
                height: auto !important;
                border-radius: 0 !important;
            }
            
            .large-image-wrapper {
                width: 100% !important;
                height: 250px !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }
            
            .large-image-wrapper img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
            }
            
            .images-column-small {
                display: flex !important;
                overflow-x: auto !important;
                gap: 5px !important;
                padding: 10px !important;
                height: 80px !important;
            }
            
            .small-image-wrapper {
                flex: 0 0 100px !important;
                height: 70px !important;
                border-radius: 6px !important;
            }
            
            .small-image-wrapper img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
            }
            
            /* Title Section */
            .property-header {
                padding: 15px !important;
                background: white !important;
            }
            
            .property-card-title {
                font-size: 1.2rem !important;
                font-weight: 600 !important;
                margin-bottom: 8px !important;
            }
            
            /* Content Sections */
            .content-wrapper {
                padding: 0 15px !important;
            }
            
            /* Tabs */
            .specs-tabs-navigation {
                display: flex !important;
                overflow-x: auto !important;
                padding: 0 15px !important;
                gap: 10px !important;
                border-bottom: 1px solid #e5e7eb !important;
                background: white !important;
            }
            
            .tab-btn {
                padding: 12px 16px !important;
                font-size: 0.85rem !important;
                white-space: nowrap !important;
                border: none !important;
                background: transparent !important;
            }
            
            .tab-btn.active {
                color: #127664 !important;
                border-bottom: 2px solid #127664 !important;
            }
            
            /* Booking Section - Fixed Bottom */
            .booking-card {
                display: none !important;
            }
            
            .mobile-booking-bar {
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                background: white !important;
                padding: 12px 15px !important;
                box-shadow: 0 -2px 10px rgba(0,0,0,0.1) !important;
                z-index: 1000 !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
            }
            
            .mobile-price {
                display: flex !important;
                flex-direction: column !important;
            }
            
            .mobile-price-amount {
                font-size: 1.3rem !important;
                font-weight: 700 !important;
                color: #127664 !important;
            }
            
            .mobile-price-period {
                font-size: 0.75rem !important;
                color: #666 !important;
            }
            
            .mobile-book-btn {
                background: #127664 !important;
                color: white !important;
                padding: 10px 24px !important;
                border-radius: 8px !important;
                font-weight: 600 !important;
                border: none !important;
                font-size: 0.95rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .large-image-wrapper {
                height: 200px;
            }
            
            .images-column-small {
                grid-template-columns: repeat(2, 1fr);
                height: 80px;
            }
            
            .small-image-wrapper {
                height: 80px;
            }
        }
        
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
        
        /* Tabs Navigation */
        .specs-tabs-navigation {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
            padding: 0 20px;
            background: #f8f9fa;
            border-radius: 12px 12px 0 0;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
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
        
        @media (max-width: 991px) {
            .booking-card-section .row {
                flex-wrap: wrap !important;
            }
            
            .booking-card-section .col-lg-8,
            .booking-card-section .col-lg-4 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
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
        
        /* Additional Responsive Fixes */
        @media (max-width: 1400px) {
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
                gap: 5px;
                margin-bottom: 15px;
            }
            
            .tab-btn {
                padding: 12px 16px;
                font-size: 13px;
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
        
        /* GRID الرئيسي */
.property-images-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 12px;
}

/* الصورة الكبيرة */
.large-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

/* العمود الجانبي */
.images-column-small {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-auto-rows: 1fr;
    gap: 12px;
}

/* كل صورة جانبية */
.small-image-wrapper {
    width: 100%;
    height: 100%;
}

.small-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

/* لو 3 صور فقط */
.images-column-small.three-images {
    grid-template-columns: repeat(2, 1fr);
}

/* الصورة الثالثة تمتد عرض العمود */
.images-column-small.three-images .full-width {
    grid-column: span 2;
}

/* 📱 موبايل */
@media (max-width: 991px) {
    .property-images-grid {
        grid-template-columns: 1fr;
    }

    .images-column-small {
        grid-template-columns: repeat(2, 1fr);
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
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.6 17H11.4C15.4 17 17 15.4 17 11.4V6.6C17 2.6 15.4 1 11.4 1H6.6C2.6 1 1 2.6 1 6.6V11.4C1 15.4 2.6 17 6.6 17Z" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.59961 1L10.5596 17" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8.62402 9.17596L1 11.4" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="feature-label">{{ $isArabic ? 'مساحة الوحدة ' . ($chalet->area_size ?? 450) . ' م' : 'Unit area ' . ($chalet->area_size ?? 450) . ' m' }}</span>
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
                @auth('customer')
                    <button class="btn-action btn-favorite" id="wishlistBtn" data-chalet-id="{{ $chalet->id }}">
                        @if(auth('customer')->user()->wishlist()->where('chalet_id', $chalet->id)->exists())
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
                @else
                    <button class="btn-action btn-favorite" onclick="showLoginAlert()">
                        <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.275 22.8888C13.85 23.0371 13.15 23.0371 12.725 22.8888C9.1 21.6652 1 16.5607 1 7.90899C1 4.08989 4.1125 1 7.95 1C10.225 1 12.2375 2.08764 13.5 3.76854C14.7625 2.08764 16.7875 1 19.05 1C22.8875 1 26 4.08989 26 7.90899C26 16.5607 17.9 21.6652 14.275 22.8888Z" stroke="#159265" stroke-width="2"/>
                        </svg>
                        <span>{{ $isArabic ? 'المفضلة' : 'Favorite' }}</span>
                    </button>
                @endauth
                
                <button class="btn-action btn-share" onclick="shareChalet()">
                    <svg width="23" height="25" viewBox="0 0 23 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.5 2.53333V15.5667M16 5.6L11.5 1L7 5.6M1 13.2667V20.9333C1 21.7467 1.31607 22.5267 1.87868 23.1018C2.44129 23.6769 3.20435 24 4 24H19C19.7956 24 20.5587 23.6769 21.1213 23.1018C21.6839 22.5267 22 21.7467 22 20.9333V13.2667" stroke="#127664" stroke-width="1.8"/>
                    </svg>
                    <span>{{ $isArabic ? 'مشاركة' : 'Share' }}</span>
                </button>
            </div>
        </div>

      {{-- Desktop Layout --}}
<div class="property-images-grid d-none d-lg-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 10px;">

    {{-- Main Image --}}
    <div class="large-image-wrapper">
        <a href="{{ asset($chalet->main_image ?? 'no_image.png') }}"
           class="glightbox"
           data-gallery="chalet-gallery">
            <img src="{{ asset($chalet->main_image ?? 'no_image.png') }}" 
                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </a>
    </div>

    @php
        $additionalImages = $chalet->images->take(4);
        $imageCount = $additionalImages->count();
    @endphp

    {{-- Side Images Column --}}
    <div class="images-column-small" style="display: grid; grid-template-rows: repeat(4, 1fr); gap: 10px;">
        @if($imageCount > 0)
            @foreach($additionalImages as $image)
                <div class="small-image-wrapper" style="width: 100%; height: 100%;">
                    <a href="{{ asset($image->image_path) }}"
                       class="glightbox"
                       data-gallery="chalet-gallery">
                        <img src="{{ asset($image->image_path) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                    </a>
                </div>
            @endforeach
        @else
            @for($i = 0; $i < 4; $i++)
                <div class="small-image-wrapper" style="width: 100%; height: 100%;">
                    <a href="{{ asset('no_image.png') }}"
                       class="glightbox"
                       data-gallery="chalet-gallery">
                        <img src="{{ asset('no_image.png') }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                    </a>
                </div>
            @endfor
        @endif
    </div>
</div>

{{-- Mobile Layout --}}
<div class="d-lg-none mobile-layout">

    @php
        $allImages = collect([]);
        if($chalet->main_image) { $allImages->push($chalet->main_image); }
        if($chalet->images) { $allImages = $allImages->merge($chalet->images->pluck('image_path')); }
    @endphp

    {{-- Main Mobile Image --}}
    <div style="position: relative; width: 100%; height: 250px; overflow: hidden; margin-bottom: 10px;">
        @if($allImages->isNotEmpty())
            <img src="{{ asset($allImages[0]) }}" 
                 alt="{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}" 
                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        @else
            <img src="{{ asset('no_image.png') }}" alt="No Image" 
                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        @endif

        {{-- Horizontal Thumbnails --}}
        @if($allImages->count() > 1)
            <div style="position: absolute; bottom: 10px; left: 10px; right: 10px; display: flex; gap: 5px; overflow-x: auto;">
                @foreach($allImages as $index => $image)
                    @if($index < 5)
                        <a href="{{ asset($image) }}" class="glightbox" data-gallery="chalet-gallery">
                            <img src="{{ asset($image) }}" alt="Image {{ $index + 1 }}" 
                                 style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 2px solid white; opacity: 0.8; cursor: pointer;">
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>



<!-- Mobile Layout (Visible on Mobile Only) -->
<div class="d-lg-none mobile-layout">
    <!-- Mobile Images Section -->
    <div style="position: relative; width: 100%; height: 250px; overflow: hidden;">
        @if($chalet->main_image)
            <img src="{{ asset($chalet->main_image) }}" alt="{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}" 
                 style="width: 100%; height: 100%; object-fit: cover;">
        @elseif($chalet->images && count($chalet->images) > 0)
            <img src="{{ asset($chalet->images[0]->image_path ?? $chalet->images[0]->image) }}" alt="{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}" 
                 style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <img src="{{ asset('no_image.png') }}" alt="No Image" 
                 style="width: 100%; height: 100%; object-fit: cover;">
        @endif
        
        @if($chalet->images && count($chalet->images) > 1)
        <div style="position: absolute; bottom: 10px; left: 10px; right: 10px; display: flex; gap: 5px; overflow-x: auto;">
            @foreach($chalet->images as $index => $image)
                @if($index < 5)
                <img src="{{ asset($image->image_path ?? $image->image) }}" alt="Image {{ $index + 1 }}" 
                     style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 2px solid white; opacity: 0.8; cursor: pointer;">
                @endif
            @endforeach
        </div>
        @endif
    </div>
    
    <!-- Mobile Header -->
    <div class="mobile-header" style="padding: 15px; background: white; border-bottom: 1px solid #e5e7eb;">
        <h1 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 8px; color: #1a1a1a;">
            {{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}
        </h1>
        <div style="display: flex; align-items: center; gap: 8px; color: #666; font-size: 0.9rem;">
            <i class="fas fa-map-marker-alt" style="color: #127664;"></i>
            <span>{{ $isArabic ? $chalet->city->name_ar : $chalet->city->name_en }} - {{ $isArabic ? $chalet->area->name_ar : $chalet->area->name_en }}</span>
        </div>
        <div style="display: flex; align-items: center; gap: 15px; margin-top: 10px;">
            <div style="display: flex; align-items: center; gap: 5px;">
                <div style="color: #FFA500;">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($averageRating))
                            <i class="fas fa-star"></i>
                        @elseif($i - 0.5 <= $averageRating)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <span style="font-weight: 600;">{{ $averageRating }}</span>
                <span style="color: #999; font-size: 0.85rem;">({{ $totalReviews }})</span>
            </div>
        </div>
    </div>
    
    <!-- Mobile Features -->
    <div style="display: flex; justify-content: space-around; padding: 15px; background: #f8f9fa; border-bottom: 1px solid #e5e7eb;">
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
        @if($chalet->area_size)
        <div style="text-align: center;">
            <i class="fas fa-expand" style="color: #127664; font-size: 1.2rem;"></i>
            <div style="font-size: 0.75rem; color: #666; margin-top: 5px;">{{ $chalet->area_size }} {{ $isArabic ? 'م²' : 'm²' }}</div>
        </div>
        @endif
    </div>
    
    <!-- Mobile Description Section -->
    <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
        <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
            {{ $isArabic ? 'وصف الشاليه' : 'Description' }}
        </h2>
        @if(($isArabic && $chalet->short_description_ar) || (!$isArabic && $chalet->short_description_en))
        <p style="font-size: 0.9rem; line-height: 1.6; color: #444;">
            {{ $isArabic ? $chalet->short_description_ar : $chalet->shor_description_en }}
        </p>
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
            {{ $isArabic ? 'تفاصيل العرض' : 'Booking Details' }}
        </h2>
        <div style="display: grid; gap: 10px;">
            @if($chalet->check_in_time)
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-sign-in-alt" style="color: #127664; width: 20px;"></i>
                <span style="font-size: 0.9rem; color: #444;">{{ $isArabic ? 'وقت تسجيل الدخول:' : 'Check-in:' }} {{ $chalet->check_in_time }}</span>
            </div>
            @endif
            @if($chalet->check_out_time)
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-sign-out-alt" style="color: #127664; width: 20px;"></i>
                <span style="font-size: 0.9rem; color: #444;">{{ $isArabic ? 'وقت تسجيل الخروج:' : 'Check-out:' }} {{ $chalet->check_out_time }}</span>
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
    
   
    
    <!-- Mobile Owner Section -->
    <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
        <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
            {{ $isArabic ? 'المالك' : 'Owner' }}
        </h2>
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 60px; height: 60px; border-radius: 50%; background: #127664; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 600;">
                {{ strtoupper(substr($chalet->owner->name ?? 'O', 0, 1)) }}
            </div>
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
    </div>
    
    <!-- Mobile Guarantee Section -->
    <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
        <div style="background: linear-gradient(135deg, #127664 0%, #0d5a4f 100%); padding: 20px; border-radius: 12px; color: white;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <i class="fas fa-shield-alt" style="font-size: 1.5rem;"></i>
                <div>
                    <h3 style="margin: 0; font-size: 1rem; font-weight: 600;">{{ $isArabic ? 'ضمان شاليك عمان' : 'Shaleek Oman Guarantee' }}</h3>
                    <p style="margin: 0; font-size: 0.75rem; opacity: 0.9;">{{ $isArabic ? 'عرضك محمي بضماناتنا' : 'Your booking is protected by our guarantees' }}</p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-check-circle" style="font-size: 0.9rem;"></i>
                    <span style="font-size: 0.85rem;">{{ $isArabic ? 'دفع آمن 100%' : '100% Secure Payment' }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-check-circle" style="font-size: 0.9rem;"></i>
                    <span style="font-size: 0.85rem;">{{ $isArabic ? 'ضمان استرجاع المبلغ' : 'Money Back Guarantee' }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-check-circle" style="font-size: 0.9rem;"></i>
                    <span style="font-size: 0.85rem;">{{ $isArabic ? 'دعم على مدار الساعة' : '24/7 Support' }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-check-circle" style="font-size: 0.9rem;"></i>
                    <span style="font-size: 0.85rem;">{{ $isArabic ? 'عقارات مفحوصة' : 'Verified Properties' }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Reviews Section -->
    <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
        <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
            {{ $isArabic ? 'التقييمات' : 'Reviews' }} ({{ $totalReviews }})
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
    <div style="padding: 20px 15px; background: white; margin-bottom: 80px;">
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
            @if($chalet->latitude && $chalet->longitude)
                <a href="https://maps.google.com/?q={{ $chalet->latitude }},{{ $chalet->longitude }}" 
                   target="_blank" 
                   style="display: inline-block; background: #127664; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; margin-top: 10px;">
                    <i class="fas fa-directions"></i>
                    {{ $isArabic ? 'عرض على الخريطة' : 'View on Map' }}
                </a>
            @endif
        </div>
    </div>
    
    <!-- Mobile Policies Section -->
    <div style="padding: 20px 15px; background: white; margin-bottom: 8px;">
        <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 12px; color: #1a1a1a;">
            {{ $isArabic ? 'السياسات' : 'Policies' }}
        </h2>
        <div style="display: grid; gap: 12px;">
            <div style="display: flex; align-items: start; gap: 10px;">
                <i class="fas fa-calendar-check" style="color: #127664; margin-top: 2px;"></i>
                <div>
                    <div style="font-weight: 500; color: #1a1a1a; font-size: 0.9rem;">{{ $isArabic ? 'سياسة الإلغاء' : 'Cancellation Policy' }}</div>
                    <p style="font-size: 0.8rem; color: #666; margin: 4px 0 0 0;">{{ $isArabic ? 'إلغاء مجاني حتى 48 ساعة قبل الوصول' : 'Free cancellation up to 48 hours before arrival' }}</p>
                </div>
            </div>
            <div style="display: flex; align-items: start; gap: 10px;">
                <i class="fas fa-credit-card" style="color: #127664; margin-top: 2px;"></i>
                <div>
                    <div style="font-weight: 500; color: #1a1a1a; font-size: 0.9rem;">{{ $isArabic ? 'طرق الدفع' : 'Payment Methods' }}</div>
                    <p style="font-size: 0.8rem; color: #666; margin: 4px 0 0 0;">{{ $isArabic ? 'بطاقات الائتمان، التحويل البنكي، الدفع عند الوصول' : 'Credit cards, Bank transfer, Pay on arrival' }}</p>
                </div>
            </div>
            <div style="display: flex; align-items: start; gap: 10px;">
                <i class="fas fa-shield-alt" style="color: #127664; margin-top: 2px;"></i>
                <div>
                    <div style="font-weight: 500; color: #1a1a1a; font-size: 0.9rem;">{{ $isArabic ? 'التأمين' : 'Security Deposit' }}</div>
                    <p style="font-size: 0.8rem; color: #666; margin: 4px 0 0 0;">{{ $isArabic ? 'تأمين قابل للاسترداد 50 ر.ع' : 'Refundable deposit 50 OMR' }}</p>
                </div>
            </div>
        </div>
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
    <div style="padding: 20px 15px; background: white; margin-bottom: 80px;">
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
    @if($chalet->owner && $chalet->owner->phone)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $chalet->owner->phone) }}?text={{ urlencode($isArabic ? 'مرحباً، أريد الاستفسار عن ' . $chalet->chalet_name_ar : 'Hello, I want to inquire about ' . $chalet->chalet_name_en) }}" 
       target="_blank"
       style="position: fixed; bottom: 80px; right: 20px; width: 56px; height: 56px; background: #25D366; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 999; text-decoration: none;">
        <i class="fab fa-whatsapp" style="color: white; font-size: 28px;"></i>
    </a>
    @endif
    
    <!-- Mobile Booking Bar (Fixed Bottom) -->
    <div class="mobile-booking-bar" style="position: fixed; bottom: 0; left: 0; right: 0; background: white; padding: 12px 15px; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); z-index: 1000; display: flex; justify-content: space-between; align-items: center;">
        <div class="mobile-price" style="display: flex; flex-direction: column;">
            <span class="mobile-price-amount" style="font-size: 1.3rem; font-weight: 700; color: #127664;">
                @if($chalet->default_day_price)
                    {{ number_format($chalet->default_day_price, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}
                @else
                    {{ $isArabic ? 'السعر غير محدد' : 'Price not set' }}
                @endif
            </span>
            <span class="mobile-price-period" style="font-size: 0.75rem; color: #666;">{{ $isArabic ? 'لليلة الواحدة' : 'per night' }}</span>
        </div>
        <button type="button" onclick="window.showMobileBookingModal()" style="background: #127664; color: white; padding: 10px 24px; border-radius: 8px; font-weight: 600; border: none; font-size: 0.95rem; cursor: pointer;">
            {{ $isArabic ? 'اعرض الآن' : 'Book Now' }}
        </button>
    </div>
</div>

<!-- Booking Card Section (Hidden on Mobile) -->
<div class="booking-card-section d-none d-lg-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 mb-4">
                
                <!-- Guarantee Card -->
                <div class="guarantee-card">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="guarantee-header">
                            <div class="guarantee-icon">
                                <img src="{{ asset('frontend/images/guarantee-logo.png') }}" alt="guarantee_logo">
                            </div>
                            <div class="guarantee-title mt-2">
                                <h3>{{ $isArabic ? 'ضمان شاليك عمان' : 'Shaleek Oman Guarantee' }}</h3>
                                <p>{{ $isArabic ? 'نضمن لك صحة المعلومات ونظافة المكان' : 'We guarantee accurate information and clean place' }}</p>
                            </div>
                        </div>
                        <div>
                            <span>
                                <svg width="10" height="20" viewBox="0 0 10 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.0975 18.2236L1.5775 11.1341C0.8075 10.2968 0.8075 8.92675 1.5775 8.0895L8.0975 1" stroke="#464B52" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="guarantee-content">
                        <p>{{ $isArabic ? 'نضمـن لك صحة المعلومات في هذه الصفحة ونضمن لك نظافة المكان و في حال لم تطابق المعلومـات 80% أو وجـدت المكان غـير نظيف نوفر لك أحد الخيارات' : 'We guarantee the accuracy of information on this page and cleanliness of the place. If the information does not match 80% or the place is not clean, we provide you with one of the options' }}</p>
                        <ul class="guarantee-list">
                            <li>{{ $isArabic ? 'عرض بديل بنفس المواصفات أو أفضل' : 'Alternative booking with same or better specifications' }}</li>
                            <li>{{ $isArabic ? 'إلغاء العرض و نسترجع المبلغ بغض النظر عن سياسة الإرفاع و الاسترجاع' : 'Cancel booking and refund regardless of cancellation policy' }}</li>
                        </ul>
                    </div>
                </div>

                <div class="description-card" style="background: #fff; padding: 30px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #e5e7eb;">
                    <h3 class="section-title" style="color: #127664; font-size: 22px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #e5e7eb;">{{ $isArabic ? 'الوصف' : 'Description' }}</h3>
                    <div class="description-content" style="line-height: 1.8; color: #333; font-size: 16px;">
                        <p>{{ $isArabic ? $chalet->long_description_ar : $chalet->long_description_en }}</p>
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
                                        <img height="50px" src="{{ asset('frontend/images/green-profile-image.png') }}" alt="profile_image">
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
                    
                        <!-- Insurance Deposit -->
                        <div class="spec-item insurance-item">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.0802 8.58003V15.42C21.0802 16.54 20.4802 17.58 19.5102 18.15L13.5702 21.58C12.6002 22.14 11.4002 22.14 10.4202 21.58L4.48016 18.15C3.51016 17.59 2.91016 16.55 2.91016 15.42V8.58003C2.91016 7.46003 3.51016 6.41999 4.48016 5.84999L10.4202 2.42C11.3902 1.86 12.5902 1.86 13.5702 2.42L19.5102 5.84999C20.4802 6.41999 21.0802 7.45003 21.0802 8.58003Z" stroke="#848484" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.9999 11.0001C13.2867 11.0001 14.3299 9.95687 14.3299 8.67004C14.3299 7.38322 13.2867 6.34009 11.9999 6.34009C10.7131 6.34009 9.66992 7.38322 9.66992 8.67004C9.66992 9.95687 10.7131 11.0001 11.9999 11.0001Z" stroke="#848484" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16 16.6601C16 14.8601 14.21 13.4001 12 13.4001C9.79 13.4001 8 14.8601 8 16.6601" stroke="#848484" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span class="spec-text">{{ $isArabic ? 'يوجد مبلغ تأمين 300 ريال يدفع عند الوصول (قابل للاسترداد)' : 'Security deposit 300 SAR paid upon arrival (refundable)' }}</span>
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
                            
                            @php
                                $nearbyPlaces = $chalet->nearby_places;
                                // معالجة البيانات بشكل آمن
                                if (is_string($nearbyPlaces)) {
                                    $nearbyPlaces = json_decode($nearbyPlaces, true);
                                }
                                if (!is_array($nearbyPlaces)) {
                                    $nearbyPlaces = [];
                                }
                            @endphp
                            @if(!empty($nearbyPlaces))
                                <div class="nearby-section mb-4">
                                    <h4 class="mb-3">
                                        <i class="fas fa-location-arrow text-primary me-2"></i>
                                        {{ $isArabic ? 'الأماكن القريبة' : 'Nearby Places' }}
                                    </h4>
                                    <div class="nearby-places-grid">
                                        @foreach($nearbyPlaces as $place)
                                            <div class="nearby-place-item">
                                                <div class="place-icon">
                                                    <i class="fas fa-map-pin"></i>
                                                </div>
                                                <div class="place-info">
                                                    @if(is_array($place))
                                                        <div class="place-name">{{ $isArabic ? ($place['name_ar'] ?? '') : ($place['name_en'] ?? '') }}</div>
                                                        <div class="place-distance">{{ $place['distance'] ?? '' }}</div>
                                                    @else
                                                        <div class="place-name">{{ $place }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
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
                                        {!! $chalet->map_link !!}
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
                            
                            @if($chalet->rules_ar || $chalet->rules_en)
                                <h4 class="mt-4 mb-3">{{ $isArabic ? 'القواعد والشروط:' : 'Rules and Conditions:' }}</h4>
                                <div class="rules-content">
                                    {!! nl2br(e($isArabic ? $chalet->rules_ar : $chalet->rules_en)) !!}
                                </div>
                            @endif
                            
                            @if($chalet->whatsapp_number)
                                <div class="mt-4">
                                    <p><strong>{{ $isArabic ? 'للتواصل المباشر:' : 'For direct contact:' }}</strong></p>
                                <a href="{{ $chalet->whatsapp_link }}" class="btn btn-success" target="_blank">
                                        <i class="fab fa-whatsapp"></i> {{ $chalet->whatsapp_number }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="booking-card sticky-card">
                    <form action="{{ route('chalet.book', $chalet->id) }}" method="POST" id="booking-form">
                        @csrf
                        <!-- Price Section -->
                        <div class="price-section">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="price-main">
                                    <span class="price-amount" data-price="{{ $chalet->default_day_price }}">{{ number_format($chalet->default_day_price, 0) }}</span>
                                    <span class="price-currency">{{ $isArabic ? 'ريال/ليلة' : 'SAR/night' }}</span>
                                </div>
                                <!-- WhatsApp Contact Button -->
                                <a href="{{ $chalet->whatsapp_link }}?text={{ urlencode($isArabic ? 'مرحباً، أرغب في الاستفسار عن الشالية: ' . $chalet->chalet_name_ar : 'Hello, I would like to inquire about the chalet: ' . $chalet->chalet_name_en) }}" 
                                   class="whatsapp-contact-btn" target="_blank" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink: 0;">
                                        <path d="M17.472 2.39999C15.538 0.465988 12.921 -0.534012 10.172 -0.534012C4.64203 -0.534012 0.144031 3.96399 0.144031 9.49399C0.144031 11.157 0.594031 12.771 1.44803 14.181L0.0660313 19.466L5.46003 18.105C6.81003 18.885 8.34303 19.29 9.90603 19.29H9.91103C15.438 19.29 19.935 14.793 19.935 9.26299C19.935 6.51399 18.936 3.89999 17.004 1.96799L17.472 2.39999ZM10.172 17.613C8.52603 17.613 6.91203 17.208 5.48103 16.437L5.16603 16.251L2.23203 17.019L3.01203 14.139L2.80803 13.809C1.96403 12.327 1.52103 10.647 1.52103 8.91899C1.52103 4.60799 5.28603 1.08899 10.177 1.08899C12.552 1.08899 14.814 2.00999 16.509 3.70499C18.204 5.39999 19.125 7.66199 19.125 10.038C19.125 14.349 15.483 17.745 10.592 17.745L10.172 17.613ZM15.063 11.52C14.808 11.394 13.554 10.773 13.317 10.683C13.08 10.593 12.906 10.548 12.732 10.803C12.558 11.058 12.063 11.646 11.907 11.82C11.751 11.994 11.595 12.012 11.34 11.886C11.085 11.76 10.251 11.487 9.26103 10.602C8.49003 9.91199 7.97103 9.06299 7.81503 8.80799C7.65903 8.55299 7.79403 8.41799 7.92203 8.29199C8.03703 8.17899 8.17703 7.99599 8.30403 7.83999C8.43103 7.68399 8.47603 7.57299 8.56603 7.39899C8.65603 7.22499 8.61103 7.06899 8.54803 6.94299C8.48503 6.81699 7.97703 5.56299 7.76103 5.04299C7.55103 4.53599 7.33803 4.60499 7.17903 4.59699C7.02303 4.58899 6.84903 4.58899 6.67503 4.58899C6.50103 4.58899 6.21903 4.65199 5.98203 4.90699C5.74503 5.16199 5.08803 5.78299 5.08803 7.03699C5.08803 8.29099 6.00003 9.49899 6.12703 9.67299C6.25403 9.84699 7.96903 12.471 10.389 13.596C10.005 13.425 11.619 14.133 12.309 14.259C12.999 14.385 14.253 13.614 14.469 12.843C14.685 12.072 14.685 11.427 14.622 11.319C14.559 11.211 14.385 11.148 14.13 11.022L15.063 11.52Z" fill="white"/>
                                    </svg>
                                    <span style="overflow: hidden; text-overflow: ellipsis;">{{ $isArabic ? 'واتساب' : 'WhatsApp' }}</span>
                                </a>
                            </div>
                            <div class="price-total">
                                <span>{{ $isArabic ? 'إجمالي ليلة واحدة' : 'Total for one night' }} <span class="text-dark fw-bold" id="price-per-night">{{ number_format($chalet->default_day_price * 1.04, 0) }}</span> {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
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


                        <!-- Time Selection -->
                        <div class="time-selection-section">
                            <div class="time-item">
                                <span class="time-label">{{ $isArabic ? 'وقت الوصول' : 'Check-in Time' }}</span>
                                <select name="checkin_time" class="form-select" style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 8px; font-size: 14px; width: 100%;">
                                    <option value="06:00">06:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="07:00">07:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="08:00">08:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="09:00">09:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="10:00">10:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="11:00">11:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="12:00">12:00 {{ $isArabic ? 'ظهراً' : 'PM' }}</option>
                                    <option value="13:00">01:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="14:00">02:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="15:00" selected>03:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="16:00">04:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="17:00">05:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="18:00">06:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="19:00">07:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="20:00">08:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="21:00">09:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="22:00">10:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="23:00">11:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="00:00">12:00 {{ $isArabic ? 'منتصف الليل' : 'AM (Midnight)' }}</option>
                                </select>
                            </div>
                            <div class="time-item">
                                <span class="time-label">{{ $isArabic ? 'وقت المغادرة' : 'Check-out Time' }}</span>
                                <select name="checkout_time" class="form-select" style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 8px; font-size: 14px; width: 100%;">
                                    <option value="06:00">06:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="07:00">07:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="08:00">08:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="09:00">09:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="10:00">10:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="11:00">11:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                                    <option value="12:00" selected>12:00 {{ $isArabic ? 'ظهراً' : 'PM' }}</option>
                                    <option value="13:00">01:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="14:00">02:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="15:00">03:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="16:00">04:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="17:00">05:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                    <option value="18:00">06:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Hidden inputs for guest number and special requests -->
                        <input type="hidden" name="number_of_guests" value="2">
                        <input type="hidden" name="special_requests" value="">

                        <!-- Confirm Button -->
                        <button type="submit" class="btn-confirm">{{ $isArabic ? 'تأكيد' : 'Confirm' }}</button>

                        <!-- Price Breakdown -->
                        <div class="price-breakdown" id="price-breakdown">
                            <div class="breakdown-item">
                                <span><span id="nights-count">1</span> {{ $isArabic ? 'ليلة' : 'night(s)' }} × {{ number_format($chalet->default_day_price, 0) }} {{ $isArabic ? 'ريال' : 'SAR' }}</span>
                                <span class="breakdown-value" id="subtotal">{{ number_format($chalet->default_day_price, 0) }} {{ $isArabic ? 'ريال' : 'SAR' }}</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="text-secondary">{{ $isArabic ? 'رسوم الخدمات' : 'Service Fees' }}</span>
                                <span class="breakdown-value text-secondary" id="service-fee">+{{ number_format($chalet->default_day_price * 0.04, 0) }} {{ $isArabic ? 'ريال' : 'SAR' }}</span>
                            </div>
                        </div>

                        <!-- Total Section -->
                        <div class="total-section">
                            <span class="total-label">{{ $isArabic ? 'الإجمالي' : 'Total' }}</span>
                            <span class="total-value" id="total-price">{{ number_format($chalet->default_day_price * 1.04, 0) }} {{ $isArabic ? 'ريال' : 'SAR' }}</span>
                        </div>

                        <!-- Insurance Note -->
                        <p class="insurance-note">* &nbsp; &nbsp; {{ $isArabic ? 'يوجد مبلغ تأمين بقيمة 300 ر.ع يدفع عند المكان' : 'Security deposit of 300 OMR paid at the location' }}</p>

     <!-- Payment Options - Static -->
<div class="payment-options">

    <!-- Thawani Pay -->
    <div class="payment-option">
        <div class="payment-logo" style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('frontend/assets/images/thawani_logo-green.png') }}" alt="Tabby" style="height: 34px;">
            <div>
                <h5 style="margin:0;">Thawani Pay</h5>
                <span class="badge bg-warning text-dark">الأفضل في عُمان</span>
            </div>
        </div>
        </div>

    <!-- Tabby -->
    <div class="payment-option">
        <img src="{{ asset('frontend/assets/images/visa.png') }}" alt="VISA" style="height: 34px;">
        <span>أدفع بالفيزا</span>
    </div>

   

    

                        </div>
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
            <h3 style="margin: 0; font-size: 1.3rem; color: #1a1a1a; font-weight: 600;">{{ $isArabic ? "تفاصيل العرض" : "Booking Details" }}</h3>
            <button class="close-modal-btn" style="background: none; border: none; font-size: 28px; color: #666; cursor: pointer; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <form action="{{ route('chalet.book', $chalet->id) }}" method="POST" id="mobile-booking-form">
            @csrf
            
            <!-- Price Section -->
            <div style="background: #f8f9fa; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <div>
                        <span style="font-size: 1.8rem; font-weight: bold; color: #127664;">{{ number_format($chalet->default_day_price, 0) }}</span>
                        <span style="color: #666; font-size: 0.9rem;">{{ $isArabic ? 'ر.ع/ليلة' : 'OMR/night' }}</span>
                    </div>
                    <!-- WhatsApp Button -->
                    <a href="{{ $chalet->whatsapp_link }}?text={{ urlencode($isArabic ? 'مرحباً، أرغب في الاستفسار عن الشالية: ' . $chalet->chalet_name_ar : 'Hello, I would like to inquire about the chalet: ' . $chalet->chalet_name_en) }}" 
                       target="_blank" 
                       style="background: #25D366; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; gap: 8px; font-size: 0.9rem;">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.472 2.39999C15.538 0.465988 12.921 -0.534012 10.172 -0.534012C4.64203 -0.534012 0.144031 3.96399 0.144031 9.49399C0.144031 11.157 0.594031 12.771 1.44803 14.181L0.0660313 19.466L5.46003 18.105C6.81003 18.885 8.34303 19.29 9.90603 19.29H9.91103C15.438 19.29 19.935 14.793 19.935 9.26299C19.935 6.51399 18.936 3.89999 17.004 1.96799L17.472 2.39999ZM10.172 17.613C8.52603 17.613 6.91203 17.208 5.48103 16.437L5.16603 16.251L2.23203 17.019L3.01203 14.139L2.80803 13.809C1.96403 12.327 1.52103 10.647 1.52103 8.91899C1.52103 4.60799 5.28603 1.08899 10.177 1.08899C12.552 1.08899 14.814 2.00999 16.509 3.70499C18.204 5.39999 19.125 7.66199 19.125 10.038C19.125 14.349 15.483 17.745 10.592 17.745L10.172 17.613ZM15.063 11.52C14.808 11.394 13.554 10.773 13.317 10.683C13.08 10.593 12.906 10.548 12.732 10.803C12.558 11.058 12.063 11.646 11.907 11.82C11.751 11.994 11.595 12.012 11.34 11.886C11.085 11.76 10.251 11.487 9.26103 10.602C8.49003 9.91199 7.97103 9.06299 7.81503 8.80799C7.65903 8.55299 7.79403 8.41799 7.92203 8.29199C8.03703 8.17899 8.17703 7.99599 8.30403 7.83999C8.43103 7.68399 8.47603 7.57299 8.56603 7.39899C8.65603 7.22499 8.61103 7.06899 8.54803 6.94299C8.48503 6.81699 7.97703 5.56299 7.76103 5.04299C7.55103 4.53599 7.33803 4.60499 7.17903 4.59699C7.02303 4.58899 6.84903 4.58899 6.67503 4.58899C6.50103 4.58899 6.21903 4.65199 5.98203 4.90699C5.74503 5.16199 5.08803 5.78299 5.08803 7.03699C5.08803 8.29099 6.00003 9.49899 6.12703 9.67299C6.25403 9.84699 7.96903 12.471 10.389 13.596C10.005 13.425 11.619 14.133 12.309 14.259C12.999 14.385 14.253 13.614 14.469 12.843C14.685 12.072 14.685 11.427 14.622 11.319C14.559 11.211 14.385 11.148 14.13 11.022L15.063 11.52Z" fill="white"/>
                        </svg>
                        {{ $isArabic ? 'واتساب' : 'WhatsApp' }}
                    </a>
                </div>
                <div style="color: #666; font-size: 0.85rem;">
                    {{ $isArabic ? 'إجمالي ليلة واحدة' : 'Total for one night' }}: 
                    <span style="font-weight: 600; color: #333;" id="mobile-price-per-night">{{ number_format($chalet->default_day_price * 1.04, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}</span>
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
            
            <!-- Time Selection -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                <div style="background: #f8f9fa; border-radius: 10px; padding: 12px;">
                    <label style="display: block; color: #666; font-size: 0.75rem; margin-bottom: 8px;">{{ $isArabic ? 'وقت الوصول' : 'Check-in Time' }}</label>
                    <select name="checkin_time" style="width: 100%; border: 1px solid #e5e7eb; border-radius: 6px; padding: 6px; font-size: 0.9rem; background: white;">
                        <option value="06:00">06:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="07:00">07:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="08:00">08:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="09:00">09:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="10:00">10:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="11:00">11:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="12:00">12:00 {{ $isArabic ? 'ظهراً' : 'PM' }}</option>
                        <option value="13:00">01:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="14:00">02:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="15:00" selected>03:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="16:00">04:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="17:00">05:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="18:00">06:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="19:00">07:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="20:00">08:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="21:00">09:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="22:00">10:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="23:00">11:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="00:00">12:00 {{ $isArabic ? 'منتصف الليل' : 'AM (Midnight)' }}</option>
                    </select>
                </div>
                
                <div style="background: #f8f9fa; border-radius: 10px; padding: 12px;">
                    <label style="display: block; color: #666; font-size: 0.75rem; margin-bottom: 8px;">{{ $isArabic ? 'وقت المغادرة' : 'Check-out Time' }}</label>
                    <select name="checkout_time" style="width: 100%; border: 1px solid #e5e7eb; border-radius: 6px; padding: 6px; font-size: 0.9rem; background: white;">
                        <option value="06:00">06:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="07:00">07:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="08:00">08:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="09:00">09:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="10:00">10:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="11:00">11:00 {{ $isArabic ? 'صباحاً' : 'AM' }}</option>
                        <option value="12:00" selected>12:00 {{ $isArabic ? 'ظهراً' : 'PM' }}</option>
                        <option value="13:00">01:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="14:00">02:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="15:00">03:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="16:00">04:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="17:00">05:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                        <option value="18:00">06:00 {{ $isArabic ? 'مساءً' : 'PM' }}</option>
                    </select>
                </div>
            </div>
            
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
            <p style="color: #dc3545; font-size: 0.85rem; margin-bottom: 20px; padding: 10px; background: #fff5f5; border-radius: 8px;">
                * {{ $isArabic ? 'يوجد مبلغ تأمين بقيمة 300 ر.ع يدفع عند المكان' : 'Security deposit of 300 OMR paid at the location' }}
            </p>
            
            <!-- Payment Options -->
            <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                    <img src="{{ asset('frontend/images/tabby.png') }}" alt="Tabby" style="height: 20px;">
                    <span style="font-size: 0.85rem; color: #666;">{{ $isArabic ? 'قسمها على 4. بدون فوائد أو رسوم' : 'Split into 4. No interest or fees' }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                    <img src="{{ asset('frontend/images/tamara.png') }}" alt="Tamara" style="height: 20px;">
                    <span style="font-size: 0.85rem; color: #666;">{{ $isArabic ? 'قسمها على 4. بدون فوائد أو رسوم' : 'Split into 4. No interest or fees' }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ asset('frontend/images/qitaf.png') }}" alt="STC" style="height: 20px;">
                    <span style="font-size: 0.85rem; color: #666;">{{ $isArabic ? 'اكسب' : 'Earn' }} <span style="font-weight: bold;">{{ number_format($chalet->default_day_price * 0.1, 0) }} {{ $isArabic ? 'نقطة' : 'points' }}</span> {{ $isArabic ? 'مع stc قطاف' : 'with STC Qitaf' }}</span>
                </div>
            </div>
            
            <!-- Confirm Button -->
            <button type="submit" style="width: 100%; background: #127664; color: white; padding: 16px; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer;">
                {{ $isArabic ? 'تأكيد العرض' : 'Confirm Booking' }}
            </button>
        </form>
    `;
    
    document.body.appendChild(modal);
    
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
    const pricePerNight = {{ $chalet->default_day_price }};
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
        const subtotal = nights * pricePerNight;
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
    const pricePerNight = priceAmountElement ? parseFloat(priceAmountElement.dataset.price || 0) : 0;
    const checkinInput = document.getElementById('checkin-date');
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
                    localStorage.setItem('pendingBooking', JSON.stringify({
                        chalet_id: {{ $chalet->id }},
                        checkin_date: checkinInput.value,
                        checkout_date: checkoutInput.value,
                        checkin_time: document.querySelector('[name="checkin_time"]').value,
                        checkout_time: document.querySelector('[name="checkout_time"]').value,
                        number_of_guests: document.querySelector('[name="number_of_guests"]').value,
                        special_requests: document.querySelector('[name="special_requests"]').value,
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
        if (pendingBooking) {
            const data = JSON.parse(pendingBooking);
            if (data.chalet_id == {{ $chalet->id }}) {
                // Restore all form values
                checkinInput.value = data.checkin_date;
                checkoutInput.value = data.checkout_date;
                document.querySelector('[name="checkin_time"]').value = data.checkin_time || '15:00';
                document.querySelector('[name="checkout_time"]').value = data.checkout_time || '08:00';
                document.querySelector('[name="number_of_guests"]').value = data.number_of_guests || 2;
                document.querySelector('[name="special_requests"]').value = data.special_requests || '';
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
                        document.getElementById('booking-form').submit();
                    }, 1500);
                }, 500);
                
                localStorage.removeItem('pendingBooking');
            }
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
    @auth('customer')
    const wishlistBtn = document.getElementById('wishlistBtn');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            const btn = this;
            const chaletId = btn.dataset.chaletId;
            const svgPath = btn.querySelector('svg path');
            const span = btn.querySelector('span');
            
            btn.disabled = true;
            
            fetch(`{{ url('/wishlist/toggle') }}/${chaletId}`, {
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
    @endauth
    
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

{{-- Load Google Maps API with async loading --}}
@if($chalet->latitude && $chalet->longitude)
<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&callback=initMap&language={{ $isArabic ? 'ar' : 'en' }}&loading=async">
</script>
@endif

@endsection
