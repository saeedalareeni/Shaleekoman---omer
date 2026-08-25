<!-- Modal -->
<div class="modal fade" id="edit_city{{$city->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.edit_city')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">

                <form action=" {{ route('cities.update', $city->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="name_ar">{{trans('back.name_ar')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control"   name="name_ar"  value="{{ $city->name_ar }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('back.name_en')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control"   name="name_en"  value="{{ $city->name_en }}">
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">{{ trans('back.image') }}</label>
                                <div class="d-flex">
                                    <input type="file" class="form-control" id="image" name="image">
                                    <img src="{{ asset($city->image??'no_image.png') }}" class=" avatar-sm rounded-circle" alt="">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{trans('back.Save')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
