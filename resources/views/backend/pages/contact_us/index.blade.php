@extends('backend.layouts.master')

@section('page_title')
{{trans('back.contact_us')}}
@endsection

@section('title')
{{trans('back.contact_us')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action=" {{ route('contacts.update', $contact->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label for="address_ar"> {{trans('back.address_ar')}} </label>
                            <input type="text" class="form-control"   name="address_ar" value="{{ $contact->address_ar }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="address_en"> {{trans('back.address_en')}} </label>
                            <input type="text" class="form-control"  name="address_en" value="{{ $contact->address_en }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="body_ar"> {{trans('back.other_details_ar')}} </label>
                            <textarea class="tinymce editor" name="body_ar"  cols="30" rows="10">{{ $contact->body_ar }}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="body_en"> {{trans('back.other_details_en')}} </label>
                            <textarea class="editor" name="body_en"   cols="30" rows="10">{{ $contact->body_en }}</textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="map">   {{trans('back.map')}} </label>
                            <textarea class="form-control"  name="map" rows="5"> {{ $contact->map }}  </textarea>
                        </div>

                        {{-- <div class="form-group col-md-12">
                            <label for="map_footer"> {{trans('back.map_footer')}} </label>
                            <textarea class="form-control"  name="map_footer" rows="5"> {{ $contact->map_footer }}  </textarea>
                        </div> --}}

                        <div class="form-group col-md-3">
                            <label for="email"> {{trans('back.email')}} </label>
                            <input type="email" class="form-control" id="email"  name="email" value="{{ $contact->email }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="phone"> {{trans('back.Phone')}} </label>
                            <input type="number" class="form-control" name="phone" value="{{ $contact->phone }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="whatsapp"> {{trans('back.whatsapp')}} </label>
                            <input type="number" class="form-control" name="whatsapp" value="{{ $contact->whatsapp }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="facebook_url"> {{trans('back.facebook_url')}} </label>
                            <input type="text" class="form-control" name="facebook_url" value="{{ $contact->facebook_url }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="instagram_url"> {{trans('back.instagram_url')}} </label>
                            <input type="text" class="form-control" name="instagram_url" value="{{ $contact->instagram_url }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="twitter_url"> {{trans('back.twitter_url')}} </label>
                            <input type="text" class="form-control" name="twitter_url" value="{{ $contact->twitter_url }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="youtube_url"> {{trans('back.youtube_url')}} </label>
                            <input type="text" class="form-control" name="youtube_url" value="{{ $contact->youtube_url }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="linkedin_url"> {{trans('back.linkedin_url')}} </label>
                            <input type="text" class="form-control" name="linkedin_url" value="{{ $contact->linkedin_url }}">
                        </div>

                        <div class="form-group col-md-12 text-center">
                            <button type="submit" class="btn btn-success"> {{trans('back.save_and_update')}}  </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

