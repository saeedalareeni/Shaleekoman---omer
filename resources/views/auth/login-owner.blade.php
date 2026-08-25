<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <title>{{ __('auth.owner_login') }} - {{ app()->getLocale() == 'ar' ? App\Models\Setting::first()->company_name_ar : App\Models\Setting::first()->company_name_en }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content=" {{app()->getLocale() == 'ar' ? App\Models\Setting::first()->company_name_ar : App\Models\Setting::first()->company_name_en}}" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ $siteFavicon ?? asset('assets/images/shaleek_logo.png') }}">

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

        .btn-google {
            width: 100%;
            padding: 12px;
            background: white;
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            color: #333;
        }

        [dir="rtl"] .btn-google {
            font-family: 'Tajawal', sans-serif !important;
            font-weight: 500;
        }

        .btn-google:hover {
            border-color: #127664;
            background: #f0f8f6;
            text-decoration: none;
            color: #333;
        }

        .btn-google img {
            height: 20px;
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e1e1;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            color: #999;
            font-size: 0.9rem;
        }

        /* Links */
        .form-links {
            text-align: center;
            margin-top: 25px;
        }

        .form-links a {
            color: #127664;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-links a:hover {
            color: #DF4D2D;
            text-decoration: underline;
        }

        .form-links .back-link {
            display: inline-block;
            padding: 8px 20px;
            background: linear-gradient(135deg, #DF4D2D 0%, #FF6341 100%);
            color: white !important;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-links .back-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(223, 77, 45, 0.3);
            text-decoration: none;
        }

        /* Remember me */
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border: 2px solid #e1e1e1;
            border-radius: 4px;
            cursor: pointer;
            accent-color: #127664;
        }

        .remember-me input[type="checkbox"]:checked {
            background-color: #127664;
            border-color: #127664;
        }

        .remember-me label {
            color: #666;
            font-size: 0.95rem;
            cursor: pointer;
            margin: 0;
        }

        [dir="rtl"] .remember-me label {
            font-family: 'Tajawal', sans-serif !important;
            font-weight: 400;
        }

        /* Portal badge */
        .portal-badge {
            display: inline-block;
            background: linear-gradient(135deg, #DF4D2D 0%, #FF6341 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(223, 77, 45, 0.3);
        }

        [dir="rtl"] .portal-badge {
            font-family: 'Tajawal', sans-serif !important;
            font-weight: 600;
        }

        /* Language Switcher */
        .language-switcher {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 100;
        }

        [dir="rtl"] .language-switcher {
            right: auto;
            left: 20px;
        }

        .lang-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(18, 118, 100, 0.2);
            border-radius: 25px;
            color: #127664;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        [dir="rtl"] .lang-btn {
            font-family: 'Tajawal', sans-serif !important;
        }

        .lang-btn:hover {
            background: white;
            border-color: #127664;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(18, 118, 100, 0.2);
            text-decoration: none;
            color: #127664;
        }

        .lang-btn i {
            font-size: 1.2rem;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.95rem;
            border: 1px solid transparent;
        }

        .alert-danger {
            background-color: #fee;
            color: #c33;
            border-color: #fcc;
        }

        .alert-success {
            background-color: #efe;
            color: #3c3;
            border-color: #cfc;
        }
    </style>

</head>
<body>

<!-- Language Switcher -->
<div class="language-switcher">
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @if($localeCode != LaravelLocalization::getCurrentLocale())
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="lang-btn">
                <i class="mdi mdi-web"></i>
                <span>{{ $properties['native'] }}</span>
            </a>
        @endif
    @endforeach
</div>

<div class="login-bg">
    <div class="login-container">
        <!-- Logo Section -->
        <div class="logo-section">
            <div class="logo-bg">
                <a href="/">
                    <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="Logo">
                </a>
            </div>
            <h2 class="site-title">
                {{ __('auth.owner_portal') }}
            </h2>
        </div>

        @include('flash-message')

        <!-- Login Card -->
        <div class="login-card">
            <div class="text-center">
                <span class="portal-badge">
                    <i class="mdi mdi-home-account"></i> {{ __('auth.owner_login') }}
                </span>
                <h2 class="card-title">{{ __('auth.welcome_back') }}</h2>
                <p class="card-subtitle">{{ __('auth.sign_in_to_manage') }}</p>
            </div>

            <form method="POST" action="{{ route('owner.login') }}">
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="mdi mdi-email-outline"></i> {{ app()->getLocale() == 'ar' ? __('back.Email') : __('back.email') }}
                    </label>
                    <input type="email"
                           class="form-input"
                           name="email"
                           id="email"
                           required
                           autofocus
                           placeholder="{{ app()->getLocale() == 'ar' ? __('back.Email') : __('back.email') }}"
                           value="{{old('email')}}">
                    @error('email')
                        <small style="color: #e74c3c; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="mdi mdi-lock-outline"></i> {{ __('back.password') }}
                    </label>
                    <!-- <div class="input-with-icon"> -->
                        <input type="password"
                               class="form-input"
                               name="password"
                               id="password"
                               required
                               autocomplete="current-password"
                               placeholder="{{ __('back.password') }}">
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="mdi mdi-eye-outline" id="toggleIcon"></i>
                        </span>
                    <!-- </div> -->
                    @error('password')
                        <small style="color: #e74c3c; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">{{ __('auth.remember_me') }}</label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-primary">
                    <i class="mdi mdi-login"></i> {{ __('back.Login') }}
                </button>

                @if(isset($googleLoginEnabled) && $googleLoginEnabled)
                <!-- Divider -->
                <div class="divider">
                    <span>{{ __('auth.or') }}</span>
                </div>

                <!-- Google Login -->
                <a href="{{ route('auth.google.withType',['type' => 'owner']) }}" class="btn-google">
                    <img src="{{ asset('images/auth/google-logo.svg') }}" alt="Google">
                    {{ __('back.Login with Google') }}
                </a>
                @endif
            </form>

            <!-- Links -->
            <div class="form-links">
                <div style="margin-bottom: 15px; text-align: center;">
                    <p style="color: #666; margin-bottom: 10px;">
                        {{ app()->getLocale() == 'ar' ? 'ليس لديك حساب؟' : "Don't have an account?" }}
                    </p>
                    <a href="{{ route('owner.register') }}" class="btn-register-link" style="
                        display: inline-block;
                        background: linear-gradient(135deg, #2c8e3d 0%, #ff8c42 100%);
                        color: white;
                        padding: 10px 30px;
                        border-radius: 25px;
                        text-decoration: none;
                        font-weight: 600;
                        transition: all 0.3s;
                        box-shadow: 0 4px 10px rgba(44, 142, 61, 0.3);
                    " onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="mdi mdi-account-plus"></i> {{ app()->getLocale() == 'ar' ? 'إنشاء حساب جديد' : 'Create New Account' }}
                    </a>
                </div>

                <div style="margin-bottom: 15px; text-align: center;">
                    <a href="{{ route('owner.forgot_password') }}" class="btn-register-link" style="
                        display: inline-block;
                        background: linear-gradient(135deg, #2c8e3d 0%, #ff8c42 100%);
                        color: white;
                        padding: 10px 30px;
                        border-radius: 25px;
                        text-decoration: none;
                        font-weight: 600;
                        transition: all 0.3s;
                        box-shadow: 0 4px 10px rgba(44, 142, 61, 0.3);
                    ">
                        <i class="mdi mdi-lock-reset"></i> {{ trans('back.forgot_password') }}
                    </a>


                </div>

                <a href="{{ route('login') }}" class="back-link">
                    <i class="mdi mdi-arrow-left"></i> {{ __('back.back') }}
                </a>
                <br>
                <small style="color: #999; margin-top: 10px; display: block;">
                    {{ __('auth.programming_development') }}
                    <a href="https://mazoonsoft.com" target="_blank" style="color: #127664;">{{ __('auth.mazoonsoft') }}</a>
                </small>
            </div>
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

</body>
</html>
