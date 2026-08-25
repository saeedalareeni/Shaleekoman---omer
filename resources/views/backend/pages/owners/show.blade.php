@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.owner')}} : {{ $owner->name }}
@endsection
@section('title')
    {{trans('back.owner')}} : {{ $owner->name }}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card text-center" >
                <div class="card-box pb-0 mb-0">
                    <div class="table-responsive">
                        <table  class="table table-bordered  table-sm text-center">
                            <tbody>
                                <tr>
                                    <th class="bg-primary">{{ __('back.totel_payment_amount_bookings') }}</th>
                                    <td>
                                        {{ $totalAmount }}
                                    </td>

                                    <th class="bg-primary">{{ __('back.totalCommission') }}</th>
                                    <td>
                                        {{ $totalCommission }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-primary">{{ __('back.totalAmountAfterCommission') }}</th>
                                    <td>
                                        {{ $totalAmount - $totalCommission }}
                                    </td>

                                    <th class="bg-primary">{{ __('back.totel_owners_expenses') }}</th>
                                    <td>
                                        {{ $owner->expenses->sum('amount') }}
                                    </td>
                                </tr>
                                <tr>
                               
                                    <th class="bg-primary">{{ __('back.rest_amount') }}</th>
                                    <td>
                                        {{($totalAmount - $totalCommission) - $owner->expenses->sum('amount') }}
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h5>{{trans('back.owners_expense')}}</h5>
            <div class="card-box">
                @can('add_owners_expense')
                <button {{ ($totalAmount - $totalCommission)- $owner->expenses->sum('amount')  <= 0 ? 'disabled' : '' }} class="btn btn-purple btn-sm mb-1" href="" data-toggle="modal" data-target="#add_owners_expense">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.add_owners_expense')}}
                </button>
                @include('backend.pages.owners_expenses.add')
            @endcan
                <div class="table-responsive">
                    <table  class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th>{{trans('back.amount')}}</th>
                            <th> {{trans('back.expense_date')}}</th>
                            <th> {{trans('back.attached')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                            <th width="180">{{trans('back.Action')}}</th>
                            <th>{{trans('back.User')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($owner->expenses as $key => $owners_expense)
                            <tr>
                                <td>{{$key+1}}</td>
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
                                        <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#edit_owners_expense{{$owners_expense->id}}" >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @include('backend.pages.owners_expenses.edit')
                                    @endcan

                                    @can('delete_owners_expense')
                                        <a href="" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#delete_owners_expense{{$owners_expense->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.owners_expenses.delete')
                                    @endcan
                                </td>
                                <td>{{ $owners_expense->User->name ?? "" }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

@endsection
