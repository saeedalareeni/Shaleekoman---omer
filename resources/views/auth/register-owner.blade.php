@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ app()->getLocale() == 'ar' ? 'تسجيل حساب مالك' : 'Owner Registration' }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('frontend/scss/main.css')}}" />
<style>
    .register-section {
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f9f4 0%, #ffe8d6 100%);
        padding: 80px 0;
    }

    .register-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        border: none;
    }

    .register-header {
        background: linear-gradient(135deg, #2c8e3d 0%, #ff8c42 100%);
        color: white;
        padding: 30px;
        text-align: center !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .register-header * {
        text-align: center !important;
    }

    .register-header i {
        display: block !important;
        margin: 0 auto 15px auto !important;
        text-align: center !important;
    }

    .register-header h4 {
        margin: 0 0 10px 0 !important;
        font-size: 24px;
        font-weight: 600;
        text-align: center !important;
        width: 100%;
        display: block;
    }

    .register-header p {
        margin: 0 !important;
        opacity: 0.9;
        text-align: center !important;
        width: 100%;
        display: block;
    }
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #2c8e3d;
        box-shadow: 0 0 0 0.2rem rgba(44, 142, 61, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .btn-register {
        background: linear-gradient(135deg, #2c8e3d 0%, #3fb054 100%);
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s;
        color: white;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(44, 142, 61, 0.3);
        color: white;
    }

    .btn-google {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        color: #495057;
    }

    .btn-google:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
        transform: translateY(-2px);
    }

    .btn-google img {
        width: 20px;
        height: 20px;
    }

    .divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: #e9ecef;
    }

    .divider span {
        background: white;
        padding: 0 15px;
        position: relative;
        color: #6c757d;
        font-size: 14px;
    }

    .login-link {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        margin: -20px -20px 0;
        border-top: 1px solid #e9ecef;
    }

    .login-link a {
        color: #2c8e3d;
        font-weight: 600;
        text-decoration: none;
    }

    .login-link a:hover {
        color: #ff8c42;
    }

    .error-message {
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
    }

    .success-alert {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        color: white;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    /* Language switcher styles */
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
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        color: #495057;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .language-switcher .btn-lang:hover {
        background: #2c8e3d;
        color: white;
        border-color: #2c8e3d;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(44, 142, 61, 0.2);
    }

    .language-switcher .btn-lang.active {
        background: #2c8e3d;
        color: white;
        border-color: #2c8e3d;
    }

    /* RTL Support */
    html[dir="rtl"] body,
    html[dir="rtl"] * {
        direction: rtl !important;
        text-align: right !important;
    }

    /* Override for centered elements in RTL */
    html[dir="rtl"] .register-header,
    html[dir="rtl"] .register-header *,
    html[dir="rtl"] .site-branding,
    html[dir="rtl"] .site-branding *,
    html[dir="rtl"] .login-link,
    html[dir="rtl"] .login-link * {
        text-align: center !important;
        direction: ltr !important;
    }

    html[dir="rtl"] .register-header h4,
    html[dir="rtl"] .register-header p {
        direction: rtl !important;
    }

    html[dir="rtl"] .language-switcher {
        left: 20px;
        right: auto;
    }

    html[dir="rtl"] .fas.me-1,
    html[dir="rtl"] .fas.me-2 {
        margin-left: 0.25rem !important;
        margin-right: 0 !important;
    }

    /* Logo and site name styles */
    .site-branding {
        text-align: center !important;
        margin-bottom: 40px;
        padding-top: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .site-branding img {
        max-height: 80px;
        margin-bottom: 15px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .site-branding h2 {
        background: linear-gradient(135deg, #2c8e3d 0%, #ff8c42 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 32px;
        font-weight: 700;
        margin: 0 auto;
        letter-spacing: 1px;
        text-align: center !important;
        display: block;
        width: 100%;
    }

    /* Center button text */
    .btn-register,
    .btn-google {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    /* Center login link text */
    .login-link p {
        text-align: center !important;
    }

    /* Font for Arabic */
    html[dir="rtl"] body {
        font-family: 'Tajawal', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif !important;
    }
</style>
</head>

<body dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

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

    <section class="register-section">
    <div class="container">
        <!-- Site Logo and Name -->
        <div class="site-branding">
            @if(isset($settings))
                @if($settings->logo)
                    <img src="{{ asset($settings->logo) }}" alt="{{ $settings->getSiteNameAttribute() ?? 'shaleek' }}">
                @else
                    <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="Logo">
                @endif
                <h2>{{ $settings->getSiteNameAttribute() ?? 'shaleek' }}</h2>
            @else
                <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="Logo">
                <h2>shaleek</h2>
            @endif
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="register-card">
                    <div class="register-header">
                        <i class="fas fa-user-plus fa-3x"></i>
                        <h4>{{ app()->getLocale() == 'ar' ? 'تسجيل حساب مالك جديد' : 'Register as Owner' }}</h4>
                        <p>{{ app()->getLocale() == 'ar' ? 'انضم إلينا وابدأ في إدارة شاليهاتك' : 'Join us and start managing your chalets' }}</p>
                    </div>

                    <div class="card-body p-4">
                        @if(session('success'))
                        <div class="success-alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                        @endif

                        <form action="{{route('owner.register')}}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-user me-1"></i>
                                        {{ app()->getLocale() == 'ar' ? 'الاسم الكامل' : 'Full Name' }}
                                    </label>
                                    <input type="text" class="form-control" placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل اسمك الكامل' : 'Enter your full name' }}" name="name" value="{{old('name')}}" required>
                                    @error('name') <div class="error-message">{{$message}}</div> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-envelope me-1"></i>
                                        {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <input type="email" class="form-control" placeholder="{{ app()->getLocale() == 'ar' ? 'example@email.com' : 'example@email.com' }}" name="email" value="{{old('email')}}" required>
                                    @error('email') <div class="error-message">{{$message}}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-lock me-1"></i>
                                        {{ app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Password' }}
                                    </label>
                                    <input type="password" class="form-control" placeholder="{{ app()->getLocale() == 'ar' ? '8 أحرف على الأقل' : 'At least 8 characters' }}" name="password" required>
                                    @error('password') <div class="error-message">{{$message}}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-lock me-1"></i>
                                        {{ app()->getLocale() == 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}

                                    </label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="{{ app()->getLocale() == 'ar' ? 'أعد كتابة كلمة المرور' : 'Re-enter password' }}" required>
                                    @error('password_confirmation') <div class="error-message">{{$message}}</div> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-phone me-1"></i>
                                        {{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone Number' }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <input type="tel"
                                          
                                           style="direction: ltr !important;" class="form-control" placeholder="{{ app()->getLocale() == 'ar' ? '+968XXXXXXXX' : '+968XXXXXXXX' }}" name="phone" value="{{old('phone')}}" required>
                                    @error('phone') <div class="error-message">{{$message}}</div> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ app()->getLocale() == 'ar' ? 'العنوان' : 'Address' }}
                                    </label>
                                    <input type="text" class="form-control" placeholder="{{ app()->getLocale() == 'ar' ? 'المدينة، المنطقة' : 'City, Area' }}" name="address" value="{{old('address')}}" required>
                                    @error('address') <div class="error-message">{{$message}}</div> @enderror
                                </div>
                            </div>

                            <button class="btn btn-register w-100 mb-3" type="submit">
                                <i class="fas fa-user-plus me-2"></i>
                                {{ app()->getLocale() == 'ar' ? 'إنشاء حساب' : 'Create Account' }}
                            </button>

                            @if(isset($googleLoginEnabled) && $googleLoginEnabled)
                            <div class="divider">
                                <span>{{ app()->getLocale() == 'ar' ? 'أو' : 'OR' }}</span>
                            </div>

                            <a href="{{ route('auth.google.withType',['type' => 'owner']) }}" class="btn btn-google w-100">
                                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'التسجيل باستخدام Google' : 'Sign up with Google' }}
                            </a>
                            @endif
                        </form>
                    </div>

                    <div class="login-link">
                        <p class="mb-0">
                            {{ app()->getLocale() == 'ar' ? 'هل لديك حساب بالفعل؟' : 'Already have an account?' }}
                            <a href="{{route('owner.login')}}">
                                {{ app()->getLocale() == 'ar' ? 'تسجيل الدخول' : 'Login' }}</a>



                        </p>
                        <p class="mb-0">
                            {{ app()->getLocale() == 'ar' ? 'هل نسيت كلمة المرور؟' : 'Did you forget your password?' }}
                            <a href="{{route('owner.login')}}">
                                {{ app()->getLocale() == 'ar' ? 'اضغظ هنا' : 'Click Here' }}</a>



                        </p>


                    </div>
                </div>
                <!-- end card -->

            </div>
        </div>
    </div>
</section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to change language
        function changeLanguage(lang) {
            window.location.href = '{{ url("/") }}/lang/' + lang + '?t=' + new Date().getTime();
        }
    </script>
</body>
</html>
