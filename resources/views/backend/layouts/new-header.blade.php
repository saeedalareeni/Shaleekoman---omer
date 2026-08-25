<!-- New Header with Working Dropdowns -->
<style>
    /* Header Styles */
    .admin-header {
        background: linear-gradient(to right, #14b024, #1e5c21);
        padding: 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
        z-index: 100;
    }
    
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        position: relative;
    }
    
    /* Logo */
    .logo-section a {
        color: white;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
    }
    
    .logo-section img {
        height: 40px;
        width: auto;
    }
    
    /* Navigation Menu */
    nav {
        overflow: visible !important;
    }
    
    .main-nav {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        align-items: center;
        overflow: visible !important;
    }
    
    .main-nav > li {
        position: relative;
        margin: 0 5px;
        overflow: visible !important;
    }
    
    .main-nav > li > a {
        color: white;
        padding: 10px 15px;
        display: block;
        text-decoration: none;
        border-radius: 4px;
        transition: background 0.3s;
    }
    
    .main-nav > li > a:hover {
        background: rgba(255,255,255,0.1);
    }
    
    /* Dropdown Menus */
    .dropdown-menu-custom {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        min-width: 220px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 10px 0;
        margin-top: 10px;
        display: none;
        z-index: 99999;
        overflow: visible !important;
    }
    
    .dropdown-menu-custom a {
        display: block;
        padding: 10px 20px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .dropdown-menu-custom a:hover {
        background: #f8f9fa;
        color: #14b024;
    }
    
    .dropdown-menu-custom .divider {
        height: 1px;
        background: #e9ecef;
        margin: 5px 0;
    }
    
    /* Show dropdown when active */
    .main-nav li.dropdown-active .dropdown-menu-custom {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }
    
    /* Arrow indicator */
    .has-dropdown > a::after {
        content: "▼";
        font-size: 10px;
        margin-left: 5px;
        display: inline-block;
        transition: transform 0.3s;
    }
    
    .has-dropdown.dropdown-active > a::after {
        transform: rotate(180deg);
    }
    
    /* User Menu */
    .user-menu {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .user-dropdown {
        position: relative;
    }
    
    .user-dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 4px;
        transition: background 0.3s;
    }
    
    .user-dropdown-toggle:hover {
        background: rgba(255,255,255,0.1);
    }
    
    .user-dropdown-toggle img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }
    
    .user-dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        min-width: 180px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-radius: 4px;
        padding: 5px 0;
        margin-top: 10px;
        display: none;
        z-index: 1000;
    }
    
    .user-dropdown.active .user-dropdown-menu {
        display: block;
    }
    
    /* Badges */
    .badge {
        display: inline-block;
        padding: 3px 8px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 10px;
        vertical-align: middle;
    }
    
    .badge-success {
        background: #28a745;
        color: white;
    }
    
    .badge-warning {
        background: #ffc107;
        color: #212529;
    }
    
    /* Language Switcher */
    .lang-switcher {
        display: flex;
        gap: 5px;
        background: rgba(255,255,255,0.2);
    }
    
    .lang-switcher-toggle {
        color: white;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 4px;
        transition: background 0.3s;
    }
    
    .lang-switcher-toggle:hover {
        background: rgba(255,255,255,0.1);
    }
    
    .lang-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        min-width: 120px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-radius: 4px;
        padding: 5px 0;
        margin-top: 10px;
        display: none;
        z-index: 1000;
    }
    
    .lang-switcher.active .lang-menu {
        display: block;
    }
    
    /* Mobile Toggle */
    .mobile-toggle {
        display: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .header-container {
            flex-wrap: wrap;
        }
        
        .main-nav {
            display: none;
            width: 100%;
            flex-direction: column;
            background: rgba(0,0,0,0.1);
            margin-top: 10px;
        }
        
        .main-nav.active {
            display: flex;
        }
        
        .main-nav > li {
            width: 100%;
            margin: 0;
        }
        
        .dropdown-menu-custom {
            position: static;
            width: 100%;
            box-shadow: none;
            background: rgba(0,0,0,0.05);
            margin: 0;
            padding-left: 20px;
        }
        
        .mobile-toggle {
            display: block;
        }
    }
</style>

<header class="admin-header">
    <div class="header-container">
        <!-- Logo -->
        <div class="logo-section">
            <a href="{{ route('dashboard.index') }}">
                @php
                    $setting = \App\Models\Setting::first();
                @endphp
                @if($setting && $setting->logo)
                    <img src="{{ asset($setting->logo) }}" alt="Logo">
                @else
                    {{ config('app.name', 'Admin Panel') }}
                @endif
            </a>
        </div>
        
        <!-- Mobile Toggle -->
        <div class="mobile-toggle" onclick="toggleMobileMenu()">
            ☰
        </div>
        
        <!-- Main Navigation -->
        <nav>
            <ul class="main-nav" id="mainNav">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-home"></i> {{ trans('back.dashboard') }}
                    </a>
                </li>
                
                <!-- Owners -->
                <li class="has-dropdown">
                    <a href="javascript:void(0)" onclick="toggleDropdown(event, this)">
                        <i class="fas fa-users"></i> {{ trans('back.owners') }}
                        @php
                            $newOwnersCount = \App\Models\Owner::where('created_at', '>=', now()->subDays(7))->count();
                        @endphp
                        @if($newOwnersCount > 0)
                            <span class="badge badge-success" style="margin-left: 5px;">{{ $newOwnersCount }} جديد</span>
                        @endif
                    </a>
                    <div class="dropdown-menu-custom" style="display: none;">
                        <a href="{{ route('owners.index') }}">
                            <i class="fas fa-list"></i> جميع المالكين
                        </a>
                        <a href="{{ route('owners.index') }}?filter=new">
                            <i class="fas fa-user-plus"></i> المالكين الجدد
                            @if($newOwnersCount > 0)
                                <span class="badge badge-success">{{ $newOwnersCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('owners.index') }}?filter=inactive">
                            <i class="fas fa-user-times"></i> غير المفعلين
                            @php
                                $inactiveCount = \App\Models\Owner::where('is_active', 0)->count();
                            @endphp
                            @if($inactiveCount > 0)
                                <span class="badge badge-warning">{{ $inactiveCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('owners.index') }}">
                            <i class="fas fa-plus-circle"></i> إضافة مالك جديد
                        </a>
                    </div>
                </li>
                
                <!-- Customers -->
                @can('customers')
                <li>
                    <a href="{{ route('customers.index') }}">
                        <i class="fas fa-user-friends"></i> {{ trans('back.customers') }}
                    </a>
                </li>
                @endcan
                
                <!-- Chalets Dropdown -->
                <li class="has-dropdown">
                    <a href="javascript:void(0)" onclick="toggleDropdown(event, this)">
                        <i class="fas fa-building"></i> {{ trans('back.chalets') }}
                    </a>
                    <div class="dropdown-menu-custom" style="display: none;">
                        <a href="{{ route('categories.index') }}">
                            <i class="fas fa-list"></i> {{ trans('back.categories') }}
                        </a>
                        <a href="{{ route('chalets.index') }}">
                            <i class="fas fa-home"></i> {{ trans('back.chalets') }}
                        </a>
                    </div>
                </li>
                
                <!-- Bookings -->
                <li>
                    <a href="{{ route('booking-customers.index') }}">
                        <i class="fas fa-calendar-check"></i> {{ trans('back.booking_customers') }}
                    </a>
                </li>
                
                <!-- Posts -->
                @can('posts')
                <li>
                    <a href="{{ route('posts.index') }}">
                        <i class="fas fa-newspaper"></i> {{ trans('back.posts') }}
                    </a>
                </li>
                @endcan
                
                <!-- Coupons -->
                @can('coupons')
                <li>
                    <a href="{{ route('coupons.index') }}">
                        <i class="fas fa-ticket-alt"></i> {{ trans('back.coupons') }}
                    </a>
                </li>
                @endcan
                
                <!-- Settings Dropdown -->
                <li class="has-dropdown">
                    <a href="javascript:void(0)" onclick="toggleDropdown(event, this)">
                        <i class="fas fa-cog"></i> {{ trans('back.setting') }}
                    </a>
                    <div class="dropdown-menu-custom" style="display: none;">
                        <a href="{{ route('cities.index') }}">
                            <i class="fas fa-city"></i> {{ trans('back.cities') }}
                        </a>
                        <a href="{{ route('areas.index') }}">
                            <i class="fas fa-map-marker-alt"></i> {{ trans('back.areas') }}
                        </a>
                        <a href="{{ route('banners.index') }}">
                            <i class="fas fa-image"></i> {{ trans('back.banners') }}
                        </a>
                        <a href="{{ route('users.index') }}">
                            <i class="fas fa-users-cog"></i> {{ trans('back.users') }}
                        </a>
                        <a href="{{ route('paymentsMethod.index') }}">
                            <i class="fas fa-credit-card"></i> {{ trans('back.payment_methods') }}
                        </a>
                        <a href="{{ route('roles.index') }}">
                            <i class="fas fa-user-shield"></i> {{ trans('back.roles') }}
                        </a>
                        <div class="divider"></div>
                        <a href="{{ route('setting.index') }}">
                            <i class="fas fa-cogs"></i> {{ trans('back.setting') }}
                        </a>
                    </div>
                </li>
                
                <!-- About Us Dropdown -->
                <li class="has-dropdown">
                    <a href="javascript:void(0)" onclick="toggleDropdown(event, this)">
                        <i class="fas fa-info-circle"></i> {{ trans('back.about_us') }}
                    </a>
                    <div class="dropdown-menu-custom" style="display: none;">
                        <a href="{{ route('sliders.index') }}">
                            <i class="fas fa-images"></i> {{ trans('back.sliders') }}
                        </a>
                        <a href="{{ route('abouts.index') }}">
                            <i class="fas fa-address-card"></i> {{ trans('back.about_us') }}
                        </a>
                        <a href="{{ route('Infos.index') }}">
                            <i class="fas fa-info"></i> {{ trans('back.info') }}
                        </a>
                        <a href="{{ route('contacts.index') }}">
                            <i class="fas fa-envelope"></i> {{ trans('back.contact_us') }}
                        </a>
                        <a href="{{ route('pages.index') }}">
                            <i class="fas fa-file-alt"></i> {{ trans('back.pages') }}
                        </a>
                        <div class="divider"></div>
                        <a href="{{ route('posts.index') }}">
                            <i class="fas fa-blog"></i> {{ trans('back.posts') }}
                        </a>
                        <a href="{{ url(LaravelLocalization::getCurrentLocale() . '/faqs') }}">
                            <i class="fas fa-question-circle"></i> {{ trans('back.faqs') }}
                        </a>
                        <a href="{{ url(LaravelLocalization::getCurrentLocale() . '/terms') }}">
                            <i class="fas fa-gavel"></i> {{ trans('back.terms') }}
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        
        <!-- User Menu -->
        <div class="user-menu">
            <!-- Language Switcher -->
            <div class="lang-switcher" onclick="toggleLangMenu(this)">
                <div class="lang-switcher-toggle">
                    <i class="fas fa-globe"></i>
                    {{ LaravelLocalization::getCurrentLocaleName() }}
                </div>
                <div class="lang-menu">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" style="display: block; padding: 8px 15px; color: #333; text-decoration: none;">
                        {{ $properties['native'] }}
                    </a>
                    @endforeach
                </div>
            </div>
            
            <!-- User Dropdown -->
            @if(auth()->check())
            <div class="user-dropdown" onclick="toggleUserMenu(this)">
                <div class="user-dropdown-toggle">
                    <img src="{{ asset('backend/avatar.png') }}" alt="User">
                    <span>{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="user-dropdown-menu">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="javascript:void(0)" onclick="this.closest('form').submit()" style="display: block; padding: 10px 20px; color: #333; text-decoration: none;">
                            <i class="fas fa-sign-out-alt"></i> {{ trans('back.Logout') }}
                        </a>
                    </form>
                </div>
            </div>
            @else
            <div class="user-dropdown">
                <a href="{{ route('login') }}" style="display: block; padding: 10px 20px; color: #333; text-decoration: none;">
                    <i class="fas fa-sign-in-alt"></i> {{ trans('back.Login') }}
                </a>
            </div>
            @endif
        </div>
    </div>
</header>

<script>
// Toggle dropdown menu
function toggleDropdown(event, element) {
    event.preventDefault();
    event.stopPropagation();
    
    var parent = element.parentElement;
    var wasActive = parent.classList.contains('dropdown-active');
    
    // Close all other dropdowns
    document.querySelectorAll('.main-nav .has-dropdown').forEach(function(item) {
        item.classList.remove('dropdown-active');
        var menu = item.querySelector('.dropdown-menu-custom');
        if (menu) {
            menu.style.display = 'none';
        }
    });
    
    // Toggle current dropdown
    if (!wasActive) {
        parent.classList.add('dropdown-active');
        
        // Force display the dropdown menu
        var dropdownMenu = parent.querySelector('.dropdown-menu-custom');
        if (dropdownMenu) {
            dropdownMenu.style.display = 'block';
            dropdownMenu.style.opacity = '1';
            dropdownMenu.style.visibility = 'visible';
        }
    }
}

// Toggle mobile menu
function toggleMobileMenu() {
    var nav = document.getElementById('mainNav');
    nav.classList.toggle('active');
}

// Toggle user menu
function toggleUserMenu(element) {
    element.classList.toggle('active');
    
    // Close other menus
    document.querySelectorAll('.lang-switcher').forEach(function(el) {
        el.classList.remove('active');
    });
}

// Toggle language menu
function toggleLangMenu(element) {
    element.classList.toggle('active');
    
    // Close other menus
    document.querySelectorAll('.user-dropdown').forEach(function(el) {
        el.classList.remove('active');
    });
}

// Close menus when clicking outside
document.addEventListener('click', function(e) {
    // Close navigation dropdowns
    if (!e.target.closest('.has-dropdown')) {
        document.querySelectorAll('.main-nav .has-dropdown').forEach(function(item) {
            item.classList.remove('dropdown-active');
        });
    }
    
    // Close user and language menus
    if (!e.target.closest('.user-dropdown') && !e.target.closest('.lang-switcher')) {
        document.querySelectorAll('.user-dropdown, .lang-switcher').forEach(function(el) {
            el.classList.remove('active');
        });
    }
});

// Prevent closing when clicking inside dropdown menus
document.querySelectorAll('.dropdown-menu-custom').forEach(function(menu) {
    menu.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});

// Prevent closing when clicking inside user/lang menus
document.querySelectorAll('.user-dropdown, .lang-switcher').forEach(function(el) {
    el.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});
</script>
