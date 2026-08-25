@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
@endphp

<!-- Unified Header CSS -->
<link rel="stylesheet" href="{{ asset('frontend/css/unified-header.css') }}">

<header class="unified-header">
    <div class="header-container">
        <!-- Logo Section -->
        <div class="header-logo">
            <a href="{{ route('shaleek.home') }}">
                <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="{{ $siteName ?? 'shaleek' }}">
            </a>
        </div>

        <!-- Navigation Section - Center -->
        <nav class="header-nav">
            <ul>
                @php
                    $currentRoute = request()->route()->getName();
                    $currentCategory = request()->get('category');
                @endphp
                <li>
                    <a href="{{ route('shaleek.home') }}" 
                       class="{{ $currentRoute == 'shaleek.home' ? 'active' : '' }}">
                        {{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('showAllChalet', ['category' => 1]) }}" 
                       class="{{ $currentRoute == 'showAllChalet' && $currentCategory == 1 ? 'active' : '' }}">
                        {{ app()->getLocale() == 'ar' ? 'استراحات , شاليهات  , مزارع' : 'Rest houses, chalets, farms' }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('showAllChalet', ['category' => 2]) }}" 
                       class="{{ $currentRoute == 'showAllChalet' && $currentCategory == 2 ? 'active' : '' }}">
                        {{ app()->getLocale() == 'ar' ? 'جلسات , مخيمات' : 'Sessions, camps' }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('showAllChalet', ['category' => 3]) }}" 
                       class="{{ $currentRoute == 'showAllChalet' && $currentCategory == 3 ? 'active' : '' }}">
                        {{ app()->getLocale() == 'ar' ? 'قاعات أفراح' : 'wedding halls' }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('showAllChalet', ['category' => 4]) }}" 
                       class="{{ $currentRoute == 'showAllChalet' && $currentCategory == 4 ? 'active' : '' }}">
                        {{ app()->getLocale() == 'ar' ? 'صالونات تجميل نسائية' : 'Women's beauty salons' }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('all-posts') }}" 
                       class="{{ $currentRoute == 'all-posts' ? 'active' : '' }}">
                        {{ app()->getLocale() == 'ar' ? 'المدونة' : 'Blog' }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('about_us') }}" 
                       class="{{ $currentRoute == 'about_us' ? 'active' : '' }}">
                        {{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact_us') }}" 
                       class="{{ $currentRoute == 'contact_us' ? 'active' : '' }}">
                        {{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}
                    </a>
                </li>
            </ul>
        </nav>
            
        <!-- Action Buttons Section - Right -->
        <div class="header-actions">
            <!-- User Profile Icon -->
            <a href="@auth('customer'){{ route('user-index.index') }}@else{{ route('login') }}@endauth" 
               class="header-profile-icon" 
               title="{{ app()->getLocale() == 'ar' ? 'الملف الشخصي' : 'User Profile' }}">
                <svg width="42" height="42" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M41.3499 50.05C39.1499 50.7 36.5499 51 33.4999 51H18.4999C15.4499 51 12.8499 50.7 10.6499 50.05C11.1999 43.55 17.8749 38.4249 25.9999 38.4249C34.1249 38.4249 40.7999 43.55 41.3499 50.05Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M33.5 1H18.5C6 1 1 6 1 18.5V33.5C1 42.95 3.85 48.125 10.65 50.05C11.2 43.55 17.875 38.4249 26 38.4249C34.125 38.4249 40.8 43.55 41.35 50.05C48.15 48.125 51 42.95 51 33.5V18.5C51 6 46 1 33.5 1ZM26 31.425C21.05 31.425 17.05 27.4 17.05 22.45C17.05 17.5 21.05 13.5 26 13.5C30.95 13.5 34.95 17.5 34.95 22.45C34.95 27.4 30.95 31.425 26 31.425Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M34.9499 22.45C34.9499 27.4 30.9499 31.425 25.9999 31.425C21.0499 31.425 17.0499 27.4 17.0499 22.45C17.0499 17.5 21.0499 13.5 25.9999 13.5C30.9499 13.5 34.9499 17.5 34.9499 22.45Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            
            <!-- Host Portal Button -->
            <a href="#" class="header-host-btn">
                {{ app()->getLocale() == 'ar' ? 'بوابة المضيف' : 'Host Portal' }}
            </a>
            
            <!-- Language Switcher -->
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale() == 'ar' ? 'en' : 'ar', null, [], true) }}" 
               class="header-lang-btn">
                <svg width="22" height="22" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.5 22.5C18.0228 22.5 22.5 18.0228 22.5 12.5C22.5 6.97715 18.0228 2.5 12.5 2.5C6.97715 2.5 2.5 6.97715 2.5 12.5C2.5 18.0228 6.97715 22.5 12.5 22.5Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.49998 3.5H9.49998C7.54998 9.34 7.54998 15.66 9.49998 21.5H8.49998" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15.5 3.5C17.45 9.34 17.45 15.66 15.5 21.5" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.5 16.5V15.5C9.34 17.45 15.66 17.45 21.5 15.5V16.5" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.5 9.49998C9.34 7.54998 15.66 7.54998 21.5 9.49998" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ app()->getLocale() == 'ar' ? 'EN' : 'AR' }}</span>
            </a>
                
            <!-- Mobile Menu Toggle -->
            <button class="header-menu-toggle" onclick="toggleMobileNav()" aria-label="Toggle Menu">
                <svg width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="19" height="4" rx="2" fill="#127652"/>
                    <rect y="9" width="28" height="4" rx="2" fill="#127652"/>
                    <rect y="18" width="12" height="4" rx="2" fill="#127652"/>
                </svg>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Navigation Overlay -->
<div class="header-overlay" id="headerOverlay" onclick="toggleMobileNav()"></div>

<!-- Mobile Side Navigation -->
<div class="header-side-nav" id="headerSideNav">
    <div class="header-side-nav-header">
        <button class="header-close-btn" onclick="toggleMobileNav()" aria-label="Close Menu">&times;</button>
    </div>
    
    <!-- Top buttons section -->
    <div class="header-side-nav-buttons">
        <a href="@auth('customer'){{ route('user-index.index') }}@else{{ route('login') }}@endauth" 
           class="header-profile-icon">
            <svg width="42" height="42" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M41.3499 50.05C39.1499 50.7 36.5499 51 33.4999 51H18.4999C15.4499 51 12.8499 50.7 10.6499 50.05C11.1999 43.55 17.8749 38.4249 25.9999 38.4249C34.1249 38.4249 40.7999 43.55 41.3499 50.05Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M33.5 1H18.5C6 1 1 6 1 18.5V33.5C1 42.95 3.85 48.125 10.65 50.05C11.2 43.55 17.875 38.4249 26 38.4249C34.125 38.4249 40.8 43.55 41.35 50.05C48.15 48.125 51 42.95 51 33.5V18.5C51 6 46 1 33.5 1ZM26 31.425C21.05 31.425 17.05 27.4 17.05 22.45C17.05 17.5 21.05 13.5 26 13.5C30.95 13.5 34.95 17.5 34.95 22.45C34.95 27.4 30.95 31.425 26 31.425Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M34.9499 22.45C34.9499 27.4 30.9499 31.425 25.9999 31.425C21.0499 31.425 17.0499 27.4 17.0499 22.45C17.0499 17.5 21.0499 13.5 25.9999 13.5C30.9499 13.5 34.9499 17.5 34.9499 22.45Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>{{ app()->getLocale() == 'ar' ? 'الملف الشخصي' : 'Profile' }}</span>
        </a>
        
        <a href="#" class="header-host-btn" style="width: 100%; justify-content: center;">
            {{ app()->getLocale() == 'ar' ? 'بوابة المضيف' : 'Host Portal' }}
        </a>
        
        <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale() == 'ar' ? 'en' : 'ar', null, [], true) }}" 
           class="header-lang-btn" style="width: 100%; justify-content: center;">
            <svg width="22" height="22" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.5 22.5C18.0228 22.5 22.5 18.0228 22.5 12.5C22.5 6.97715 18.0228 2.5 12.5 2.5C6.97715 2.5 2.5 6.97715 2.5 12.5C2.5 18.0228 6.97715 22.5 12.5 22.5Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.49998 3.5H9.49998C7.54998 9.34 7.54998 15.66 9.49998 21.5H8.49998" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M15.5 3.5C17.45 9.34 17.45 15.66 15.5 21.5" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3.5 16.5V15.5C9.34 17.45 15.66 17.45 21.5 15.5V16.5" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3.5 9.49998C9.34 7.54998 15.66 7.54998 21.5 9.49998" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>{{ app()->getLocale() == 'ar' ? 'English' : 'العربية' }}</span>
        </a>
    </div>
    
    <!-- Navigation Links -->
    <ul>
        <li><a href="{{ route('shaleek.home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
        <li><a href="{{ route('showAllChalet', ['category' => 1]) }}">{{ app()->getLocale() == 'ar' ? 'شقق، استوديوهات، غرف، فلل' : 'Flats, studios, rooms, villas' }}</a></li>
        <li><a href="{{ route('showAllChalet', ['category' => 2]) }}">{{ app()->getLocale() == 'ar' ? 'شاليهات، بيوت راحة، منتجعات' : 'Chalets, rest houses, resorts' }}</a></li>
        <li><a href="{{ route('showAllChalet', ['category' => 3]) }}">{{ app()->getLocale() == 'ar' ? 'مزارع' : 'Farms' }}</a></li>
        <li><a href="{{ route('showAllChalet', ['category' => 4]) }}">{{ app()->getLocale() == 'ar' ? 'مخيمات' : 'Camps' }}</a></li>
        <li><a href="{{ route('all-posts') }}">{{ app()->getLocale() == 'ar' ? 'المدونة' : 'Blog' }}</a></li>
        <li><a href="{{ route('about_us') }}">{{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}</a></li>
        <li><a href="{{ route('contact_us') }}">{{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}</a></li>
    </ul>
</div>

<!-- Mobile Navigation JavaScript -->
<script>
    function toggleMobileNav() {
        const overlay = document.getElementById('headerOverlay');
        const sideNav = document.getElementById('headerSideNav');
        
        if (overlay && sideNav) {
            overlay.classList.toggle('active');
            sideNav.classList.toggle('active');
            
            // Prevent body scroll when menu is open
            if (sideNav.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
    }
    
    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const sideNav = document.getElementById('headerSideNav');
            if (sideNav && sideNav.classList.contains('active')) {
                toggleMobileNav();
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991) {
            const overlay = document.getElementById('headerOverlay');
            const sideNav = document.getElementById('headerSideNav');
            
            if (overlay && sideNav) {
                overlay.classList.remove('active');
                sideNav.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });
</script>
