@extends('backend.layouts_new.master')

@section('page_title')
    إضافة أسئلة شائعة لمقال :
    {{$post->title}}
@endsection

@section('title')
    إضافة أسئلة شائعة لمقال :
    {{$post->title}}
@endsection

@section('css')
        .close-icon{
            border-radius: 50%;
            position: absolute;
            right: 5px;
            top: -10px;
            padding: 5px 8px;
        }
@endsection

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action="{{route('faqs.store')}}"  method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <input type="hidden" name="post_id" class="form-control" value="{{$post->id}}">

                        <div class="col-md-10 mb-2">
                            <input type="text" name="name" class="form-control" placeholder="الاسم" value="{{old('name')}}">
                        </div>

                        <div class="col-md-2 mb-2">
                            <button type="submit" class="btn btn-success btn-block">اضافة</button>
                        </div>

                        <div class="form-group col-md-12 mb-2" >
                            <textarea class="form-control tinymce" rows="2" name="body" placeholder="الوصف"> {{ old('body') }}  </textarea>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    @if($post->faqs->count())

                            <div class="table-responsive">
                                <table id="" class="table table-bordered text-center table-sm">
                                    <thead>
                                    <tr>
                                        <th>السؤال</th>
                                        <th> الاجابة</th>
                                        <th>اجراء</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($post->faqs as $faq)
                                        <tr>
                                            <td> {{$faq->name}}</td>
                                            <td> {{$faq->body}}</td>
                                            <td>

                                            <button class="btn btn-success btn-xs ml-1" data-toggle="modal" data-target="#edit_post_faqs{{$faq->id}}" >
                                                تعديل
                                            </button>
                                            @include('backend.pages.Posts._edit_post_faqs')


                                            <button class="btn btn-danger btn-xs ml-1" data-toggle="modal" data-target="#delete_post_faqs{{$faq->id}}">
                                                حذف
                                            </button>
                                            @include('backend.pages.Posts._delete_post_faqs')

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        <div class="col-md-12">
                            <h4 class="text-center">
                                لا يوجد
                            </h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

