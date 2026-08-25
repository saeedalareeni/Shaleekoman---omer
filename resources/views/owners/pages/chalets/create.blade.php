@extends('owners.layouts.master')

@section('page_title', trans('back.add_chalet'))

@section('title', trans('back.add_chalet'))

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/shaleek-design.css') }}?v={{ @filemtime(public_path('frontend/css/shaleek-design.css')) ?: time() }}">
    <style>
        /* Scope the Shaleek form components to this page without pulling in the
           full .shaleek reset (this page still lives inside the admin/owner
           dashboard shell — sidebar, topbar, etc. stay as they are). */
        .shaleek-add-wrap { font-family: 'Tajawal', 'Cairo', system-ui, sans-serif; max-width: 960px; margin: 0 auto; }
        .shaleek-add-wrap .form-group { margin-bottom: 0; }
        .shaleek-add-wrap label { display: block; font-size: 12.5px; font-weight: 700; color: var(--ink-700); margin-bottom: 7px; }
    </style>
@endsection

@section('content')
    <div class="shaleek-add-wrap">
        <div class="shaleek-add-header">
            <h1 class="shaleek-add-title">{{ trans('back.add_chalet') }}</h1>
            <p class="shaleek-add-subtitle">{{ app()->getLocale() == 'ar' ? 'اعرض عقارك أمام آلاف الزوار شهرياً' : 'Showcase your property to thousands of visitors every month' }}</p>
        </div>

        <form action="{{ route('owner.chalets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Basic info -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">{{ app()->getLocale() == 'ar' ? 'بيانات العقار' : 'Property info' }}</div>
                <div class="shaleek-form-grid">
                    <div class="shaleek-form-field span-2">
                        <label for="frome">{{ trans('back.select_category') }} <span class="shaleek-req">*</span></label>
                        <select id="frome" class="shaleek-form-select select2" name="category_id" required>
                            <option selected disabled>{{ trans('back.select') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ App::getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="shaleek-form-field">
                        <label for="chalet_name_ar">{{ trans('back.chalet_name_ar') }} <span class="shaleek-req">*</span></label>
                        <input type="text" class="shaleek-form-input" id="chalet_name_ar" name="chalet_name_ar" value="{{ old('chalet_name_ar') }}" placeholder="{{ trans('back.chalet_name_ar') }}" required>
                    </div>

                    <div class="shaleek-form-field">
                        <label for="chalet_name_en">{{ trans('back.chalet_name_en') }} <span class="shaleek-req">*</span></label>
                        <input type="text" class="shaleek-form-input" id="chalet_name_en" name="chalet_name_en" value="{{ old('chalet_name_en') }}" placeholder="{{ trans('back.chalet_name_en') }}" required>
                    </div>

                    <div class="shaleek-form-field">
                        <label for="slug">{{ trans('back.slug') }} <span class="shaleek-req">*</span></label>
                        <input type="text" class="shaleek-form-input" id="slug" name="slug" value="{{ old('slug') }}" placeholder="{{ trans('back.enter_slug') }}" required dir="ltr" style="text-align:left;">
                    </div>

                    <div class="shaleek-form-field">
                        <label for="main_image">{{ trans('back.main_image') }}</label>
                        <input type="file" class="shaleek-form-input" id="main_image" name="main_image">
                    </div>

                    <div class="shaleek-form-field">
                        <label for="video">{{ trans('back.video') }}</label>
                        <input type="text" class="shaleek-form-input" id="video" name="video" value="{{ old('video') }}" placeholder="{{ trans('back.video') }}" dir="ltr" style="text-align:left;">
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">{{ app()->getLocale() == 'ar' ? 'الموقع' : 'Location' }}</div>
                <div class="shaleek-form-grid">
                    <div class="shaleek-form-field">
                        <label for="frome2">{{ trans('back.select_city') }} <span class="shaleek-req">*</span></label>
                        <select id="frome2" class="shaleek-form-select select2" name="city_id" required>
                            <option selected disabled>{{ trans('back.select') }}</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ app()->getLocale() == 'ar' ? $city->name_ar : $city->name_en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="shaleek-form-field">
                        <label for="area_id">{{ trans('back.areas') }} <span class="shaleek-req">*</span></label>
                        <select class="shaleek-form-select select2" id="area_id" name="area_id" required></select>
                    </div>

                    <div class="shaleek-form-field">
                        <label for="location">{{ trans('back.location') }}</label>
                        <input type="text" class="shaleek-form-input" id="location" name="location" value="{{ old('location') }}" placeholder="{{ trans('back.enter_location') }}">
                    </div>

                    <div class="shaleek-form-field">
                        <label for="map_link">{{ trans('back.map_link') }}</label>
                        <input type="text" class="shaleek-form-input" id="map_link" name="map_link" value="{{ old('map_link') }}" placeholder="{{ trans('back.enter_map_link') }}" dir="ltr" style="text-align:left;">
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">{{ app()->getLocale() == 'ar' ? 'الأسعار' : 'Pricing' }}</div>
                <div class="shaleek-form-grid">
                    <div class="shaleek-form-field">
                        <label for="default_day_price">{{ trans('back.default_day_price') }} <span class="shaleek-req">*</span></label>
                        <input type="number" step="0.01" class="shaleek-form-input" id="default_day_price" name="default_day_price" value="{{ old('default_day_price') }}" placeholder="{{ trans('back.enter_default_day_price') }}" required>
                    </div>
                    <div class="shaleek-form-field">
                        <label for="holiday_day_price">{{ trans('back.holiday_day_price') }} <span class="shaleek-req">*</span></label>
                        <input type="number" step="0.01" class="shaleek-form-input" id="holiday_day_price" name="holiday_day_price" value="{{ old('holiday_day_price') }}" placeholder="{{ trans('back.enter_holiday_day_price') }}" required>
                    </div>
                    <div class="shaleek-form-field">
                        <label for="half_day_price">{{ trans('back.half_day_price') }} <span class="shaleek-req">*</span></label>
                        <input type="number" step="0.01" class="shaleek-form-input" id="half_day_price" name="half_day_price" value="{{ old('half_day_price') }}" placeholder="{{ trans('back.half_day_price') }}" required>
                    </div>
                    <div class="shaleek-form-field">
                        <label for="stay_price">{{ trans('back.stay_price') }} <span class="shaleek-req">*</span></label>
                        <input type="number" step="0.01" class="shaleek-form-input" id="stay_price" name="stay_price" value="{{ old('stay_price') }}" placeholder="{{ trans('back.stay_price') }}" required>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">{{ app()->getLocale() == 'ar' ? 'الوصف' : 'Description' }}</div>
                <div class="shaleek-form-grid">
                    <div class="shaleek-form-field">
                        <label for="short_description_ar">{{ trans('back.short_description_ar') }}</label>
                        <input type="text" class="shaleek-form-input" id="short_description_ar" name="short_description_ar" value="{{ old('short_description_ar') }}" placeholder="{{ trans('back.short_description_ar') }}">
                    </div>
                    <div class="shaleek-form-field">
                        <label for="short_description_en">{{ trans('back.short_description_en') }}</label>
                        <input type="text" class="shaleek-form-input" id="short_description_en" name="short_description_en" value="{{ old('short_description_en') }}" placeholder="{{ trans('back.short_description_en') }}">
                    </div>
                    <div class="shaleek-form-field span-2">
                        <label for="long_description_ar">{{ trans('back.long_description_ar') }}</label>
                        <textarea class="shaleek-form-textarea editor" id="long_description_ar" name="long_description_ar" placeholder="{{ trans('back.long_description_ar') }}">{{ old('long_description_ar') }}</textarea>
                    </div>
                    <div class="shaleek-form-field span-2">
                        <label for="long_description_en">{{ trans('back.long_description_en') }}</label>
                        <textarea class="shaleek-form-textarea editor" id="long_description_en" name="long_description_en" placeholder="{{ trans('back.long_description_en') }}">{{ old('long_description_en') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">SEO</div>
                <div class="shaleek-form-grid">
                    <div class="shaleek-form-field">
                        <label for="seo_keywords_ar">{{ trans('back.seo_keywords_ar') }}</label>
                        <textarea class="shaleek-form-textarea" id="seo_keywords_ar" name="seo_keywords_ar" rows="3" placeholder="{{ trans('back.seo_keywords_ar') }}">{{ old('seo_keywords_ar') }}</textarea>
                    </div>
                    <div class="shaleek-form-field">
                        <label for="seo_keywords_en">{{ trans('back.seo_keywords_en') }}</label>
                        <textarea class="shaleek-form-textarea" id="seo_keywords_en" name="seo_keywords_en" rows="3" placeholder="{{ trans('back.seo_keywords_en') }}">{{ old('seo_keywords_en') }}</textarea>
                    </div>
                    <div class="shaleek-form-field">
                        <label for="seo_meta_description_ar">{{ trans('back.seo_meta_description_ar') }}</label>
                        <textarea class="shaleek-form-textarea" id="seo_meta_description_ar" name="seo_meta_description_ar" rows="3" placeholder="{{ trans('back.seo_meta_description_ar') }}">{{ old('seo_meta_description_ar') }}</textarea>
                    </div>
                    <div class="shaleek-form-field">
                        <label for="seo_meta_description_en">{{ trans('back.seo_meta_description_en') }}</label>
                        <textarea class="shaleek-form-textarea" id="seo_meta_description_en" name="seo_meta_description_en" rows="3" placeholder="{{ trans('back.seo_meta_description_en') }}">{{ old('seo_meta_description_en') }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="shaleek-submit-btn">
                <svg viewBox="0 0 24 24"><path d="M22 2L11 13"></path><path d="M22 2l-7 20-4-9-9-4 20-7z"></path></svg>
                {{ trans('back.add_chalet') }}
            </button>
        </form>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('select[name="city_id"]').on('change', function() {
            var country_id = $(this).val();
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
