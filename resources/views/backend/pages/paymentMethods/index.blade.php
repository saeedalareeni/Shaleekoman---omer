@extends('backend.layouts.master')

@section('title')
{{trans('back.payment_methods')}}
@endsection

@section('title')
{{trans('back.payment_methods')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            @can('payment_methods_add')
                <a class="btn btn-purple btn-sm" href="" data-toggle="modal" data-target="#add_payment_method">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.payment_methods_add')}}
                </a>
                @include('backend.pages.paymentMethods.add')
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">


                <div class="table-responsive">
                    <table  class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th> {{trans('back.name')}}</th>
                            <th> {{trans('back.status')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                            <th width="150">  {{trans('back.Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($paymentMethods as $key => $payment_method)
                            <tr>
                                <td>{{$key+ $paymentMethods->firstItem()}}</td>
                                <td><img class=" avatar-sm" src="{{ asset($payment_method->logo??'no_image.png') }}"> {{ app()->getLocale() == 'ar' ? $payment_method->name_ar : $payment_method->name_en }}</td>
                                <td>
                                    {{ $payment_method->is_active ? trans('back.active'): trans('back.inactive') }}
                                </td>
                                <td>{{ $payment_method->created_at }}</td>
                                <td>
                                    @can('payment_methods_edit')
                                        <a href="{{ route('paymentsMethod.show',$payment_method->id) }}" class="btn btn-primary btn-sm ml-1">
                                            {{ trans('back.setting_payment') }}
                                        </a>
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>

    </script>

@endsection


