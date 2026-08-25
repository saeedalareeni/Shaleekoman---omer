<head>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="mazoonsoft" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />
    
    <!-- Google Fonts: Tajawal for Arabic, Poppins for English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <meta name="keywords" content="@yield('meta_keywords', $siteSettings->meta_keywords ?? '')" />
    <meta name="description" content="@yield('meta_description', $siteSettings->getMetaDescriptionAttribute() ?? '')" />
    <title>@yield('page_title', '') {{ !empty(trim($__env->yieldContent('page_title'))) ? ' - ' : '' }}{{ $siteTitle ?? config('app.name') }}</title>

    <link rel="shortcut icon" href="{{ $siteFavicon ?? asset('assets/images/shaleek_logo.png') }}" />
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('frontend/scss/main.css')}}" />

    <!-- <link rel="stylesheet" href="{{asset('frontend/assets/css/custom_style.css')}}" /> -->

    <!-- استيراد الخطوط فقط مرة واحدة -->

    <!-- <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Fustat:wght@200..800&display=swap" rel="stylesheet"> -->

    @yield('css')

    <!-- استيراد مكتبة select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Default font for English (LTR) */
        :root {
            --font-primary: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif;
        }
        
        body {
            font-family: var(--font-primary) !important;
            background-color: #ffffff;
            color: #212529;
            line-height: 1.6;
        }

        html {
            font-family: var(--font-primary) !important;
        }
        
        /* Arabic (RTL) - Use Tajawal font */
        [dir="rtl"] {
            --font-primary: 'Tajawal', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif;
        }
        
        [dir="rtl"] body,
        [dir="rtl"] html {
            font-family: 'Tajawal', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif !important;
        }
        
        [dir="ltr"] body,
        [dir="ltr"] html {
            font-family: 'Poppins', sans-serif !important;
        }
        
        /* Additional Styling */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        }
        
        .btn-outline-green {
            border-color: #127664;
            color: #127664;
        }
        
        .btn-outline-green:hover {
            background-color: #127664;
            color: white;
        }
        
        .bg-green {
            background-color: #127664 !important;
        }
        
        .badge {
            font-weight: 600;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            font-size: 1.2em;
        }
        
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            height: auto;
            line-height: 1.5;
            font-size: 1rem;
            color: #495057;
            border-radius: 111px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 50px;
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: inherit;
        }
    </style>
</head>
