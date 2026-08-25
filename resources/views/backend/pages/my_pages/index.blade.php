@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.pages')}}
@endsection

@section('title')
    {{trans('back.pages')}}
@endsection

@section('content')

    <div class="col-sm-4">
        <a href="{{route('pages.create')}}" type="button" class="btn btn-primary btn-sm mb-2 ">
            <i class="fas fa-plus"></i>
            {{trans('back.add_new_page')}}
        </a>
    </div>

    <div class="row">
        <div class="col-12 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="" class="table table-bordered text-center table-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{trans('back.name')}}</th>
                            <th>{{trans('back.Status')}}</th>
                            <th>{{trans('back.Created_at')}}</th>
                            <th>{{trans('back.actions')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($pages as $key => $page)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{ App::getLocale() == 'ar' ? $page->name_ar : $page->name_en }}</td>
                                <td>{{$page->status()}}</td>
                                <td>{{$page->created_at}}</td>
                                <td>
                                    <a href="{{route('pages.edit', $page->id)}}" class="btn btn-primary btn-xs ml-1 " >
                                        {{trans('back.edit')}}
                                    </a>

                                    <a href="" class="btn btn-danger btn-xs ml-1 " data-toggle="modal" data-target="#delete_Page{{$page->id}}">
                                        {{trans('back.Delete')}}
                                    </a>
                                    @include('backend.pages.my_pages.delete')
                                </td>
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
