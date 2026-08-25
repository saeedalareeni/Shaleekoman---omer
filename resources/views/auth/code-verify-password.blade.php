@extends('frontend.layouts.weekend_master')

@section('title_page')
    {{ trans('back.reset_password') }}
@endsection

@section('content')
@php
    $resetType = $resetType ?? session('password_reset_user_type', 'customer');
    $checkCodeRoute = $resetType === 'owner' ? route('owner.checkCode') : route('user.checkCode');
    $resetRoute = $resetType === 'owner' ? route('owner.reset') : route('user.reset');
@endphp

<section class="mt-18 mb-12 mt-lg-17">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h5 class="mb-3 font-weight-semibold">{{ trans('back.reset_password') }}</h5>
                        </div>

                        @if(!session('checked'))
                            <form method="POST" action="{{ $checkCodeRoute }}">
                                @csrf
                                <input type="hidden" name="user_type" value="{{ $resetType }}">
                                <div class="form-group">
                                    <label>{{ app()->getLocale() == 'ar' ? 'رمز التحقق' : 'Verification code' }}</label>
                                    <input class="form-control" name="reset_code" type="text" required>
                                    @error('reset_code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="mb-2 btn btn-primary">{{ app()->getLocale() == 'ar' ? 'تحقق' : 'Verify' }}</button>
                            </form>
                        @else
                            <form method="POST" action="{{ $resetRoute }}">
                                @csrf
                                <input type="hidden" name="user_type" value="{{ $resetType }}">
                                <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                                <div class="form-group">
                                    <label>{{ trans('back.password') }}</label>
                                    <input class="form-control" name="password" type="password" required>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ app()->getLocale() == 'ar' ? 'تأكيد كلمة المرور' : 'Confirm password' }}</label>
                                    <input class="form-control" name="confirm-password" type="password" required>
                                    @error('confirm-password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="mb-2 btn btn-primary">{{ trans('back.reset_password') }}</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
