@extends('backend.layouts.master')

@section('page_title')
{{ App::getLocale() =='ar' ? $chalet->chalet_name_ar :  $chalet->chalet_name_en}}
@endsection

@section('title')
    {{ App::getLocale() =='ar' ? $chalet->chalet_name_ar :  $chalet->chalet_name_en}}
@endsection

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h2 class="fw-bold">{{ $chalet->views->count() }}</h2>
                <h5 class="mb-0"> {{ __('back.views') }} </h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h2 class="fw-bold">  {{ number_format(round($chalet->reviews->avg('rating'), 1), 1) }}  </h2>
                <h5 class="mb-0"> {{ __('back.guest_reviews') }} </h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h2 class="fw-bold">  {{ $chalet->bookings->count() }}  </h2>
                <h5 class="mb-0"> {{ __('back.bookings') }} </h5>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <th>{{ trans('back.main_image') }}</th>
                            <td>
                                @if($chalet->main_image)
                                    <img src="{{ asset($chalet->main_image) }}" alt="Main Image" width="60">
                                @else
                                    {{ trans('back.no_image') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ trans('back.owner') }}</th>
                            <td>{{ $chalet->owner->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('back.chalet_name') }}</th>
                            <td>
                                {{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}
                            </td>
                        </tr>
                        <tr>
                            <th>{{ trans('back.city_area') }}</th>
                            <td>
                                {{ app()->getLocale() == 'ar' ? $chalet->city->name_ar : $chalet->city->name_en }}
                                ({{ app()->getLocale() == 'ar' ? $chalet->area->name_ar : $chalet->area->name_en }})
                            </td>
                        </tr>
                        <tr>
                            <th>{{ trans('back.location') }}</th>
                            <td>{{ $chalet->location }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('back.default_day_price') }}</th>
                            <td>{{ number_format($chalet->default_day_price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('back.stay_price') }}</th>
                            <td>{{ number_format($chalet->stay_price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('back.half_day_price') }}</th>
                            <td>{{ number_format($chalet->half_day_price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('back.featured') }}</th>
                            <td>{!! $chalet->isFeature() !!}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('back.status') }}</th>
                            <td>
                                <button class="btn btn-white btn-xs" data-toggle="modal" data-target="#model_status{{ $chalet->id }}">
                                    {!! $chalet->status() !!}
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th>{{ trans('back.action') }}</th>
                            <td>
                                <a class="btn btn-info btn-xs" href="{{ route('chalets.prices.index', $chalet->id) }}">
                                    <i class="fas fa-dollar-sign"></i>
                                </a>

                                @can('show_chalet')
                                    <a class="btn btn-primary btn-xs" href="{{ route('chalets.images.index', $chalet->id) }}">
                                        <i class="fas fa-images"></i>
                                        ({{ count($chalet->images) }})
                                    </a>
                                @endcan

                                @can('edit_chalet')
                                    <a class="btn btn-success btn-xs" href="{{ route('chalets.edit', $chalet->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('delete_chalet')
                                    <a class="btn btn-danger btn-xs" href="" data-toggle="modal" data-target="#delete_chalet{{ $chalet->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @include('backend.pages.chalets.delete', ['chalet' => $chalet])
                                @endcan
                            </td>
                        </tr>

                        @include('backend.pages.chalets.model_status')
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- الحجوزات --}}
        <div class="col-md-12">
            <h5>{{ __('back.booking_customers') }} ({{ $chalet->bookings->count() }})</h5>
            <div class="card-box">
                <div class="table-responsive">
                    <table id="" class="table table-bordered table-striped  text-center table-sm">
                        <thead>
                        <tr>
                            <th width='25'>#</th>
                            <th width='100'>{{trans('back.booking_number')}}</th>
                            <th width='150'>{{trans('back.customer_name')}}</th>
                            <th width='100'>{{trans('back.phone')}}</th>
                            <th width='100'>{{trans('back.email')}}</th>
                            <th width='100'>{{trans('back.days_number')}}</th>
                            <th width='200'>{{trans('back.days')}}</th>
                            <th width='100'>{{trans('back.payment_method')}}</th>
                            <th width='100'>{{trans('back.Total_amount')}}</th>
                            <th width='100'>{{trans('back.amount_paid')}}</th>
                            <th width='100'>{{trans('back.rest_amount')}}</th>
                            <th width='100'>{{trans('back.Status')}}</th>
                            <th width='250'>{{trans('back.actions')}}</th>
                            <th width='100'>{{trans('back.Created_at')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($chalet->bookings as $key => $order)
                            <tr>
                                <td>{{$loop->iteration}}</td>

                                <td>{{$order->booking_number}}</td>
                                <td> {{ $order->customer_name ?? '--' }}</td>
                                <td>
                                    <a href="https://wa.me/{{$order->country.$order->phone_number}}" target="_blank">
                                        {{ $order->country.$order->phone_number ??'--' }}
                                    </a>
                                </td>
                                <td> {{ $order->email ??'--' }}</td>

                                <td>  <span class=" text-danger">{{ $order->dates->count()}}</span> {{ $order->booking_type }}</td>

                                <td style="background-color: #e5f6f4">
                                    @foreach ($order->dates as $date)
                                        <span class=" border-2 bg-blue" style='line-height: 17px'>
                                            {{ $date->date}}
                                        </span>

                                    @endforeach
                                </td>


                                <td> {{ $order->PaymentMethod->name}}{{app()->getLocale() == 'ar' ? $order->PaymentMethod->name_ar : $order->PaymentMethod->name_en}}</td>
                                <td> {{ $order->total_amount }}</td>
                                <td> {{ $order->payment_amount }}</td>
                                <td> {{  $order->total_amount - $order->payment_amount}}</td>
                                <td>{{ trans("back.$order->payment_status")}}</td>
                                <td>
                                    <a href="{{route('booking-customers.show', $order->slug)}}" target="_blank" class="btn btn-primary btn-xs ml-1" >
                                        {{__('back.Show_order')}}
                                    </a>
                                </td>
                                <td>{{$order->created_at}}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="20">
                                        {{ __('back.not_funded') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
</div>


<div class="row">
    <div class="col-12 mb-3">
        <h4 class="mb-0">  {{ __('back.guest_reviews') }} </h4>
    </div>
    <div class="col-6 d-flex align-items-center mb-3">
        <span class="badge badge-lg bg-white p-3 shadow text-dark d-flex align-items-center">
            {{ number_format(round($chalet->reviews->avg('rating'), 1), 1) }}
        </span>
        <div class="ms-2 m-2">
            <p class="mb-0"> {{ __('back.general_rating') }} ( {{ $chalet->reviews->count() }} {{ __('back.review') }} )   </p>
            <strong>{{ getRatingText(round($chalet->reviews->avg('rating'), 1)) }}</strong>
        </div>
    </div>
</div>

<div class="row mb-20">
    @foreach($chalet->reviews()->latest()->get() as $review)
        <div class="col-6 d-flex align-items-center mb-3">
            <div class="">
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ $review->customer->image ?? asset('avatar.png') }}" class="rounded-circle me-3" width="50" height="50" alt="User">
                    <div>
                        <strong class="d-block">{{ $review->customer->name ?? 'مستخدم' }}</strong>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->translatedFormat('l، j F') }}</small>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#f39c12" class="bi bi-star-fill me-2" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73-3.522-3.356c-.33-.314-.16-.888.282-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.244 4.319 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <span class="fw-bold me-2">{{ getRatingText(round($review->rating, 1)) }}</span>
                    <span class="text-muted">• {{ number_format(round($review->rating, 1),1) }}</span>
                </div>

                <div class="">
                    <p class="mb-0">{{ $review->comment }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
