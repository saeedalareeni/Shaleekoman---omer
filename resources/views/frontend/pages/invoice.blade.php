@extends('backend.layouts.master_invoice')

@section('title')
{{ trans('back.invoice') }} - {{ $booking->booking_number }}
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
                            @if ($booking->cancellation_status)
                                <p class="bg-danger p-1 mt-2 text-center text-white">{{ $booking->cancellation_status }}</p>
                            @endif
                            <h6 class="fw-bold"> {{ __('back.booking_details') }}</h6>
                        </div>


                            <div class="text-center fw-bold pt-2 chalet-name">
                                @if($booking->chalet)
                                    {{ app()->getLocale() == 'ar' ? $booking->chalet->chalet_name_ar : $booking->chalet->chalet_name_en }}
                                @else
                                    --
                                @endif
                            </div>


                        <div class="card-body pb-0">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <tbody>
                                    <tr>
                                        <th>{{trans('back.booking_number')}}</th>
                                        <td class="booking-number"> {{ $booking->booking_number ?? '--' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.name')}}</th>
                                        <td> {{ $booking->customer_name ?? __('back.not_saved') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.phone')}}</th>
                                        <td>
                                            <a href="https://wa.me/{{ $booking->phone_number}}" target="_blank">
                                                {{ $booking->country.$booking->phone_number ?? '--' }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.email')}}</th>
                                        <td> {{ $booking->email ?? '--' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.days_number')}}</th>
                                        <td> {{ $booking->dates ? $booking->dates->count() : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.Created_at')}}</th>
                                        <td>{{$booking->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('back.message')}}</th>
                                        <td>{!! $booking->message !!}</td>
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
                                    @foreach ($booking->dates as $date)
                                        <tr>
                                            <td>{{ $date->date }}</td>
                                            <td>{{ number_format($date->price, 2) }} {{trans('back.OMR')}}</td>
                                            <td>{{ trans("back.$booking->booking_type") }}</td>
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
                                            <td>
                                                @if($booking->PaymentMethod)
                                                    {{ app()->getLocale() == 'ar' ? $booking->PaymentMethod->name_ar : $booking->PaymentMethod->name_en }}
                                                @elseif($booking->payment_method)
                                                    {{ trans("back.{$booking->payment_method}") }}
                                                @else
                                                    {{ trans('back.cash') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('back.payment_status')}}</th>
                                            <td class="payment-status-{{ $booking->payment_status }}">{{  trans("back.$booking->payment_status") }} </td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('back.Total_amount')}}</th>
                                            <td> {{ number_format($booking->total_amount, 2) }} {{trans('back.OMR')}}</td>
                                        </tr>

                                        <tr>
                                            <th>{{trans('back.amount_paid')}}</th>
                                            <td> {{ number_format($booking->payment_amount, 2) }} {{trans('back.OMR')}}</td>
                                        </tr>

                                        <tr class="font-weight-bold rest-amount">
                                            <th class="font-weight-bold">{{trans('back.rest_amount')}}</th>
                                            <td class="font-weight-bold"> {{ number_format($booking->total_amount - $booking->payment_amount, 2) }} {{trans('back.OMR')}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            {{-- عرض معلومات الحساب البنكي إذا كانت طريقة الدفع تحويل بنكي --}}
                            @if($booking->payment_method == 'bank_transfer' || session('show_bank_details'))
                                <div class="alert alert-info mt-3">
                                    <h5 class="text-center mb-3">{{ trans('back.bank_transfer_details') }}</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <th>{{ trans('back.bank_name') }}:</th>
                                                    <td>{{ App\Models\Setting::first()->bank_name ?? 'البنك الأهلي' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('back.account_name') }}:</th>
                                                    <td>{{ App\Models\Setting::first()->account_name ?? 'شركة شاليك عمان' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('back.account_number') }}:</th>
                                                    <td>{{ App\Models\Setting::first()->account_number ?? '1234567890' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('back.iban') }}:</th>
                                                    <td>{{ App\Models\Setting::first()->iban ?? 'SA1234567890123456789012' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-center mt-2 mb-0">
                                        <small>{{ trans('back.bank_transfer_note') }}</small>
                                    </p>
                                </div>
                            @endif
                            
                            <div class="d-print-none">
                                <div class="float-right">
                                    <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light"><i class="fa fa-print"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="text-center mt-2 ">
                        <h6 class="fw-bold">{{trans('back.location')}} :</h6>
                        <a href="{{$booking->chalet->map_url}}" target="_blank" > {{$booking->chalet->map_url}} </a>
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
    </section>
@endsection
