@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.booking_customers')}}
@endsection

@section('title')
    {{trans('back.booking_customers')}}
@endsection

@section('css')
<style>
    .booking-badge {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-new { background: #17a2b8; color: #fff; }
    .badge-pending { background: #ffc107; color: #000; }
    .badge-confirmed { background: #28a745; color: #fff; }
    .badge-cancelled { background: #dc3545; color: #fff; }
    .badge-active { background: #007bff; color: #fff; }
</style>
@endsection

@section('content')

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card primary">
                <div class="text-center">
                    <div class="stats-icon text-primary">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stats-number text-primary">{{ \App\Models\Booking::count() }}</div>
                    <div class="stats-label">{{ __('back.total_bookings') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card success">
                <div class="text-center">
                    <div class="stats-icon text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-number text-success">{{ \App\Models\Booking::where('status', 'confirmed')->count() }}</div>
                    <div class="stats-label">{{ __('back.confirmed_bookings') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card warning">
                <div class="text-center">
                    <div class="stats-icon text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-number text-warning">{{ \App\Models\Booking::where('status', 'pending')->count() }}</div>
                    <div class="stats-label">{{ __('back.pending_bookings') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card info">
                <div class="text-center">
                    <div class="stats-icon text-info">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stats-number text-info">{{ \App\Models\Booking::whereDate('created_at', today())->count() }}</div>
                    <div class="stats-label">{{ __('back.today_bookings') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-box">
        <div class="filter-box-header">
            <div class="filter-box-title">
                <i class="fas fa-filter"></i>
                <span>{{ __('back.search') }} & {{ __('back.filter') }}</span>
            </div>
            <div class="filter-results">
                <i class="fas fa-list"></i> {{ __('back.results_count') }}: {{ $bookings->total() }}
            </div>
        </div>
        
        <form method="GET" action="{{ route('booking-customers.index') }}" id="filterForm">
            <div class="filter-box-body">
                <div class="filter-row">
                    <div class="filter-col">
                        <label><i class="fas fa-search"></i> {{ __('back.search') }}</label>
                        <input type="text" name="query" class="form-control" value="{{ request('query') }}" 
                               placeholder="{{ __('back.booking_search_placeholder') }}">
                    </div>
                    
                    <div class="filter-col">
                        <label><i class="fas fa-home"></i> {{ __('back.chalet') }}</label>
                        <select name="chalet_id" class="form-control">
                            <option value="">{{ __('back.all_chalets') }}</option>
                            @foreach(App\Models\Chalet::all() as $chalet)
                                <option value="{{ $chalet->id }}" {{ request('chalet_id') == $chalet->id ? 'selected' : '' }}>
                                    {{app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="filter-col">
                        <label><i class="fas fa-toggle-on"></i> {{ __('back.status') }}</label>
                        <select name="status" class="form-control">
                            <option value="">{{ __('back.all') }}</option>
                            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>{{ __('back.new') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('back.pending') }}</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>{{ __('back.confirmed') }}</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('back.cancelled') }}</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('back.active') }}</option>
                        </select>
                    </div>
                    
                    <div class="filter-col">
                        <label><i class="fas fa-calendar"></i> {{ __('back.from_date') }}</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    
                    <div class="filter-col">
                        <label><i class="fas fa-calendar"></i> {{ __('back.to_date') }}</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> {{ __('back.apply_filter') }}
                </button>
                <a href="{{ route('booking-customers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> {{ __('back.reset') }}
                </a>
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-download"></i> {{ __('back.export') }}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="exportBookingsToExcel()">
                            <i class="fas fa-file-excel text-success"></i> Excel
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="exportBookingsToPDF()">
                            <i class="fas fa-file-pdf text-danger"></i> PDF
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="bg-light">
                        <tr>
                            <th width="50">#</th>
                            <th>رقم الحجز</th>
                            <th>الشاليه</th>
                            <th>العميل</th>
                            <th>التواريخ</th>
                            <th>المبلغ</th>
                            <th>الحالة</th>
                            <th width="180">الإجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $key => $booking)
                            <tr>
                                <td>{{ $bookings->firstItem() + $key }}</td>
                                
                                <!-- Booking Number -->
                                <td>
                                    <strong>{{ $booking->booking_number }}</strong>
                                    @if($booking->created_at->diffInDays(now()) <= 1)
                                        <span class="badge badge-new">جديد</span>
                                    @endif
                                </td>
                                
                                <!-- Chalet -->
                                <td>
                                    @if($booking->chalet)
                                        <div>
                                            <strong>{{ app()->getLocale() == 'ar' ? $booking->chalet->chalet_name_ar : $booking->chalet->chalet_name_en }}</strong>
                                        </div>
                                        <small class="text-muted">{{ $booking->chalet->owner->name ?? '' }}</small>
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </td>
                                
                                <!-- Customer -->
                                <td>
                                    <div>
                                        <strong>{{ $booking->customer_name ?? 'غير محدد' }}</strong>
                                    </div>
                                    <div>
                                        <small>
                                            <i class="fas fa-phone text-muted"></i>
                                            <a href="https://wa.me/{{$booking->country.$booking->phone_number}}" target="_blank">
                                                {{ $booking->country.$booking->phone_number ?? '--' }}
                                            </a>
                                        </small>
                                    </div>
                                    @if($booking->email)
                                        <small><i class="fas fa-envelope text-muted"></i> {{ $booking->email }}</small>
                                    @endif
                                </td>
                                
                                <!-- Dates -->
                                <td>
                                    <div>
                                        <i class="fas fa-calendar-check text-success"></i>
                                        {{ $booking->checkin_date ?? '--' }}
                                    </div>
                                    <div>
                                        <i class="fas fa-calendar-times text-danger"></i>
                                        {{ $booking->checkout_date ?? '--' }}
                                    </div>
                                    <small class="text-muted">
                                        @if($booking->dates)
                                            {{ $booking->dates->count() }} ليالي
                                        @endif
                                    </small>
                                </td>
                                
                                <!-- Amount -->
                                <td>
                                    <div><strong>{{ number_format($booking->total_amount ?? 0, 2) }} ريال</strong></div>
                                    <small class="text-success">مدفوع: {{ number_format($booking->payment_amount ?? 0, 2) }}</small>
                                    @if(($booking->total_amount - $booking->payment_amount) > 0)
                                        <br><small class="text-danger">متبقي: {{ number_format($booking->total_amount - $booking->payment_amount, 2) }}</small>
                                    @endif
                                </td>
                                
                                <!-- Status -->
                                <td class="text-center">
                                    @if($booking->status == 'confirmed')
                                        <span class="badge badge-confirmed">مؤكد</span>
                                    @elseif($booking->status == 'pending')
                                        <span class="badge badge-pending">قيد الانتظار</span>
                                    @elseif($booking->status == 'cancelled')
                                        <span class="badge badge-cancelled">ملغي</span>
                                    @elseif($booking->status == 'new')
                                        <span class="badge badge-new">جديد</span>
                                    @elseif($booking->status == 'active')
                                        <span class="badge badge-active">نشط</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $booking->status }}</span>
                                    @endif
                                    
                                    @if($booking->payment_status)
                                        <br><small class="text-muted">{{ trans("back.$booking->payment_status") }}</small>
                                    @endif
                                </td>
                                
                                <!-- Actions -->
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- View/Print -->
                                        <a href="{{route('booking-customers.show', $booking->slug ?? $booking->id)}}" target="_blank" class="btn btn-info btn-sm" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Print -->
                                        <a href="{{route('booking-customers.show', $booking->slug ?? $booking->id)}}?print=true" target="_blank" class="btn btn-primary btn-sm" title="طباعة">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        
                                        @if (!$booking->cancellation_status)
                                            @can('cancel_booking')
                                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#cancel_order{{ $booking->id }}" title="إلغاء">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @endcan
                                        @endif
                                        
                                        @can('delete_booking')
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_order{{ $booking->id }}" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="p-4">
                                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">لا توجد حجوزات حالياً</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center p-3">
                    <div>
                        عرض {{ $bookings->firstItem() ?? 0 }} إلى {{ $bookings->lastItem() ?? 0 }} من {{ $bookings->total() }} حجز
                    </div>
                    <div>
                        {!! $bookings->appends(request()->query())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Include Modals -->
    @foreach($bookings as $booking)
        @include('backend.pages.bookingCustomers.delete', ['order' => $booking])
        @include('backend.pages.bookingCustomers.cancel', ['order' => $booking])
    @endforeach

@endsection

@section('js')
<script>
// Export to Excel
function exportBookingsToExcel() {
    const params = new URLSearchParams(window.location.search);
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("bookings.export.excel") }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    params.forEach((value, key) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Export to PDF
function exportBookingsToPDF() {
    const params = new URLSearchParams(window.location.search);
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("bookings.export.pdf") }}';
    form.target = '_blank';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    params.forEach((value, key) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
</script>
@endsection
