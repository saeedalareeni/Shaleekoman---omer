<style>
    /* Force Logo Display on All Devices */
    .navbar-brand {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
        z-index: 999 !important;
        width: auto !important;
        min-width: 60px !important;
    }
    
    .navbar-brand a {
        display: inline-block !important;
        line-height: 0 !important;
    }
    
    .navbar-brand img {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: auto !important;
        height: 50px !important;
        max-width: 180px !important;
        object-fit: contain !important;
        position: relative !important;
        z-index: 999 !important;
    }
    
    /* Override any conflicting styles */
    .navbar-brand,
    .navbar-brand a,
    .navbar-brand img {
        -webkit-transform: none !important;
        transform: none !important;
        -webkit-filter: none !important;
        filter: none !important;
        clip-path: none !important;
        -webkit-clip-path: none !important;
    }
    
    /* Mobile specific adjustments */
    @media (max-width: 991px) {
        .navbar-brand {
            flex: 0 0 auto !important;
            margin-right: auto !important;
        }
    }
    
    @media (max-width: 768px) {
        .navbar-brand img {
            height: 45px !important;
            max-width: 150px !important;
        }
        
        .navbar {
            padding: 0.5rem 1rem !important;
        }
    }
    
    @media (max-width: 480px) {
        .navbar-brand img {
            height: 40px !important;
            max-width: 120px !important;
        }
    }
    
    @media (max-width: 360px) {
        .navbar-brand img {
            height: 35px !important;
            max-width: 100px !important;
        }
    }
</style>

<header class="wrapper bg-white">

    <nav class="navbar container center-nav navbar-expand-lg classic position-absolute navbar-light navbar-bg-light mx-auto custom-navbar">


        <div class="container mx-3 mx-lg-12 flex-lg-row flex-nowrap align-items-center">
            <div class="navbar-brand py-1 w-100">
                <a href="/">
                    <img src="{{ $siteLogo }}" style="width:3.5rem" alt="{{ $siteName }}" />
                </a>
            </div>
            <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
                <div class="offcanvas-header d-lg-none">
                    <a href="/">
                        <img src="{{ $siteLogo }}" style="width:60px" alt="{{ $siteName }}" />
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">
                    @include('frontend.layouts.navbar')
                    <div class="d-lg-none mt-auto pt-6 pb-6 order-4">
                        <a href="mailto:{{App\Models\Contact::first()->email}}" class="link-inverse">
                            {{App\Models\Contact::first()->email}}
                        </a>
                        <br />
                        {{App\Models\Contact::first()->whatsapp}}
                        <br />
                        <nav class="nav social social-white mt-4">
                            <a href="{{App\Models\Contact::first()->twitter_url}}"><i class="uil uil-twitter"></i></a>
                            <a href="{{App\Models\Contact::first()->facebook_url}}"><i class="uil uil-facebook-f"></i></a>
                            <a href="{{App\Models\Contact::first()->linkedin_url}}"><i class="uil uil-linkedin"></i></a>
                            <a href="{{App\Models\Contact::first()->instagram_url}}"><i class="uil uil-instagram"></i></a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- /.navbar-collapse -->
            <div class="navbar-other ms-lg-4">
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    @if(auth('customer')->check())
                    <div class="dropdown notification-list topbar-dropdown d-inline-block ">
                        <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('avatar.png') }}" alt="user-image" class="rounded-circle avatar-sm" width="30">
                            <span class="pro-user-name ms-1">
                                {{ explode(' ', auth()->guard('customer')->user()->name)[0]}}
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                            <!-- item-->
                            <a href="{{ route('user-index.index') }}" class="dropdown-item notify-item">
                                <i class="fa fa-user"></i>
                                <span>{{trans('back.profile')}}</span>
                            </a>
                            <a href="{{ route('account.orders') }}" class="dropdown-item notify-item">
                                <i class="fa fa-calendar"></i>
                                <span>{{trans('back.My_booking')}}</span>
                            </a>
                            <a href="{{ route('account.wishlist') }}" class="dropdown-item notify-item">
                                <i class="fa fa-heart"></i>
                                <span>{{trans('back.wishlist')}}</span>
                            </a>
                            <form method="POST" action="{{ route('customer_logout') }}">
                                @csrf
                                <a href="javascript:void(0);" class="dropdown-item notify-item"
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fa fa-power-off"></i>
                                    <span>{{trans('back.Logout')}} </span>
                                </a>
                            </form>
                        </div>
                    </div>
                   header.blade.php @else
                    <li class="nav-item">
                        <span class="nav-link" >
                            <a class="btn btn-sm btn-outline-primary px-2 py-1 m-0 fs-13" href="{{ route('login') }}">{{ __('back.login') }} </a>
                        </span>
                    </li>
                    @endif
                    <li class="nav-item d-lg-none">
                        <button class="hamburger offcanvas-nav-btn">
                            <span></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script>
    // Force logo visibility on mobile
    document.addEventListener('DOMContentLoaded', function() {
        // Check if logo exists and force display
        const logos = document.querySelectorAll('.navbar-brand img');
        logos.forEach(function(logo) {
            if (logo) {
                logo.style.display = 'block';
                logo.style.visibility = 'visible';
                logo.style.opacity = '1';
                
                // Check parent elements
                let parent = logo.parentElement;
                while (parent && parent !== document.body) {
                    if (parent.classList.contains('navbar-brand')) {
                        parent.style.display = 'block';
                        parent.style.visibility = 'visible';
                        parent.style.opacity = '1';
                    }
                    parent = parent.parentElement;
                }
            }
        });
        
        // Re-check on window resize
        window.addEventListener('resize', function() {
            const logos = document.querySelectorAll('.navbar-brand img');
            logos.forEach(function(logo) {
                if (logo && window.innerWidth <= 768) {
                    logo.style.display = 'block';
                    logo.style.visibility = 'visible';
                    logo.style.opacity = '1';
                }
            });
        });
    });
</script>
