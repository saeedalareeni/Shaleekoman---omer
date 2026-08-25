@extends('backend.layouts.master')

@section('page_title')
{{trans('back.about_us')}}
@endsection

@section('title')
{{trans('back.about_us')}}
@endsection

@section('css')
<style>
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        padding: 15px 25px;
        margin-right: 10px;
        border-radius: 10px 10px 0 0;
        background: #f8f9fa;
        transition: all 0.3s;
    }
    .nav-tabs .nav-link.active {
        background: #6c5ce7;
        color: white;
    }
    .nav-tabs .nav-link:hover {
        background: #e9ecef;
        color: #333;
    }
    .card-section {
        background: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    .section-title {
        color: #333;
        font-size: 1.3rem;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }
    .preview-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-top: 15px;
    }
    .preview-box img {
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
    }
    .stats-card .number {
        font-size: 2rem;
        font-weight: bold;
    }
    .stats-card .label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    .form-control, .form-control-file {
        border-radius: 8px;
        border: 1px solid #e3e6f0;
    }
    .form-control:focus {
        border-color: #6c5ce7;
        box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.25);
    }
    .btn-save {
        background: #6c5ce7;
        color: white;
        padding: 12px 40px;
        border-radius: 25px;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-save:hover {
        background: #5f3dc4;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
    }
    .image-upload-box {
        border: 2px dashed #e3e6f0;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        transition: all 0.3s;
    }
    .image-upload-box:hover {
        border-color: #6c5ce7;
        background: #f8f9fa;
    }
</style>
@endsection

@section('content')

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">
                <i class="fas fa-info-circle"></i> {{trans('back.about_us')}} - إدارة شاملة
            </h4>
            <p class="text-muted">قم بتحديث جميع معلومات صفحة "من نحن" من هنا</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="number">{{ strlen($about->about_ar ?? '') }}</div>
            <div class="label">حرف في النص العربي</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="number">{{ strlen($about->about_en ?? '') }}</div>
            <div class="label">حرف في النص الإنجليزي</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="number">{{ $about->logo ? '✓' : '✗' }}</div>
            <div class="label">الشعار</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div class="number">{{ $about->updated_at ? $about->updated_at->diffForHumans() : 'لم يتم التحديث بعد' }}</div>
            <div class="label">آخر تحديث</div>
        </div>
    </div>
</div>

<form action="{{ route('abouts.update', $about->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="aboutTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab">
                <i class="fas fa-cog"></i> معلومات عامة
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="content-tab" data-toggle="tab" href="#content" role="tab">
                <i class="fas fa-file-alt"></i> المحتوى
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab">
                <i class="fas fa-images"></i> الصور والوسائط
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab">
                <i class="fas fa-search"></i> SEO
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="features-tab" data-toggle="tab" href="#features" role="tab">
                <i class="fas fa-star"></i> المميزات
            </a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="aboutTabContent">
        
        <!-- General Information Tab -->
        <div class="tab-pane fade show active" id="general" role="tabpanel">
            <div class="card-section">
                <h5 class="section-title">معلومات الشركة</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{trans('back.company_name_ar')}}</label>
                            <input type="text" name="company_name_ar" class="form-control" 
                                   value="{{ $about->company_name_ar }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{trans('back.company_name_en')}}</label>
                            <input type="text" name="company_name_en" class="form-control" 
                                   value="{{ $about->company_name_en }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{trans('back.slogan_ar')}}</label>
                            <input type="text" name="slogan_ar" class="form-control" 
                                   value="{{ $about->slogan_ar }}" placeholder="شعار الشركة بالعربية">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{trans('back.slogan_en')}}</label>
                            <input type="text" name="slogan_en" class="form-control" 
                                   value="{{ $about->slogan_en }}" placeholder="Company slogan in English">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-section">
                <h5 class="section-title">معلومات إضافية</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>سنة التأسيس</label>
                            <input type="number" name="founded_year" class="form-control" 
                                   value="{{ $about->founded_year }}" min="1900" max="{{ date('Y') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>عدد الموظفين</label>
                            <input type="number" name="employees_count" class="form-control" 
                                   value="{{ $about->employees_count }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>عدد العملاء</label>
                            <input type="number" name="clients_count" class="form-control" 
                                   value="{{ $about->clients_count }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Tab -->
        <div class="tab-pane fade" id="content" role="tabpanel">
            <div class="card-section">
                <h5 class="section-title">نص "من نحن"</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{trans('back.about_ar')}}</label>
                            <textarea name="about_ar" class="form-control" rows="10" required>{{ $about->about_ar }}</textarea>
                            <small class="text-muted">عدد الأحرف: <span id="ar-count">{{ strlen($about->about_ar ?? '') }}</span></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{trans('back.about_en')}}</label>
                            <textarea name="about_en" class="form-control" rows="10" required>{{ $about->about_en }}</textarea>
                            <small class="text-muted">Characters: <span id="en-count">{{ strlen($about->about_en ?? '') }}</span></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-section">
                <h5 class="section-title">الرؤية والرسالة</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>الرؤية (عربي)</label>
                            <textarea name="vision_ar" class="form-control" rows="4">{{ $about->vision_ar }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Vision (English)</label>
                            <textarea name="vision_en" class="form-control" rows="4">{{ $about->vision_en }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>الرسالة (عربي)</label>
                            <textarea name="mission_ar" class="form-control" rows="4">{{ $about->mission_ar }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mission (English)</label>
                            <textarea name="mission_en" class="form-control" rows="4">{{ $about->mission_en }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Images Tab -->
        <div class="tab-pane fade" id="images" role="tabpanel">
            <div class="card-section">
                <h5 class="section-title">الشعار والصور</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="image-upload-box">
                            <label for="logo">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                                <h6>{{trans('back.upload_logo')}}</h6>
                            </label>
                            <input type="file" class="form-control-file" name="logo" id="logo" style="display: none;">
                            @if($about->logo)
                            <div class="preview-box">
                                <img src="{{ URL::asset($about->logo) }}" alt="logo">
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="image-upload-box">
                            <label for="image_about_us">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                                <h6>{{trans('back.image_about_us')}}</h6>
                            </label>
                            <input type="file" class="form-control-file" name="image_about_us" id="image_about_us" style="display: none;">
                            @if($about->image_about_us)
                            <div class="preview-box">
                                <img src="{{ URL::asset($about->image_about_us) }}" alt="about">
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="image-upload-box">
                            <label for="bg">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                                <h6>{{trans('back.bg')}}</h6>
                            </label>
                            <input type="file" class="form-control-file" name="bg" id="bg" style="display: none;">
                            @if($about->bg)
                            <div class="preview-box">
                                <img src="{{ URL::asset($about->bg) }}" alt="background">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Tab -->
        <div class="tab-pane fade" id="seo" role="tabpanel">
            <div class="card-section">
                <h5 class="section-title">تحسين محركات البحث (SEO)</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Title (عربي)</label>
                            <input type="text" name="meta_title_ar" class="form-control" 
                                   value="{{ $about->meta_title_ar }}" maxlength="60">
                            <small class="text-muted">الحد الأقصى 60 حرف</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Title (English)</label>
                            <input type="text" name="meta_title_en" class="form-control" 
                                   value="{{ $about->meta_title_en }}" maxlength="60">
                            <small class="text-muted">Maximum 60 characters</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Description (عربي)</label>
                            <textarea name="meta_description_ar" class="form-control" rows="3" maxlength="160">{{ $about->meta_description_ar }}</textarea>
                            <small class="text-muted">الحد الأقصى 160 حرف</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Description (English)</label>
                            <textarea name="meta_description_en" class="form-control" rows="3" maxlength="160">{{ $about->meta_description_en }}</textarea>
                            <small class="text-muted">Maximum 160 characters</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Keywords (فصل بفاصلة)</label>
                            <input type="text" name="keywords" class="form-control" 
                                   value="{{ $about->keywords }}" placeholder="شاليهات, عُمان, حجز, سياحة">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Tab -->
        <div class="tab-pane fade" id="features" role="tabpanel">
            <div class="card-section">
                <h5 class="section-title">المميزات والخدمات</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>الميزة الأولى (عربي)</label>
                            <input type="text" name="feature1_ar" class="form-control" 
                                   value="{{ $about->feature1_ar }}" placeholder="خدمة على مدار الساعة">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Feature 1 (English)</label>
                            <input type="text" name="feature1_en" class="form-control" 
                                   value="{{ $about->feature1_en }}" placeholder="24/7 Service">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>الميزة الثانية (عربي)</label>
                            <input type="text" name="feature2_ar" class="form-control" 
                                   value="{{ $about->feature2_ar }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Feature 2 (English)</label>
                            <input type="text" name="feature2_en" class="form-control" 
                                   value="{{ $about->feature2_en }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>الميزة الثالثة (عربي)</label>
                            <input type="text" name="feature3_ar" class="form-control" 
                                   value="{{ $about->feature3_ar }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Feature 3 (English)</label>
                            <input type="text" name="feature3_en" class="form-control" 
                                   value="{{ $about->feature3_en }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-save">
            <i class="fas fa-save"></i> حفظ جميع التغييرات
        </button>
    </div>
</form>

@endsection

@section('js')
<script>
// Character counter for textareas
document.querySelector('textarea[name="about_ar"]').addEventListener('input', function() {
    document.getElementById('ar-count').textContent = this.value.length;
});

document.querySelector('textarea[name="about_en"]').addEventListener('input', function() {
    document.getElementById('en-count').textContent = this.value.length;
});

// Image preview
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = input.closest('.image-upload-box').querySelector('.preview-box img');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    const previewBox = document.createElement('div');
                    previewBox.className = 'preview-box';
                    previewBox.innerHTML = `<img src="${e.target.result}" alt="preview">`;
                    input.closest('.image-upload-box').appendChild(previewBox);
                }
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
