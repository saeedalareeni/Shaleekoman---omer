@extends('backend.layouts.master')

@section('page_title')
{{trans('back.info')}}
@endsection

@section('title')
{{trans('back.info')}}
@endsection


@section('content')

    <div class="col-sm-4">
        <button type="button" class="btn btn-purple btn-sm mb-2" data-toggle="modal" data-target="#add_info">
            <i class="fas fa-plus"></i>
            {{trans('back.add_Info')}}
        </button>
        @include('backend.pages.infos.add')
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="table-responsive">
                    <table id="" class="table table-bordered text-center table-sm">
                        <thead>
                        <tr>
                            <th>{{trans('back.image')}}</th>
                            <th>{{trans('back.name_ar')}}</th>
                            <th>{{trans('back.name_en')}}</th>
                            <th>{{trans('back.actions')}}</th>
                            <th>{{trans('back.Created_at')}}</th>
                        </tr>
                        </thead>
                        @php $i=1 @endphp

                        <tbody>
                        @foreach($infos as $info)
                            <tr>
                                <td> <a href="{{asset($info->image)}}"> <img src="{{asset($info->image)}}" alt="{{$info->name}}" width="60px"> </a> </td>
                                <td> {{$info->name_ar}}</td>
                                <td> {{$info->name_en}}</td>
                                <td>
                                    <a href="" class="btn btn-success btn-xs ml-1" data-toggle="modal" data-target="#edit_info{{$info->id}}">
                                        {{trans('back.edit')}}
                                    </a>
                                    @include('backend.pages.infos.edit')

                                    <a href="" class="btn btn-danger btn-xs ml-1" data-toggle="modal" data-target="#delete_info{{$info->id}}">
                                        {{trans('back.Delete')}}
                                    </a>
                                    @include('backend.pages.infos.delete')
                                </td>
                                <td>{{$info->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end row -->

@endsection


@section('js')

    <script src="//cdn.ckeditor.com/4.15.0/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor', {
            language: 'ar',
            height: 500
        });
    </script>

@endsection
