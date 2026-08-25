@extends('frontend.layouts.weekend_master')

@section('title_page')
    {{trans('back.forgot_password')}}
@endsection

@section('content')


<section class="mt-18 mb-12 mt-lg-17">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                <div class="card-body p-4">
                        <div class="text-center">
                            <h4 class="text-uppercase mt-0 mb-3">
                                <h5 class="mb-3 font-weight-semibold">  {{ trans('back.forgot_password') }}  </h5>
                            </h4>
                        </div>
                        @php
                            $resetType = $resetType ?? 'customer';
                            $sendCodeRoute = $resetType === 'owner' ? route('owner.sendCode') : route('user.sendCode');
                        @endphp
                        <form method="POST" action="{{ $sendCodeRoute }}">
                            @csrf
                            <input type="hidden" name="user_type" value="{{ $resetType }}">
                            <div class="form-group">
                                <label>  {{ trans('back.enter_email') }} </label>
                                <input class="form-control" name="email"
                                    placeholder="Enter your email" type="email">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <p> {{ trans('back.reset_password_title') }}</p>
                            <button type="submit" class="mb-2 btn btn-primary">{{ trans('back.reset_password') }}</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
