<!-- Modal -->
<div class="modal fade" id="cancel_order{{$order->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.cancel_booking')}} {{ $order->booking_number }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <form action="{{ route('booking-customers.cancel', $order->booking_number) }}" method="post">
                    @csrf
                    @method('DELETE')
                
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <h4 class="mb-4 text-danger">
                                {{ trans('back.are_you_sure_to_cancel_booking') }}
                               {{ $order->booking_number }}
                            </h4>
                            <p class="text-danger mb-4">
                                {{ trans('back.cancel_booking_warning') }}
                            </p>
                        </div>
                        <div class="col-md-12 mx-auto">
                            <div class="form-group">
                                <label for="notes">{{ trans('back.notes') }} ({{ trans('back.optional') }})</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="{{ trans('back.cancel_notes_placeholder') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            {{ trans('back.close') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            {{ trans('back.cancel_booking') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
