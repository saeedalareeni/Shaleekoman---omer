<!DOCTYPE html>
<html lang="en">

    @include('owners.layouts.head')
    @include('owners.layouts.icons-fix-owner')

<body data-layout="horizontal" data-topbar="light" >

    <!-- لن يتم عرض loader افتراضيًا -->

    <!-- Begin page -->
        <div id="wrapper">

            @include('owners.layouts.header-new')

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="page-title">@yield('title')</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        @include('flash-message')

                        @yield('content')

                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                <!-- Footer Start -->
                {{-- @include('owners.layouts.footer') --}}
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
{{--        @include('owners.layouts.right-bar')--}}
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
{{--        <div class="rightbar-overlay"></div>--}}


    @include('owners.layouts.script')

    @include('sweetalert::alert')

    </body>
</html>
