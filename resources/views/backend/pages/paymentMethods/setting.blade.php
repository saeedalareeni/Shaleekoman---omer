@extends('backend.layouts.master')

@section('page_title')
{{ trans('back.setting_payment') }} {{ app()->getLocale() == 'ar' ? $paymentMethod->name_ar : $paymentMethod->name_en }}
@endsection

@section('title')
    {{ trans('back.setting_payment') }} {{ app()->getLocale() == 'ar' ? $paymentMethod->name_ar : $paymentMethod->name_en }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payment_methods.setting') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group col-md-3">
                                <label for="is_active">{{ trans('back.status') }}</label>
                                <select class="form-control" name="is_active" id="is_active" required>
                                    <option value="1" {{ $paymentMethod->is_active ? 'selected' : '' }}>{{ trans('back.active') }}</option>
                                    <option value="0" {{ !$paymentMethod->is_active ? 'selected' : '' }}>{{ trans('back.inactive') }}</option>
                                </select>
                            </div>
                            <input type="hidden" class="form-control" value="{{ $paymentMethod->id }}" name="id">
                            @if($paymentMethod->name_en=='PayPal')
                                <div class="form-group col-12">
                                    <label for="secret_key">CLIENT SECRET</label>
                                    <input type="text" class="form-control" value="{{ $paymentMethod->secret_key }}" name="secret_key" id="secret_key" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="client_id">CLIENT ID</label>
                                    <input type="text" class="form-control"value="{{ $paymentMethod->client_id }}" name="client_id" id="client_id" required>
                                </div>
                            @endif


                            @if($paymentMethod->name_en=='Thawani' || $paymentMethod->name_en=='Card payment')
                                <div class="form-group col-12">
                                    <label for="secret_key">Secret Key</label>
                                    <input type="text" class="form-control" name="secret_key"value="{{ $paymentMethod->secret_key }}" id="secret_key" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="publish_key">Publishable Key</label>
                                    <input type="text" class="form-control" name="publish_key" id="publish_key" value="{{ $paymentMethod->publish_key }}" required>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('paymentsMethod.index') }}" class="btn btn-secondary">{{ trans('back.back') }}</a>
                            <button type="submit" class="btn btn-primary">{{ trans('back.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end row -->

@endsection
