@extends('owners.layouts.master')

@section('page_title', trans('back.add_chalet'))

@section('title', trans('back.add_chalet'))

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/shaleek-design.css') }}?v={{ @filemtime(public_path('frontend/css/shaleek-design.css')) ?: time() }}">
    <style>
        /* Scope the Shaleek form components to this page without pulling in the
           full .shaleek reset (this page still lives inside the admin/owner
           dashboard shell — sidebar, topbar, etc. stay as they are). */
        .shaleek-add-wrap { font-family: 'Tajawal', 'Cairo', system-ui, sans-serif; max-width: 760px; margin: 0 auto; }
        .shaleek-add-wrap .form-group { margin-bottom: 0; }
    </style>
@endsection

@section('content')
    <div class="shaleek-add-wrap">
        <div class="shaleek-add-header">
            <h1 class="shaleek-add-title">{{ app()->getLocale() == 'ar' ? 'أضف عقارك إلى شاليك' : 'Add your property to Shaleek' }}</h1>
            <p class="shaleek-add-subtitle">{{ app()->getLocale() == 'ar' ? 'اعرض عقارك أمام آلاف الزوار شهرياً — مجاناً وبدون عمولات' : 'Showcase your property to thousands of visitors every month — free, no commissions' }}</p>
        </div>

        <div class="shaleek-notice-banner">
            <svg class="shaleek-notice-banner-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <div>
                <strong>{{ app()->getLocale() == 'ar' ? 'منصة عرض — لا نوفر خدمة حجوزات' : 'A listing platform — we don\'t handle bookings' }}</strong>
                {{ app()->getLocale() == 'ar' ? 'نعرض عقارك بمعلوماته وصوره، ويتواصل العملاء معك مباشرةً عبر الاتصال أو الواتساب. الاتفاق والحجز والدفع يتم بينك وبين العميل مباشرة.' : 'We display your property\'s info and photos, and customers contact you directly by call or WhatsApp. The agreement, booking and payment happen directly between you and the customer.' }}
            </div>
        </div>

        <form action="{{ route('owner.chalets.store') }}" method="POST" enctype="multipart/form-data" id="shAddForm">
            @csrf

            <!-- Property info -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">{{ app()->getLocale() == 'ar' ? 'بيانات العقار' : 'Property info' }}</div>
                <div class="shaleek-form-grid">
                    <div class="shaleek-form-field span-2">
                        <label for="chalet_name_ar">{{ app()->getLocale() == 'ar' ? 'اسم العقار أو المشروع' : 'Property or project name' }} <span class="shaleek-req">*</span></label>
                        <input type="text" class="shaleek-form-input" id="chalet_name_ar" name="chalet_name_ar" value="{{ old('chalet_name_ar') }}" placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: إستراحة زهرة الأوركيد' : 'e.g. Orchid Flower Rest House' }}" required>
                    </div>

                    <div class="shaleek-form-field">
                        <label for="category_id">{{ app()->getLocale() == 'ar' ? 'القسم المناسب' : 'Suitable category' }} <span class="shaleek-req">*</span></label>
                        <select id="category_id" class="shaleek-form-select select2" name="category_id" required>
                            <option value="" selected disabled>{{ trans('back.select') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ App::getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="shaleek-form-field">
                        <label for="max_guests">{{ app()->getLocale() == 'ar' ? 'السعة التقريبية (اختياري)' : 'Approximate capacity (optional)' }}</label>
                        <input type="number" class="shaleek-form-input" id="max_guests" name="max_guests" value="{{ old('max_guests') }}" placeholder="{{ app()->getLocale() == 'ar' ? 'عدد الأشخاص' : 'Number of people' }}" min="1">
                    </div>

                    <div class="shaleek-form-field span-2">
                        <label for="long_description_ar">{{ app()->getLocale() == 'ar' ? 'وصف العقار' : 'Property description' }} <span class="shaleek-req">*</span></label>
                        <textarea class="shaleek-form-textarea" id="long_description_ar" name="long_description_ar" placeholder="{{ app()->getLocale() == 'ar' ? 'اكتب وصفاً جذاباً: المميزات، الغرف، المرافق، ما يميز عقارك عن غيره...' : 'Write an appealing description: features, rooms, facilities, what sets your property apart...' }}" required>{{ old('long_description_ar') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">{{ app()->getLocale() == 'ar' ? 'موقع المشروع' : 'Project location' }}</div>
                <div class="shaleek-form-grid">
                    <div class="shaleek-form-field">
                        <label for="city_id">{{ app()->getLocale() == 'ar' ? 'المحافظة' : 'Governorate' }} <span class="shaleek-req">*</span></label>
                        <select id="city_id" class="shaleek-form-select select2" name="city_id" required>
                            <option value="" selected disabled>{{ trans('back.select') }}</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ app()->getLocale() == 'ar' ? $city->name_ar : $city->name_en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="shaleek-form-field">
                        <label for="area_id">{{ app()->getLocale() == 'ar' ? 'الولاية / المنطقة' : 'State / Area' }} <span class="shaleek-req">*</span></label>
                        <select class="shaleek-form-select select2" id="area_id" name="area_id" required></select>
                    </div>

                    <div class="shaleek-form-field span-2">
                        <label for="map_link">{{ app()->getLocale() == 'ar' ? 'رابط الموقع من خرائط جوجل (اختياري)' : 'Google Maps location link (optional)' }}</label>
                        <input type="url" class="shaleek-form-input" id="map_link" name="map_link" value="{{ old('map_link') }}" placeholder="https://maps.app.goo.gl/..." dir="ltr" style="text-align:left;">
                        <div class="shaleek-form-hint">{{ app()->getLocale() == 'ar' ? 'افتح خرائط جوجل ← حدد موقعك ← مشاركة ← انسخ الرابط' : 'Open Google Maps → pin your location → Share → copy the link' }}</div>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">{{ app()->getLocale() == 'ar' ? 'السعر' : 'Price' }}</div>
                <div class="shaleek-price-mode">
                    <button type="button" class="shaleek-price-mode-pill active" id="pmFrom" onclick="shSetPriceMode('from')">{{ app()->getLocale() == 'ar' ? 'السعر يبدأ من' : 'Price starts from' }}</button>
                    <button type="button" class="shaleek-price-mode-pill" id="pmAsk" onclick="shSetPriceMode('ask')">{{ app()->getLocale() == 'ar' ? 'تواصل لمعرفة الأسعار' : 'Contact for pricing' }}</button>
                </div>
                <div class="shaleek-price-inputs" id="shPriceInputs">
                    <div class="shaleek-form-field">
                        <label for="default_day_price">{{ app()->getLocale() == 'ar' ? 'السعر (ر.ع)' : 'Price (OMR)' }} <span class="shaleek-req">*</span></label>
                        <input type="number" step="0.01" class="shaleek-form-input" id="default_day_price" name="default_day_price" value="{{ old('default_day_price') }}" placeholder="60" min="1" required>
                    </div>
                    <div class="shaleek-form-field">
                        <label>{{ app()->getLocale() == 'ar' ? 'الوحدة' : 'Unit' }}</label>
                        <input type="text" class="shaleek-form-input" value="{{ app()->getLocale() == 'ar' ? 'ر.ع / ليلة' : 'OMR / night' }}" disabled>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">{{ app()->getLocale() == 'ar' ? 'أرقام التواصل' : 'Contact numbers' }}</div>
                <div class="shaleek-form-grid">
                    <div class="shaleek-form-field">
                        <label for="phone">{{ app()->getLocale() == 'ar' ? 'رقم التواصل بالاتصال' : 'Call number' }} <span class="shaleek-req">*</span></label>
                        <div class="shaleek-phone-wrap">
                            <span class="shaleek-phone-prefix">+968</span>
                            <input type="tel" class="shaleek-form-input" id="phone" name="phone" placeholder="9XXXXXXX" pattern="[0-9]{8}" maxlength="8" required>
                        </div>
                    </div>
                    <div class="shaleek-form-field">
                        <label for="whatsapp_number">{{ app()->getLocale() == 'ar' ? 'رقم الواتساب' : 'WhatsApp number' }} <span class="shaleek-req">*</span></label>
                        <div class="shaleek-phone-wrap">
                            <span class="shaleek-phone-prefix">+968</span>
                            <input type="tel" class="shaleek-form-input" id="whatsapp_number" name="whatsapp_number" placeholder="9XXXXXXX" pattern="[0-9]{8}" maxlength="8" required>
                        </div>
                        <div class="shaleek-form-hint">{{ app()->getLocale() == 'ar' ? 'سيصلك عليه تواصل العملاء مباشرة' : 'Customers will contact you on it directly' }}</div>
                    </div>
                </div>
            </div>

            <!-- Photos -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">{{ app()->getLocale() == 'ar' ? 'صور المشروع' : 'Project photos' }}</div>
                <input type="file" id="shPhotosPicker" accept="image/*" multiple hidden>
                <input type="file" id="main_image" name="main_image" hidden>
                <input type="file" id="shExtraImages" name="images[]" multiple hidden>
                <div class="shaleek-dropzone" id="shDropzone" onclick="document.getElementById('shPhotosPicker').click()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg>
                    <div class="shaleek-dropzone-title">{{ app()->getLocale() == 'ar' ? 'اضغط لإضافة الصور أو اسحبها هنا' : 'Click to add photos or drag them here' }}</div>
                    <div class="shaleek-dropzone-hint">{{ app()->getLocale() == 'ar' ? 'حتى ١٠ صور — يُفضّل صور أفقية واضحة (الصورة الأولى هي الرئيسية)' : 'Up to 10 photos — clear landscape photos preferred (the first photo becomes the main one)' }}</div>
                </div>
                <div class="shaleek-photo-grid" id="shPhotoGrid"></div>
                <div class="shaleek-photo-count" id="shPhotoCount"></div>
            </div>

            <!-- Amenities -->
            <div class="shaleek-form-card">
                <div class="shaleek-form-section-title">{{ app()->getLocale() == 'ar' ? 'المرافق والخدمات (اختياري)' : 'Amenities & services (optional)' }}</div>
                <div class="shaleek-form-chips" id="shAmenityChips">
                    @php
                        $shAmenityOptions = [
                            'pool' => ['ar' => 'مسبح', 'en' => 'Pool'],
                            'garden' => ['ar' => 'حديقة', 'en' => 'Garden'],
                            'wifi' => ['ar' => 'واي فاي', 'en' => 'WiFi'],
                            'parking' => ['ar' => 'مواقف سيارات', 'en' => 'Parking'],
                            'ac' => ['ar' => 'مكيفات', 'en' => 'AC'],
                            'sea_view' => ['ar' => 'إطلالة بحرية', 'en' => 'Sea view'],
                            'mountain_view' => ['ar' => 'إطلالة جبلية', 'en' => 'Mountain view'],
                            'private_beach' => ['ar' => 'شاطئ خاص', 'en' => 'Private beach'],
                            'kitchen' => ['ar' => 'مطبخ مجهّز', 'en' => 'Equipped kitchen'],
                            'playground' => ['ar' => 'ألعاب أطفال', 'en' => 'Kids play area'],
                        ];
                    @endphp
                    @foreach($shAmenityOptions as $shKey => $shLabel)
                        <button type="button" class="shaleek-filter-option" data-value="{{ $shKey }}" onclick="this.classList.toggle('active')">{{ app()->getLocale() == 'ar' ? $shLabel['ar'] : $shLabel['en'] }}</button>
                    @endforeach
                </div>
            </div>

            <!-- Agreement + submit -->
            <div class="shaleek-form-card">
                <label class="shaleek-agree-row">
                    <input type="checkbox" id="fAgree" required>
                    <span>
                        {{ app()->getLocale() == 'ar' ? 'أقرّ بصحة البيانات المُدخلة، وأوافق على' : 'I confirm the entered data is accurate, and I agree to the' }}
                        <a href="{{ route('terms') }}" target="_blank" style="color: var(--green-700); font-weight:700; text-decoration: underline;">{{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms and Conditions' }}</a>{{ app()->getLocale() == 'ar' ? '، وأفهم أن شاليك منصة عرض فقط ولا تتدخل في الحجوزات أو المدفوعات.' : ', and I understand Shaleek is a listing platform only and does not handle bookings or payments.' }}
                    </span>
                </label>
                <button type="submit" class="shaleek-submit-btn">
                    <svg viewBox="0 0 24 24"><path d="M22 2L11 13"></path><path d="M22 2l-7 20-4-9-9-4 20-7z"></path></svg>
                    {{ app()->getLocale() == 'ar' ? 'إرسال طلب العرض' : 'Submit listing request' }}
                </button>
            </div>
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
            }
        });
    });

    // Price mode: "starts from" vs "contact for pricing"
    function shSetPriceMode(mode) {
        document.getElementById('pmFrom').classList.toggle('active', mode === 'from');
        document.getElementById('pmAsk').classList.toggle('active', mode === 'ask');
        document.getElementById('shPriceInputs').classList.toggle('disabled', mode === 'ask');
        var priceInput = document.getElementById('default_day_price');
        if (mode === 'ask') {
            priceInput.removeAttribute('required');
            priceInput.value = '';
        } else {
            priceInput.setAttribute('required', 'required');
        }
    }

    // Unified photo dropzone: first photo picked becomes the main image,
    // the rest go into the gallery — split across the two real file inputs
    // the backend expects on submit.
    var shPhotoFiles = [];

    function shRenderPhotos() {
        var grid = document.getElementById('shPhotoGrid');
        grid.innerHTML = '';
        shPhotoFiles.forEach(function (file, i) {
            var url = URL.createObjectURL(file);
            var div = document.createElement('div');
            div.className = 'shaleek-photo-tile';
            div.innerHTML = '<img src="' + url + '">' +
                '<button type="button" class="shaleek-photo-remove" onclick="shRemovePhoto(' + i + ')">✕</button>';
            grid.appendChild(div);
        });
        document.getElementById('shPhotoCount').textContent = shPhotoFiles.length
            ? shPhotoFiles.length + ' {{ app()->getLocale() == "ar" ? "صورة مختارة (الأولى هي الرئيسية)" : "photos selected (the first is the main one)" }}'
            : '';
        shSyncPhotoInputs();
    }

    function shSyncPhotoInputs() {
        var mainDt = new DataTransfer();
        var extraDt = new DataTransfer();
        shPhotoFiles.forEach(function (file, i) {
            if (i === 0) mainDt.items.add(file);
            else extraDt.items.add(file);
        });
        document.getElementById('main_image').files = mainDt.files;
        document.getElementById('shExtraImages').files = extraDt.files;
    }

    function shRemovePhoto(index) {
        shPhotoFiles.splice(index, 1);
        shRenderPhotos();
    }

    function shAddPhotos(fileList) {
        Array.from(fileList).forEach(function (file) {
            if (shPhotoFiles.length < 10 && file.type.startsWith('image/')) {
                shPhotoFiles.push(file);
            }
        });
        shRenderPhotos();
    }

    document.getElementById('shPhotosPicker').addEventListener('change', function (e) {
        shAddPhotos(e.target.files);
        this.value = '';
    });

    var shDropzone = document.getElementById('shDropzone');
    ['dragover', 'dragleave', 'drop'].forEach(function (evt) {
        shDropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            shDropzone.classList.toggle('drag', evt === 'dragover');
        });
    });
    shDropzone.addEventListener('drop', function (e) {
        shAddPhotos(e.dataTransfer.files);
    });

    // Amenity chips → hidden inputs on submit
    document.getElementById('shAddForm').addEventListener('submit', function () {
        var form = this;
        document.querySelectorAll('#shAmenityChips .shaleek-filter-option.active').forEach(function (chip) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'amenities[]';
            input.value = chip.dataset.value;
            form.appendChild(input);
        });
    });
</script>
@endsection
