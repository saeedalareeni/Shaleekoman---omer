{{--offers--}}
<section class="wrapper bg-light">
    <div class="overflow-hidden">
        <div class="container py-5 py-md-8">

            <div class="row">
                <div class="col-xl-7 col-xxl-6 mx-auto text-center">
                    <h2 class="display-7 text-green text-center mt-2 mb-5">
                        {{ trans('back.offer_weekend_feature') }}
                    </h2>
                </div>
            </div>

            <div class="swiper-container nav-bottom nav-start nav-color mb-14" data-margin="30" data-dots="false" data-nav="true" data-items-lg="3" data-items-md="2" data-items-xs="1">
                <div class="swiper overflow-visible pb-2">
                    <div class="swiper-wrapper">
                        @forelse($chalets->where('is_feature', 1)->where('status','approved')->take('20') as $chalet)
                        <div class="swiper-slide">
                            <article>
                                <div class="card bg-gray p-3 position-relative rounded-4 shadow-lg h-100">
                                    <span class="badge badge-lg bg-green fs-14 rounded-pill ms-2 position-absolute" style="z-index: 200; left: 8%; top: 9%;"   >{{ $chalet->default_day_price }} {{ trans('back.currency') }}</span>
                                    @include('frontend.inc._btn_add_wishlist', ['style' => 'position-absolute text-white'])
                                    <figure class="position-relative z-5 card-img-top rounded-4 overlay overlay-2" style="z-index: 155">
                                        <a href="{{ route('showChalet', $chalet->slug) }}"><img src="{{ asset($chalet->main_image??'no_image.png') }}" class="rounded-4" alt="{{ app()->getLocale() == 'ar' ? $chalet->name_ar : $chalet->name_en }}" /></a>
                                        <figcaption>
                                            <h5 class="from-top mb-0"> {{trans('back.show_details')}}</h5>

                                        </figcaption>
                                    </figure>
                                    <div class="card-body py-1 px-1 d-flex flex-column">
                                        <div class="post-header mb-2 text-center">
                                            <h2 class="post-title h3 mt-1 mb-0">
                                                <a class="link-dark fs-18" href="{{ route('showChalet', $chalet->slug) }}">
                                                    {{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}
                                                </a>
                                            </h2>
                                            <p class="ms-auto mb-2">
                                                {{ app()->getLocale()=='ar'? $chalet->city->name_ar:$chalet->city->name_en }} ({{ app()->getLocale()=='ar'? $chalet->area->name_ar:$chalet->area->name_en }})
                                            </p>
                                        </div>

                                        <p class="flex-grow-1 m-0">
                                            {{ app()->getLocale() == 'ar' ? $chalet->description_ar : $chalet->description_en }}
                                        </p>
                                        <div class=" d-flex justify-content-center align-items-center">
                                            <a href="{{ route('showChalet', $chalet->slug) }}" class="btn btn-sm btn-outline-green rounded-4 mx-1 btn-icon icon-start rounded-top-right-0 rounded-top-left-0">
                                                {{trans('back.show_details')}}
                                                <i class="fas fa-chevron-left ms-1"></i>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- /article -->
                        </div>
                        @empty
                        <p class="text-center mb-4 "> {{  __('back.not_found') }}</p>
                        @endforelse
                        <!--/.swiper-slide -->
                    </div>
                    <!--/.swiper-wrapper -->
                </div>
                <!-- /.swiper -->
            </div>
        </div>
    </div>
</section>
