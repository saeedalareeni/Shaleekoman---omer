<!-- Navigation Bar-->
<style>
    /* Mobile Logo Fix for Backend */
    @media (max-width: 768px) {
        .logo-box {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .logo-box img {
            display: block !important;
            visibility: visible !important;
            height: 35px !important;
            width: auto !important;
            max-width: 150px;
            object-fit: contain;
        }
    }
    
    @media (max-width: 480px) {
        .logo-box img {
            height: 30px !important;
            max-width: 120px;
        }
    }
</style>

<header id="topnav" style="background: linear-gradient(to right, #14b024, #1e5c21);">

    <!-- Topbar Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                <li class="dropdown notification-list">
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
                                    @elseif($properties['native'] == "العربية")
                                    @endif
                                    {{ $properties['native'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>
                {{-- نهاية كود تغيير اللغة  --}}

                {{--   اليوزر --}}
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{asset('backend/avatar.png')}}" alt="user-image" class="rounded-circle">
                        <span class="pro-user-name ml-1">
                          {{auth()->user()->name}}
                     <i class="mdi mdi-chevron-down"></i>
                </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                        <!-- logout-->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="javascript:void(0);" class="dropdown-item notify-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fe-log-out"></i>
                                <span>{{trans('back.Logout')}} </span>
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



    @include('backend.layouts.topbar-menu')

</header>
<!-- End Navigation Bar-->

