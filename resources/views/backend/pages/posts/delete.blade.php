<!-- Modal -->
<div class="modal fade" id="delete_Post{{$post->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.delete_category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">

                <form action="{{route('posts.destroy', $post->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center" >

                        <h4>
                            {{trans('back.Are you sure to delete?')}}
                            <br>
                            <br>
                            {{$post->name}}
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
