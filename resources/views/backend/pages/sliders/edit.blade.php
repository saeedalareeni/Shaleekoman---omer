<!-- Modal -->
<div class="modal fade" id="edit_Slider{{$slider->id}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="exampleModalLabel">
                    {{trans('back.edit_slider')}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('sliders.update', $slider->id)}}" method="post" enctype="multipart/form-data" class="text-left">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-2 col-md-6">
                            <label class="form-label">{{trans('back.title_ar')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.title_ar')}}" name="title_ar" value="{{$slider->title_ar}}" required>
                        </div>

                        <div class="mb-2 col-md-6">
                            <label class="form-label">{{trans('back.title_en')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.title_en')}}" name="title_en" value="{{$slider->title_en}}" required>
                        </div>

                        <div class="mb-2 col-md-6">
                            <label class="form-label">{{trans('back.url')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.url')}}" name="url" value="{{$slider->url}}" required>
                        </div>

                        <div class="mb-2 col-6">
                            <label class="form-label">{{trans('back.Status')}}</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $slider->status) == 1 ? 'selected' : null }}>{{trans('back.Active')}}</option>
                                <option value="0" {{ old('status', $slider->status) == 0 ? 'selected' : null }}>{{trans('back.Inactive')}}</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-2 col-md-6">
                            <label class="form-label">{{trans('back.image')}}</label>
                            <input type="file" class="form-control form-control-file" name="image" >
                        </div>

                        <div class="mb-2 col-md-6">
                            <label class="form-label">{{trans('back.image')}} </label> <br>
                            <img src="{{asset($slider->image)}}" alt="{{$slider->name}}" class="img-thumbnail" width="100">
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
