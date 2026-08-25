@extends('backend.layouts.master')

@section('page_title')
{{trans('back.coupons')}}
@endsection

@section('title')
{{trans('back.coupons')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            @can('add_coupon')
                <a class="btn btn-purple btn-sm" href="" data-toggle="modal" data-target="#add_coupon">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_coupon')}}
                </a>
                @include('backend.pages.coupons.add')
            @endcan
        </div>


        @can('search_coupon')
        <div class="col-md-3 mb-1">
            <form action="{{ route('coupons.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query" >
                    <button class="btn btn-purple btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('coupons.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
                        <span class="fas fa-sync-alt"></span>
                    </a>
                </div>
            </form>
        </div>
        @endcan

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="table-responsive">
                    <table class="table text-center table-striped table-bordered table-sm">
                        <thead>
                            <tr style="background-color: rgb(232,245,252)">
                                <th>#</th>
                                <th>{{ trans('back.code') }}</th>
                                <th>{{ trans('back.discount_percentage') }}</th>
                                <th>{{ trans('back.max_uses') }}</th>
                                <th>{{ trans('back.used_count') }}</th>
                                <th>{{ trans('back.expires_at') }}</th>
                                <th>{{ trans('back.status') }}</th>
                                <th>{{ trans('back.created_at') }}</th>
                                <th width="150">{{ trans('back.Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($coupons as $key => $coupon)
                                <tr>
                                    <td>{{ $key + $coupons->firstItem() }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_percentage }}%</td>
                                    <td>{{ $coupon->max_uses }}</td>
                                    <td>{{ $coupon->used_count }}</td>
                                    <td>{{ $coupon->expires_at }}</td>
                                    <td>
                                        @if($coupon->is_active)
                                            <span class="badge badge-success">{{ trans('back.active') }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ trans('back.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $coupon->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @can('edit_coupon')
                                            <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target="#edit_coupon{{ $coupon->id }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @include('backend.pages.coupons.edit')
                                        @endcan

                                        @can('delete_coupon')
                                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_coupon{{ $coupon->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            @include('backend.pages.coupons.delete')
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $coupons->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>


@endsection

