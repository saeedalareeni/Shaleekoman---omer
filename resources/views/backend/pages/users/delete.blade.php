<!-- Modal -->
<div class="modal fade" id="delete_user{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fcf9f0; border: 1px solid #d09400; top: 50px" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.Delete_User')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>
                    {{trans('back.Are you sure to delete')}}
                    {{ $user->name }}
                </h6>

                <form action=" {{route('users.destroy', $user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{trans('back.close')}} </button>
                        <button type="submit" class="btn btn-danger">{{trans('back.delete')}} </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
