@php
    $isArabic = app()->getLocale() == 'ar';
    // $activeTab is passed in as 'login' or 'register'
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isArabic ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#127664">
    <title>{{ $activeTab == 'register' ? ($isArabic ? 'حساب جديد — شاليك' : 'Create account — Shaleek') : ($isArabic ? 'تسجيل الدخول — شاليك' : 'Log in — Shaleek') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/shaleek-design.css') }}?v={{ @filemtime(public_path('frontend/css/shaleek-design.css')) ?: time() }}">
</head>
<body class="shaleek">
    <script>
        (function () {
            try {
                if (localStorage.getItem('shaleek-theme') === 'dark') {
                    document.documentElement.classList.add('shaleek-dark');
                }
            } catch (e) {}
        })();
    </script>

    <header class="shaleek-header">
        <div class="container shaleek-header-inner">
            <a href="{{ route('shaleek.home') }}" class="shaleek-logo">
                <span class="shaleek-logo-mark">
                    @if($siteLogo ?? false)
                        <img src="{{ $siteLogo }}" alt="{{ $siteName ?? 'شاليك' }}">
                    @else
                        ش
                    @endif
                </span>
                <span>{{ $siteName ?? 'شاليك' }}</span>
            </a>
            <div class="shaleek-header-actions">
                <a href="{{ LaravelLocalization::getLocalizedURL($isArabic ? 'en' : 'ar', null, [], true) }}" class="shaleek-lang-switch">{{ $isArabic ? 'EN' : 'AR' }}</a>
                <button type="button" class="shaleek-theme-toggle" onclick="shaleekToggleTheme()" aria-label="{{ $isArabic ? 'الوضع الليلي' : 'Dark mode' }}">
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        <div class="shaleek-auth-page">
            <div class="shaleek-auth-hero">
                <div class="shaleek-auth-hero-glow"></div>
                <div class="shaleek-auth-hero-inner">
                    <span class="shaleek-auth-eyebrow">◆ {{ $isArabic ? 'حساب الزوّار · مجاني' : 'Visitor account · Free' }}</span>
                    <h1>{{ $isArabic ? 'اكتشف عقارك القادم على' : 'Find your next stay on' }} <span class="hl">{{ $siteName ?? 'شاليك' }}</span></h1>
                    <p class="shaleek-auth-hero-lede">
                        {{ $isArabic
                            ? 'سجّل دخولك وتابع حجوزاتك، واحفظ العقارات المفضّلة لديك، وتواصل مع أصحاب الاستراحات والشاليهات والمزارع مباشرةً.'
                            : 'Log in to track your bookings, save your favorite properties, and message rest house, chalet, and farm owners directly.' }}
                    </p>
                    <div class="shaleek-auth-benefits">
                        <div class="shaleek-auth-bitem">
                            <div class="bic"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg></div>
                            <div><b>{{ $isArabic ? 'بحث حسب المحافظة' : 'Search by governorate' }}</b><span>{{ $isArabic ? 'تصفّح العقارات المتاحة في محافظتك ومنطقتك.' : 'Browse properties available in your governorate and area.' }}</span></div>
                        </div>
                        <div class="shaleek-auth-bitem">
                            <div class="bic"><svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></div>
                            <div><b>{{ $isArabic ? 'احفظ المفضّلة' : 'Save favorites' }}</b><span>{{ $isArabic ? 'احفظ العقارات التي تعجبك وارجع لها لاحقاً.' : 'Save properties you like and come back to them later.' }}</span></div>
                        </div>
                        <div class="shaleek-auth-bitem">
                            <div class="bic"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></div>
                            <div><b>{{ $isArabic ? 'تواصل مباشر' : 'Direct contact' }}</b><span>{{ $isArabic ? 'اتصال وواتساب مباشر مع صاحب العقار — بدون وسيط.' : 'Call or WhatsApp the owner directly — no middleman.' }}</span></div>
                        </div>
                        <div class="shaleek-auth-bitem">
                            <div class="bic"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg></div>
                            <div><b>{{ $isArabic ? 'عقارات موثّقة' : 'Verified listings' }}</b><span>{{ $isArabic ? 'تصفّح عقارات موثّقة من أصحاب مشاريع حقيقيين.' : 'Browse listings verified from real property owners.' }}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shaleek-auth-form-pane">
                <div class="shaleek-auth-card">
                    <div class="shaleek-auth-tabs">
                        <button type="button" class="shaleek-auth-tab {{ $activeTab == 'register' ? 'active' : '' }}" onclick="window.location.href='{{ route('customer_register') }}'">{{ $isArabic ? 'حساب جديد' : 'New account' }}</button>
                        <button type="button" class="shaleek-auth-tab {{ $activeTab == 'login' ? 'active' : '' }}" onclick="window.location.href='{{ route('login') }}'">{{ $isArabic ? 'تسجيل الدخول' : 'Log in' }}</button>
                    </div>

                    @if(session('success'))
                        <div class="shaleek-auth-note" style="margin-top:0; margin-bottom: 16px;">
                            <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="shaleek-auth-error">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($activeTab == 'register')
                        <form class="shaleek-auth-form active" method="POST" action="{{ route('customer_register_store') }}">
                            @csrf
                            <div class="shaleek-auth-field">
                                <label>{{ $isArabic ? 'الاسم الكامل' : 'Full name' }} <span class="req">*</span></label>
                                <input type="text" class="shaleek-auth-input" name="name" value="{{ old('name') }}" placeholder="{{ $isArabic ? 'مثال: محمد الحارثي' : 'e.g. Mohammed Al Harthy' }}" required>
                            </div>
                            <div class="shaleek-auth-field">
                                <label>{{ $isArabic ? 'البريد الإلكتروني' : 'Email' }} <span class="req">*</span></label>
                                <input type="email" class="shaleek-auth-input" name="email" value="{{ old('email') }}" placeholder="you@example.com" style="direction:ltr; text-align:left;" required>
                            </div>
                            <div class="shaleek-auth-field">
                                <label>{{ $isArabic ? 'رقم الهاتف' : 'Phone number' }} <span class="req">*</span></label>
                                <input type="tel" class="shaleek-auth-input" name="phone" value="{{ old('phone') }}" placeholder="+968XXXXXXXX" style="direction:ltr; text-align:left;" required>
                            </div>
                            <div class="shaleek-auth-field">
                                <label>{{ $isArabic ? 'المدينة / المنطقة' : 'City / Area' }} <span class="req">*</span></label>
                                <input type="text" class="shaleek-auth-input" name="address" value="{{ old('address') }}" placeholder="{{ $isArabic ? 'مثال: مسقط، بوشر' : 'e.g. Muscat, Bawshar' }}" required>
                            </div>
                            <div class="shaleek-auth-field">
                                <label>{{ $isArabic ? 'كلمة المرور' : 'Password' }} <span class="req">*</span></label>
                                <div class="shaleek-auth-pw">
                                    <input type="password" class="shaleek-auth-input" id="regPw" name="password" placeholder="{{ $isArabic ? '٨ أحرف على الأقل' : 'At least 8 characters' }}" minlength="8" required>
                                    <button type="button" class="pw-toggle" id="regPwToggle">{{ $isArabic ? 'إظهار' : 'Show' }}</button>
                                </div>
                            </div>
                            <div class="shaleek-auth-field">
                                <label>{{ $isArabic ? 'تأكيد كلمة المرور' : 'Confirm password' }} <span class="req">*</span></label>
                                <input type="password" class="shaleek-auth-input" id="regPw2" name="password_confirmation" placeholder="{{ $isArabic ? 'أعد إدخال كلمة المرور' : 'Re-enter password' }}" minlength="8" required>
                            </div>
                            <button type="submit" class="shaleek-auth-submit">{{ $isArabic ? 'إنشاء الحساب ←' : 'Create account ←' }}</button>

                            @if(isset($googleLoginEnabled) && $googleLoginEnabled)
                                <div class="shaleek-auth-divider">{{ $isArabic ? 'أو' : 'or' }}</div>
                                <a href="{{ route('auth.google.withType', ['type' => 'customer']) }}" class="shaleek-auth-input" style="display:flex; align-items:center; justify-content:center; gap:8px; text-decoration:none; font-weight:700; color: var(--ink-900);">
                                    {{ $isArabic ? 'الدخول عبر جوجل' : 'Continue with Google' }}
                                </a>
                            @endif

                            <div class="shaleek-auth-switch-hint" style="margin-top:16px;">
                                {{ $isArabic ? 'لديك حساب بالفعل؟' : 'Already have an account?' }}
                                <a href="{{ route('login') }}">{{ $isArabic ? 'سجّل دخولك' : 'Log in' }}</a>
                            </div>
                        </form>
                    @else
                        <form class="shaleek-auth-form active" method="POST" action="{{ route('customer_store') }}">
                            @csrf
                            <div class="shaleek-auth-field">
                                <label>{{ $isArabic ? 'البريد الإلكتروني' : 'Email' }} <span class="req">*</span></label>
                                <input type="email" class="shaleek-auth-input" name="email" value="{{ old('email') }}" style="direction:ltr; text-align:left;" required autofocus>
                            </div>
                            <div class="shaleek-auth-field">
                                <label>{{ $isArabic ? 'كلمة المرور' : 'Password' }} <span class="req">*</span></label>
                                <div class="shaleek-auth-pw">
                                    <input type="password" class="shaleek-auth-input" id="loginPw" name="password" placeholder="{{ $isArabic ? 'كلمة المرور' : 'Password' }}" required>
                                    <button type="button" class="pw-toggle" id="loginPwToggle">{{ $isArabic ? 'إظهار' : 'Show' }}</button>
                                </div>
                            </div>
                            <div class="shaleek-auth-row">
                                <label class="shaleek-auth-check">
                                    <input type="checkbox" name="remember">
                                    <span>{{ $isArabic ? 'تذكّرني' : 'Remember me' }}</span>
                                </label>
                                <a href="{{ route('user.forgot_password') }}" class="shaleek-auth-link">{{ $isArabic ? 'نسيت كلمة المرور؟' : 'Forgot password?' }}</a>
                            </div>
                            <button type="submit" class="shaleek-auth-submit">{{ $isArabic ? 'دخول' : 'Log in' }}</button>

                            @if(isset($googleLoginEnabled) && $googleLoginEnabled)
                                <div class="shaleek-auth-divider">{{ $isArabic ? 'أو' : 'or' }}</div>
                                <a href="{{ route('auth.google.withType', ['type' => 'customer']) }}" class="shaleek-auth-input" style="display:flex; align-items:center; justify-content:center; gap:8px; text-decoration:none; font-weight:700; color: var(--ink-900);">
                                    {{ $isArabic ? 'الدخول عبر جوجل' : 'Continue with Google' }}
                                </a>
                            @endif

                            <div class="shaleek-auth-switch-hint" style="margin-top:16px;">
                                {{ $isArabic ? 'ليس لديك حساب؟' : "Don't have an account?" }}
                                <a href="{{ route('customer_register') }}">{{ $isArabic ? 'أنشئ حساباً جديداً' : 'Create one' }}</a>
                            </div>
                        </form>
                    @endif

                    <div class="shaleek-auth-note">
                        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>
                        <span>{{ $isArabic ? 'هذا الحساب مخصّص للزوّار الباحثين عن عقار. أصحاب المشاريع الراغبين بعرض عقاراتهم يمكنهم إنشاء حساب مالك من صفحة "أضف عقارك".' : 'This account is for visitors browsing for a stay. Property owners wanting to list their property can create an owner account from the "Add your property" page.' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('frontend.inc._shaleek_footer')

    <script src="{{ asset('frontend/js/shaleek-design.js') }}?v={{ @filemtime(public_path('frontend/js/shaleek-design.js')) ?: time() }}"></script>
    <script>
        function shWirePwToggle(btnId, inputId) {
            var btn = document.getElementById(btnId);
            if (!btn) return;
            btn.addEventListener('click', function () {
                var inp = document.getElementById(inputId);
                var t = inp.type === 'password' ? 'text' : 'password';
                inp.type = t;
                this.textContent = t === 'text' ? '{{ $isArabic ? "إخفاء" : "Hide" }}' : '{{ $isArabic ? "إظهار" : "Show" }}';
            });
        }
        shWirePwToggle('regPwToggle', 'regPw');
        shWirePwToggle('loginPwToggle', 'loginPw');
    </script>
</body>
</html>
