<!-- Modal -->
<div class="modal fade" id="edit_area{{$area->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.edit_area')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-left">
                <form action="{{ route('areas.update', $area->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name_ar">{{trans('back.name_ar')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" name="name_ar" value="{{ $area->name_ar }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('back.name_en')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" name="name_en" value="{{ $area->name_en }}">
                        </div>

                        <div class="form-group m-0 col-6">
                            <select class="form-control select2" name="city_id" required>
                                <option value="0" selected disabled>{{ trans('back.cities') }}</option>
                                @foreach ($cities  as $city)
                                    <option value="{{ $city->id }}" {{ $city->id== $area->city_id?'selected':'' }}>
                                        {{ app()->getLocale()=='ar'? $city->name_ar:$city->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>

            <!-- <<< انقل الـ footer إلى هنا وليس داخل الفورم >>> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    {{trans('back.Close')}}
                </button>

                <button type="submit" class="btn btn-primary">
                    {{trans('back.Save')}}
                </button>
            </div>
                </form>
            <!-- <<< إغلاق الفورم هنا فقط >>> -->

        </div>
    </div>
</div>
