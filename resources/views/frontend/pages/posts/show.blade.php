@extends('frontend.layouts.master_page')

@php
    $locale = app()->getLocale();
    $setting = App\Models\Setting::first();
    $title = $locale == 'ar' ? $post->title_ar : $post->title_en;
    $body = $locale == 'ar' ? $post->body_ar : $post->body_en;
    $meta_keywords = $locale == 'ar' ? $post->meta_keywords_ar : $post->meta_keywords_en;
    $meta_description = $locale == 'ar' ? $post->meta_description_ar : $post->meta_description_en;
@endphp

@section('meta_keywords')
    {{ $meta_keywords }}
@endsection

@section('meta_description')
    {{ $meta_description }}
@endsection

@section('page_title')
    {{ trans('back.posts') }}
@endsection

@section('content')

    <!-- Page Title -->
    <section id="page-title" class="page-title-parallax page-title-dark mb-5 mt-2"
             style="background-image: url({{ asset($setting->bg) }}); background-size: auto; background-position: top; background-repeat: no-repeat;">
        <div class="container">
            <h1 style="font-size: 33px">{{ $title }}</h1>
            <nav aria-label="breadcrumb mt-5" class="breadcrumb-row">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ trans('back.main') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('all-posts') }}">{{ trans('back.posts') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ul>
            </nav>
        </div>
    </section>

    <!-- Post Content -->
    <section class="content-inner-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dlab-media m-b30 rounded-md">
                        <img src="{{ asset($post->image) }}" alt="" style="max-height: 400px; width: 100%; object-fit: cover">
                    </div>

                    <div class="dlab-content">
                        <div class="m-b40">
                            <h3>{{ $title }}</h3>
                            <p>{!! $body !!}</p>
                        </div>

                        {{-- صور إضافية --}}
                        @if($post->Images && $post->Images->count())
                            <section class="content-inner-2"
                                     style="background-image: url(images/background/bg17.png); background-size: cover; background-position: top center; background-repeat: no-repeat;">
                                <div class="container">
                                    <div class="row lightgallery">
                                        @foreach ($post->Images as $image)
                                            <div class="card-container col-lg-3 col-md-3 col-sm-12 web_development wow fadeInUp">
                                                <div class="dlab-box dlab-overlay-box style-2 m-b30 overlay-shine">
                                                    <div class="dlab-media dlab-img-overlay1">
                                                        <img src="{{ asset($image->image) }}" alt="{{ $image->name }}">
                                                        <span data-exthumbimage="{{ asset($image->image) }}"
                                                              data-src="{{ asset($image->image) }}"
                                                              class="lightimg" title="Design">
                                                    <i class="la la-plus"></i>
                                                </span>
                                                    </div>
                                                    <div class="dlab-info">
                                                        <h5 class="title">{{ $image->name }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif

                        {{-- الفيديو --}}
                        @if($post->video)
                            <div class="row mb-5">
                                <div class="col-lg-12">
                                    {!! $post->video !!}
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
