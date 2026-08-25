@extends('backend.layouts.master_invoice')

@section('title')
{{ app()->getLocale() == 'ar' ? $order->chalet->chalet_name_ar : $order->chalet->chalet_name_en }}
@endsection

@section('content')

    <section class="experience-area pt-3 ">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="text-center pb-2">
                        <a href="/" target="_blank">
                            <img src="{{asset(App\Models\Setting::first()->logo)}}" width="120" >
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-header text-center">
                            <h6 class="fw-bold text-danger"> {{ __('back.booking_details') }}</h6>
                        </div>


                            <div class="text-center fw-bold pt-2">
                                {{ app()->getLocale() == 'ar' ? $order->chalet->chalet_name_ar : $order->chalet->chalet_name_en }}
                            </div>



                        <div class="card-body pb-0">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <tbody>
                                    <tr>
                                        <th>{{trans('back.booking_number')}}</th>
                                        <td> {{ $order->booking_number ?? '--' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.name')}}</th>
                                        <td> {{ $order->customer_name ?? __('back.not_saved') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.phone')}}</th>
                                        <td>
                                            <a href="https://wa.me/{{ $order->phone_number}}" target="_blank">
                                                {{ $order->phone_number ?? '--' }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.email')}}</th>
                                        <td> {{ $order->email ?? '--' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.days_number')}}</th>
                                        <td> {{ $order->dates->count() ?? '--' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.Created_at')}}</th>
                                        <td>{{$order->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.message')}}</th>
                                        <td>{!! $order->message !!}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{ __('back.date') }}</th>
                                        <th>{{ __('back.price') }}</th>
                                        <th>{{ __('back.booking_type') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($order->dates as $date)
                                        <tr>
                                            <td>{{ $date->date }}</td>
                                            <td>{{ $date->price }}</td>
                                            <td>{{ trans("back.$order->booking_type") }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <tbody class=" font-weight-bold">
                                        <tr>
                                            <th>{{trans('back.payment_method')}}</th>
                                            <td>{{ app()->getLocale() == 'ar' ? $order->PaymentMethod->name_ar : $order->PaymentMethod->name_en }} </td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('back.Total_amount')}}</th>
                                            <td> {{ $order->total_amount}}</td>
                                        </tr>

                                        <tr>
                                            <th>{{trans('back.amount_paid')}}</th>
                                            <td> {{ $order->payment_amount}}</td>
                                        </tr>

                                        <tr class=" font-weight-bold">
                                            <th class=" font-weight-bold">{{trans('back.rest_amount')}}</th>
                                            <td class=" font-weight-bold"> {{ $order->total_amount - $order->payment_amount}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>



                    {{-- <div class="text-center mt-2 ">
                        <h6 class="fw-bold">{{trans('back.location')}} :</h6>
                        <a href="{{$order->chalet->map_url}}" target="_blank" > {{$order->chalet->map_url}} </a>
                    </div> --}}
                </div>
            </div>

            {{-- <div class="col-md-12 text-center mt-3">
                <h6 class="mb-3">
                    <span class="text-danger">
                        {{trans('back.Cancellation Policy:')}}
                    </span>
                    {{trans('back.The reservation deposit will be refunded if canceled one night before arrival')}}
                </h6>
            </div> --}}

        </div>
        <div class="d-print-none">
            <div class="float-right">
                <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light"><i class="fa fa-print"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>
@endsection
{{-- @section('js')
    <script>
        window.print();
        var div_btn = $('.div_btn')
        div_btn.hide();
    </script>
@endsection --}}
