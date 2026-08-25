{{-- Slider --}}
<section class="wrapper bg-light" id="sliderHome">
    <div class="container mt-18 mt-md-15 mt-lg-12 mt-xl-12 pt-21 pt-md-10 pt-lg-5 pb-0">
        <div class="swiper-container dots-over dots-start"
        data-drag="true"
        data-margin="5"
        data-dots="true"
        data-autoheight="true"
        style="overflow: hidden; width: 100%;">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach($sliders as $slider)
                        <div class="swiper-slide rounded">
                            <img src="{{ asset($slider->image) }}" class="img-fluid" alt="{{ $slider->title }}" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
