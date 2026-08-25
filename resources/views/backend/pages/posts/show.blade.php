@extends('backend.layouts.master')

@section('page_title')
{{ trans('back.add_image_post') }}  :
    {{$post->title}}
@endsection

@section('title')
    {{ trans('back.add_image_post') }} :
    {{$post->title}}
@endsection
@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action="{{route('image-gallery.store')}}"  method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <input type="hidden" name="post_id" class="form-control" value="{{$post->id}}">

                        <div class="col-md-5">
                            <input type="text" name="name" class="form-control" placeholder="name">
                        </div>
                        <div class="col-md-5">
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-purple"> {{ trans('back.add_image_post') }}</button>
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
                    @if($post->Images->count())
                        @foreach($post->Images as $image)
                        <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                            <a class="thumbnail fancybox" rel="ligthbox" href="{{ $image->image }}">
                                <img class="img-responsive avatar-xl" alt="" src="{{ asset( $image->image ) }}" />
                                <div class='text-center'>
                                    <small class='text-muted'>{{ $image->title }}</small>
                                </div>
                            </a>
                            <form action="{{route('image-gallery.destroy', $image->id)}}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-xs mt-2 text-center"> {{ trans('back.delete') }} </button>
                            </form>
                        </div>



                        @endforeach
                    @else
                        <div class="col-md-12">
                            <h4 class="text-center">
                                لا يوجد صور
                            </h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection






@section('js')

    <script type="text/javascript">
        $(document).ready(function(){
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });
        });
    </script>

@endsection
