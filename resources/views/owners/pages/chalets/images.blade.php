@extends('owners.layouts.master')

@section('page_title')
    إضافة صور للشاليه
    {{ $chalet->chalet_name_ar }}
@endsection

@section('title')
    إضافة صور للشاليه
    {{ $chalet->chalet_name_ar }}
@endsection

@section('content')

    <div class="row">

        <div class="container mt-4">

            <form action="{{ route('owner.chalets.images.store', $chalet->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="image-upload-container" class="form-group">
                    <div class="image-upload row mb-3">
                        <div class="col-md-4">
                            <input type="file" class="form-control form-control-file" name="images[]" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="image_names_ar[]" placeholder="اسم الصورة بالعربية">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="image_names_en[]" placeholder="اسم الصورة بالإنجليزية">
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary btn-sm mb-3" onclick="addImageUploadField()">إضافة صورة أخرى</button>

                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary w-50">حفظ</button>
                </div>

            </form>


            <!-- عرض الصور الحالية -->
            <div class="mt-5">
                <h4>الصور الحالية:</h4>
                <div class="row justify-content-center">
                    @foreach($chalet->images as $image)
                        <div class="col-md-3 mb-3 text-center">
                            <img src="{{ asset($image->image_path) }}" class="img-thumbnail" alt="{{ $image->image_name_ar }}">
                            <h6 style="line-height: 20px">
                                {{ $image->image_name_ar }} <br> {{ $image->image_name_en }}
                            </h6>
                            <form action="{{ route('owner.chalets.images.destroy', $image->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs">حذف</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

@endsection


@section('js')
    <script>
        function addImageUploadField() {
            var container = document.getElementById('image-upload-container');
            var div = document.createElement('div');
            div.classList.add('image-upload', 'row', 'mb-3');
            div.innerHTML = `
        <div class="col-md-4">
            <input type="file" class="form-control form-control-file" name="images[]" required>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="image_names_ar[]" placeholder="اسم الصورة بالعربية">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="image_names_en[]" placeholder="اسم الصورة بالإنجليزية">
        </div>
    `;
            container.appendChild(div);
        }
    </script>
@endsection
