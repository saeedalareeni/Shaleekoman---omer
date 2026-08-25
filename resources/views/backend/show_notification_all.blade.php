@extends('backend.layouts.master')

@section('title', 'جميع الإشعارات')

@section('css')
<style>
    .notifications-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .notifications-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px;
        background: linear-gradient(135deg, #2c8e3d 0%, #ff8c42 100%);
        border-radius: 15px;
        color: white;
        box-shadow: 0 5px 20px rgba(44, 142, 61, 0.3);
    }
    
    .notifications-title {
        font-size: 24px;
        font-weight: bold;
    }
    
    .mark-all-btn {
        background: white;
        color: #2c8e3d;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .mark-all-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        background: #f8f9fa;
        color: #ff8c42;
    }
    
    .notification-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border-left: 4px solid transparent;
    }
    
    .notification-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.12);
    }
    
    .notification-card.unread {
        background: #f0f9ff;
        border-left-color: #3b82f6;
    }
    
    .notification-card.success {
        border-left-color: #10b981;
    }
    
    .notification-card.warning {
        border-left-color: #f59e0b;
    }
    
    .notification-card.danger {
        border-left-color: #ef4444;
    }
    
    .notification-card.info {
        border-left-color: #3b82f6;
    }
    
    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 10px;
    }
    
    .notification-icon-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .notification-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .notification-icon.success {
        background: #d1fae5;
        color: #10b981;
    }
    
    .notification-icon.warning {
        background: #fed7aa;
        color: #f59e0b;
    }
    
    .notification-icon.danger {
        background: #fee2e2;
        color: #ef4444;
    }
    
    .notification-icon.info {
        background: #dbeafe;
        color: #3b82f6;
    }
    
    .notification-content {
        flex: 1;
    }
    
    .notification-title {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }
    
    .notification-message {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.5;
    }
    
    .notification-time {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 10px;
    }
    
    .notification-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-view {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-view:hover {
        background: #2563eb;
    }
    
    .btn-mark-read {
        background: #10b981;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-mark-read:hover {
        background: #059669;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-icon {
        font-size: 80px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }
    
    .empty-title {
        font-size: 24px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 10px;
    }
    
    .empty-message {
        font-size: 16px;
        color: #94a3b8;
    }
</style>
@endsection

@section('content')
<div class="notifications-container">
    <div class="notifications-header">
        <h1 class="notifications-title">
            <i class="fas fa-bell"></i> جميع الإشعارات
        </h1>
        @if(isset($notifications) && $notifications->where('is_read', 0)->count() > 0)
            <a href="{{ route('markAsRead_all') }}" class="mark-all-btn">
                <i class="fas fa-check-double"></i> تحديد الكل كمقروء
            </a>
        @endif
    </div>
    
    @if(isset($notifications) && $notifications->count() > 0)
        @foreach($notifications as $notification)
            <div class="notification-card {{ !$notification->is_read ? 'unread' : '' }} {{ $notification->color ?? 'info' }}">
                <div class="notification-header">
                    <div class="notification-icon-wrapper">
                        <div class="notification-icon {{ $notification->color ?? 'info' }}">
                            <i class="{{ $notification->icon ?? 'fas fa-bell' }}"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">
                                {{ app()->getLocale() == 'ar' ? $notification->title_ar : $notification->title_en }}
                            </div>
                            <div class="notification-message">
                                {{ app()->getLocale() == 'ar' ? $notification->message_ar : $notification->message_en }}
                            </div>
                            <div class="notification-time">
                                <i class="far fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div class="notification-actions">
                        @if($notification->url)
                            <a href="{{ $notification->url }}" class="btn-view">
                                <i class="fas fa-eye"></i> عرض
                            </a>
                        @endif
                        @if(!$notification->is_read)
                            <a href="{{ route('markAsRead', $notification->id) }}" class="btn-mark-read">
                                <i class="fas fa-check"></i> مقروء
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="far fa-bell-slash"></i>
            </div>
            <div class="empty-title">لا توجد إشعارات</div>
            <div class="empty-message">ستظهر هنا جميع الإشعارات عند وصولها</div>
        </div>
    @endif
</div>
@endsection

@section('js')
<script>
    // Auto refresh every 30 seconds
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>
@endsection
