<!-- Modal -->
<div class="modal fade" id="edit_category{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">{{trans('back.edit_category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-left">

                <form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <!-- الاسم عربي -->
                        <div class="form-group col-md-6">
                            <label>{{trans('back.name_ar')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text"
                                   class="form-control"
                                   name="name_ar"
                                   value="{{ $category->name_ar }}"
                                   required>
                        </div>

                        <!-- الاسم إنجليزي -->
                        <div class="form-group col-md-6">
                            <label>{{trans('back.name_en')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text"
                                   class="form-control"
                                   name="name_en"
                                   value="{{ $category->name_en }}"
                                   required>
                        </div>

                    </div>

                    <!-- الوصف -->
                    <div class="row mt-3">

                        <!-- الوصف عربي -->
                        <div class="form-group col-md-6">
                            <label>الوصف بالعربي</label>
                            <textarea class="form-control"
                                      name="description_ar"
                                      rows="3"
                                      placeholder="اكتب وصف القسم بالعربي">{{ $category->description_ar }}</textarea>
                        </div>

                        <!-- الوصف إنجليزي -->
                        <div class="form-group col-md-6">
                            <label>Description (English)</label>
                            <textarea class="form-control"
                                      name="description_en"
                                      rows="3"
                                      placeholder="Write category description in English">{{ $category->description_en }}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            {{trans('back.Close')}}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{trans('back.Save')}}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
