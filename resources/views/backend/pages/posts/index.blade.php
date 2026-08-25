@extends('backend.layouts.master')
@section('page_title')
{{ trans('back.posts') }}
@endsection
@section('title')
{{ trans('back.posts') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            @can('add_post')
                <a href="{{route('posts.create')}}" type="button" class="btn btn-purple btn-sm mb-2" >
                    <i class="fas fa-plus"></i>
                    {{ trans('back.add_post') }}
                </a>
            @endcan
        </div>

        <div class="col-md-3 mb-1">
            @can('search_post')
                <form action="{{ route('posts.index') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="بحث .." id="query" >
                        <button class="btn btn-purple btn-sm ml-1" type="submit" title="Search">
                            <span class="fas fa-search"></span>
                        </button>
                        <a href="{{ route('posts.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
                            <span class="fas fa-sync-alt"></span>
                        </a>
                    </div>
                </form>
            @endcan
        </div>
    </div>


    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered text-center table-sm">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('back.image')}}</th>
                                <th>{{trans('back.title')}}</th>
                                <th>{{trans('back.Status')}}</th>
                                <th>{{trans('back.Created_at')}}</th>
                                <th>{{trans('back.actions')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($posts as $key => $post)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td> <a href="{{asset($post->image)}}"> <img src="{{asset($post->image)}}" alt="{{$post->name}}" width="60px"> </a> </td>
                                    <td>@if(app()->getLocale() == 'ar'){{$post->title_ar}}@else{{$post->title_en}}@endif</td>
                                    <td>{{$post->status()}}</td>
                                    <td>{{$post->created_at}}</td>
                                    <td>
                                        @can('show_post')
                                            <a href="{{route('posts.show', $post->id)}}" class="btn btn-purple btn-xs ml-1 " >
                                                {{trans('back.Add_images')}}
                                                ( {{$post->Images->count()}} )
                                            </a>
                                        @endcan

                                        @can('edit_post')
                                            <a href="{{route('posts.edit', $post->id)}}" class="btn btn-success btn-xs ml-1 " >
                                                {{trans('back.edit')}}
                                            </a>
                                        @endcan

                                        @can('delete_post')
                                            <a href="" class="btn btn-danger btn-xs ml-1 " data-toggle="modal" data-target="#delete_Post{{$post->id}}">
                                                {{trans('back.Delete')}}
                                            </a>
                                        @endcan
                                        @include('backend.pages.posts.delete')
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {!! $posts->appends(Request::all())->links() !!}
                    </div>
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
