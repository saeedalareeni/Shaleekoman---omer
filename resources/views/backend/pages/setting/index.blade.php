@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.setting')}}
@endsection

@section('title')
    {{trans('back.setting')}}
@endsection

@section('content')

    @can('setting')
        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <form action=" {{ route('setting.update', $setting->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">

                            <div class="form-group col-md-3">
                                <label for="exampleFormControlFile1">{{trans('back.logo')}} </label>
                                <input type="file" class="form-control-file" name="logo" id="logo">
                                <img src="{{ asset($setting->logo) }}"  alt="image" width="100px">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="stamp"> {{trans('back.stamp')}}</label>
                                <input type="file" class="form-control-file" name="stamp" id="stamp">
                                <img src="{{ asset($setting->stamp) }}"  alt="image" width="100px">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="header">{{trans('back.header')}} </label>
                                <input type="file" class="form-control-file" name="header" id="header">
                                <img src="{{ asset($setting->header) }}"  alt="image" width="100%">
                            </div>

                            <hr class="col-md-12">

                            <div class="form-group col-md-3">
                                <label for="company_name_ar"> {{trans('back.company_name_ar')}}   </label>
                                <input type="text" class="form-control"  name="company_name_ar" value="{{ $setting->company_name_ar }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="company_name_en"> {{trans('back.company_name_en')}}   </label>
                                <input type="text" class="form-control"  name="company_name_en" value="{{ $setting->company_name_en }}">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="cr_no"> {{trans('back.cr_no')}}   </label>
                                <input type="text" class="form-control"  name="cr_no" value="{{ $setting->cr_no }}">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="address_ar"> {{trans('back.address_ar')}}   </label>
                                <input type="text" class="form-control"  name="address_ar" value="{{ $setting->address_ar }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="address_en"> {{trans('back.address_en')}}   </label>
                                <input type="text" class="form-control"  name="address_en" value="{{ $setting->address_en }}">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="governorate_ar"> {{trans('back.governorate_ar')}}   </label>
                                <input type="text" class="form-control"  name="governorate_ar" value="{{ $setting->governorate_ar }}">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="governorate_en"> {{trans('back.governorate_en')}}   </label>
                                <input type="text" class="form-control"  name="governorate_en" value="{{ $setting->governorate_en }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="wilayat_ar"> {{trans('back.wilayat_ar')}}   </label>
                                <input type="text" class="form-control"  name="wilayat_ar" value="{{ $setting->wilayat_ar }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="wilayat_en"> {{trans('back.wilayat_en')}}   </label>
                                <input type="text" class="form-control"  name="wilayat_en" value="{{ $setting->wilayat_en }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="building_no"> {{trans('back.building_no')}}   </label>
                                <input type="text" class="form-control"  name="building_no" value="{{ $setting->building_no }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="PO_box"> {{trans('back.PO_box')}}   </label>
                                <input type="text" class="form-control"  name="PO_box" value="{{ $setting->PO_box }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="pc"> {{trans('back.pc')}}   </label>
                                <input type="text" class="form-control"  name="pc" value="{{ $setting->pc }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="email"> {{trans('back.email')}}  </label>
                                <input type="email" class="form-control"   name="email" value="{{ $setting->email }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="phone"> {{trans('back.phone')}}   </label>
                                <input type="number" class="form-control" name="phone" value="{{ $setting->phone }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="tax_no"> الرقم الضريبي   </label>
                                <input type="text" class="form-control" name="tax_no" value="{{ $setting->tax_no }}" placeholder="الرقم الضريبي">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="tax"> قيمة الضريبة   </label>
                                <input type="number" class="form-control" name="tax" value="{{ $setting->tax }}" placeholder="قيمة الضريبة">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="advance_amount"> {{trans('back.advance_amount')}}   </label>
                                <input type="number" class="form-control"  name="advance_amount" value="{{ App\Models\Setting::first()->advance_amount }}">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="terms_ar">  {{trans('back.terms_ar')}}  </label>
                                <textarea id="editor_ar" class="editor" name="terms_ar"> {{ $setting->terms_ar }}  </textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="terms_en">  {{trans('back.terms_en')}}  </label>
                                <textarea id="editor_en" class="editor" name="terms_en"> {{ $setting->terms_en }}  </textarea>
                            </div>


                           
                            <div class="form-group col-md-12 text-center">
                                <button type="submit" class="btn btn-success"> {{trans('back.save')}}  </button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    @endcan

@endsection


