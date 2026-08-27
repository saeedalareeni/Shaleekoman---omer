@extends('owners.layouts.master')

@section('page_title')
    {{trans('back.dashboard')}}
@endsection

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Font Awesome All Versions -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="{{ asset('assets/css/owner-dashboard.css') }}" rel="stylesheet">
<style>
    /* تحسين شكل الأزرار في جدول الحجوزات */
    .bookings-content .btn-group {
        display: inline-flex;
        gap: 4px;
    }
    
    .bookings-content .btn-group .btn {
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 4px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .bookings-content .btn-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .bookings-content .btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
    }
    
    .bookings-content .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
    }
    
    .bookings-content .btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
    }
    
    .bookings-content .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
    }
    
    /* Force Tajwal Font for Arabic */
    @if(app()->getLocale() == 'ar')
    *, *::before, *::after {
        font-family: 'Tajawal', sans-serif !important;
    }
    body, h1, h2, h3, h4, h5, h6, p, span, div, a, button, input, select, textarea,
    .btn, .card, .card-title, .card-text, .navbar, .nav-link, .breadcrumb,
    .stat-card, .property-item, .timeline-content, .notification-item {
        font-family: 'Tajawal', sans-serif !important;
    }
    @endif
    
    /* CRITICAL FIX FOR FONT AWESOME ICONS */
    i.fa:before,
    i.fas:before,
    i.far:before,
    i.fab:before,
    i[class*="fa-"]:before {
        font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome", "Font Awesome 5 Pro" !important;
        display: inline-block !important;
        font-style: normal !important;
        font-variant: normal !important;
        text-rendering: auto !important;
        -webkit-font-smoothing: antialiased !important;
    }
    
    .fas, .fa, i.fas, i.fa {
        font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
        font-weight: 900 !important;
    }
    
    .far, i.far {
        font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
        font-weight: 400 !important;
    }
    
    .fab, i.fab {
        font-family: "Font Awesome 6 Brands", "Font Awesome 5 Brands" !important;
        font-weight: 400 !important;
    }
    
    /* Override any conflicting styles */
    #wrapper i[class*="fa-"],
    .content-page i[class*="fa-"],
    .card i[class*="fa-"],
    .btn i[class*="fa-"],
    button i[class*="fa-"] {
        display: inline-block !important;
        font-style: normal !important;
    }
    
    /* Force Font Awesome Icons to Display */
    .fa:before,
    .fas:before,
    .far:before,
    .fab:before {
        display: inline-block !important;
        font-style: normal !important;
        font-variant: normal !important;
        text-rendering: auto !important;
        -webkit-font-smoothing: antialiased !important;
    }
    
    /* Fallback for older Font Awesome */
    .fa {
        font-family: 'FontAwesome', 'Font Awesome 6 Free', 'Font Awesome 5 Free' !important;
    }
    
    .fas, .fa-solid {
        font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free' !important;
        font-weight: 900 !important;
    }
    
    .far, .fa-regular {
        font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free' !important;
        font-weight: 400 !important;
    }
    
    .fab, .fa-brands {
        font-family: 'Font Awesome 6 Brands', 'Font Awesome 5 Brands' !important;
        font-weight: 400 !important;
    }
    
    /* Ensure icons in buttons and cards are visible */
    .btn i, .card i, .stat-card i, .property-item i, .timeline-icon i {
        display: inline-block !important;
        margin-left: 5px;
        margin-right: 5px;
    }
    
    /* Fix for RTL icons */
    i.fas, i.far, i.fab {
        display: inline-block !important;
    }
    
    /* Fix margin classes */
    .me-2 {
        margin-left: 0.5rem !important;
    }
    
    .ms-2 {
        margin-right: 0.5rem !important;
    }
    
    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        /* Smaller padding for mobile */
        .container-fluid {
            padding: 10px !important;
        }
        
        /* Stats Cards Mobile */
        .stat-card {
            padding: 15px !important;
            margin-bottom: 10px !important;
        }
        
        .stat-card .stat-icon {
            width: 40px !important;
            height: 40px !important;
            font-size: 18px !important;
        }
        
        .stat-card .stat-value {
            font-size: 24px !important;
        }
        
        .stat-card .stat-label {
            font-size: 12px !important;
        }
        
        /* Property Cards Mobile */
        .property-item {
            padding: 10px !important;
            margin-bottom: 10px !important;
        }
        
        .property-item .property-image {
            width: 50px !important;
            height: 50px !important;
        }
        
        .property-item .property-name {
            font-size: 14px !important;
        }
        
        .property-item .property-location {
            font-size: 11px !important;
        }
        
        /* Tabs Mobile */
        .nav-tabs .nav-link {
            padding: 8px 12px !important;
            font-size: 13px !important;
        }
        
        .nav-tabs .nav-link i {
            font-size: 14px !important;
        }
        
        /* Cards Mobile */
        .card {
            margin-bottom: 15px !important;
        }
        
        .card-header {
            padding: 12px !important;
        }
        
        .card-body {
            padding: 15px !important;
        }
        
        /* Timeline Mobile */
        .timeline {
            padding-left: 30px !important;
        }
        
        .timeline::before {
            left: 10px !important;
        }
        
        .timeline-icon {
            width: 30px !important;
            height: 30px !important;
            left: -25px !important;
        }
        
        .timeline-content {
            padding: 10px !important;
            margin-left: 0 !important;
        }
        
        /* Notifications Mobile */
        .notification-item {
            padding: 10px !important;
            margin-bottom: 8px !important;
        }
        
        .notification-item h6 {
            font-size: 13px !important;
        }
        
        .notification-item p {
            font-size: 11px !important;
        }
        
        /* Forms Mobile */
        .form-label {
            font-size: 13px !important;
        }
        
        .form-control, .form-select {
            font-size: 14px !important;
            padding: 8px 12px !important;
        }
        
        /* Buttons Mobile */
        .btn {
            font-size: 13px !important;
            padding: 8px 16px !important;
        }
        
        .btn-sm {
            font-size: 11px !important;
            padding: 5px 10px !important;
        }
        
        /* Tables Mobile */
        .table {
            font-size: 12px !important;
        }
        
        .table th, .table td {
            padding: 8px !important;
        }
        
        /* Hide some elements on mobile */
        .hide-mobile {
            display: none !important;
        }
        
        /* Stack columns on mobile */
        .col-md-3, .col-md-4, .col-md-6, .col-md-8, .col-lg-3, .col-lg-4 {
            margin-bottom: 15px;
        }
    }
    
    /* Very Small Screens */
    @media (max-width: 480px) {
        .stat-card .stat-value {
            font-size: 20px !important;
        }
        
        .property-item {
            flex-direction: column !important;
            text-align: center !important;
        }
        
        .property-info {
            flex-direction: column !important;
            align-items: center !important;
        }
        
        .property-details {
            text-align: center !important;
            margin-top: 10px !important;
        }
        
        .nav-tabs {
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
        
        .nav-tabs .nav-link {
            white-space: nowrap !important;
        }
    }
    
    /* Mobile Improvements for Dashboard Elements */
    @media (max-width: 768px) {
        /* Dashboard Header Mobile */
        .page-title-box {
            padding: 10px 0 !important;
        }
        
        .page-title {
            font-size: 18px !important;
        }
        
        /* Quick Stats Mobile */
        .quick-stats {
            padding: 10px !important;
        }
        
        .quick-stats .col-6 {
            padding: 5px !important;
        }
        
        /* Properties List Mobile */
        .properties-list {
            padding: 10px !important;
        }
        
        .property-price .price-badge {
            font-size: 11px !important;
            padding: 4px 8px !important;
        }
        
        /* Modal Mobile */
        .modal-dialog {
            margin: 10px !important;
            max-width: calc(100% - 20px) !important;
        }
        
        .modal-content {
            border-radius: 10px !important;
        }
        
        .modal-header, .modal-footer {
            padding: 12px !important;
        }
        
        .modal-body {
            padding: 15px !important;
        }
        
        /* Pagination Mobile */
        .pagination {
            font-size: 12px !important;
        }
        
        .page-link {
            padding: 5px 10px !important;
        }
        
        /* Alerts Mobile */
        .alert {
            padding: 10px !important;
            font-size: 13px !important;
        }
        
        /* Badges Mobile */
        .badge {
            font-size: 10px !important;
            padding: 3px 6px !important;
        }
    }
    
    /* أنماط الإشعارات */
    .notifications-section {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    
    @media (max-width: 768px) {
        .notifications-section {
            padding: 12px !important;
            border-radius: 8px !important;
        }
    }
    
    .notification-item {
        position: relative;
        overflow: hidden;
    }
    
    .notification-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .notification-item.unread::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #007bff;
    }
    
    .notification-icon {
        font-size: 14px;
    }
    
    .notification-preview p {
        margin-bottom: 0.5rem !important;
        font-size: 0.875rem;
    }
    
    /* أنماط المودال */
    .notification-modal {
        border-radius: 15px !important;
    }
    
    .notification-details .detail-item {
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    
    .notification-details .detail-item i {
        width: 20px;
    }
    
    .notification-details .alert {
        border-radius: 10px;
    }
    
    /* Property card styles */
    .property-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .property-card {
            margin-bottom: 10px !important;
        }
        
        .property-card .card-body {
            padding: 12px !important;
        }
        
        .property-card img {
            height: 120px !important;
        }
        
        .property-card .card-title {
            font-size: 14px !important;
        }
        
        .property-card .card-text {
            font-size: 12px !important;
        }
    }
    
    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .property-card .badge {
        font-size: 12px;
        padding: 5px 8px;
    }
    
    .property-card .badge small {
        font-size: 10px;
        opacity: 0.8;
    }
    
    /* Timeline styles for activities */
    .timeline {
        position: relative;
        padding-left: 50px;
        overflow: hidden;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #127664, #e0e0e0);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }
    
    .timeline-icon {
        position: absolute;
        left: -30px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 3px solid #e0e0e0;
        z-index: 1;
    }
    
    .timeline-icon.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        border-color: #28a745;
        color: white !important;
    }
    
    .timeline-icon.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        border-color: #ffc107;
        color: white !important;
    }
    
    .timeline-icon.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        border-color: #17a2b8;
        color: white !important;
    }
    
    .timeline-icon.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border-color: #dc3545;
        color: white !important;
    }
    
    .timeline-icon.bg-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);
        border-color: #6c757d;
        color: white !important;
    }
    
    .timeline-content {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }
    
    .timeline-content:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
        border-color: #127664;
    }
    
    .timeline-content h6 {
        color: #127664 !important;
        font-weight: 600;
    }
    
    .timeline-content p {
        color: #495057 !important;
    }
    
    .timeline-content small {
        color: #6c757d !important;
    }
    
    .timeline-icon i {
        font-size: 14px;
        color: white !important;
    }
    
    .activities-content .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        background: white;
    }
    
    .activities-content .card-header {
        background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%);
        color: white !important;
        border: none;
        border-radius: 10px 10px 0 0;
        padding: 15px 20px;
    }
    
    .activities-content .card-header h5 {
        color: white !important;
        margin: 0;
    }
    
    .activities-content .card-header * {
        color: white !important;
    }
    
    .activities-content .card-body {
        background: white;
        color: #333;
    }
    
    .activities-content .btn-group .btn {
        transition: all 0.3s ease;
        color: #127664;
        border-color: #127664;
        background: white;
    }
    
    .activities-content .btn-group .btn:hover {
        background: #f0f0f0;
    }
    
    .activities-content .btn-group .btn.active {
        background: #127664;
        color: white !important;
        border-color: #127664;
    }
    
    .activities-content h3 {
        color: #333 !important;
    }
    
    /* Profile tab styles */
    .profile-content .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }
    
    .profile-content .card-header {
        border: none;
        font-weight: 600;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%) !important;
        color: white !important;
    }
    
    .bg-gradient-primary * {
        color: white !important;
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
        color: white !important;
    }
    
    .bg-gradient-info * {
        color: white !important;
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
        color: white !important;
    }
    
    .bg-gradient-success * {
        color: white !important;
    }
    
    .profile-content .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 5px;
    }
    
    .profile-content .form-control:focus {
        border-color: #127664;
        box-shadow: 0 0 0 0.2rem rgba(18, 118, 100, 0.25);
    }
    
    /* أنماط فلاتر الحجوزات */
    #bookings-tab .card-header {
        background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%) !important;
        border: none;
        color: white !important;
    }
    
    #bookings-tab .card-header * {
        color: white !important;
    }
    
    @media (max-width: 768px) {
        #bookings-tab .card-header {
            padding: 12px !important;
        }
        
        #bookings-tab .card-header h5 {
            font-size: 16px !important;
        }
    }
    
    #bookings-tab .form-label {
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }
    
    #bookings-tab .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #127664;
    }
    
    #bookings-tab .btn-group .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    #bookings-tab .btn-primary {
        background-color: #127664;
        border-color: #127664;
        color: white !important;
    }
    
    #bookings-tab .btn-primary:hover {
        background-color: #0d5a4d;
        border-color: #0d5a4d;
        color: white !important;
    }
    
    /* Responsive Tables for Mobile */
    @media (max-width: 576px) {
        /* Convert tables to cards on very small screens */
        .table-responsive {
            border: none !important;
        }
        
        .table {
            display: block !important;
        }
        
        .table thead {
            display: none !important;
        }
        
        .table tbody {
            display: block !important;
        }
        
        .table tr {
            display: block !important;
            margin-bottom: 10px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 8px !important;
            padding: 10px !important;
            background: white !important;
        }
        
        .table td {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 8px 0 !important;
            border: none !important;
            border-bottom: 1px solid #f0f0f0 !important;
        }
        
        .table td:last-child {
            border-bottom: none !important;
        }
        
        .table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #6c757d;
            font-size: 12px;
        }
        
        /* Booking Status Colors */
        .badge-pending {
            background: #ffc107 !important;
            color: #fff !important;
        }
        
        .badge-confirmed {
            background: #28a745 !important;
            color: #fff !important;
        }
        
        .badge-cancelled {
            background: #dc3545 !important;
            color: #fff !important;
        }
    }
    
    /* تحسين مظهر pagination */
    #bookings-pagination .pagination {
        margin-bottom: 0;
    }
    
    #bookings-pagination .page-link {
        color: #fff;
        background-color: #127664;
        border-color: #127664;
        margin: 0 2px;
        border-radius: 4px;
    }
    
    #bookings-pagination .page-item.active .page-link {
        background-color: #0d5a4d;
        border-color: #0d5a4d;
        color: #fff;
        font-weight: bold;
    }
    
    #bookings-pagination .page-link:hover {
        color: #fff;
        background-color: #0d5a4d;
        border-color: #0d5a4d;
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    #bookings-pagination .page-item.disabled .page-link {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #fff;
        opacity: 0.5;
    }
    
    /* تحسين الجدول */
    #bookings-tab .table-responsive {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 0;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    #bookings-tab .table {
        margin-bottom: 0;
    }
    
    #bookings-tab .table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #343a40;
        white-space: nowrap;
    }
    
    /* شريط التمرير المخصص */
    #bookings-tab .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    
    #bookings-tab .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    #bookings-tab .table-responsive::-webkit-scrollbar-thumb {
        background: #127664;
        border-radius: 4px;
    }
    
    #bookings-tab .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #0d5a4d;
    }
    
    /* Additional Color Fixes for All Colored Backgrounds */
    .bg-primary, .bg-success, .bg-danger, .bg-warning, .bg-info, .bg-dark, .bg-secondary {
        color: white !important;
    }
    
    .bg-primary *, .bg-success *, .bg-danger *, .bg-warning *, .bg-info *, .bg-dark *, .bg-secondary * {
        color: white !important;
    }
    
    /* Stat Cards with colored backgrounds */
    .stat-card.bg-primary, .stat-card.bg-success, .stat-card.bg-info, .stat-card.bg-warning {
        color: white !important;
    }
    
    .stat-card.bg-primary *, .stat-card.bg-success *, .stat-card.bg-info *, .stat-card.bg-warning * {
        color: white !important;
    }
    
    /* Buttons with primary color */
    .btn-primary {
        background-color: #127664 !important;
        border-color: #127664 !important;
        color: white !important;
    }
    
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
        background-color: #0d5a4d !important;
        border-color: #0d5a4d !important;
        color: white !important;
    }
    
    /* Nav tabs active state */
    .nav-tabs .nav-link.active {
        background-color: #127664 !important;
        border-color: #127664 !important;
        color: white !important;
    }
    
    /* Alert boxes with colored backgrounds */
    .alert-success, .alert-danger, .alert-warning, .alert-info {
        color: white !important;
    }
    
    .alert-success *, .alert-danger *, .alert-warning *, .alert-info * {
        color: white !important;
    }
    
    /* Badge colors */
    .badge-primary, .badge-success, .badge-danger, .badge-warning, .badge-info {
        color: white !important;
    }
    
    /* Progress bars */
    .progress-bar {
        color: white !important;
    }
    
    /* Notification badges */
    .notification-badge {
        background: #dc3545 !important;
        color: white !important;
    }
    
    /* Any element with gradient background */
    [class*="bg-gradient-"] {
        color: white !important;
    }
    
    [class*="bg-gradient-"] * {
        color: white !important;
    }
    
    /* Specific fixes for card headers */
    .card-header.bg-primary, .card-header.bg-success, .card-header.bg-info, .card-header.bg-warning, .card-header.bg-danger {
        color: white !important;
    }
    
    .card-header.bg-primary *, .card-header.bg-success *, .card-header.bg-info *, .card-header.bg-warning *, .card-header.bg-danger * {
        color: white !important;
    }
    
    /* Table headers with dark background */
    .table-dark, .table-dark > th, .table-dark > td {
        color: white !important;
    }
    
    thead.bg-dark th, thead.bg-primary th {
        color: white !important;
    }
    
    /* Fix for any remaining black text on colored backgrounds */
    .text-white {
        color: white !important;
    }
</style>
@endpush

@section('content')

<!-- Dashboard Page Section -->
<div class="dashboard-page" style="margin: -30px -24px; padding: 38px 80px;">
        <!-- Top Header -->
        <div class="dashboard-top-header">
            <div class="welcome-section">
                <h2 class="welcome-text">{{ __('back.welcome_back') }}, <span class="user-highlight">{{ auth()->user()->name ?? '' }}</span>!</h2>
                <p class="user-email">{{ auth()->user()->email ?? 'owner@example.com' }}</p>
            </div>
            <button onclick="openAddPropertyModal()" class="btn-add-property">
                <span>{{ __('back.add_property') }}</span>
                <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.7143 9.71429H10.2857V15.7857C10.2857 16.1078 10.1503 16.4166 9.90914 16.6443C9.66802 16.8721 9.34099 17 9 17C8.65901 17 8.33198 16.8721 8.09086 16.6443C7.84974 16.4166 7.71429 16.1078 7.71429 15.7857V9.71429H1.28571C0.944722 9.71429 0.617695 9.58635 0.376577 9.35863C0.135459 9.13091 0 8.82205 0 8.5C0 8.17795 0.135459 7.86909 0.376577 7.64137C0.617695 7.41365 0.944722 7.28572 1.28571 7.28572H7.71429V1.21429C7.71429 0.892237 7.84974 0.583378 8.09086 0.355656C8.33198 0.127933 8.65901 0 9 0C9.34099 0 9.66802 0.127933 9.90914 0.355656C10.1503 0.583378 10.2857 0.892237 10.2857 1.21429V7.28572H16.7143C17.0553 7.28572 17.3823 7.41365 17.6234 7.64137C17.8645 7.86909 18 8.17795 18 8.5C18 8.82205 17.8645 9.13091 17.6234 9.35863C17.3823 9.58635 17.0553 9.71429 16.7143 9.71429Z" fill="#F4F7FF"/>
                </svg>
            </button>
        </div>

        <div class="bg-white pt-3 px-4 pb-5 border-radius-20">
            <!-- Navigation Tabs -->
            <div class="dashboard-tabs">
                <button class="tab-item active" data-tab="home">{{ __('back.home') }}</button>
                <button class="tab-item" data-tab="profile">{{ __('back.profile') }}</button>
                <button class="tab-item" data-tab="properties">{{ __('back.properties') }}</button>
                <button class="tab-item" data-tab="activities">{{ __('back.activities') }}</button>
                <button class="tab-item" data-tab="bookings">{{ __('back.property_bookings') }}</button>
                <button class="tab-item" data-tab="expenses">{{ __('back.expenses') }}</button>
                <button class="tab-item" data-tab="reviews">{{ __('back.customer_reviews') }}</button>
                <button class="tab-item" data-tab="notifications">
                    {{ __('back.notifications') }}
                    @if($unread_notifications_count > 0)
                        <span class="badge bg-danger ms-2">{{ $unread_notifications_count }}</span>
                    @endif
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="tab-contents">
                <!-- Home Tab -->
                <div class="tab-pane active" id="home-tab">

            <!-- Orange Banner -->
            <div class="properties-banner">
                <div class="banner-content">
                    <div class="banner-icon">
                        <svg width="130" height="124" viewBox="0 0 108 121" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <!-- SVG Path content here -->
                        </svg>
                    </div>
                    <div class="banner-text">
                        <div class="d-flex align-items-center justify-content-between mb-2" style="border-bottom: 5px solid white;">
                            <h3 class="banner-title">كل العقارات</h3>
                            <p class="banner-number mb-0">{{ $chalets_count }}</p>
                        </div>
                        <p class="banner-subtitle">عدد العقارات المسجلة في النظام</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="statistics-cards-row">
                <div class="stat-card stat-card-green">
                    <div class="stat-content">
                        <h4 class="stat-title fw-medium">عدد مشاهدات الإعلانات</h4>
                        <p class="stat-value fw-bold">{{ number_format($total_views) }}</p>
                    </div>
                    <div class="stat-icon">
                        <svg width="48" height="41" viewBox="0 0 48 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M32.232 20.7391C32.232 25.292 28.5529 28.9711 24.0001 28.9711C19.4472 28.9711 15.7681 25.292 15.7681 20.7391C15.7681 16.1862 19.4472 12.5071 24.0001 12.5071C28.5529 12.5071 32.232 16.1862 32.232 20.7391Z" stroke="white" stroke-opacity="0.2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M24 39.7552C32.117 39.7552 39.6822 34.9723 44.9479 26.6944C47.0174 23.4521 47.0174 18.0025 44.9479 14.7603C39.6822 6.48229 32.117 1.69946 24 1.69946C15.883 1.69946 8.31783 6.48229 3.05212 14.7603C0.982626 18.0025 0.982626 23.4521 3.05212 26.6944C8.31783 34.9723 15.883 39.7552 24 39.7552Z" stroke="white" stroke-opacity="0.2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card stat-card-white border-green">
                    <div class="stat-content">
                        <h4 class="stat-title fw-semibold">{{ __('back.total_revenue') }}</h4>
                        <p class="stat-value stat-value-orange fw-bold">{{ number_format($total_revenue, 0) }} ر.ع</p>
                    </div>
                    <div>
                        <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M48 8C26.804 8 9.6 25.204 9.6 46.4C9.6 67.596 26.804 84.8 48 84.8C69.196 84.8 86.4 67.596 86.4 46.4C86.4 25.204 69.196 8 48 8Z" fill="#333333" fill-opacity="0.05"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card stat-card-white border-green">
                    <div class="stat-content">
                        <h4 class="stat-title fw-semibold">{{ __('back.total_visitors') }}</h4>
                        <p class="stat-value stat-value-orange fw-bold">{{ number_format($total_visitors) }}</p>
                    </div>
                    <div>
                        <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_24_442)">
                            <path d="M48 39.7552C32.117 39.7552 39.6822 34.9723 44.9479 26.6944C47.0174 23.4521 47.0174 18.0025 44.9479 14.7603C39.6822 6.48229 32.117 1.69946 24 1.69946C15.883 1.69946 8.31783 6.48229 3.05212 14.7603C0.982626 18.0025 0.982626 23.4521 3.05212 26.6944C8.31783 34.9723 15.883 39.7552 24 39.7552Z" fill="#333333" fill-opacity="0.05"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_24_442">
                            <rect width="96" height="96" fill="white"/>
                            </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>


            <!-- Bottom Section: Properties List and Chart -->
            <div class="dashboard-bottom-section">
                <!-- Chart Section -->
                <div class="chart-section">
                    <div class="chart-header mb-3">
                        <h4 class="chart-title">إحصائيات العام</h4>
                    </div>
                    <div class="chart-container" style="height: 350px;">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>

                <!-- Best Properties List -->
                <div class="best-properties cool-gray-color">
                    <div class="section-header">
                        <h3 class="section-title">أفضل العقارات</h3>
                        <a href="{{ route('owner.chalets.index') }}" class="view-all-link text-dark d-flex align-items-center gap-1">
                            <h6 class="mx-2 mb-0">كل العقارات</h6>
                            <span>
                                <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.54038 4.54038C0.286539 4.79422 0.286539 5.20578 0.54038 5.45962L4.67695 9.59619C4.93079 9.85003 5.34235 9.85003 5.59619 9.59619C5.85003 9.34235 5.85003 8.9308 5.59619 8.67696L1.91924 5L5.59619 1.32304C5.85003 1.0692 5.85003 0.657647 5.59619 0.403806C5.34235 0.149965 4.93079 0.149965 4.67695 0.403806L0.54038 4.54038ZM16 5V4.35L0.999999 4.35V5V5.65L16 5.65V5Z" fill="#333333"/>
                                </svg>
                            </span>
                        </a>
                    </div>

                    <div class="properties-list">
                        @if(isset($chalets) && $chalets->count() > 0)
                            @foreach($chalets as $chalet)
                            <!-- Property Item -->
                            <div class="property-item">
                                <div class="property-info">
                                    @php
                                        $image = $chalet->images->first() ? asset($chalet->images->first()->image) : asset('assets/images/real-estate-item-image.png');
                                    @endphp
                                    <img src="{{ $image }}" alt="Property" class="property-image">
                                    <div class="property-details">
                                        <h5 class="property-name">{{ $chalet->name }}</h5>
                                        <p class="property-location">{{ $chalet->address }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-5">
                                    <div>
                                        <h6 style="font-size: 14px;" class="m-0">{{ number_format($chalet->price) }} ر.ع</h6>
                                    </div>
                                    <div class="property-price">
                                        <span class="price-badge">{{ $chalet->views()->count() }} مشاهدة</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <!-- Default Property Items -->
                            <div class="property-item">
                                <div class="property-info">
                                    <img src="{{ asset('assets/images/real-estate-item-image.png') }}" alt="Property" class="property-image">
                                    <div class="property-details">
                                        <h5 class="property-name">إستراحة زهرة الأوركيد</h5>
                                        <p class="property-location">مصر, الساحل الشمالي</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-5">
                                    <div>
                                        <h6 style="font-size: 14px;" class="m-0">1570$</h6>
                                    </div>
                                    <div class="property-price">
                                        <span class="price-badge">200 مشاهدة</span>
                                    </div>
                                </div>
                            </div>

                            <div class="property-item">
                                <div class="property-info">
                                    <img src="{{ asset('assets/images/real-estate-item-image.png') }}" alt="Property" class="property-image">
                                    <div class="property-details">
                                        <h5 class="property-name">شاليه روسيلا</h5>
                                        <p class="property-location">السعودية, جدة</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-5">
                                    <div>
                                        <h6 style="font-size: 14px;" class="m-0">1570$</h6>
                                    </div>
                                    <div class="property-price">
                                        <span class="price-badge">200 مشاهدة</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
                </div>
                <!-- End Home Tab -->

                <!-- Profile Tab -->
                <div class="tab-pane" id="profile-tab">
                    <div class="profile-content p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3><i class="fas fa-user-circle me-2"></i>البيانات الشخصية</h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header bg-gradient-primary text-white">
                                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>معلومات الحساب</h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        
                                        <form id="profile-form" method="POST" action="{{ route('owner.profile.update') }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">الاسم الكامل</label>
                                                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">البريد الإلكتروني</label>
                                                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">رقم الهاتف</label>
                                                    <input type="text" class="form-control" name="phone" value="{{ auth()->user()->phone }}" placeholder="+968 XXXX XXXX">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">رقم الحساب</label>
                                                    <input type="text" class="form-control" name="account_number" value="{{ auth()->user()->account_number }}" readonly disabled>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">العنوان</label>
                                                <textarea class="form-control" name="address" rows="2" placeholder="العنوان التفصيلي">{{ auth()->user()->address }}</textarea>
                                            </div>
                                            
                                            <hr class="my-4">
                                            
                                            <h6 class="mb-3"><i class="fas fa-lock me-2"></i>تغيير كلمة المرور</h6>
                                            
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">كلمة المرور الحالية</label>
                                                    <input type="password" class="form-control" name="current_password">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">كلمة المرور الجديدة</label>
                                                    <input type="password" class="form-control" name="new_password">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">تأكيد كلمة المرور</label>
                                                    <input type="password" class="form-control" name="new_password_confirmation">
                                                </div>
                                            </div>
                                            
                                            <div class="alert alert-info" role="alert">
                                                <i class="fas fa-info-circle me-2"></i>
                                                اترك حقول كلمة المرور فارغة إذا كنت لا تريد تغييرها
                                            </div>
                                            
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-2"></i>حفظ التغييرات
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary ms-2">
                                                    <i class="fas fa-undo me-2"></i>إلغاء
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-gradient-info text-white">
                                        <h5 class="mb-0"><i class="fas fa-camera me-2"></i>الصورة الشخصية</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <img id="profile-preview"
                                                 src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=127664&color=fff&size=200' }}"
                                                 alt="Profile" 
                                                 class="rounded-circle"
                                                 style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #127664;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="profile-image" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-upload me-2"></i>اختر صورة جديدة
                                            </label>
                                            <input type="file" id="profile-image" name="image" form="profile-form" accept="image/*" style="display: none;" onchange="previewProfileImage(this)">
                                        </div>
                                        <small class="text-muted">يُنصح بصورة مربعة بحجم 200×200 بكسل</small>
                                    </div>
                                </div>
                                
                                <div class="card mt-3">
                                    <div class="card-header bg-gradient-success text-white">
                                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>إحصائياتك</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>عدد العقارات:</span>
                                            <span class="badge bg-primary">{{ \App\Models\Chalet::where('owner_id', auth()->id())->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>إجمالي الحجوزات:</span>
                                            <span class="badge bg-success">{{ \App\Models\Booking::whereHas('chalet', function($q) { $q->where('owner_id', auth()->id()); })->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>التقييمات:</span>
                                            <span class="badge bg-warning">{{ \App\Models\Review::whereHas('chalet', function($q) { $q->where('owner_id', auth()->id()); })->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>تاريخ الانضمام:</span>
                                            <span class="text-muted">{{ auth()->user()->created_at->format('Y-m-d') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Profile Tab -->

                <!-- Properties Tab -->
                <div class="tab-pane" id="properties-tab">
                    <div class="properties-content p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3>عقاراتي</h3>
                            <a href="{{ route('owner.chalets.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> إضافة عقار جديد
                            </a>
                        </div>
                        
                        <div class="row">
                            @php
                                $owner_chalets = \App\Models\Chalet::where('owner_id', auth()->id())
                                    ->with(['images', 'views', 'city', 'area', 'reviews'])
                                    ->latest()
                                    ->get();
                            @endphp
                            @forelse($owner_chalets as $chalet)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card property-card h-100">
                                    @php
                                        $mainImage = $chalet->main_image ? asset($chalet->main_image) : 
                                                    ($chalet->images->first() ? asset($chalet->images->first()->image) : 
                                                    asset('assets/images/real-estate-item-image.png'));
                                    @endphp
                                    <div style="height: 200px; overflow: hidden; position: relative;">
                                        <img src="{{ $mainImage }}" class="card-img-top" alt="{{ $chalet->name }}" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                        <span class="badge badge-{{ $chalet->status == 'approved' ? 'success' : ($chalet->status == 'pending' ? 'warning' : 'danger') }}" 
                                              style="position: absolute; top: 10px; left: 10px;">
                                            {{ $chalet->status == 'approved' ? 'نشط' : ($chalet->status == 'pending' ? 'قيد المراجعة' : 'معطل') }}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate" title="{{ $chalet->name }}">{{ $chalet->name }}</h5>
                                        <p class="card-text text-muted mb-2">
                                            <i class="fas fa-map-marker-alt text-danger"></i> 
                                            <small>{{ $chalet->city ? $chalet->city->name : '' }}{{ $chalet->area ? ' - ' . $chalet->area->name : '' }}</small>
                                        </p>
                                        @if($chalet->location)
                                        <p class="card-text text-muted small mb-2">
                                            <i class="fas fa-location-arrow text-info"></i> {{ Str::limit($chalet->location, 30) }}
                                        </p>
                                        @endif
                                        
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">السعر اليومي:</small>
                                                <span class="text-primary font-weight-bold">{{ number_format($chalet->default_day_price) }} ر.ع</span>
                                            </div>
                                            @if($chalet->holiday_day_price)
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">سعر الإجازات:</small>
                                                <span class="text-warning font-weight-bold">{{ number_format($chalet->holiday_day_price) }} ر.ع</span>
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                @if($chalet->bedrooms)
                                                <span class="badge badge-light" title="غرف النوم">
                                                    <i class="fas fa-bed"></i> {{ $chalet->bedrooms }}
                                                </span>
                                                @endif
                                                @if($chalet->bathrooms)
                                                <span class="badge badge-light" title="دورات المياه">
                                                    <i class="fas fa-bath"></i> {{ $chalet->bathrooms }}
                                                </span>
                                                @endif
                                                @if($chalet->max_guests)
                                                <span class="badge badge-light" title="عدد الضيوف">
                                                    <i class="fas fa-users"></i> {{ $chalet->max_guests }}
                                                </span>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="badge badge-info me-1" title="عدد المشاهدات">
                                                    <i class="fas fa-eye"></i> {{ $chalet->views()->count() }}
                                                </span>
                                                @php
                                                    $reviewsCount = $chalet->reviews()->count();
                                                    $averageRating = $reviewsCount > 0 ? round($chalet->reviews()->avg('rating'), 1) : 0;
                                                    $ratingColor = $averageRating >= 4 ? 'success' : ($averageRating >= 3 ? 'warning' : 'danger');
                                                @endphp
                                                <span class="badge badge-{{ $reviewsCount > 0 ? $ratingColor : 'secondary' }}" title="{{ $reviewsCount }} {{ $reviewsCount == 1 ? 'تقييم' : 'تقييمات' }}">
                                                    <i class="fas fa-star"></i> 
                                                    @if($reviewsCount > 0)
                                                        {{ $averageRating }} <small>({{ $reviewsCount }})</small>
                                                    @else
                                                        <small>لا توجد تقييمات</small>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="btn-group btn-group-sm w-100" role="group">
                                            <button type="button" class="btn btn-outline-primary" onclick="openEditPropertyModal({{ $chalet->id }})" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-info" onclick="viewPropertyDetails({{ $chalet->id }})" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-success" onclick="openImagesGallery({{ $chalet->id }})" title="الصور">
                                                <i class="fas fa-images"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-warning" onclick="openPricingCalendar({{ $chalet->id }})" title="الأسعار">
                                                <i class="fas fa-dollar-sign"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" onclick="confirmDelete({{ $chalet->id }})" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle"></i> لا توجد عقارات مضافة حتى الآن
                                    <br>
                                    <button class="btn btn-primary mt-3" onclick="openAddPropertyModal()">
                                        إضافة أول عقار
                                    </button>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Activities Tab -->
                <div class="tab-pane" id="activities-tab">
                    <div class="activities-content p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3><i class="fas fa-chart-line mr-2"></i>النشاطات والإحصائيات</h3>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary active" onclick="filterActivities('all')">الكل</button>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="filterActivities('today')">اليوم</button>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="filterActivities('week')">هذا الأسبوع</button>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="filterActivities('month')">هذا الشهر</button>
                            </div>
                        </div>
                        
                        <!-- إحصائيات سريعة -->
                        @php
                            // حساب الإحصائيات الفعلية
                            $today = \Carbon\Carbon::today();
                            $owner_id = Auth::guard('owner')->user()->id;
                            
                            // حجوزات اليوم
                            $todayBookingsCount = \App\Models\Booking::whereHas('chalet', function($q) use($owner_id) {
                                $q->where('owner_id', $owner_id);
                            })->whereDate('created_at', $today)->count();
                            
                            // تقييمات هذا الأسبوع
                            $weekReviews = \App\Models\Review::whereHas('chalet', function($q) use($owner_id) {
                                $q->where('owner_id', $owner_id);
                            })->where('created_at', '>=', now()->subWeek())->count();
                            
                            // نسبة الإشغال (عدد الشاليهات المحجوزة اليوم / إجمالي الشاليهات)
                            $totalChalets = \App\Models\Chalet::where('owner_id', $owner_id)->count();
                            $today = now()->toDateString();
                            
                            // عدد الشاليهات المحجوزة اليوم (ليس عدد الحجوزات)
                            $occupiedChaletsToday = \App\Models\Chalet::where('owner_id', $owner_id)
                                ->whereHas('bookings', function($q) use($today) {
                                    $q->whereIn('status', ['confirmed', 'active'])
                                      ->whereDate('checkin_date', '<=', $today)
                                      ->whereDate('checkout_date', '>=', $today);
                                })
                                ->count();
                            
                            // حساب نسبة الإشغال بناءً على الشاليهات المحجوزة
                            $occupancyRate = $totalChalets > 0 ? round(($occupiedChaletsToday / $totalChalets) * 100) : 0;
                            
                            // إجمالي الزوار (عدد الشاليهات × متوسط تقديري)
            $totalViews = $totalChalets * 150; // رقم تقديري يمكنك تغييره
                        @endphp
                        
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <div class="card" style="background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%); border: none; box-shadow: 0 4px 15px rgba(18, 118, 100, 0.2);">
                                    <div class="card-body text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-1" style="font-size: 14px; opacity: 0.9;">
                                                    <i class="fas fa-eye me-1"></i> مشاهدات الكل
                                                </h6>
                                                <h3 class="mb-0" style="font-size: 28px; font-weight: 600;">{{ number_format($totalViews) }}</h3>
                                            </div>
                                            <div style="font-size: 32px; opacity: 0.3;">
                                                <i class="fas fa-eye"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border: none; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);">
                                    <div class="card-body text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-1" style="font-size: 14px; opacity: 0.9;">
                                                    <i class="fas fa-calendar-check me-1"></i> حجوزات اليوم
                                                </h6>
                                                <h3 class="mb-0" style="font-size: 28px; font-weight: 600;">{{ $todayBookingsCount }}</h3>
                                            </div>
                                            <div style="font-size: 32px; opacity: 0.3;">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border: none; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);">
                                    <div class="card-body text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-1" style="font-size: 14px; opacity: 0.9;">
                                                    <i class="fas fa-star me-1"></i> تقييمات الأسبوع
                                                </h6>
                                                <h3 class="mb-0" style="font-size: 28px; font-weight: 600;">{{ $weekReviews }}</h3>
                                            </div>
                                            <div style="font-size: 32px; opacity: 0.3;">
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.2);">
                                    <div class="card-body text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-1" style="font-size: 14px; opacity: 0.9;">
                                                    <i class="fas fa-chart-pie me-1"></i> نسبة الإشغال اليوم
                                                </h6>
                                                <h3 class="mb-0" style="font-size: 28px; font-weight: 600;">{{ $occupancyRate }}%</h3>
                                                <small class="text-white-50">{{ $occupiedChaletsToday }} من {{ $totalChalets }} شاليه</small>
                                            </div>
                                            <div style="font-size: 32px; opacity: 0.3;">
                                                <i class="fas fa-chart-pie"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- سجل النشاطات -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-history"></i> آخر النشاطات</h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    @php
                                        // جمع النشاطات من مصادر مختلفة
                                        $activities = collect();
                                        $owner_id = Auth::guard('owner')->user()->id;
                                        
                                        // إضافة الحجوزات الأخيرة
                                        $recentBookings = \App\Models\Booking::whereHas('chalet', function($q) use($owner_id) {
                                            $q->where('owner_id', $owner_id);
                                        })
                                        ->orderBy('created_at', 'desc')
                                        ->take(5)
                                        ->get()
                                        ->map(function($booking) {
                                            return [
                                                'type' => 'booking',
                                                'icon' => 'calendar-check',
                                                'color' => 'success',
                                                'title' => 'حجز جديد',
                                                'description' => 'حجز للشاليه ' . $booking->chalet->name . ' بواسطة ' . $booking->customer->name,
                                                'time' => $booking->created_at,
                                            ];
                                        });
                                        
                                        $activities = $activities->merge($recentBookings);
                                        
                                        // إضافة التقييمات الأخيرة
                                        $recentReviews = \App\Models\Review::whereHas('chalet', function($q) use($owner_id) {
                                            $q->where('owner_id', $owner_id);
                                        })
                                        ->orderBy('created_at', 'desc')
                                        ->take(5)
                                        ->get()
                                        ->map(function($review) {
                                            return [
                                                'type' => 'review',
                                                'icon' => 'star',
                                                'color' => 'warning',
                                                'title' => 'تقييم جديد',
                                                'description' => 'تقييم ' . $review->rating . ' نجوم للشاليه ' . $review->chalet->name,
                                                'time' => $review->created_at,
                                            ];
                                        });
                                        
                                        $activities = $activities->merge($recentReviews);
                                        
                                        // إضافة الرسائل/الاستفسارات الأخيرة (مؤقتاً معطل)
                                        // يمكن تفعيله لاحقاً إذا كانت العلاقة موجودة
                                        
                                        // إضافة الإشعارات الأخيرة من جدول notifications
                                        $recentNotifications = \App\Models\Notification::where('owner_id', $owner_id)
                                            ->whereNotIn('type', ['booking', 'review']) // تجنب التكرار
                                            ->orderBy('created_at', 'desc')
                                            ->take(5)
                                            ->get()
                                            ->map(function($notif) {
                                                $icon = 'bell';
                                                $color = 'secondary';
                                                
                                                switch($notif->type) {
                                                    case 'booking_cancelled':
                                                        $icon = 'calendar-times';
                                                        $color = 'danger';
                                                        break;
                                                    case 'booking_confirmed':
                                                        $icon = 'check-circle';
                                                        $color = 'success';
                                                        break;
                                                    case 'contact_message':
                                                        $icon = 'envelope';
                                                        $color = 'info';
                                                        break;
                                                }
                                                
                                                return [
                                                    'type' => $notif->type,
                                                    'icon' => $icon,
                                                    'color' => $color,
                                                    'title' => $notif->title_ar,
                                                    'description' => $notif->message_ar,
                                                    'time' => $notif->created_at,
                                                ];
                                            });
                                        
                                        $activities = $activities->merge($recentNotifications);
                                        
                                        // ترتيب حسب الوقت
                                        $activities = $activities->sortByDesc('time')->take(10);
                                    @endphp
                                    
                                    @forelse($activities as $activity)
                                        <div class="timeline-item">
                                            <div class="timeline-icon bg-{{ $activity['color'] }}">
                                                <i class="fas fa-{{ $activity['icon'] }} text-white"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                                <p class="mb-1 text-muted">{{ $activity['description'] }}</p>
                                                <small class="text-muted">
                                                    <i class="far fa-clock"></i> {{ $activity['time']->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">لا توجد نشاطات حتى الآن</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>


                <!-- Bookings Tab -->
                <div class="tab-pane" id="bookings-tab">
                    <div class="bookings-content p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3><i class="fas fa-calendar-check mr-2"></i>{{trans('back.booking_customers')}}</h3>
                        </div>
                        
                        <!-- فلاتر البحث المتقدمة -->
                        <div class="card shadow-sm mb-4" style="border-radius: 10px; border: none;">
                            <div class="card-header bg-gradient-primary text-white" style="border-radius: 10px 10px 0 0;">
                                <h6 class="mb-0"><i class="fas fa-filter mr-2"></i>فلاتر البحث والتصفية</h6>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-end">
                                    <!-- البحث بالنص -->
                                    <div class="col-lg-3 col-md-6 mb-3">
                                        <label class="form-label small text-muted">البحث بالنص</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="searchQuery" 
                                                   placeholder="رقم الحجز، اسم العميل، الهاتف...">
                                        </div>
                                    </div>
                                    
                                    <!-- فلتر الشاليه -->
                                    <div class="col-lg-3 col-md-6 mb-3">
                                        <label class="form-label small text-muted">العقار</label>
                                        <select class="form-control form-control-sm" id="chaletFilterSelect">
                                            <option value="0">جميع العقارات</option>
                                            @foreach(App\Models\Chalet::where('owner_id',auth()->user()->id)->get() as $chalet)
                                                <option value="{{ $chalet->id }}">
                                                    {{app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <!-- التاريخ من -->
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label class="form-label small text-muted">من تاريخ</label>
                                        <input type="date" id="startDate" class="form-control form-control-sm">
                                    </div>
                                    
                                    <!-- التاريخ إلى -->
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label class="form-label small text-muted">إلى تاريخ</label>
                                        <input type="date" id="endDate" class="form-control form-control-sm">
                                    </div>
                                    
                                    <!-- أزرار الإجراءات -->
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <div class="btn-group btn-group-sm w-100" role="group">
                                            <button class="btn btn-primary" onclick="applyFilters()" title="بحث">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button class="btn btn-success" onclick="refreshBookings()" title="تحديث">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                            <button class="btn btn-secondary" onclick="exportBookingsToExcel()" title="تصدير Excel">
                                                <i class="fas fa-file-excel"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- إحصائيات سريعة -->
                        <div class="row mb-3">
                            @php
                                $allBookings = \App\Models\Booking::whereHas('chalet', function($q) {
                                    $q->where('owner_id', auth()->id());
                                });
                                $totalBookings = $allBookings->count();
                                $confirmedBookings = (clone $allBookings)->where('status', 'confirmed')->count();
                                $pendingBookings = (clone $allBookings)->where('status', 'pending')->count();
                                $cancelledBookings = (clone $allBookings)->where('status', 'cancelled')->count();
                            @endphp
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body p-3">
                                        <h6>{{ __('back.total_bookings') }}</h6>
                                        <h4>{{ $totalBookings }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body p-3">
                                        <h6>حجوزات مؤكدة</h6>
                                        <h4>{{ $confirmedBookings }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body p-3">
                                        <h6>قيد الانتظار</h6>
                                        <h4>{{ $pendingBookings }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body p-3">
                                        <h6>حجوزات ملغية</h6>
                                        <h4>{{ $cancelledBookings }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- جدول الحجوزات -->
                        <div class="position-relative">
                            <div class="alert alert-info py-2 mb-2" style="font-size: 0.85rem;">
                                <i class="fas fa-arrows-alt-h mr-2"></i>
                                يمكنك التمرير أفقياً لعرض جميع البيانات
                            </div>
                            <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
                                <table class="table table-bordered table-striped text-center table-sm" style="min-width: 1500px;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="min-width: 40px;">#</th>
                                        <th style="min-width: 150px;">{{trans('back.chalet_name')}}</th>
                                        <th style="min-width: 100px;">{{trans('back.booking_number')}}</th>
                                        <th style="min-width: 120px;">{{trans('back.customer_name')}}</th>
                                        <th style="min-width: 100px;">{{trans('back.phone')}}</th>
                                        <th style="min-width: 120px;">{{trans('back.email')}}</th>
                                        <th style="min-width: 80px;">{{trans('back.days_number')}}</th>
                                        <th style="min-width: 150px;">{{trans('back.days')}}</th>
                                        <th style="min-width: 100px;">{{trans('back.payment_method')}}</th>
                                        <th style="min-width: 90px;">{{trans('back.Total_amount')}}</th>
                                        <th style="min-width: 90px;">{{trans('back.amount_paid')}}</th>
                                        <th style="min-width: 90px;">{{trans('back.rest_amount')}}</th>
                                        <th style="min-width: 100px;">{{trans('back.booking_status')}}</th>
                                        <th style="min-width: 100px;">{{trans('back.payment_status')}}</th>
                                        <th style="min-width: 200px;">{{trans('back.actions')}}</th>
                                        <th style="min-width: 100px;">{{trans('back.Created_at')}}</th>
                                    </tr>
                                </thead>
                                <tbody id="bookingsTableBody">
                                    @php
                                        $bookings = \App\Models\Booking::whereHas('chalet', function($q) {
                                            $q->where('owner_id', auth()->id());
                                        })->with(['chalet', 'dates', 'PaymentMethod'])->latest('id')->paginate(15);
                                    @endphp
                                    @forelse($bookings as $key => $booking)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            {{ app()->getLocale() == 'ar' ? $booking->chalet->chalet_name_ar : $booking->chalet->chalet_name_en }}
                                        </td>
                                        <td>{{$booking->booking_number}}</td>
                                        <td>{{ htmlspecialchars($booking->customer_name ?? '--', ENT_QUOTES, 'UTF-8') }}</td>
                                        <td>
                                            <a href="https://wa.me/{{$booking->country.$booking->phone_number}}" target="_blank">
                                                {{ $booking->country.$booking->phone_number ??'--' }}
                                            </a>
                                        </td>
                                        <td>{{ htmlspecialchars($booking->email ?? '--', ENT_QUOTES, 'UTF-8') }}</td>
                                        
                                        <td><span class="text-danger">{{ $booking->dates->count()}}</span> {{ $booking->booking_type }}</td>
                                        
                                        <td style="background-color: #e5f6f4">
                                            @foreach ($booking->dates as $date)
                                                <span class="badge badge-info" style='line-height: 17px; margin: 2px;'>
                                                    {{ $date->date}}
                                                </span>
                                            @endforeach
                                        </td>
                                        
                                        <td>
                                            @if($booking->PaymentMethod)
                                                {{ app()->getLocale() == 'ar' ? $booking->PaymentMethod->name_ar : $booking->PaymentMethod->name_en }}
                                            @else
                                                @if($booking->payment_method == 'cash')
                                                    {{ trans('back.cash') }}
                                                @elseif($booking->payment_method == 'card')
                                                    {{ trans('back.credit_card') }}
                                                @elseif($booking->payment_method == 'bank_transfer')
                                                    {{ trans('back.bank_transfer') }}
                                                @else
                                                    {{ $booking->payment_method ?? '--' }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $booking->total_amount }}</td>
                                        <td>{{ $booking->payment_amount }}</td>
                                        <td>{{ $booking->total_amount - $booking->payment_amount }}</td>
                                        <td>
                                            @if($booking->status)
                                                <span class="badge badge-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : ($booking->status == 'cancelled' ? 'danger' : 'info')) }}">
                                                    {{ trans("back.$booking->status") }}
                                                </span>
                                                
                                                <!-- أزرار تحويل الحالة -->
                                                <div class="btn-group btn-group-xs mt-1" role="group">
                                                    @if($booking->status != 'confirmed')
                                                        <button onclick="changeBookingStatus('{{ $booking->booking_number }}', 'confirmed')" 
                                                                class="btn btn-success btn-xs" title="تأكيد">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif
                                                    
                                                    @if($booking->status != 'pending')
                                                        <button onclick="changeBookingStatus('{{ $booking->booking_number }}', 'pending')" 
                                                                class="btn btn-warning btn-xs" title="معلق">
                                                            <i class="fas fa-clock"></i>
                                                        </button>
                                                    @endif
                                                    
                                                    @if($booking->status != 'cancelled')
                                                        <button onclick="changeBookingStatus('{{ $booking->booking_number }}', 'cancelled')" 
                                                                class="btn btn-danger btn-xs" title="إلغاء">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $booking->payment_status == 'paid' ? 'success' : 'danger' }}">
                                                {{ trans("back.$booking->payment_status") }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{route('owner.bookings.show', $booking->slug)}}" target="_blank" class="btn btn-sm btn-info" title="طباعة">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                
                                                {{-- زر تأكيد الدفع للدفع النقدي والتحويل البنكي --}}
                                                @if($booking->payment_status != 'paid' && in_array($booking->payment_method, ['cash', 'bank_transfer']))
                                                    <button class="btn btn-sm btn-success" onclick="confirmPayment('{{ $booking->booking_number }}', event)" title="تأكيد الدفع">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                @endif
                                                
                                                @if (!$booking->cancellation_status)
                                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#cancel_booking{{ $booking->booking_number }}" title="إلغاء">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                @endif
                                                
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_booking{{ $booking->booking_number }}" title="حذف">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            
                                            @if ($booking->cancellation_status)
                                                <span class="badge badge-danger mt-1">
                                                    {{ $booking->cancellation_status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{$booking->created_at}}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="14" class="text-center">
                                            <div class="alert alert-info mb-0">
                                                <i class="fas fa-info-circle"></i> لا توجد حجوزات حالياً
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3" id="bookings-pagination">
                            {{ $bookings->links() }}
                        </div>
                        
                        <!-- المودالات للحذف والإلغاء -->
                        @foreach($bookings as $booking)
                            <!-- Modal حذف الحجز -->
                            <div class="modal fade" id="delete_booking{{ $booking->booking_number }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('back.confirm_delete') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ __('back.are_you_sure_delete') }} <strong>{{ $booking->booking_number }}</strong>؟</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('back.cancel') }}</button>
                                            <form action="{{ route('owner.bookings.destroy', $booking->booking_number) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">{{ __('back.delete') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modal إلغاء الحجز -->
                            <div class="modal fade" id="cancel_booking{{ $booking->booking_number }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('back.cancel_booking') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('owner.bookings.cancel', $booking->booking_number) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>{{ __('back.are_you_sure_cancel') }} <strong>{{ $booking->booking_number }}</strong>؟</p>
                                                <div class="form-group">
                                                    <label>{{ __('back.cancellation_notes') }}</label>
                                                    <textarea name="notes" class="form-control" rows="3" placeholder="{{ __('back.enter_cancellation_reason') }}"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('back.close') }}</button>
                                                <button type="submit" class="btn btn-warning">{{ __('back.cancel_booking') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Expenses Tab -->
                <div class="tab-pane" id="expenses-tab">
                    <div class="expenses-content p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3><i class="fas fa-money-bill-wave" style="color: #127664; margin-left: 8px;"></i>المصروفات والإيرادات</h3>
                            <div>
                                <button class="btn btn-primary" style="background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%); border: none; color: white !important;">
                                    <i class="fas fa-list" style="margin-left: 8px;"></i>عرض جميع المصروفات
                                </button>
                                <button class="btn btn-success" onclick="addNewExpense()" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; color: white !important;">
                                    <i class="fas fa-plus" style="margin-left: 8px;"></i>إضافة مصروف
                                </button>
                            </div>
                        </div>
                        
                        @php
                            $owner = auth()->user();
                            $bookings = \App\Models\Booking::whereHas('chalet', function($q) {
                                $q->where('owner_id', auth()->id());
                            })->where('status', 'confirmed');
                            
                            $totalAmount = $bookings->sum('total_amount');
                            $totalCommission = $bookings->sum('service_fee');
                            $totalExpenses = $owner->expenses->sum('amount');
                            $netAmount = ($totalAmount - $totalCommission) - $totalExpenses;
                        @endphp
                        
                        <!-- بطاقات الإحصائيات -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card" style="border: 2px solid #127664; border-radius: 15px; overflow: hidden;">
                                    <div class="card-body text-center" style="background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%); color: white;">
                                        <i class="fas fa-coins fa-2x mb-2" style="color: white !important;"></i>
                                        <h6 class="mb-1" style="color: white !important;">{{ __('back.total_revenue') }}</h6>
                                        <h4 class="mb-0" style="color: white !important;">{{ number_format($totalAmount) }} ر.ع</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card" style="border: 2px solid #ff6b35; border-radius: 15px; overflow: hidden;">
                                    <div class="card-body text-center" style="background: linear-gradient(135deg, #ff6b35 0%, #ff9800 100%); color: white;">
                                        <i class="fas fa-percentage fa-2x mb-2" style="color: white !important;"></i>
                                        <h6 class="mb-1" style="color: white !important;">العمولة</h6>
                                        <h4 class="mb-0" style="color: white !important;">{{ number_format($totalCommission) }} ر.ع</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card" style="border: 2px solid #dc3545; border-radius: 15px; overflow: hidden;">
                                    <div class="card-body text-center" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white;">
                                        <i class="fas fa-receipt fa-2x mb-2" style="color: white !important;"></i>
                                        <h6 class="mb-1" style="color: white !important;">{{ __('back.total_expenses') }}</h6>
                                        <h4 class="mb-0" style="color: white !important;">{{ number_format($totalExpenses) }} ر.ع</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card" style="border: 2px solid {{ $netAmount >= 0 ? '#28a745' : '#dc3545' }}; border-radius: 15px; overflow: hidden;">
                                    <div class="card-body text-center" style="background: linear-gradient(135deg, {{ $netAmount >= 0 ? '#28a745 0%, #20c997' : '#dc3545 0%, #c82333' }} 100%); color: white;">
                                        <i class="fas fa-wallet fa-2x mb-2" style="color: white !important;"></i>
                                        <h6 class="mb-1" style="color: white !important;">الصافي</h6>
                                        <h4 class="mb-0" style="color: white !important;">{{ number_format($netAmount) }} ر.ع</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- جدول الملخص المالي -->
                        <div class="card mb-4" style="border: 1px solid #127664; border-radius: 15px;">
                            <div class="card-header" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 2px solid #127664;">
                                <h5 class="mb-0" style="color: #127664;"><i class="fas fa-chart-line" style="margin-left: 8px;"></i>الملخص المالي</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th style="background: rgba(18, 118, 100, 0.1); color: #127664; width: 25%;">إجمالي مبالغ الحجوزات</th>
                                                <td style="font-weight: bold; color: #127664;">{{ number_format($totalAmount) }} ر.ع</td>
                                                <th style="background: rgba(18, 118, 100, 0.1); color: #127664; width: 25%;">إجمالي العمولة</th>
                                                <td style="font-weight: bold; color: #ff6b35;">{{ number_format($totalCommission) }} ر.ع</td>
                                            </tr>
                                            <tr>
                                                <th style="background: rgba(18, 118, 100, 0.1); color: #127664;">الإيرادات بعد العمولة</th>
                                                <td style="font-weight: bold; color: #28a745;">{{ number_format($totalAmount - $totalCommission) }} ر.ع</td>
                                                <th style="background: rgba(18, 118, 100, 0.1); color: #127664;">إجمالي المصروفات</th>
                                                <td style="font-weight: bold; color: #dc3545;">{{ number_format($totalExpenses) }} ر.ع</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2" style="background: rgba(255, 107, 53, 0.1); color: #ff6b35; text-align: center;">المبلغ المتبقي (الصافي)</th>
                                                <td colspan="2" style="font-weight: bold; font-size: 1.2em; text-align: center; color: {{ $netAmount >= 0 ? '#28a745' : '#dc3545' }};">
                                                    {{ number_format($netAmount) }} ر.ع
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- فلتر البحث -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background: #127664; color: white; border: none;">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="expenseSearch" placeholder="بحث في المصروفات..." style="border: 1px solid #127664;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" id="expenseStartDate" style="border: 1px solid #127664;">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" id="expenseEndDate" style="border: 1px solid #127664;">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-block" onclick="filterExpenses()" style="background: linear-gradient(135deg, #ff6b35 0%, #ff9800 100%); color: white; border: none;">
                                    <i class="fas fa-filter"></i> تصفية
                                </button>
                            </div>
                        </div>
                        
                        <!-- جدول المصروفات -->
                        <div class="card" style="border: 1px solid #127664; border-radius: 15px;">
                            <div class="card-header" style="background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%); color: white;">
                                <h5 class="mb-0" style="color: white !important;"><i class="fas fa-list" style="color: white !important; margin-left: 8px;"></i>قائمة المصروفات</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped mb-0">
                                        <thead style="background: rgba(18, 118, 100, 0.1);">
                                            <tr>
                                                <th style="color: #127664;">#</th>
                                                <th style="color: #127664;">المبلغ</th>
                                                <th style="color: #127664;">الوصف</th>
                                                <th style="color: #127664;">تاريخ المصروف</th>
                                                <th style="color: #127664;">المرفقات</th>
                                                <th style="color: #127664;">تاريخ الإضافة</th>
                                                <th style="color: #127664;">الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody id="expensesTableBody">
                                            @forelse($owner->expenses()->latest()->take(10)->get() as $key => $expense)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <span class="badge badge-danger" style="font-size: 14px; padding: 8px 12px;">
                                                        {{ number_format($expense->amount) }} ر.ع
                                                    </span>
                                                </td>
                                                <td>
                                                    <span style="color: #495057; font-weight: 500;">
                                                        {{ $expense->about ?? 'بدون وصف' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-calendar-alt" style="margin-left: 4px;"></i>
                                                        {{ $expense->expense_date }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($expense->image)
                                                        <a href="{{ asset($expense->image) }}" target="_blank" class="btn btn-sm" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none;">
                                                            <i class="fas fa-paperclip"></i> عرض
                                                        </a>
                                                    @else
                                                        <span class="text-muted">لا يوجد</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock" style="margin-left: 4px;"></i>
                                                        {{ $expense->created_at->format('Y-m-d H:i') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button onclick="editExpense({{ $expense->id }})" class="btn btn-warning" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button onclick="deleteExpense({{ $expense->id }})" class="btn btn-danger" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="alert alert-info mb-0" style="background: rgba(18, 118, 100, 0.1); border: 1px solid #127664; color: #127664;">
                                                        <i class="fas fa-info-circle" style="margin-left: 8px;"></i>لا توجد مصروفات مسجلة حتى الآن
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if($owner->expenses()->count() > 10)
                            <div class="card-footer text-center" style="background: rgba(18, 118, 100, 0.05);">
                                <a href="{{ route('owner.expenses.index') }}" class="btn" style="background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%); color: white; border: none;">
                                    <i class="fas fa-arrow-left mr-2"></i>عرض جميع المصروفات ({{ $owner->expenses()->count() }})
                                </a>
                            </div>
                            @endif
                        </div>
                        
                        <!-- رسم بياني للمصروفات -->
                        <div class="card mt-4" style="border: 1px solid #ff6b35; border-radius: 15px;">
                            <div class="card-header" style="background: linear-gradient(135deg, #ff6b35 0%, #ff9800 100%); color: white;">
                                <h5 class="mb-0"><i class="fas fa-chart-bar mr-2"></i>إحصائيات المصروفات الشهرية</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="expensesChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane" id="reviews-tab">
                    <div class="reviews-content p-4">
                        <h3 class="mb-4">تعليقات العملاء</h3>
                        @php
                            $reviews = \App\Models\Review::whereHas('chalet', function($q) {
                                $q->where('owner_id', auth()->id());
                            })->latest()->take(10)->get();
                        @endphp
                        @forelse($reviews as $review)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5>{{ $review->customer->name ?? 'عميل' }}</h5>
                                    <div class="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-1"><strong>الشاليه:</strong> {{ $review->chalet->name ?? '-' }}</p>
                                <p>{{ $review->comment }}</p>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-info">
                            لا توجد تعليقات حتى الآن
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Notifications Tab -->
                <div class="tab-pane" id="notifications-tab">
                    <div class="notifications-content p-4">
                        <div class="section-header mb-4 d-flex justify-content-between align-items-center">
                            <h3 class="section-title mb-0">الإشعارات</h3>
                            @if($unread_notifications_count > 0)
                                <div>
                                    <span class="badge bg-danger rounded-pill me-2">{{ $unread_notifications_count }} غير مقروء</span>
                                    <button class="btn btn-sm btn-outline-primary" onclick="markAllNotificationsAsRead()">
                                        <i class="fas fa-check-double"></i> تحديد الكل كمقروء
                                    </button>
                                </div>
                            @endif
                        </div>
                        
                        <div class="notifications-list">
                            @forelse($notifications as $notification)
                                @php
                                    $data = $notification->data;
                                @endphp
                                <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}" 
                                     data-id="{{ $notification->id }}"
                                     style="padding: 20px; border: 1px solid #e0e0e0; border-radius: 12px; margin-bottom: 15px; transition: all 0.3s ease; {{ !$notification->is_read ? 'background-color: #f0f8ff; border-color: #007bff;' : 'background-color: #fff;' }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-3">
                                                @if($notification->icon_type == 'success')
                                                    <div class="notification-icon bg-success text-white rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                @elseif($notification->icon_type == 'warning')
                                                    <div class="notification-icon bg-warning text-white rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-exclamation"></i>
                                                    </div>
                                                @elseif($notification->icon_type == 'error')
                                                    <div class="notification-icon bg-danger text-white rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-times"></i>
                                                    </div>
                                                @else
                                                    <div class="notification-icon bg-info text-white rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-info"></i>
                                                    </div>
                                                @endif
                                                <h5 class="mb-0 fw-bold">{{ $notification->title_ar }}</h5>
                                            </div>
                                            
                                            @if($notification->type == 'booking' && is_array($data) && count($data) > 0)
                                                <div class="notification-preview" style="font-size: 15px; color: #666;">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <i class="fas fa-hashtag text-primary"></i>
                                                            <strong>رقم الحجز:</strong> {{ $data['booking_number'] ?? '-' }}
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <i class="fas fa-home text-primary"></i>
                                                            <strong>الشاليه:</strong> {{ $data['chalet_name'] ?? '-' }}
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <i class="fas fa-user text-primary"></i>
                                                            <strong>العميل:</strong> {{ $data['customer_name'] ?? '-' }}
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <i class="fas fa-calendar text-primary"></i>
                                                            <strong>التاريخ:</strong> {{ $data['checkin_date'] ?? '-' }} إلى {{ $data['checkout_date'] ?? '-' }}
                                                        </div>
                                                        @if(isset($data['total_amount']))
                                                        <div class="col-md-12 mb-2">
                                                            <i class="fas fa-money-bill text-success"></i>
                                                            <strong>المبلغ:</strong> 
                                                            <span class="badge bg-success fs-6">{{ number_format($data['total_amount'], 0) }} ر.ع</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-muted mb-2">{{ $notification->message_ar ?? $notification->message_en ?? '' }}</p>
                                            @endif
                                            
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            @if(!$notification->is_read)
                                            <button class="btn btn-sm btn-outline-primary mark-as-read-notification" data-id="{{ $notification->id }}">
                                                <i class="fas fa-check-circle"></i> تحديد كمقروء
                                            </button>
                                            @endif
                                            <button class="btn btn-sm btn-outline-secondary view-notification-details" 
                                                    data-notification='@json($notification)'>
                                                <i class="fas fa-eye"></i> التفاصيل
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                                    <p class="text-muted fs-5">لا توجد إشعارات</p>
                                </div>
                            @endforelse
                        </div>
                        
                    </div>
                </div>
                
            </div>
            <!-- End Tab Contents -->
        </div>
</div>

<!-- Add Property Modal -->
<div class="modal fade" id="addPropertyModal" tabindex="-1" aria-labelledby="addPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="addPropertyModalLabel">
                    <i class="fas fa-home mr-2"></i> إضافة عقار جديد
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('owner.chalets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- معلومات أساسية -->
                    <div class="form-section">
                        <h4 class="form-section-title">المعلومات الأساسية</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم ( استراحات , شاليهات , مزارع / صالونات تجميل نسائية / قاعات أفراح / جلسات , مخيمات ) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="chalet_name_ar" placeholder="اسم العقار بالعربية" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>أختر القسم المناسب <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="category_id" required>
                                        <option selected disabled>{{ trans('back.select') }}</option>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رقم الهاتف للاتصال</label>
                                    <input type="text" class="form-control" name="phone" placeholder="+96891234567 أو 91234567" maxlength="20">
                                    <small class="text-muted">اختياري - مفتاح الدولة 968 فقط</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رقم الواتساب للتواصل <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="whatsapp_number" placeholder="+96891234567 أو 91234567" required maxlength="20">
                                    <small class="text-muted">إجباري - مفتاح الدولة 968 فقط</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>مبلغ التأمين (ر.ع)</label>
                                    <input type="number" step="0.01" min="0" class="form-control" name="insurance_amount" placeholder="اختياري - يظهر في صفحة العقار">
                                    <small class="text-muted">اختياري - مبلغ التأمين يدفع عند الوصول (قابل للاسترداد)</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>وقت تسجيل الدخول</label>
                                    <input type="time" class="form-control" name="check_in_time" value="14:00">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>وقت تسجيل الخروج</label>
                                    <input type="time" class="form-control" name="check_out_time" value="12:00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الموقع -->
                    <div class="form-section">
                        <h4 class="form-section-title">الموقع</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>المدينة <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="city_id" name="city_id" required>
                                        <option selected disabled>{{ trans('back.select') }}</option>
                                        @foreach(\App\Models\City::all() as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>المنطقة <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="area_id" name="area_id" required>
                                        <option selected disabled>{{ trans('back.select') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>أدخل رابط موقع العقار / Google Maps <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control" id="map_link" name="map_link" placeholder="https://maps.google.com/ أو رابط Apple Maps" required>
                                    <small class="text-muted">إجباري - عند الضغط على الرابط يفتح في تطبيق خرائط جوجل أو أبل ماب</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- التفاصيل والأسعار -->
                    <div class="form-section">
                        <h4 class="form-section-title">التفاصيل والأسعار</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>السعر الافتراضي لليوم <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="default_day_price" placeholder="السعر بالريال" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>سعر نصف اليوم <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="half_day_price" placeholder="السعر بالريال" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>سعر المبيت <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="stay_price" placeholder="السعر بالريال" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>سعر أيام الإجازات <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="holiday_day_price" placeholder="السعر بالريال" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>العقار مخصص</label>
                                    <select class="form-control" name="dedicated_to">
                                        <option value="everyone">الجميع</option>
                                        <option value="families">عوائل</option>
                                        <option value="singles">عزاب</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>عدد المجالس</label>
                                    <input type="number" class="form-control" name="councils_count" placeholder="مثال: 2" min="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>عدد الضيوف الأقصى</label>
                                    <input type="number" class="form-control" name="max_guests" placeholder="مثال: 10">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>عدد غرف النوم</label>
                                    <input type="number" class="form-control" name="bedrooms" placeholder="مثال: 3">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>عدد دورات المياه</label>
                                    <input type="number" class="form-control" name="bathrooms" placeholder="مثال: 2">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الصور والوسائط -->
                    <div class="form-section">
                        <h4 class="form-section-title">الصور والوسائط</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الصورة الرئيسية <span class="text-muted">(واحدة)</span></label>
                                    <input type="file" class="form-control" name="main_image" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif">
                                    <small class="text-muted">تظهر في واجهة العقار والبطاقة الرئيسية</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>صور إضافية للمعرض <span class="text-muted">(حتى 10 صور)</span></label>
                                    <input type="file" class="form-control" id="add_property_images" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" data-max="10">
                                    <small class="text-muted">اختر حتى 10 صور إضافية لعرضها في صفحة العقار (صورة رئيسية + 10 = 11 صورة كحد أقصى)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الميزات الخاصة (التاقات) -->
                    <div class="form-section">
                        <h4 class="form-section-title">الميزات الخاصة</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>حدد الميزات المتوفرة في العقار</label>
                                    <div class="tags-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 15px;">
                                        <label class="custom-checkbox" style="display: flex; align-items: center; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                                            <input type="checkbox" name="has_pool" value="1" style="margin-left: 10px;">
                                            <span style="display: flex; align-items: center;">
                                                <i class="fas fa-swimming-pool" style="margin-left: 8px; color: #127664;"></i>
                                                مسبح
                                            </span>
                                        </label>
                                        <label class="custom-checkbox" style="display: flex; align-items: center; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                                            <input type="checkbox" name="has_beachfront" value="1" style="margin-left: 10px;">
                                            <span style="display: flex; align-items: center;">
                                                <i class="fas fa-umbrella-beach" style="margin-left: 8px; color: #127664;"></i>
                                                على الشاطئ
                                            </span>
                                        </label>
                                        <label class="custom-checkbox" style="display: flex; align-items: center; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                                            <input type="checkbox" name="has_beach" value="1" style="margin-left: 10px;">
                                            <span style="display: flex; align-items: center;">
                                                <i class="fas fa-water" style="margin-left: 8px; color: #127664;"></i>
                                                شاطئ خاص
                                            </span>
                                        </label>
                                        <label class="custom-checkbox" style="display: flex; align-items: center; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                                            <input type="checkbox" name="has_garden" value="1" style="margin-left: 10px;">
                                            <span style="display: flex; align-items: center;">
                                                <i class="fas fa-tree" style="margin-left: 8px; color: #127664;"></i>
                                                حديقة
                                            </span>
                                        </label>
                                        <label class="custom-checkbox" style="display: flex; align-items: center; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                                            <input type="checkbox" name="has_mountain_view" value="1" style="margin-left: 10px;">
                                            <span style="display: flex; align-items: center;">
                                                <i class="fas fa-mountain" style="margin-left: 8px; color: #127664;"></i>
                                                إطلالة جبلية
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- المرافق والخدمات -->
                    <div class="form-section">
                        <h4 class="form-section-title">المرافق والخدمات</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>المرافق المتوفرة</label>
                                    <div class="amenities-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px;">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="amenities[]" value="wifi">
                                            <span>واي فاي</span>
                                        </label>
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="amenities[]" value="pool">
                                            <span>مسبح</span>
                                        </label>
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="amenities[]" value="parking">
                                            <span>موقف سيارات</span>
                                        </label>
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="amenities[]" value="ac">
                                            <span>تكييف</span>
                                        </label>
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="amenities[]" value="kitchen">
                                            <span>مطبخ مجهز</span>
                                        </label>
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="amenities[]" value="tv">
                                            <span>تلفزيون</span>
                                        </label>
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="amenities[]" value="garden">
                                            <span>حديقة</span>
                                        </label>
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="amenities[]" value="bbq">
                                            <span>منطقة شواء</span>
                                        </label>
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="amenities[]" value="playground">
                                            <span>منطقة ألعاب أطفال</span>
                                        </label>
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="amenities[]" value="security">
                                            <span>حراسة أمنية</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- أبرز المميزات ولمحة عن المكان -->
                    <div class="form-section">
                        <h4 class="form-section-title">أبرز المميزات ولمحة عن المكان</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>الوصف</label>
                                    <textarea class="form-control" name="long_description_ar" rows="6" placeholder="أبرز المميزات ولمحة عن المكان..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- شروط الحجز -->
                    <div class="form-section">
                        <h4 class="form-section-title">شروط الحجز</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>شروط الحجز</label>
                                    <textarea class="form-control" name="booking_terms_ar" rows="4" placeholder="شروط الحجز والإلغاء..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- مواقع التواصل الاجتماعي -->
                    <div class="form-section">
                        <h4 class="form-section-title">مواقع التواصل الاجتماعي</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رابط صفحة الانستجرام</label>
                                    <input type="url" class="form-control" name="instagram_url" placeholder="https://instagram.com/...">
                                    <small class="text-muted">اختياري - تظهر أيقونة الانستجرام في صفحة العقار عند الإضافة</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رابط صفحة التوك توك</label>
                                    <input type="url" class="form-control" name="tiktok_url" placeholder="https://tiktok.com/@...">
                                    <small class="text-muted">اختياري - تظهر أيقونة التوك توك في صفحة العقار عند الإضافة</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> إلغاء
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i> حفظ العقار
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Property Modal -->
<div class="modal fade" id="viewPropertyModal" tabindex="-1" aria-labelledby="viewPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #127664 0%, #ff6b35 100%);">
                <h5 class="modal-title text-white" id="viewPropertyModalLabel">
                    <i class="fas fa-eye mr-2"></i> تفاصيل العقار
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="viewPropertyContent">
                <!-- سيتم ملؤه بواسطة JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> إغلاق
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Images Gallery Modal -->
<div class="modal fade" id="imagesGalleryModal" tabindex="-1" aria-labelledby="imagesGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #28a745 0%, #ff9800 100%);">
                <h5 class="modal-title text-white" id="imagesGalleryModalLabel">
                    <i class="fas fa-images mr-2"></i> معرض الصور
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="imagesGalleryContent" class="row">
                    <!-- سيتم ملؤه بواسطة JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="uploadImagesBtn">
                    <i class="fas fa-upload mr-2"></i> رفع صور جديدة
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> إغلاق
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Pricing Calendar Modal -->
<div class="modal fade" id="pricingCalendarModal" tabindex="-1" aria-labelledby="pricingCalendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #ffc107 0%, #127664 100%);">
                <h5 class="modal-title text-white" id="pricingCalendarModalLabel">
                    <i class="fas fa-calendar-alt mr-2"></i> تقويم الأسعار
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="pricingCalendarContent">
                    <!-- سيتم ملؤه بواسطة JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning text-white">
                    <i class="fas fa-save mr-2"></i> حفظ التغييرات
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> إغلاق
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Upload Images Modal -->
<div class="modal fade" id="uploadImagesModal" tabindex="-1" aria-labelledby="uploadImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #28a745 0%, #127664 100%);">
                <h5 class="modal-title text-white" id="uploadImagesModalLabel">
                    <i class="fas fa-upload mr-2"></i> رفع صور جديدة
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadImagesForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="upload_chalet_id" name="chalet_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>اختر الصور <span class="text-muted">(حتى 10 صور في كل رفع)</span></label>
                        <input type="file" class="form-control" id="upload_modal_images" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" data-max="10" required>
                        <small class="text-muted">يمكنك اختيار حتى 10 صور دفعة واحدة. الصورة الرئيسية من بيانات العقار + هذه الصور للمعرض.</small>
                    </div>
                    <div id="imagePreview" class="row mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> إلغاء
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload mr-2"></i> رفع الصور
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteConfirmModalLabel">
                    <i class="fas fa-exclamation-triangle mr-2"></i> تأكيد الحذف
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-trash-alt fa-5x text-danger mb-3"></i>
                <h4>هل أنت متأكد من حذف هذا العقار؟</h4>
                <p class="text-muted">لا يمكن التراجع عن هذا الإجراء</p>
                <input type="hidden" id="deletePropertyId">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" onclick="deleteProperty()">
                    <i class="fas fa-trash mr-2"></i> نعم، احذف
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> إلغاء
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Property Modal -->
<div class="modal fade" id="editPropertyModal" tabindex="-1" aria-labelledby="editPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="editPropertyModalLabel">
                    <i class="fas fa-edit mr-2"></i> تعديل العقار
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPropertyForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_chalet_id" name="chalet_id">
                <div class="modal-body">
                    <!-- نفس الحقول الموجودة في مودال الإضافة ولكن مع إضافة edit_ قبل كل id -->
                    <!-- معلومات أساسية -->
                    <div class="form-section">
                        <h4 class="form-section-title">المعلومات الأساسية</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم ( استراحات , شاليهات , مزارع / صالونات تجميل نسائية / قاعات أفراح / جلسات , مخيمات ) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_chalet_name_ar" name="chalet_name_ar" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>أختر القسم المناسب <span class="text-danger">*</span></label>
                                    <select class="form-control select2-edit" id="edit_category_id" name="category_id" required>
                                        <option selected disabled>{{ trans('back.select') }}</option>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رقم الهاتف للاتصال</label>
                                    <input type="text" class="form-control" id="edit_phone" name="phone" placeholder="+96891234567 أو 91234567" maxlength="20">
                                    <small class="text-muted">اختياري - مفتاح الدولة 968 فقط</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رقم الواتساب للتواصل <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_whatsapp_number" name="whatsapp_number" placeholder="+96891234567 أو 91234567" required maxlength="20">
                                    <small class="text-muted">إجباري - مفتاح الدولة 968 فقط</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>مبلغ التأمين (ر.ع)</label>
                                    <input type="number" step="0.01" min="0" class="form-control" id="edit_insurance_amount" name="insurance_amount" placeholder="اختياري">
                                    <small class="text-muted">اختياري</small>
                                </div>
                            </div>
                            <input type="hidden" id="edit_chalet_name_en" name="chalet_name_en">
                            <input type="hidden" id="edit_slug" name="slug">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>وقت تسجيل الدخول</label>
                                    <input type="time" class="form-control" id="edit_check_in_time" name="check_in_time">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>وقت تسجيل الخروج</label>
                                    <input type="time" class="form-control" id="edit_check_out_time" name="check_out_time">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الموقع -->
                    <div class="form-section">
                        <h4 class="form-section-title">الموقع</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>المدينة <span class="text-danger">*</span></label>
                                    <select class="form-control select2-edit" id="edit_city_id" name="city_id" required>
                                        <option selected disabled>{{ trans('back.select') }}</option>
                                        @foreach(\App\Models\City::all() as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>المنطقة <span class="text-danger">*</span></label>
                                    <select class="form-control select2-edit" id="edit_area_id" name="area_id" required>
                                        <option selected disabled>{{ trans('back.select') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>أدخل رابط موقع العقار / Google Maps <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control" id="edit_map_link" name="map_link" placeholder="https://maps.google.com/ أو رابط Apple Maps" required>
                                    <small class="text-muted">إجباري - عند الضغط على الرابط يفتح في تطبيق خرائط جوجل أو أبل ماب</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- التفاصيل والأسعار -->
                    <div class="form-section">
                        <h4 class="form-section-title">التفاصيل والأسعار</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>السعر الافتراضي لليوم <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="edit_default_day_price" name="default_day_price" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>سعر نصف اليوم <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="edit_half_day_price" name="half_day_price" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>سعر المبيت <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="edit_stay_price" name="stay_price" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>سعر أيام الإجازات <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="edit_holiday_day_price" name="holiday_day_price" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>العقار مخصص</label>
                                    <select class="form-control" id="edit_dedicated_to" name="dedicated_to">
                                        <option value="everyone">الجميع</option>
                                        <option value="families">عوائل</option>
                                        <option value="singles">عزاب</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>عدد المجالس</label>
                                    <input type="number" class="form-control" id="edit_councils_count" name="councils_count" min="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>عدد الضيوف الأقصى</label>
                                    <input type="number" class="form-control" id="edit_max_guests" name="max_guests">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>عدد غرف النوم</label>
                                    <input type="number" class="form-control" id="edit_bedrooms" name="bedrooms">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>عدد دورات المياه</label>
                                    <input type="number" class="form-control" id="edit_bathrooms" name="bathrooms">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الصور والوسائط -->
                    <div class="form-section">
                        <h4 class="form-section-title">الصور والوسائط</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الصورة الرئيسية الحالية</label>
                                    <div id="edit_current_main_image"></div>
                                    <label class="mt-2">تغيير الصورة الرئيسية</label>
                                    <input type="file" class="form-control" name="main_image" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الصور الحالية</label>
                                    <div id="edit_current_images" class="mb-2"></div>
                                    <label>إضافة صور جديدة <span class="text-muted">(حتى 10 صور)</span></label>
                                    <input type="file" class="form-control" id="edit_property_images" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" data-max="10">
                                    <small class="text-muted">يمكنك إضافة حتى 10 صور إضافية مع الصور الحالية</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الميزات الخاصة (التاقات) -->
                    <div class="form-section">
                        <h4 class="form-section-title">الميزات الخاصة</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>حدد الميزات المتوفرة في العقار</label>
                                    <div class="tags-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 15px;">
                                        <label class="custom-checkbox" style="display: flex; align-items: center; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                                            <input type="checkbox" id="edit_has_pool" name="has_pool" value="1" style="margin-left: 10px;">
                                            <span style="display: flex; align-items: center;">
                                                <i class="fas fa-swimming-pool" style="margin-left: 8px; color: #127664;"></i>
                                                مسبح
                                            </span>
                                        </label>
                                        <label class="custom-checkbox" style="display: flex; align-items: center; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                                            <input type="checkbox" id="edit_has_beachfront" name="has_beachfront" value="1" style="margin-left: 10px;">
                                            <span style="display: flex; align-items: center;">
                                                <i class="fas fa-umbrella-beach" style="margin-left: 8px; color: #127664;"></i>
                                                على الشاطئ
                                            </span>
                                        </label>
                                        <label class="custom-checkbox" style="display: flex; align-items: center; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                                            <input type="checkbox" id="edit_has_beach" name="has_beach" value="1" style="margin-left: 10px;">
                                            <span style="display: flex; align-items: center;">
                                                <i class="fas fa-water" style="margin-left: 8px; color: #127664;"></i>
                                                شاطئ خاص
                                            </span>
                                        </label>
                                        <label class="custom-checkbox" style="display: flex; align-items: center; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                                            <input type="checkbox" id="edit_has_garden" name="has_garden" value="1" style="margin-left: 10px;">
                                            <span style="display: flex; align-items: center;">
                                                <i class="fas fa-tree" style="margin-left: 8px; color: #127664;"></i>
                                                حديقة
                                            </span>
                                        </label>
                                        <label class="custom-checkbox" style="display: flex; align-items: center; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                                            <input type="checkbox" id="edit_has_mountain_view" name="has_mountain_view" value="1" style="margin-left: 10px;">
                                            <span style="display: flex; align-items: center;">
                                                <i class="fas fa-mountain" style="margin-left: 8px; color: #127664;"></i>
                                                إطلالة جبلية
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- المرافق والخدمات -->
                    <div class="form-section">
                        <h4 class="form-section-title">المرافق والخدمات</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>المرافق المتوفرة</label>
                                    <div class="amenities-grid" id="edit_amenities_grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px;">
                                        <!-- سيتم ملؤها بواسطة JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- أبرز المميزات ولمحة عن المكان -->
                    <div class="form-section">
                        <h4 class="form-section-title">أبرز المميزات ولمحة عن المكان</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>الوصف</label>
                                    <textarea class="form-control" id="edit_long_description_ar" name="long_description_ar" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- شروط الحجز -->
                    <div class="form-section">
                        <h4 class="form-section-title">شروط الحجز</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>شروط الحجز</label>
                                    <textarea class="form-control" id="edit_booking_terms_ar" name="booking_terms_ar" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- مواقع التواصل الاجتماعي -->
                    <div class="form-section">
                        <h4 class="form-section-title">مواقع التواصل الاجتماعي</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رابط صفحة الانستجرام</label>
                                    <input type="url" class="form-control" id="edit_instagram_url" name="instagram_url" placeholder="https://instagram.com/...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رابط صفحة التوك توك</label>
                                    <input type="url" class="form-control" id="edit_tiktok_url" name="tiktok_url" placeholder="https://tiktok.com/@...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> إلغاء
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// دوال للانتقال المباشر للتابات (global)
window.showProfileTab = function() {
    // إزالة active من جميع التابات والمحتويات
    document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
    
    // تفعيل تاب البيانات الشخصية
    const profileTab = document.querySelector('[data-tab="profile"]');
    if (profileTab) {
        profileTab.classList.add('active');
    }
    const profilePane = document.getElementById('profile-tab');
    if (profilePane) {
        profilePane.classList.add('active');
    }
}

window.showPropertiesTab = function() {
    // إزالة active من جميع التابات والمحتويات
    document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
    
    // تفعيل تاب العقارات
    const propertiesTab = document.querySelector('[data-tab="properties"]');
    if (propertiesTab) {
        propertiesTab.classList.add('active');
    }
    const propertiesPane = document.getElementById('properties-tab');
    if (propertiesPane) {
        propertiesPane.classList.add('active');
    }
}

// دالة لمعاينة الصورة الشخصية (global)
window.previewProfileImage = function(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // تفعيل التابات
    const tabs = document.querySelectorAll('.tab-item');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    // استرجاع التاب المحفوظ من localStorage
    const savedTab = localStorage.getItem('ownerActiveTab');
    if (savedTab) {
        // إزالة active من جميع التابات والمحتويات
        tabs.forEach(t => t.classList.remove('active'));
        tabPanes.forEach(pane => pane.classList.remove('active'));
        
        // تفعيل التاب المحفوظ
        const savedTabElement = document.querySelector(`[data-tab="${savedTab}"]`);
        const savedPaneElement = document.getElementById(savedTab + '-tab');
        
        if (savedTabElement && savedPaneElement) {
            savedTabElement.classList.add('active');
            savedPaneElement.classList.add('active');
            
            // إذا كان تاب الحجوزات، ربط أحداث pagination
            if (savedTab === 'bookings') {
                bindPaginationEvents();
            }
        }
    }
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // الحصول على اسم التاب
            const targetTab = this.getAttribute('data-tab');
            
            // حفظ التاب النشط في localStorage
            localStorage.setItem('ownerActiveTab', targetTab);
            
            // إزالة active من جميع التابات والمحتويات
            tabs.forEach(t => t.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // إضافة active للتاب المضغوط ومحتواه
            this.classList.add('active');
            const targetPane = document.getElementById(targetTab + '-tab');
            if (targetPane) {
                targetPane.classList.add('active');
            }
            
            // إذا كان تاب الحجوزات، ربط أحداث pagination
            if (targetTab === 'bookings') {
                bindPaginationEvents();
            }
        });
    });
    
    // التحقق من وجود hash في URL للانتقال المباشر للتاب
    const hash = window.location.hash;
    if (hash === '#profile') {
        showProfileTab();
    } else if (hash === '#properties') {
        showPropertiesTab();
    } else if (hash === '#bookings') {
        // الانتقال لتاب الحجوزات
        document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
        const bookingsTab = document.querySelector('[data-tab="bookings"]');
        if (bookingsTab) bookingsTab.classList.add('active');
        const bookingsPane = document.getElementById('bookings-tab');
        if (bookingsPane) bookingsPane.classList.add('active');
        bindPaginationEvents();
    }
    
    // ربط أحداث pagination عند التحميل الأولي
    bindPaginationEvents();

    // إنشاء الرسم البياني
    const ctx = document.getElementById('dashboardChart');
    if (ctx) {
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                datasets: [{
                    label: 'الحجوزات',
                    data: {{ json_encode($monthly_bookings) }},
                    borderColor: '#127664',
                    backgroundColor: 'rgba(18, 118, 100, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'الإيرادات (ر.ع)',
                    data: {{ json_encode($monthly_revenue) }},
                    borderColor: '#FF8A65',
                    backgroundColor: 'rgba(255, 138, 101, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            font: {
                                family: 'ExpoArabic',
                                size: 14
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            family: 'ExpoArabic',
                            size: 14
                        },
                        bodyFont: {
                            family: 'ExpoArabic',
                            size: 13
                        },
                        rtl: true,
                        textDirection: 'rtl'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                family: 'ExpoArabic',
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'ExpoArabic',
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    }
});

// متغيرات عامة لحفظ حالة الفلاتر
let currentFilters = {};

// وظائف الحجوزات
function applyFilters() {
    const query = document.getElementById('searchQuery').value;
    const chaletId = document.getElementById('chaletFilterSelect').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    currentFilters = {
        query: query,
        chalet_id: chaletId,
        start_date: startDate,
        end_date: endDate
    };
    
    loadBookings(currentFilters);
}

function filterBookingsByChalet() {
    const chaletId = document.getElementById('chaletFilterSelect').value;
    currentFilters.chalet_id = chaletId;
    loadBookings(currentFilters);
}

function searchBookings() {
    applyFilters();
}

function refreshBookings() {
    // مسح الفلاتر
    document.getElementById('searchQuery').value = '';
    document.getElementById('chaletFilterSelect').value = '0';
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';
    currentFilters = {};
    loadBookings({});
}

function loadBookings(filters, page = 1) {
    const params = new URLSearchParams(filters);
    params.append('page', page);
    
    $.ajax({
        url: '{{ route("owner.search_booking_between_date") }}?' + params.toString(),
        type: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            // تحديث منطقة الجدول و pagination
            const $bookingsArea = $('#bookings-tab .table-responsive').parent();
            
            // استخراج الجدول و pagination من الاستجابة
            const $response = $(response);
            const $table = $response.find('table').parent();
            const $pagination = $response.filter('#bookings-pagination').length ? 
                              $response.filter('#bookings-pagination') : 
                              $response.find('#bookings-pagination');
            
            // تحديث الجدول
            $('#bookings-tab .table-responsive').replaceWith($table);
            
            // تحديث أو إضافة pagination
            if ($('#bookings-pagination').length) {
                if ($pagination.length) {
                    $('#bookings-pagination').replaceWith($pagination);
                } else {
                    $('#bookings-pagination').remove();
                }
            } else if ($pagination.length) {
                $('#bookings-tab .table-responsive').after($pagination);
            }
            
            // تحديث المودالات
            $('.modal[id^="delete_booking"], .modal[id^="cancel_booking"]').remove();
            $response.filter('.modal').appendTo('body');
            
            // إعادة ربط أحداث pagination
            bindPaginationEvents();
        },
        error: function(xhr, status, error) {
            console.error('Error loading bookings:', error);
            alert('حدث خطأ في تحميل البيانات');
        }
    });
}

// دالة لربط أحداث pagination
function bindPaginationEvents() {
    // إزالة الأحداث السابقة لتجنب التكرار
    $(document).off('click', '#bookings-tab .pagination a');
    
    // ربط حدث click لروابط pagination
    $(document).on('click', '#bookings-tab .pagination a', function(e) {
        e.preventDefault();
        
        const url = $(this).attr('href');
        if (url) {
            const urlParams = new URLSearchParams(url.split('?')[1]);
            const page = urlParams.get('page') || 1;
            
            // تحميل الصفحة المطلوبة مع الفلاتر الحالية
            loadBookings(currentFilters, page);
        }
    });
}

function exportBookingsToExcel() {
    const chaletId = document.getElementById('chaletFilterSelect').value;
    
    // إنشاء نموذج مؤقت للتصدير
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("owner.filter_booking_by_chalet_excel") }}';
    
    // إضافة CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);
    
    // إضافة chalet_id
    const chaletInput = document.createElement('input');
    chaletInput.type = 'hidden';
    chaletInput.name = 'chalet_id';
    chaletInput.value = chaletId;
    form.appendChild(chaletInput);
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// وظائف التنقل بين التابات
function openAddPropertyModal() {
    // أضف عقار صار له صفحة كاملة بالتصميم الجديد بدل المودال القديم
    window.location.href = '{{ route('owner.chalets.create') }}';
}

function showPropertiesTab() {
    // إزالة active من جميع التابات
    document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
    
    // تفعيل تاب العقارات
    const propertiesTab = document.querySelector('[data-tab="properties"]');
    if (propertiesTab) {
        propertiesTab.classList.add('active');
    }
    
    const propertiesPane = document.getElementById('properties-tab');
    if (propertiesPane) {
        propertiesPane.classList.add('active');
    }
}

// عرض تفاصيل العقار
function viewPropertyDetails(chaletId) {
    $.ajax({
        url: `/owner/chalets/${chaletId}/edit-json`,
        type: 'GET',
        success: function(data) {
            // عرض الصورة الرئيسية إن وجدت
            var imageSection = '';
            if (data.main_image) {
                imageSection = `
                    <div class="text-center mb-3">
                        <img src="/${data.main_image}" class="img-fluid rounded" style="max-height: 300px;">
                    </div>
                `;
            }
            
            // المرافق
            var amenitiesText = '-';
            if (data.amenities) {
                try {
                    var amenitiesArray = JSON.parse(data.amenities);
                    var amenitiesLabels = {
                        'wifi': 'واي فاي',
                        'pool': 'مسبح',
                        'parking': 'موقف سيارات',
                        'ac': 'تكييف',
                        'kitchen': 'مطبخ مجهز',
                        'tv': 'تلفزيون',
                        'garden': 'حديقة',
                        'bbq': 'منطقة شواء',
                        'playground': 'منطقة ألعاب أطفال',
                        'security': 'حراسة أمنية'
                    };
                    amenitiesText = amenitiesArray.map(a => amenitiesLabels[a] || a).join(', ');
                } catch(e) {}
            }
            
            var content = `
                <div class="property-details">
                    ${imageSection}
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 style="color: #127664;"><i class="fas fa-home mr-2"></i>معلومات العقار</h5>
                            <table class="table table-sm">
                                <tr><td><strong>الاسم:</strong></td><td>${data.chalet_name_ar || '-'}</td></tr>
                                <tr><td><strong>المدينة:</strong></td><td>${data.city ? data.city.name : '-'}</td></tr>
                                <tr><td><strong>المنطقة:</strong></td><td>${data.area ? data.area.name : '-'}</td></tr>
                                <tr><td><strong>رابط الموقع:</strong></td><td>${data.map_link ? '<a href="' + data.map_link + '" target="_blank" rel="noopener">فتح في الخرائط</a>' : '-'}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 style="color: #ff6b35;"><i class="fas fa-dollar-sign mr-2"></i>الأسعار</h5>
                            <table class="table table-sm">
                                <tr><td><strong>السعر اليومي:</strong></td><td>${data.default_day_price} ر.ع</td></tr>
                                <tr><td><strong>سعر نصف اليوم:</strong></td><td>${data.half_day_price} ر.ع</td></tr>
                                <tr><td><strong>سعر المبيت:</strong></td><td>${data.stay_price} ر.ع</td></tr>
                                <tr><td><strong>سعر الإجازات:</strong></td><td>${data.holiday_day_price} ر.ع</td></tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 style="color: #28a745;"><i class="fas fa-info-circle mr-2"></i>التفاصيل</h5>
                            <table class="table table-sm">
                                <tr><td><strong>العقار مخصص:</strong></td><td>${data.dedicated_to_label || (data.dedicated_to === 'families' ? 'عوائل' : data.dedicated_to === 'singles' ? 'عزاب' : 'الجميع')}</td></tr>
                                <tr><td><strong>عدد المجالس:</strong></td><td>${data.councils_count ?? '-'}</td></tr>
                                <tr><td><strong>عدد الضيوف:</strong></td><td>${data.max_guests || '-'}</td></tr>
                                <tr><td><strong>غرف النوم:</strong></td><td>${data.bedrooms || '-'}</td></tr>
                                <tr><td><strong>دورات المياه:</strong></td><td>${data.bathrooms || '-'}</td></tr>
                                <tr><td><strong>الحالة:</strong></td><td>${data.status == 'approved' ? 'نشط' : (data.status == 'pending' ? 'قيد المراجعة' : 'معطل')}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 style="color: #ffc107;"><i class="fas fa-clock mr-2"></i>الأوقات والتواصل</h5>
                            <table class="table table-sm">
                                <tr><td><strong>وقت الدخول:</strong></td><td>${data.check_in_time || '14:00'}</td></tr>
                                <tr><td><strong>وقت الخروج:</strong></td><td>${data.check_out_time || '12:00'}</td></tr>
                                <tr><td><strong>رقم الهاتف:</strong></td><td>${data.phone || '-'}</td></tr>
                                <tr><td><strong>واتساب:</strong></td><td>${data.whatsapp_number || '-'}</td></tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 style="color: #17a2b8;"><i class="fas fa-list mr-2"></i>المرافق والخدمات</h5>
                            <p>${amenitiesText}</p>
                        </div>
                    </div>
                    
                    ${data.long_description_ar ? `
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 style="color: #127664;"><i class="fas fa-star mr-2"></i>أبرز المميزات ولمحة عن المكان</h5>
                            <p>${data.long_description_ar}</p>
                        </div>
                    </div>
                    ` : ''}
                    
                    ${data.booking_terms_ar ? `
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 style="color: #dc3545;"><i class="fas fa-exclamation-triangle mr-2"></i>شروط الحجز</h5>
                            <p>${data.booking_terms_ar}</p>
                        </div>
                    </div>
                    ` : ''}
                    ${data.instagram_url || data.tiktok_url ? `
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 style="color: #e4405f;"><i class="fas fa-share-alt mr-2"></i>مواقع التواصل الاجتماعي</h5>
                            <div class="d-flex gap-2 flex-wrap">
                                ${data.instagram_url ? `<a href="${data.instagram_url}" target="_blank" rel="noopener" class="btn btn-sm" style="background:#e4405f;color:white;"><i class="fab fa-instagram mr-1"></i> انستجرام</a>` : ''}
                                ${data.tiktok_url ? `<a href="${data.tiktok_url}" target="_blank" rel="noopener" class="btn btn-sm btn-dark"><i class="fab fa-tiktok mr-1"></i> توك توك</a>` : ''}
                            </div>
                        </div>
                    </div>
                    ` : ''}
                </div>
            `;
            $('#viewPropertyContent').html(content);
            $('#viewPropertyModal').modal('show');
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'حدث خطأ في تحميل بيانات العقار',
                confirmButtonColor: '#dc3545'
            });
        }
    });
}

// عرض معرض الصور
function openImagesGallery(chaletId) {
    // حفظ معرف العقار
    window.setCurrentChaletId(chaletId);
    
    // إظهار رسالة تحميل
    $('#imagesGalleryContent').html('<div class="col-12 text-center"><i class="fas fa-spinner fa-spin fa-3x"></i><p>جاري تحميل الصور...</p></div>');
    $('#imagesGalleryModal').modal('show');
    
    $.ajax({
        url: `/owner/chalets/${chaletId}/edit-json`,
        type: 'GET',
        success: function(data) {
            console.log('Gallery Data:', data); // للتشخيص
            console.log('Images:', data.images); // تشخيص الصور
            console.log('Main Image:', data.main_image); // تشخيص الصورة الرئيسية
            var content = '';
            
            // الصورة الرئيسية
            if (data.main_image) {
                content += `
                    <div class="col-md-12 mb-4 text-center">
                        <h5 style="color: #127664; margin-bottom: 15px;"><i class="fas fa-star mr-2"></i>الصورة الرئيسية</h5>
                        <div class="main-image-container" style="border: 3px solid #127664; border-radius: 10px; padding: 10px; display: inline-block;">
                            <img src="${data.main_image.startsWith('/') ? data.main_image : '/' + data.main_image}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 400px; max-width: 100%;"
                                 onerror="this.src='/assets/images/real-estate-item-image.png'">
                        </div>
                    </div>
                `;
            } else {
                content += `
                    <div class="col-md-12 mb-4 text-center">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>لا توجد صورة رئيسية
                        </div>
                    </div>
                `;
            }
            
            // الصور الإضافية
            if (data.images && data.images.length > 0) {
                content += '<div class="col-12 mb-3"><h5 style="color: #ff6b35;"><i class="fas fa-images mr-2"></i>الصور الإضافية (' + data.images.length + ')</h5></div>';
                data.images.forEach(function(image, index) {
                    // التحقق من اسم الحقل الصحيح (image_path أو image)
                    var imageField = image.image_path || image.image;
                    if (!imageField) {
                        console.error('Image field not found:', image);
                        return;
                    }
                    var imagePath = imageField.startsWith('/') ? imageField : '/' + imageField;
                    content += `
                        <div class="col-md-4 col-lg-3 mb-3" data-image-id="${image.id}">
                            <div class="position-relative image-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                <img src="${imagePath}" 
                                     class="img-fluid" 
                                     style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;"
                                     onclick="showFullImage('${imagePath}')"
                                     onerror="this.src='/assets/images/real-estate-item-image.png'"
                                     title="انقر للعرض بالحجم الكامل">
                                <div class="image-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); color: white; padding: 5px;">
                                    <small>صورة ${index + 1}</small>
                                    <button class="btn btn-sm btn-danger float-right" onclick="deleteImage(${image.id})" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else if (!data.main_image) {
                content += `
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>لا توجد صور لهذا العقار
                        </div>
                    </div>
                `;
            }
            
            // إضافة معلومات إضافية
            content += `
                <div class="col-12 mt-3">
                    <div class="alert alert-light">
                        <strong>معلومات العقار:</strong> ${data.chalet_name_ar || 'غير محدد'}
                        <br><small class="text-muted">إجمالي الصور: ${(data.images ? data.images.length : 0) + (data.main_image ? 1 : 0)}</small>
                    </div>
                </div>
            `;
            
            $('#imagesGalleryContent').html(content);
        },
        error: function(xhr) {
            console.error('Error loading images:', xhr);
            console.error('Status:', xhr.status);
            console.error('Response:', xhr.responseText);
            
            var errorMessage = 'حدث خطأ في تحميل الصور';
            if (xhr.status === 404) {
                errorMessage = 'العقار غير موجود';
            } else if (xhr.status === 500) {
                errorMessage = 'خطأ في الخادم';
            }
            
            $('#imagesGalleryContent').html(`
                <div class="col-12 text-center">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>${errorMessage}
                        <br><small class="text-muted">رمز الخطأ: ${xhr.status}</small>
                    </div>
                </div>
            `);
        }
    });
}

// عرض الصورة بالحجم الكامل
function showFullImage(imageSrc) {
    Swal.fire({
        imageUrl: imageSrc,
        imageAlt: 'صورة العقار',
        showConfirmButton: false,
        showCloseButton: true,
        width: 'auto'
    });
}

// حذف صورة (أثناء التعديل: تُضاف للحذف عند الحفظ فقط — خارج التعديل: حذف فوري)
function deleteImage(imageId) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: window.deleteImagesOnSave ? 'سيتم حذف الصورة عند الضغط على "حفظ التعديلات"' : 'سيتم حذف هذه الصورة نهائياً',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'نعم، احذف',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (!result.isConfirmed) return;
        if (window.deleteImagesOnSave) {
            window.imagesToDelete = window.imagesToDelete || [];
            if (window.imagesToDelete.indexOf(imageId) === -1) {
                window.imagesToDelete.push(imageId);
            }
            $('[data-image-id="' + imageId + '"]').fadeOut(200, function() { $(this).remove(); });
            Swal.fire({
                icon: 'info',
                title: 'تم التحديد',
                text: 'سيتم حذف الصورة عند الضغط على "حفظ التعديلات"',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }
        var deleteUrl = '{{ route("owner.chalets.images.destroy", ["image" => "__ID__"]) }}'.replace('__ID__', imageId);
        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response && response.success === false) {
                    Swal.fire({ icon: 'error', title: 'خطأ', text: response.message || 'حدث خطأ أثناء حذف الصورة', confirmButtonColor: '#dc3545' });
                    return;
                }
                Swal.fire({ icon: 'success', title: 'تم الحذف', text: 'تم حذف الصورة بنجاح', confirmButtonColor: '#28a745' });
                $('#imagesGalleryModal').modal('hide');
                setTimeout(function() { location.reload(); }, 1500);
            },
            error: function(xhr) {
                var msg = 'حدث خطأ أثناء حذف الصورة';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                Swal.fire({ icon: 'error', title: 'خطأ', text: msg, confirmButtonColor: '#dc3545' });
            }
        });
    });
}

// عرض تقويم الأسعار
function openPricingCalendar(chaletId) {
    // يمكن تحميل iframe أو محتوى تقويم الأسعار
    var content = `
        <div class="text-center p-4">
            <h4 style="color: #127664;">تقويم الأسعار للعقار</h4>
            <p>يمكنك إدارة الأسعار الخاصة للأيام المختلفة من هنا</p>
            <a href="/owner/chalets/${chaletId}/prices" class="btn btn-warning text-white" target="_blank">
                <i class="fas fa-external-link-alt mr-2"></i>فتح صفحة إدارة الأسعار
            </a>
        </div>
    `;
    $('#pricingCalendarContent').html(content);
    $('#pricingCalendarModal').modal('show');
}

// تأكيد الحذف
function confirmDelete(chaletId) {
    $('#deletePropertyId').val(chaletId);
    $('#deleteConfirmModal').modal('show');
}

// حذف العقار
function deleteProperty() {
    var chaletId = $('#deletePropertyId').val();
    
    $.ajax({
        url: `/owner/chalets/${chaletId}`,
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#deleteConfirmModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'تم الحذف',
                text: 'تم حذف العقار بنجاح',
                confirmButtonColor: '#28a745'
            }).then(() => {
                location.reload();
            });
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'حدث خطأ أثناء حذف العقار',
                confirmButtonColor: '#dc3545'
            });
        }
    });
}

// وظائف الحجوزات
function filterBookings() {
    var chaletId = $('#bookingChaletFilter').val();
    // يمكن إضافة AJAX هنا لتصفية الحجوزات حسب العقار
    console.log('Filter by chalet:', chaletId);
}

function filterBookingsByDate() {
    var startDate = $('#bookingStartDate').val();
    var endDate = $('#bookingEndDate').val();
    
    if (!startDate || !endDate) {
        Swal.fire({
            icon: 'warning',
            title: 'تنبيه',
            text: 'يرجى اختيار التاريخ من وإلى',
            confirmButtonColor: '#ffc107'
        });
        return;
    }
    
    // يمكن إضافة AJAX هنا لتصفية الحجوزات حسب التاريخ
    console.log('Filter by date:', startDate, endDate);
}

function exportBookingsExcel() {
    window.location.href = "{{ route('owner.filter_booking_by_chalet_excel') }}";
}

function confirmBooking(bookingId) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: 'سيتم تأكيد هذا الحجز',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'نعم، تأكيد',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/owner/bookings/${bookingId}/confirm`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التأكيد',
                        text: 'تم تأكيد الحجز بنجاح',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء تأكيد الحجز',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
}

function cancelBooking(bookingId) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: 'سيتم إلغاء هذا الحجز',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'نعم، إلغاء الحجز',
        cancelButtonText: 'تراجع'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/owner/bookings/${bookingId}/cancel`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الإلغاء',
                        text: 'تم إلغاء الحجز بنجاح',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء إلغاء الحجز',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
}

// وظائف المصروفات
function addNewExpense() {
    Swal.fire({
        title: 'إضافة مصروف جديد',
        html: `
            <div class="text-right">
                <div class="form-group">
                    <label>المبلغ <span class="text-danger">*</span></label>
                    <input type="number" id="expense_amount" class="form-control" placeholder="أدخل المبلغ">
                </div>
                <div class="form-group">
                    <label>الوصف <span class="text-danger">*</span></label>
                    <textarea id="expense_about" class="form-control" rows="3" placeholder="وصف المصروف"></textarea>
                </div>
                <div class="form-group">
                    <label>تاريخ المصروف <span class="text-danger">*</span></label>
                    <input type="date" id="expense_date" class="form-control" value="${new Date().toISOString().split('T')[0]}">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonColor: '#127664',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'حفظ',
        cancelButtonText: 'إلغاء',
        preConfirm: () => {
            const amount = document.getElementById('expense_amount').value;
            const about = document.getElementById('expense_about').value;
            const date = document.getElementById('expense_date').value;
            
            if (!amount || !about || !date) {
                Swal.showValidationMessage('يرجى ملء جميع الحقول المطلوبة');
                return false;
            }
            
            return { amount, about, date };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // إرسال البيانات عبر AJAX
            $.ajax({
                url: '{{ route("owner.expenses.store") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    amount: result.value.amount,
                    about: result.value.about,
                    expense_date: result.value.date
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الحفظ',
                        text: 'تم إضافة المصروف بنجاح',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: xhr.responseJSON?.message || 'حدث خطأ أثناء إضافة المصروف',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
}

function editExpense(expenseId) {
    // يمكن إضافة AJAX لجلب بيانات المصروف
    Swal.fire({
        title: 'تعديل المصروف',
        html: `
            <div class="text-right">
                <div class="form-group">
                    <label>المبلغ <span class="text-danger">*</span></label>
                    <input type="number" id="edit_expense_amount" class="form-control" placeholder="أدخل المبلغ">
                </div>
                <div class="form-group">
                    <label>الوصف <span class="text-danger">*</span></label>
                    <textarea id="edit_expense_about" class="form-control" rows="3" placeholder="وصف المصروف"></textarea>
                </div>
                <div class="form-group">
                    <label>تاريخ المصروف <span class="text-danger">*</span></label>
                    <input type="date" id="edit_expense_date" class="form-control">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonColor: '#ff6b35',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'تحديث',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            // هنا يمكن إضافة AJAX لتحديث المصروف
            console.log('Update expense:', expenseId);
            Swal.fire({
                icon: 'success',
                title: 'تم التحديث',
                text: 'تم تحديث المصروف بنجاح',
                confirmButtonColor: '#28a745'
            }).then(() => {
                location.reload();
            });
        }
    });
}

function deleteExpense(expenseId) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: 'سيتم حذف هذا المصروف نهائياً',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'نعم، احذف',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("owner.expenses.destroy", "") }}/' + expenseId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الحذف',
                        text: 'تم حذف المصروف بنجاح',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء حذف المصروف',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
}

function filterExpenses() {
    var search = $('#expenseSearch').val();
    var startDate = $('#expenseStartDate').val();
    var endDate = $('#expenseEndDate').val();
    
    console.log('Filter expenses:', { search, startDate, endDate });
    // يمكن إضافة AJAX هنا لتصفية المصروفات
}

// رسم بياني للمصروفات
$(document).ready(function() {
    // إعداد الرسم البياني للمصروفات إذا كان العنصر موجود
    if ($('#expensesChart').length) {
        var ctx = document.getElementById('expensesChart').getContext('2d');
        
        // بيانات وهمية للتجربة - يمكن استبدالها ببيانات حقيقية من قاعدة البيانات
        @php
            $monthlyExpenses = [];
            $currentYear = date('Y');
            for ($i = 1; $i <= 12; $i++) {
                $monthExpenses = $owner->expenses()
                    ->whereYear('expense_date', $currentYear)
                    ->whereMonth('expense_date', $i)
                    ->sum('amount');
                $monthlyExpenses[] = (float) $monthExpenses;
            }
        @endphp
        
        var expensesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                datasets: [{
                    label: 'المصروفات الشهرية',
                    data: {!! json_encode($monthlyExpenses) !!},
                    backgroundColor: 'rgba(255, 107, 53, 0.5)',
                    borderColor: '#ff6b35',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + ' ر.ع';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'المصروفات: ' + context.parsed.y + ' ر.ع';
                            }
                        }
                    }
                }
            }
        });
    }
});

// فتح مودال التعديل وتحميل بيانات العقار
function openEditPropertyModal(chaletId) {
    // إظهار رسالة تحميل
    Swal.fire({
        title: 'جاري التحميل...',
        text: 'يتم تحميل بيانات العقار',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
    
    // جلب بيانات العقار من الخادم
    $.ajax({
        url: `/owner/chalets/${chaletId}/edit-json`,
        type: 'GET',
        success: function(data) {
            // ملء النموذج بالبيانات
            $('#edit_chalet_id').val(data.id);
            $('#editPropertyForm').attr('action', `/owner/chalets/${data.id}`);
            
            // المعلومات الأساسية
            $('#edit_chalet_name_ar').val(data.chalet_name_ar);
            $('#edit_chalet_name_en').val(data.chalet_name_en);
            $('#edit_slug').val(data.slug);
            $('#edit_category_id').val(data.category_id).trigger('change');
            $('#edit_phone').val(data.phone);
            $('#edit_whatsapp_number').val(data.whatsapp_number);
            $('#edit_insurance_amount').val(data.insurance_amount ?? '');
            $('#edit_check_in_time').val(data.check_in_time);
            $('#edit_check_out_time').val(data.check_out_time);
            
            // الموقع
            $('#edit_city_id').val(data.city_id).trigger('change');
            
            // تحميل المناطق ثم اختيار المنطقة
            setTimeout(function() {
                loadEditAreas(data.city_id, data.area_id);
            }, 500);
            
            $('#edit_map_link').val(data.map_link);
            
            // التفاصيل والأسعار
            $('#edit_default_day_price').val(data.default_day_price);
            $('#edit_half_day_price').val(data.half_day_price);
            $('#edit_stay_price').val(data.stay_price);
            $('#edit_holiday_day_price').val(data.holiday_day_price);
            $('#edit_dedicated_to').val(data.dedicated_to || 'everyone');
            $('#edit_councils_count').val(data.councils_count);
            $('#edit_max_guests').val(data.max_guests);
            $('#edit_bedrooms').val(data.bedrooms);
            $('#edit_bathrooms').val(data.bathrooms);
            // لا نحتاج لتعيين حالة العقار - يحددها الأدمن
            
            // الميزات الخاصة (التاقات)
            $('#edit_has_pool').prop('checked', data.has_pool == 1);
            $('#edit_has_beachfront').prop('checked', data.has_beachfront == 1);
            $('#edit_has_beach').prop('checked', data.has_beach == 1);
            $('#edit_has_garden').prop('checked', data.has_garden == 1);
            $('#edit_has_mountain_view').prop('checked', data.has_mountain_view == 1);
            
            // الصور
            if (data.main_image) {
                $('#edit_current_main_image').html(`<img src="/${data.main_image}" class="img-thumbnail" style="max-width: 200px;">`);
            }
            
            if (data.images && data.images.length > 0) {
                var imagesHtml = '<div class="row">';
                data.images.forEach(function(image) {
                    var imgSrc = (image.image_path || image.image || '').startsWith('/') ? (image.image_path || image.image) : '/' + (image.image_path || image.image);
                    imagesHtml += `
                        <div class="col-md-3 mb-2" data-image-id="${image.id}">
                            <img src="${imgSrc}" class="img-thumbnail">
                            <button type="button" class="btn btn-sm btn-danger mt-1" onclick="deleteImage(${image.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                });
                imagesHtml += '</div>';
                $('#edit_current_images').html(imagesHtml);
            }
            
            
            // المرافق
            var amenitiesHtml = '';
            var amenitiesList = ['wifi', 'pool', 'parking', 'ac', 'kitchen', 'tv', 'garden', 'bbq', 'playground', 'security'];
            var amenitiesLabels = {
                'wifi': 'واي فاي',
                'pool': 'مسبح',
                'parking': 'موقف سيارات',
                'ac': 'تكييف',
                'kitchen': 'مطبخ مجهز',
                'tv': 'تلفزيون',
                'garden': 'حديقة',
                'bbq': 'منطقة شواء',
                'playground': 'منطقة ألعاب أطفال',
                'security': 'حراسة أمنية'
            };
            
            var selectedAmenities = data.amenities ? JSON.parse(data.amenities) : [];
            
            amenitiesList.forEach(function(amenity) {
                var checked = selectedAmenities.includes(amenity) ? 'checked' : '';
                amenitiesHtml += `
                    <label class="custom-checkbox">
                        <input type="checkbox" name="amenities[]" value="${amenity}" ${checked}>
                        <span>${amenitiesLabels[amenity]}</span>
                    </label>
                `;
            });
            $('#edit_amenities_grid').html(amenitiesHtml);
            
            $('#edit_long_description_ar').val(data.long_description_ar);
            $('#edit_booking_terms_ar').val(data.booking_terms_ar);
            $('#edit_instagram_url').val(data.instagram_url);
            $('#edit_tiktok_url').val(data.tiktok_url);
            
            // تهيئة قائمة الصور المعلقة للحذف (تُحذف عند الضغط على حفظ التعديلات فقط)
            window.imagesToDelete = [];
            window.deleteImagesOnSave = true;
            
            // إغلاق رسالة التحميل وفتح المودال
            Swal.close();
            $('#editPropertyModal').modal('show');
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'حدث خطأ في تحميل بيانات العقار',
                confirmButtonColor: '#dc3545'
            });
        }
    });
}

// تحميل المناطق للتعديل
function loadEditAreas(cityId, selectedAreaId) {
    $.ajax({
        url: "{{ URL::to('getareas') }}/" + cityId,
        type: "GET",
        dataType: "json",
        success: function(data) {
            $('#edit_area_id').empty();
            $('#edit_area_id').append('<option selected disabled>{{ trans('back.select') }}</option>');
            $.each(data, function(key, value) {
                var selected = key == selectedAreaId ? 'selected' : '';
                $('#edit_area_id').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
            });
        }
    });
}

// التعامل مع المدن والمناطق
$(document).ready(function() {
    // عند تغيير المدينة
    $('#city_id').on('change', function() {
        var city_id = $(this).val();
        if (city_id) {
            $.ajax({
                url: "{{ URL::to('getareas') }}/" + city_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#area_id').empty();
                    $('#area_id').append('<option selected disabled>{{ trans('back.select') }}</option>');
                    $.each(data, function(key, value) {
                        $('#area_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                },
                error: function() {
                    console.log('خطأ في تحميل المناطق');
                }
            });
        } else {
            $('#area_id').empty();
            $('#area_id').append('<option selected disabled>{{ trans('back.select') }}</option>');
        }
    });
    
    // تهيئة Select2 إذا كان متاح
    if ($.fn.select2) {
        $('.select2').select2({
            placeholder: "{{ trans('back.select') }}",
            allowClear: true,
            width: '100%'
        });
    }
    
    // معالجة حفظ النموذج
    $('#addPropertyModal form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var submitBtn = $(this).find('button[type="submit"]');
        
        // تعطيل زر الحفظ
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> جاري الحفظ...');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // إغلاق المودال
                $('#addPropertyModal').modal('hide');
                
                // إعادة تعيين النموذج
                $('#addPropertyModal form')[0].reset();
                
                // إظهار رسالة نجاح
                Swal.fire({
                    icon: 'success',
                    title: 'تم الحفظ بنجاح',
                    text: 'تم إضافة العقار بنجاح',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#127664'
                }).then(() => {
                    // الانتقال إلى تاب العقارات
                    showPropertiesTab();
                    // إعادة تحميل الصفحة لعرض العقار الجديد
                    location.reload();
                });
            },
            error: function(xhr) {
                // إعادة تفعيل زر الحفظ
                submitBtn.prop('disabled', false).html('<i class="fas fa-save mr-2"></i> حفظ العقار');
                
                // عرض رسالة خطأ
                var errors = xhr.responseJSON.errors;
                var errorMessage = 'حدث خطأ أثناء حفظ العقار';
                
                if (errors) {
                    errorMessage = '<ul class="text-start">';
                    $.each(errors, function(key, value) {
                        errorMessage += '<li>' + value[0] + '</li>';
                    });
                    errorMessage += '</ul>';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    html: errorMessage,
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });
    
    // إعادة تعيين النموذج عند إغلاق المودال
    $('#addPropertyModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('.select2').val(null).trigger('change');
    });
    
    // عند إغلاق مودال التعديل: إلغاء وضع "الحذف عند الحفظ فقط"
    $('#editPropertyModal').on('hidden.bs.modal', function () {
        window.deleteImagesOnSave = false;
        window.imagesToDelete = [];
    });
    
    // معالجة حفظ التعديلات
    $('#editPropertyForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var submitBtn = $(this).find('button[type="submit"]');
        var actionUrl = $(this).attr('action');
        
        // التأكد من وجود action URL
        if (!actionUrl) {
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'لم يتم تحديد العقار بشكل صحيح',
                confirmButtonColor: '#dc3545'
            });
            return;
        }
        
        // إضافة _method للـ PUT request
        formData.append('_method', 'PUT');
        
        // إضافة معرّفات الصور المعلقة للحذف (تُحذف عند الحفظ فقط)
        if (window.imagesToDelete && window.imagesToDelete.length > 0) {
            window.imagesToDelete.forEach(function(id) {
                formData.append('delete_images[]', id);
            });
        }
        
        // تعطيل زر الحفظ
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> جاري الحفظ...');
        
        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // إغلاق المودال
                $('#editPropertyModal').modal('hide');
                
                // إظهار رسالة نجاح
                Swal.fire({
                    icon: 'success',
                    title: 'تم التحديث بنجاح',
                    text: 'تم تحديث بيانات العقار بنجاح',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#127664'
                }).then(() => {
                    // إعادة تحميل الصفحة لعرض التغييرات
                    location.reload();
                });
            },
            error: function(xhr) {
                // إعادة تفعيل زر الحفظ
                submitBtn.prop('disabled', false).html('<i class="fas fa-save mr-2"></i> حفظ التعديلات');
                
                // طباعة الخطأ في console للتشخيص
                console.error('Error response:', xhr);
                console.error('Status:', xhr.status);
                console.error('Response Text:', xhr.responseText);
                
                // عرض رسالة خطأ
                var errorMessage = 'حدث خطأ أثناء حفظ التعديلات';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        errorMessage = '<ul class="text-start">';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorMessage += '<li>' + value[0] + '</li>';
                        });
                        errorMessage += '</ul>';
                    }
                } else if (xhr.status === 422) {
                    errorMessage = 'يرجى التحقق من البيانات المدخلة';
                } else if (xhr.status === 404) {
                    errorMessage = 'العقار غير موجود';
                } else if (xhr.status === 500) {
                    errorMessage = 'خطأ في الخادم، يرجى المحاولة لاحقاً';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    html: errorMessage,
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });
    
    // تهيئة Select2 للتعديل
    $('.select2-edit').select2({
        placeholder: "{{ trans('back.select') }}",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#editPropertyModal')
    });
    
    // معالجة تغيير المدينة في التعديل
    $('#edit_city_id').on('change', function() {
        var city_id = $(this).val();
        if (city_id) {
            loadEditAreas(city_id, null);
        }
    });
    
    
    // معالجة زر رفع الصور
    var currentChaletId = null;
    
    $('#uploadImagesBtn').on('click', function() {
        if (currentChaletId) {
            $('#upload_chalet_id').val(currentChaletId);
            $('#uploadImagesModal').modal('show');
        }
    });
    
    // الحد الأقصى 10 صور إضافية في فورم الإضافة
    $('#add_property_images').on('change', function() {
        var input = this;
        var max = parseInt($(input).data('max')) || 10;
        if (input.files.length > max) {
            Swal.fire({
                icon: 'warning',
                title: 'الحد الأقصى ' + max + ' صور',
                text: 'يرجى اختيار حتى ' + max + ' صور إضافية فقط. تم إلغاء الاختيار.',
                confirmButtonColor: '#127664'
            });
            $(input).val('');
            return;
        }
    });

    // الحد الأقصى 10 صور إضافية في فورم التعديل
    $('#edit_property_images').on('change', function() {
        var input = this;
        var max = parseInt($(input).data('max')) || 10;
        if (input.files.length > max) {
            Swal.fire({
                icon: 'warning',
                title: 'الحد الأقصى ' + max + ' صور',
                text: 'يرجى اختيار حتى ' + max + ' صور إضافية فقط. تم إلغاء الاختيار.',
                confirmButtonColor: '#127664'
            });
            $(input).val('');
            return;
        }
    });

    // الحد الأقصى 10 صور في مودال رفع الصور
    $(document).on('change', '#upload_modal_images', function() {
        var input = this;
        var max = parseInt($(input).data('max')) || 10;
        if (input.files.length > max) {
            Swal.fire({
                icon: 'warning',
                title: 'الحد الأقصى ' + max + ' صور',
                text: 'يرجى اختيار حتى ' + max + ' صور فقط. تم إلغاء الاختيار.',
                confirmButtonColor: '#127664'
            });
            $(input).val('');
            $('#imagePreview').empty();
            return;
        }
    });

    // معاينة الصور قبل الرفع
    $('input[name="images[]"]').on('change', function() {
        var files = this.files;
        var preview = $('#imagePreview');
        preview.empty();
        
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                preview.append(`
                    <div class="col-md-4 mb-2">
                        <img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                `);
            };
            
            reader.readAsDataURL(file);
        }
    });
    
    // رفع الصور
    $('#uploadImagesForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var submitBtn = $(this).find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> جاري الرفع...');
        
        $.ajax({
            url: `/owner/chalets/${currentChaletId}/images`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#uploadImagesModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'تم الرفع',
                    text: 'تم رفع الصور بنجاح',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    // إعادة تحميل معرض الصور
                    openImagesGallery(currentChaletId);
                });
            },
            error: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-upload mr-2"></i> رفع الصور');
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء رفع الصور',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });
    
    // حفظ معرف العقار الحالي
    window.setCurrentChaletId = function(id) {
        currentChaletId = id;
    };
    
    // ربط زر عرض التفاصيل
    $(document).on('click', '.view-details', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const btn = $(this);
        const notificationId = btn.data('id');
        const type = btn.data('type');
        const titleAr = btn.data('title-ar');
        const titleEn = btn.data('title-en');
        const messageAr = btn.data('message-ar');
        const messageEn = btn.data('message-en');
        const details = btn.data('details') || {};
        
        // Debug
        console.log('Notification Details:', {
            id: notificationId,
            type: type,
            details: details,
            detailsType: typeof details,
            detailsKeys: Object.keys(details)
        });
        
        const isArabic = '{{ app()->getLocale() }}' === 'ar';
        const title = isArabic ? titleAr : titleEn;
        const message = isArabic ? messageAr : messageEn;
        
        let detailsHtml = '';
        
        if (type === 'booking' && details && Object.keys(details).length > 0) {
            detailsHtml = `
                <div class="notification-details">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h5 class="mb-3"><i class="fas fa-bookmark me-2"></i>رقم الحجز: ${details.booking_number || 'غير محدد'}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-home text-primary me-2"></i>
                                <strong>الشاليه:</strong> ${details.chalet_name || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-user text-primary me-2"></i>
                                <strong>اسم العميل:</strong> ${details.customer_name || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-calendar-check text-success me-2"></i>
                                <strong>تاريخ الوصول:</strong> ${details.checkin_date || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-calendar-times text-danger me-2"></i>
                                <strong>تاريخ المغادرة:</strong> ${details.checkout_date || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                <strong>المبلغ الإجمالي:</strong> 
                                <span class="badge bg-success fs-6">${details.total_amount ? Number(details.total_amount).toLocaleString() + ' ر.ع' : 'غير محدد'}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-light">
                                <p class="mb-0"><strong>الرسالة الكاملة:</strong></p>
                                <p class="mt-2">${message}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <a href="/owner/bookings" class="btn btn-primary">
                                <i class="fas fa-list me-2"></i>عرض جميع الحجوزات
                            </a>
                        </div>
                    </div>
                </div>
            `;
        } else {
            detailsHtml = `
                <div class="notification-details">
                    <div class="alert alert-light">
                        <p>${message}</p>
                    </div>
                </div>
            `;
        }
        
        Swal.fire({
            title: `<strong>${title}</strong>`,
            html: detailsHtml,
            width: 700,
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                popup: 'notification-modal'
            }
        });
        
        // تحديد الإشعار كمقروء
        markNotificationAsRead(notificationId);
    });
    
    // دالة تحديد الإشعار كمقروء
    window.markNotificationAsRead = function(notificationId) {
        $.ajax({
            url: `/owner/notifications/${notificationId}/read`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // تحديث واجهة المستخدم
                $(`.notification-item[data-id="${notificationId}"]`).removeClass('unread').css('background-color', '#fff').css('border-color', '#e0e0e0');
                $(`.mark-as-read[data-id="${notificationId}"]`).remove();
                
                // تحديث عداد الإشعارات غير المقروءة
                let unreadCount = parseInt($('.badge.bg-danger').text()) || 0;
                if (unreadCount > 0) {
                    unreadCount--;
                    if (unreadCount > 0) {
                        $('.badge.bg-danger').text(unreadCount + ' غير مقروء');
                    } else {
                        $('.badge.bg-danger').remove();
                    }
                }
            }
        });
    };
    
    // ربط زر تحديد كمقروء
    $(document).on('click', '.mark-as-read', function(e) {
        e.stopPropagation();
        const notificationId = $(this).data('id');
        markNotificationAsRead(notificationId);
    });
    
    // ربط زر تحديد كمقروء في تاب الإشعارات
    $(document).on('click', '.mark-as-read-notification', function(e) {
        e.stopPropagation();
        const notificationId = $(this).data('id');
        markNotificationAsRead(notificationId);
    });
    
    // ربط زر عرض التفاصيل في تاب الإشعارات
    $(document).on('click', '.view-notification-details', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const notification = $(this).data('notification');
        showNotificationDetailsModal(notification);
    });
    
    // دالة عرض تفاصيل الإشعار في مودال
    window.showNotificationDetailsModal = function(notification) {
        const isArabic = '{{ app()->getLocale() }}' === 'ar';
        const title = isArabic ? notification.title_ar : notification.title_en;
        const message = isArabic ? notification.message_ar : notification.message_en;
        const data = notification.data || {};
        
        let detailsHtml = '';
        
        if (notification.type === 'booking' && Object.keys(data).length > 0) {
            detailsHtml = `
                <div class="notification-details">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h5 class="mb-3"><i class="fas fa-bookmark me-2"></i>رقم الحجز: ${data.booking_number || 'غير محدد'}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-home text-primary me-2"></i>
                                <strong>الشاليه:</strong> ${data.chalet_name || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-user text-primary me-2"></i>
                                <strong>اسم العميل:</strong> ${data.customer_name || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-calendar-check text-success me-2"></i>
                                <strong>تاريخ الوصول:</strong> ${data.checkin_date || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-calendar-times text-danger me-2"></i>
                                <strong>تاريخ المغادرة:</strong> ${data.checkout_date || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                <strong>المبلغ الإجمالي:</strong> 
                                <span class="badge bg-success fs-6">${data.total_amount ? Number(data.total_amount).toLocaleString() + ' ر.ع' : 'غير محدد'}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-light">
                                <p class="mb-0"><strong>الرسالة الكاملة:</strong></p>
                                <p class="mt-2">${message}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            detailsHtml = `
                <div class="notification-details">
                    <div class="alert alert-light">
                        <p>${message}</p>
                    </div>
                </div>
            `;
        }
        
        Swal.fire({
            title: `<strong>${title}</strong>`,
            html: detailsHtml,
            width: 700,
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                popup: 'notification-modal'
            }
        });
        
        // تحديد الإشعار كمقروء
        if (!notification.is_read) {
            markNotificationAsRead(notification.id);
        }
    };
    
    // دالة فلترة النشاطات
    window.filterActivities = function(period) {
        // تحديث الأزرار النشطة
        $('.activities-content .btn-group .btn').removeClass('active');
        $('.activities-content .btn-group .btn').each(function() {
            if ($(this).attr('onclick').includes(period)) {
                $(this).addClass('active');
            }
        });
        
        // يمكنك إضافة AJAX هنا لجلب النشاطات حسب الفترة
        // مؤقتاً سنغير العنوان فقط
        let title = '';
        switch(period) {
            case 'today':
                title = 'نشاطات اليوم';
                break;
            case 'week':
                title = 'نشاطات هذا الأسبوع';
                break;
            case 'month':
                title = 'نشاطات هذا الشهر';
                break;
            default:
                title = 'جميع النشاطات';
        }
        
        // يمكن إضافة تحديث المحتوى هنا
        console.log('تم اختيار فترة:', period);
    };
    
    // دالة تحديد كل الإشعارات كمقروءة
    window.markAllNotificationsAsRead = function() {
        if (!confirm('هل أنت متأكد من تحديد جميع الإشعارات كمقروءة؟')) return;
        
        $.ajax({
            url: '/owner/notifications/mark-all-read',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                location.reload();
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء تحديث الإشعارات'
                });
            }
        });
    };
});
</script>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Chart.js للرسوم البيانية -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Leaflet Maps (بديل مجاني لـ Google Maps) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
/* Custom Checkbox Styles */
.custom-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 8px 12px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.custom-checkbox:hover {
    background-color: #f8f9fa;
    border-color: #127664;
}

.custom-checkbox input[type="checkbox"] {
    margin-left: 8px;
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.custom-checkbox input[type="checkbox"]:checked {
    accent-color: #127664;
}

.custom-checkbox span {
    font-size: 14px;
    color: #495057;
}

/* Map Container */
#map {
    width: 100%;
    min-height: 400px;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    margin-top: 10px;
}

/* Form Section Improvements */
.form-section {
    margin-bottom: 25px;
}

.form-section-title {
    position: relative;
    padding-right: 30px;
}

.form-section-title:before {
    content: "";
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%);
    border-radius: 50%;
}
</style>
@endpush

@push('scripts')
<script>
// Fix Font Awesome Icons
document.addEventListener('DOMContentLoaded', function() {
    // Check if Font Awesome is loaded
    if (typeof window.FontAwesome === 'undefined') {
        // Load Font Awesome via JavaScript
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
        document.head.appendChild(link);
        
        // Also load Font Awesome Kit
        var script = document.createElement('script');
        script.src = 'https://kit.fontawesome.com/a076d05399.js';
        script.crossOrigin = 'anonymous';
        document.head.appendChild(script);
    }
    
    // Force reload icons after a delay
    setTimeout(function() {
        var icons = document.querySelectorAll('i[class*="fa-"]');
        icons.forEach(function(icon) {
            var classes = icon.className;
            icon.className = '';
            setTimeout(function() {
                icon.className = classes;
            }, 10);
        });
    }, 1000);
});


// دالة تحويل حالة الحجز
function changeBookingStatus(bookingNumber, newStatus) {
    // رسالة تأكيد
    let statusText = '';
    let statusColor = '';
    
    switch(newStatus) {
        case 'confirmed':
            statusText = 'هل أنت متأكد من تأكيد هذا الحجز؟';
            statusColor = '#28a745';
            break;
        case 'pending':
            statusText = 'هل أنت متأكد من تعليق هذا الحجز؟';
            statusColor = '#ffc107';
            break;
        case 'cancelled':
            statusText = 'هل أنت متأكد من إلغاء هذا الحجز؟';
            statusColor = '#dc3545';
            break;
    }
    
    Swal.fire({
        title: 'تحويل حالة الحجز',
        text: statusText,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: statusColor,
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'نعم، تحويل',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            // إرسال طلب AJAX
            $.ajax({
                url: '/owner/bookings/change-status/' + bookingNumber,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التحديث',
                        text: 'تم تحويل حالة الحجز بنجاح',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        // إعادة تحميل الجدول أو الصفحة
                        if (typeof applyFilters === 'function') {
                            applyFilters(); // إذا كانت هناك فلاتر مطبقة
                        } else {
                            location.reload(); // إعادة تحميل الصفحة
                        }
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: xhr.responseJSON?.message || 'حدث خطأ أثناء تحويل الحالة',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
}
// AGGRESSIVE FIX FOR FONT AWESOME ICONS
window.addEventListener('load', function() {
    console.log('Starting icon fix...');
    
    function fixOwnerIcons() {
        console.log('Fixing icons...');
        // Get all icon elements
        const icons = document.querySelectorAll('i[class*="fa-"], span[class*="fa-"]');
        
        icons.forEach(function(icon) {
            // Clean up classes
            let classes = icon.className.split(' ');
            let cleanClasses = [];
            let hasIcon = false;
            
            classes.forEach(function(cls) {
                // Skip duplicate style classes
                if (cls === 'fa' || cls === 'fa-solid') {
                    if (!cleanClasses.includes('fas')) {
                        cleanClasses.push('fas');
                    }
                } else if (cls === 'fa-regular') {
                    if (!cleanClasses.includes('far')) {
                        cleanClasses.push('far');
                    }
                } else if (cls === 'fa-brands') {
                    if (!cleanClasses.includes('fab')) {
                        cleanClasses.push('fab');
                    }
                } else if (cls.startsWith('fa-')) {
                    cleanClasses.push(cls);
                    hasIcon = true;
                } else if (cls && !cls.startsWith('fa')) {
                    cleanClasses.push(cls);
                }
            });
            
            // Apply cleaned classes
            if (hasIcon) {
                icon.className = cleanClasses.join(' ');
                
                // Force style
                icon.style.fontFamily = '"Font Awesome 6 Free", "Font Awesome 5 Free"';
                if (icon.classList.contains('far')) {
                    icon.style.fontWeight = '400';
                } else {
                    icon.style.fontWeight = '900';
                }
            }
        });
        
        // Fix specific problematic icons
        const iconMap = {
            'fa-check-circle': 'fa-circle-check',
            'fa-times-circle': 'fa-circle-xmark',
            'fa-info-circle': 'fa-circle-info',
            'fa-user-circle': 'fa-circle-user'
        };
        
        Object.keys(iconMap).forEach(function(oldClass) {
            document.querySelectorAll('.' + oldClass).forEach(function(el) {
                el.classList.remove(oldClass);
                el.classList.add(iconMap[oldClass]);
            });
        });
    }
    
    // Run immediately
    fixOwnerIcons();
    
    // Run after delays for dynamic content
    setTimeout(fixOwnerIcons, 500);
    setTimeout(fixOwnerIcons, 1000);
    setTimeout(fixOwnerIcons, 2000);
    
    // Watch for changes
    const observer = new MutationObserver(function() {
        fixOwnerIcons();
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});

// دالة تأكيد الدفع باستخدام AJAX
function confirmPayment(bookingNumber, evt) {
    // منع السلوك الافتراضي
    if (evt && evt.preventDefault) {
        evt.preventDefault();
    }
    
    // الحصول على الزر الذي تم النقر عليه
    const button = evt ? (evt.target.closest('button') || evt.currentTarget) : null;
    
    if (!button) {
        console.error('Button not found');
        showAlert('error', 'حدث خطأ: لم يتم العثور على الزر');
        return;
    }
    
    if (confirm('هل أنت متأكد من تأكيد الدفع لهذا الحجز؟')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        if (!csrfToken) {
            console.error('CSRF token not found');
            showAlert('error', 'حدث خطأ: لم يتم العثور على رمز الأمان');
            return;
        }
        
        // إظهار رسالة الانتظار
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        const url = '/owner/bookings/' + bookingNumber + '/confirm-payment';
        console.log('Sending request to:', url);
        console.log('CSRF Token:', csrfToken);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // عرض رسالة النجاح
                showAlert('success', data.message || 'تم تأكيد الدفع بنجاح وإرسال إشعار للعميل');
                
                // تحديث البيانات في الجدول
                const row = button.closest('tr');
                
                // تحديث المبلغ المدفوع (العمود 8) - يصبح مساوياً للمبلغ الإجمالي
                const paidAmountCell = row.querySelector('td:nth-child(8)');
                if (paidAmountCell && data.data) {
                    // عرض المبلغ المدفوع = المبلغ الإجمالي
                    paidAmountCell.textContent = data.data.total_amount || data.data.payment_amount;
                }
                
                // تحديث المبلغ الباقي (العمود 9) - يصبح صفر
                const restAmountCell = row.querySelector('td:nth-child(9)');
                if (restAmountCell) {
                    restAmountCell.textContent = '0';
                }
                
                // تحديث حالة الدفع (العمود 11)
                const paymentStatusCell = row.querySelector('td:nth-child(11)');
                if (paymentStatusCell) {
                    paymentStatusCell.innerHTML = '<span class="badge badge-success">مدفوع</span>';
                }
                
                // إخفاء زر تأكيد الدفع
                button.style.display = 'none';
            } else {
                showAlert('error', data.message || 'حدث خطأ أثناء تأكيد الدفع');
                button.innerHTML = originalContent;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            let errorMessage = 'حدث خطأ في الاتصال';
            if (error.message) {
                errorMessage += ': ' + error.message;
            }
            showAlert('error', errorMessage);
            button.innerHTML = originalContent;
            button.disabled = false;
        });
    }
}

// دالة عرض التنبيهات
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alertDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // إخفاء الرسالة بعد 5 ثواني
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>
@endpush
