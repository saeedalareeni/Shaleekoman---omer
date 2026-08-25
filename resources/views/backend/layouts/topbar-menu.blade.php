<div class="topbar-menu">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="{{route('dashboard.index')}}">{{trans('back.dashboard')}}</a>
                </li>

                @can('owners')
                    <li class="has-submenu">
                        <a href="{{route('owners.index')}}">{{trans('back.owners')}}</a>
                    </li>
                @endcan

                @can('customers')
                    <li class="has-submenu">
                        <a href="{{route('customers.index')}}">{{trans('back.customers')}}</a>
                    </li>
                @endcan


                 <li class="has-submenu">
                    <a href="#">
                        {{trans('back.chalets')}}
                        <div class="arrow-down"></div>
                    </a>
                    <ul class="submenu">
                        @can('categories')
                            <li class="has-submenu"><a href="{{route('categories.index')}}"> {{trans('back.categories')}} </a></li>
                        @endcan
                        @can('chalets')
                        <li class="has-submenu">
                            <a href="{{route('chalets.index')}}">{{trans('back.chalets')}}</a>
                        </li>
                        @endcan
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="{{route('booking-customers.index')}}">{{trans('back.booking_customers')}}</a>
                </li>

                @can('posts')
                <li class="has-submenu">
                    <a href="{{route('posts.index')}}">{{trans('back.posts')}}</a>
                </li>
                @endcan

                @can('coupons')
                <li class="has-submenu">
                    <a href="{{route('coupons.index')}}">{{trans('back.coupons')}}</a>
                </li>
                @endcan

                {{--الإعدادات --}}
                <li class="has-submenu">
                    <a href="#">
                        {{trans('back.setting')}}
                        <div class="arrow-down"></div>
                    </a>
                    <ul class="submenu ">
                        @can('cities')
                            <li><a href="{{route('cities.index')}}"> {{trans('back.cities')}} </a></li>
                        @endcan

                        @can('areas')
                            <li><a href="{{route('areas.index')}}"> {{trans('back.areas')}} </a></li>
                        @endcan

                        @can('banners')
                            <li><a href="{{route('banners.index')}}"> {{trans('back.banners')}} </a></li>
                        @endcan

                        @can('users')
                            <li><a href="{{route('users.index')}}"> {{trans('back.users')}} </a></li>
                        @endcan

                        {{--  طرق الدفع--}}
                        @can('payment_methods')
                            <li class="has-submenu">
                                <a href="{{route('paymentsMethod.index')}}">
                                    <span> {{trans('back.payment_methods')}}   </span>
                                </a>
                            </li>
                        @endcan

                        @can('roles')
                            <li><a href="{{route('roles.index')}}"> {{trans('back.roles')}} </a></li>
                        @endcan

                        <div class="dropdown-divider"></div>

                        @can('setting')
                            <li><a href="{{route('setting.index')}}"> {{trans('back.setting')}} </a></li>
                        @endcan
                    </ul>
                </li>



                  {{--من نحن--}}
                  <li class="has-submenu">
                    <a href="#">
                        {{trans('back.about_us')}}
                        <div class="arrow-down"></div>
                    </a>
                    <ul class="submenu">
                        {{--من نحن--}}
                        @can('sliders')
                            <li>
                                <a href="{{route('sliders.index')}}">
                                    <span> {{trans('back.sliders')}} </span>
                                </a>
                            </li>
                        @endcan

                        @can('about_us')
                            <li>
                                <a href="{{route('abouts.index')}}">
                                    <span> {{trans('back.about_us')}} </span>
                                </a>
                            </li>
                        @endcan

                        {{--معلومات--}}
                        @can('about_us')
                            <li>
                                <a href="{{route('Infos.index')}}">
                                    <span> {{trans('back.info')}} </span>
                                </a>
                            </li>
                        @endcan

                        {{--اتصل بنا--}}
                        @can('contact_us')
                            <li>
                                <a href="{{route('contacts.index')}}">
                                    <span> {{trans('back.contact_us')}} </span>
                                </a>
                            </li>
                        @endcan
                        @can('pages')
                            <li>
                                <a href="{{route('pages.index')}}">
                                    <span> {{trans('back.pages')}} </span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>


                {{--رسائل العملاء--}}
                @can('customer_messages')
                    <li>
                        <a href="{{route('customer-messages.index')}}">
                            <span> {{trans('back.messages')}} </span>
                        </a>
                    </li>
                @endcan



                <li class="has-submenu">
                    <a href="/"> {{trans('back.frontend')}}</a>
                </li>

            </ul>

            <!-- End navigation menu -->

            <div class="clearfix"></div>
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>
<!-- end navbar-custom -->
