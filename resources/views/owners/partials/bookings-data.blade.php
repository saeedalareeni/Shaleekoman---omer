<!-- جدول البيانات -->
<div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
    <table class="table table-bordered table-striped text-center table-sm" style="min-width: 1500px;">
        <thead class="thead-dark">
            <tr>
                <th style="min-width: 40px;">#</th>
                <th style="min-width: 150px;">{{trans('back.chalet_name')}}</th>
                <th style="min-width: 100px;">{{trans('back.booking_number')}}</th>
                <th style="min-width: 120px;">{{trans('back.customer_name')}}</th>
                <th style="min-width: 100px;">{{trans('back.phone')}}</th>
                <th style="min-width: 120px;">{{trans('back.email')}}</th>
                <th style="min-width: 80px;">{{trans('back.days_number')}}</th>
                <th style="min-width: 150px;">{{trans('back.days')}}</th>
                <th style="min-width: 100px;">{{trans('back.payment_method')}}</th>
                <th style="min-width: 90px;">{{trans('back.Total_amount')}}</th>
                <th style="min-width: 90px;">{{trans('back.amount_paid')}}</th>
                <th style="min-width: 90px;">{{trans('back.rest_amount')}}</th>
                <th style="min-width: 100px;">{{trans('back.booking_status')}}</th>
                <th style="min-width: 100px;">{{trans('back.payment_status')}}</th>
                <th style="min-width: 200px;">{{trans('back.actions')}}</th>
                <th style="min-width: 100px;">{{trans('back.Created_at')}}</th>
            </tr>
        </thead>
        <tbody id="bookingsTableBody">
            @include('owners.partials.bookings-table')
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if(isset($bookings) && $bookings->hasPages())
<div class="d-flex justify-content-center mt-3" id="bookings-pagination">
    {{ $bookings->appends(request()->query())->links() }}
</div>
@endif

<!-- المودالات -->
@foreach($bookings as $booking)
    <!-- Modal حذف الحجز -->
    <div class="modal fade" id="delete_booking{{ $booking->booking_number }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('back.confirm_delete') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('back.are_you_sure_delete') }} <strong>{{ $booking->booking_number }}</strong>؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('back.cancel') }}</button>
                    <form action="{{ route('owner.bookings.destroy', $booking->booking_number) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('back.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal إلغاء الحجز -->
    <div class="modal fade" id="cancel_booking{{ $booking->booking_number }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('back.cancel_booking') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('owner.bookings.cancel', $booking->booking_number) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>{{ __('back.are_you_sure_cancel') }} <strong>{{ $booking->booking_number }}</strong>؟</p>
                        <div class="form-group">
                            <label>{{ __('back.cancellation_notes') }}</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="{{ __('back.enter_cancellation_reason') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('back.close') }}</button>
                        <button type="submit" class="btn btn-warning">{{ __('back.cancel_booking') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
