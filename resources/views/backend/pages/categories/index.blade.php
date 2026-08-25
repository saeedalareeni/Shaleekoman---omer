@extends('backend.layouts.master')

@section('title')
{{trans('back.categories')}}
@endsection

@section('title')
{{trans('back.categories')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-purple btn-sm" href="" data-toggle="modal" data-target="#add_category">
                <i class="mdi mdi-plus"></i>
                {{trans('back.add_category')}}
            </a>
            @include('backend.pages.categories.add')
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
                            <th> {{trans('back.name')}}</th>
                            <th> {{trans('back.chalets_count')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                            <th width="150">  {{trans('back.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($categories as $key => $category)
                            <tr>
                                <td>{{$key+ $categories->firstItem()}}</td>
                                <td>{{ app()->getLocale()=='ar'? $category->name_ar:$category->name_en }}</td>
                                <td>{{ $category->chalets->count()??0 }}</td>
                                <td>{{ $category->created_at }}</td>
                                <td>
                                    <a class="btn btn-success btn-xs " href="" data-toggle="modal" data-target="#edit_category{{$category->id}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @include('backend.pages.categories.edit')

                                    <a href="" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#delete_category{{$category->id}}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @include('backend.pages.categories.delete')
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $categories->appends(Request::all())->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>

    </script>

@endsection


