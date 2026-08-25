@extends('frontend.layouts.master_page')

@section('title')
    {{ trans('back.terms') }}
@endsection

@section('content')
    <section class="wrapper">
        <div class="image-wrapper bg-cover bg-image d-flex align-items-center justify-content-center mx-auto">
            <div class="container pt-17 pb-15 py-sm-17 py-xxl-20">
                <div class="row">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">{{ __('back.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('back.terms') }}</li>
                        </ol>
                    </nav>
                    <div class="col-12">
                        <h4>{{ trans('back.terms') }}</h4>
                        {!! App::getLocale() == 'ar' ? $setting->terms_ar : $setting->terms_en !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
