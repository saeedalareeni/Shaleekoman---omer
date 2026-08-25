@extends('backend.layouts.master')

@section('page_title')
    {{ trans('back.Add_New_User') }}
@endsection

@section('title')
    {{ trans('back.Add_New_User') }}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 mb-1">
            @can('users')
                <a class="btn btn-purple btn-sm mb-1" href="{{ route('users.index') }}">
                    <i class="fas fa-chevron-circle-right"></i>
                    {{ trans('back.Back_All_users') }}
                </a>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-box">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('back.name') }} :</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('back.Email') }}:</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('back.Password') }}</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('back.confirm-password') }}:</label>
                                    <input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ trans('back.Permissions') }}:</label>
                                    <select name="roles[]" class="form-control" multiple>
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}">{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                                <button type="submit" class="btn btn-purple">{{ trans('back.add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
