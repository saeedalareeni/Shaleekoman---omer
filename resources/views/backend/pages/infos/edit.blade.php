<!-- Modal -->
<div class="modal fade" id="edit_info{{$info->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.edit_Info')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{route('Infos.update', $info->id)}}" method="post" enctype="multipart/form-data" class="text-left">
                    @csrf
                    @method('PUT')
                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="name_ar">{{trans('back.name_ar')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.name_ar')}}" name="name_ar" value="{{$info->name_ar}}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name_en">{{trans('back.name_en')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.name_en')}}" name="name_en" value="{{$info->name_en}}" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="image">{{trans('back.image')}}</label>
                            <input type="file" class="form-control form-control-file" name="image" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="image">{{trans('back.image')}} </label> <br>
                            <img src="{{asset($info->image)}}" alt="{{$info->name}}" class="img-thumbnail" width="100">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="body_ar">{{trans('back.body_ar')}}</label>
                            <textarea class="form-control tinymce " name="body_ar" rows="3" >{!! $info->body_ar !!}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="body_en">{{trans('back.body_en')}}</label>
                            <textarea class="form-control tinymce " name="body_en" rows="3" >{!! $info->body_en !!}</textarea>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('back.close')}}</button>
                        <button type="submit" class="btn btn-success">{{trans('back.save_and_update')}}</button>
                    </div>


                </form>

            </div>

        </div>
    </div>
</div>

