<!DOCTYPE html>
<html lang="en">

    @include('backend.layouts.head')

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            @include('backend.layouts.navbar_employee')
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('backend.layouts.left-side-menu_employee')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                <div class="content mt-1">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        @include('flash-message')

                        @yield('content')

                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                <!-- Footer Start -->
                @include('backend.layouts.footer')
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        @include('backend.layouts.right-bar')
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

{{--        <a href="javascript:void(0);" class="right-bar-toggle demos-show-btn">--}}
{{--            <i class="mdi mdi-cog-outline mdi-spin"></i> &nbsp;Choose Demos--}}
{{--        </a>--}}

    @include('backend.layouts.script')

    </body>
</html>
