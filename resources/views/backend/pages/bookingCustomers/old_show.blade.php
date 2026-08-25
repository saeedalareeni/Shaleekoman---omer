@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.orders')}}
@endsection

@section('title')
    {{trans('back.orders')}}
@endsection

@section('content')


    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4> {{ __('back.order_details') }} : {{$order->order_no}}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center table-sm">
                        <tbody>
                            <tr>
                                <th>{{trans('back.chalet')}}</th>
                                <td>
                                    @if($order->chalet)
                                    <div class="text-center">
                                        <span class="px-2">
                                            {{$order->chalet->name}}
                                        </span></div>
                                    @else
                                         ---
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{trans('front.order_number')}}</th>
                                <td> {{ $order->id ?? __('back.not_saved') }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('front.name')}}</th>
                                <td> {{ $order->name ?? __('back.not_saved') }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('front.phone')}}</th>
                                <td> {{ $order->phone_number ?? __('back.not_saved') }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('front.email')}}</th>
                                <td> {{ $order->email ?? __('back.not_saved') }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('front.start_date.label')}}</th>
                                <td> {{ $order->start_date ?? __('back.not_saved') }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('front.end_date.label')}}</th>
                                <td> {{ $order->end_date ?? __('back.not_saved') }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('front.nights_number')}}</th>
                                <td> {{ $order->nights_number ?? __('back.not_saved') }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('back.Status')}}</th>
                                <td>{!! $order->status() !!}</td>
                            </tr>
                            <tr>
                                <th>{{trans('front.message')}}</th>
                                <td>{!! $order->message !!}</td>
                            </tr>
                            <tr>
                                <th>{{trans('back.Created_at')}}</th>
                                <td>{{$order->created_at}}</td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="mt-3">{{ __('back.nights_costs_details') }}</h4>

                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('front.night') }}</th>
                                <th>{{ __('front.cost') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->nights as $date => $cost)
                                <tr>
                                    <td>{{ $date }}</td>
                                    <td>{{ $cost . ' ' . __('front.s_omr') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between">
                        <h4>{{ __('front.total') }}</h4>
                        <h4>{{ $order->total . ' ' . __('front.omr') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->

@endsection
