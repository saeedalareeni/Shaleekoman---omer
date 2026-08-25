<!-- Modal -->
<div class="modal fade" id="delete_Page{{$page->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.delete_page')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">

                <form action="{{route('pages.destroy', $page->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center" >

                        <h4>
                            {{trans('back.Are_you_sure_to_delete')}}
                            <br>
                            <br>
                            {{$page->name_ar}}
                            <br>
                        </h4>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger  mt-2">{{trans('back.delete_page')}}</button>
                        <button type="button" class="btn btn-secondary  mt-2 " data-dismiss="modal"> {{trans('back.close')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
