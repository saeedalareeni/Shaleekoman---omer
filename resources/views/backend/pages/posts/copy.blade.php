@extends('backend.layouts_new.master')

@section('page_title')
نسخ المقالة:
    {{$post->title}}
@endsection

@section('title')
نسخ المقالة:
    {{$post->title}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <form action="{{route('Posts.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">

                        <div class="col-md-8">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="title">عنوان المقال</label>
                                    <input type="text" class="form-control" placeholder="عنوان المقال" name="title" value="{{$post->title}}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="slug">slug</label>
                                    <input type="text" class="form-control slug" placeholder="slug" name="slug"  value="{{$post->slug}}" required>
                                </div>

                            </div>

                            <div class="form-group col-12">
                                <label for="body">تفاصيل المقال</label>
                                <textarea class="form-control tinymce "    name="body" rows="3" >{{$post->body}}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="row">

                                <div class="form-group col-md-12">
                                    <label for="image">صورة المقالة</label>
                                    <input type="file" class="dropify" data-max-file-size="1M" data-height="130" name="image" >
                                </div>

                                <div class="form-group col-12">
                                    <label for="video">فيديو</label>
                                    <textarea class="form-control" id="video" name="video" rows="3">{{$post->video}}</textarea>
                                    @error('video')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="product_category_id">اختر القسم</label>
                                    <select name="posts_category_id" class="form-control" required>
                                        <option value="" selected disabled>اختر القسم</option>
                                        @forelse(App\Models\PostsCategory::all() as $postsCategory)
                                            <option value="{{ $postsCategory->id }}" {{ old('posts_category_id', $post->posts_category_id) == $postsCategory->id ? 'selected' : null }}>{{ $postsCategory->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('posts_category_id')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="form-group col-6">
                                    <label for="status">الحالة</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status', $post->status) == 1 ? 'selected' : null }}>مفعل</option>
                                        <option value="0" {{ old('status', $post->status) == 0 ? 'selected' : null }}>غير مفعل</option>
                                    </select>
                                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="featured">مميز ام لا</label>
                                    <select name="featured" class="form-control">
                                        <option value="1" {{ old('featured', $post->featured) == 1 ? 'selected' : null }}>مميز</option>
                                        <option value="0" {{ old('featured', $post->featured) == 0 ? 'selected' : null }}>غير مميز</option>
                                    </select>
                                    @error('featured')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>


                                <div class="form-group col-12">
                                    <label for="meta_description">الوصف (السيو)</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{$post->meta_description}}</textarea>
                                    @error('meta_description')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="form-group col-12">
                                    <label for="meta_keywords">الكلمات الدلالية (السيو)</label>
                                    <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3">{{$post->meta_keywords}}</textarea>
                                    @error('meta_keywords')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"> حفظ وإنشاء</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection



