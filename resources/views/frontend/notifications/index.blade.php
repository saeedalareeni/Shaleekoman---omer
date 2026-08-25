@extends('frontend.layouts.weekend_master')

@section('content')
<div class="notifications-page" style="min-height: 100vh; background: #f8f9fa; padding: 40px 0;">
    <div class="container">
        <!-- Header Section -->
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title mb-0" style="color: #127664; font-weight: 600;">
                        <i class="fas fa-bell me-2"></i>
                        {{ app()->getLocale() == 'ar' ? 'الإشعارات' : 'Notifications' }}
                    </h2>
                    <nav aria-label="breadcrumb" class="mt-2">
                        <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                            <li class="breadcrumb-item"><a href="/" style="color: #127664;">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                            <li class="breadcrumb-item active">{{ app()->getLocale() == 'ar' ? 'الإشعارات' : 'Notifications' }}</li>
                        </ol>
                    </nav>
                </div>
                @if($notifications->where('is_read', false)->count() > 0)
                <div class="col-auto">
                    <form action="{{ route('customer.notifications.mark-all-read') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%); border: none;">
                            <i class="fas fa-check-double me-2"></i>
                            {{ app()->getLocale() == 'ar' ? 'تحديد الكل كمقروء' : 'Mark All as Read' }}
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Sidebar for Desktop -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="sidebar-card" style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); position: sticky; top: 20px;">
                    @include('frontend.inc.customer-sidebar')
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Notifications Card -->
                <div class="notifications-card" style="background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="card-body p-4">
                        @if($notifications->count() > 0)
                            <div class="notifications-list">
                                @foreach($notifications as $notification)
                                    <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }} mb-3" 
                                         style="background: {{ !$notification->is_read ? 'linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%)' : '#f8f9fa' }}; 
                                                border-radius: 12px; padding: 20px; border-left: 4px solid {{ $notification->icon_color ?? '#127664' }}; 
                                                transition: all 0.3s ease;">
                                        <div class="row align-items-start">
                                            <div class="col-auto">
                                                <div class="notification-icon" 
                                                     style="width: 50px; height: 50px; border-radius: 50%; 
                                                            background: {{ $notification->icon_color ?? '#127664' }}20; 
                                                            display: flex; align-items: center; justify-content: center;">
                                                    <i class="{{ $notification->icon_class ?? 'fas fa-bell' }}" 
                                                       style="color: {{ $notification->icon_color ?? '#127664' }}; font-size: 20px;"></i>
                                                    </div>
                                                </div>
                                                
                                                <div class="col">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h6 class="mb-1">
                                                                {{ $notification->title }}
                                                                @if(!$notification->is_read)
                                                                    <span class="badge bg-danger ms-2">{{ __('جديد') }}</span>
                                                                @endif
                                                            </h6>
                                                            <p class="mb-2 text-muted">{{ $notification->message }}</p>
                                                            
                                                            @if($notification->booking)
                                                                <div class="notification-details mt-2">
                                                                    <span class="badge bg-light text-dark me-2">
                                                                        <i class="fas fa-hashtag"></i> {{ $notification->booking->booking_number }}
                                                                    </span>
                                                                    <span class="badge bg-light text-dark me-2">
                                                                        <i class="fas fa-calendar"></i> 
                                                                        {{ \Carbon\Carbon::parse($notification->booking->checkin_date)->format('Y/m/d') }}
                                                                    </span>
                                                                    @if($notification->booking->chalet)
                                                                        <span class="badge bg-light text-dark">
                                                                            <i class="fas fa-home"></i> 
                                                                            {{ app()->getLocale() == 'ar' ? $notification->booking->chalet->name : $notification->booking->chalet->name_en }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                            
                                                            <small class="text-muted">
                                                                <i class="far fa-clock"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </small>
                                                        </div>
                                                        
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                @if($notification->booking)
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('customer.bookings.show', $notification->booking->id) }}">
                                                                            <i class="fas fa-eye me-2"></i>
                                                                            {{ __('عرض العرض') }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <form action="{{ route('customer.notifications.destroy', $notification->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger">
                                                                            <i class="fas fa-trash me-2"></i>
                                                                            {{ __('حذف') }}
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('لا توجد إشعارات') }}</h5>
                            <p class="text-muted">{{ __('سيتم عرض إشعاراتك هنا عندما تتلقى أي تحديثات') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Responsive Styles */
@media (max-width: 768px) {
    .notifications-page {
        padding: 20px 0 !important;
    }
    
    .page-header {
        padding: 0 15px;
    }
    
    .page-title {
        font-size: 1.5rem !important;
    }
    
    .notification-item {
        padding: 15px !important;
    }
    
    .notification-icon {
        width: 40px !important;
        height: 40px !important;
    }
    
    .notification-icon i {
        font-size: 16px !important;
    }
    
    .dropdown-menu {
        position: fixed !important;
        left: 10px !important;
        right: 10px !important;
        width: auto !important;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.25rem !important;
    }
    
    .breadcrumb {
        font-size: 0.875rem;
    }
    
    .notification-details .badge {
        display: block !important;
        margin-bottom: 5px !important;
        width: fit-content;
    }
}

/* Hover Effects */
.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Animation */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.notification-item {
    animation: slideIn 0.3s ease;
}

/* RTL Support */
@if(app()->getLocale() == 'ar')
[dir="rtl"] .notification-item {
    border-left: none !important;
    border-right: 4px solid {{ $notification->icon_color ?? '#127664' }} !important;
}

[dir="rtl"] .notification-icon {
    margin-left: 15px;
    margin-right: 0;
}
@endif

.notification-item.unread .card {
    background-color: #f8f9fa;
    border-right: 3px solid #127664 !important;
}

.notification-item:hover .card {
    transform: translateX(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}

.notification-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: #f8f9fa;
}

.notification-details .badge {
    font-weight: 500;
    padding: 5px 10px;
}

@media (max-width: 768px) {
    .notification-item.unread::before {
        right: 5px;
    }
}
</style>
@endsection
