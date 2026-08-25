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
    
    <td><span class="text-danger">{{ $booking->dates->count()}}</span> {{ $booking->booking_type }}</td>
    
    <td style="background-color: #e5f6f4">
        @foreach ($booking->dates as $date)
            <span class="badge badge-info" style='line-height: 17px; margin: 2px;'>
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
    <td>{{ $booking->total_amount }}</td>
    <td>{{ $booking->payment_amount }}</td>
    <td>{{ $booking->total_amount - $booking->payment_amount }}</td>
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
        <a href="{{route('owner.bookings.show', $booking->slug)}}" target="_blank" class="btn btn-primary btn-xs ml-1">
            <span class="fas fa-print"></span>
        </a>
        
        <a class="btn btn-danger btn-xs" href="#" data-toggle="modal" data-target="#delete_booking{{ $booking->booking_number }}">
            <i class="fas fa-trash-alt"></i>
        </a>
        
        @if ($booking->cancellation_status)
            <button class="btn btn-danger btn-xs disabled">
                {{ $booking->cancellation_status }}
            </button>
        @else
            <a class="btn btn-warning btn-xs" href="#" data-toggle="modal" data-target="#cancel_booking{{ $booking->booking_number }}">
                {{ __('back.cancel') }}
            </a>
        @endif
    </td>
    <td>{{$booking->created_at}}</td>
</tr>
@empty
<tr>
    <td colspan="16" class="text-center">
        <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle"></i> {{ __('back.not_funded') }}
        </div>
    </td>
</tr>
@endforelse
