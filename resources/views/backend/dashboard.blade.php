@extends('backend.layouts.master')

@section('page_title')
{{trans('back.dashboard')}}
@endsection

@section('content')
    <div class="row justify-content-center p-3">
        @php
            $settings = App\Models\Setting::first();
            $logo = $siteLogo ?? asset('assets/images/shaleek_logo.png');
        @endphp
        <div class="text-center">
            <img src="{{ $logo }}" alt="Logo" style="height: 100px; width: auto; object-fit: contain; display: inline-block;">
        </div>
    </div>

    <div class="row text-center m-auto justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2 class="fw-bold">{{ \App\Models\View::whereNull('chalet_id')->count() }}</h2>
                    <h5 class="mb-0">  {{ __('back.guastwebsit_count') }} </h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2 class="fw-bold">{{ App\Models\Chalet::count()}}</h2>
                    <h5 class="mb-0">  {{ __('back.chalets_count') }} </h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2 class="fw-bold">{{ App\Models\Booking::count() }}</h2>
                    <h5 class="mb-0">  {{ __('back.bookings_count') }} </h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2 class="fw-bold">{{ App\Models\Customer::count() }}</h2>
                    <h5 class="mb-0">  {{ __('back.customer_count') }} </h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2 class="fw-bold">{{ App\Models\Owner::count() }}</h2>
                    <h5 class="mb-0">  {{ __('back.owner_count') }} </h5>
                </div>
            </div>
        </div>
    </div>
@endsection
