<!-- Modal -->
<div class="modal fade" id="add_Slider" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    {{trans('back.add_slider')}}
                </h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form action="{{route('sliders.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="mb-2 col-md-6">
                            <label class="form-label">{{trans('back.title_ar')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.title_ar')}}" name="title_ar" value="{{old('title_ar')}}" required>
                        </div>

                        <div class="mb-2 col-md-6">
                            <label class="form-label">{{trans('back.title_en')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.title_en')}}" name="title_en" value="{{old('title_en')}}" required>
                        </div>


                        <div class="mb-2 col-md-6">
                            <label class="form-label">{{trans('back.url')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.url')}}" name="url" value="{{old('url')}}" required>
                        </div>

                        <div class="mb-2 col-md-6">
                            <label class="form-label">{{trans('back.Status')}}</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status') == 1 ? 'selected' : null }}>{{trans('back.Active')}}</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : null }}>{{trans('back.Inactive')}}</option>
                            </select>
                        </div>

                        <div class="mb-2 col-md-6">
                            <label class="form-label">{{trans('back.image')}}</label>
                            <input type="file" class="form-control form-control-file" name="image" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('back.close')}}</button>
                        <button type="submit" class="btn btn-success"> {{trans('back.Save')}}</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
