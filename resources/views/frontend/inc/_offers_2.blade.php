{{-- offers_2 --}}
<section class="wrapper bg-white">
    <div class="overflow-hidden">
        <div class="container py-4 py-md-8">

            <ul class="nav nav-tabs nav-pills justify-content-center">
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link justify-content-center  rounded-pill px-4 py-1 py-md-2 {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-{{ $category->id }}">
                            <span>{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach($categories as $category)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $category->id }}">
                        <div class="row gx-md-4 gy-4 align-items-stretch justify-content-center">
                            @forelse($chalets->where('category_id', $category->id)->where('status','approved')->take('20')->take('8') as $chalet)
                                <div class="col-12 col-md-4 col-lg-3">
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
                                </div>
                            @empty
                            <p class="text-center mb-4 "> {{  __('back.not_found') }}</p>
                            @endforelse
                        </div>
                        <div class="text-center m-auto mt-10 ">
                            <a href="{{ route('search-result', ['category' => $category->id]) }}" class="btn btn-gradient gradient-1 btn-icon btn-icon-end rounded-pill">
                                {{ trans('back.show_more') }}
                            </a>

                        </div>

                    </div>

                @endforeach
                </div>
            </div>
        </div>
    </section>
