@extends('owners.layouts.master')

@section('page_title', trans('back.chalets'))

@section('title', trans('back.chalets'))

@section('content')

    <div class="row mb-1">
        <div class="col-md-7">
            <a class="btn btn-purple btn-sm" href="{{ route('owner.chalets.create') }}">
                <i class="mdi mdi-plus"></i>
                {{ trans('back.add_chalet') }}
            </a>
        </div>

        <div class="col-md-5">
                <form action="{{ route('owner.chalets.index') }}" method="GET">
                    <div class="d-flex">
                        <select class="form-control select2" name="area_id" required>
                            <option selected disabled>{{ trans('back.select') }}</option>
                           @foreach ($areas as $area)
                                <option value="{{$area->id }}" {{ $area->id == request()->input('area_id')?'selected':'' }}>   {{ app()->getLocale() == 'ar' ? $area->name_ar : $area->name_en }} ( {{ app()->getLocale() == 'ar' ? $area->city->name_ar : $area->city->name_en }} )</option>
                           @endforeach
                        </select>
                        &numsp;
                        <input type="text" class="form-control form-control-sm" name="query" value="{{ old('query', request()->input('query')) }}" placeholder="{{ trans('back.search_placeholder') }}" id="query">
                        <button class="btn btn-purple btn-sm ml-1" type="submit" title="{{ trans('back.search') }}">
                            <span class="fas fa-search"></span>
                        </button>
                        <a href="{{ route('owner.chalets.index') }}" class="btn btn-success btn-sm ml-1" type="button" title="{{ trans('back.reload') }}">
                            <span class="fas fa-sync-alt"></span>
                        </a>
                    </div>
                </form>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card-box">

                <div class="table-responsive">
                    <table class="table text-center table-striped table-bordered table-sm">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th width="25">#</th>
                            <th width="100">{{ trans('back.main_image') }}</th>
                            <th width="200">{{ trans('back.chalet_name') }}</th>
                            <th width="200">{{ trans('back.city_area') }}</th>
                            <th width="200">{{ trans('back.featured') }}</th>
                            <th width="200">{{ trans('back.status') }}</th>
                            <th width="100">{{ trans('back.bookings_count') }}</th>
                            <th width="100">{{ trans('back.totel_payment_amount_bookings') }}</th>
                            <th width="300">{{ trans('back.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($chalets as $key => $chalet)
                            <tr>
                                <td>{{ $key + $chalets->firstItem() }}</td>
                                <td>
                                    @if($chalet->main_image)
                                        <img src="{{ asset($chalet->main_image) }}" alt="Main Image" width="40">
                                    @else
                                        {{ trans('back.no_image') }}
                                    @endif
                                </td>
                                <td>{{ App::getLocale() =='ar' ? $chalet->chalet_name_ar :  $chalet->chalet_name_en}}</td>
                                <td>
                                    {{ app()->getLocale()=='ar'? $chalet->city->name_ar:$chalet->city->name_en }}
                                    ({{ app()->getLocale()=='ar'? $chalet->area->name_ar:$chalet->area->name_en }})
                                    - {{ $chalet->location }}
                                </td>

                                <td>
                                    {!! $chalet->isFeature() !!}
                                </td>
                                <td>
                                        {!! $chalet->status() !!}
                                </td>

                                <td>{{ $chalet->bookings->count() }}</td>
                                <td>{{$chalet->bookings->sum('payment_amount') }}</td>

                                <td>
                                    <a class="btn btn-primary btn-xs" href="{{ route('owner.chalets.show', $chalet->slug) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{--إدارة الأسعار--}}
                                    <a class="btn btn-info btn-xs" href="{{ route('owner.chalets.prices.index', $chalet->slug) }}">
                                        <i class="fas fa-dollar-sign"></i>
                                    </a>

                                    <a class="btn btn-primary btn-xs" href="{{ route('owner.chalets.images.index', $chalet->slug) }}">
                                        <i class="fas fa-images"></i>
                                        ( {{count($chalet->images)}} )
                                    </a>

                                    <a class="btn btn-success btn-xs" href="{{ route('owner.chalets.edit', $chalet->slug) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a class="btn btn-danger btn-xs" href="" data-toggle="modal" data-target="#delete_chalet{{ $chalet->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                        @include('owners.pages.chalets.delete', ['chalet' => $chalet])
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $chalets->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>
@endsection
