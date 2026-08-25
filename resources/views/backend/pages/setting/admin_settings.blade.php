@extends('backend.layouts.master')

@section('page_title', 'إعدادات النظام')
@section('title', 'إعدادات النظام الشاملة')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .settings-container {
        padding: 20px;
        background: #f8f9fa;
        min-height: 100vh;
    }
    
    .nav-tabs {
        border: none;
        background: white;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        overflow-x: auto;
        white-space: nowrap;
    }
    
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        padding: 12px 20px;
        margin: 5px;
        border-radius: 8px;
        transition: all 0.3s;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link:hover {
        background: #f0f9f7;
        color: #127664;
    }
    
    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, #127664, #0d5d4e);
        color: white;
    }
    
    .nav-tabs .nav-link i {
        margin-right: 8px;
    }
    
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        transition: transform 0.3s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .card-header {
        background: linear-gradient(135deg, #127664, #0d5d4e);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 18px 25px;
        font-weight: 600;
        font-size: 18px;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }
    
    .form-control, .form-select {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 12px 15px;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #127664;
        box-shadow: 0 0 0 0.2rem rgba(18, 118, 100, 0.25);
    }
    
    .btn-save {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
        border: none;
        padding: 14px 35px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
    }
    
    .btn-save:hover {
        background: linear-gradient(135deg, #218838, #1e7e34);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.4);
        color: white;
    }
    
    .btn-save:active {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    
    .btn-save:disabled {
        background: #6c757d;
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }
    
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 30px;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .slider {
        background-color: #127664;
    }
    
    input:checked + .slider:before {
        transform: translateX(30px);
    }
    
    .payment-card {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        background: white;
        transition: all 0.3s;
    }
    
    .payment-card:hover {
        border-color: #127664;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .payment-card.active {
        border-color: #127664;
        background: linear-gradient(to bottom right, #f0f9f7, #ffffff);
    }
    
    .preview-image {
        width: 150px !important;
        height: 80px !important;
        object-fit: contain !important;
        border-radius: 10px;
        margin-top: 15px;
        border: 2px solid #e0e0e0;
        padding: 8px;
        background: #f8f9fa;
        display: block;
    }
    
    /* تحجيم خاص للـ Favicon */
    #favicon-preview {
        width: 50px !important;
        height: 50px !important;
    }
    
    /* خلفية داكنة للشعار الأبيض */
    #logo-white-preview {
        background: #2c3e50 !important;
    }
    
    /* Container للصور */
    .image-preview-container {
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-top: 10px;
        padding: 5px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background: #fafafa;
    }
    
    @media (max-width: 768px) {
        .nav-tabs {
            padding: 5px;
        }
        
        .nav-tabs .nav-link {
            padding: 10px 15px;
            font-size: 14px;
        }
        
        .card-header {
            padding: 15px 20px;
            font-size: 16px;
        }
        
        .btn-save {
            width: 100%;
            margin-top: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="settings-container">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                <i class="fas fa-cog"></i> الإعدادات العامة
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">
                <i class="fas fa-credit-card"></i> وسائل الدفع
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="oauth-tab" data-toggle="tab" href="#oauth" role="tab" aria-controls="oauth" aria-selected="false">
                <i class="fab fa-google"></i> Google OAuth
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="email-tab" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="false">
                <i class="fas fa-envelope"></i> البريد الإلكتروني
            </a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" id="commission-tab" data-toggle="tab" href="#commission" role="tab" aria-controls="commission" aria-selected="false">
                <i class="fas fa-percentage"></i> العمولات
            </a>
        </li> -->
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="settingsTabContent">
        @include('backend.pages.setting.tabs.general')
        @include('backend.pages.setting.tabs.payment')
        @include('backend.pages.setting.tabs.oauth')
        @include('backend.pages.setting.tabs.email')
        <!-- @include('backend.pages.setting.tabs.commission') -->
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Preview image before upload
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var previewElement = $('#' + previewId);
            previewElement.attr('src', e.target.result);
            previewElement.show();
            
            // تأكد من أن الصورة تحترم الأنماط المحددة
            previewElement.css({
                'width': previewId === 'favicon-preview' ? '50px' : '150px',
                'height': previewId === 'favicon-preview' ? '50px' : '80px',
                'object-fit': 'contain',
                'display': 'block'
            });
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Toggle payment settings
$(document).ready(function() {
    // تطبيق التحجيم على الصور الموجودة
    $('.preview-image').each(function() {
        var imgId = $(this).attr('id');
        if (imgId === 'favicon-preview') {
            $(this).css({
                'width': '50px',
                'height': '50px',
                'object-fit': 'contain'
            });
        } else {
            $(this).css({
                'width': '150px',
                'height': '80px',
                'object-fit': 'contain'
            });
        }
    });
    
    // Payment method toggles
    $('#paypal_enabled').change(function() {
        $('#paypal_settings').toggle(this.checked);
    });
    
    $('#stripe_enabled').change(function() {
        $('#stripe_settings').toggle(this.checked);
    });
    
    $('#thawani_enabled').change(function() {
        $('#thawani_settings').toggle(this.checked);
    });
    
    $('#cash_enabled').change(function() {
        $('#cash_settings').toggle(this.checked);
    });
    
    // Initialize on page load
    if ($('#paypal_enabled').is(':checked')) {
        $('#paypal_settings').show();
    }
    if ($('#stripe_enabled').is(':checked')) {
        $('#stripe_settings').show();
    }
    if ($('#thawani_enabled').is(':checked')) {
        $('#thawani_settings').show();
    }
    if ($('#cash_enabled').is(':checked')) {
        $('#cash_settings').show();
    }
});

// Save settings via AJAX
function saveSettings(formId) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    const submitBtn = form.querySelector('.btn-save');
    
    // تعطيل الزر أثناء الإرسال
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
    }
    
    $.ajax({
        url: form.action,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'تم الحفظ',
                text: response.message || 'تم حفظ الإعدادات بنجاح',
                timer: 2000,
                showConfirmButton: false
            });
        },
        error: function(xhr) {
            let errorMessage = 'حدث خطأ أثناء حفظ الإعدادات';
            
            // محاولة استخراج رسالة الخطأ من الاستجابة
            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON.errors) {
                    // إذا كان هناك أخطاء في الحقول
                    const errors = xhr.responseJSON.errors;
                    errorMessage = 'يرجى التحقق من:\n';
                    for (const field in errors) {
                        errorMessage += '• ' + errors[field][0] + '\n';
                    }
                }
            } else if (xhr.status === 422) {
                errorMessage = 'يرجى التحقق من البيانات المدخلة';
            } else if (xhr.status === 500) {
                errorMessage = 'خطأ في الخادم. يرجى المحاولة لاحقاً';
            } else if (xhr.status === 419) {
                errorMessage = 'انتهت صلاحية الجلسة. يرجى تحديث الصفحة والمحاولة مرة أخرى';
            }
            
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: errorMessage,
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#dc3545'
            });
            
            // طباعة الخطأ في وحدة التحكم للمطور
            console.error('Error saving settings:', xhr);
        },
        complete: function() {
            // إعادة تمكين الزر
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save"></i> حفظ الإعدادات';
            }
        }
    });
}

// Test email settings
function testEmailSettings() {
    $.ajax({
        url: '{{ route("admin.settings.test-email") }}',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'نجح الاختبار',
                text: 'تم إرسال بريد تجريبي بنجاح'
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'فشل الاختبار',
                text: 'تحقق من إعدادات البريد الإلكتروني'
            });
        }
    });
}
</script>
@endpush
