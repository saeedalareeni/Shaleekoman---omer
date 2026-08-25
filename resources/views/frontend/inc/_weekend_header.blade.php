@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
@endphp

<!-- Header Fix CSS -->
<link rel="stylesheet" href="{{ asset('frontend/css/header-fix.css') }}">

<!-- Custom Dropdown Styles -->
<style>
    /* Enhanced Mobile Header Styles */
    @media (max-width: 768px) {
        .main-header {
            padding: 0.75rem !important;
            margin: 0.5rem !important;
            border-width: 1.5px !important;
            background: linear-gradient(135deg, #e3f0e9 0%, #f0f8f5 100%) !important;
            box-shadow: 0 2px 10px rgba(18, 118, 100, 0.1) !important;
        }

        /* Mobile Header Grid Layout */
        .main-header .container-fluid {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 0.5rem !important;
            padding: 0 !important;
        }

        /* Logo Section */
        .logo {
            flex: 0 0 auto !important;
            order: 1 !important;
        }

        /* Action Buttons Container */
        .action-buttons {
            flex: 1 1 auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 0.4rem !important;
            order: 2 !important;
        }

        /* Notification Icon Styling */
        .notification-trigger {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 36px !important;
            height: 36px !important;
            border-radius: 10px !important;
            background: white !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08) !important;
            transition: all 0.3s ease !important;
        }

        .notification-trigger:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 10px rgba(18, 118, 100, 0.2) !important;
        }

        .notification-trigger svg {
            width: 24px !important;
            height: 24px !important;
        }

        /* Notification Badge */
        .notification-badge {
            position: absolute !important;
            top: -5px !important;
            right: -5px !important;
            min-width: 18px !important;
            height: 18px !important;
            padding: 0 4px !important;
            font-size: 10px !important;
            animation: pulse 2s infinite !important;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* User Profile Button */
        #userDropdown {
            background: white !important;
            border-radius: 10px !important;
            padding: 4px 8px !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08) !important;
            transition: all 0.3s ease !important;
        }

        #userDropdown:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 10px rgba(18, 118, 100, 0.2) !important;
        }

        #userDropdown img {
            width: 28px !important;
            height: 28px !important;
            border: 2px solid #e3f0e9 !important;
        }

        #userDropdown h6 {
            display: none !important;
        }

        #userDropdown p {
            display: none !important;
        }

        #userDropdown > span:last-child {
            display: none !important;
        }

        /* Host Portal Button */
        .host-portal-btn {
            padding: 6px 10px !important;
            font-size: 0.7rem !important;
            height: 36px !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
            background: linear-gradient(135deg, #127664 0%, #0a5c4a 100%) !important;
            border: none !important;
            box-shadow: 0 2px 6px rgba(18, 118, 100, 0.2) !important;
            transition: all 0.3s ease !important;
        }

        .host-portal-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 10px rgba(18, 118, 100, 0.3) !important;
        }

        /* Language Switcher */
        .lang-switcher {
            padding: 6px 8px !important;
            height: 36px !important;
            border-radius: 10px !important;
            background: white !important;
            border: 1.5px solid #e0e0e0 !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05) !important;
            transition: all 0.3s ease !important;
        }

        .lang-switcher:hover {
            border-color: #127664 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 10px rgba(18, 118, 100, 0.15) !important;
        }

        .lang-switcher svg {
            width: 18px !important;
            height: 18px !important;
        }

        .lang-switcher span {
            font-size: 0.7rem !important;
            font-weight: 600 !important;
        }

        /* Menu Toggle Button */
        .menu-toggle {
            width: 36px !important;
            height: 36px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 10px !important;
            background: white !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08) !important;
            transition: all 0.3s ease !important;
        }

        .menu-toggle:hover {
            background: #f8f9fa !important;
            transform: rotate(90deg) !important;
        }

        .menu-toggle svg {
            width: 20px !important;
            height: 20px !important;
        }
    }

    @media (max-width: 480px) {
        .main-header {
            padding: 0.5rem 0.6rem !important;
            margin: 0.3rem !important;
            border-width: 1px !important;
            border-radius: 1.2rem !important;
        }

        /* Logo for small screens */
        .logo img {
            height: 32px !important;
            max-width: 110px !important;
        }

        /* Compact buttons for very small screens */
        .notification-trigger,
        #userDropdown,
        .host-portal-btn,
        .lang-switcher,
        .menu-toggle {
            width: 34px !important;
            height: 34px !important;
            padding: 0 !important;
            border-radius: 8px !important;
        }

        .notification-trigger svg {
            width: 20px !important;
            height: 20px !important;
        }

        #userDropdown img {
            width: 26px !important;
            height: 26px !important;
        }

        .host-portal-btn {
            min-width: 34px !important;
        }

        .host-portal-btn span:not(:has(svg)) {
          /*  display: none !important;*/
        }

        .host-portal-btn svg {
            width: 18px !important;
            height: 18px !important;
        }

        .lang-switcher span:last-child {
            display: none !important;
        }

        .lang-switcher svg {
            width: 16px !important;
            height: 16px !important;
        }

        .menu-toggle svg {
            width: 18px !important;
            height: 18px !important;
        }

        .action-buttons {
            gap: 0.25rem !important;
        }

        /* Notification badge for small screens */
        .notification-badge {
            width: 16px !important;
            height: 16px !important;
            font-size: 9px !important;
            top: -3px !important;
            right: -3px !important;
            border-width: 1.5px !important;
        }
    }

    @media (max-width: 360px) {
        .main-header {
            padding: 0.4rem 0.5rem !important;
            margin: 0.25rem !important;
        }

        .logo img {
            height: 28px !important;
            max-width: 90px !important;
        }

        .notification-trigger,
        #userDropdown,
        .host-portal-btn,
        .lang-switcher,
        .menu-toggle {
            width: 30px !important;
            height: 30px !important;
        }

        .notification-trigger svg {
            width: 18px !important;
            height: 18px !important;
        }

        #userDropdown img {
            width: 24px !important;
            height: 24px !important;
        }

        .action-buttons {
            gap: 0.2rem !important;
        }
    }
    /* Force Logo Display on All Screen Sizes */
    .logo {
        display: flex !important;
        align-items: center !important;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
        z-index: 10 !important;
    }

    /* Dropdown Menus Mobile Optimization */
    @media (max-width: 768px) {
        /* Notifications Dropdown */
        #notificationsDropdown {
            position: fixed !important;
            top: 70px !important;
            left: 10px !important;
            right: 10px !important;
            width: auto !important;
            max-width: none !important;
            min-width: auto !important;
            max-height: 70vh !important;
            border-radius: 15px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
            animation: slideDown 0.3s ease !important;
        }

        /* User Dropdown Menu */
        #userDropdownMenu {
            position: fixed !important;
            top: 70px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            width: 90% !important;
            max-width: 300px !important;
            border-radius: 15px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
            animation: slideDown 0.3s ease !important;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px) translateX(-50%);
            }
            to {
                opacity: 1;
                transform: translateY(0) translateX(-50%);
            }
        }

        /* Dropdown items mobile */
        .dropdown-item {
            padding: 12px 20px !important;
            font-size: 14px !important;
        }
    }

    /* Active states for mobile buttons */
    @media (max-width: 768px) {
        .notification-trigger:active,
        #userDropdown:active,
        .host-portal-btn:active,
        .lang-switcher:active,
        .menu-toggle:active {
            transform: scale(0.95) !important;
        }
    }

    /* Smooth transitions for all interactive elements */
    .notification-trigger,
    #userDropdown,
    .host-portal-btn,
    .lang-switcher,
    .menu-toggle {
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
    }

    .logo a {
        display: inline-block !important;
        line-height: 0 !important;
    }

    .logo img {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: 45px;
        width: auto;
        max-width: 180px;
        object-fit: contain;
    }

    /* Prevent header overflow but allow dropdowns */
    header {
        overflow: visible !important;
        position: relative !important;
    }

    header .container-fluid {
        overflow: visible !important;
        display: grid;
        align-items: center;
    }

    /* Mobile specific adjustments */
    @media (max-width: 991px) {
        header .container-fluid {
            grid-template-columns: auto 1fr !important;
            gap: 0.5rem !important;
            align-items: center !important;
            padding: 0 !important;
        }

        .main-nav {
            display: none !important;
        }

        .logo {
            flex-shrink: 0;
        }

        .action-buttons {
            display: flex !important;
            justify-content: flex-end !important;
            align-items: center !important;
            flex-wrap: nowrap !important;
            gap: 0.3rem !important;
        }
    }

    @media (max-width: 768px) {
        header {
            padding: 0.5rem !important;
            margin: 0.5rem !important;
            border-radius: 1.5rem !important;
        }

        .logo img {
            height: 35px;
            max-width: 120px;
        }

        .action-buttons {
            gap: 0.25rem !important;
        }

        .action-buttons .btn {
            padding: 5px 8px !important;
            font-size: 0.75rem !important;
            white-space: nowrap !important;
            height: 32px !important;
        }

        /* Hide text in buttons, show only icons */
        .action-buttons .btn span:not(:has(svg)) {
          /*  display: none !important;*/
        }

        /* User dropdown adjustments */
        .action-buttons .dropdown h6 {
            font-size: 0.8rem !important;
        }

        .action-buttons .dropdown p {
            display: none !important;
        }

        .action-buttons .dropdown img {
            width: 32px !important;
            height: 32px !important;
        }
    }

    @media (max-width: 480px) {
        header {
            padding: 0.4rem !important;
            margin: 0.4rem !important;
            border-radius: 1.2rem !important;
        }

        header .container-fluid {
            gap: 0.3rem !important;
        }

        .logo img {
            height: 30px;
            max-width: 100px;
        }

        .action-buttons .btn {
            padding: 4px 6px !important;
            font-size: 0.7rem !important;
            height: 28px !important;
        }

        /* Show only icons in buttons on very small screens */
        .action-buttons .btn span:not(:has(svg)) {
           /* display: none !important;*/
        }

        .action-buttons .btn svg {
            width: 16px !important;
            height: 16px !important;
        }

        /* Keep menu toggle visible */
        .menu-toggle {
            display: block !important;
            padding: 4px !important;
        }

        .menu-toggle svg {
            width: 24px !important;
            height: 18px !important;
        }
    }

    @media (max-width: 360px) {
        header {
            padding: 0.3rem !important;
            margin: 0.3rem !important;
        }

        .logo img {
            height: 28px;
            max-width: 85px;
        }

        .action-buttons {
            gap: 0.2rem !important;
        }

        .action-buttons .btn {
            padding: 3px 5px !important;
            height: 26px !important;
        }

        .action-buttons .dropdown img {
            width: 28px !important;
            height: 28px !important;
        }

        .menu-toggle svg {
            width: 22px !important;
            height: 16px !important;
        }
    }

    /* Custom dropdown menu styles */
    #userDropdownMenu {
        display: none;
        min-width: 200px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #e0e0e0;
        padding: 8px 0;
        margin-top: 10px !important;
        background: white !important;
        z-index: 9999 !important;
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        list-style: none !important;
    }

    #userDropdownMenu.show {
        display: block !important;
    }

    #userDropdownMenu li {
        list-style: none !important;
        margin: 0;
        padding: 0;
    }

    #userDropdownMenu .dropdown-item {
        display: flex !important;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        color: #333;
        text-decoration: none;
        transition: background 0.2s;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        color: #127664;
    }

    .dropdown-divider {
        margin: 8px 0;
    }

    /* Ensure dropdown container has relative position */
    .dropdown {
        position: relative !important;
    }
</style>

    <header style="background-color: #e3f0e9; border: 2px solid #127664; border-radius: 2rem; padding: 1rem 2.5rem; margin: 1rem; overflow: visible;" class="main-header">
        <div class="container-fluid" style="max-width: 100%; margin: 0 auto; display: grid; grid-template-columns: {{ app()->getLocale() == 'ar' ? 'auto 1fr auto' : 'auto 1fr auto' }}; align-items: center; gap: 2rem; padding: 0; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            <!-- Logo Section -->
            <div class="logo" style="display: flex; align-items: center;">
                <a href="{{ route('shaleek.home') }}">
                    <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="{{ $siteName ?? 'shaleek' }}" style="height: 45px; width: auto; display: block;">
                </a>
            </div>

            <!-- Navigation Section - Center -->
            <nav class="main-nav d-none d-lg-flex" style="justify-content: center; align-items: center;">
                <ul style="display: flex; align-items: center; list-style: none; margin-bottom: 0; gap: 1.8rem; padding: 0; flex-wrap: nowrap;">
                    @php
                        $currentRoute = request()->route()->getName();
                        $currentCategory = request()->get('category');
                    @endphp
                    <li>
                        <a href="{{ route('shaleek.home') }}"
                           style="color: #127664; text-decoration: none; font-weight: {{ $currentRoute == 'shaleek.home' ? '700' : '500' }}; font-size: 0.95rem; white-space: nowrap; padding: 8px 12px; border-radius: 8px; transition: all 0.3s; position: relative;">
                            {{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}
                            @if($currentRoute == 'shaleek.home')
                                <span style="position: absolute; bottom: 0; left: 12px; right: 12px; height: 2px; background: #127664;"></span>
                            @endif
                        </a>
                    </li>
                    @foreach($headerCategories ?? [] as $category)
                    <li>
                        <a href="{{ route('showAllChalet', ['category' => $category->id]) }}"
                           style="color: #127664; text-decoration: none; font-weight: {{ $currentRoute == 'showAllChalet' && $currentCategory == $category->id ? '700' : '500' }}; font-size: 0.95rem; white-space: nowrap; padding: 8px 12px; border-radius: 8px; transition: all 0.3s; position: relative;">
                            {{ $category->name }}
                            @if($currentRoute == 'showAllChalet' && $currentCategory == $category->id)
                                <span style="position: absolute; bottom: 0; left: 12px; right: 12px; height: 2px; background: #127664;"></span>
                            @endif
                        </a>
                    </li>
                    @endforeach
                    <li>
                        <a href="{{ route('all-posts') }}"
                           style="color: #127664; text-decoration: none; font-weight: {{ $currentRoute == 'all-posts' ? '700' : '500' }}; font-size: 0.95rem; white-space: nowrap; padding: 8px 12px; border-radius: 8px; transition: all 0.3s; position: relative;">
                            {{ app()->getLocale() == 'ar' ? 'المدونة' : 'Blog' }}
                            @if($currentRoute == 'all-posts')
                                <span style="position: absolute; bottom: 0; left: 12px; right: 12px; height: 2px; background: #127664;"></span>
                            @endif
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Action Buttons Section - Right -->
            <div class="action-buttons d-flex align-items-center" style="gap: 0.5rem; flex-direction: row; justify-content: flex-end;">
                <!-- User Profile Section -->
                @auth('customer')
                    @php
                        $unreadCount = \App\Models\CustomerNotification::where('customer_id', auth('customer')->user()->id)
                            ->where('is_read', false)
                            ->count();
                    @endphp

                    <!-- Notifications Icon -->
                    <div class="dropdown notification-dropdown" style="position: relative; z-index: 1000; order: 1;">
                        <a href="#" onclick="toggleNotificationsDropdown(event)" class="d-inline-flex align-items-center justify-content-center notification-trigger" title="Notifications" style="text-decoration: none; padding: 5px; border-radius: 12px; transition: all 0.3s; position: relative;">
                            <svg width="42" height="42" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M26 6C21.0826 6 17 10.0826 17 15V20.382C17 21.7607 16.428 23.0609 15.4142 23.9749L13.5858 25.8033C11.8457 27.5434 11.8457 30.4566 13.5858 32.1967C14.3668 32.9777 15.4344 33.4142 16.5 33.4142H35.5C36.5656 33.4142 37.6332 32.9777 38.4142 32.1967C40.1543 30.4566 40.1543 27.5434 38.4142 25.8033L36.5858 23.9749C35.572 23.0609 35 21.7607 35 20.382V15C35 10.0826 30.9174 6 26 6Z" fill="#127664" stroke="white" stroke-width="2"/>
                                <path d="M22 33V35C22 37.2091 23.7909 39 26 39C28.2091 39 30 37.2091 30 35V33" stroke="#127664" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            @if($unreadCount > 0)
                                <span class="notification-badge" style="position: absolute; top: 0; right: 0; background: #dc3545; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; border: 2px solid white;">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </a>

                        <!-- Notifications Dropdown -->
                        <ul id="notificationsDropdown" class="dropdown-menu" style="display: none; position: absolute; top: 100%; {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 0; margin-top: 10px; min-width: 320px; max-width: 400px; background: white; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); padding: 0; z-index: 1000; max-height: 400px; overflow-y: auto;">
                            <li style="padding: 15px; border-bottom: 1px solid #eee;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ __('الإشعارات') }}</h6>
                                    @if($unreadCount > 0)
                                        <span class="badge bg-danger">{{ $unreadCount }} {{ __('جديد') }}</span>
                                    @endif
                                </div>
                            </li>

                            @php
                                $recentNotifications = \App\Models\CustomerNotification::where('customer_id', auth('customer')->user()->id)
                                    ->orderBy('created_at', 'desc')
                                    ->limit(5)
                                    ->get();
                            @endphp

                            @if($recentNotifications->count() > 0)
                                @foreach($recentNotifications as $notification)
                                    <li style="padding: 10px 15px; border-bottom: 1px solid #f0f0f0; {{ !$notification->is_read ? 'background-color: #f8f9fa;' : '' }}">
                                        <a href="{{ route('account.orders') }}#notifications" style="text-decoration: none; color: inherit;">
                                            <div class="d-flex align-items-start">
                                                <div class="me-2" style="color: {{ $notification->icon_color }}">
                                                    <i class="{{ $notification->icon_class }}"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1" style="font-size: 14px;">{{ $notification->title }}</h6>
                                                    <p class="mb-1 text-muted" style="font-size: 12px;">{{ Str::limit($notification->message, 50) }}</p>
                                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach

                                <li style="padding: 10px 15px; text-align: center;">
                                    <a href="{{ route('account.orders') }}#notifications" class="btn btn-sm btn-primary">{{ __('عرض جميع الإشعارات') }}</a>
                                </li>
                            @else
                                <li style="padding: 30px 15px; text-align: center;">
                                    <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">{{ __('لا توجد إشعارات') }}</p>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- User Dropdown -->
                    <div class="dropdown user-dropdown" style="position: relative; z-index: 1000; order: 2;">
                        <a class="d-flex align-items-center gap-2 text-decoration-none" href="javascript:void(0)" role="button" id="userDropdown" onclick="toggleDropdown(event)" style="cursor: pointer; position: relative; z-index: 1001; padding: 5px; border-radius: 8px; transition: all 0.3s;">
                            <div>
                                @php
                                    $user = auth('customer')->user();
                                    $avatarUrl = asset('avatar.png'); // Default avatar

                                    if ($user) {
                                        if (!empty($user->avatar)) {
                                            // Check if avatar is a full URL or just a filename
                                            if (filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                                                $avatarUrl = $user->avatar;
                                            } elseif (file_exists(public_path('storage/' . $user->avatar))) {
                                                $avatarUrl = asset('storage/' . $user->avatar);
                                            } elseif (file_exists(public_path($user->avatar))) {
                                                $avatarUrl = asset($user->avatar);
                                            }
                                        } elseif (!empty($user->image)) {
                                            // Try 'image' field if 'avatar' is empty
                                            if (filter_var($user->image, FILTER_VALIDATE_URL)) {
                                                $avatarUrl = $user->image;
                                            } elseif (file_exists(public_path('storage/' . $user->image))) {
                                                $avatarUrl = asset('storage/' . $user->image);
                                            } elseif (file_exists(public_path($user->image))) {
                                                $avatarUrl = asset($user->image);
                                            }
                                        } elseif (!empty($user->profile_image)) {
                                            // Try 'profile_image' field
                                            if (filter_var($user->profile_image, FILTER_VALIDATE_URL)) {
                                                $avatarUrl = $user->profile_image;
                                            } elseif (file_exists(public_path('storage/' . $user->profile_image))) {
                                                $avatarUrl = asset('storage/' . $user->profile_image);
                                            } elseif (file_exists(public_path($user->profile_image))) {
                                                $avatarUrl = asset($user->profile_image);
                                            }
                                        }
                                    }
                                @endphp
                                <img src="{{ $avatarUrl }}" alt="user" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                            </div>
                            <div>
                                <h6 style="color: #127664; font-weight: 600; margin: 0; font-size: 0.9rem; line-height: 1.2;">{{ explode(' ', auth('customer')->user()->name)[0] }}</h6>
                                <p style="margin: 0; color: #666; font-size: 0.75rem;">{{ app()->getLocale() == 'ar' ? 'مستخدم' : 'User' }}</p>
                            </div>
                            <span style="{{ app()->getLocale() == 'ar' ? 'margin-right: 5px;' : 'margin-left: 5px;' }}">
                                <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 0.49585C1.10044 0.49585 1.19798 0.525816 1.28027 0.580811L1.35645 0.643311L4.64648 3.94312L5 4.29761L5.35352 3.94312L8.62109 0.674561C8.71588 0.595868 8.83668 0.555541 8.95996 0.560303C9.0857 0.565169 9.20493 0.616885 9.29395 0.705811C9.3829 0.794766 9.43548 0.914096 9.44043 1.03979C9.44519 1.16302 9.40284 1.28292 9.32422 1.37769L5.34766 5.35522C5.25456 5.44738 5.12905 5.4992 4.99805 5.49976H4.99707C4.93142 5.50011 4.86646 5.48744 4.80566 5.46265C4.77524 5.45022 4.74603 5.43479 4.71875 5.41675L4.64258 5.35522L0.643555 1.3562C0.549135 1.26168 0.496094 1.13336 0.496094 0.999756C0.496143 0.866129 0.549063 0.737803 0.643555 0.643311C0.738046 0.548819 0.866373 0.495899 1 0.49585Z" fill="#A098AE" stroke="#A098AE"/>
                                </svg>
                            </span>
                        </a>
                        <ul id="userDropdownMenu" style="display: none; position: absolute; top: 100%; {{ app()->getLocale() == 'ar' ? 'left: 0;' : 'right: 0;' }} min-width: 200px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 1px solid #e0e0e0; padding: 8px 0; z-index: 9999; margin-top: 10px; list-style: none;">
                            <li>
                                <a class="dropdown-item" href="{{ route('account.orders') }}#profile">
                                    <i class="fa fa-user" style="width: 20px; color: #127664;"></i>
                                    <span>{{ trans('back.profile') }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('account.orders') }}#bookings">
                                    <i class="fa fa-calendar" style="width: 20px; color: #127664;"></i>
                                    <span>{{ trans('back.My_booking') }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('account.orders') }}#wishlist">
                                    <i class="fa fa-heart" style="width: 20px; color: #127664;"></i>
                                    <span>{{ trans('back.wishlist') }}</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('customer_logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #dc3545;">
                                        <i class="fa fa-power-off" style="width: 20px;"></i>
                                        <span>{{ trans('back.Logout') }}</span>
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Login Icon for non-logged users -->
                    <a href="{{ route('login') }}" class="d-inline-flex align-items-center justify-content-center" title="Login" style="text-decoration: none; padding: 5px; border-radius: 50%; transition: all 0.3s; order: 3; ">
                        <svg width="42" height="42" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M41.3499 50.05C39.1499 50.7 36.5499 51 33.4999 51H18.4999C15.4499 51 12.8499 50.7 10.6499 50.05C11.1999 43.55 17.8749 38.4249 25.9999 38.4249C34.1249 38.4249 40.7999 43.55 41.3499 50.05Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M33.5 1H18.5C6 1 1 6 1 18.5V33.5C1 42.95 3.85 48.125 10.65 50.05C11.2 43.55 17.875 38.4249 26 38.4249C34.125 38.4249 40.8 43.55 41.35 50.05C48.15 48.125 51 42.95 51 33.5V18.5C51 6 46 1 33.5 1ZM26 31.425C21.05 31.425 17.05 27.4 17.05 22.45C17.05 17.5 21.05 13.5 26 13.5C30.95 13.5 34.95 17.5 34.95 22.45C34.95 27.4 30.95 31.425 26 31.425Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M34.9499 22.45C34.9499 27.4 30.9499 31.425 25.9999 31.425C21.0499 31.425 17.0499 27.4 17.0499 22.45C17.0499 17.5 21.0499 13.5 25.9999 13.5C30.9499 13.5 34.9499 17.5 34.9499 22.45Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                @endauth


                <!-- Register -->
                @guest('customer')
                <a href="{{ LaravelLocalization::localizeUrl('/login') }}" class="btn btn-sm " style="background-color: #EB5432 !important;; color: white; border: 2px solid #EB5432; border-radius: 10px; padding: 8px 20px; font-weight: 600; text-decoration: none; white-space: nowrap; transition: all 0.3s; height: 38px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem; order: 3;">
                        <span class=" d-sm-inline">{{ app()->getLocale() == 'ar' ? 'دخول المستخدمين' : 'User login' }}</span>
{{--                    <svg class="d-sm-none" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                        <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                    </svg>--}}
                </a>
                @endguest

                <!-- Add property Button -->
                <a href="{{ LaravelLocalization::localizeUrl('/owner/login') }}" class="btn btn-sm " style="background: #127664; color: white; border: 2px solid #127664; border-radius: 10px; padding: 8px 16px; font-weight: 500; text-decoration: none; white-space: nowrap; transition: all 0.3s; height: 38px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem; order: 3;">
                        <span class=" d-sm-inline">{{ app()->getLocale() == 'ar' ? 'أضف عقارك' : 'Add your property' }}</span>
{{--                    <svg class="d-sm-none" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                        <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                    </svg>--}}
                </a>

                <!-- Language Switcher -->
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale() == 'ar' ? 'en' : 'ar', null, [], true) }}" class="btn btn-sm d-flex align-items-center lang-switcher" style="background: #f8f9fa; color: #333; border: 2px solid #d8dbdd; border-radius: 10px; padding: 8px 12px; font-weight: 500; text-decoration: none; gap: 6px; transition: all 0.3s; height: 38px; white-space: nowrap; order: 4;">
                    <svg width="20" height="20" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5 22.5C18.0228 22.5 22.5 18.0228 22.5 12.5C22.5 6.97715 18.0228 2.5 12.5 2.5C6.97715 2.5 2.5 6.97715 2.5 12.5C2.5 18.0228 6.97715 22.5 12.5 22.5Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8.49998 3.5H9.49998C7.54998 9.34 7.54998 15.66 9.49998 21.5H8.49998" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M15.5 3.5C17.45 9.34 17.45 15.66 15.5 21.5" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.5 16.5V15.5C9.34 17.45 15.66 17.45 21.5 15.5V16.5" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.5 9.49998C9.34 7.54998 15.66 7.54998 21.5 9.49998" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span style="font-size: 0.85rem; min-width: 20px;">{{ app()->getLocale() == 'ar' ? 'EN' : 'AR' }}</span>
                </a>

                    <!-- Mobile Menu Toggle -->
                    <button class="menu-toggle d-lg-none" onclick="toggleSideNav()" style="background: transparent; border: none; padding: 8px; cursor: pointer; order: 5;">
                        <svg width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="19" height="4" rx="2" fill="#127652"/>
                            <rect y="9" width="28" height="4" rx="2" fill="#127652"/>
                            <rect y="18" width="12" height="4" rx="2" fill="#127652"/>
                        </svg>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <script>
        // Force logo visibility on page load and resize
        document.addEventListener('DOMContentLoaded', function() {
            // Check if logo exists and force display
            const logo = document.querySelector('.logo img');
            if (logo) {
                logo.style.display = 'block';
                logo.style.visibility = 'visible';
                logo.style.opacity = '1';

                // Check parent elements
                let parent = logo.parentElement;
                while (parent && parent !== document.body) {
                    if (parent.classList.contains('logo')) {
                        parent.style.display = 'flex';
                        parent.style.visibility = 'visible';
                        parent.style.opacity = '1';
                    }
                    parent = parent.parentElement;
                }
            }
        });

        // Re-check on window resize
        window.addEventListener('resize', function() {
            const logo = document.querySelector('.logo img');
            if (logo && window.innerWidth <= 768) {
                logo.style.display = 'block';
                logo.style.visibility = 'visible';
                logo.style.opacity = '1';
            }
        });

        // Pure JavaScript dropdown implementation
        window.toggleDropdown = function(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            console.log('Toggle dropdown clicked');

            var dropdownMenu = document.getElementById('userDropdownMenu');
            var notificationsDropdown = document.getElementById('notificationsDropdown');

            if (dropdownMenu) {
                console.log('Current display:', dropdownMenu.style.display);

                // Close notifications dropdown if open
                if (notificationsDropdown) {
                    notificationsDropdown.style.display = 'none';
                }

                // Simple toggle
                if (dropdownMenu.style.display === 'block') {
                    dropdownMenu.style.display = 'none';
                    console.log('Dropdown hidden');
                } else {
                    dropdownMenu.style.display = 'block';
                    console.log('Dropdown shown');
                }
            } else {
                console.log('Dropdown menu not found!');
            }

            return false;
        }

        // Toggle notifications dropdown
        window.toggleNotificationsDropdown = function(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            var notificationsDropdown = document.getElementById('notificationsDropdown');
            var userDropdownMenu = document.getElementById('userDropdownMenu');

            if (notificationsDropdown) {
                // Close user dropdown if open
                if (userDropdownMenu) {
                    userDropdownMenu.style.display = 'none';
                }

                // Toggle notifications dropdown
                if (notificationsDropdown.style.display === 'block') {
                    notificationsDropdown.style.display = 'none';
                } else {
                    notificationsDropdown.style.display = 'block';

                    // Mark notifications as read when dropdown is opened
                    fetch('{{ route("customer.notifications.mark-all-read") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    });
                }
            }

            return false;
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            var userDropdown = document.getElementById('userDropdown');
            var dropdownMenu = document.getElementById('userDropdownMenu');
            var notificationTrigger = document.querySelector('.notification-trigger');
            var notificationsDropdown = document.getElementById('notificationsDropdown');

            // Close user dropdown
            if (dropdownMenu && userDropdown) {
                if (!userDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.style.display = 'none';
                }
            }

            // Close notifications dropdown
            if (notificationsDropdown && notificationTrigger) {
                if (!notificationTrigger.contains(event.target) && !notificationsDropdown.contains(event.target)) {
                    notificationsDropdown.style.display = 'none';
                }
            }
        });

        // Prevent dropdown from closing when clicking inside menu
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, setting up dropdown...');

            var dropdownMenu = document.getElementById('userDropdownMenu');
            var userDropdown = document.getElementById('userDropdown');

            if (dropdownMenu) {
                console.log('Dropdown menu element found');
                // Prevent closing when clicking inside
                dropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            } else {
                console.log('Dropdown menu element NOT found');
            }

            if (userDropdown) {
                console.log('User dropdown button found');
                // Remove onclick attribute to avoid double firing
                userDropdown.removeAttribute('onclick');
                // Add click event
                userDropdown.addEventListener('click', function(e) {
                    console.log('Dropdown clicked via addEventListener');
                    window.toggleDropdown(e);
                });
            } else {
                console.log('User dropdown button NOT found');
            }
        });
    </script>

    <script>
        // Toggle Side Navigation
        function toggleSideNav() {
            const sideNav = document.querySelector('.side-nav');
            const overlay = document.querySelector('.overlay');

            if (sideNav && overlay) {
                // Toggle active class
                sideNav.classList.toggle('active');
                overlay.classList.toggle('active');

                // Control body overflow
                if (sideNav.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                    sideNav.style.visibility = 'visible';
                } else {
                    document.body.style.overflow = '';
                    // Delay hiding to allow animation to complete
                    setTimeout(() => {
                        if (!sideNav.classList.contains('active')) {
                            sideNav.style.visibility = 'hidden';
                        }
                    }, 300);
                }
            }
        }

        // Ensure side nav is hidden on page load
        document.addEventListener('DOMContentLoaded', function() {
            const sideNav = document.querySelector('.side-nav');
            if (sideNav && !sideNav.classList.contains('active')) {
                sideNav.style.visibility = 'hidden';
            }
        });
    </script>

    <style>
        /* Side Navigation Styles */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9997 !important; /* Lower than side nav */
            display: none;
        }

        .overlay.active {
            display: block;
        }

        @if(app()->getLocale() == 'ar')
        .side-nav {
            position: fixed;
            top: 0;
            right: -350px; /* Increased to ensure complete hiding */
            width: 300px;
            height: 100%;
            background: white !important;
            background-color: #ffffff !important;
            z-index: 999999 !important; /* Maximum z-index */
            transition: right 0.3s ease;
            overflow-y: auto;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            transform: translateX(0); /* Ensure no transform issues */
        }

        .side-nav.active {
            right: 0 !important;
            transform: translateX(0) !important;
            visibility: visible !important;
        }

        .side-nav:not(.active) {
            right: -350px !important;
            visibility: hidden;
        }
        @else
        /* English version - slide from left */
        .side-nav {
            position: fixed;
            top: 0;
            left: -350px; /* Increased to ensure complete hiding */
            width: 300px;
            height: 100%;
            background: white !important;
            background-color: #ffffff !important;
            z-index: 999999 !important; /* Maximum z-index */
            transition: left 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transform: translateX(0); /* Ensure no transform issues */
        }

        .side-nav.active {
            left: 0 !important;
            transform: translateX(0) !important;
        }

        .side-nav:not(.active) {
            left: -350px !important;
            visibility: hidden;
        }
        @endif

        .side-nav-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: {{ app()->getLocale() == 'ar' ? 'row-reverse' : 'row' }};
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 30px;
            cursor: pointer;
            color: #333;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .side-nav-top-buttons {
            padding: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .side-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .side-nav ul li {
            border-bottom: 1px solid #f0f0f0;
        }

        .side-nav ul li a {
            display: block;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }

        .side-nav ul li a:hover {
            background: #f8f9fa;
            color: #127664;
            padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 30px;
        }

        /* Ensure all side nav elements are clickable when active */
        .side-nav.active * {
            pointer-events: auto !important;
        }
    </style>

    <!-- Overlay (MUST be before side nav) -->
    <div class="overlay" onclick="toggleSideNav()"></div>

    <!-- Side Navigation (MUST be after overlay) -->
    <div class="side-nav" سفغ>
        <div class="side-nav-header">
            <a href="{{ route('shaleek.home') }}" style="display: inline-block;">
                <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="{{ $siteName ?? 'shaleek' }}" style="height: 35px; width: auto;">
            </a>
            <button class="close-btn" onclick="toggleSideNav()">&times;</button>
        </div>

        <!-- Top buttons section -->
        <div class="side-nav-top-buttons">
            <!-- Profile shortcut -->
            <a href="@auth('customer'){{ route('user-index.index') }}@else{{ route('login') }}@endauth" class="side-profile-link">
                <span>
                    <svg width="42" height="42" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M41.3499 50.05C39.1499 50.7 36.5499 51 33.4999 51H18.4999C15.4499 51 12.8499 50.7 10.6499 50.05C11.1999 43.55 17.8749 38.4249 25.9999 38.4249C34.1249 38.4249 40.7999 43.55 41.3499 50.05Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M33.5 1H18.5C6 1 1 6 1 18.5V33.5C1 42.95 3.85 48.125 10.65 50.05C11.2 43.55 17.875 38.4249 26 38.4249C34.125 38.4249 40.8 43.55 41.35 50.05C48.15 48.125 51 42.95 51 33.5V18.5C51 6 46 1 33.5 1ZM26 31.425C21.05 31.425 17.05 27.4 17.05 22.45C17.05 17.5 21.05 13.5 26 13.5C30.95 13.5 34.95 17.5 34.95 22.45C34.95 27.4 30.95 31.425 26 31.425Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M34.9499 22.45C34.9499 27.4 30.9499 31.425 25.9999 31.425C21.0499 31.425 17.0499 27.4 17.0499 22.45C17.0499 17.5 21.0499 13.5 25.9999 13.5C30.9499 13.5 34.9499 17.5 34.9499 22.45Z" fill="#127664" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>

            <!-- Book now button (mobile menu) -->
            @guest('customer')
            <a href="{{ LaravelLocalization::localizeUrl('/login') }}" class="btn btn-sm" style="background-color: #EB5432 !important; color: white; border: 2px solid #EB5432; border-radius: 10px; padding: 8px 16px; font-weight: 600; text-decoration: none; white-space: nowrap;">
                {{ app()->getLocale() == 'ar' ? 'دخول المستخدمين' : 'User login' }}
            </a>
            @endguest

            <!-- Add property / Host portal (mobile menu) -->
            <a href="{{ LaravelLocalization::localizeUrl('/owner/login') }}" class="btn btn-success btn-sm cool-green-bg-color padding-6-px border-width-2" style="background: #198754 !important;">
                {{ app()->getLocale() == 'ar' ? 'أضف عقارك' : 'Add your property' }}
            </a>

            <!-- Language switcher -->
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale() == 'ar' ? 'en' : 'ar', null, [], true) }}" style="border-color:#d8dbdd !important;" class="btn btn-secondary btn-sm cool-gray-color padding-6-px text-dark border-width-2">
                <span>
                    <span>
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.5 22.5C18.0228 22.5 22.5 18.0228 22.5 12.5C22.5 6.97715 18.0228 2.5 12.5 2.5C6.97715 2.5 2.5 6.97715 2.5 12.5C2.5 18.0228 6.97715 22.5 12.5 22.5Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8.49998 3.5H9.49998C7.54998 9.34 7.54998 15.66 9.49998 21.5H8.49998" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.5 3.5C17.45 9.34 17.45 15.66 15.5 21.5" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3.5 16.5V15.5C9.34 17.45 15.66 17.45 21.5 15.5V16.5" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3.5 9.49998C9.34 7.54998 15.66 7.54998 21.5 9.49998" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span>{{ app()->getLocale() == 'ar' ? 'EN' : 'AR' }}</span>
                </span>
            </a>
        </div>
        <ul>
            <li><a href="{{ route('shaleek.home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
            @foreach($headerCategories ?? [] as $category)
            <li><a href="{{ route('showAllChalet', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
            @endforeach
            <li><a href="{{ route('all-posts') }}">{{ app()->getLocale() == 'ar' ? 'المدونة' : 'Blog' }}</a></li>
            <li><a href="{{ route('about_us') }}">{{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}</a></li>
            <li><a href="{{ route('contact_us') }}">{{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}</a></li>
        </ul>
    </div>
