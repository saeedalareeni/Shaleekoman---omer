@extends('owners.layouts.master')

@section('page_title')
    {{trans('back.booking_customers')}}
@endsection

@section('title')
    {{trans('back.booking_customers')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4 mb-1">
            <div class=" justify-content-between ">
                {{-- فلتر --}}
                <form>
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <select class="form-control form-control-sm " name="chalet_id" >
                                <option value="0">{{trans('back.All')}}</option>
                                @foreach(App\Models\Chalet::where('owner_id',auth()->user()->id)->get() as $chalet)
                                    <option value="{{ $chalet->id }}" {{ old('chalet_id', request()->input('chalet_id')) == $chalet->id ? 'selected' : null }}>
                                        {{app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary btn-sm " type="submit" formaction="{{ route('owner.filter_booking_by_chalet') }}" formmethod="get"> {{trans('back.Search')}}  </button>
                            <button class="btn btn-secondary btn-sm " type="submit" formaction="{{ route('owner.filter_booking_by_chalet_excel') }}" formmethod="post"> excel </button>
                            <a href="{{ route('owner.bookings.index') }}" class="btn btn-success btn-sm " type="button" title="Reload">
                                <span class="fas fa-sync-alt"></span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="col-md-8 mb-1">
            <form action="{{ route('owner.search_booking_between_date') }}" method="GET" role="search">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="query"value="{{ request()->input('query') }}" placeholder="{{ trans('back.search_placeholder') }}">
                    </div>
                    <div class="col-md-3">
                        <input name="start_date" class="form-control form-control-sm mb-1 " type="date" value="{{ $start_date??"" }}">
                    </div>
                    <div class="col-md-3">
                        <input name="end_date" class="form-control form-control-sm mb-1 " type="date" value="{{ $end_date??"" }}">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-sm " type="submit" > {{trans('back.Search')}}  </button>
                        <a href="{{ route('owner.bookings.index') }}" class="btn btn-success btn-sm" type="button" title="تحديث الصفحة">
                            <span class="fas fa-sync-alt"></span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="table-responsive">
                    <table id="" class="table table-bbookinged table-striped  text-center table-sm">
                        <thead>
                        <tr>
                            <th width='25'>#</th>
                            <th width='200'>{{trans('back.chalet_name')}}</th>
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
                            <th width='100'>{{trans('back.booking_status')}}</th>
                            <th width='100'>{{trans('back.payment_status')}}</th>
                            <th width='400'>{{trans('back.actions')}}</th>
                            <th width='100'>{{trans('back.Created_at')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $key => $booking)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{ app()->getLocale() == 'ar' ? $booking->chalet->chalet_name_ar : $booking->chalet->chalet_name_en }}
                                </td>
                                <td>{{$booking->booking_number}}</td>
                                <td>{{ htmlspecialchars($booking->customer_name ?? '--', ENT_QUOTES, 'UTF-8') }}</td>
                                <td>
                                    <a href="https://wa.me/{{$booking->country.$booking->phone_number}}" target="_blank">
                                        {{ $booking->country.$booking->phone_number ??'--' }}
                                    </a>
                                </td>
                                <td>{{ htmlspecialchars($booking->email ?? '--', ENT_QUOTES, 'UTF-8') }}</td>

                                <td>  <span class=" text-danger">{{ $booking->dates->count()}}</span> {{ $booking->booking_type }}</td>

                                <td style="background-color: #e5f6f4">
                                    @foreach ($booking->dates as $date)
                                        <span class=" bbooking-2 bg-blue" style='line-height: 17px'>
                                            {{ $date->date}}
                                        </span>

                                    @endforeach
                                </td>


                                <td>
                                    @if($booking->PaymentMethod)
                                        {{ app()->getLocale() == 'ar' ? $booking->PaymentMethod->name_ar : $booking->PaymentMethod->name_en }}
                                    @else
                                        @if($booking->payment_method == 'cash')
                                            {{ trans('back.cash') }}
                                        @elseif($booking->payment_method == 'card')
                                            {{ trans('back.credit_card') }}
                                        @elseif($booking->payment_method == 'bank_transfer')
                                            {{ trans('back.bank_transfer') }}
                                        @else
                                            {{ $booking->payment_method ?? '--' }}
                                        @endif
                                    @endif
                                </td>
                                <td> {{ $booking->total_amount }}</td>
                                <td> {{ $booking->payment_amount }}</td>
                                <td> {{  $booking->total_amount - $booking->payment_amount}}</td>
                                <td>
                                    @if($booking->status)
                                        <span class="badge badge-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'info') }}">
                                            {{ trans("back.$booking->status") }}
                                        </span>
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $booking->payment_status == 'paid' ? 'success' : 'danger' }}">
                                        {{ trans("back.$booking->payment_status") }}
                                    </span>
                                </td>
                                <td>
                                    
                                    <a href="{{route('owner.bookings.show', $booking->slug)}}" target="_blank" class="btn btn-primary btn-xs ml-1" >
                                        <span class="fas fa-print"></span>
                                    </a>

                                    <a class="btn btn-danger btn-xs" href="" data-toggle="modal" data-target="#delete_booking{{ $booking->booking_number }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @include('owners.pages.bookings.delete')



                                    @if ($booking->cancellation_status)
                                    <button class="btn btn-danger btn-xs disabled">
                                        {{ $booking->cancellation_status }}
                                    </button>
                                    @else
                                        <a class="btn btn-warning btn-xs" href="" data-toggle="modal" data-target="#cancel_booking{{ $booking->booking_number }}">
                                            {{ __('back.cancel') }}
                                        </a>
                                        @include('owners.pages.bookings.cancel')
                                    @endif
                                </td>
                                <td>{{$booking->created_at}}</td>
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
                    <div class="text-center">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
