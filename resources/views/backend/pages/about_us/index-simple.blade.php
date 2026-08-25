@extends('backend.layouts.master')

@section('page_title')
{{trans('back.about_us')}}
@endsection

@section('title')
{{trans('back.about_us')}}
@endsection

@section('css')
<style>
    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .page-header .page-title {
        color: white;
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
        position: relative;
        z-index: 1;
    }
    
    .page-header p {
        color: rgba(255,255,255,0.9);
        margin: 5px 0 0 0;
        font-size: 14px;
        position: relative;
        z-index: 1;
    }
    
    /* Card Sections */
    .card-section {
        background: white;
        border-radius: 20px;
        padding: 35px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        border: 1px solid #f0f2f5;
        transition: all 0.3s ease;
    }
    
    .card-section:hover {
        box-shadow: 0 15px 50px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    
    /* Section Titles */
    .section-title {
        color: #2c3e50;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 3px solid transparent;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, transparent 50%);
        background-size: 200% 3px;
        background-position: 100% 100%;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .section-title i {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        margin-right: 15px;
        font-size: 20px;
    }
    
    /* Form Controls */
    .form-group {
        margin-bottom: 25px;
        position: relative;
    }
    
    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
        display: block;
        font-size: 14px;
    }
    
    .form-group label .text-danger {
        color: #f46a6a !important;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
        outline: none;
    }
    
    .form-control.is-invalid {
        border-color: #f46a6a;
        background-color: #fff5f5;
    }
    
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(244, 106, 106, 0.1);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    input[type="file"].form-control {
        padding: 10px;
        background: white;
        cursor: pointer;
    }
    
    /* Image Preview */
    .image-preview-box {
        position: relative;
        border: 2px dashed #e9ecef;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        background: #f8f9fa;
        cursor: pointer;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    
    .image-preview-box:hover {
        border-color: #667eea;
        background: white;
        transform: translateY(-2px);
    }
    
    .image-preview-box label {
        cursor: pointer;
        display: block;
        margin: 0;
        width: 100%;
    }
    
    .image-preview-box .upload-icon {
        font-size: 40px;
        color: #a0a0a0;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    .image-preview-box:hover .upload-icon {
        color: #667eea;
        transform: scale(1.1);
    }
    
    .preview-img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 10px;
        margin-top: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: opacity 0.3s ease;
    }
    
    .file-name {
        font-size: 12px;
        color: #28a745;
        margin-top: 10px;
        font-weight: 500;
    }
    
    /* Save Button */
    .save-section {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        margin-top: 40px;
        position: relative;
        overflow: hidden;
    }
    
    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 50px;
        border-radius: 30px;
        border: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
    }
    
    .btn-save:active {
        transform: translateY(-1px);
    }
    
    .btn-save:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }
    
    .btn-save i {
        margin-right: 8px;
    }
    
    /* Info Badge */
    .info-badge {
        display: inline-block;
        background: #e7f3ff;
        color: #0066cc;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        margin-left: 10px;
    }
    
    /* Loading Animation for Submit Button */
    .btn-save.loading {
        pointer-events: none;
        position: relative;
    }
    
    .btn-save.loading::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255,255,255,0.4), 
            transparent
        );
        animation: loading-shimmer 1.5s infinite;
    }
    
    @keyframes loading-shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    .btn-save.loading::after {
        content: '';
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-left: 10px;
        border: 2px solid transparent;
        border-top-color: white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Success Checkmark Animation */
    .success-checkmark {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background: white;
        border-radius: 50%;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    
    .success-checkmark.show {
        display: block;
        animation: scaleIn 0.5s ease;
    }
    
    @keyframes scaleIn {
        from {
            transform: translate(-50%, -50%) scale(0);
        }
        to {
            transform: translate(-50%, -50%) scale(1);
        }
    }
    
    /* Character Counter */
    .char-counter {
        font-size: 12px;
        text-align: left;
        margin-top: 5px;
        padding-right: 5px;
    }
    
    /* رسائل التنبيه */
    .alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        animation: slideIn 0.5s ease;
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        min-width: 300px;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #34c38f 0%, #1ea876 100%);
        color: white;
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #f46a6a 0%, #e24a4a 100%);
        color: white;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-section {
            padding: 20px;
        }
        
        .section-title {
            font-size: 1.1rem;
        }
        
        .section-title i {
            width: 35px;
            height: 35px;
            font-size: 16px;
        }
        
        .btn-save {
            padding: 12px 30px;
            font-size: 14px;
            width: 100%;
        }
        
        .image-preview-box {
            min-height: 150px;
            margin-bottom: 15px;
        }
    }
    
    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card-section {
        animation: fadeInUp 0.5s ease;
    }
    
    .card-section:nth-child(2) {
        animation-delay: 0.1s;
    }
    
    .card-section:nth-child(3) {
        animation-delay: 0.2s;
    }
    
    .card-section:nth-child(4) {
        animation-delay: 0.3s;
    }
</style>
@endsection

@section('content')

<!-- رسائل التنبيه -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <div class="mb-2 fw-bold">يوجد أخطاء في النموذج:</div>
        <ul class="mb-0 ps-3" style="font-size: 14px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
    </div>
@endif

<!-- Page Header -->
<div class="page-header">
    <h4 class="page-title">
        <i class="fas fa-info-circle me-2"></i> {{trans('back.about_us')}}
    </h4>
    <p>تعديل معلومات صفحة "من نحن"</p>
</div>

<form action="{{ route('abouts.update', $about->id) }}" method="post" enctype="multipart/form-data" id="aboutForm">
    @csrf
    @method('PUT')
    
    <!-- Basic Info -->
    <div class="card-section">
        <h5 class="section-title">
            <i class="fas fa-building"></i>
            المعلومات الأساسية
        </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('back.company_name_ar')}} <span class="text-danger">*</span></label>
                    <input type="text" name="company_name_ar" class="form-control @error('company_name_ar') is-invalid @enderror" 
                           value="{{ old('company_name_ar', $about->company_name_ar) }}" required>
                    @error('company_name_ar')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('back.company_name_en')}} <span class="text-danger">*</span></label>
                    <input type="text" name="company_name_en" class="form-control @error('company_name_en') is-invalid @enderror" 
                           value="{{ old('company_name_en', $about->company_name_en) }}" required>
                    @error('company_name_en')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('back.slogan_ar')}}</label>
                    <input type="text" name="slogan_ar" class="form-control @error('slogan_ar') is-invalid @enderror" 
                           value="{{ old('slogan_ar', $about->slogan_ar) }}" placeholder="شعار الشركة بالعربية">
                    @error('slogan_ar')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('back.slogan_en')}}</label>
                    <input type="text" name="slogan_en" class="form-control @error('slogan_en') is-invalid @enderror" 
                           value="{{ old('slogan_en', $about->slogan_en) }}" placeholder="Company slogan in English">
                    @error('slogan_en')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- About Content -->
    <div class="card-section">
        <h5 class="section-title">
            <i class="fas fa-file-alt"></i>
            نص "من نحن"
        </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('back.about_ar')}} <span class="text-danger">*</span></label>
                    <textarea name="about_ar" class="form-control @error('about_ar') is-invalid @enderror" rows="8" required>{{ old('about_ar', $about->about_ar) }}</textarea>
                    @error('about_ar')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('back.about_en')}} <span class="text-danger">*</span></label>
                    <textarea name="about_en" class="form-control @error('about_en') is-invalid @enderror" rows="8" required>{{ old('about_en', $about->about_en) }}</textarea>
                    @error('about_en')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Vision & Mission -->
    <div class="card-section">
        <h5 class="section-title">
            <i class="fas fa-eye"></i>
            الرؤية والرسالة
        </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>الرؤية (عربي)</label>
                    <textarea name="vision_ar" class="form-control @error('vision_ar') is-invalid @enderror" rows="3">{{ old('vision_ar', $about->vision_ar) }}</textarea>
                    @error('vision_ar')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Vision (English)</label>
                    <textarea name="vision_en" class="form-control @error('vision_en') is-invalid @enderror" rows="3">{{ old('vision_en', $about->vision_en) }}</textarea>
                    @error('vision_en')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الرسالة (عربي)</label>
                    <textarea name="mission_ar" class="form-control @error('mission_ar') is-invalid @enderror" rows="3">{{ old('mission_ar', $about->mission_ar) }}</textarea>
                    @error('mission_ar')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Mission (English)</label>
                    <textarea name="mission_en" class="form-control @error('mission_en') is-invalid @enderror" rows="3">{{ old('mission_en', $about->mission_en) }}</textarea>
                    @error('mission_en')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Images -->
    <div class="card-section">
        <h5 class="section-title">
            <i class="fas fa-images"></i>
            الصور
        </h5>
        <div class="row">
            <div class="col-md-4">
                <div class="image-preview-box" id="logo-preview">
                    <label for="logo">
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <h6>{{trans('back.upload_logo')}}</h6>
                        <small class="text-muted">PNG, JPG (Max: 2MB)</small>
                    </label>
                    <input type="file" class="d-none" name="logo" id="logo" accept="image/*">
                    @if($about->logo)
                    <img src="{{ URL::asset($about->logo) }}" alt="logo" class="preview-img">
                    @endif
                    @error('logo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="image-preview-box" id="about-image-preview">
                    <label for="image_about_us">
                        <i class="fas fa-image upload-icon"></i>
                        <h6>{{trans('back.image_about_us')}}</h6>
                        <small class="text-muted">PNG, JPG (Max: 2MB)</small>
                    </label>
                    <input type="file" class="d-none" name="image_about_us" id="image_about_us" accept="image/*">
                    @if($about->image_about_us)
                    <img src="{{ URL::asset($about->image_about_us) }}" alt="about" class="preview-img">
                    @endif
                    @error('image_about_us')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="image-preview-box" id="hero-image-preview">
                    <label for="hero_image">
                        <i class="fas fa-panorama upload-icon"></i>
                        <h6>صورة الخلفية</h6>
                        <small class="text-muted">PNG, JPG (Max: 2MB)</small>
                    </label>
                    <input type="file" class="d-none" name="hero_image" id="hero_image" accept="image/*">
                    @if($about->hero_image)
                    <img src="{{ URL::asset($about->hero_image) }}" alt="hero" class="preview-img">
                    @endif
                    @error('hero_image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="save-section">
        <button type="submit" class="btn btn-save" id="saveButton">
            <i class="fas fa-save"></i> حفظ التغييرات
        </button>
        <p class="text-muted mt-3 mb-0" style="font-size: 13px;">
            <i class="fas fa-info-circle me-1"></i>
            سيتم حفظ جميع التغييرات في قاعدة البيانات
        </p>
    </div>
</form>

<!-- Success Animation -->
<div class="success-checkmark" id="successAnimation">
    <div class="check-icon" style="width: 80px; height: 80px; position: relative;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" style="width: 100%; height: 100%;">
            <circle cx="26" cy="26" r="25" fill="none" stroke="#34c38f" stroke-width="3"/>
            <path fill="none" stroke="#34c38f" stroke-width="4" stroke-linecap="round" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
        </svg>
    </div>
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Image preview functionality
    function setupImagePreview(inputId, previewBoxId) {
        const $input = $(inputId);
        const $previewBox = $(previewBoxId);
        
        // جعل صندوق المعاينة قابل للنقر
        $previewBox.on('click', function(e) {
            if (!$(e.target).is('input')) {
                $input.click();
            }
        });
        
        // التعامل مع تغيير الملف
        $input.on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // التحقق من حجم الملف (2MB كحد أقصى)
                if (file.size > 2 * 1024 * 1024) {
                    showAlert('خطأ', 'حجم الملف يجب أن يكون أقل من 2MB', 'error');
                    $(this).val('');
                    return;
                }
                
                // التحقق من نوع الملف
                if (!file.type.match('image.*')) {
                    showAlert('خطأ', 'يرجى اختيار صورة فقط (PNG, JPG, JPEG)', 'error');
                    $(this).val('');
                    return;
                }
                
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    let $previewImg = $previewBox.find('.preview-img');
                    
                    if ($previewImg.length) {
                        // تأثير التلاشي للصورة القديمة
                        $previewImg.css('opacity', '0');
                        setTimeout(() => {
                            $previewImg.attr('src', e.target.result);
                            $previewImg.css('opacity', '1');
                        }, 300);
                    } else {
                        // إنشاء معاينة جديدة
                        const img = $('<img>')
                            .attr('src', e.target.result)
                            .addClass('preview-img')
                            .css('opacity', '0');
                        $previewBox.append(img);
                        
                        // ظهور الصورة الجديدة تدريجياً
                        setTimeout(() => {
                            img.css('opacity', '1');
                        }, 100);
                    }
                    
                    // إخفاء أيقونة الرفع
                    $previewBox.find('.upload-icon').hide();
                    $previewBox.find('h6, small').hide();
                    
                    // إضافة اسم الملف
                    $previewBox.find('.file-name').remove();
                    $previewBox.append(`
                        <div class="file-name text-success mt-2">
                            <i class="fas fa-check-circle me-1"></i>
                            ${file.name}
                        </div>
                    `);
                };
                
                reader.readAsDataURL(file);
            }
        });
    }
    
    // إعداد معاينة الصور
    setupImagePreview('#logo', '#logo-preview');
    setupImagePreview('#image_about_us', '#about-image-preview');
    setupImagePreview('#hero_image', '#hero-image-preview');
    
    // عدّاد الأحرف للنصوص الطويلة
    function setupCharacterCounter(textareaSelector) {
        const $textarea = $(textareaSelector);
        
        const updateCounter = () => {
            const length = $textarea.val().length;
            let $counter = $textarea.parent().find('.char-counter');
            
            if (!$counter.length) {
                $counter = $('<small class="char-counter text-muted d-block mt-1"></small>');
                $textarea.parent().append($counter);
            }
            
            $counter.text(`${length} حرف`);
            
            // تغيير اللون بناءً على الطول
            $counter.removeClass('text-success text-warning text-danger text-muted');
            
            if (length === 0) {
                $counter.addClass('text-muted');
            } else if (length < 50) {
                $counter.addClass('text-warning');
            } else if (length > 1000) {
                $counter.addClass('text-danger');
            } else {
                $counter.addClass('text-success');
            }
        };
        
        $textarea.on('input', updateCounter);
        updateCounter(); // العد الأولي
    }
    
    // إعداد عدادات الأحرف
    setupCharacterCounter('textarea[name="about_ar"]');
    setupCharacterCounter('textarea[name="about_en"]');
    setupCharacterCounter('textarea[name="vision_ar"]');
    setupCharacterCounter('textarea[name="vision_en"]');
    setupCharacterCounter('textarea[name="mission_ar"]');
    setupCharacterCounter('textarea[name="mission_en"]');
    
    // التحقق من النموذج قبل الإرسال
    $('#aboutForm').on('submit', function(e) {
        const $submitBtn = $('#saveButton');
        const $form = $(this);
        
        // التحقق من الحقول المطلوبة
        let isValid = true;
        $form.find('[required]').each(function() {
            const $field = $(this);
            if (!$field.val().trim()) {
                $field.addClass('is-invalid');
                $field.after(`<div class="invalid-feedback d-block">هذا الحقل مطلوب</div>`);
                isValid = false;
                
                if ($field.is(':visible')) {
                    $('html, body').animate({
                        scrollTop: $field.offset().top - 100
                    }, 500);
                    $field.focus();
                    return false;
                }
            } else {
                $field.removeClass('is-invalid');
                $field.next('.invalid-feedback').remove();
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showAlert('خطأ', 'يرجى ملء جميع الحقول المطلوبة', 'error');
            return;
        }
        
        // إضافة تأثير التحميل
        $submitBtn.addClass('loading');
        $submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> جاري الحفظ...');
        $submitBtn.prop('disabled', true);
        
        // السماح للنموذج بالإرسال
        return true;
    });
    
    // التمرير السلس للأخطاء
    setTimeout(function() {
        const $errorElements = $('.is-invalid').closest('.form-group');
        if ($errorElements.length > 0) {
            $('html, body').animate({
                scrollTop: $errorElements.first().offset().top - 100
            }, 500);
            $errorElements.first().find('input, textarea, select').focus();
        }
    }, 100);
    
    // مؤشر الحفظ التلقائي
    let saveTimeout;
    let isFormChanged = false;
    
    $('input, textarea').on('input', function() {
        isFormChanged = true;
        clearTimeout(saveTimeout);
        
        let $indicator = $('.auto-save-indicator');
        
        if (!$indicator.length) {
            $indicator = $(`
                <div class="auto-save-indicator" style="
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    background: #fff;
                    padding: 10px 20px;
                    border-radius: 30px;
                    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
                    font-size: 14px;
                    z-index: 1000;
                    display: flex;
                    align-items: center;
                    transition: opacity 0.3s ease;
                    border: 1px solid #f0f2f5;
                ">
                    <i class="fas fa-edit text-warning me-2"></i> تعديل غير محفوظ
                </div>
            `);
            $('body').append($indicator);
        }
        
        $indicator.show().css('opacity', '1');
        
        saveTimeout = setTimeout(() => {
            $indicator.css('opacity', '0');
            setTimeout(() => $indicator.hide(), 300);
        }, 3000);
    });
    
    // عرض رسائل التنبيه
    function showAlert(title, message, type) {
        const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        
        const $alert = $(`
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 10000;">
                <i class="fas fa-${icon} me-2"></i>
                <strong>${title}:</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
            </div>
        `);
        
        $('body').append($alert);
        
        // إزالة التنبيه تلقائياً بعد 5 ثوانٍ
        setTimeout(() => {
            $alert.alert('close');
        }, 5000);
    }
    
    // إظهار رسالة النجاح إذا كان هناك رسالة في الجلسة
    @if(session('success'))
        setTimeout(() => {
            $('#successAnimation').addClass('show');
            setTimeout(() => {
                $('#successAnimation').removeClass('show');
            }, 2000);
        }, 500);
    @endif
    
    // منع إغلاق الصفحة إذا كان هناك تغييرات غير محفوظة
    window.addEventListener('beforeunload', function(e) {
        if (isFormChanged) {
            e.preventDefault();
            e.returnValue = 'لديك تغييرات غير محفوظة. هل أنت متأكد أنك تريد المغادرة؟';
            return e.returnValue;
        }
    });
    
    // إعادة تمكين زر الحفظ عند العودة للصفحة
    $(window).on('pageshow', function() {
        $('#saveButton').removeClass('loading').prop('disabled', false);
        $('#saveButton').html('<i class="fas fa-save"></i> حفظ التغييرات');
    });
    
    // إضافة تأثيرات للحقول عند التركيز
    $('input, textarea, select').on('focus', function() {
        $(this).closest('.form-group').css('transform', 'translateY(-2px)');
    }).on('blur', function() {
        $(this).closest('.form-group').css('transform', 'translateY(0)');
    });
});
</script>
@endsection