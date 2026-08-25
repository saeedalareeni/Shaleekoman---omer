<!-- Navigation Bar-->
<header id="topnav" style="background: #ffffff; border-bottom: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">

    <!-- Topbar Start -->
    <div class="navbar-custom" style="background: transparent;">
        <div class="container-fluid">
            <ul class="list-unstyled topnav-menu float-right mb-0" style="display: flex; align-items: center;">

                <li class="dropdown notification-list d-lg-none">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle nav-link">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </li>

                {{-- تغيير اللغة  --}}
                <li class="dropdown notification-list mx-2">
                    <a class="nav-link dropdown-toggle language-selector" href="#" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                        <i class="fas fa-globe" style="color: #127664; font-size: 18px;"></i>
                        <span class="ml-2" style="color: #333; font-weight: 500;">
                            {{ App::getLocale() == 'ar' ? 'العربية' : 'English' }}
                        </span>
                        <i class="fas fa-chevron-down ml-1" style="font-size: 12px; color: #666;"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="min-width: 150px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                               style="padding: 10px 15px; color: #333;">
                                <i class="fas fa-language mr-2" style="color: #127664;"></i>
                                {{ $properties['native'] }}
                            </a>
                        @endforeach
                    </div>
                </li>
                {{-- نهاية تغيير اللغة  --}}

                {{-- الإشعارات --}}
                @php
                    $currentOwnerId = Auth::guard('owner')->user()->id;
                    $ownerNotifications = \App\Models\Notification::where('owner_id', $currentOwnerId)
                        ->where('is_read', false)
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                    $unreadCount = \App\Models\Notification::where('owner_id', $currentOwnerId)
                        ->where('is_read', false)
                        ->count();
                @endphp
                
                <li class="dropdown notification-list mx-2">
                    <a class="nav-link dropdown-toggle notification-bell" href="#" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                        <i class="fas fa-bell" style="color: #127664; font-size: 18px;"></i>
                        @if($unreadCount > 0)
                            <span class="badge badge-danger">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg" style="width: 380px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <div class="dropdown-header" style="background: #f8f9fa; padding: 15px; border-bottom: 1px solid #e5e7eb;">
                            <h6 class="mb-0" style="color: #333;">الإشعارات ({{ $unreadCount }} غير مقروءة)</h6>
                        </div>
                        <div style="max-height: 400px; overflow-y: auto;">
                            @forelse($ownerNotifications as $notification)
                                <a href="#" class="dropdown-item notify-item" style="padding: 15px; border-bottom: 1px solid #f0f0f0;" 
                                   onclick="showNotificationDetails({{ json_encode($notification) }}); return false;">
                                    <div class="d-flex align-items-start">
                                        <div class="notify-icon bg-info" style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-left: 10px;">
                                            <i class="fas fa-bell text-white"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="notify-details mb-1" style="color: #333; font-weight: 500;">
                                                {{ $notification->title_ar ?? 'حجز جديد' }}
                                            </p>
                                            
                                            @if($notification->type == 'booking' && $notification->data && is_array($notification->data))
                                                <div class="text-muted small">
                                                    @if(!empty($notification->data['booking_number']))
                                                        <div><i class="fas fa-hashtag fa-sm"></i> رقم الحجز: {{ $notification->data['booking_number'] }}</div>
                                                    @endif
                                                    @if(!empty($notification->data['chalet_name']))
                                                        <div><i class="fas fa-home fa-sm"></i> {{ $notification->data['chalet_name'] }}</div>
                                                    @endif
                                                    @if(!empty($notification->data['customer_name']))
                                                        <div><i class="fas fa-user fa-sm"></i> {{ $notification->data['customer_name'] }}</div>
                                                    @endif
                                                    @if(!empty($notification->data['checkin_date']))
                                                        <div><i class="fas fa-calendar fa-sm"></i> {{ $notification->data['checkin_date'] }}
                                                        @if(!empty($notification->data['checkout_date']))
                                                            إلى {{ $notification->data['checkout_date'] }}
                                                        @endif
                                                        </div>
                                                    @endif
                                                    @if(!empty($notification->data['total_amount']))
                                                        <div><i class="fas fa-money-bill fa-sm"></i> {{ number_format($notification->data['total_amount'], 0) }} ر.ع</div>
                                                    @endif
                                                </div>
                                            @elseif(!empty($notification->message_ar))
                                                <small class="text-muted">{{ \Str::limit($notification->message_ar, 100) }}</small>
                                            @endif
                                            
                                            <small class="text-muted d-block mt-1">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-bell-slash fa-3x text-muted mb-2"></i>
                                    <p class="text-muted">لا توجد إشعارات جديدة</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="dropdown-footer" style="padding: 10px; text-align: center; background: #f8f9fa; border-top: 1px solid #e5e7eb;">
                            <a href="{{ route('owner.dashboard') }}#notifications" style="color: #127664; text-decoration: none; font-weight: 500;">عرض كل الإشعارات</a>
                        </div>
                    </div>
                </li>
                {{-- نهاية الإشعارات --}}

                {{-- معلومات المستخدم --}}
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user user-profile-btn mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{asset(auth()->user()->image ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=127664&color=fff')}}" alt="user-image" class="rounded-circle">
                        <div class="user-info ml-2">
                            <span class="user-name">{{auth()->user()->name}}</span>
                            <small class="user-role">صاحب عقارات</small>
                        </div>
                        <i class="fas fa-chevron-down ml-2" style="font-size: 12px; color: #666;"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown" style="min-width: 200px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <div class="dropdown-header" style="padding: 15px; background: #f8f9fa; border-bottom: 1px solid #e5e7eb;">
                            <div class="d-flex align-items-center">
                                <img src="{{asset(auth()->user()->image ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=127664&color=fff')}}" alt="user-image" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="ml-3">
                                    <h6 class="mb-1" style="color: #333;">{{auth()->user()->name}}</h6>
                                    <small style="color: #666;">{{auth()->user()->email}}</small>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('owner.profile.edit') }}" class="dropdown-item notify-item" style="padding: 12px 20px; color: #333;">
                            <i class="fas fa-user-circle mr-2" style="color: #127664;"></i>
                            <span>الملف الشخصي</span>
                        </a>
                        <a href="{{ route('owner.chalets.index') }}" class="dropdown-item notify-item" style="padding: 12px 20px; color: #333;">
                            <i class="fas fa-home mr-2" style="color: #127664;"></i>
                            <span>عقاراتي</span>
                        </a>
                        <a href="#" class="dropdown-item notify-item" style="padding: 12px 20px; color: #333;">
                            <i class="fas fa-cog mr-2" style="color: #127664;"></i>
                            <span>الإعدادات</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <!-- logout-->
                        <form method="POST" action="{{ route('owner.logout') }}">
                            @csrf
                            <a href="javascript:void(0);" class="dropdown-item notify-item" onclick="event.preventDefault(); this.closest('form').submit();" style="padding: 12px 20px; color: #dc3545;">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>تسجيل الخروج</span>
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
            <!-- LOGO -->
            <div class="logo-box">
                <a href="{{route('dashboard.index')}}" class="logo logo-dark text-center">
                    <span class="logo-lg">
                        <img src="{{asset(App\Models\Setting::first()->logo)}}" alt="" height="40">
                    </span>
                            <span class="logo-sm">
                        <img src="{{asset(App\Models\Setting::first()->logo)}}" alt="" height="30">
                    </span>
                </a>
                <a href="{{route('dashboard.index')}}" class="logo logo-light text-center">
                    <span class="logo-lg">
                        <img src="{{asset(App\Models\Setting::first()->logo)}}" alt="" height="40">
                    </span>
                            <span class="logo-sm">
                        <img src="{{asset(App\Models\Setting::first()->logo)}}" alt="" height="30">
                    </span>
                </a>
            </div>

            <div class="clearfix"></div>
        </div> <!-- end container-fluid-->
    </div>
    <!-- end Topbar -->



    @include('owners.layouts.topbar-menu')

</header>
<!-- End Navigation Bar-->

<script>
// دالة عرض تفاصيل الإشعار
function showNotificationDetails(notification) {
    // إذا كان SweetAlert2 موجود
    if (typeof Swal !== 'undefined') {
        const data = notification.data || {};
        let detailsHtml = '';
        
        if (notification.type === 'booking' && Object.keys(data).length > 0) {
            detailsHtml = `
                <div class="notification-details">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h5 class="mb-3"><i class="fas fa-bookmark me-2"></i>رقم الحجز: ${data.booking_number || 'غير محدد'}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row text-right" style="text-align: right;">
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-home text-primary me-2"></i>
                                <strong>الشاليه:</strong> ${data.chalet_name || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-user text-primary me-2"></i>
                                <strong>اسم العميل:</strong> ${data.customer_name || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-calendar-check text-success me-2"></i>
                                <strong>تاريخ الوصول:</strong> ${data.checkin_date || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-calendar-times text-danger me-2"></i>
                                <strong>تاريخ المغادرة:</strong> ${data.checkout_date || 'غير محدد'}
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="detail-item">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                <strong>المبلغ الإجمالي:</strong> 
                                <span class="badge bg-success fs-6">${data.total_amount ? Number(data.total_amount).toLocaleString() + ' ر.ع' : 'غير محدد'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            detailsHtml = `
                <div class="notification-details">
                    <div class="alert alert-light">
                        <p>${notification.message_ar || 'لا توجد تفاصيل إضافية'}</p>
                    </div>
                </div>
            `;
        }
        
        Swal.fire({
            title: `<strong>${notification.title_ar || 'إشعار'}</strong>`,
            html: detailsHtml,
            width: 700,
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                popup: 'notification-modal'
            }
        });
        
        // تحديد الإشعار كمقروء
        if (!notification.is_read) {
            markNotificationAsRead(notification.id);
        }
    } else {
        // إذا لم يكن SweetAlert موجود، استخدم alert عادي
        alert('تفاصيل الإشعار:\n' + JSON.stringify(notification.data, null, 2));
    }
}

// دالة تحديد الإشعار كمقروء
function markNotificationAsRead(notificationId) {
    fetch(`/owner/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }).then(response => {
        if (response.ok) {
            // تحديث عداد الإشعارات
            const badge = document.querySelector('.notification-bell .badge');
            if (badge) {
                const count = parseInt(badge.textContent) || 0;
                if (count > 1) {
                    badge.textContent = count - 1;
                } else {
                    badge.remove();
                }
            }
        }
    });
}
</script>

