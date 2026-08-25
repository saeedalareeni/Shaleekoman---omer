<!-- ========== المنيو الخاص بالموظف ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{URL::asset('backend/assets/images/users/user-1.jpg')}}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
            <p class="text-muted pt-2">
                @if (app()->getLocale() == 'ar')
                @else
                    {{auth()->user()->name_en}} <br>
                @endif
                    {{auth()->user()->email}}
            </p>

        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">
                <h3 class="menu-title text-center font-weight-bold font-14 " style="color: #6951ce">{{trans('auth.garage_software')}} </h3>

                <li>
                    <a href="{{route('employee.index')}}">
                        <i class="fas fa-home"></i>
                        <span> {{trans('back.dashboard')}} </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('Messages.create')}}">
                        <i class="far fa-comment"></i>
                        <span> {{trans('back.send_message')}} </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('Messages.index')}}">
                        <i class="fas fa-comments"></i>
                        <span> {{trans('back.my_messages')}} </span>
                    </a>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
