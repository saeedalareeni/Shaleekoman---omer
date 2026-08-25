{{--about--}}
<section class="wrapper bg-light position-relative  ">
    {{-- <img src="{{ asset($about->bg) }}" class="position-absolute top-50 start-0 translate-middle-y" alt="" alt=""> --}}
    <div class="container py-4 py-md-8 overflow-hidden">
        <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center ">
            <div class="col-lg-6 position-relative z-5">
                <h2 class="display-4 mb-4 text-green"> {{ __('back.about_us') }} </h2>
                <p class="fs-md mb-3">
                    {{ app()->getLocale()=='ar'? $about->short_about_ar:$about->short_about_en }}
                </p>
                <p class="fs-md mb-6">
                    {!! app()->getLocale()=='ar'? $about->about_ar:$about->about_en !!}
                </p>
            </div>

            <div class="col-lg-6 d-flex justify-content-center align-items-center ">
                <div class="w-100 h-100 d-flex align-items-center justify-content-center position-relative ">
                    <div
                        class="p-3 border-2 border-green position-relative d-flex align-items-center justify-content-center"
                        style="border-style: dashed !important; min-height: 300px;">

                        <!-- Main Centered Image -->
                        <img src="{{ asset($about->bg) }}" class="img-fluid position-relative" style="z-index: 3;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
