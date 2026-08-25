<!-- Modern Admin Header with Notifications -->
<style>
    :root {
        --primary-color: #2c8e3d;
        --primary-dark: #1a5c28;
        --primary-light: #3fb054;
        --secondary-color: #ff8c42;
        --secondary-dark: #e67225;
        --secondary-light: #ffa05c;
        --accent-color: #ff6b6b;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
        --text-dark: #2c3e50;
        --text-light: #95a5a6;
        --bg-light: #f8f9fa;
        --border-color: #e9ecef;
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 12px rgba(0,0,0,0.12);
        --shadow-lg: 0 8px 24px rgba(0,0,0,0.15);
    }
    
    /* Modern Header */
    .modern-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        box-shadow: var(--shadow-md);
        position: sticky;
        top: 0;
        z-index: 1000;
        transition: all 0.3s ease;
        overflow: visible !important;
    }
    
    .header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
        height: 65px;
    }
    
    /* Logo Section */
    .logo-area {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .logo-area img {
        height: 45px;
        width: auto;
        filter: brightness(0) invert(1);
    }
    
    .logo-text {
        color: white;
        font-size: 20px;
        font-weight: 600;
        letter-spacing: -0.5px;
    }
    
    /* Navigation Menu */
    .nav-menu {
        display: flex;
        align-items: center;
        gap: 5px;
        list-style: none;
        margin: 0;
        padding: 0;
        flex: 1;
        justify-content: center;
        overflow: visible !important;
    }
    
    .nav-item {
        position: relative;
        overflow: visible !important;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }
    
    .nav-link:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.1);
        transition: left 0.3s ease;
    }
    
    .nav-link:hover:before {
        left: 0;
    }
    
    .nav-link:hover {
        color: white;
        background: rgba(255,255,255,0.15);
        transform: translateY(-2px);
    }
    
    .nav-link.active {
        background: rgba(255,255,255,0.2);
        color: white;
    }
    
    .nav-link i {
        font-size: 16px;
    }
    
    /* Dropdown Menu */
    .dropdown-modern {
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        min-width: 260px;
        padding: 8px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
        z-index: 1050;
        display: none;
        transform: translateY(10px);
        pointer-events: none;
    }
    
    .nav-item:hover .dropdown-modern,
    .nav-item.show .dropdown-modern {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
        display: block;
        pointer-events: auto;
    }
    
    .dropdown-modern::before {
        content: '';
        position: absolute;
        top: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-bottom: 8px solid white;
    }
    
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        color: var(--text-dark);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-size: 14px;
    }
    
    .dropdown-item:hover {
        background: linear-gradient(90deg, var(--primary-light) 0%, var(--secondary-light) 100%);
        color: white;
        transform: translateX(5px);
    }
    
    .dropdown-item i {
        width: 20px;
        text-align: center;
        color: var(--primary-light);
    }
    
    .dropdown-divider {
        height: 1px;
        background: var(--border-color);
        margin: 8px 0;
    }
    
    /* Right Section */
    .header-right {
        display: flex !important;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 1000;
    }
    
    /* Notifications */
    .notification-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .notification-btn {
        position: relative;
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .notification-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.05);
    }
    
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: var(--accent-color);
        color: white;
        font-size: 11px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    /* Notification Dropdown */
    .notification-dropdown {
        position: absolute;
        top: 45px;
        right: 0;
        width: 350px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.1);
        opacity: 0;
        visibility: hidden;
        display: none;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1051;
    }
    
    .notification-dropdown.show {
        opacity: 1;
        visibility: visible;
        display: block;
        transform: translateY(0);
    }
    
    .notification-header {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .notification-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .mark-all-read {
        font-size: 12px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }
    
    .notification-list {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .notification-item {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        transition: background 0.2s;
        cursor: pointer;
        display: flex;
        gap: 15px;
    }
    
    .notification-item:hover {
        background: var(--bg-light);
    }
    
    .notification-item.unread {
        background: #f0f9ff;
        border-left: 3px solid var(--primary-color);
    }
    
    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .notification-icon.info { background: #e3f2fd; color: #1976d2; }
    .notification-icon.success { background: #e8f5e9; color: #2e7d32; }
    .notification-icon.warning { background: #fff3e0; color: #f57c00; }
    .notification-icon.danger { background: #ffebee; color: #c62828; }
    
    .notification-content {
        flex: 1;
    }
    
    .notification-text {
        font-size: 14px;
        color: var(--text-dark);
        margin-bottom: 5px;
    }
    
    .notification-time {
        font-size: 12px;
        color: var(--text-light);
    }
    
    .notification-footer {
        padding: 12px 20px;
        text-align: center;
        border-top: 1px solid var(--border-color);
    }
    
    .view-all-notifications {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    
    /* User Menu */
    .user-menu-wrapper {
        position: relative;
    }
    
    .user-menu-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 15px;
        background: rgba(255,255,255,0.2);
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .user-menu-btn:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-weight: bold;
    }
    
    .user-name {
        font-size: 14px;
        font-weight: 500;
    }
    
    /* User Dropdown */
    .user-dropdown {
        position: absolute;
        top: 45px;
        right: 0;
        width: 280px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.1);
        opacity: 0;
        visibility: hidden;
        display: none;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1051;
    }
    
    .user-dropdown.show {
        opacity: 1;
        visibility: visible;
        display: block;
        transform: translateY(0);
    }
    
    .user-info {
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .user-avatar-large {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #127664, #0c594b);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
    }
    
    .user-details {
        flex: 1;
    }
    
    .user-name-large {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin: 0 0 5px 0;
    }
    
    .user-email {
        font-size: 13px;
        color: #666;
        margin: 0;
    }
    
    .user-dropdown .dropdown-divider {
        height: 1px;
        background: #eee;
        margin: 0;
    }
    
    .user-dropdown .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .user-dropdown .dropdown-item:hover {
        background: #f8f9fa;
    }
    
    .user-dropdown .dropdown-item i {
        width: 20px;
        color: #127664;
    }
    
    .logout-form {
        margin: 0;
    }
    
    .logout-btn {
        width: 100%;
        text-align: left;
        background: none;
        border: none;
        cursor: pointer;
        font-family: inherit;
        font-size: inherit;
    }
    
    .logout-btn:hover {
        background: #f8f9fa;
    }
    
    /* Language Switcher */
    .lang-switcher {
        display: flex;
        gap: 5px;
        background: rgba(255,255,255,0.2);
        padding: 5px;
        border-radius: 8px;
    }
    
    .lang-btn {
        padding: 6px 12px;
        background: transparent;
        border: none;
        color: rgba(255,255,255,0.8);
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 13px;
        font-weight: 500;
    }
    
    .lang-btn.active {
        background: white;
        color: var(--primary-color);
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
    
    /* Mobile Menu Toggle */
    .mobile-menu-toggle {
        display: none;
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    /* Fix for dropdown visibility */
    .nav-item.show > .nav-link {
        background: rgba(255,255,255,0.2);
    }
    
    /* Mobile Menu Styles */
    .nav-menu.mobile-active {
        display: flex !important;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--primary-dark);
        flex-direction: column;
        padding: 20px;
        box-shadow: var(--shadow-lg);
    }
    
    .nav-menu.mobile-active .nav-item {
        width: 100%;
    }
    
    .nav-menu.mobile-active .dropdown-modern {
        position: static;
        transform: none;
        margin-top: 10px;
        width: 100%;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .nav-menu {
            display: none;
        }
        
        .mobile-menu-toggle {
            display: flex !important;
        }
        
        .header-wrapper {
            position: relative;
        }
    }

    /* Extra small screens: keep hamburger visible */
    @media (max-width: 576px) {
        .header-wrapper {
            padding: 0 10px;
        }
        
        .header-right {
            gap: 8px;
        }
        
        .lang-switcher {
            display: none !important;
        }
        
        .user-name {
            display: none !important;
        }
        
        .user-menu-btn {
            padding: 8px 10px;
        }
        
        .mobile-menu-toggle {
            width: 42px;
            height: 42px;
            flex: 0 0 auto;
        }
    }
</style>


<header class="modern-header">
    <div class="header-wrapper">
        <!-- Logo -->
        <div class="logo-area">
            @if(isset($siteLogo) && $siteLogo)
                <img src="{{ $siteLogo }}" alt="{{ $siteName ?? 'Logo' }}">
            @else
                <span class="logo-text">{{ $siteName ?? config('app.name', 'Shaleek') }}</span>
            @endif
        </div>
        
        <!-- Navigation -->
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>{{ trans('back.dashboard') }}</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('owners.index') }}" class="nav-link {{ request()->routeIs('owners.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>{{ trans('back.owners') }}</span>
                    @php
                        $newOwnersCount = \App\Models\Owner::where('created_at', '>=', now()->subDays(7))->count();
                    @endphp
                    @if($newOwnersCount > 0)
                        <span class="badge badge-success" style="margin-left: 5px;">{{ $newOwnersCount }} جديد</span>
                    @endif
                </a>
            </li>
            
            @can('customers')
            <li class="nav-item">
                <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i>
                    <span>{{ trans('back.customers') }}</span>
                </a>
            </li>
            @endcan
            
            <!-- Chalets Dropdown -->
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="toggleDropdown(event, this)">
                    <i class="fas fa-building"></i>
                    <span>{{ __('back.chalets') }}</span>
                    <i class="fas fa-chevron-down" style="font-size: 10px; margin-left: 5px;"></i>
                </a>
                <div class="dropdown-modern">
                    <a href="{{ route('chalets.index') }}" class="dropdown-item">
                        <i class="fas fa-list"></i>
                        <span>{{ __('back.all_chalets') }}</span>
                    </a>
                    @if(Route::has('chalets.pending'))
                    <a href="{{ route('chalets.pending') }}" class="dropdown-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ __('back.pending_chalets') }}</span>
                    </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('categories.index') }}" class="dropdown-item">
                        <i class="fas fa-tags"></i>
                        <span>{{ __('back.categories') }}</span>
                    </a>
                    @if(Route::has('amenities.index'))
                    <a href="{{ route('amenities.index') }}" class="dropdown-item">
                        <i class="fas fa-concierge-bell"></i>
                        <span>{{ __('back.amenities') }}</span>
                    </a>
                    @endif
                </div>
            </li>
            
            <!-- Bookings -->
            <li class="nav-item">
                <a href="{{ route('booking-customers.index') }}" class="nav-link {{ request()->routeIs('booking-customers.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>{{ trans('back.booking_customers') }}</span>
                    @php
                        $todayBookings = \App\Models\Booking::whereDate('created_at', today())->count();
                    @endphp
                    @if($todayBookings > 0)
                        <span class="badge badge-warning" style="margin-left: 5px;">{{ $todayBookings }} {{ __('back.today') }}</span>
                    @endif
                </a>
            </li>
            
            <!-- Pages Dropdown -->
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="toggleDropdown(event, this)">
                    <i class="fas fa-file-alt"></i>
                    <span>{{ __('back.pages') }}</span>
                    <i class="fas fa-chevron-down" style="font-size: 10px; margin-left: 5px;"></i>
                </a>
                <div class="dropdown-modern">
                    @if(Route::has('abouts.index'))
                    <a href="{{ route('abouts.index') }}" class="dropdown-item">
                        <i class="fas fa-info-circle"></i>
                        <span>{{ __('back.about_us') }}</span>
                    </a>
                    @endif
                    @if(Route::has('contacts.index'))
                    <a href="{{ route('contacts.index') }}" class="dropdown-item">
                        <i class="fas fa-phone"></i>
                        <span>{{ __('back.contact_us') }}</span>
                    </a>
                    @endif
                    @if(Route::has('terms.index'))
                    <a href="{{ route('terms.index') }}" class="dropdown-item">
                        <i class="fas fa-gavel"></i>
                        <span>{{ __('back.terms_conditions') }}</span>
                    </a>
                    @elseif(Route::has('pages.index'))
                    <a href="{{ route('pages.index') }}?type=terms" class="dropdown-item">
                        <i class="fas fa-gavel"></i>
                        <span>{{ __('back.terms_conditions') }}</span>
                    </a>
                    @endif
                    @if(Route::has('faqs.index'))
                    <a href="{{ route('faqs.index') }}" class="dropdown-item">
                        <i class="fas fa-question-circle"></i>
                        <span>{{ __('back.faqs') }}</span>
                    </a>
                    @endif
                    @if(Route::has('posts.index'))
                    <a href="{{ route('posts.index') }}" class="dropdown-item">
                        <i class="fas fa-blog"></i>
                        <span>{{ __('back.blog') }}</span>
                    </a>
                    @endif
                    @can('pages')
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('pages.index') }}" class="dropdown-item">
                        <i class="fas fa-file-alt"></i>
                        <span>{{ trans('back.pages') }}</span>
                    </a>
                    @endcan
                </div>
            </li>
            
           <!-- Others Dropdown -->
<li class="nav-item">
    <a href="#" class="nav-link" onclick="toggleDropdown(event, this)">
        <i class="fas fa-ellipsis-h"></i>
        <span>{{ trans('back.others') }}</span>
        <i class="fas fa-chevron-down" style="font-size: 10px; margin-left: 5px;"></i>
    </a>
    <div class="dropdown-modern">
        <!-- المحافظات -->
        <a href="{{ route('cities.index') }}" class="dropdown-item">
            <i class="fas fa-city"></i>
            <span>{{ trans('back.cities') }}</span>
        </a>

        <!-- المناطق / الولايات -->
        <a href="{{ route('areas.index') }}" class="dropdown-item">
            <i class="fas fa-map-marked"></i>
            <span>{{ trans('back.areas') }}</span>
        </a>

        <!-- السليدرز -->
        @if(Route::has('sliders.index'))
        <a href="{{ route('sliders.index') }}" class="dropdown-item">
            <i class="fas fa-images"></i>
            <span>{{ __('back.sliders') }}</span>
        </a>
        @endif

        <!-- المستخدمين -->
        @if(Route::has('users.index'))
        <a href="{{ route('users.index') }}" class="dropdown-item">
            <i class="fas fa-users-cog"></i>
            <span>{{ trans('back.users') }}</span>
        </a>
        @endif

        <!-- منح الصلاحيات -->
        @if(Route::has('roles.index'))
        <a href="{{ route('roles.index') }}" class="dropdown-item">
            <i class="fas fa-user-shield"></i>
            <span>{{ trans('back.roles') }}</span>
        </a>
        @endif
    </div>
</li>

        </ul>
        
        <!-- Right Section -->
        <div class="header-right">
            <!-- Notifications -->
            <div class="notification-wrapper" style="display: inline-block !important; position: relative;">
                <button class="notification-btn" onclick="toggleNotifications()" style="background: rgba(255,255,255,0.2) !important; color: white !important; position: relative;" title="{{ __('back.notifications') }}">
                    <i class="fas fa-bell" style="color: white !important; font-size: 20px !important;"></i>
                    <?php
                        $unreadCount = 0;
                        // Show notifications for all admin panel users
                        $unreadCount = \App\Models\Notification::where('is_read', 0)->count();
                    ?>
                    @if($unreadCount > 0)
                        <span class="notification-badge" style="position: absolute !important; top: -8px !important; right: -8px !important; background: #ff6b6b !important; color: white !important; font-size: 12px !important; padding: 2px 6px !important; border-radius: 10px !important; font-weight: bold !important; min-width: 20px !important; text-align: center !important; display: inline-block !important; z-index: 1052 !important;">{{ $unreadCount }}</span>
                    @endif
                </button>
                
                <!-- Notification Dropdown -->
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-header">
                        <span class="notification-title">{{ __('back.notifications') }}</span>
                        <a href="{{ route('markAsRead_all') }}" class="mark-all-read">{{ __('back.mark_all_read') }}</a>
                    </div>
                    <div class="notification-list">
                        <?php
                            $recentNotifications = collect();
                            // Show recent notifications
                            $recentNotifications = \App\Models\Notification::orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
                        ?>
                        @if($recentNotifications->count() > 0)
                            @foreach($recentNotifications as $notification)
                            <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}" onclick="window.location.href='{{ $notification->url ?? '#' }}'">
                                <div class="notification-icon {{ $notification->color ?? 'info' }}">
                                    <i class="{{ $notification->icon ?? 'fas fa-bell' }}"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">{{ app()->getLocale() == 'ar' ? $notification->title_ar : $notification->title_en }}</div>
                                    <div class="notification-message">{{ \Illuminate\Support\Str::limit(app()->getLocale() == 'ar' ? $notification->message_ar : $notification->message_en, 100) }}</div>
                                    <div class="notification-time">
                                        <i class="far fa-clock"></i> 
                                        {{ $notification->created_at ? $notification->created_at->diffForHumans() : '' }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="no-notifications">
                                <i class="far fa-bell-slash"></i>
                                <p>{{ __('back.no_new_notifications') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="notification-footer">
                        <a href="{{ route('show_notification_all') }}" class="view-all-notifications">
                            {{ __('back.view_all_notifications') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Messages -->
            <div class="notification-wrapper" style="display: inline-block !important; position: relative;">
                <a href="{{ route('customer-messages.index') }}" class="notification-btn" style="background: rgba(255,255,255,0.2) !important; color: white !important; position: relative; text-decoration: none;" title="{{ __('back.messages') }}">
                    <i class="fas fa-envelope" style="color: white !important; font-size: 20px !important;"></i>
                    @php
                        $unreadMessages = 0;
                        if (auth()->check()) {
                            $unreadMessages = \App\Models\CustomerMessage::where('is_read', 0)->count();
                        }
                    @endphp
                    @if($unreadMessages > 0)
                        <span class="notification-badge" style="position: absolute !important; top: -8px !important; right: -8px !important; background: #28a745 !important; color: white !important; font-size: 12px !important; padding: 2px 6px !important; border-radius: 10px !important; font-weight: bold !important;">{{ $unreadMessages }}</span>
                    @endif
                </a>
            </div>
            
            <!-- Settings Button -->
            <div class="notification-wrapper" style="display: inline-block !important; position: relative;">
                @if(Route::has('settings.index'))
                    <a href="{{ route('settings.index') }}" class="notification-btn" style="background: rgba(255,255,255,0.2) !important; color: white !important; position: relative; text-decoration: none;" title="{{ __('back.settings') }}">
                        <i class="fas fa-cog" style="color: white !important; font-size: 20px !important;"></i>
                    </a>
                @elseif(Route::has('admin.settings'))
                    <a href="{{ route('admin.settings') }}" class="notification-btn" style="background: rgba(255,255,255,0.2) !important; color: white !important; position: relative; text-decoration: none;" title="{{ __('back.settings') }}">
                        <i class="fas fa-cog" style="color: white !important; font-size: 20px !important;"></i>
                    </a>
                @endif
            </div>
            
            <!-- Language Switcher -->
            <div class="lang-switcher">
                <button class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}" onclick="changeLanguage('ar')">{{ __('back.arabic') }}</button>
                <button class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}" onclick="changeLanguage('en')">{{ __('back.english') }}</button>
            </div>
            
            <!-- User Menu -->
            <div class="user-menu-wrapper">
                <button class="user-menu-btn" onclick="toggleUserMenu()">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <i class="fas fa-chevron-down" style="font-size: 10px;"></i>
                </button>
                
                <!-- User Dropdown Menu -->
                <div class="user-dropdown" id="userDropdown">
                    <div class="user-info">
                        <div class="user-avatar-large">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="user-details">
                            <p class="user-name-large">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="user-email">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    @if(Route::has('admin.profile'))
                        <a href="{{ route('admin.profile') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>{{ __('back.profile') }}</span>
                        </a>
                    @elseif(Route::has('profile.index'))
                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>{{ __('back.profile') }}</span>
                        </a>
                    @else
                        <a href="{{ route('admin.profile') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>{{ __('back.profile') }}</span>
                        </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="dropdown-item logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>{{ __('back.logout') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" type="button" onclick="toggleMobileMenu()" aria-label="Menu">
            <svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect y="0" width="22" height="2.5" rx="1.25" fill="white"/>
                <rect y="7.75" width="22" height="2.5" rx="1.25" fill="white"/>
                <rect y="15.5" width="22" height="2.5" rx="1.25" fill="white"/>
            </svg>
        </button>
    </div>
</header>

<script>
// Toggle Dropdown
function toggleDropdown(event, element) {
    event.preventDefault();
    event.stopPropagation();
    
    // Close all other dropdowns
    document.querySelectorAll('.nav-item').forEach(item => {
        if (item !== element.parentElement) {
            item.classList.remove('show');
        }
    });
    
    // Toggle current dropdown
    element.parentElement.classList.toggle('show');
}

// Toggle Notifications
function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    
    if (!dropdown) {
        console.error('Notification dropdown not found!');
        return;
    }
    
    // Toggle the dropdown
    dropdown.classList.toggle('show');
    
    // Close other dropdowns
    document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('show');
    });
    
    // Mark notifications as read when opened
    if (dropdown.classList.contains('show')) {
        // Optional: Mark notifications as read via AJAX
        fetch('{{ route("markAsRead_all") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).catch(error => console.log('Error marking notifications as read:', error));
        
        // Close on click outside
        setTimeout(() => {
            document.addEventListener('click', function closeDropdown(e) {
                if (!dropdown.contains(e.target) && !e.target.closest('.notification-btn')) {
                    dropdown.classList.remove('show');
                    document.removeEventListener('click', closeDropdown);
                }
            });
        }, 100);
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    // Close notification dropdown
    const notificationWrapper = document.querySelector('.notification-wrapper');
    if (notificationWrapper && !notificationWrapper.contains(e.target)) {
        document.getElementById('notificationDropdown').classList.remove('show');
    }
    
    // Close nav dropdowns
    if (!e.target.closest('.nav-item')) {
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.remove('show');
        });
    }
});

// Keep dropdown open on hover
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.nav-item').forEach(item => {
        let timeout;
        
        // Check if item has dropdown
        if (item.querySelector('.dropdown-modern')) {
            item.addEventListener('mouseenter', function() {
                clearTimeout(timeout);
                this.classList.add('show');
            });
            
            item.addEventListener('mouseleave', function() {
                const element = this;
                timeout = setTimeout(function() {
                    element.classList.remove('show');
                }, 300);
            });
        }
    });
});

// Change Language - Works with LaravelLocalization
function changeLanguage(lang) {
    @php
        $useLaravelLocalization = class_exists('\Mcamara\LaravelLocalization\Facades\LaravelLocalization');
    @endphp
    
    @if($useLaravelLocalization)
        // Get current path without locale
        var currentPath = window.location.pathname;
        var pathParts = currentPath.split('/');
        
        // Remove locale if exists (en/ar)
        if (pathParts[1] === 'en' || pathParts[1] === 'ar') {
            pathParts.splice(1, 1);
        }
        
        // Add new locale
        pathParts.splice(1, 0, lang);
        
        // Redirect to new URL
        window.location.href = pathParts.join('/');
    @else
        // Fallback to simple language switch
        window.location.href = '{{ url("/") }}/lang/' + lang;
    @endif
}

// Toggle Mobile Menu
function toggleMobileMenu() {
    const navMenu = document.querySelector('.nav-menu');
    navMenu.classList.toggle('mobile-active');
}

// Toggle User Menu
function toggleUserMenu() {
    const dropdown = document.getElementById('userDropdown');
    
    if (!dropdown) {
        console.error('User dropdown not found!');
        return;
    }
    
    // Toggle the dropdown
    dropdown.classList.toggle('show');
    
    // Close notifications dropdown if open
    const notificationDropdown = document.getElementById('notificationDropdown');
    if (notificationDropdown) {
        notificationDropdown.classList.remove('show');
    }
    
    // Close on click outside
    if (dropdown.classList.contains('show')) {
        setTimeout(() => {
            document.addEventListener('click', function closeUserDropdown(e) {
                if (!dropdown.contains(e.target) && !e.target.closest('.user-menu-btn')) {
                    dropdown.classList.remove('show');
                    document.removeEventListener('click', closeUserDropdown);
                }
            });
        }, 100);
    }
}
</script>
