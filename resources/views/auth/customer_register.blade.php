@extends('frontend.layouts.weekend_master')

@section('title_page')
    {{trans('back.Register Account')}}
@endsection

@section('content')

<section class="mt-12 mb-12 ">
    <div class="container">
    <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="text-center">
                            <h4 class="text-uppercase mt-0 pt-0">
                                {{trans('back.Register Account')}}
                            </h4>
                        </div>
                        <form class="pt-2" action="{{route('customer_register_store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-2 col-md-12">
                                    <label class="form-label">{{trans('back.name')}}</label>
                                    <input type="text" class="form-control" placeholder="{{trans('back.name')}}" name="name" value="{{old('name')}}" required>
                                    @error('name') <div class="text-danger">{{$message}}</div> @enderror
                                </div>

                                <div class="mb-2 col-md-12">
                                    <label class="form-label">{{trans('back.email')}}</label>
                                    <b class="text-danger">*</b>
                                    <input type="email" class="form-control" placeholder="{{trans('back.email')}}" name="email" value="{{old('email')}}" required>
                                    @error('email') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                                <div class="mb-2 col-md-12">
                                    <label class="form-label">{{trans('back.password')}}</label>
                                    <input type="password" class="form-control" placeholder="{{trans('back.password')}}" name="password" value="{{old('password')}}" required>
                                    @error('password') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="form-label">{{trans('back.password')}}</label>
                                    <b class="text-danger">*</b>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="{{trans('back.password_confirmation')}}" value="{{old('password_confirmation')}}" required>
                                    @error('password_confirmation') <div class="text-success">{{$message}}</div> @enderror
                                </div>
                                <div class="mb-2 col-md-12">
                                    <label class="form-label">{{trans('back.phone')}}</label>
                                    <b class="text-danger">*</b>
                                    <input type="tel"  style="direction: ltr !important;" class="form-control" placeholder="{{ app()->getLocale() == 'ar' ? '+968XXXXXXXX' : '+968XXXXXXXX' }}" class="form-control" placeholder="{{trans('back.phone')}}" name="phone" value="{{old('phone')}}" required>
                                    @error('phone') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                                <div class="mb-2 col-md-12">
                                    <label class="form-label">{{trans('back.address')}}</label>
                                    <input type="text" class="form-control" placeholder="{{trans('back.address')}}" name="address" value="{{old('address')}}" required>
                                    @error('address') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <div class="mb-2 text-center mt-2">
                                <button class="btn btn-primary w-100" type="submit"> {{trans('back.Signup')}}</button>
                            </div>
                            <a href="{{ route('auth.google.withType',['type' => 'customer']) }}"class="btn btn-outline-secondary  w-100 btn-sm mt-2 text-dark">
                                <img src="{{ asset('images/auth/google-logo.svg') }}" class="me-2" alt=""> {{trans('back.Login with Google')}}
                            </a>
                        </form>

                        <div class="col-12 text-center mt-3">
                            <h5 class="mb-0">
                                {{trans('back.Already have an account ?')}}
                                <a href="{{route('login')}}" class="text-primary">
                                    {{trans('back.login')}}
                                </a>
                            </h5>
                        </div>

                    </div>

                </div>
                <!-- end card -->

            </div>
        </div>
    </div>
</section>
@endsection
