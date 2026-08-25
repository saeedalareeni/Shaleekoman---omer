<!-- Modal -->
<div class="modal fade" id="add_banner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.add_banner')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('banners.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <div class="row mb-2">

                        <div class="mb-2 col-md-12">
                            <label class="form-label">{{trans('back.image')}} </label>
                            <input type="file" class="form-control form-control-file" name="images[]" multiple>
                        </div>
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{trans('back.Add')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
