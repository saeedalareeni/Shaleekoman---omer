@extends('owners.layouts.master')

@section('page_title')
    {{trans('back.expenses')}}
@endsection
@section('title')
    {{trans('back.expenses')}}
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
            {{-- <h5>{{trans('back.expenses')}}</h5> --}}
            <div class="card-box">
                <div class="table-responsive">
                    <table  class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th>{{trans('back.amount')}}</th>
                            <th>{{trans('back.about')}}</th>
                            <th> {{trans('back.expense_date')}}</th>
                            <th> {{trans('back.attached')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($owner->expenses as $key => $owners_expense)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $owners_expense->amount }}</td>
                                <td>{{ $owners_expense->about }}</td>
                                <td>{{ $owners_expense->expense_date }}</td>
                                <td>
                                    @if($owners_expense->image)
                                        <a href="{{asset($owners_expense->image)}}" target="_blank" class="btn btn-secondary btn-xs"> {{trans('back.attached')}}</a>
                                    @else
                                        {{trans('back.none')}}
                                    @endif
                                </td>
                                <td>{{ $owners_expense->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    {{ trans('back.not_found') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

@endsection
