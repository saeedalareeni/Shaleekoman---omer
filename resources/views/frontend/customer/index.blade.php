{{--@extends('frontend.layouts.master_page')--}}
@extends('frontend.layouts.weekend_master')
@section('title')
    {{ trans('back.home') }}
@endsection
@section('content')
    <section class="wrapper bg-gray">
        <div class="container py-5 py-md-5">
            <nav class="d-inline-block" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">{{ __('back.home') }}</a></li>
                </ol>
            </nav>
        </div>
    </section>

    <section class=" mb-12 mt-lg-5">
        <div class="container">
            @include('frontend.customer.tap')

            @include('frontend.customer.account_information')
        </div>
    </section>
@endsection
