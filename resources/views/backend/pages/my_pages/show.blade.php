@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.Add_images')}}
    {{$page->name}}
@endsection

@section('title')
    {{trans('back.Add_images')}}
    {{$page->name}}
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

                <form action="{{route('image-gallery.store')}}"  method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <input type="hidden" name="page_id" class="form-control" value="{{$page->id}}">

                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control " placeholder="{{trans('back.name')}}">
                        </div>

                        <div class="col-md-3">
                            <input type="file" name="image" class="form-control ">
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-purple ">{{trans('back.Add_image')}}</button>
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
                    @if($page->Images->count())
                        @foreach($page->Images as $image)
                            <div class='col-md-2 text-center'>

                                <a  href="{{asset( $image->image)}}" target="_blank">
                                    <img height="150" width="150"  alt="{{ $image->name}}" src="{{asset( $image->image)}}" >
                                    <div class='text-center mt-1'>
                                        <small class='text-muted'>{{ $image->name}}</small>
                                        <br>
                                    </div>
                                </a>

                                <form action="{{route('image-gallery.destroy', $image->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
    
                                    <button type="submit" class="btn btn-danger btn-xs mt-2 text-center"> {{ trans('back.delete') }} </button>
                                </form>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <h4 class="text-center">
                                {{trans('back.no_images')}}
                            </h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection

