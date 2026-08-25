<!-- Modal -->
<div class="modal fade" id="add_city" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.add_city')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('cities.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="name_ar">{{trans('back.name_ar')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control"   name="name_ar" placeholder="{{trans('back.name_ar')}}" value="{{ old('name_ar') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('back.name_en')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control"   name="name_en" placeholder="{{trans('back.name_en')}}" value="{{ old('name_en') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('back.image')}} </label>
                            <b class="text-danger">*</b>
                            <input type="file" class="form-control"   id="image" name="image" >
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
