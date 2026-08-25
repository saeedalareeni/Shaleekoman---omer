<!-- Topbar Start -->
<div class="navbar-custom" style="background-color: #efece2">
    <ul class="list-unstyled topnav-menu float-right mb-0">

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
            
            // Debug
            if(config('app.debug')) {
                \Log::info('Navbar Notifications Debug', [
                    'owner_id' => $currentOwnerId,
                    'notifications_count' => $ownerNotifications->count(),
                    'unread_count' => $unreadCount,
                    'first_notification' => $ownerNotifications->first() ? $ownerNotifications->first()->toArray() : 'none'
                ]);
            }
        @endphp
        
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fas fa-bell noti-icon"></i>
                @if($unreadCount > 0)
                <span class="badge badge-danger rounded-circle noti-icon-badge" style="position: absolute; top: -5px; right: -5px;">
                    {{ $unreadCount }}
                </span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                <!-- Header -->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        @if ($unreadCount > 0)
                            <span class="float-right">
                                <a href="#" onclick="markAllAsRead()" class="text-dark">
                                    <small>تحديد الكل كمقروء</small>
                                </a>
                            </span>
                        @endif
                        الإشعارات
                    </h5>
                    <small class="text-muted">
                        لديك <span class="text-danger font-weight-bold">{{ $unreadCount }}</span> إشعار غير مقروء
                    </small>
                </div>

                <div class="slimscroll noti-scroll" style="max-height: 350px;">
                    @if($ownerNotifications->count() > 0)
                        @foreach($ownerNotifications as $notification)
                            <a href="#" class="dropdown-item notify-item" onclick="showNotificationModal({{ json_encode($notification) }}); return false;">
                                <div class="d-flex align-items-start">
                                    <div class="notify-icon bg-info" style="min-width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                        <i class="fas fa-bell text-white"></i>
                                    </div>
                                    
                                    <div class="flex-grow-1">
                                        <p class="notify-details mb-1">
                                            <strong>{{ $notification->title_ar ?? 'حجز جديد' }}</strong>
                                        </p>
                                        
                                        @if($notification->type == 'booking' && $notification->data && is_array($notification->data))
                                            <div class="text-muted small">
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
                                        @else
                                            <p class="text-muted small mb-1">
                                                {{ $notification->message_ar ?? '' }}
                                            </p>
                                        @endif
                                        
                                        <p class="text-muted mb-0">
                                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <p class="text-muted">لا توجد إشعارات جديدة</p>
                        </div>
                    @endif
                </div>

                @if ($unreadCount > 0)
                    <a href="{{ route('owner.dashboard') }}#notifications" class="dropdown-item text-center text-primary notify-item notify-all">
                        عرض جميع الإشعارات
                        <i class="fi-arrow-right"></i>
                    </a>
                @endif
            </div>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{asset('backend/assets/images/users/user.png')}}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                          {{auth()->user()->name}}
                     <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">{{trans('back.Welcome')}}</h6>
                    <p class="text-muted pt-2">
                        {{auth()->user()->name}} <br>
                        {{auth()->user()->email}}
                    </p>
                </div>


                <!-- item-->
                <a href="{{route('setting.index')}}" class="dropdown-item notify-item">
                    <i class="fe-settings"></i>
                    <span>{{trans('back.setting')}}</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- logout-->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="javascript:void(0);" class="dropdown-item notify-item" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fe-log-out"></i>
                        <span>{{trans('back.Log_Out')}} </span>
                    </a>
                </form>


            </div>
        </li>


    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{route('dashboard.index')}}" class="logo logo-dark text-center">
                        <span class="logo-lg">
                            <img src="{{asset(App\Models\Setting::first()->logo_image)}}" alt="" height=60">
                        </span>
            <span class="logo-sm">
                            <img src="{{asset(App\Models\Setting::first()->logo_image)}}" alt="" height="60">
                        </span>
        </a>
        <a href="{{route('dashboard.index')}}" class="logo logo-light text-center">
            <span class="logo-lg">
                <img src="{{asset(App\Models\Setting::first()->logo_image)}}" alt="" height="60">
            </span>
            <span class="logo-sm">
                <img src="{{asset(App\Models\Setting::first()->logo_image)}}" alt="" height="60">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect">
                <i class="fe-menu"></i>
            </button>
        </li>

        <li>
            <h4 class="page-title-main" style="font-weight:600; color: #d07300">@yield('title_page')</h4>
        </li>

    </ul>

</div>
<!-- end Topbar -->

<!-- Modal للإشعارات -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalTitle">تفاصيل الإشعار</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="notificationModalBody">
                <!-- سيتم ملء المحتوى بواسطة JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" id="markAsReadBtn" onclick="markNotificationAsRead()">تحديد كمقروء</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentNotificationId = null;

function showNotificationModal(notification) {
    currentNotificationId = notification.id;
    const title = notification.title_ar || notification.title_en;
    const message = notification.message_ar || notification.message_en;
    
    document.getElementById('notificationModalTitle').innerText = title;
    
    let bodyHtml = '';
    
    if (notification.type === 'booking' && notification.data) {
        const data = notification.data;
        bodyHtml = `
            <div class="notification-details">
                ${data.booking_number ? `
                <div class="alert alert-info mb-3">
                    <h5><i class="fas fa-bookmark me-2"></i>رقم الحجز: ${data.booking_number}</h5>
                </div>` : ''}
                
                <div class="row">
                    ${data.chalet_name ? `
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-home text-primary me-2"></i>
                            <strong>الشاليه:</strong> ${data.chalet_name}
                        </div>
                    </div>` : ''}
                    
                    ${data.customer_name ? `
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-user text-primary me-2"></i>
                            <strong>اسم العميل:</strong> ${data.customer_name}
                        </div>
                    </div>` : ''}
                    
                    ${data.checkin_date ? `
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-calendar-check text-success me-2"></i>
                            <strong>تاريخ الوصول:</strong> ${data.checkin_date}
                        </div>
                    </div>` : ''}
                    
                    ${data.checkout_date ? `
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-calendar-times text-danger me-2"></i>
                            <strong>تاريخ المغادرة:</strong> ${data.checkout_date}
                        </div>
                    </div>` : ''}
                    
                    ${data.total_amount ? `
                    <div class="col-md-12 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                            <strong>المبلغ الإجمالي:</strong> 
                            <span class="badge bg-success fs-6">${Number(data.total_amount).toLocaleString()} ر.ع</span>
                        </div>
                    </div>` : ''}
                </div>
                
                ${message ? `
                <div class="alert alert-light mt-3">
                    <p class="mb-0"><strong>الرسالة الكاملة:</strong></p>
                    <p class="mt-2">${message}</p>
                </div>` : ''}
            </div>
        `;
    } else {
        bodyHtml = `<div class="alert alert-light"><p>${message}</p></div>`;
    }
    
    document.getElementById('notificationModalBody').innerHTML = bodyHtml;
    
    // إظهار/إخفاء زر تحديد كمقروء
    if (notification.is_read) {
        document.getElementById('markAsReadBtn').style.display = 'none';
    } else {
        document.getElementById('markAsReadBtn').style.display = 'block';
    }
    
    $('#notificationModal').modal('show');
}

function markNotificationAsRead() {
    if (!currentNotificationId) return;
    
    $.ajax({
        url: `/owner/notifications/${currentNotificationId}/read`,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // إخفاء زر تحديد كمقروء
            document.getElementById('markAsReadBtn').style.display = 'none';
            // تحديث عداد الإشعارات
            location.reload();
        },
        error: function() {
            alert('حدث خطأ أثناء تحديث الإشعار');
        }
    });
}

function markAllAsRead() {
    if (!confirm('هل أنت متأكد من تحديد جميع الإشعارات كمقروءة؟')) return;
    
    $.ajax({
        url: `/owner/notifications/mark-all-read`,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            location.reload();
        },
        error: function() {
            alert('حدث خطأ أثناء تحديث الإشعارات');
        }
    });
}
</script>
