@extends('frontend.layouts.weekend_master')

@section('page_title')
    {{trans('back.login')}}
@endsection

@section('css')
<style>
    /* Login Page Styles */
    .login-page {
        min-height: 100vh;
        background: linear-gradient(180deg, 
            #ffffff 0%, 
            #ffffff 8%, 
            rgba(255, 255, 255, 0.98) 12%,
            rgba(248, 249, 250, 0.95) 20%,
            rgba(245, 247, 250, 0.9) 35%,
            rgba(18, 118, 100, 0.02) 50%, 
            rgba(223, 77, 45, 0.015) 65%, 
            rgba(245, 247, 250, 0.95) 85%,
            #f8f9fa 100%
        );
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 100px 20px 40px;
        position: relative;
        overflow: hidden;
    }
    
    /* Soft shadow under header */
    .login-page::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 120px;
        background: linear-gradient(180deg, 
            rgba(0,0,0,0.02) 0%, 
            rgba(0,0,0,0) 100%
        );
        pointer-events: none;
        z-index: 1;
    }
    
    /* Decorative gradient background */
    .login-page::before {
        content: '';
        position: absolute;
        top: 50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, 
            rgba(18, 118, 100, 0.05) 0%, 
            rgba(21, 146, 101, 0.04) 25%, 
            rgba(223, 77, 45, 0.03) 50%, 
            rgba(255, 99, 65, 0.04) 75%, 
            rgba(18, 118, 100, 0.05) 100%
        );
        animation: gradientAnimation 20s ease infinite;
        z-index: 0;
    }
    
    @keyframes gradientAnimation {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(180deg); }
    }
    
    /* Decorative circles - more subtle */
    .decorative-circle-1 {
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(223, 77, 45, 0.03) 0%, transparent 70%);
        border-radius: 50%;
        bottom: 10%;
        right: -200px;
        z-index: 0;
    }
    
    .login-container::before {
        content: '';
        position: absolute;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(18, 118, 100, 0.03) 0%, transparent 70%);
        border-radius: 50%;
        top: 20%;
        left: -175px;
        z-index: 0;
    }
    
    /* Additional subtle decoration */
    .login-container::after {
        content: '';
        position: absolute;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255, 99, 65, 0.02) 0%, transparent 70%);
        border-radius: 50%;
        bottom: -125px;
        right: 50%;
        z-index: 0;
    }
    
    /* Google Login Button Styles */
    .google-login-btn {
        width: 100%;
        padding: 12px 20px;
        border: 2px solid #ea4335;
        background: white;
        color: #3c4043;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-bottom: 15px;
    }
    
    .google-login-btn:hover {
        background: #ea4335;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(234, 67, 53, 0.3);
    }
    
    .google-login-btn svg {
        width: 20px;
        height: 20px;
    }
    
    .divider-or {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }
    
    .divider-or::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e0e0e0;
    }
    
    .divider-or span {
        background: white;
        padding: 0 15px;
        position: relative;
        color: #999;
        font-size: 14px;
    }
    
    /* Login Container */
    .login-container {
        width: 100%;
        max-width: 480px;
        position: relative;
        z-index: 10;
    }
    
    /* Logo Section */
    .login-logo {
        text-align: center;
        margin-bottom: 30px;
        position: relative;
        z-index: 20;
    }
    
    .login-logo img {
        height: 70px;
        filter: drop-shadow(0 4px 15px rgba(0,0,0,0.15));
    }
    
    .welcome-text {
        color: #127664;
        font-size: 1.8rem;
        font-weight: 700;
        margin-top: 15px;
        background: linear-gradient(135deg, #127664 0%, #DF4D2D 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Login Card */
    .login-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        position: relative;
        border-top: 4px solid transparent;
        background-image: linear-gradient(white, white),
                          linear-gradient(90deg, #127664 0%, #159265 40%, #DF4D2D 60%, #FF6341 100%);
        background-origin: border-box;
        background-clip: padding-box, border-box;
    }
    
    .login-card h3 {
        color: #333;
        text-align: center;
        margin-bottom: 10px;
        font-weight: 600;
        font-size: 1.4rem;
    }
    
    .login-card p.subtitle {
        color: #666;
        text-align: center;
        margin-bottom: 30px;
        font-size: 0.95rem;
    }
    
    /* Form Styles */
    .form-floating {
        margin-bottom: 20px;
    }
    
    .form-floating input {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        height: 55px;
        padding: 10px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-floating input:focus {
        border-color: #127664;
        box-shadow: 0 0 0 0.2rem rgba(18, 118, 100, 0.1);
        background-color: rgba(18, 118, 100, 0.02);
    }
    
    .form-floating label {
        color: #6c757d;
        padding: 1rem 15px;
    }
    
    .form-check {
        margin-bottom: 20px;
    }
    
    .form-check-input:checked {
        background-color: #127664;
        border-color: #127664;
    }
    
    /* Buttons */
    .btn-login {
        background: linear-gradient(135deg, #127664 0%, #159265 50%, #127664 100%);
        background-size: 200% auto;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 30px;
        font-size: 1rem;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-login:hover {
        background-position: right center;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(18, 118, 100, 0.3);
    }
    
    .btn-login:hover::before {
        left: 100%;
    }
    
    .btn-google {
        background: white;
        color: #333;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 12px 30px;
        font-size: 1rem;
        font-weight: 500;
        width: 100%;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 15px;
    }
    
    .btn-google:hover {
        background: #f0f8f6;
        border-color: #127664;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .btn-google img {
        height: 20px;
    }
    
    /* Orange dot decoration */
    .login-card::after {
        content: '';
        position: absolute;
        width: 80px;
        height: 80px;
        background: radial-gradient(circle, rgba(223, 77, 45, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        top: -40px;
        right: -40px;
    }
    
    .login-card::before {
        content: '';
        position: absolute;
        width: 60px;
        height: 60px;
        background: radial-gradient(circle, rgba(18, 118, 100, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        bottom: -30px;
        left: -30px;
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
        background: #e0e0e0;
    }
    
    .divider span {
        background: white;
        padding: 0 15px;
        color: #6c757d;
        position: relative;
    }
    
    /* Links */
    .auth-links {
        text-align: center;
        margin-top: 25px;
    }
    
    .auth-links a {
        color: #127664;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .auth-links a:hover {
        color: #DF4D2D;
    }
    
    .auth-links a.register-link {
        color: #DF4D2D;
        font-weight: 700;
    }
    
    .auth-links a.register-link:hover {
        color: #FF6341;
    }
    
    /* Orange accent for register */
    .or-register {
        display: inline-block;
        padding: 10px 25px;
        background: linear-gradient(135deg, #DF4D2D 0%, #FF6341 100%);
        color: white !important;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 15px;
    }
    
    .or-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(223, 77, 45, 0.3);
        text-decoration: none;
        color: white !important;
    }
    
    /* Error Messages */
    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 5px;
    }
    
    /* Success Messages */
    .alert {
        border-radius: 12px;
        margin-bottom: 20px;
    }
    
    /* RTL Support */
    [dir="rtl"] .btn-google {
        flex-direction: row-reverse;
    }
    
    [dir="rtl"] .form-floating input {
        text-align: right;
    }
</style>
@endsection

@section('content')
<div class="login-page">
    <!-- Decorative circles -->
    <div class="decorative-circle-1"></div>
    
    <div class="login-container">
        <!-- Logo Section -->
        <div class="login-logo">
            <a href="/">
                <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="Logo">
            </a>
            <h2 class="welcome-text">{{ app()->getLocale() == 'ar' ? 'مرحباً بك' : 'Welcome' }}</h2>
        </div>
        
        <!-- Login Card -->
        <div class="login-card">
            @include('flash-message')
            
            <h3>{{ trans('back.login') }}</h3>
            <p class="subtitle">{{ app()->getLocale() == 'ar' ? 'سجل دخولك للاستمتاع بخدماتنا' : 'Sign in to enjoy our services' }}</p>
            
            <form method="POST" action="{{ route('customer_store') }}">
                @csrf
                
                <!-- Email Field -->
                <div class="form-floating">
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           placeholder="{{ trans('back.Email') }}"
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                    <label for="email">{{ trans('back.Email') }}</label>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Password Field -->
                <div class="form-floating">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="{{ trans('back.password') }}"
                           required>
                    <label for="password">{{ trans('back.password') }}</label>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Remember Me -->
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="remember" 
                           id="remember">
                    <label class="form-check-label" for="remember">
                        {{ trans('back.Remember_me') }}
                    </label>
                </div>
                
                <!-- Login Button -->
                <button type="submit" class="btn btn-login">
                    {{ trans('back.Login') }}
                </button>
                
                @if(isset($googleLoginEnabled) && $googleLoginEnabled)
                <!-- Divider -->
                <div class="divider-or">
                    <span>{{ app()->getLocale() == 'ar' ? 'أو' : 'OR' }}</span>
                </div>
                
                <!-- Google Login -->
                <a href="{{ route('auth.google.withType',['type' => 'customer']) }}" class="google-login-btn">
                    <svg viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                        <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                            <path fill="#4285F4" d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z"/>
                            <path fill="#34A853" d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z"/>
                            <path fill="#FBBC05" d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z"/>
                            <path fill="#EA4335" d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z"/>
                        </g>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'تسجيل الدخول بـ Google' : 'Sign in with Google' }}</span>
                </a>
                @endif
            </form>
            
            <!-- Links -->
            <div class="auth-links">
                <p class="mb-2">
                    {{ trans('back.Dont have an account ?') }}
                </p>
                <a href="{{ route('customer_register') }}" class="or-register">
                    <i class="fas fa-user-plus"></i> {{ trans('back.Signup now') }}
                </a>
                <div class="mt-3">
                    <a href="{{ route('user.forgot_password') }}">
                        <i class="fas fa-key"></i> {{ trans('back.forgot_password') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
