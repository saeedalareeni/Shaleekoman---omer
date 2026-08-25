<head>
    <meta charset="utf-8" />
    <title>@yield('page_title', 'لوحة التحكم') - {{ $siteName ?? config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ $siteSettings->getSiteDescriptionAttribute() ?? '' }}" name="description" />
    <meta content="{{ $companyName ?? '' }}" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ $siteFavicon ?? asset('assets/images/shaleek_logo.png') }}">

    <!-- Dropify CSS -->
    <link href="{{ asset('backend/assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap and Icons CSS -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Bootstrap 5 CSS CDN Fallback -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Complete Icons Fix -->
    @include('layouts.icons-fix')
    

    <!-- Plugins CSS -->
    <link href="{{ asset('backend/assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/multiselect/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

    <!-- App CSS -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Modern Admin CSS -->
    <link href="{{ asset('backend/css/modern-admin.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @if (App::getLocale() == 'ar')
        <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
        <style>
            /* === قوة RTL الكاملة === */
            html[dir="rtl"], 
            html[dir="rtl"] body,
            html[dir="rtl"] * {
                direction: rtl !important;
                text-align: right !important;
            }
            
            /* الهيدر */
            html[dir="rtl"] .modern-header .header-wrapper {
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-between !important;
            }
            
            html[dir="rtl"] .modern-header .nav-menu {
                margin-left: auto !important;
                margin-right: 0 !important;
            }
            
            html[dir="rtl"] .modern-header .header-right {
                margin-right: auto !important;
                margin-left: 0 !important;
            }
            
            /* القوائم المنسدلة */
            html[dir="rtl"] .dropdown-modern {
                left: auto !important;
                right: 0 !important;
            }
            
            /* الإشعارات */
            html[dir="rtl"] .notification-dropdown {
                left: 0 !important;
                right: auto !important;
            }
            
            html[dir="rtl"] .notification-badge {
                right: auto !important;
                left: -8px !important;
            }
            
            /* قائمة المستخدم */
            html[dir="rtl"] .user-dropdown {
                left: 0 !important;
                right: auto !important;
            }
            
            html[dir="rtl"] .user-dropdown .dropdown-item {
                text-align: right !important;
            }
            
            html[dir="rtl"] .logout-btn {
                text-align: right !important;
            }
            
            /* تبديل الهوامش */
            html[dir="rtl"] .ml-1, html[dir="rtl"] .ms-1 { margin-right: 0.25rem !important; margin-left: 0 !important; }
            html[dir="rtl"] .ml-2, html[dir="rtl"] .ms-2 { margin-right: 0.5rem !important; margin-left: 0 !important; }
            html[dir="rtl"] .ml-3, html[dir="rtl"] .ms-3 { margin-right: 1rem !important; margin-left: 0 !important; }
            html[dir="rtl"] .mr-1, html[dir="rtl"] .me-1 { margin-left: 0.25rem !important; margin-right: 0 !important; }
            html[dir="rtl"] .mr-2, html[dir="rtl"] .me-2 { margin-left: 0.5rem !important; margin-right: 0 !important; }
            html[dir="rtl"] .mr-3, html[dir="rtl"] .me-3 { margin-left: 1rem !important; margin-right: 0 !important; }
            
            /* تبديل الحشوات */
            html[dir="rtl"] .pl-1, html[dir="rtl"] .ps-1 { padding-right: 0.25rem !important; padding-left: 0 !important; }
            html[dir="rtl"] .pl-2, html[dir="rtl"] .ps-2 { padding-right: 0.5rem !important; padding-left: 0 !important; }
            html[dir="rtl"] .pl-3, html[dir="rtl"] .ps-3 { padding-right: 1rem !important; padding-left: 0 !important; }
            html[dir="rtl"] .pr-1, html[dir="rtl"] .pe-1 { padding-left: 0.25rem !important; padding-right: 0 !important; }
            html[dir="rtl"] .pr-2, html[dir="rtl"] .pe-2 { padding-left: 0.5rem !important; padding-right: 0 !important; }
            html[dir="rtl"] .pr-3, html[dir="rtl"] .pe-3 { padding-left: 1rem !important; padding-right: 0 !important; }
            
            /* الجداول */
            html[dir="rtl"] table {
                direction: rtl !important;
            }
            
            html[dir="rtl"] th,
            html[dir="rtl"] td {
                text-align: right !important;
            }
            
            /* الفورمات */
            html[dir="rtl"] .form-control,
            html[dir="rtl"] .form-select,
            html[dir="rtl"] input,
            html[dir="rtl"] select,
            html[dir="rtl"] textarea {
                text-align: right !important;
                direction: rtl !important;
            }
            
            /* محتوى الصفحة */
            html[dir="rtl"] .content-page {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            
            /* Text alignment */
            html[dir="rtl"] .text-left {
                text-align: right !important;
            }
            
            html[dir="rtl"] .text-right {
                text-align: left !important;
            }
            
            /* Float fixes */
            html[dir="rtl"] .float-left {
                float: right !important;
            }
            
            html[dir="rtl"] .float-right {
                float: left !important;
            }
        </style>
    @else
        <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    @endif
    

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400&display=swap" rel="stylesheet">
    
    <!-- Custom CSS for centering content -->
    <style>
        /* Fix for overlapping issues and loader */
        body {
            position: relative;
            overflow-x: hidden;
        }
        
        /* Ensure loader has proper z-index and is removed properly */
        .loader-wrapper {
            position: fixed !important;
            z-index: 99999 !important;
            pointer-events: all !important;
        }
        
        .loader-wrapper.d-none,
        .loader-wrapper[style*="display: none"] {
            display: none !important;
            pointer-events: none !important;
            z-index: -1 !important;
        }
        
        /* Center all admin content */
        .content-page {
            margin-left: auto !important;
            margin-right: auto !important;
            margin-top: 70px !important;
            max-width: 100% !important;
            padding: 0 15px !important;
            position: relative;
            z-index: 1;
        }
        
        .content {
            padding: 20px 0 !important;
        }
        
        .container-fluid {
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 0 15px !important;
        }
        
        /* Remove any left margin from sidebar */
        body {
            padding-left: 0 !important;
        }
        
        #wrapper {
            margin-left: 0 !important;
        }
        
        /* Ensure header is full width */
        .modern-header {
            width: 100%;
            left: 0;
            right: 0;
        }
        
        /* Fix for RTL */
        [dir="rtl"] .content-page {
            margin-right: auto !important;
            margin-left: auto !important;
        }
        
        /* Increase height for all select elements in admin panel */
        select.form-control,
        .form-control[type="select"],
        .custom-select,
        select {
            min-height: calc(2.5em + .9rem + 2px) !important;
            height: auto !important;
            padding: 0.5rem 0.75rem !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
        }
        
        /* Special handling for Select2 */
        .select2-container .select2-selection--single {
            height: calc(2.5em + .9rem + 2px) !important;
            padding: 6px 12px !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: calc(2.5em + .9rem + 2px) !important;
            padding-top: 2px !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.5em + .9rem + 2px) !important;
        }
        
        /* Multi-select Select2 */
        .select2-container .select2-selection--multiple {
            min-height: calc(2.5em + .9rem + 2px) !important;
        }
        
        /* Bootstrap custom select */
        .custom-select-sm {
            height: calc(2.25em + .9rem + 2px) !important;
            font-size: 14px !important;
        }
        
        .custom-select-lg {
            height: calc(2.875em + .9rem + 2px) !important;
            font-size: 16px !important;
        }
        
        /* Ensure text is visible and centered */
        select.form-control option,
        .custom-select option {
            padding: 8px !important;
            line-height: 1.6 !important;
        }
        
        /* Statistics Cards Design for All Pages */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }
        
        .stats-card.primary { border-color: #007bff; }
        .stats-card.success { border-color: #28a745; }
        .stats-card.warning { border-color: #ffc107; }
        .stats-card.info { border-color: #17a2b8; }
        .stats-card.danger { border-color: #dc3545; }
        
        .stats-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .stats-number {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stats-label {
            font-size: 14px;
            color: #6c757d;
        }
        
        /* Beautiful Filter Box Design for All Pages */
        .filter-box {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }
        
        .filter-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2c8e3d 0%, #ff8c42 100%);
        }
        
        .filter-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .filter-box-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .filter-box-title i {
            color: #2c8e3d;
            font-size: 20px;
        }
        
        .filter-box-body {
            margin-bottom: 20px;
        }
        
        .filter-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: end;
        }
        
        .filter-col {
            flex: 1;
            min-width: 200px;
        }
        
        .filter-col label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #495057;
        }
        
        .filter-col label i {
            color: #6c757d;
            margin-right: 5px;
            font-size: 12px;
        }
        
        .filter-box .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s;
            background: white;
        }
        
        .filter-box .form-control:focus {
            border-color: #2c8e3d;
            box-shadow: 0 0 0 0.2rem rgba(44, 142, 61, 0.1);
            background: white;
        }
        
        .filter-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        
        .filter-actions .btn {
            padding: 8px 20px;
            font-size: 14px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .filter-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .filter-actions .btn i {
            font-size: 14px;
        }
        
        /* Dropdown for export */
        .filter-actions .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border: none;
            padding: 5px;
        }
        
        .filter-actions .dropdown-item {
            border-radius: 5px;
            padding: 8px 15px;
            transition: all 0.2s;
        }
        
        .filter-actions .dropdown-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }
        
        /* Results counter */
        .filter-results {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .filter-box {
                padding: 20px 15px;
            }
            
            .filter-col {
                min-width: 100%;
            }
            
            .filter-box-header {
                flex-direction: column;
                align-items: start;
                gap: 10px;
            }
            
            .filter-actions {
                justify-content: stretch;
            }
            
            .filter-actions .btn {
                flex: 1;
                justify-content: center;
            }
        }
    </style>

    <!-- Custom CSS -->
    <link href="{{ asset('backend/custom.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />

    <!-- jQuery UI CSS and JS for Signature -->
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <style>
        .kbw-signature { width: 100%; height: 200px; }
        #sig canvas {
            width: 100% !important;
            height: auto;
        }
        canvas {
            width: 100%;
        }
        .cke_notifications_area {
            pointer-events: none;
            display: none;
        }
        @yield('css')
    </style>

    @livewireStyles
    <!-- Emergency overlay cleanup -->
    <script>
        // تنظيف فوري بدون انتظار jQuery
        document.addEventListener('DOMContentLoaded', function() {
            // إزالة كل العناصر التي قد تحجب الصفحة
            var overlays = document.querySelectorAll('.loader-wrapper, .loader, .preloader, .modal-backdrop, .rightbar-overlay, .swal2-container');
            overlays.forEach(function(el) {
                el.remove();
            });
            
            // تنظيف body
            document.body.classList.remove('modal-open', 'loading', 'swal2-shown');
            document.body.style.overflow = '';
            document.body.style.pointerEvents = '';
        });
        
        // تنظيف إضافي مع jQuery
        if (typeof jQuery !== 'undefined') {
            jQuery(function() {
                jQuery('.loader-wrapper, .loader, .preloader, .modal-backdrop, .rightbar-overlay').remove();
                jQuery('body').removeClass('modal-open loading swal2-shown').css({
                    'overflow': '',
                    'pointer-events': ''
                });
            });
        }
    </script>
</head>
