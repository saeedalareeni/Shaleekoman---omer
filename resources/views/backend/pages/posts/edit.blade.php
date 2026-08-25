@extends('backend.layouts.master')
@section('page_title')
{{ trans('back.edit_post') }}:
    {{$post->title}}
@endsection
@section('title')
{{ trans('back.edit_post') }}:
    {{$post->title}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('posts.index') }}" class="btn btn-purple btn-sm mb-2">
                {{ trans('back.back_all_posts') }}:
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('posts.update', $post->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-2 col-md-6">
                                <label class="form-label" for="title_ar"> {{trans('back.title_ar')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('back.title_ar')}}" name="title_ar" value="{{$post->title_ar}}" required>
                            </div>
                            <div class="mb-2 col-md-6">
                                <label class="form-label" for="title_en"> {{trans('back.title_en')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('back.title_en')}}" name="title_en" value="{{$post->title_en}}" required>
                            </div>
                            

                            <div class="form-group col-md-4">
                                <label for="status">{{trans('back.Status')}}</label>
                                <select name="status" class="form-control ">
                                    <option value="1" {{ old('status', $post->status) == 1 ? 'selected' : null }}>{{trans('back.Active')}}</option>
                                    <option value="0" {{ old('status', $post->status) == 0 ? 'selected' : null }}>{{trans('back.Inactive')}}</option>
                                </select>
                            </div>

                            
                            <div class="form-group col-md-4">
                                <label for="image">{{trans('back.image1')}}</label>
                                <input type="file" class="form-control form-control-file " name="image" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="image2">{{trans('back.image2')}}</label>
                                <input type="file" class="form-control form-control-file " name="image2" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="image">{{trans('back.image1')}} </label> <br>
                                <img src="{{asset($post->image)}}" alt="{{$post->name}}" class="img-thumbnail" width="100">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="image">{{trans('back.image2')}} </label> <br>
                                <img src="{{asset($post->image2)}}" alt="{{$post->name}}" class="img-thumbnail" width="100">
                            </div>
                            <div class="form-group col-6">
                                <label for="video">{{trans('back.video')}}</label>
                                <input  class="form-control" id="video" name="video" value="{{$post->video}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="featured">{{trans('back.Featured')}}</label>
                                <select name="featured" class="form-control ">
                                    <option value="1" {{ old('featured', $post->featured) == 1 ? 'selected' : null }}>{{trans('back.Featured')}}</option>
                                    <option value="0" {{ old('featured', $post->featured) == 0 ? 'selected' : null }}>{{trans('back.not_Featured')}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="body_ar">{{trans('back.body_ar')}}</label>
                                <textarea class="form-control editor "  name="body_ar" rows="3" >{{$post->body_ar}}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="body_en">{{trans('back.body_en')}}</label>
                                <textarea class="form-control editor "  name="body_en" rows="3" >{{$post->body_en}}</textarea>
                            </div>

                            <div class="form-group col-6">
                                <label for="meta_description_ar">{{trans('back.meta_description_ar')}}</label>
                                <textarea  class="form-control"  name="meta_description_ar" rows="3">{{$post->meta_description_ar}}</textarea>
                            </div>
                            <div class="form-group col-6">
                                <label for="meta_description_en">{{trans('back.meta_description_en')}}</label>
                                <textarea  class="form-control"  name="meta_description_en" rows="3">{{$post->meta_description_en}}</textarea>
                            </div>
                            <div class="form-group col-6">
                                <label for="meta_keywords_ar">{{trans('back.meta_keywords_ar')}}</label>
                                <textarea  class="form-control" name="meta_keywords_ar" rows="3">{{$post->meta_keywords_ar}}</textarea>
                            </div>
                            <div class="form-group col-6">
                                <label for="meta_keywords_en">{{trans('back.meta_keywords_en')}}</label>
                                <textarea  class="form-control" name="meta_keywords_en" rows="3">{{$post->meta_keywords_en}}</textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-purple">  {{ trans('back.save') }} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script>
        $(".checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

@endsection

