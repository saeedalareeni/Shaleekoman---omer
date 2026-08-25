@extends('owners.layouts.master')

@section('title', __('back.Profile'))
@section('page_title', __('back.Profile'))

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <h5 class="card-header">{{ __('back.Profile Details') }}</h5>
                <!-- Account -->
                <div class="card-body">
                    <form action="{{ route('owner.profile.image.update') }}" id="formAccountSettings" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ auth()->user()->image != null ? asset(auth()->user()->image) : asset('avatar.png') }}"  alt="image" class="img-fluid rounded-circle" width="120" id="uploadedAvatar">
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary btn-sm me-2 mb-2" tabindex="0">
                                    <span class="d-none d-sm-block"><i class="fas fa-edit"></i> </span>
                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                    <input type="file" name="image" id="upload" class="account-file-input" hidden
                                        accept="image/png, image/jpeg" required />
                                </label>
                                <button type="submit" class="btn btn-secondary btn-sm account-image-reset mb-1">
                                    <i class="ti ti-save d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">{{ __('back.reset') }}</span>
                                </button>
                                <div class="text-muted">يُسمح بتنسيق JPG أو GIF أو PNG، والحجم الأقصى هو 1024 كيلوبايت</div>
                            </div>
                        </div>
                    </form>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <form action="{{ route('owner.profile.update') }}" id="formAccountSettings" method="POST">
                        @csrf
                        @method('patch')
                        <div class="row d-block">
                            <div class="mb-1 col-md-4">
                                <label for="firstName" class="form-label">{{ __('back.name') }}</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    value="{{ auth()->user()->name }}" autofocus required />
                            </div>
                            <div class="mb-2 col-md-4">
                                <label for="email" class="form-label">{{ __('back.email') }}</label>
                                <input class="form-control" type="email" id="email" name="email" value="{{ auth()->user()->email }}" placeholder="john.doe@example.com" required />
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">{{ __('back.save') }}</button>
                        </div>
                    </form>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <h5 class="mb-2">{{ __('back.Update Password') }}</h5>
                    <form action="{{ route('owner.password.update') }}" id="formAccountSettings" method="POST">
                        @csrf
                        @method('put')
                        <div class="row d-block">
                            <div class="mb-1 col-md-4">
                                <label for="update_password_current_password"
                                    class="block text-sm font-medium text-gray-700">{{ __('back.Current Password') }}</label>
                                <input class="form-control" id="update_password_current_password" name="current_password"
                                    type="password"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    autocomplete="current-password">
                                <span class="text-danger text-sm mt-2">
                                    {{ $errors->updatePassword->first('current_password') }}
                                </span>
                            </div>
                            <div class="mb-1 col-md-4">
                                <label for="update_password_password"
                                    class="block text-sm font-medium text-gray-700">{{ __('back.New Password') }}</label>
                                <input class="form-control" id="update_password_password" name="password" type="password"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    autocomplete="new-password">
                                <span class="text-danger text-sm mt-2">
                                    {{ $errors->updatePassword->first('password') }}
                                </span>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="update_password_password_confirmation"
                                    class="block text-sm font-medium text-gray-700">{{ __('back.Confirm Password') }}</label>
                                <input class="form-control" id="update_password_password_confirmation"
                                    name="password_confirmation" type="password"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    autocomplete="new-password">
                                <span class="text-danger text-red-600 text-sm mt-2">
                                    {{ $errors->updatePassword->first('password_confirmation') }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">{{ __('back.save') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>

        </div>
    </div>

@endsection
