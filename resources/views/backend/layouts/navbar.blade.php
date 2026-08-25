<!-- Topbar Start -->
<div class="navbar-custom" style="background-color: #efece2">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fas fa-bell noti-icon"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge badge-danger rounded-circle noti-icon-badge loader__element" id="notifications_count" style="width: 10px; height: 10px;top: 12px; left: 18px" >
                    </span>
                    @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        @if (! auth()->user()->unreadNotifications->count() == 0)
                            <span class="float-right">
                                <a href="{{route('markAsRead_all')}}" class="text-dark">
                                    <small>{{trans('back.Clear_all')}}</small>
                                </a>
                            </span>
                        @endif
                        {{trans('back.Notifications')}}
                        <br>
                        <small class="pt-2" >
                            {{trans('back.Number_of_unread_notifications')}}
                            <span class="text-danger font-16">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        </small>
                    </h5>
                </div>

                <div class="slimscroll noti-scroll" >
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <a href="#" class="dropdown-item notify-item active" id="unreadNotifications">
                            <div class="notify-icon">
                                <i class="fas fa-bell text-danger"></i>
                            </div>
                            <p class="notify-details">
                                {{ $notification->data['title'] ?? '' }}
                                <br>
                                {{ $notification->data['body'] ?? '' }}
                                <br>
                                {{ $notification->data['date'] ?? '' }}
                            </p>
                            <p class="text-muted mb-0 user-msg">
                                <small>{{ $notification->created_at->diffForHumans() }}
                                </small>
                            </p>
                        </a>
                        <a href="{{route('markAsRead', $notification->id)}}" class="float-right mr-1"  >
                           {{trans('back.make_it_read')}}
                        </a>
                    @empty
                        <div class="dropdown-item text-center text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p>{{trans('back.no_notifications')}}</p>
                        </div>
                    @endforelse
                </div>

                @if (! auth()->user()->unreadNotifications->count() == 0)
                    <a href="{{route('markAsRead_all')}}" class="dropdown-item text-center text-primary notify-item notify-all">
                       {{trans('back.Clear_all')}}
                        <i class="fi-arrow-right"></i>
                    </a>
                    @can('all_notifications')
                    <a href="{{route('all_notifications')}}" class="dropdown-item text-center text-primary notify-item notify-all">
                        {{trans('back.all_notifications')}}
                        <i class="fi-arrow-right"></i>
                    </a>
                    @endcan
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
