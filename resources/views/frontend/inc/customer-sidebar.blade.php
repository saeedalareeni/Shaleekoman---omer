<div class="list-group">
    <a href="{{ route('account.orders') }}#profile" class="list-group-item list-group-item-action {{ request()->is('account/orders') && request()->get('tab') == 'profile' ? 'active' : '' }}">
        <i class="fas fa-user me-2"></i> {{ __('الملف الشخصي') }}
    </a>
    
    <a href="{{ route('account.orders') }}#bookings" class="list-group-item list-group-item-action {{ request()->is('account/orders') && request()->get('tab') == 'bookings' ? 'active' : '' }}">
        <i class="fas fa-calendar me-2"></i> {{ __('حجوزاتي') }}
    </a>
    
    <a href="{{ route('account.orders') }}#notifications" class="list-group-item list-group-item-action {{ request()->is('account/orders') && request()->get('tab') == 'notifications' ? 'active' : '' }}">
        <i class="fas fa-bell me-2"></i> {{ __('الإشعارات') }}
        @php
            $unreadCount = \App\Models\CustomerNotification::where('customer_id', auth('customer')->user()->id)
                ->where('is_read', false)
                ->count();
        @endphp
        @if($unreadCount > 0)
            <span class="badge bg-danger float-end">{{ $unreadCount }}</span>
        @endif
    </a>
    
    <a href="{{ route('account.orders') }}#wishlist" class="list-group-item list-group-item-action {{ request()->is('account/orders') && request()->get('tab') == 'wishlist' ? 'active' : '' }}">
        <i class="fas fa-heart me-2"></i> {{ __('المفضلة') }}
    </a>
    
    <a href="{{ route('account.orders') }}#settings" class="list-group-item list-group-item-action {{ request()->is('account/orders') && request()->get('tab') == 'settings' ? 'active' : '' }}">
        <i class="fas fa-cog me-2"></i> {{ __('الإعدادات') }}
    </a>
    
    <form method="POST" action="{{ route('customer_logout') }}" class="mb-0">
        @csrf
        <button type="submit" class="list-group-item list-group-item-action text-danger border-0 w-100 text-start">
            <i class="fas fa-sign-out-alt me-2"></i> {{ __('تسجيل الخروج') }}
        </button>
    </form>
</div>

<style>
.list-group-item {
    border: none;
    border-radius: 8px !important;
    margin-bottom: 5px;
    transition: all 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
    transform: translateX(-5px);
}

.list-group-item.active {
    background-color: #127664;
    border-color: #127664;
}

.list-group-item.active i {
    color: white;
}
</style>
