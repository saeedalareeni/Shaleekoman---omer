<!-- Owner Header -->
<style>
    .owner-header {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 15px 0;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .owner-header .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 30px;
    }

    .owner-header .header-logo {
        display: flex !important;
        align-items: center;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
        z-index: 999 !important;
        min-width: 60px !important;
    }
    
    .owner-header .header-logo a {
        display: inline-block !important;
        line-height: 0 !important;
    }
    
    .owner-header .header-logo img {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: 40px !important;
        width: auto !important;
        max-width: 150px !important;
        object-fit: contain !important;
        position: relative !important;
        z-index: 999 !important;
    }
    
    /* Override any conflicting styles */
    .owner-header .header-logo,
    .owner-header .header-logo a,
    .owner-header .header-logo img {
        -webkit-transform: none !important;
        transform: none !important;
        -webkit-filter: none !important;
        filter: none !important;
        clip-path: none !important;
        -webkit-clip-path: none !important;
    }

    .owner-header .header-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .owner-header .header-item {
        position: relative;
    }

    .owner-header .header-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #333;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .owner-header .header-btn:hover {
        border-color: #127664;
        box-shadow: 0 2px 8px rgba(18, 118, 100, 0.1);
    }

    .owner-header .header-btn svg {
        width: 20px;
        height: 20px;
    }

    /* Notifications */
    .owner-header .notifications .header-btn {
        position: relative;
        padding: 10px;
    }

    .owner-header .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #dc3545;
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 600;
    }

    /* User Profile */
    .owner-header .user-profile .header-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 15px 5px 5px;
    }

    .owner-header .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .owner-header .user-info {
        text-align: right;
    }

    .owner-header .user-name {
        display: block;
        color: #333;
        font-weight: 600;
        font-size: 14px;
        line-height: 1.2;
    }

    .owner-header .user-role {
        display: block;
        color: #666;
        font-size: 12px;
        line-height: 1.2;
        margin-top: 2px;
    }

    /* Dropdown Menus */
    .owner-header .dropdown-menu {
        position: absolute;
        top: 100%;
        left: auto;
        right: 0;
        margin-top: 10px;
        background: white;
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        min-width: 200px;
        display: none;
        z-index: 1001;
    }
    
    /* RTL Support - Align dropdowns properly for Arabic */
    [dir="rtl"] .owner-header .dropdown-menu {
        left: 0;
        right: auto;
    }
    
    /* Notifications dropdown specific positioning */
    .owner-header .notifications .dropdown-menu {
        left: auto;
        right: -50px;
    }
    
    /* User dropdown specific positioning */
    .owner-header .user-profile .dropdown-menu {
        left: auto;
        right: 0;
    }
    
    @media (max-width: 768px) {
        .owner-header .notifications .dropdown-menu {
            position: fixed;
            left: 10px;
            right: 10px;
            top: 70px;
            width: auto;
        }
    }

    .owner-header .header-item.show .dropdown-menu {
        display: block;
    }

    .owner-header .dropdown-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .owner-header .dropdown-item:hover {
        background: #f8f9fa;
        color: #127664;
    }

    .owner-header .dropdown-item i {
        margin-left: 10px;
        color: #127664;
        width: 20px;
    }

    /* Notifications Dropdown */
    .owner-header .notifications-dropdown {
        width: 320px;
        max-width: calc(100vw - 40px);
        max-height: 400px;
        overflow: hidden;
    }
    
    @media (max-width: 480px) {
        .owner-header .notifications-dropdown {
            width: calc(100vw - 20px);
            left: 10px !important;
            right: 10px !important;
        }
    }

    .owner-header .dropdown-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: #f8f9fa;
        border-bottom: 1px solid #e5e7eb;
    }

    .owner-header .dropdown-header h6 {
        margin: 0;
        color: #333;
        font-size: 16px;
        font-weight: 600;
    }

    .owner-header .dropdown-header a {
        color: #127664;
        font-size: 12px;
        text-decoration: none;
    }

    .owner-header .notifications-list {
        max-height: 280px;
        overflow-y: auto;
    }

    .owner-header .notification-item {
        display: flex;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .owner-header .notification-item:hover {
        background: #f8f9fa;
    }

    .owner-header .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 12px;
        flex-shrink: 0;
    }

    .owner-header .notification-icon.success {
        background: #d4edda;
        color: #155724;
    }

    .owner-header .notification-icon.info {
        background: #d1ecf1;
        color: #0c5460;
    }

    .owner-header .notification-icon.warning {
        background: #fff3cd;
        color: #856404;
    }

    .owner-header .notification-content {
        flex: 1;
    }

    .owner-header .notification-content h6 {
        margin: 0 0 4px;
        color: #333;
        font-size: 14px;
        font-weight: 600;
    }

    .owner-header .notification-content p {
        margin: 0 0 4px;
        color: #666;
        font-size: 13px;
    }

    .owner-header .notification-time {
        color: #999;
        font-size: 11px;
    }

    .owner-header .dropdown-footer {
        padding: 12px;
        text-align: center;
        background: #f8f9fa;
        border-top: 1px solid #e5e7eb;
    }

    .owner-header .dropdown-footer a {
        color: #127664;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
    }

    /* User Dropdown */
    .owner-header .user-dropdown .dropdown-header {
        padding: 20px;
    }

    .owner-header .user-dropdown .user-profile-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .owner-header .user-dropdown .user-avatar-large {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .owner-header .user-dropdown .user-details h6 {
        margin: 0 0 4px;
        color: #333;
        font-size: 16px;
        font-weight: 600;
    }

    .owner-header .user-dropdown .user-details small {
        color: #666;
        font-size: 13px;
    }

    .owner-header .dropdown-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 0;
    }
    
    /* Mobile Menu Toggle Button */
    .mobile-menu-toggle {
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 35px;
        height: 35px;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 5px;
        z-index: 1002;
    }
    
    .mobile-menu-toggle span {
        display: block;
        width: 25px;
        height: 3px;
        background: #127664;
        margin: 3px 0;
        border-radius: 2px;
        transition: all 0.3s ease;
    }
    
    .mobile-menu-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }
    
    .mobile-menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }
    
    .mobile-menu-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }
    
    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .mobile-menu-toggle {
            display: flex;
        }
        
        .owner-header .header-content {
            padding: 0 15px;
            position: relative;
        }
        
        .owner-header .header-logo {
            display: block !important;
            visibility: visible !important;
            flex: 1;
        }
        
        .owner-header .header-logo a {
            display: inline-block;
        }
        
        .owner-header .header-logo img {
            height: 35px;
            display: block;
            width: auto;
        }
        
        .owner-header .header-right {
            display: none;
            gap: 10px;
        }
        
        .owner-header .header-right.mobile-active {
            display: flex !important;
        }
        
        .owner-header .header-btn {
            padding: 6px 10px;
            font-size: 13px;
        }
        
        .owner-header .header-btn span {
            display: none;
        }
        
        .owner-header .user-profile .header-btn {
            padding: 5px;
        }
        
        .owner-header .user-info {
            display: none;
        }
        
        .owner-header .user-avatar {
            width: 35px;
            height: 35px;
        }
    }
    
    @media (max-width: 480px) {
        .owner-header {
            padding: 10px 0;
        }
        
        .owner-header .header-content {
            padding: 0 10px;
        }
        
        .owner-header .header-logo {
            flex: 1;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .owner-header .header-logo img {
            height: 30px;
            max-width: 120px;
            object-fit: contain;
        }
        
        .owner-header .header-right {
            gap: 5px;
        }
        
        .owner-header .header-btn {
            padding: 8px;
            border: none;
            background: transparent;
        }
        
        .owner-header .header-btn svg {
            width: 18px;
            height: 18px;
        }
        
        .owner-header .language-switcher {
            display: none;
        }
        
        .owner-header .notification-badge {
            top: -3px;
            right: -3px;
            font-size: 9px;
            padding: 1px 4px;
        }
    }
    
    /* Unread notification styles */
    .notification-item.unread {
        background: #f0f8ff;
        position: relative;
    }
    
    .notification-item.unread::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: #127664;
        border-radius: 0 2px 2px 0;
    }
    
    .notification-item.unread .notification-content h6 {
        font-weight: 700;
    }
</style>

<header class="owner-header">
    <div class="header-content">
        <!-- Logo -->
        <div class="header-logo">
            <a href="{{ route('owner.dashboard') }}">
                <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="Logo">
            </a>
        </div>
        
        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Right Side Items -->
        <div class="header-right" id="headerRight">
            <!-- Language Switcher -->
            <div class="header-item language-switcher">
                <button class="header-btn" type="button" onclick="toggleDropdown(this, event)">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM17.93 6H14.97C14.65 4.75 14.19 3.55 13.59 2.44C15.43 3.07 16.96 4.35 17.93 6ZM10 2.04C10.83 3.24 11.48 4.57 11.91 6H8.09C8.52 4.57 9.17 3.24 10 2.04ZM2.26 12C2.1 11.36 2 10.69 2 10C2 9.31 2.1 8.64 2.26 8H5.64C5.56 8.66 5.5 9.32 5.5 10C5.5 10.68 5.56 11.34 5.64 12H2.26ZM2.07 14H5.03C5.35 15.25 5.81 16.45 6.41 17.56C4.57 16.93 3.04 15.66 2.07 14ZM5.03 6H2.07C3.04 4.34 4.57 3.07 6.41 2.44C5.81 3.55 5.35 4.75 5.03 6ZM10 17.96C9.17 16.76 8.52 15.43 8.09 14H11.91C11.48 15.43 10.83 16.76 10 17.96ZM12.34 12H7.66C7.57 11.34 7.5 10.68 7.5 10C7.5 9.32 7.57 8.65 7.66 8H12.34C12.43 8.65 12.5 9.32 12.5 10C12.5 10.68 12.43 11.34 12.34 12ZM13.59 17.56C14.19 16.45 14.65 15.25 14.97 14H17.93C16.96 15.66 15.43 16.93 13.59 17.56ZM14.36 12C14.44 11.34 14.5 10.68 14.5 10C14.5 9.32 14.44 8.66 14.36 8H17.74C17.9 8.64 18 9.31 18 10C18 10.69 17.9 11.36 17.74 12H14.36Z" fill="#127664"/>
                    </svg>
                    <span>{{ App::getLocale() == 'ar' ? 'العربية' : 'English' }}</span>
                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1.5L6 6.5L11 1.5" stroke="#666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="dropdown-menu">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Notifications -->
            <div class="header-item notifications">
                <button class="header-btn" type="button" onclick="toggleDropdown(this, event)">
                    <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 22C11.1046 22 12 21.1046 12 20H8C8 21.1046 8.89543 22 10 22Z" fill="#127664"/>
                        <path d="M18 16V11C18 7.07 15.64 3.74 12 3.18V2C12 0.9 11.1 0 10 0C8.9 0 8 0.9 8 2V3.18C4.37 3.74 2 7.06 2 11V16L0 18V19H20V18L18 16Z" fill="#127664"/>
                    </svg>
                    @php
                        $unreadCount = \App\Models\Notification::where('owner_id', Auth::guard('owner')->user()->id)
                            ->where('is_read', false)
                            ->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="notification-badge" id="notification-count">{{ $unreadCount }}</span>
                    @endif
                </button>
                <div class="dropdown-menu notifications-dropdown">
                    <div class="dropdown-header">
                        <h6>الإشعارات</h6>
                        <a href="#" onclick="markAllAsRead()">تحديد الكل كمقروء</a>
                    </div>
                    <div class="notifications-list" id="notifications-list">
                        @php
                            $currentOwnerId = Auth::guard('owner')->user()->id;
                            $notifications = \App\Models\Notification::where('owner_id', $currentOwnerId)
                                ->where('is_read', false)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
                        @endphp
                        @forelse($notifications as $notification)
                            <a href="#" class="notification-item {{ !$notification->is_read ? 'unread' : '' }}" 
                               data-id="{{ $notification->id }}" 
                               data-type="{{ $notification->type ?? 'info' }}"
                               onclick="showNotificationModal(event, this, {{ json_encode($notification) }})">
                                <div class="notification-icon {{ $notification->type ?? 'info' }}">
                                    @if($notification->type == 'booking')
                                        <i class="fas fa-calendar-check"></i>
                                    @elseif($notification->type == 'review')
                                        <i class="fas fa-star"></i>
                                    @elseif($notification->type == 'contact_message')
                                        <i class="fas fa-envelope"></i>
                                    @elseif($notification->type == 'booking_cancelled')
                                        <i class="fas fa-calendar-times"></i>
                                    @elseif($notification->type == 'booking_confirmed')
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        <i class="fas fa-bell"></i>
                                    @endif
                                </div>
                                <div class="notification-content">
                                    <h6>{{ $notification->title_ar ?? 'حجز جديد' }}</h6>
                                    @if($notification->type == 'review' && $notification->data && is_array($notification->data))
                                        @if(!empty($notification->data['rating']))
                                            <p style="margin: 2px 0; font-size: 12px;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $notification->data['rating'])
                                                        <i class="fas fa-star fa-xs" style="color: gold;"></i>
                                                    @else
                                                        <i class="far fa-star fa-xs"></i>
                                                    @endif
                                                @endfor
                                            </p>
                                        @endif
                                        @if(!empty($notification->data['customer_name']))
                                            <p style="margin: 2px 0; font-size: 12px;">
                                                <i class="fas fa-user fa-xs"></i> {{ $notification->data['customer_name'] }}
                                            </p>
                                        @endif
                                        @if(!empty($notification->data['chalet_name']))
                                            <p style="margin: 2px 0; font-size: 12px;">
                                                <i class="fas fa-home fa-xs"></i> {{ $notification->data['chalet_name'] }}
                                            </p>
                                        @endif
                                    @elseif($notification->type == 'contact_message' && $notification->data && is_array($notification->data))
                                        @if(!empty($notification->data['sender_name']))
                                            <p style="margin: 2px 0; font-size: 12px;">
                                                <i class="fas fa-user fa-xs"></i> من: {{ $notification->data['sender_name'] }}
                                            </p>
                                        @endif
                                        @if(!empty($notification->data['subject']))
                                            <p style="margin: 2px 0; font-size: 12px;">
                                                <i class="fas fa-comment fa-xs"></i> {{ $notification->data['subject'] }}
                                            </p>
                                        @endif
                                    @elseif($notification->type == 'booking' && $notification->data && is_array($notification->data))
                                        @if(!empty($notification->data['booking_number']))
                                            <p style="margin: 2px 0; font-size: 12px;">
                                                <i class="fas fa-hashtag fa-xs"></i> رقم الحجز: {{ $notification->data['booking_number'] }}
                                            </p>
                                        @endif
                                        @if(!empty($notification->data['chalet_name']))
                                            <p style="margin: 2px 0; font-size: 12px;">
                                                <i class="fas fa-home fa-xs"></i> {{ $notification->data['chalet_name'] }}
                                            </p>
                                        @endif
                                        @if(!empty($notification->data['customer_name']))
                                            <p style="margin: 2px 0; font-size: 12px;">
                                                <i class="fas fa-user fa-xs"></i> {{ $notification->data['customer_name'] }}
                                            </p>
                                        @endif
                                        @if(!empty($notification->data['checkin_date']) && !empty($notification->data['checkout_date']))
                                            <p style="margin: 2px 0; font-size: 12px;">
                                                <i class="fas fa-calendar fa-xs"></i> {{ $notification->data['checkin_date'] }} - {{ $notification->data['checkout_date'] }}
                                            </p>
                                        @endif
                                        @if(!empty($notification->data['total_amount']))
                                            <p style="margin: 2px 0; font-size: 12px; color: #28a745;">
                                                <i class="fas fa-money-bill fa-xs"></i> {{ number_format($notification->data['total_amount'], 0) }} ر.ع
                                            </p>
                                        @endif
                                    @else
                                        <p>{{ $notification->message_ar ?? '' }}</p>
                                    @endif
                                    <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="notification-item">
                                <p style="text-align: center; padding: 20px; color: #999;">لا توجد إشعارات</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="dropdown-footer">
                        <a href="{{ route('owner.notifications.index') }}">عرض كل الإشعارات</a>
                    </div>
                </div>
            </div>

            <!-- User Profile -->
            <div class="header-item user-profile">
                <button class="header-btn" type="button" onclick="toggleDropdown(this, event)">
                    <img src="{{ asset(auth()->user()->image ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=127664&color=fff') }}" alt="User" class="user-avatar">
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">صاحب عقارات</span>
                    </div>
                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1.5L6 6.5L11 1.5" stroke="#666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="dropdown-menu user-dropdown">
                    <div class="dropdown-header">
                        <div class="user-profile-info">
                            <img src="{{ asset(auth()->user()->image ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=127664&color=fff') }}" alt="User" class="user-avatar-large">
                            <div class="user-details">
                                <h6>{{ auth()->user()->name }}</h6>
                                <small>{{ auth()->user()->email }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('owner.dashboard') }}#profile" class="dropdown-item" onclick="handleTabNavigation(event, 'profile')">
                        <i class="fas fa-user-circle"></i>
                        البيانات الشخصية
                    </a>
                    <a href="{{ route('owner.dashboard') }}#properties" class="dropdown-item" onclick="handleTabNavigation(event, 'properties')">
                        <i class="fas fa-home"></i>
                        عقاراتي
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('owner.logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="dropdown-item" style="color: #dc3545; border: none; background: none; width: 100%; text-align: right; cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i>
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
// Toggle Mobile Menu
window.toggleMobileMenu = function() {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const headerRight = document.getElementById('headerRight');
    
    menuToggle.classList.toggle('active');
    
    if (headerRight.style.display === 'flex') {
        headerRight.style.display = 'none';
    } else {
        headerRight.style.display = 'flex';
        headerRight.style.position = 'fixed';
        headerRight.style.top = '60px';
        headerRight.style.right = '0';
        headerRight.style.background = 'white';
        headerRight.style.flexDirection = 'column';
        headerRight.style.padding = '20px';
        headerRight.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
        headerRight.style.borderRadius = '0 0 0 8px';
        headerRight.style.zIndex = '1001';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Toggle dropdown function
    window.toggleDropdown = function(button, event) {
        if (event) {
            event.stopPropagation();
        }
        const headerItem = button.closest('.header-item');
        const wasOpen = headerItem.classList.contains('show');
        
        // Close all dropdowns
        document.querySelectorAll('.header-item').forEach(item => {
            item.classList.remove('show');
        });
        
        // Toggle current dropdown
        if (!wasOpen) {
            headerItem.classList.add('show');
        }
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.header-btn')) {
            document.querySelectorAll('.header-item').forEach(item => {
                item.classList.remove('show');
            });
        }
    });
});

// Show notification modal
window.showNotificationModal = function(event, element, notification) {
    event.preventDefault();
    event.stopPropagation();
    
    // Get notification data
    const notificationId = element.dataset.id;
    const type = notification.type || 'info';
    const data = notification.data || {};
    
    // Create modal HTML
    const modalHtml = `
        <div id="notificationModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 9999;">
            <div style="background: white; border-radius: 12px; width: 90%; max-width: 500px; padding: 0; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                <div style="padding: 20px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; color: #333; font-size: 20px;">تفاصيل الإشعار</h3>
                    <button onclick="closeNotificationModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999;">&times;</button>
                </div>
                <div style="padding: 30px;">
                    <div style="width: 60px; height: 60px; margin: 0 auto 20px; background: #d1ecf1; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-bell" style="font-size: 24px; color: #0c5460;"></i>
                    </div>
                    <h4 style="text-align: center; margin: 0 0 15px; color: #333; font-size: 22px;">${notification.title_ar || 'حجز جديد'}</h4>
                    ${type === 'booking' && data ? `
                        <div style="background: #f8f9fa; border-radius: 8px; padding: 15px; margin-top: 20px;">
                            ${data.booking_number ? `
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #dee2e6;">
                                    <span><i class="fas fa-hashtag" style="color: #127664; margin-left: 8px;"></i>رقم الحجز</span>
                                    <strong>${data.booking_number}</strong>
                                </div>
                            ` : ''}
                            ${data.chalet_name ? `
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #dee2e6;">
                                    <span><i class="fas fa-home" style="color: #127664; margin-left: 8px;"></i>الشاليه</span>
                                    <strong>${data.chalet_name}</strong>
                                </div>
                            ` : ''}
                            ${data.customer_name ? `
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #dee2e6;">
                                    <span><i class="fas fa-user" style="color: #127664; margin-left: 8px;"></i>العميل</span>
                                    <strong>${data.customer_name}</strong>
                                </div>
                            ` : ''}
                            ${data.checkin_date ? `
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #dee2e6;">
                                    <span><i class="fas fa-calendar-check" style="color: #127664; margin-left: 8px;"></i>تاريخ الوصول</span>
                                    <strong>${data.checkin_date}</strong>
                                </div>
                            ` : ''}
                            ${data.checkout_date ? `
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #dee2e6;">
                                    <span><i class="fas fa-calendar-times" style="color: #127664; margin-left: 8px;"></i>تاريخ المغادرة</span>
                                    <strong>${data.checkout_date}</strong>
                                </div>
                            ` : ''}
                            ${data.total_amount ? `
                                <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                                    <span><i class="fas fa-money-bill" style="color: #28a745; margin-left: 8px;"></i>المبلغ الإجمالي</span>
                                    <strong style="color: #28a745; font-size: 18px;">${Number(data.total_amount).toLocaleString()} ر.ع</strong>
                                </div>
                            ` : ''}
                        </div>
                    ` : `
                        <p style="text-align: center; color: #666; line-height: 1.6; margin: 0 0 20px;">${notification.message_ar || ''}</p>
                    `}
                    <div style="text-align: center; color: #999; font-size: 14px; margin-top: 20px;">
                        <i class="fas fa-clock"></i> ${notification.created_at ? new Date(notification.created_at).toLocaleDateString('ar-SA') : ''}
                    </div>
                </div>
                <div style="padding: 20px; border-top: 1px solid #e5e7eb; display: flex; gap: 10px;">
                    <button onclick="markAsRead('${notificationId}')" style="flex: 1; padding: 12px; background: #127664; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 500;">
                        تحديد كمقروء
                    </button>
                    <button onclick="closeNotificationModal()" style="flex: 1; padding: 12px; background: #f8f9fa; color: #333; border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer; font-weight: 500;">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Mark as read if unread
    if (element.classList.contains('unread')) {
        markAsRead(notificationId);
        element.classList.remove('unread');
    }
}

// Close notification modal
window.closeNotificationModal = function() {
    const modal = document.getElementById('notificationModal');
    if (modal) {
        modal.remove();
    }
}

// Mark notification as read
window.markAsRead = function(notificationId) {
    fetch(`/owner/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update notification count
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            const currentCount = parseInt(badge.textContent) || 0;
            if (currentCount > 1) {
                badge.textContent = currentCount - 1;
            } else {
                badge.style.display = 'none';
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

// Mark all as read
window.markAllAsRead = function() {
    event.preventDefault();
    fetch('/owner/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Remove unread class from all notifications
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
        });
        // Hide badge
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.style.display = 'none';
        }
    })
    .catch(error => console.error('Error:', error));
}

// دالة للتنقل بين التابات بذكاء
window.handleTabNavigation = function(event, tabName) {
    event.preventDefault();
    
    // إغلاق dropdown
    const headerItem = event.target.closest('.header-item');
    if (headerItem) {
        headerItem.classList.remove('show');
        const dropdownMenu = headerItem.querySelector('.dropdown-menu');
        if (dropdownMenu) {
            dropdownMenu.classList.remove('show');
        }
    }
    
    // التحقق من الصفحة الحالية
    const currentUrl = window.location.pathname;
    const dashboardUrl = '{{ route("owner.dashboard") }}'.replace(window.location.origin, '');
    
    // إذا كنا في صفحة dashboard
    if (currentUrl === dashboardUrl) {
        // تغيير التاب مباشرة بدون refresh
        const tabs = document.querySelectorAll('.tab-item');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        // إزالة active من جميع التابات
        tabs.forEach(t => t.classList.remove('active'));
        tabPanes.forEach(pane => pane.classList.remove('active'));
        
        // تفعيل التاب المطلوب
        const targetTab = document.querySelector(`[data-tab="${tabName}"]`);
        const targetPane = document.getElementById(`${tabName}-tab`);
        
        if (targetTab && targetPane) {
            targetTab.classList.add('active');
            targetPane.classList.add('active');
            
            // تحديث URL بدون reload
            window.history.pushState({}, '', `#${tabName}`);
            
            // التمرير إلى أعلى بسلاسة
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    } else {
        // إذا كنا في صفحة أخرى، نذهب إلى dashboard مع hash
        window.location.href = `{{ route("owner.dashboard") }}#${tabName}`;
    }
}
</script>
