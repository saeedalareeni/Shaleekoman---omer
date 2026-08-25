<!-- Modal -->
<div class="modal fade" id="delete_booking{{$booking->booking_number}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.delete_booking')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">

                <form action="{{route('owner.bookings.destroy', $booking->booking_number)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center" >

                        <h4>
                            {{trans('back.Are_you_sure_to_delete')}}
                            <br>
                            <br>
                            {{$booking->booking_number}}
                        </h4>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('back.close')}}</button>
                        <button type="submit" class="btn btn-success">{{trans('back.delete')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
