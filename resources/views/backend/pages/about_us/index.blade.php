@extends('backend.layouts.master')

@section('page_title')
{{trans('back.about_us')}}
@endsection

@section('title')
{{trans('back.about_us')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">

            <div class="card-box">

                <form action=" {{ route('abouts.update', $about->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-row">

                        <div class="form-group col-md-2">
                            <label for="logo">{{trans('back.upload_logo')}} </label>
                            <input type="file" class="form-control-file" name="logo" id="logo">
                        </div>

                        <div class="form-group col-md-2">
                            <img src="{{ URL::asset($about->logo) }}"  alt="image" width="100">
                        </div>


                        <div class="form-group col-md-2">
                            <label for="image_about_us">{{trans('back.image_about_us')}} </label>
                            <input type="file" class="form-control-file" name="image_about_us" >
                        </div>

                        <div class="form-group col-md-2">
                            <img src="{{ URL::asset($about->image_about_us) }}"  alt="image" width="100">
                        </div>


                        <div class="form-group col-md-2">
                            <label for="bg">{{trans('back.bg')}} </label>
                            <input type="file" class="form-control-file" name="bg" >
                        </div>

                        <div class="form-group col-md-2">
                            <img src="{{ URL::asset($about->bg) }}"  alt="image" width="100">
                        </div>


                        <hr class="col-md-12">

                        {{--  التعريف --}}
                        <div class="form-group col-md-6">
                            <label for="company_name_ar"> {{trans('back.company_name_ar')}}  </label>
                            <input type="text" class="form-control "   name="company_name_ar" value="{{ $about->company_name_ar }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="company_name_en"> {{trans('back.company_name_en')}}  </label>
                            <input type="text" class="form-control " name="company_name_en" value="{{ $about->company_name_en }}">
                        </div>

                        <hr class="col-md-12">

                        <div class="form-group col-md-6">
                            <label for="short_about_ar"> {{trans('back.short_about_ar')}}</label>
                            <textarea class="form-control editor" name="short_about_ar" cols="30" rows="10"> {{ $about->short_about_ar }} </textarea>
                        </div>

                        <div class="form-group col-md-6" >
                            <label for="short_about_en">   {{trans('back.short_about_en')}} </label>
                            <textarea class="form-control editor" name="short_about_en" cols="30" rows="10"> {{ $about->short_about_en }} </textarea>
                        </div>

                        <hr class="col-md-12">

                        <div class="form-group col-md-6">
                            <label for="about_ar"> {{trans('back.description_ar')}}</label>
                            <textarea class="form-control editor" name="about_ar" cols="30" rows="10"> {{ $about->about_ar }} </textarea>
                        </div>

                        <div class="form-group col-md-6" >
                            <label for="about_en">   {{trans('back.description_en')}} </label>
                            <textarea class="form-control editor" name="about_en" cols="30" rows="10"> {{ $about->about_en }} </textarea>
                        </div>

                        <hr class="col-md-12">

                        <div class="form-group col-6">
                            <label for="meta_description_ar">{{trans('back.meta_description_ar')}}</label>
                            <textarea class="form-control"  name="meta_description_ar" rows="4">{{$about->meta_description_ar}}</textarea>
                        </div>

                        <div class="form-group col-6">
                            <label for="meta_description_en">{{trans('back.meta_description_en')}}</label>
                            <textarea class="form-control"  name="meta_description_en" rows="4">{{$about->meta_description_en}}</textarea>
                        </div>

                        <div class="form-group col-6">
                            <label for="meta_keywords_ar">{{trans('back.meta_keywords_ar')}}</label>
                            <textarea class="form-control" name="meta_keywords_ar" rows="4">{{$about->meta_keywords_ar}}</textarea>
                        </div>

                        <div class="form-group col-6">
                            <label for="meta_keywords_en">{{trans('back.meta_keywords_en')}}</label>
                            <textarea class="form-control" name="meta_keywords_en" rows="4">{{$about->meta_keywords_en}}</textarea>
                        </div>


                        <div class="form-group col-md-12 text-center">
                            <button type="submit" class="btn btn-success"> {{trans('back.save_and_update')}}   </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@section('js')



@endsection


