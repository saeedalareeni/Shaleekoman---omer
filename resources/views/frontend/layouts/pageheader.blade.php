@php
    $contact = \App\Models\Contact::first();
    $about = \App\Models\About::first();
@endphp

<header class="wrapper">
    <nav class="navbar container navbar-expand-lg classic  navbar-light navbar-bg-light ">
      <div class="container mx-3 mx-lg-12 flex-lg-row flex-nowrap align-items-center">
        <div class="navbar-brand py-1 w-100">
          <a href="/">
            <img src="{{asset(App\Models\Setting::first()->logo)}}" style="width: 3.5rem" alt="logo" />
          </a>
        </div>

        <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
          <div class="offcanvas-header d-lg-none">
              <a href="/"><img src="{{asset(App\Models\Setting::first()->logo)}}" width="60px" alt="logo" /></a>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                      aria-label="Close"></button>
          </div>
          <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">

              @include('frontend.layouts.navbar')
              <!-- /.navbar-nav -->
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
              <!-- /offcanvas-nav-other -->
          </div>
          <!-- /.offcanvas-body -->
      </div>

          <div class=" navbar-other ms-lg-4">
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
                @else
                <li class="nav-item">
                    <span class="nav-link " >
                        <a class="btn btn-sm btn-outline-primary px-2 py-1 m-0 fs-13" href="{{ route('login') }}">{{ __('back.login') }} </a>
                    </span>
                </li>
                @endif


                <li class="nav-item d-lg-none">
                  <button class="hamburger offcanvas-nav-btn"><span></span></button>
                </li>
              </ul>
              <!-- /.navbar-nav -->
            </div>
          <!-- /.navbar-other -->
        </div>
        <!-- /.container -->
      </nav>
      <!-- /.navbar -->

      <!-- /.offcanvas -->



      <!-- /.offcanvas -->
    </header>
