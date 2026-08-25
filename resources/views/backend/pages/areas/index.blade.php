@extends('backend.layouts.master')

@section('title')
{{ trans('back.areas') }}
@endsection

@section('content')

<div class="row mb-2">
    <div class="col-md-9">
        @can('add_area')
        <button class="btn btn-purple btn-sm" data-toggle="modal" data-target="#add_area">
            <i class="mdi mdi-plus"></i> {{ trans('back.add_area') }}
        </button>
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="table-responsive">
                <table class="table text-center table-bordered table-sm">
                    <thead style="background-color: rgb(232,245,252)">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('back.name') }}</th>
                            <th>{{ trans('back.city') }}</th>
                            <th>{{ trans('back.Created_at') }}</th>
                            <th width="150">{{ trans('back.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($areas as $key => $area)
                        <tr>
                            <td>{{ $key + $areas->firstItem() }}</td>
                            <td>{{ app()->getLocale() == 'ar' ? $area->name_ar : $area->name_en }}</td>
                            <td>{{ app()->getLocale() == 'ar' ? $area->city->name_ar : $area->city->name_en }}</td>
                            <td>{{ $area->created_at }}</td>
                            <td>
                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#edit_area{{ $area->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_area{{ $area->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="edit_area{{ $area->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('areas.update', $area->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ trans('back.edit_area') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>{{ trans('back.name') }} (AR)</label>
                                                <input type="text" class="form-control" name="name_ar" value="{{ $area->name_ar }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('back.name') }} (EN)</label>
                                                <input type="text" class="form-control" name="name_en" value="{{ $area->name_en }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('back.city') }}</label>
                                                <select name="city_id" class="form-control" required>
                                                    @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $area->city_id == $city->id ? 'selected' : '' }}>
                                                        {{ app()->getLocale() == 'ar' ? $city->name_ar : $city->name_en }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">{{ trans('back.save') }}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('back.close') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Delete Modal --}}
                        <div class="modal fade" id="delete_area{{ $area->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('areas.destroy', $area->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ trans('back.delete_area') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ trans('back.confirm_delete') }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">{{ trans('back.delete') }}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('back.close') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
                {!! $areas->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
@can('add_area')
<div class="modal fade" id="add_area" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('areas.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('back.add_area') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('back.name') }} (AR)</label>
                        <input type="text" class="form-control" name="name_ar" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('back.name') }} (EN)</label>
                        <input type="text" class="form-control" name="name_en" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('back.city') }}</label>
                        <select name="city_id" class="form-control" required>
                            @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ app()->getLocale() == 'ar' ? $city->name_ar : $city->name_en }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ trans('back.save') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('back.close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan

@endsection

@section('js')
<script>
    $(document).ready(function(){
        // التركيز على أول عنصر عند فتح أي Modal
        $('.modal').on('shown.bs.modal', function () {
            $(this).find('input, select, textarea').first().focus();
        });

        // ✅ إصلاح مشكلة التعتيم overlay
        $('body').append('<style>\
            .modal { z-index: 2000 !important; } \
            .modal-backdrop { z-index: 1999 !important; } \
        </style>');
    });
</script>
@endsection
