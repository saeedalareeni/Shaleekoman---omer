@extends('frontend.layouts.weekend_master')

@php
    $isArabic = app()->getLocale() == 'ar';
@endphp

@section('page_title')
    {{ $isArabic ? 'حجوزاتي' : 'My Bookings' }}
@endsection

@section('css')
<style>
    /* RTL Support */
    [dir="rtl"] .profile-sidebar {
        border-left: none;
        border-right: 1px solid #e0e0e0;
    }
    
    [dir="rtl"] .nav-item svg {
        margin-left: 10px;
        margin-right: 0;
    }
    
    [dir="rtl"] .text-end {
        text-align: left !important;
    }
    
    [dir="rtl"] .text-start {
        text-align: right !important;
    }
    
    .profile-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding-top: 20px;
    }
    .profile-page .container-fluid {
        margin: 0 auto;
        padding: 0 20px;
    }
    .profile-page .profile-layout {
        display: flex;
        gap: 30px;
        border-radius: 20px;
        overflow: hidden;
    }
    
    /* Sidebar Styles */
    .profile-page .profile-sidebar {
        flex: 0 0 270px;
        color: white;
        padding: 40px 0;
    }
    .profile-page .profile-sidebar .user-info {
        text-align: center;
        margin-bottom: 20px;
        padding: 0 25px 30px;
        border-bottom: 1px solid #e0e0e0;
    }
    .profile-page .profile-sidebar .user-info .user-name {
        font-size: 28px;
        font-weight: 600;
        margin: 0 0 8px 0;
        color: #127664;
    }
    .profile-page .profile-sidebar .user-info .user-email {
        font-size: 14px;
        color: #777777;
        margin: 0;
        font-weight: 400;
    }
    
    /* Navigation Menu */
    .profile-page .profile-sidebar .sidebar-nav .nav-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .profile-page .profile-sidebar .sidebar-nav .nav-menu .nav-item {
        margin-bottom: 7px;
        position: relative;
        width: 175px;
        text-align: center;
        margin: 0 auto 10px;
    }
    .active-side-link {
        background: #DF4D2D !important;
        color: white !important;
        border: none !important;
    }
    .active-side-link svg path {
        stroke: white !important;
    }
    .side-btn-padding {
        padding: 10px 20px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .side-link-span {
        font-weight: 500;
    }
    
    /* Sidebar button hover effect */
    .sidebar-nav button:not(.active-side-link):hover {
        background: #f0f0f0 !important;
        transform: translateX(-5px);
    }
    
    [dir="rtl"] .sidebar-nav button:not(.active-side-link):hover {
        transform: translateX(5px);
    }
    
    /* Tab pane animation */
    .tab-pane {
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
    .border-radius-20 {
        border-radius: 20px !important;
    }
    .border-radius-25 {
        border-radius: 25px !important;
    }
    .border-width-2 {
        border-width: 2px !important;
    }
    .secondary-green-color {
        color: #127664;
    }
    
    /* Main Content */
    .profile-page .profile-content {
        flex: 1;
        padding: 40px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 20px;
        min-height: 600px;
    }
    
    /* Statistics Cards */
    .statistics-cards {
        margin-bottom: 40px;
    }
    .statistic-card {
        background: white !important;
        border-radius: 20px !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important;
        transition: all 0.3s ease;
        height: 100%;
        min-height: 120px;
    }
    .statistic-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .primary-green-color {
        color: #127664;
    }
    
    /* Tabs Styles */
    .booking-tabs {
        margin-bottom: 30px;
    }
    
    .booking-tabs .nav-tabs {
        border: none;
        background: white;
        border-radius: 15px;
        padding: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        gap: 10px;
    }
    
    .booking-tabs .nav-link {
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        color: #666;
        font-weight: 500;
        transition: all 0.3s;
        background: transparent;
        position: relative;
    }
    
    .booking-tabs .nav-link:hover {
        background: #f0f0f0;
        color: #127664;
    }
    
    .booking-tabs .nav-link.active {
        background: #127664;
        color: white;
    }
    
    .booking-tabs .nav-link .badge {
        margin-left: 8px;
        background: rgba(255, 255, 255, 0.2);
        color: inherit;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
    }
    
    .booking-tabs .nav-link.active .badge {
        background: rgba(255, 255, 255, 0.3);
    }
    
    [dir="rtl"] .booking-tabs .nav-link .badge {
        margin-left: 0;
        margin-right: 8px;
    }
    
    /* Bookings Table */
    .bookings-table {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    .bookings-table h4 {
        color: #127664;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .bookings-table .table {
        font-size: 14px;
    }
    .bookings-table .table thead {
        background: #f8f9fa;
        border-radius: 10px;
    }
    .bookings-table .table thead th {
        border: none;
        padding: 15px 10px;
        color: #127664;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
    }
    .bookings-table .table tbody td {
        padding: 15px 10px;
        vertical-align: middle;
        border-color: #f0f0f0;
    }
    .badge {
        padding: 6px 12px;
        font-weight: 500;
        font-size: 11px;
    }
    .btn-print {
        background: #127664;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .btn-print:hover {
        background: #0f5c4d;
        transform: translateY(-2px);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state i {
        color: #e0e0e0;
        margin-bottom: 20px;
    }
    .empty-state p {
        color: #666;
        font-size: 18px;
        margin-bottom: 20px;
    }
    
    /* Wishlist Card Hover Effects */
    .chalet-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12) !important;
    }
    
    .chalet-card:hover .chalet-card-image img {
        transform: scale(1.1);
    }
    
    .chalet-card:hover .image-overlay {
        opacity: 1 !important;
    }
    
    .chalet-title a:hover {
        color: #127664 !important;
    }
    
    .btn-view-details:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(18, 118, 100, 0.4);
    }
    
    .wishlist-btn:hover {
        transform: scale(1.1);
    }
    
    /* RTL Support for Wishlist Cards */
    [dir="rtl"] .chalet-location i {
        margin-right: 0;
        margin-left: 5px;
    }
    
    [dir="rtl"] .price-badge {
        left: auto;
        right: 15px;
    }
    
    [dir="rtl"] .wishlist-btn {
        right: auto;
        left: 15px;
    }
    
    /* Profile Form Styles */
    .profile-form {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 20px;
        padding: 50px;
        margin-top: 30px;
    }
    
    .profile-form .form-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 60px;
        margin-bottom: 40px;
    }
    
    [dir="rtl"] .profile-form .form-container {
        grid-template-columns: 380px 1fr;
    }
    
    .profile-form .form-left {
        border-left: 1px solid #E5E5E5;
        padding-left: 50px;
    }
    
    [dir="rtl"] .profile-form .form-left {
        border-left: none;
        border-right: 1px solid #E5E5E5;
        padding-left: 0;
        padding-right: 50px;
    }
    
    .profile-form .form-left .form-title {
        font-size: 20px;
        font-weight: 700;
        color: #1F1F1F;
        margin: 0 0 35px 0;
    }
    
    .profile-form .form-right {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }
    
    .profile-form .form-group {
        display: flex;
        flex-direction: column;
    }
    
    .profile-form .form-group .form-label {
        font-size: 16px;
        font-weight: 600;
        color: #127664;
        margin-bottom: 10px;
    }
    
    .profile-form .form-group .form-input {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid #D4D4D4;
        border-radius: 15px;
        font-size: 14px;
        background: white;
        transition: all 0.3s ease;
    }
    
    .profile-form .form-group .form-input::placeholder {
        color: #BEBEBE;
    }
    
    .profile-form .form-group .form-input:focus {
        outline: none;
        border-color: #127664;
        box-shadow: 0 0 0 3px rgba(18, 118, 100, 0.08);
    }
    
    .profile-form .btn-confirm {
        background: #127664;
        color: white;
        border: none;
        padding: 14px 40px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 18px;
        transition: all 0.3s ease;
    }
    
    .profile-form .btn-confirm:hover {
        background: #0F5D4F;
        transform: translateY(-1px);
    }
    
    .profile-form .form-footer {
        display: flex;
        justify-content: center;
    }
    
    .profile-form .form-footer .btn-save {
        background: #127664;
        color: white;
        border: none;
        padding: 16px 60px;
        border-radius: 50px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(18, 118, 100, 0.15);
    }
    
    .profile-form .form-footer .btn-save:hover {
        background: #0F5D4F;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(18, 118, 100, 0.25);
    }
    
    .primary-bg-green {
        background: #127664 !important;
        color: white !important;
    }
    
    @media (max-width: 1024px) {
        .profile-form {
            padding: 40px;
        }
        .profile-form .form-container {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        .profile-form .form-left {
            border-left: none;
            border-top: 1px solid #E5E5E5;
            padding-left: 0;
            padding-top: 40px;
        }
    }
    
    @media (max-width: 768px) {
        .profile-form {
            padding: 30px 25px;
        }
        .profile-form .form-container {
            gap: 30px;
        }
        .profile-form .form-left .form-title {
            font-size: 18px;
            margin-bottom: 25px;
        }
    }
    
    /* Success Message Styles */
    .booking-success-message {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
        animation: slideDown 0.6s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
    
    .success-icon-wrapper {
        display: inline-block;
        margin-bottom: 20px;
    }
    
    .success-checkmark {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #fff;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #fff;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        position: relative;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.1);
    }
    
    .check-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
    }
    
    .icon-line {
        height: 4px;
        background-color: white;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }
    
    .icon-line.line-tip {
        top: 23px;
        left: 8px;
        width: 12px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }
    
    .icon-line.line-long {
        top: 19px;
        left: 15px;
        width: 25px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }
    
    @keyframes icon-line-tip {
        0% {
            width: 0;
            left: 1px;
            top: 19px;
        }
        54% {
            width: 0;
            left: 1px;
            top: 19px;
        }
        70% {
            width: 18px;
            left: 5px;
            top: 23px;
        }
        84% {
            width: 10px;
            left: 9px;
            top: 25px;
        }
        100% {
            width: 12px;
            left: 8px;
            top: 23px;
        }
    }
    
    @keyframes icon-line-long {
        0% {
            width: 0;
            right: 22px;
            top: 25px;
        }
        65% {
            width: 0;
            right: 22px;
            top: 25px;
        }
        84% {
            width: 30px;
            right: 0;
            top: 20px;
        }
        100% {
            width: 25px;
            right: 3px;
            top: 19px;
        }
    }
    
    .success-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: white;
    }
    
    .success-message {
        font-size: 1.1rem;
        margin-bottom: 25px;
        opacity: 0.95;
        color: white;
    }
    
    .success-actions .btn {
        background: white;
        color: #667eea;
        border: none;
        padding: 12px 30px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .success-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .profile-page .profile-layout {
            gap: 20px;
        }
        .profile-page .profile-sidebar {
            flex: 0 0 240px;
        }
    }
    @media (max-width: 768px) {
        .profile-page .profile-layout {
            flex-direction: column;
        }
        .profile-page .profile-sidebar {
            flex: none;
            padding: 20px 0;
        }
        .profile-page .profile-content {
            padding: 20px;
        }
        .statistics-cards .col-md-3 {
            margin-bottom: 15px;
        }
    }
</style>
@endsection

@section('content')

<!-- Profile Page Section -->
<section class="profile-page">
    <div class="container-fluid px-5">
        <!-- Success Message -->
        @if(session('success'))
            <div class="booking-success-message">
                <div class="success-icon-wrapper">
                    <div class="success-checkmark">
                        <div class="check-icon">
                            <span class="icon-line line-tip"></span>
                            <span class="icon-line line-long"></span>
                        </div>
                    </div>
                </div>
                <h3 class="success-title">{{ $isArabic ? 'تم العرض بنجاح!' : 'Booking Successful!' }}</h3>
                <p class="success-message">{{ session('success') }}</p>
                <div class="success-actions">
                    <button type="button" class="btn btn-success" data-bs-dismiss="alert">
                        {{ $isArabic ? 'عرض تفاصيل العرض' : 'View Booking Details' }}
                    </button>
                </div>
            </div>
        @endif
        
        <!-- Error Message -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="border-radius: 15px; padding: 20px;">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-exclamation-circle" style="font-size: 2rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <strong>{{ $isArabic ? 'حدث خطأ!' : 'Error!' }}</strong><br>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        <div class="profile-layout">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="user-info">
                    <h3 class="user-name secondary-green-color">{{ auth('customer')->user()->name }}</h3>
                    <p class="user-email">{{ auth('customer')->user()->email }}</p>
                </div>

                <nav class="sidebar-nav">
                    <ul class="nav-menu d-flex flex-column align-items-center" role="tablist">
                        <li class="nav-item text-center">
                            <button class="nav-item btn btn-dark d-flex gap-2 bg-transparent rounded-pill side-btn-padding border-width-2 border-radius-20 fw-medium" 
                                    data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab">
                                <svg width="21" height="23" viewBox="0 0 21 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 11.5C12.7614 11.5 15 9.26142 15 6.5C15 3.73858 12.7614 1.5 10 1.5C7.23858 1.5 5 3.73858 5 6.5C5 9.26142 7.23858 11.5 10 11.5Z" stroke="#343F52" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M1.41016 21.5C1.41016 17.63 5.26018 14.5 10.0002 14.5C11.0402 14.5 12.0402 14.65 12.9702 14.93" stroke="#343F52" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="side-link-span">{{ $isArabic ? 'تعديل حسابي' : 'Edit Profile' }}</span>
                            </button>
                        </li>
                        <li class="nav-item text-center">
                            <button class="nav-item btn btn-dark d-flex gap-2 bg-transparent rounded-pill side-btn-padding border-width-2 border-radius-20 fw-medium active-side-link"
                                    data-bs-toggle="tab" data-bs-target="#bookings-tab-pane" type="button" role="tab">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 2.5V5.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16 2.5V5.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3.5 9.58997H20.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M21 9V17.5C21 20.5 19.5 22.5 16 22.5H8C4.5 22.5 3 20.5 3 17.5V9C3 6 4.5 4 8 4H16C19.5 4 21 6 21 9Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="side-link-span">{{ $isArabic ? 'حجوزاتي' : 'My Bookings' }}</span>
                            </button>
                        </li>
                        <li class="nav-item text-center">
                            <button class="nav-item btn btn-dark d-flex gap-2 bg-transparent rounded-pill side-btn-padding border-width-2 border-radius-20 fw-medium"
                                    data-bs-toggle="tab" data-bs-target="#wishlist-tab-pane" type="button" role="tab">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.62 21.31C12.28 21.43 11.72 21.43 11.38 21.31C8.48 20.32 2 16.19 2 9.18998C2 6.09998 4.49 3.59998 7.56 3.59998C9.38 3.59998 10.99 4.47998 12 5.83998C13.01 4.47998 14.63 3.59998 16.44 3.59998C19.51 3.59998 22 6.09998 22 9.18998C22 16.19 15.52 20.32 12.62 21.31Z" stroke="#343F52" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="side-link-span">{{ $isArabic ? 'مفضلتي' : 'My Wishlist' }}</span>
                            </button>
                        </li>
                        <li class="nav-item text-center">
                            <button class="nav-item btn btn-dark d-flex gap-2 bg-transparent rounded-pill side-btn-padding border-width-2 border-radius-20 fw-medium"
                                    data-bs-toggle="tab" data-bs-target="#notifications-tab-pane" type="button" role="tab">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.02 3.41C8.71003 3.41 6.02003 6.1 6.02003 9.41V12.3C6.02003 12.91 5.76003 13.84 5.45003 14.36L4.30003 16.27C3.59003 17.45 4.08003 18.76 5.38003 19.2C9.69003 20.64 14.34 20.64 18.65 19.2C19.86 18.8 20.39 17.37 19.73 16.27L18.58 14.36C18.28 13.84 18.02 12.91 18.02 12.3V9.41C18.02 6.11 15.32 3.41 12.02 3.41Z" stroke="#343F52" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                    <path d="M13.87 3.7C13.56 3.61 13.24 3.54 12.91 3.5C11.95 3.38 11.03 3.45 10.17 3.7C10.46 2.96 11.18 2.44 12.02 2.44C12.86 2.44 13.58 2.96 13.87 3.7Z" stroke="#343F52" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15.02 19.56C15.02 21.21 13.67 22.56 12.02 22.56C11.2 22.56 10.44 22.22 9.90002 21.68C9.36002 21.14 9.02002 20.38 9.02002 19.56" stroke="#343F52" stroke-width="1.5" stroke-miterlimit="10"/>
                                </svg>
                                <span class="side-link-span position-relative">
                                    {{ $isArabic ? 'الإشعارات' : 'Notifications' }}
                                    @php
                                        $unreadCount = \App\Models\CustomerNotification::where('customer_id', auth('customer')->id())
                                            ->where('is_read', false)
                                            ->count();
                                    @endphp
                                    @if($unreadCount > 0)
                                        <span class="badge bg-danger position-absolute" style="top: -5px; right: -10px; font-size: 10px;">{{ $unreadCount }}</span>
                                    @endif
                                </span>
                            </button>
                        </li>
                        <li class="nav-item text-center">
                            <form action="{{ route('customer_logout') }}" method="POST" style="width: 100%;">
                                @csrf
                                <button type="submit" class="nav-item btn btn-danger d-flex border-radius-25 gap-2 text-danger bg-transparent side-btn-padding border-width-2 fw-medium w-100">
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.8999 8.05999C9.2099 4.45999 11.0599 2.98999 15.1099 2.98999H15.2399C19.7099 2.98999 21.4999 4.77999 21.4999 9.24999V15.77C21.4999 20.24 19.7099 22.03 15.2399 22.03H15.1099C11.0899 22.03 9.2399 20.58 8.9099 17.04" stroke="#EA1C1C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M2 12.5H14.88" stroke="#EA1C1C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.6499 9.15002L15.9999 12.5L12.6499 15.85" stroke="#EA1C1C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="side-link-span">{{ $isArabic ? 'تسجيل الخروج' : 'Logout' }}</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="profile-content tab-content">
                <!-- Profile Tab Pane -->
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel">
                    <!-- Profile Form Section -->
                    <div class="profile-form">
                        <form method="POST" action="{{ route('profile-update') }}">
                            @csrf
                            <div class="form-container">
                                <!-- RIGHT SIDE - Personal Information -->
                                <div class="form-right">
                                    <div class="form-group">
                                        <label class="form-label fw-medium secondary-green-color">{{ $isArabic ? 'الاسم' : 'Name' }}</label>
                                        <input type="text" name="name" class="form-input" placeholder="{{ $isArabic ? 'ادخل الاسم هنا' : 'Enter your name' }}" value="{{ auth('customer')->user()->name }}" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label fw-medium secondary-green-color">{{ $isArabic ? 'رقم الهاتف' : 'Phone Number' }}</label>
                                        <input type="tel" name="phone" class="form-input" placeholder="{{ $isArabic ? 'ادخل رقم الهاتف' : 'Enter phone number' }}" value="{{ auth('customer')->user()->phone ?? '' }}">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label fw-medium secondary-green-color">{{ $isArabic ? 'البريد الإلكتروني' : 'Email' }}</label>
                                        <input type="email" name="email" class="form-input" placeholder="user@gmail.com" value="{{ auth('customer')->user()->email }}" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label fw-medium secondary-green-color">{{ $isArabic ? 'العنوان' : 'Address' }}</label>
                                        <input type="text" name="address" class="form-input" placeholder="{{ $isArabic ? 'عمان، مسقط، عمان' : 'Oman, Muscat, Oman' }}" value="{{ auth('customer')->user()->address ?? '' }}">
                                    </div>
                                </div>

                                <!-- LEFT SIDE - Password Reset -->
                                <div class="form-left">
                                    <h3 class="form-title">{{ $isArabic ? 'إعادة تعيين كلمة المرور' : 'Reset Password' }}</h3>
                                    
                                    <div class="form-group">
                                        <label class="form-label fw-medium secondary-green-color">{{ $isArabic ? 'كلمة المرور الحالية' : 'Current Password' }}</label>
                                        <input type="password" name="current_password" class="form-input" placeholder="..........">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label fw-medium secondary-green-color">{{ $isArabic ? 'كلمة المرور الجديدة' : 'New Password' }}</label>
                                        <input type="password" name="password" class="form-input" placeholder="..........">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label fw-medium secondary-green-color">{{ $isArabic ? 'تأكيد كلمة المرور' : 'Confirm Password' }}</label>
                                        <input type="password" name="password_confirmation" class="form-input" placeholder="..........">
                                    </div>
                                    
                                    <button type="button" class="btn-confirm primary-bg-green rounded-pill fw-medium" onclick="updatePassword()">
                                        {{ $isArabic ? 'تأكيد' : 'Confirm' }}
                                    </button>
                                </div>
                            </div>

                            <!-- BOTTOM - Save Button -->
                            <div class="form-footer">
                                <button type="submit" class="btn-save primary-bg-green rounded-pill fw-medium">
                                    {{ $isArabic ? 'حفظ التغييرات' : 'Save Changes' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Bookings Tab Pane -->
                <div class="tab-pane fade" id="bookings-tab-pane" role="tabpanel">
                    <!-- Stats Cards Container -->
                    <div class="statistics-cards">
                        <div class="row">
                        <div class="col-md-3">
                            <div class="card statistic-card text-end bg-transparent d-flex flex-row justify-content-between align-items-center p-4">
                                <div>
                                    <div class="mb-3">
                                        <svg width="35" height="35" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8 2V5" stroke="#127664" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M16 2V5" stroke="#127664" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.5 9.08997H20.5" stroke="#127664" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M21 8.5V17C21 20 19.5 22 16 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z" stroke="#127664" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <p class="fw-bold mb-0 primary-green-color">{{ $isArabic ? 'حجوزاتي' : 'My Bookings' }}</p>
                                </div>
                                <div>
                                    @php
                                        $totalBookings = \App\Models\Booking::where('customer_id', auth('customer')->id())
                                                        ->orWhere('user_id', auth('customer')->id())
                                                        ->count();
                                    @endphp
                                    <h3 class="m-0 fw-bold">{{ $totalBookings }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card statistic-card text-end bg-transparent d-flex flex-row justify-content-between align-items-center p-4">
                                <div>
                                    <div class="mb-3">
                                        <svg width="35" height="35" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.7299 3.51001L15.4899 7.03001C15.7299 7.52002 16.3699 7.99001 16.9099 8.08001L20.0999 8.61001C22.1399 8.95001 22.6199 10.43 21.1499 11.89L18.6699 14.37C18.2499 14.79 18.0199 15.6 18.1499 16.18L18.8599 19.25C19.4199 21.68 18.1299 22.62 15.9799 21.35L12.9899 19.58C12.4499 19.26 11.5599 19.26 11.0099 19.58L8.01991 21.35C5.87991 22.62 4.57991 21.67 5.13991 19.25L5.84991 16.18C5.97991 15.6 5.74991 14.79 5.32991 14.37L2.84991 11.89C1.38991 10.43 1.85991 8.95001 3.89991 8.61001L7.08991 8.08001C7.61991 7.99001 8.25991 7.52002 8.49991 7.03001L10.2599 3.51001C11.2199 1.60001 12.7799 1.60001 13.7299 3.51001Z" stroke="#127664" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <p class="fw-bold mb-0 primary-green-color">{{ $isArabic ? 'تقييمات العملاء' : 'Customer Reviews' }}</p>
                                </div>
                                <div>
                                    <h3 class="m-0 fw-bold">0</h3>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- Bookings Tabs -->
                    <div class="booking-tabs">
                    @php
                        $allBookings = \App\Models\Booking::where('customer_id', auth('customer')->id())
                                    ->orWhere('user_id', auth('customer')->id())
                                    ->with(['chalet', 'chalet.city', 'chalet.area'])
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                        $activeBookings = $allBookings->whereIn('status', ['new', 'confirmed']);
                        $completedBookings = $allBookings->where('status', 'completed');
                        $cancelledBookings = $allBookings->whereIn('status', ['canceled', 'cancelled']);
                    @endphp
                    
                    <ul class="nav nav-tabs" id="bookingTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                                {{ $isArabic ? 'جميع الحجوزات' : 'All Bookings' }}
                                <span class="badge">{{ $allBookings->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
                                {{ $isArabic ? 'الحجوزات النشطة' : 'Active Bookings' }}
                                <span class="badge">{{ $activeBookings->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                                {{ $isArabic ? 'الحجوزات المكتملة' : 'Completed' }}
                                <span class="badge">{{ $completedBookings->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab">
                                {{ $isArabic ? 'الحجوزات الملغاة' : 'Cancelled' }}
                                <span class="badge">{{ $cancelledBookings->count() }}</span>
                            </button>
                        </li>
                    </ul>
                </div>
                
                <!-- Tab Content -->
                <div class="tab-content" id="bookingTabContent">
                    <!-- All Bookings Tab -->
                    <div class="tab-pane fade show active" id="all" role="tabpanel">
                        <div class="bookings-table">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ $isArabic ? 'رقم العرض' : 'Booking No.' }}</th>
                                            <th>{{ $isArabic ? 'الشاليه' : 'Chalet' }}</th>
                                            <th>{{ $isArabic ? 'تاريخ الوصول' : 'Check-in' }}</th>
                                            <th>{{ $isArabic ? 'تاريخ المغادرة' : 'Check-out' }}</th>
                                            <th>{{ $isArabic ? 'المبلغ' : 'Amount' }}</th>
                                            <th>{{ $isArabic ? 'الحالة' : 'Status' }}</th>
                                            <th>{{ $isArabic ? 'الإجراءات' : 'Actions' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($allBookings as $order)
                                <tr>
                                    <td>
                                        <strong>{{ $order->booking_number }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $order->created_at->format('Y-m-d') }}</small>
                                    </td>
                                    <td>
                                        @if($order->chalet)
                                            <a href="{{ route('showChalet', $order->chalet->slug) }}" class="text-decoration-none">
                                                {{ $isArabic ? $order->chalet->chalet_name_ar : $order->chalet->chalet_name_en }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->checkin_date)
                                            {{ $order->checkin_date->format('Y-m-d') }}
                                            @if($order->checkin_time)
                                                <br><small>{{ date('g:i A', strtotime($order->checkin_time)) }}</small>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->checkout_date)
                                            {{ $order->checkout_date->format('Y-m-d') }}
                                            @if($order->checkout_time)
                                                <br><small>{{ date('g:i A', strtotime($order->checkout_time)) }}</small>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ number_format($order->total_amount, 2) }}</strong>
                                        <br>
                                        <small>{{ $isArabic ? 'ريال' : 'SAR' }}</small>
                                    </td>
                                    <td>
                                        @if($order->status == 'new')
                                            <span class="badge bg-info">{{ $isArabic ? 'جديد' : 'New' }}</span>
                                        @elseif($order->status == 'confirmed')
                                            <span class="badge bg-success">{{ $isArabic ? 'مؤكد' : 'Confirmed' }}</span>
                                        @elseif($order->status == 'canceled' || $order->status == 'cancelled')
                                            <span class="badge bg-danger">{{ $isArabic ? 'ملغي' : 'Cancelled' }}</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-primary">{{ $isArabic ? 'مكتمل' : 'Completed' }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $order->status }}</span>
                                        @endif
                                        
                                        <br>
                                        
                                        @if($order->payment_status == 'paid')
                                            <span class="badge bg-success mt-1">{{ $isArabic ? 'مدفوع' : 'Paid' }}</span>
                                        @else
                                            <span class="badge bg-warning mt-1">{{ $isArabic ? 'غير مدفوع' : 'Unpaid' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            @if($order->status == 'new' || $order->status == 'pending')
                                                <a class="btn btn-success btn-sm px-3" href="{{ route('booking.confirm.page', ['booking_number' => $order->booking_number]) }}" title="{{ $isArabic ? 'تأكيد الطلب' : 'Confirm Order' }}">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    {{ $isArabic ? 'تأكيد' : 'Confirm' }}
                                                </a>
                                            @elseif($order->status == 'confirmed')
                                                <span class="btn btn-sm btn-outline-success disabled px-3">
                                                    <i class="fas fa-check me-1"></i>
                                                    {{ $isArabic ? 'مؤكد' : 'Confirmed' }}
                                                </span>
                                            @endif
                                            <a class="btn-print btn btn-sm" target="_blank" href="{{ route('showInvoice', $order->slug) }}" title="{{ $isArabic ? 'طباعة' : 'Print' }}">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="empty-state">
                                                <i class="fas fa-inbox fa-5x"></i>
                                                <p>{{ $isArabic ? 'لا توجد حجوزات حتى الآن' : 'No bookings yet' }}</p>
                                                <a href="{{ route('showAllChalet') }}" class="btn btn-primary">
                                                    {{ $isArabic ? 'تصفح الشاليهات' : 'Browse Chalets' }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Active Bookings Tab -->
                    <div class="tab-pane fade" id="active" role="tabpanel">
                        @include('frontend.customer.partials.bookings-table', [
                            'bookings' => $activeBookings,
                            'isArabic' => $isArabic,
                            'emptyMessage' => $isArabic ? 'لا توجد حجوزات نشطة' : 'No active bookings'
                        ])
                    </div>
                    
                    <!-- Completed Bookings Tab -->
                    <div class="tab-pane fade" id="completed" role="tabpanel">
                        @include('frontend.customer.partials.bookings-table', [
                            'bookings' => $completedBookings,
                            'isArabic' => $isArabic,
                            'emptyMessage' => $isArabic ? 'لا توجد حجوزات مكتملة' : 'No completed bookings'
                        ])
                    </div>
                    
                    <!-- Cancelled Bookings Tab -->
                    <div class="tab-pane fade" id="cancelled" role="tabpanel">
                        @include('frontend.customer.partials.bookings-table', [
                            'bookings' => $cancelledBookings,
                            'isArabic' => $isArabic,
                            'emptyMessage' => $isArabic ? 'لا توجد حجوزات ملغاة' : 'No cancelled bookings'
                        ])
                    </div>
                    </div>
                </div> <!-- End Bookings Tab Pane -->
                
                <!-- Wishlist Tab Pane -->
                <div class="tab-pane fade" id="wishlist-tab-pane" role="tabpanel">
                    <div class="row g-4">
                        @php
                            $wishlists = auth('customer')->user()->wishlist ?? [];
                        @endphp
                        @forelse($wishlists as $chalet)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="deal-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s ease; height: 100%;">
                                    <!-- Card Image -->
                                    <div class="deal-image" style="position: relative; height: 250px; overflow: hidden;">
                                        <img src="{{ asset($chalet->main_image ?? 'no_image.png') }}" 
                                             alt="{{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}"
                                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                        
                                        <!-- Discount Badge if exists -->
                                        @php
                                            $defaultPrice = $chalet->default_day_price ?? 100;
                                            $holidayPrice = $chalet->holiday_day_price ?? 150;
                                            $actualDiscount = 0;
                                            if ($holidayPrice > $defaultPrice) {
                                                $actualDiscount = round((($holidayPrice - $defaultPrice) / $holidayPrice) * 100);
                                            }
                                        @endphp
                                        @if($actualDiscount > 0)
                                            @if($actualDiscount >= 50)
                                                <span class="discount-badge" style="position: absolute; top: 20px; left: 20px; background: linear-gradient(135deg, #127664 0%, #159265 100%); color: white; padding: 8px 16px; border-radius: 25px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 10px rgba(18, 118, 100, 0.3);">
                                                    {{ $actualDiscount }}% {{ $isArabic ? 'خصم' : 'off' }}
                                                </span>
                                            @else
                                                <span class="discount-badge" style="position: absolute; top: 20px; left: 20px; background: linear-gradient(135deg, #ff9f43 0%, #ff6348 100%); color: white; padding: 8px 16px; border-radius: 25px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 10px rgba(255, 99, 72, 0.3);">
                                                    {{ $actualDiscount }}% {{ $isArabic ? 'خصم' : 'off' }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    <!-- Card Content -->
                                    <div class="deal-content" style="padding: 20px;">
                                        <!-- Price -->
                                        <div class="deal-price-tag" style="margin-bottom: 15px;">
                                            @if($holidayPrice > $defaultPrice)
                                                <del style="color: #999; font-size: 14px; margin-right: 10px;">{{ number_format($holidayPrice, 0) }}</del>
                                            @endif
                                            <span style="color: #127664; font-size: 24px; font-weight: 700;">
                                                {{ number_format($defaultPrice, 0) }} {{ $isArabic ? 'ر.ع' : 'OMR' }}
                                            </span>
                                        </div>
                                        
                                        <!-- Title -->
                                        <h3 class="deal-title" style="font-size: 18px; font-weight: 600; margin-bottom: 10px; color: #333;">
                                            {{ $isArabic ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}
                                        </h3>
                                        
                                        <!-- Location -->
                                        <p class="deal-location" style="color: #666; font-size: 14px; margin-bottom: 15px;">
                                            <i class="fas fa-map-marker-alt" style="color: #127664; margin-right: 5px;"></i>
                                            {{ $isArabic ? $chalet->city->name_ar ?? '' : $chalet->city->name_en ?? '' }}
                                            @if($chalet->area)
                                                / {{ $isArabic ? $chalet->area->name_ar ?? '' : $chalet->area->name_en ?? '' }}
                                            @endif
                                        </p>
                                        
                                        <!-- Host Info -->
                                        @if($chalet->owner)
                                        <div class="deal-host" style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                                            <img src="https://i.pravatar.cc/150?img={{ $chalet->owner->id ?? rand(1, 50) }}" 
                                                 alt="Host" 
                                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                            <div class="host-info">
                                                <span style="display: block; font-weight: 600; color: #333; font-size: 14px;">{{ $chalet->owner->name ?? 'مالك العقار' }}</span>
                                                <span style="display: block; color: #999; font-size: 12px;">{{ $isArabic ? 'مالك العقار' : 'Property Owner' }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Actions -->
                                        <div class="deal-actions" style="display: flex; gap: 10px; align-items: center;">
                                            <button class="btn-view-details" 
                                                    onclick="window.location.href='{{ route('showChalet', $chalet->slug) }}'"
                                                    style="flex: 1; background: linear-gradient(135deg, #127664 0%, #159265 100%); color: white; border: none; padding: 12px 20px; border-radius: 10px; font-weight: 500; cursor: pointer; transition: all 0.3s;">
                                                {{ $isArabic ? 'عرض التفاصيل' : 'View Details' }}
                                            </button>
                                            <button class="btn-wishlist-circle wishlist-btn active" 
                                                    data-chalet-id="{{ $chalet->id }}"
                                                    style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid #159265; background: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s;">
                                                <svg width="20" height="18" viewBox="0 0 18 16" fill="#159265" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.496 15.0542C9.224 15.1486 8.776 15.1486 8.504 15.0542C6.184 14.2756 1 11.0272 1 5.52163C1 3.09129 2.992 1.125 5.448 1.125C6.904 1.125 8.192 1.81714 9 2.8868C9.808 1.81714 11.104 1.125 12.552 1.125C15.008 1.125 17 3.09129 17 5.52163C17 11.0272 11.816 14.2756 9.496 15.0542Z" stroke="#159265" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state" style="text-align: center; padding: 80px 20px; background: white; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                    <i class="fas fa-heart" style="font-size: 5rem; color: #e0e0e0; margin-bottom: 20px;"></i>
                                    <h3 style="color: #333; margin-bottom: 10px;">{{ $isArabic ? 'لا توجد شاليهات في المفضلة' : 'No chalets in wishlist' }}</h3>
                                    <p style="color: #6c757d; margin-bottom: 30px;">{{ $isArabic ? 'ابدأ بإضافة الشاليهات المفضلة لديك' : 'Start adding your favorite chalets' }}</p>
                                    <a href="{{ route('showAllChalet') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #127664 0%, #159265 100%); border: none; padding: 12px 30px; border-radius: 8px; font-weight: 500;">
                                        {{ $isArabic ? 'تصفح الشاليهات' : 'Browse Chalets' }}
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div> <!-- End Wishlist Tab Pane -->
                
                <!-- Notifications Tab Pane -->
                <div class="tab-pane fade" id="notifications-tab-pane" role="tabpanel">
                    @php
                        $notifications = \App\Models\CustomerNotification::where('customer_id', auth('customer')->id())
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
                    @endphp
                    
                    <div class="notifications-container">
                        <!-- Header with Mark All Read Button -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">{{ $isArabic ? 'الإشعارات' : 'Notifications' }}</h4>
                            @if($notifications->where('is_read', false)->count() > 0)
                                <button onclick="markAllNotificationsAsRead()" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-check-double me-2"></i>
                                    {{ $isArabic ? 'تحديد الكل كمقروء' : 'Mark All as Read' }}
                                </button>
                            @endif
                        </div>
                        
                        @if($notifications->count() > 0)
                            <div class="notifications-list">
                                @foreach($notifications as $notification)
                                    <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }} mb-3" 
                                         onclick="viewNotification({{ $notification->id }}, '{{ $notification->booking_id ? route('customer.bookings.show', $notification->booking_id) : '#' }}')"
                                         style="cursor: pointer; background: {{ !$notification->is_read ? '#f0f9ff' : 'white' }}; 
                                                border: 1px solid #e0e0e0; border-radius: 12px; padding: 20px; 
                                                transition: all 0.3s ease; position: relative;
                                                {{ !$notification->is_read ? 'border-left: 4px solid #127664;' : '' }}">
                                        
                                        <div class="row align-items-start">
                                            <div class="col-auto">
                                                <div class="notification-icon" 
                                                     style="width: 50px; height: 50px; border-radius: 50%; 
                                                            background: {{ $notification->icon_color ?? '#127664' }}20; 
                                                            display: flex; align-items: center; justify-content: center;">
                                                    <i class="{{ $notification->icon_class ?? 'fas fa-bell' }}" 
                                                       style="color: {{ $notification->icon_color ?? '#127664' }}; font-size: 20px;"></i>
                                                </div>
                                            </div>
                                            
                                            <div class="col">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">
                                                            {{ app()->getLocale() == 'ar' ? $notification->title_ar : $notification->title_en }}
                                                            @if(!$notification->is_read)
                                                                <span class="badge bg-danger ms-2">{{ $isArabic ? 'جديد' : 'New' }}</span>
                                                            @endif
                                                        </h6>
                                                        <p class="mb-2 text-muted">{{ app()->getLocale() == 'ar' ? $notification->message_ar : $notification->message_en }}</p>
                                                        
                                                        @if($notification->booking)
                                                            <div class="notification-details mt-2">
                                                                <span class="badge bg-light text-dark me-2">
                                                                    <i class="fas fa-hashtag"></i> {{ $notification->booking->booking_number }}
                                                                </span>
                                                                <span class="badge bg-light text-dark me-2">
                                                                    <i class="fas fa-calendar"></i> 
                                                                    {{ \Carbon\Carbon::parse($notification->booking->checkin_date)->format('Y/m/d') }}
                                                                </span>
                                                                @if($notification->booking->chalet)
                                                                    <span class="badge bg-light text-dark">
                                                                        <i class="fas fa-home"></i> 
                                                                        {{ app()->getLocale() == 'ar' ? $notification->booking->chalet->name : $notification->booking->chalet->name_en }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        
                                                        <small class="text-muted">
                                                            <i class="far fa-clock"></i>
                                                            {{ $notification->created_at->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                    
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" onclick="event.stopPropagation()">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <button class="dropdown-item text-danger" onclick="deleteNotification({{ $notification->id }}); event.stopPropagation();">
                                                                    <i class="fas fa-trash me-2"></i>
                                                                    {{ $isArabic ? 'حذف' : 'Delete' }}
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $notifications->fragment('notifications')->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">{{ $isArabic ? 'لا توجد إشعارات' : 'No Notifications' }}</h5>
                                <p class="text-muted">{{ $isArabic ? 'سيتم عرض إشعاراتك هنا عندما تتلقى أي تحديثات' : 'Your notifications will appear here when you receive any updates' }}</p>
                            </div>
                        @endif
                    </div>
                </div> <!-- End Notifications Tab Pane -->
                
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto dismiss success message after 5 seconds
    const successMessage = document.querySelector('.booking-success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.animation = 'fadeOut 0.5s ease-out';
            setTimeout(() => {
                successMessage.remove();
            }, 500);
        }, 5000);
    }
    
    // Sidebar tabs management
    const sidebarButtons = document.querySelectorAll('.sidebar-nav button[data-bs-toggle="tab"]');
    
    sidebarButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all sidebar buttons
            sidebarButtons.forEach(btn => {
                btn.classList.remove('active-side-link');
                // Reset stroke color for SVG paths
                btn.querySelectorAll('svg path').forEach(path => {
                    path.setAttribute('stroke', '#343F52');
                });
            });
            
            // Add active class to clicked button
            this.classList.add('active-side-link');
            // Set white stroke for active button SVG
            this.querySelectorAll('svg path').forEach(path => {
                path.setAttribute('stroke', 'white');
            });
            
            // Save active sidebar tab
            const target = this.getAttribute('data-bs-target');
            localStorage.setItem('activeProfileTab', target);
        });
    });
    
    // Restore last active sidebar tab
    const lastSidebarTab = localStorage.getItem('activeProfileTab');
    if (lastSidebarTab) {
        const sidebarButton = document.querySelector(`.sidebar-nav button[data-bs-target="${lastSidebarTab}"]`);
        if (sidebarButton) {
            // Trigger click to activate the tab
            sidebarButton.click();
        }
    }
    
    // Booking tabs management (inner tabs)
    const lastTab = localStorage.getItem('bookingsActiveTab');
    if (lastTab) {
        const tabButton = document.querySelector(`.booking-tabs button[data-bs-target="${lastTab}"]`);
        if (tabButton && document.querySelector('#bookings-tab-pane').classList.contains('active')) {
            // Remove active class from all booking tabs
            document.querySelectorAll('.booking-tabs .nav-link').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('#bookings-tab-pane .tab-pane').forEach(p => p.classList.remove('show', 'active'));
            
            // Add active class to saved tab
            tabButton.classList.add('active');
            const targetPane = document.querySelector(lastTab);
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        }
    }
    
    // Save active booking tab on change
    const bookingTabButtons = document.querySelectorAll('.booking-tabs .nav-link');
    bookingTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-bs-target');
            localStorage.setItem('bookingsActiveTab', target);
        });
    });
    
    // Add animation to badge counts
    const badges = document.querySelectorAll('.booking-tabs .badge');
    badges.forEach(badge => {
        const count = parseInt(badge.textContent);
        if (count > 0) {
            badge.style.transform = 'scale(1.1)';
            setTimeout(() => {
                badge.style.transform = 'scale(1)';
            }, 300);
        }
    });
    
    // Handle direct navigation from URL hash
    if (window.location.hash) {
        const hash = window.location.hash.substring(1);
        if (hash === 'bookings') {
            // Activate bookings tab
            const bookingsBtn = document.querySelector('button[data-bs-target="#bookings-tab-pane"]');
            if (bookingsBtn) {
                bookingsBtn.click();
            }
        } else if (hash === 'profile') {
            // Activate profile tab
            const profileBtn = document.querySelector('button[data-bs-target="#profile-tab-pane"]');
            if (profileBtn) {
                profileBtn.click();
            }
        } else if (hash === 'wishlist') {
            // Activate wishlist tab
            const wishlistBtn = document.querySelector('button[data-bs-target="#wishlist-tab-pane"]');
            if (wishlistBtn) {
                wishlistBtn.click();
                // Make sure to hide bookings content
                const bookingsPane = document.querySelector('#bookings-tab-pane');
                if (bookingsPane) {
                    bookingsPane.classList.remove('show', 'active');
                }
                const wishlistPane = document.querySelector('#wishlist-tab-pane');
                if (wishlistPane) {
                    wishlistPane.classList.add('show', 'active');
                }
            }
        } else if (hash === 'notifications') {
            // Activate notifications tab
            const notificationsBtn = document.querySelector('button[data-bs-target="#notifications-tab-pane"]');
            if (notificationsBtn) {
                notificationsBtn.click();
            }
        }
    } else {
        // No hash, default to bookings tab
        const bookingsBtn = document.querySelector('button[data-bs-target="#bookings-tab-pane"]');
        if (bookingsBtn) {
            bookingsBtn.click();
        }
    }
});

// Handle wishlist toggle in wishlist tab
document.addEventListener('DOMContentLoaded', function() {
    // Wishlist button functionality in wishlist tab
    const wishlistButtons = document.querySelectorAll('#wishlist-tab-pane .wishlist-btn');
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const btn = this;
            const chaletId = btn.getAttribute('data-chalet-id');
            const chaletCard = btn.closest('.col-12');
            
            @auth('customer')
                // Disable button during request
                btn.disabled = true;
                btn.style.opacity = '0.5';
                
                // Send AJAX request to toggle wishlist
                const wishlistUrl = @json(route('wishlist.toggle', ['chalet' => '__CHALET_ID__']));

                fetch(wishlistUrl.replace('__CHALET_ID__', encodeURIComponent(chaletId)), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _token: '{{ csrf_token() }}'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success || data.status === 'removed') {
                        // Animate and remove the card
                        chaletCard.style.transition = 'all 0.3s ease';
                        chaletCard.style.transform = 'scale(0.9)';
                        chaletCard.style.opacity = '0';
                        
                        setTimeout(() => {
                            chaletCard.remove();
                            
                            // Check if wishlist is empty
                            const remainingCards = document.querySelectorAll('#wishlist-tab-pane .deal-card').length;
                            if (remainingCards === 0) {
                                // Show empty state
                                const wishlistContainer = document.querySelector('#wishlist-tab-pane .row');
                                wishlistContainer.innerHTML = `
                                    <div class="col-12">
                                        <div class="empty-state" style="text-align: center; padding: 80px 20px; background: white; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                            <i class="fas fa-heart" style="font-size: 5rem; color: #e0e0e0; margin-bottom: 20px;"></i>
                                            <h3 style="color: #333; margin-bottom: 10px;">{{ $isArabic ? 'لا توجد شاليهات في المفضلة' : 'No chalets in wishlist' }}</h3>
                                            <p style="color: #6c757d; margin-bottom: 30px;">{{ $isArabic ? 'ابدأ بإضافة الشاليهات المفضلة لديك' : 'Start adding your favorite chalets' }}</p>
                                            <a href="{{ route('showAllChalet') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #127664 0%, #159265 100%); border: none; padding: 12px 30px; border-radius: 8px; font-weight: 500;">
                                                {{ $isArabic ? 'تصفح الشاليهات' : 'Browse Chalets' }}
                                            </a>
                                        </div>
                                    </div>
                                `;
                            }
                        }, 300);
                        
                        // Show success message
                        showToastNotification('success', '{{ $isArabic ? "تم إزالة الشاليه من المفضلة" : "Chalet removed from wishlist" }}');
                    } else {
                        // Re-enable button if failed
                        btn.disabled = false;
                        btn.style.opacity = '1';
                        showToastNotification('error', data.message || '{{ $isArabic ? "حدث خطأ" : "An error occurred" }}');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    showToastNotification('error', '{{ $isArabic ? "حدث خطأ في الاتصال" : "Connection error" }}');
                });
            @else
                // User is not logged in
                if (confirm('{{ $isArabic ? "يجب تسجيل الدخول أولاً. هل تريد الذهاب إلى صفحة تسجيل الدخول؟" : "You need to login first. Do you want to go to login page?" }}')) {
                    window.location.href = '{{ route("login") }}';
                }
            @endauth
        });
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
    
    // Add animation styles
    const style = document.createElement('style');
    style.textContent = `
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
    `;
    document.head.appendChild(style);
    
    toast.innerHTML = `
        <div style="font-size: 24px; color: ${type === 'success' ? '#28a745' : '#dc3545'};">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        </div>
        <div style="flex: 1;">${message}</div>
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

// Update password function
function updatePassword() {
    const currentPassword = document.querySelector('input[name="current_password"]').value;
    const newPassword = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;
    
    if (!currentPassword || !newPassword || !confirmPassword) {
        alert('{{ $isArabic ? "يرجى ملء جميع حقول كلمة المرور" : "Please fill all password fields" }}');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        alert('{{ $isArabic ? "كلمة المرور الجديدة غير متطابقة" : "New passwords do not match" }}');
        return;
    }
    
    if (newPassword.length < 8) {
        alert('{{ $isArabic ? "كلمة المرور يجب أن تكون 8 أحرف على الأقل" : "Password must be at least 8 characters" }}');
        return;
    }
    
    // Create form data
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('current_password', currentPassword);
    formData.append('password', newPassword);
    formData.append('password_confirmation', confirmPassword);
    
    // Send AJAX request
    fetch('{{ route("reset-password") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('{{ $isArabic ? "تم تحديث كلمة المرور بنجاح" : "Password updated successfully" }}');
            // Clear password fields
            document.querySelector('input[name="current_password"]').value = '';
            document.querySelector('input[name="password"]').value = '';
            document.querySelector('input[name="password_confirmation"]').value = '';
        } else {
            alert(data.message || '{{ $isArabic ? "حدث خطأ في تحديث كلمة المرور" : "Error updating password" }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ $isArabic ? "حدث خطأ في الاتصال" : "Connection error" }}');
    });
}
// Notifications Functions
function viewNotification(notificationId, url) {
    // Mark as read via AJAX
    fetch(`/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI
            const notificationItem = document.querySelector(`.notification-item[onclick*="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.classList.remove('unread');
                notificationItem.style.background = 'white';
                notificationItem.style.borderLeft = 'none';
                const newBadge = notificationItem.querySelector('.badge.bg-danger');
                if (newBadge) {
                    newBadge.remove();
                }
            }
            
            // Update unread count in sidebar
            updateUnreadCount();
            
            // Navigate to booking if URL provided
            if (url && url !== '#') {
                window.location.href = url;
            }
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function deleteNotification(notificationId) {
    if (confirm('{{ $isArabic ? "هل أنت متأكد من حذف هذا الإشعار؟" : "Are you sure you want to delete this notification?" }}')) {
        fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove notification from UI
                const notificationItem = document.querySelector(`.notification-item[onclick*="${notificationId}"]`);
                if (notificationItem) {
                    notificationItem.style.animation = 'fadeOut 0.3s ease';
                    setTimeout(() => {
                        notificationItem.remove();
                        
                        // Check if no more notifications
                        const remainingNotifications = document.querySelectorAll('#notifications-tab-pane .notification-item').length;
                        if (remainingNotifications === 0) {
                            // Show empty state
                            const notificationsContainer = document.querySelector('#notifications-tab-pane .notifications-list');
                            if (notificationsContainer) {
                                notificationsContainer.innerHTML = `
                                    <div class="text-center py-5">
                                        <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">{{ $isArabic ? 'لا توجد إشعارات' : 'No Notifications' }}</h5>
                                        <p class="text-muted">{{ $isArabic ? 'سيتم عرض إشعاراتك هنا عندما تتلقى أي تحديثات' : 'Your notifications will appear here when you receive any updates' }}</p>
                                    </div>
                                `;
                            }
                        }
                    }, 300);
                }
                
                showToastNotification('success', '{{ $isArabic ? "تم حذف الإشعار بنجاح" : "Notification deleted successfully" }}');
            }
        })
        .catch(error => {
            console.error('Error deleting notification:', error);
            showToastNotification('error', '{{ $isArabic ? "حدث خطأ أثناء حذف الإشعار" : "Error deleting notification" }}');
        });
    }
}

function markAllNotificationsAsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update all notifications UI
            document.querySelectorAll('#notifications-tab-pane .notification-item.unread').forEach(item => {
                item.classList.remove('unread');
                item.style.background = 'white';
                item.style.borderLeft = 'none';
                const newBadge = item.querySelector('.badge.bg-danger');
                if (newBadge) {
                    newBadge.remove();
                }
            });
            
            // Hide mark all as read button
            const markAllBtn = document.querySelector('button[onclick="markAllNotificationsAsRead()"]');
            if (markAllBtn) {
                markAllBtn.style.display = 'none';
            }
            
            // Update unread count
            updateUnreadCount();
            
            showToastNotification('success', '{{ $isArabic ? "تم تحديد جميع الإشعارات كمقروءة" : "All notifications marked as read" }}');
        }
    })
    .catch(error => {
        console.error('Error marking all as read:', error);
        showToastNotification('error', '{{ $isArabic ? "حدث خطأ" : "An error occurred" }}');
    });
}

function updateUnreadCount() {
    // Update badge in sidebar
    fetch('/notifications/unread-count', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const badge = document.querySelector('button[data-bs-target="#notifications-tab-pane"] .badge');
        if (badge) {
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }
    })
    .catch(error => {
        console.error('Error updating unread count:', error);
    });
}

// Add fadeOut animation
if (!document.querySelector('#fadeOutStyle')) {
    const style = document.createElement('style');
    style.id = 'fadeOutStyle';
    style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; transform: translateX(0); }
            to { opacity: 0; transform: translateX(20px); }
        }
    `;
    document.head.appendChild(style);
}
</script>
@endsection
