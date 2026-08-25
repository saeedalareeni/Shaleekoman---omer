@extends('backend.layouts.master')

@section('page_title')
{{trans('back.customers')}}
@endsection

@section('title')
{{trans('back.customers')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            @can('add_customer')
                <a class="btn btn-purple btn-sm" href="" data-toggle="modal" data-target="#add_customer">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_customer')}}
                </a>
                @include('backend.pages.customers.add')
            @endcan
        </div>


        @can('search_customer')
        <div class="col-md-3 mb-1">
            <form action="{{ route('customers.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query" >
                    <button class="btn btn-purple btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('customers.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
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
                    <table  class="table text-center  table-striped  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th> {{trans('back.Customer_Name')}}</th>
                            <th> {{trans('back.email')}}</th>
                            <th> {{trans('back.phone')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                            <th width="150">  {{trans('back.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($customers as $key => $customer)
                            <tr>
                                <td>{{$key+ $customers->firstItem()}}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                    <a href="https://wa.me/{{ $customer->phone }}" target="_blank"> {{ $customer->phone }}</a>
                                </td>



                                <td>{{ $customer->created_at }}</td>
                                <td>
                                   
                                    @can('edit_customer')
                                        <a class="btn btn-success btn-xs " href="" data-toggle="modal" data-target="#edit_customer{{$customer->id}}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @include('backend.pages.customers.edit')
                                    @endcan

                                    @can('delete_customer')
                                        <a href="" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#delete_customer{{$customer->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.customers.delete')
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $customers->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>

@endsection

