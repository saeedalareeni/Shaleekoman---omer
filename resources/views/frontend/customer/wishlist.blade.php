

@extends('frontend.layouts.master_page')
@section('title')
    {{ trans('back.wishlist') }}
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
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-3">
                            <h4 class="title ml-3">{{ trans('back.wishlist') }} </h4>
                            <div class="table-responsive text-center">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ trans('back.chalet') }} </th>
                                            <th scope="col">{{ trans('back.delete') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($chalets as $chalet)
                                            <tr>
                                                <td class="">
                                                    <a href="{{ route('showChalet', $chalet->slug) }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        {{ app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}
                                                    </a>
                                                </td>
                                                <td class="text-bold">
                                                    <button class="btn btn-sm btn-danger mx-1 btn-icon icon-start delete-wishlist-btn" data-id="{{ $chalet->id }}">
                                                        <i class="fas fa-trash ms-1"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"> {{ __('back.not_found') }} </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
