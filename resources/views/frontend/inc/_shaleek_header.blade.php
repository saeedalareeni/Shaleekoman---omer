@php
    $shCurrentRoute = request()->route()?->getName();
    $shCurrentCategory = request()->get('category');
    $shCustomerUnread = 0;
    if (auth('customer')->check()) {
        $shCustomerUnread = \App\Models\CustomerNotification::where('customer_id', auth('customer')->id())
            ->where('is_read', false)->count();
    }
@endphp
<!-- Prevent dark-mode flash: apply saved theme before first paint -->
<script>
    (function () {
        try {
            if (localStorage.getItem('shaleek-theme') === 'dark') {
                document.documentElement.classList.add('shaleek-dark');
            }
        } catch (e) {}
    })();
    window.shaleekLoggedIn = {{ auth('customer')->check() ? 'true' : 'false' }};
    window.shaleekLoginUrl = @json(LaravelLocalization::localizeUrl('/login'));
</script>

<header class="shaleek-header">
    <div class="shaleek-header-inner">
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

        <nav class="shaleek-nav-desktop">
            <a href="{{ route('shaleek.home') }}" class="{{ $shCurrentRoute == 'shaleek.home' ? 'active' : '' }}">
                {{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}
            </a>
            @foreach($headerCategories ?? [] as $category)
                <a href="{{ route('showAllChalet', ['category' => $category->id]) }}"
                   class="{{ ($shCurrentRoute == 'showAllChalet' && $shCurrentCategory == $category->id) ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
            <a href="{{ route('all-posts') }}" class="{{ $shCurrentRoute == 'all-posts' ? 'active' : '' }}">
                {{ app()->getLocale() == 'ar' ? 'المدونة' : 'Blog' }}
            </a>
        </nav>

        <div class="shaleek-header-actions">
            @auth('customer')
                <a href="{{ route('account.orders') }}" class="shaleek-btn-login" style="display:inline-flex;">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M4 20c0-4.4 3.6-8 8-8s8 3.6 8 8"></path></svg>
                    {{ app()->getLocale() == 'ar' ? 'حسابي' : 'My Account' }}
                    @if($shCustomerUnread > 0)
                        <span style="background:var(--red-500); color:#fff; border-radius:99px; font-size:10px; font-weight:800; padding:1px 6px; margin-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}:4px;">{{ $shCustomerUnread > 9 ? '9+' : $shCustomerUnread }}</span>
                    @endif
                </a>
            @endauth
            {{-- Visitors browse and contact owners directly — only property owners have
                 accounts on Shaleek, so there's no separate "user login" entry point. --}}

            @auth('owner')
                <a href="{{ route('owner.chalets.create') }}" class="shaleek-btn-login" style="display:inline-flex;">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    {{ app()->getLocale() == 'ar' ? 'أضف عقار' : 'Add property' }}
                </a>
                <a href="{{ route('owner.dashboard') }}" class="shaleek-btn-host">
                    <svg viewBox="0 0 24 24"><path d="M3 10.5L12 3l9 7.5"></path><path d="M5 9.5V21h14V9.5"></path><path d="M12 12.5v5"></path><path d="M9.5 15h5"></path></svg>
                    {{ app()->getLocale() == 'ar' ? 'لوحة تحكم المضيف' : 'Host Dashboard' }}
                </a>
            @else
                <a href="{{ LaravelLocalization::localizeUrl('/owner/login') }}" class="shaleek-btn-host">
                    <svg viewBox="0 0 24 24"><path d="M3 10.5L12 3l9 7.5"></path><path d="M5 9.5V21h14V9.5"></path><path d="M12 12.5v5"></path><path d="M9.5 15h5"></path></svg>
                    {{ app()->getLocale() == 'ar' ? 'أضف عقارك' : 'Add your property' }}
                </a>
            @endauth

            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale() == 'ar' ? 'en' : 'ar', null, [], true) }}" class="shaleek-lang-switch">
                {{ app()->getLocale() == 'ar' ? 'EN' : 'AR' }}
            </a>

            <button type="button" class="shaleek-theme-toggle" onclick="shaleekToggleTheme()" aria-label="{{ app()->getLocale() == 'ar' ? 'الوضع الليلي' : 'Dark mode' }}">
                <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
            </button>

            <button type="button" class="shaleek-menu-toggle" onclick="shaleekToggleMenu()" aria-label="{{ app()->getLocale() == 'ar' ? 'القائمة' : 'Menu' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
        </div>
    </div>
</header>

<!-- Mobile menu drawer -->
<div class="shaleek-mobile-menu" id="shaleekMobileMenu" onclick="if(event.target===this)shaleekToggleMenu()">
    <div class="shaleek-mobile-menu-panel">
        <div class="shaleek-mobile-menu-header">
            <div class="shaleek-logo">
                <span class="shaleek-logo-mark">
                    @if($siteLogo ?? false)
                        <img src="{{ $siteLogo }}" alt="{{ $siteName ?? 'شاليك' }}">
                    @else
                        ش
                    @endif
                </span>
                <span>{{ $siteName ?? 'شاليك' }}</span>
            </div>
            <button type="button" class="shaleek-mobile-menu-close" onclick="shaleekToggleMenu()">✕</button>
        </div>

        <div class="shaleek-mobile-menu-section">
            <div class="shaleek-mobile-menu-label">{{ app()->getLocale() == 'ar' ? 'التصفح' : 'Browse' }}</div>
            <a href="{{ route('shaleek.home') }}" class="{{ $shCurrentRoute == 'shaleek.home' ? 'active' : '' }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a>
            @foreach($headerCategories ?? [] as $category)
                <a href="{{ route('showAllChalet', ['category' => $category->id]) }}" class="{{ ($shCurrentRoute == 'showAllChalet' && $shCurrentCategory == $category->id) ? 'active' : '' }}">{{ $category->name }}</a>
            @endforeach
            <a href="{{ route('all-posts') }}">{{ app()->getLocale() == 'ar' ? 'المدونة' : 'Blog' }}</a>
        </div>

        <div class="shaleek-mobile-menu-section">
            <div class="shaleek-mobile-menu-label">{{ app()->getLocale() == 'ar' ? 'الحساب' : 'Account' }}</div>
            @auth('customer')
                <a href="{{ route('account.orders') }}">{{ app()->getLocale() == 'ar' ? 'حسابي' : 'My Account' }}</a>
                <form method="POST" action="{{ route('customer_logout') }}">
                    @csrf
                    <button type="submit" style="width:100%; text-align:{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; border:none; background:none; padding:12px 16px; border-radius:12px; font-weight:500; color:var(--red-500);">{{ app()->getLocale() == 'ar' ? 'تسجيل الخروج' : 'Logout' }}</button>
                </form>
            @endauth
            @auth('owner')
                <a href="{{ route('owner.chalets.create') }}">{{ app()->getLocale() == 'ar' ? 'أضف عقار' : 'Add property' }}</a>
                <a href="{{ route('owner.dashboard') }}">{{ app()->getLocale() == 'ar' ? 'لوحة تحكم المضيف' : 'Host Dashboard' }}</a>
            @else
                <a href="{{ LaravelLocalization::localizeUrl('/owner/login') }}">{{ app()->getLocale() == 'ar' ? 'أضف عقارك' : 'Add your property' }}</a>
            @endauth
            <a href="{{ route('about_us') }}">{{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}</a>
            <a href="{{ route('contact_us') }}">{{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}</a>
        </div>

        <div class="shaleek-mobile-menu-section">
            <div class="shaleek-mobile-menu-label">{{ app()->getLocale() == 'ar' ? 'اللغة' : 'Language' }}</div>
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale() == 'ar' ? 'en' : 'ar', null, [], true) }}">
                {{ app()->getLocale() == 'ar' ? 'English — EN' : 'العربية — AR' }}
            </a>
        </div>
    </div>
</div>
