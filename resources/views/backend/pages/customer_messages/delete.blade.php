<!-- Modal -->
<div class="modal fade" id="delete_customer_message{{$customer_message->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.delete_customer_message')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">

                <form action="{{route('customer-messages.destroy', $customer_message->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center" >

                        <h4>
                            {{trans('back.Are you sure to delete?')}}
                            <br>
                            <br>
                            {{$customer_message->name}}
                        </h4>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">{{trans('back.Delete')}}</button>
                        <button type="button" class="btn btn-purple" data-dismiss="modal"> {{trans('back.close')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
