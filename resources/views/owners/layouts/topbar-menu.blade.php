<style>
    .nav-tab-notifications {
        position: relative;
    }
    
    .nav-tab-notifications .badge {
        position: absolute !important;
        top: 8px !important;
        right: 5px !important;
        background: #dc3545 !important;
        color: white !important;
        font-size: 10px !important;
        padding: 2px 6px !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        min-width: 18px !important;
        text-align: center !important;
    }
    
    .nav-tab-notifications a {
        position: relative !important;
        padding-right: 25px !important;
    }
</style>

<div class="topbar-menu">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="{{route('owner.dashboard')}}">{{trans('back.dashboard')}}</a>
                </li>

                <li class="has-submenu">
                    <a href="{{route('owner.chalets.index')}}">{{trans('back.chalets')}}</a>
                </li>

                <li class="has-submenu">
                    <a href="{{route('owner.bookings.index')}}">{{trans('back.booking_customers')}}</a>
                </li>

                <li class="has-submenu">
                    <a href="{{route('owner.expenses.index')}}">{{trans('back.expenses')}}</a>
                </li>

                <li class="has-submenu nav-tab-notifications">
                    <a href="{{route('owner.notifications.index')}}">
                        <span>{{trans('back.notifications') ?? 'الإشعارات'}}</span>
                        @if(auth('owner')->user()->unread_notifications_count > 0)
                            <span class="badge badge-danger" style="position: absolute; top: 5px; right: -5px; font-size: 10px;">
                                {{ auth('owner')->user()->unread_notifications_count }}
                            </span>
                        @endif
                    </a>
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
