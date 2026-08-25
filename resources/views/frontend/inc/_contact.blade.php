{{--contact--}}
<section class="wrapper bg-light mb-10">
    <div class="overflow-hidden">
        <div class="container py-6 py-md-8">
            <div class="row">
                <div class="col-xl-7 col-xxl-6 mx-auto text-center">
                    <h2 class="display-5 text-green text-center mt-2 mb-10">
                        {{ __('back.contact_us') }}
                    </h2>
                </div>
                <!--/column -->
            </div>
            <div class="row mb-10">
                <div class="col-md-4">
                    <div class="card shadow-sm  bg-gray">
                        <div class="card-body text-center">
                            <h5 class="fw-bold">{{ __('back.email') }} </h5>
                            <a class="text-dark" href="mailto:{{ $contact_us->email }}"> {{ $contact_us->email }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm  bg-gray">
                        <div class="card-body text-center">
                            <h5 class="fw-bold">{{ __('back.phone') }} </h5>
                            <a class="" href="tel:{{ $contact_us->phone }}"> {{ $contact_us->phone }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm  bg-gray">
                        <div class="card-body text-center">
                            <h5 class="fw-bold">{{ __('back.phone') }} </h5>
                            <a class="text-dark">
                                {{ App::getLocale() == 'ar' ? $contact_us->address_ar : $contact_us->address_en }}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-7 px-5">
                   
                    <form action="{{route('send_messages')}}" method="post">
                        @csrf
                        <h6 class="mb-3">  {{ __('back.send_message') }}  </h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label class="mb-2 text-green" for="textInputExample">{{ __('back.name') }}</label>
                                    <input name="name" id="textInputExample" type="text" class="form-control"    placeholder="{{ __('back.name') }}" />
                                    @error('name') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-6">
                                    <label class="mb-2 text-green" for="textInputExample"> {{ __('back.email') }}</label>
                                    <input id="textInputExample" type="text" class="form-control"    placeholder="{{ __('back.email') }}" name="email" required/>
                                    @error('email') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-6">
                                    <label class="mb-2 text-green" for="phone"> {{ __('back.phone') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('back.phone') }}" name="phone" />
                                    @error('phone') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label class="mb-2 text-green" for="textInputExample"> {{ __('back.message') }} </label>
                                    <textarea id="textareaExample" name="message" class="form-control"  placeholder="{{ __('back.message') }}"></textarea>
                                    @error('message') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /.form-floating -->
                        <div class="d-flex justify-content-between align-items-center">
                            <nav class="nav social">
                                <a href="{{ App\Models\Contact::first()->twitter }}"><i class="uil uil-twitter"></i></a>
                                <a href="{{ App\Models\Contact::first()->facebook }}"><i class="uil uil-facebook-f"></i></a>
                                <a href="{{ App\Models\Contact::first()->instagram }}"><i class="uil uil-instagram"></i></a>
                                <a href="{{ App\Models\Contact::first()->youtube }}"><i class="uil uil-youtube"></i></a>
                            </nav>

                            <button type="submit" class="btn btn-gradient gradient-2 rounded-3">{{ __('back.send_message') }}</button>
                        </div>
                    </form> <!-- /form -->

                </div>
                <div class="col-lg-5">
                    <img src="{{asset('frontend')}}/assets/img/contact.png" class="img-fluid" alt="" />
                </div>
            </div>

            <!--/.row -->

            <!-- /.swiper-container -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.overflow-hidden -->
</section>
