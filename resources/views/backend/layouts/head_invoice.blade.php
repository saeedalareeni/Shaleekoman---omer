<head>
    <meta charset="utf-8" />
    <title>@yield('title') - {{ app()->getLocale() == 'ar' ? App\Models\Setting::first()->website_name_ar : App\Models\Setting::first()->website_name_en }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ app()->getLocale() == 'ar' ? App\Models\Setting::first()->website_name_ar : App\Models\Setting::first()->website_name_en }}" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset(App\Models\Setting::first()->logo) }}">
    <link rel="icon" type="image/png" href="{{ asset(App\Models\Setting::first()->logo) }}">
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- App CSS -->
    @if (App::getLocale() == 'ar')
        <link href="{{ asset('backend/assets/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    @endif
    
    <!-- Tajawal Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Invoice Styles -->
    <link href="{{ asset('backend/invoice-styles.css') }}" rel="stylesheet" type="text/css" />
    
    <style>
        body, * {
            font-family: 'Tajawal', sans-serif !important;
        }
        
        @media print {
            body {
                font-family: 'Tajawal', sans-serif !important;
            }
        }
    </style>
    
    @yield('css')
</head>
