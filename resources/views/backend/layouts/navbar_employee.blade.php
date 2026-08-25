<!-- navbar employee -->
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        {{-- التنبيهات  --}}
{{--        <li class="dropdown notification-list">--}}
{{--            <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">--}}
{{--                <i class="fe-bell noti-icon"></i>--}}
{{--                <span class="badge badge-danger rounded-circle noti-icon-badge">9</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-right dropdown-lg">--}}

{{--                <!-- item-->--}}
{{--                <div class="dropdown-item noti-title">--}}
{{--                    <h5 class="m-0">--}}
{{--                        <span class="float-right">--}}
{{--                            <a href="" class="text-dark">--}}
{{--                                <small>Clear All</small>--}}
{{--                            </a>--}}
{{--                        </span>Notification--}}
{{--                    </h5>--}}
{{--                </div>--}}

{{--                <div class="slimscroll noti-scroll">--}}

{{--                    <!-- item-->--}}
{{--                    <a href="javascript:void(0);" class="dropdown-item notify-item active">--}}
{{--                        <div class="notify-icon">--}}
{{--                            <img src="{{asset('backend/assets/images/users/user-1.jpg')}}" class="img-fluid rounded-circle" alt="" /> </div>--}}
{{--                        <p class="notify-details">Cristina Pride</p>--}}
{{--                        <p class="text-muted mb-0 user-msg">--}}
{{--                            <small>Hi, How are you? What about our next meeting</small>--}}
{{--                        </p>--}}
{{--                    </a>--}}

{{--                    <!-- item-->--}}
{{--                    <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                        <div class="notify-icon bg-primary">--}}
{{--                            <i class="mdi mdi-comment-account-outline"></i>--}}
{{--                        </div>--}}
{{--                        <p class="notify-details">Caleb Flakelar commented on Admin--}}
{{--                            <small class="text-muted">1 min ago</small>--}}
{{--                        </p>--}}
{{--                    </a>--}}

{{--                    <!-- item-->--}}
{{--                    <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                        <div class="notify-icon">--}}
{{--                            <img src="{{asset('backend/assets/images/users/user-4.jpg')}}" class="img-fluid rounded-circle" alt="" /> </div>--}}
{{--                        <p class="notify-details">Karen Robinson</p>--}}
{{--                        <p class="text-muted mb-0 user-msg">--}}
{{--                            <small>Wow ! this admin looks good and awesome design</small>--}}
{{--                        </p>--}}
{{--                    </a>--}}

{{--                    <!-- item-->--}}
{{--                    <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                        <div class="notify-icon bg-warning">--}}
{{--                            <i class="mdi mdi-account-plus"></i>--}}
{{--                        </div>--}}
{{--                        <p class="notify-details">New user registered.--}}
{{--                            <small class="text-muted">5 hours ago</small>--}}
{{--                        </p>--}}
{{--                    </a>--}}

{{--                    <!-- item-->--}}
{{--                    <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                        <div class="notify-icon bg-info">--}}
{{--                            <i class="mdi mdi-comment-account-outline"></i>--}}
{{--                        </div>--}}
{{--                        <p class="notify-details">Caleb Flakelar commented on Admin--}}
{{--                            <small class="text-muted">4 days ago</small>--}}
{{--                        </p>--}}
{{--                    </a>--}}

{{--                    <!-- item-->--}}
{{--                    <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                        <div class="notify-icon bg-secondary">--}}
{{--                            <i class="mdi mdi-heart"></i>--}}
{{--                        </div>--}}
{{--                        <p class="notify-details">Carlos Crouch liked--}}
{{--                            <b>Admin</b>--}}
{{--                            <small class="text-muted">13 days ago</small>--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </div>--}}

{{--                <!-- All-->--}}
{{--                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">--}}
{{--                    View all--}}
{{--                    <i class="fi-arrow-right"></i>--}}
{{--                </a>--}}

{{--            </div>--}}
{{--        </li>--}}

        {{-- كود تغيير اللغة  --}}
        <li class="">
            <div class="dropdown  nav-itemd-none d-md-flex">
                <a href="#" class="d-flex  nav-item nav-link pl-0 country-flag1" data-toggle="dropdown"
                   aria-expanded="false">
                    @if (App::getLocale() == 'ar')
                        <strong class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }} </strong>
                    @else
                        <strong class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}</strong>
                    @endif
                    <div class="my-auto">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            @if($properties['native'] == "English")
                                {{--                                        <img src="{{asset('flags/english.png')}}" alt="english" width="24px">--}}
                            @elseif($properties['native'] == "العربية")
                                {{--                                        <img src="{{asset('flags/arabic.png')}}" alt="arabic" width="24px">--}}
                            @endif
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </li>
        {{-- نهاية كود تغيير اللغة  --}}

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{asset('backend/assets/images/users/user-1.jpg')}}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                          {{auth()->user()->name}}
                     <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                <div class="dropdown-divider"></div>

                <!-- logout-->
                <form method="POST" action="{{ route('employee_logout') }}">
                    @csrf
                    <a href="javascript:void(0);" class="dropdown-item notify-item" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fe-log-out"></i>
                        <span>{{trans('back.logout')}} </span>
                    </a>
                </form>


            </div>
        </li>

    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{route('employee.index')}}" class="logo logo-dark text-center">
            <span class="logo-lg">
                <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="" height="60">
            </span>
            <span class="logo-sm">
                <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="" height="60">
            </span>
        </a>
        <a href="{{route('employee.index')}}" class="logo logo-light text-center">
            <span class="logo-lg">
                <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="" height="60">
            </span>
            <span class="logo-sm">
                <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="" height="60">
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
            <h4 class="page-title-main" >@yield('title_page')</h4>
        </li>

    </ul>

</div>
<!-- end Topbar -->
