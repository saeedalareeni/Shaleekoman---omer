<head>
    <meta charset="utf-8" />
    <title>@yield('page_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ app()->getLocale() == 'ar' ? App\Models\Setting::first()->website_name_ar : App\Models\Setting::first()->website_name_en }}" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{ $siteFavicon ?? asset('assets/images/shaleek_logo.png') }}">

    <!-- Dropify CSS -->
    <link href="{{ asset('backend/assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap and Icons CSS -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Font Awesome Direct Load -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
    /* Force Font Awesome to work */
    .fas, .far, .fab, .fa {
        font-family: "Font Awesome 6 Free", "Font Awesome 5 Free" !important;
    }
    .fas, .fa {
        font-weight: 900 !important;
    }
    .far {
        font-weight: 400 !important;
    }
    i[class*="fa-"] {
        font-style: normal !important;
        font-variant: normal !important;
        text-rendering: auto !important;
        display: inline-block !important;
        -webkit-font-smoothing: antialiased !important;
    }
    </style>
    
    <!-- Font Awesome Kit -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Plugins CSS -->
    <link href="{{ asset('backend/assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/multiselect/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

    <!-- App CSS -->
    @if (App::getLocale() == 'ar')
        <link href="{{ asset('backend/assets/css/app-rtl.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('backend/custom.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    
    <!-- Owner Mobile Responsive CSS -->
    <link href="{{ asset('css/owner-mobile.css') }}" rel="stylesheet" type="text/css" />

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
        
        /* Custom Header Styles */
        #topnav {
            background: #ffffff !important;
            border-bottom: 1px solid #e5e7eb !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
            padding: 0 !important;
            min-height: 70px !important;
        }
        
        #topnav .navbar-custom {
            background: transparent !important;
            padding: 10px 0 !important;
            min-height: 70px !important;
        }
        
        #topnav .topnav-menu {
            display: flex !important;
            align-items: center !important;
            margin: 0 !important;
            height: 100% !important;
        }
        
        #topnav .topnav-menu > li {
            display: flex !important;
            align-items: center !important;
            margin: 0 5px !important;
        }
        
        /* Language Selector */
        #topnav .topnav-menu .language-selector {
            padding: 8px 12px !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            background: white !important;
            display: flex !important;
            align-items: center !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }
        
        #topnav .topnav-menu .language-selector:hover {
            border-color: #127664 !important;
            box-shadow: 0 2px 8px rgba(18, 118, 100, 0.1) !important;
        }
        
        /* Notification Bell */
        #topnav .topnav-menu .notification-bell {
            padding: 8px 12px !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            background: white !important;
            position: relative !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }
        
        #topnav .topnav-menu .notification-bell:hover {
            border-color: #127664 !important;
            box-shadow: 0 2px 8px rgba(18, 118, 100, 0.1) !important;
        }
        
        #topnav .topnav-menu .notification-bell .badge {
            position: absolute !important;
            top: -5px !important;
            right: -5px !important;
            font-size: 10px !important;
            padding: 2px 5px !important;
            border-radius: 10px !important;
            background: #dc3545 !important;
        }
        
        /* User Profile */
        #topnav .topnav-menu .user-profile-btn {
            display: flex !important;
            align-items: center !important;
            padding: 5px 15px !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            background: white !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }
        
        #topnav .topnav-menu .user-profile-btn:hover {
            border-color: #127664 !important;
            box-shadow: 0 2px 8px rgba(18, 118, 100, 0.1) !important;
        }
        
        #topnav .topnav-menu .user-profile-btn img {
            width: 40px !important;
            height: 40px !important;
            object-fit: cover !important;
            border-radius: 50% !important;
        }
        
        #topnav .topnav-menu .user-profile-btn .user-info {
            margin-left: 10px !important;
            text-align: right !important;
        }
        
        #topnav .topnav-menu .user-profile-btn .user-name {
            display: block !important;
            color: #333 !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            line-height: 1.2 !important;
        }
        
        #topnav .topnav-menu .user-profile-btn .user-role {
            display: block !important;
            color: #666 !important;
            font-size: 12px !important;
            line-height: 1.2 !important;
        }
        
        /* Dropdown Menus */
        #topnav .dropdown-menu {
            border: none !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
            margin-top: 10px !important;
        }
        
        #topnav .dropdown-menu .dropdown-item {
            padding: 10px 15px !important;
            color: #333 !important;
            transition: all 0.3s ease !important;
        }
        
        #topnav .dropdown-menu .dropdown-item:hover {
            background: #f8f9fa !important;
            color: #127664 !important;
        }
        
        #topnav .dropdown-menu .dropdown-item i {
            margin-right: 8px !important;
            color: #127664 !important;
        }
        
        /* Logo Box */
        #topnav .logo-box {
            float: left !important;
            height: 70px !important;
            display: flex !important;
            align-items: center !important;
        }
        
        #topnav .logo-box img {
            height: 40px !important;
            width: auto !important;
        }
        
        /* Remove old styles */
        #topnav .nav-link {
            padding: 0 !important;
            border: none !important;
        }
        
        #topnav .nav-user {
            padding: 0 !important;
        }
        
        @yield('css')
    </style>
    
    @stack('styles')

    @livewireStyles
    
    <script>
    // Immediate Icon Fix
    window.addEventListener('DOMContentLoaded', function() {
        // Force load Font Awesome
        if (!document.querySelector('link[href*="fontawesome"]')) {
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css';
            document.head.appendChild(link);
        }
        
        // Fix icons after load
        setTimeout(function() {
            document.querySelectorAll('i[class*="fa-"]').forEach(function(icon) {
                icon.style.fontFamily = '"Font Awesome 6 Free", "Font Awesome 5 Free"';
                if (icon.classList.contains('far')) {
                    icon.style.fontWeight = '400';
                } else {
                    icon.style.fontWeight = '900';
                }
            });
        }, 100);
    });
    </script>
    
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
