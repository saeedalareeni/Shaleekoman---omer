<!-- Modal -->
<div class="modal fade" id="delete_Owner{{$Owner->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.delete_owner')}}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
            </div>
            <div class="modal-body">

                <h6 class="text-center lh-5">
                    {{trans('back.Are you sure to delete the owner')}}
                    <br>
                    {{ $Owner->name }}
                </h6>

                <form action=" {{route('owners.update', $Owner->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{trans('back.close')}}  </button>
                        <button type="submit" class="btn btn-danger">{{trans('back.delete')}} </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
