@extends('backend.layouts.master')

@section('title')
{{trans('back.banners')}}
@endsection

@section('title')
{{trans('back.banners')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            @can('add_banner')
                <a class="btn btn-purple btn-sm" href="" data-toggle="modal" data-target="#add_banner">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_banner')}}
                </a>
                @include('backend.pages.banners.add')
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">


                <div class="table-responsive">
                    <table  class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th> {{trans('back.image')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                            <th width="150">  {{trans('back.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($banners as $key => $banner)
                            <tr>
                                <td>{{$key+ $banners->firstItem()}}</td>

                                <td>
                                    <a href="{{ asset($banner->image??'no_image.png') }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset($banner->image??'no_image.png') }}" alt="image" class="avatar-md"></a>
                                <td>
                                    @can('edit_banner')
                                        <a class="btn btn-success btn-xs " href="" data-toggle="modal" data-target="#edit_banner{{$banner->id}}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.pages.banners.edit')
                                    @endcan

                                    @can('delete_banner')
                                        <a href="" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#delete_banner{{$banner->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.banners.delete')
                                    @endcan
                                </td>
                                <td>{{ $banner->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $banners->appends(Request::all())->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>

    </script>

@endsection


