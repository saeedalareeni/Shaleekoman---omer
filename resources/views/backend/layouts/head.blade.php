<head>
    <meta charset="utf-8" />
    <title>@yield('page_title', 'لوحة التحكم') - {{ $siteName ?? config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ $siteSettings->getSiteDescriptionAttribute() ?? '' }}" name="description" />
    <meta content="{{ $companyName ?? '' }}" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $siteFavicon ?? asset('assets/images/shaleek_logo.png') }}">
    <link rel="shortcut icon" href="{{ $siteFavicon ?? asset('assets/images/shaleek_logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Almarai:wght@300;400&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <!-- ملاحظة: لوحة الأدمن مبنية على Bootstrap 4 (JS + Blade classes). -->
    <!-- نستخدم Bootstrap 4 CSS لتفادي تعارضات Bootstrap 5 على الجوال (مثل form-row/tabs). -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="{{ asset('backend/assets/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Plugins CSS -->
    <link href="{{ asset('backend/assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/multiselect/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('backend/custom.css') }}" rel="stylesheet" type="text/css" />

    <!-- RTL Fixes -->
    @if (App::getLocale() == 'ar')
    <style>
        html[dir="rtl"], html[dir="rtl"] body, html[dir="rtl"] * { direction: rtl !important; text-align: right !important; }
        .float-left { float: right !important; }
        .float-right { float: left !important; }
        table { direction: rtl !important; }
        th, td { text-align: right !important; }
        .form-control, .form-select, input, select, textarea { text-align: right !important; direction: rtl !important; }
    </style>
    @endif

    <!-- Inline CSS fixes -->
    <style>
        body { font-family: 'Tajawal', 'Almarai', sans-serif !important; overflow-x: hidden; }
        i.fa, i.fas, i.fa-solid, i.fa-regular, i.fab { font-family: "Font Awesome 6 Free" !important; font-weight: 900 !important; }
        .loader-wrapper { position: fixed !important; z-index: 99999 !important; pointer-events: all !important; }
        .loader-wrapper.d-none, .loader-wrapper[style*="display: none"] { display: none !important; pointer-events: none !important; z-index: -1 !important; }
        canvas { width: 100% !important; height: auto; }
    </style>

    <!-- jQuery and jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <!-- Emergency overlay cleanup -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var overlays = document.querySelectorAll('.loader-wrapper, .loader, .preloader, .modal-backdrop, .rightbar-overlay, .swal2-container');
            overlays.forEach(el => el.remove());
            document.body.classList.remove('modal-open', 'loading', 'swal2-shown');
            document.body.style.overflow = '';
            document.body.style.pointerEvents = '';
        });
        if (typeof jQuery !== 'undefined') {
            jQuery(function() {
                jQuery('.loader-wrapper, .loader, .preloader, .modal-backdrop, .rightbar-overlay').remove();
                jQuery('body').removeClass('modal-open loading swal2-shown').css({ 'overflow': '', 'pointer-events': '' });
            });
        }
    </script>

    @livewireStyles
    @yield('css')
</head>
