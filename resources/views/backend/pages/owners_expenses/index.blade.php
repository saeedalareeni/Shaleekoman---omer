@extends('backend2.layouts_new.master')

@section('page_title')
    {{trans('back.owners_expenses')}}
@endsection

@section('title')
    {{trans('back.owners_expenses')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            @can('add_owners_expense')
                <a class="btn btn-purple btn-sm" href="" data-toggle="modal" data-target="#add_owners_expense">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_owners_expense')}}
                </a>
                @include('backend2.pages.owners_expenses.add')
            @endcan
        </div>

        <div class="col-md-3 mb-1">
            <form action="{{ route('owners_expenses.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="{{trans('back.search')}}" id="query" >
                    <button class="btn btn-purple btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('owners_expenses.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
                        <span class="fas fa-sync-alt"></span>
                    </a>
                </div>
            </form>
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
                            <th> {{trans('back.owner')}}</th>
                            <th>{{trans('back.amount')}}</th>
                            <th> {{trans('back.expense_date')}}</th>
                            <th> {{trans('back.attached')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                            <th width="180">{{trans('back.Action')}}</th>
                            <th>{{trans('back.User')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($owners_expenses as $key => $owners_expense)
                            <tr>
                                <td>{{$key+ $owners_expenses->firstItem()}}</td>
                                <td>{{ $owners_expense->Owner->name ?? '' }}</td>
                                <td>{{ $owners_expense->amount }}</td>
                                <td>{{ $owners_expense->expense_date }}</td>
                                <td>
                                    @if($owners_expense->image)
                                        <a href="{{asset($owners_expense->image)}}" target="_blank" class="btn btn-secondary btn-xs"> {{trans('back.attached')}}</a>
                                    @else
                                        {{trans('back.none')}}
                                    @endif
                                </td>
                                <td>{{ $owners_expense->created_at }}</td>
                                <td>
                                    @can('edit_owners_expense')
                                        <a class="btn btn-success btn-xs " href="{{route('owners_expenses.edit', $owners_expense->id)}}" >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('delete_owners_expense')
                                        <a href="" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#delete_owners_expense{{$owners_expense->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend2.pages.owners_expenses.delete')
                                    @endcan
                                </td>
                                <td>{{ $owners_expense->User->name ?? "" }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $owners_expenses->appends(Request::all())->links() !!}

            </div>
        </div>
    </div>

@endsection
