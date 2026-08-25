@extends('backend.layouts.master')

@section('page_title', trans('back.edit_chalet'))

@section('title', trans('back.edit_chalet'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <form action="{{ route('chalets.update', $chalet->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="frome">{{ trans('back.select_owner') }}</label>
                                <select id="frome" class="form-control select2" name="owner_id" required>
                                    <option selected disabled>{{ trans('back.select') }}</option>
                                   @foreach ($owners as $owner)
                                        <option value="{{$owner->id }}" {{ $chalet->owner_id == $owner->id?'selected':'' }}>  {{ $owner->name}}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="frome">{{ trans('back.select_category') }}</label>
                                <select id="frome" class="form-control select2" name="category_id" required>
                                    <option selected disabled>{{ trans('back.select') }}</option>
                                   @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $chalet->category_id == $category->id?'selected':'' }}>  {{ App::getLocale() == 'ar' ? $category->name_ar : $category->name_en}}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="chalet_name_ar">{{ trans('back.chalet_name_ar') }}</label>
                                <input type="text" class="form-control" id="chalet_name_ar" name="chalet_name_ar" value="{{ old('chalet_name_ar', $chalet->chalet_name_ar) }}" placeholder="{{ trans('back.chalet_name_ar') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="chalet_name_en">{{ trans('back.chalet_name_en') }}</label>
                                <input type="text" class="form-control" id="chalet_name_en" name="chalet_name_en" value="{{ old('chalet_name_en', $chalet->chalet_name_en) }}" placeholder="{{ trans('back.chalet_name_en') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="frome">{{ trans('back.select_city') }}</label>
                                <select id="frome" class="form-control select2" name="city_id" required>
                                    <option selected disabled>{{ trans('back.select') }}</option>
                                   @foreach ($cities as $city)
                                        <option value="{{$city->id }}" {{ $city->id == $chalet->city_id?'selected':'' }}>   {{ app()->getLocale() == 'ar' ? $city->name_ar : $city->name_en }}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="frome">{{ trans('back.areas') }}</label>
                                <select class="form-control select2" id="area_id" name="area_id" required>
                                    @foreach ($areas as $area)
                                        <option value="{{$area->id }}" {{ $area->id == $chalet->area_id?'selected':'' }}>   {{ app()->getLocale() == 'ar' ? $area->name_ar : $area->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="slug">{{ trans('back.slug') }}</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $chalet->slug) }}" placeholder="{{ trans('back.enter_slug') }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="main_image">{{ trans('back.main_image') }}</label>
                                <input type="file" class="form-control" id="main_image" name="main_image">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="default_day_price">{{ trans('back.default_day_price') }}</label>
                                <input type="number" step="0.01" class="form-control" id="default_day_price" name="default_day_price" value="{{ old('default_day_price', $chalet->default_day_price) }}" placeholder="{{ trans('back.enter_default_day_price') }}" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="holiday_day_price">{{ trans('back.holiday_day_price') }}</label>
                                <input type="number" step="0.01" class="form-control" id="holiday_day_price" name="holiday_day_price" value="{{ old('holiday_day_price', $chalet->holiday_day_price) }}" placeholder="{{ trans('back.enter_holiday_day_price') }}" required>
                            </div>
                        </div>

                        {{--سعر نصف يوم --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="half_day_price">{{ trans('back.half_day_price') }}</label>
                                <input type="number" step="0.01" class="form-control" id="half_day_price" name="half_day_price" value="{{ $chalet->half_day_price }}" placeholder="{{ trans('back.half_day_price') }}" required>
                            </div>
                        </div>

                        {{--سعر  يوم كامل مع المبيت--}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="holiday_day_price">{{ trans('back.stay_price') }}</label>
                                <input type="number" step="0.01" class="form-control" id="stay_price" name="stay_price" value="{{ $chalet->stay_price }}" placeholder="{{ trans('back.stay_price') }}" required>
                            </div>
                        </div>
                        
 {{-- عرض أيقونة الأتصال --}}
   <div class="col-md-3">
    <div class="form-group">
         <label for="show_contact_icon">{{ trans('back.contact_icon') }}</label>
        <input type="checkbox" name="show_contact_icon" value="1" {{ old('show_contact_icon', $chalet->show_contact_icon) == 1 ? 'checked' : '' }}>
       
    </label>
</div>
</div>
            
            
            
<div class="form-group">
    <label>مبلغ التأمين (ر.ع)</label>
    <input 
        type="number" 
        step="0.01" 
        name="insurance_amount" 
        class="form-control"
        value="{{ old('insurance_amount', $chalet->insurance_amount ?? '') }}"
        placeholder="مثال: 300"
    >
</div>
<br>
  <div class="col-md-3">
    <label>رقم الاتصال</label>
    <input type="text" name="phone" class="form-control"
           value="{{ old('phone',$chalet->phone) }}" placeholder="+96891234567 أو 91234567">
</div>

<div class="col-md-3">
    <label>رقم واتساب</label>
    <input type="text" name="whatsapp_number" class="form-control"
           value="{{ old('whatsapp_number', $chalet->whatsapp_number) }}" placeholder="+96891234567 أو 91234567">
</div>


                      <div class="col-md-6">
                            <div class="form-group">
                                <label for="location">{{ trans('back.location') }}</label>
                                <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $chalet->location) }}" placeholder="{{ trans('back.enter_location') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="map_link">{{ trans('back.map_link') }}</label>
                                <input type="text" class="form-control" id="map_link" name="map_link" value="{{ old('map_link', $chalet->map_link) }}" placeholder="{{ trans('back.enter_map_link') }}">
                            </div>
                        </div>

                        <div class="mb-2 col-md-4">
                            <label class="form-label">{{trans('back.is_feature')}}</label>
                            <select name="is_feature" class="form-control">
                                <option value="1" {{ old('is_feature',$chalet->is_feature) == 1 ? 'selected' : null }}>{{trans('back.yes')}}</option>
                                <option value="0" {{ old('is_feature',$chalet->is_feature) == 0 ? 'selected' : null }}>{{trans('back.no')}}</option>
                            </select>
                             </div>
                             
       


                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="video">{{ trans('back.video') }}</label>
                                <input type="text" class="form-control" id="video" name="video" value="{{ old('video', $chalet->video) }}" placeholder="{{ trans('back.video') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="short_description_ar">{{ trans('back.short_description_ar') }}</label>
                                <input type="text" class="form-control" id="short_description_ar" name="short_description_ar" value="{{ old('short_description_ar', $chalet->short_description_ar) }}" placeholder="{{ trans('back.short_description_ar') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="short_description_en">{{ trans('back.short_description_en') }}</label>
                                <input type="text" class="form-control" id="short_description_en" name="short_description_en" value="{{ old('short_description_en', $chalet->short_description_en) }}" placeholder="{{ trans('back.short_description_en') }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="long_description_ar">{{ trans('back.long_description_ar') }}</label>
                                <textarea class="form-control editor" id="long_description_ar" name="long_description_ar" placeholder="{{ trans('back.long_description_ar') }}">{{ old('long_description_ar', $chalet->long_description_ar) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="long_description_en">{{ trans('back.long_description_en') }}</label>
                                <textarea class="form-control editor" id="long_description_en" name="long_description_en" placeholder="{{ trans('back.long_description_en') }}">{{ old('long_description_en', $chalet->long_description_en) }}</textarea>
                            </div>
                        </div>

                      {{-- Tags and Amenities --}}
<div class="col-md-12 mb-3">
    <h5 class="text-primary">{{ trans('back.amenities') ?? 'المرافق والخدمات' }}</h5>
</div>

<div class="col-md-12">
    <div class="row amenities-group">

        <div class="col-md-3 col-6 mb-2">
            <label class="amenity-item">
                <input type="checkbox" name="has_pool" value="1" {{ old('has_pool', $chalet->has_pool) ? 'checked' : '' }}>
                <span>{{ trans('amenities.pool') ?? 'مسبح' }}</span>
            </label>
        </div>

        <div class="col-md-3 col-6 mb-2">
            <label class="amenity-item">
                <input type="checkbox" name="has_beachfront" value="1" {{ old('has_beachfront', $chalet->has_beachfront) ? 'checked' : '' }}>
                <span>{{ trans('amenities.beachfront') ?? 'يرى البحر ' }}</span>
            </label>
        </div>

        <div class="col-md-3 col-6 mb-2">
            <label class="amenity-item">
                <input type="checkbox" name="has_beach" value="1" {{ old('has_beach', $chalet->has_beach) ? 'checked' : '' }}>
                <span>{{ trans('amenities.beach') ?? 'شاطئ خاص' }}</span>
            </label>
        </div>

        <div class="col-md-3 col-6 mb-2">
            <label class="amenity-item">
                <input type="checkbox" name="has_garden" value="1" {{ old('has_garden', $chalet->has_garden) ? 'checked' : '' }}>
                <span>{{ trans('amenities.garden') ?? 'حديقة' }}</span>
            </label>
        </div>

        <div class="col-md-3 col-6 mb-2">
            <label class="amenity-item">
                <input type="checkbox" name="has_mountain_view" value="1" {{ old('has_mountain_view', $chalet->has_mountain_view) ? 'checked' : '' }}>
                <span>{{ trans('amenities.mountain_view') ?? 'إطلالة جبلية' }}</span>
            </label>
        </div>

    </div>
</div>

                        
        
                        <div class="col-md-12 mt-4"></div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seo_keywords_ar">{{ trans('back.seo_keywords_ar') }}</label>
                                <textarea class="form-control" id="seo_keywords_ar" name="seo_keywords_ar" rows="3" placeholder="{{ trans('back.seo_keywords_ar') }}">{{ old('seo_keywords_ar', $chalet->seo_keywords_ar) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seo_keywords_en">{{ trans('back.seo_keywords_en') }}</label>
                                <textarea class="form-control" id="seo_keywords_en" name="seo_keywords_en" rows="3" placeholder="{{ trans('back.seo_keywords_en') }}">{{ old('seo_keywords_en', $chalet->seo_keywords_en) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seo_meta_description_ar">{{ trans('back.seo_meta_description_ar') }}</label>
                                <textarea class="form-control" id="seo_meta_description_ar" name="seo_meta_description_ar" rows="3" placeholder="{{ trans('back.seo_meta_description_ar') }}">{{ old('seo_meta_description_ar', $chalet->seo_meta_description_ar) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seo_meta_description_en">{{ trans('back.seo_meta_description_en') }}</label>
                                <textarea class="form-control" id="seo_meta_description_en" name="seo_meta_description_en" rows="3" placeholder="{{ trans('back.seo_meta_description_en') }}">{{ old('seo_meta_description_en', $chalet->seo_meta_description_en) }}</textarea>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success w-50">{{ trans('back.update_chalet') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('select[name="city_id"]').on('change', function() {
            var country_id = $(this).val();
            //console.log(college_id);
            if (country_id) {
                $.ajax({
                    url: "{{ URL::to('getareas') }}/" + country_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="area_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="area_id"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>
    <script>
        $(document).ready(function() {
            $('#chalet_name_en').on('input', function() {
                var chaletNameEn = $(this).val();
                var slug = chaletNameEn.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                $('#slug').val(slug);
            });
        });
    </script>
@endsection
