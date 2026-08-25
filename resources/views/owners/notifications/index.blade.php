@extends('owners.layouts.master')

@section('title', 'الإشعارات')

@section('css')
<style>
    .notifications-page {
        padding: 30px 0;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #333;
    }
    
    .header-actions {
        display: flex;
        gap: 15px;
    }
    
    .btn-action {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-mark-all {
        background: #127664;
        color: white;
    }
    
    .btn-mark-all:hover {
        background: #0e5a4c;
    }
    
    .btn-clear-all {
        background: #dc3545;
        color: white;
    }
    
    .btn-clear-all:hover {
        background: #c82333;
    }
    
    .notifications-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .notification-card {
        display: flex;
        align-items: start;
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    
    .notification-card:hover {
        background: #f8f9fa;
    }
    
    .notification-card.unread {
        background: #f0f8ff;
    }
    
    .notification-card.unread::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: #127664;
    }
    
    .notification-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 20px;
        flex-shrink: 0;
    }
    
    .notification-icon.success {
        background: #d4edda;
        color: #155724;
    }
    
    .notification-icon.info {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .notification-icon.warning {
        background: #fff3cd;
        color: #856404;
    }
    
    .notification-icon.error {
        background: #f8d7da;
        color: #721c24;
    }
    
    .notification-content {
        flex: 1;
    }
    
    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 8px;
    }
    
    .notification-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    .notification-time {
        color: #999;
        font-size: 13px;
        white-space: nowrap;
    }
    
    .notification-message {
        color: #666;
        font-size: 14px;
        line-height: 1.5;
        margin: 0;
    }
    
    .notification-actions {
        display: flex;
        gap: 10px;
        margin-top: 12px;
    }
    
    .btn-notification {
        padding: 6px 12px;
        border: 1px solid #e0e0e0;
        background: white;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-notification:hover {
        background: #f8f9fa;
        border-color: #127664;
    }
    
    .btn-delete {
        color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-delete:hover {
        background: #dc3545;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }
    
    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 30px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .empty-icon svg {
        width: 60px;
        height: 60px;
        color: #dee2e6;
    }
    
    .empty-title {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }
    
    .empty-text {
        color: #666;
        font-size: 16px;
    }
</style>
@endsection

@section('content')
<div class="notifications-page">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">الإشعارات</h1>
            <div class="header-actions">
                @if($notifications->where('is_read', false)->count() > 0)
                    <button class="btn-action btn-mark-all" onclick="markAllAsRead()">
                        <i class="fas fa-check-double"></i>
                        تحديد الكل كمقروء
                    </button>
                @endif
                @if($notifications->count() > 0)
                    <button class="btn-action btn-clear-all" onclick="clearAllNotifications()">
                        <i class="fas fa-trash"></i>
                        حذف الكل
                    </button>
                @endif
            </div>
        </div>
        
        <div class="notifications-container">
            @forelse($notifications as $notification)
                <div class="notification-card {{ !$notification->is_read ? 'unread' : '' }}" data-id="{{ $notification->id }}">
                    <div class="notification-icon {{ $notification->icon_type }}">
                        @if($notification->icon_type == 'success')
                            <i class="fas fa-check fa-lg"></i>
                        @elseif($notification->icon_type == 'info')
                            <i class="fas fa-star fa-lg"></i>
                        @elseif($notification->icon_type == 'warning')
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                        @else
                            <i class="fas fa-times-circle fa-lg"></i>
                        @endif
                    </div>
                    <div class="notification-content">
                        <div class="notification-header">
                            <h3 class="notification-title">{{ $notification->title }}</h3>
                            <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="notification-message">{{ $notification->message }}</p>
                        <div class="notification-actions">
                            @if(!$notification->is_read)
                                <button class="btn-notification" onclick="markAsRead({{ $notification->id }})">
                                    <i class="fas fa-check"></i>
                                    تحديد كمقروء
                                </button>
                            @endif
                            <button class="btn-notification btn-delete" onclick="deleteNotification({{ $notification->id }})">
                                <i class="fas fa-trash"></i>
                                حذف
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h3 class="empty-title">لا توجد إشعارات</h3>
                    <p class="empty-text">ستظهر هنا جميع إشعاراتك عندما تتلقى أي إشعارات جديدة</p>
                </div>
            @endforelse
        </div>
        
        @if($notifications->hasPages())
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function markAsRead(notificationId) {
    fetch(`{{ url('/owner/notifications') }}/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const card = document.querySelector(`[data-id="${notificationId}"]`);
            card.classList.remove('unread');
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function markAllAsRead() {
    if (!confirm('هل أنت متأكد من تحديد جميع الإشعارات كمقروءة؟')) return;
    
    fetch('{{ route('owner.notifications.markAllRead') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteNotification(notificationId) {
    if (!confirm('هل أنت متأكد من حذف هذا الإشعار؟')) return;
    
    fetch(`{{ url('/owner/notifications') }}/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const card = document.querySelector(`[data-id="${notificationId}"]`);
            card.remove();
            
            // Check if no notifications left
            if (document.querySelectorAll('.notification-card').length === 0) {
                location.reload();
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

function clearAllNotifications() {
    if (!confirm('هل أنت متأكد من حذف جميع الإشعارات؟')) return;
    
    fetch('{{ route('owner.notifications.clearAll') }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
