<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <title>{{ __('back.login-admin') }} - {{ isset($settings) ? $settings->getSiteNameAttribute() : 'shaleek' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ isset($settings) ? $settings->getSiteNameAttribute() : 'shaleek' }}" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ $siteFavicon ?? asset('assets/images/shaleek_logo.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />

    @if (App::getLocale() == 'ar')
        <!-- Bootstrap Css -->
        <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('backend/assets/css/app-rtl.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    @else
        <!-- Bootstrap Css -->
        <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('backend/assets/css/app.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    @endif


    <link href="{{asset('backend/assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />

    {{-- Google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- custom css -->
    <link href="{{asset('backend/custom.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/login-custom.css?v=2.0')}}" rel="stylesheet" type="text/css" />
    
    <style>
        /* Modern Clean Design */
        body {
            min-height: 100vh;
            background: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica', 'Arial', sans-serif;
        }
        
        [dir="rtl"] body {
            font-family: 'Tajawal', -apple-system, BlinkMacSystemFont, 'Arial', sans-serif !important;
        }
        
        [dir="rtl"] * {
            font-family: 'Tajawal', -apple-system, BlinkMacSystemFont, 'Arial', sans-serif !important;
        }
        
        .login-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #127664 0%, #159265 50%, #127664 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        
        /* Pattern overlay */
        .login-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        /* Orange circles decoration */
        .login-bg::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(223, 77, 45, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            top: -150px;
            right: -150px;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255, 99, 65, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -125px;
            left: -125px;
            z-index: 0;
        }
        
        .login-container {
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 10;
        }
        
        /* Logo */
        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-bg {
            display: inline-block;
            padding: 20px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        .logo-bg img {
            height: 60px;
        }
        
        .site-title {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        [dir="rtl"] .site-title {
            font-family: 'Tajawal', sans-serif !important;
            font-weight: 700;
        }
        
        /* Card */
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 40px;
            position: relative;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 20%;
            right: 20%;
            height: 4px;
            background: linear-gradient(90deg, #127664 0%, #159265 50%, #DF4D2D 100%);
            border-radius: 0 0 10px 10px;
        }
        
        .card-title {
            text-align: center;
            color: #333;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        [dir="rtl"] .card-title {
            font-family: 'Tajawal', sans-serif !important;
            font-weight: 700;
        }
        
        .card-subtitle {
            text-align: center;
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }
        
        [dir="rtl"] .card-subtitle {
            font-family: 'Tajawal', sans-serif !important;
            font-weight: 400;
        }
        
        /* Form */
        .form-group {
            margin-bottom: 25px;
            width: 100%;
            display: block;
        }
        
        .form-label {
            display: block;
            color: #555;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        
        [dir="rtl"] .form-label {
            text-align: right;
        }
        
        .form-label i {
            width: 20px;
            color: #127664;
        }
        
        .form-input {
            width: 100% !important;
            padding: 14px 16px;
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            box-sizing: border-box;
            display: block;
            margin: 0;
        }
        
        [dir="rtl"] .form-input {
            font-family: 'Tajawal', sans-serif !important;
            text-align: right;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #127664;
            box-shadow: 0 0 0 4px rgba(18, 118, 100, 0.1);
        }
        
        .input-with-icon {
            position: relative;
            width: 100%;
        }
        
        .input-with-icon .form-input {
            width: 100% !important;
            padding: 14px 45px 14px 16px !important;
            box-sizing: border-box;
            margin: 0;
        }
        
        [dir="rtl"] .input-with-icon .form-input {
            padding: 14px 16px 14px 45px !important;
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            transition: color 0.3s;
        }
        
        .password-toggle:hover {
            color: #127664;
        }
        
        [dir="rtl"] .password-toggle {
            right: auto;
            left: 16px;
        }
        
        /* Buttons */
        .btn-primary {
            width: 100%;
            padding: 14px 28px;
            background: linear-gradient(135deg, #127664 0%, #159265 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        
        [dir="rtl"] .btn-primary {
            font-family: 'Tajawal', sans-serif !important;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(18, 118, 100, 0.4);
            background: linear-gradient(135deg, #159265 0%, #127664 100%);
        }
        
        /* Links */
        .link-text {
            color: #666;
            text-align: center;
            display: block;
            margin-top: 20px;
            font-size: 0.95rem;
            text-decoration: none;
        }
        
        .link-text:hover {
            color: #127664;
        }
        
        .developer-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 0.85rem;
            color: #999;
        }
        
        .developer-link a {
            color: #127664;
            text-decoration: none;
            font-weight: 500;
        }
        
        .developer-link a:hover {
            color: #DF4D2D;
        }
        
        /* Language Switcher */
        .language-switcher {
            position: absolute;
            top: 20px;
            z-index: 1000;
        }
        
        html[dir="rtl"] .language-switcher {
            left: 20px;
        }
        
        html[dir="ltr"] .language-switcher {
            right: 20px;
        }
        
        .language-switcher .btn-lang {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            color: white;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .language-switcher .btn-lang:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        .language-switcher .btn-lang.active {
            background: white;
            color: #127664;
        }
    </style>

</head>

<body>
    @php
        use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    @endphp
    
    <!-- Language Switcher -->
    <div class="language-switcher">
        @if(app()->getLocale() == 'en')
            <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" class="btn-lang">
                <i class="fas fa-globe"></i> عربي
            </a>
        @else
            <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" class="btn-lang">
                <i class="fas fa-globe"></i> English
            </a>
        @endif
    </div>

    <div class="login-bg">
        <div class="login-container">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-bg">
                    @if(isset($settings) && $settings->logo)
                        <img src="{{ asset($settings->logo) }}" alt="{{ $settings->getSiteNameAttribute() }}">
                    @else
                        <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="Logo">
                    @endif
                </div>
                <h2 class="site-title">{{ isset($settings) ? $settings->getSiteNameAttribute() : 'shaleek' }}</h2>
            </div>

            @include('flash-message')
            
            <!-- Login Card -->
            <div class="login-card">
                <h3 class="card-title">{{ __('back.login-admin') }}</h3>
                <p class="card-subtitle">{{ __('back.Sign in to continue') }}</p>

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="email">
                            <i class="mdi mdi-email-outline"></i> {{ __('back.Email') }}
                        </label>
                        <input class="form-input" type="email" name="email" id="email" required autofocus placeholder="{{ __('back.Email') }}" value="{{old('email')}}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">
                            <i class="mdi mdi-lock-outline"></i> {{ __('back.password') }}
                        </label>
                        <!-- <div class="input-with-icon"> -->
                            <input class="form-input" type="password" name="password" required autocomplete="current-password" id="password" placeholder="{{ __('back.password') }}">
                            <span class="password-toggle" onclick="togglePassword()">
                                <i class="mdi mdi-eye-outline" id="toggleIcon"></i>
                            </span>
                        <!-- </div> -->
                    </div>

                    <button class="btn-primary" type="submit">
                        <i class="mdi mdi-login"></i> {{ __('back.Login') }}
                    </button>
                </form>
                
                <a href="{{ route('login') }}" class="link-text">
                    <i class="mdi mdi-arrow-left"></i> {{ __('back.back') }}
                </a>
<!-- 
                <div class="developer-link">
                    {{ __('auth.programming_development') }}
                    <a href="https://mazoonsoft.com" target="_blank">{{ __('auth.mazoonsoft') }}</a>
                </div> -->
            </div>
        </div>
    </div>

<script>
function togglePassword() {
    var passwordInput = document.getElementById('password');
    var toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.className = 'mdi mdi-eye-off-outline';
    } else {
        passwordInput.type = 'password';
        toggleIcon.className = 'mdi mdi-eye-outline';
    }
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
