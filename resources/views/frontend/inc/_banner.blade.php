<section class="content-wrapper min-vh-80 mb-7"  >
    <div class="container">
        <div class="row">
            @foreach($banners as $banner)
            <div class="col-md-4 mb-3">
                <img src="{{ asset($banner->image) }}" class="img-fluid rounded shadow" alt="Banner">
            </div>
            @endforeach
        </div>
    </div>
</section>
