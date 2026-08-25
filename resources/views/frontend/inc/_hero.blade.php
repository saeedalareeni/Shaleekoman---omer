{{--heroo and search--}}
<section class="content-wrapper min-vh-80">
    <div class="container-fluid position-relative">
        <div class="row">
            <!-- Left Section (Text & Button) -->
            <div class="col-md-12 col-lg-6 bg-soft-primary pt-18 pt-lg-18 pb-5 pb-lg-9"
                 style="border-radius: 0 0 48px 0">
                <div class="ps-0 ps-md-14">
                    <div class="row">
                        <div class="col-sm-12 col-xxl-9 text-center text-sm-start" data-cues="slideInDown" data-group="page-title"
                             data-interval="-200" data-delay="500">
                             <h2 class="display-1 fs-56 mb-7 mt-0 mt-lg-5 ls-xs pe-xl-5 pe-xxl-0">
                                {!! trans('back.heading') !!}
                            </h2>
                            <p class="fs-23 lh-base mb-7 pe-lg-5 pe-xl-5 pe-xxl-0">
                                {{ trans('back.subheading') }}
                            </p>

                            <div class="mb-9">
                                <a href="{{ route('owner.register') }}"  class="btn btn-lg btn-gradient gradient-1 btn-icon btn-icon-end rounded-pill">  انضم إلينا<i class="uil uil-arrow-up-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Image for Mobile View -->
                        <div class="mt-5 d-block d-lg-none">
                            <img src="{{asset('frontend/assets/img/photos/bg37.png')}}" class="img-fluid"  alt="Background Image" />
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="col-lg-6 d-none d-lg-block wrapper image-wrapper bg-cover bg-image bg-xs-none bg-primary pt-12 pt-lg-18 pb-5 pb-lg-9"
                data-image-src="{{asset('frontend')}}/assets/img/photos/Group 43.png" style="border-radius: 0 0 0 48px;">
                <div class="position-relative" style="inset-inline-start: -20%;">
                    <img src="{{asset('frontend/assets/img/photos/bg37.png')}}" class="img-fluid" alt="Background Image" />
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        @include('frontend.inc._filter', ['style' => 'position-absolute mx-auto custom-bottom'])

    </div>
</section>

<style>
    .select2-container--default .select2-selection--single {
        font-size: .7rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 40px !important;
    }
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{
      background-color: #127551;
    }
</style>
