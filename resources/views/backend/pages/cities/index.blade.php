@extends('backend.layouts.master')

@section('title')
{{trans('back.cities')}}
@endsection

@section('title')
{{trans('back.cities')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            @can('add_city')
                <a class="btn btn-purple btn-sm" href="" data-toggle="modal" data-target="#add_city">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_city')}}
                </a>
                @include('backend.pages.cities.add')
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
                            <th> {{trans('back.name')}}</th>
                            <th> {{trans('back.area_number')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                            <th width="150">  {{trans('back.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($cities as $key => $city)
                            <tr>
                                <td>{{$key+ $cities->firstItem()}}</td>
                                <td>{{ app()->getLocale()=='ar'? $city->name_ar:$city->name_en }}</td>
                                <td>{{ $city->areas->count()??0 }}</td>

                                <td>
                                    @can('edit_city')
                                        <a class="btn btn-success btn-xs " href="" data-toggle="modal" data-target="#edit_city{{$city->id}}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.pages.cities.edit')
                                    @endcan

                                    @can('delete_city')
                                        <a href="" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#delete_city{{$city->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.cities.delete')
                                    @endcan
                                </td>
                                <td>{{ $city->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $cities->appends(Request::all())->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>

    </script>

@endsection


