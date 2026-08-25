<!-- General Settings Tab -->
<div class="tab-pane fade show active" id="general" role="tabpanel">
    <form id="generalForm" action="{{ route('admin.settings.update.general') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Site Identity -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-globe"></i> هوية الموقع
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">اسم الموقع (عربي) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="site_name_ar" value="{{ $setting->site_name_ar ?? 'شاليك' }}" required>
                        <small class="text-muted">سيظهر في شعار الموقع وعنوان الصفحات</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">اسم الموقع (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="site_name_en" value="{{ $setting->site_name_en ?? 'shaleek' }}" required>
                        <small class="text-muted">Will appear in site logo and page titles</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">عنوان الموقع (عربي)</label>
                        <input type="text" class="form-control" name="site_title_ar" value="{{ $setting->site_title_ar ?? 'احجز شاليهك المثالي في عمان' }}">
                        <small class="text-muted">يظهر في عنوان المتصفح</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">عنوان الموقع (English)</label>
                        <input type="text" class="form-control" name="site_title_en" value="{{ $setting->site_title_en ?? 'Book Your Perfect Chalet in Oman' }}">
                        <small class="text-muted">Appears in browser title</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">وصف الموقع (عربي)</label>
                        <textarea class="form-control" name="site_description_ar" rows="3">{{ $setting->site_description_ar ?? 'منصة حجز الشاليهات الأولى في عمان' }}</textarea>
                        <small class="text-muted">للاستخدام في محركات البحث والمشاركات</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">وصف الموقع (English)</label>
                        <textarea class="form-control" name="site_description_en" rows="3">{{ $setting->site_description_en ?? 'The Premier Chalet Booking Platform in Oman' }}</textarea>
                        <small class="text-muted">For search engines and social shares</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company Information
        <div class="card">
            <div class="card-header">
                <i class="fas fa-building"></i> معلومات الشركة
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">اسم الشركة (عربي)</label>
                        <input type="text" class="form-control" name="company_name_ar" value="{{ $setting->company_name_ar ?? '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">اسم الشركة (English)</label>
                        <input type="text" class="form-control" name="company_name_en" value="{{ $setting->company_name_en ?? '' }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">السجل التجاري</label>
                        <input type="text" class="form-control" name="cr_no" value="{{ $setting->cr_no ?? '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">الرقم الضريبي</label>
                        <input type="text" class="form-control" name="tax_no" value="{{ $setting->tax_no ?? '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" class="form-control" name="phone" value="{{ $setting->phone ?? '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" name="email" value="{{ $setting->email ?? '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الموقع الإلكتروني</label>
                        <input type="url" class="form-control" name="website" value="{{ $setting->website ?? url('/') }}">
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Logos and Images -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-image"></i> الشعارات والصور
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">الشعار الرئيسي</label>
                        <input type="file" class="form-control" name="logo" accept="image/*" onchange="previewImage(this, 'logo-preview')">
                        <div class="image-preview-container">
                            @if(isset($setting->logo) && $setting->logo)
                                <img id="logo-preview" src="{{ asset(ltrim($setting->logo, '/')) }}" class="preview-image" style="width: 150px !important; height: 80px !important; object-fit: contain !important;" alt="Logo">
                            @else
                                <img id="logo-preview" class="preview-image" style="display:none; width: 150px !important; height: 80px !important; object-fit: contain !important;" alt="Logo">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">الشعار الأبيض (Footer)</label>
                        <input type="file" class="form-control" name="logo_white" accept="image/*" onchange="previewImage(this, 'logo-white-preview')">
                        <div class="image-preview-container" style="background: #2c3e50; border-radius: 10px;">
                            @if(isset($setting->logo_white) && $setting->logo_white)
                                <img id="logo-white-preview" src="{{ asset(ltrim($setting->logo_white, '/')) }}" class="preview-image" style="width: 150px !important; height: 80px !important; object-fit: contain !important;" alt="White Logo">
                            @else
                                <img id="logo-white-preview" class="preview-image" style="display:none; width: 150px !important; height: 80px !important; object-fit: contain !important;" alt="White Logo">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Favicon</label>
                        <input type="file" class="form-control" name="favicon" accept="image/x-icon,image/png" onchange="previewImage(this, 'favicon-preview')">
                        <div class="image-preview-container">
                            @if(isset($setting->favicon) && $setting->favicon)
                                <img id="favicon-preview" src="{{ asset(ltrim($setting->favicon, '/')) }}" class="preview-image" style="width: 50px !important; height: 50px !important; object-fit: contain !important;" alt="Favicon">
                            @else
                                <img id="favicon-preview" class="preview-image" style="display:none; width: 50px !important; height: 50px !important; object-fit: contain !important;" alt="Favicon">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <!-- <div class="card">
            <div class="card-header">
                <i class="fas fa-map-marker-alt"></i> معلومات العنوان
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">العنوان (عربي)</label>
                        <input type="text" class="form-control" name="address_ar" value="{{ $setting->address_ar ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">العنوان (English)</label>
                        <input type="text" class="form-control" name="address_en" value="{{ $setting->address_en ?? '' }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">المدينة</label>
                        <input type="text" class="form-control" name="city" value="{{ $setting->city ?? '' }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">المحافظة</label>
                        <input type="text" class="form-control" name="governorate_ar" value="{{ $setting->governorate_ar ?? '' }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">الدولة</label>
                        <input type="text" class="form-control" name="country" value="{{ $setting->country ?? 'عمان' }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">الرمز البريدي</label>
                        <input type="text" class="form-control" name="postal_code" value="{{ $setting->postal_code ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">خط العرض (Latitude)</label>
                        <input type="text" class="form-control" name="latitude" value="{{ $setting->latitude ?? '' }}" placeholder="23.5880">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">خط الطول (Longitude)</label>
                        <input type="text" class="form-control" name="longitude" value="{{ $setting->longitude ?? '' }}" placeholder="58.3829">
                    </div>
                </div>
            </div>
        </div> -->

        <!-- App Settings -->
        <!-- <div class="card">
            <div class="card-header">
                <i class="fas fa-mobile-alt"></i> إعدادات التطبيق
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">رابط تطبيق Android</label>
                        <input type="url" class="form-control" name="android_app_url" value="{{ $setting->android_app_url ?? '' }}" placeholder="https://play.google.com/store/apps/...">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">رابط تطبيق iOS</label>
                        <input type="url" class="form-control" name="ios_app_url" value="{{ $setting->ios_app_url ?? '' }}" placeholder="https://apps.apple.com/app/...">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">إصدار التطبيق</label>
                        <input type="text" class="form-control" name="app_version" value="{{ $setting->app_version ?? '1.0.0' }}">
                    </div>
                </div>
            </div>
        </div> -->

        <div class="text-center">
            <button type="button" class="btn btn-danger" onclick="saveSettings('generalForm')">
                <i class="fas fa-save"></i> حفظ الإعدادات العامة
            </button>
        </div>
    </form>
</div>
