<div class="bookings-table">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ $isArabic ? 'رقم العرض' : 'Booking No.' }}</th>
                    <th>{{ $isArabic ? 'الشاليه' : 'Chalet' }}</th>
                    <th>{{ $isArabic ? 'تاريخ الوصول' : 'Check-in' }}</th>
                    <th>{{ $isArabic ? 'تاريخ المغادرة' : 'Check-out' }}</th>
                    <th>{{ $isArabic ? 'المبلغ' : 'Amount' }}</th>
                    <th>{{ $isArabic ? 'الحالة' : 'Status' }}</th>
                    <th>{{ $isArabic ? 'الإجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $order)
                <tr>
                    <td>
                        <strong>{{ $order->booking_number }}</strong>
                        <br>
                        <small class="text-muted">{{ $order->created_at->format('Y-m-d') }}</small>
                    </td>
                    <td>
                        @if($order->chalet)
                            <a href="{{ route('showChalet', $order->chalet->slug) }}" class="text-decoration-none">
                                {{ $isArabic ? $order->chalet->chalet_name_ar : $order->chalet->chalet_name_en }}
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($order->checkin_date)
                            {{ $order->checkin_date->format('Y-m-d') }}
                            @if($order->checkin_time)
                                <br><small>{{ date('g:i A', strtotime($order->checkin_time)) }}</small>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($order->checkout_date)
                            {{ $order->checkout_date->format('Y-m-d') }}
                            @if($order->checkout_time)
                                <br><small>{{ date('g:i A', strtotime($order->checkout_time)) }}</small>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <strong>{{ number_format($order->total_amount, 2) }}</strong>
                        <br>
                        <small>{{ $isArabic ? 'ريال' : 'SAR' }}</small>
                    </td>
                    <td>
                        @if($order->status == 'new')
                            <span class="badge bg-info">{{ $isArabic ? 'جديد' : 'New' }}</span>
                        @elseif($order->status == 'confirmed')
                            <span class="badge bg-success">{{ $isArabic ? 'مؤكد' : 'Confirmed' }}</span>
                        @elseif($order->status == 'canceled' || $order->status == 'cancelled')
                            <span class="badge bg-danger">{{ $isArabic ? 'ملغي' : 'Cancelled' }}</span>
                        @elseif($order->status == 'completed')
                            <span class="badge bg-primary">{{ $isArabic ? 'مكتمل' : 'Completed' }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $order->status }}</span>
                        @endif
                        
                        <br>
                        
                        @if($order->payment_status == 'paid')
                            <span class="badge bg-success mt-1">{{ $isArabic ? 'مدفوع' : 'Paid' }}</span>
                        @else
                            <span class="badge bg-warning mt-1">{{ $isArabic ? 'غير مدفوع' : 'Unpaid' }}</span>
                        @endif
                    </td>
                    <td>
                        <a class="btn-print btn btn-sm" target="_blank" href="{{ route('showInvoice', $order->slug) }}" title="{{ $isArabic ? 'طباعة' : 'Print' }}">
                            <i class="fas fa-print"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="fas fa-inbox fa-5x"></i>
                        <p>{{ $emptyMessage ?? ($isArabic ? 'لا توجد حجوزات' : 'No bookings') }}</p>
                        <a href="{{ route('showAllChalet') }}" class="btn btn-primary">
                            {{ $isArabic ? 'تصفح الشاليهات' : 'Browse Chalets' }}
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
