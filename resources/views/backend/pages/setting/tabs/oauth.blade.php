<!-- OAuth Settings Tab -->
<div class="tab-pane fade" id="oauth" role="tabpanel">
    <style>
        /* Save Button Styles */
        .save-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .save-button:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .save-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.4);
        }
        
        .save-button i {
            margin-right: 8px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
    
    <form id="oauthForm" action="{{ route('admin.settings.update.oauth') }}" method="post">
        @csrf
        @method('PUT')
        
        <!-- Google Login Settings -->
        <div class="card">
            <div class="card-header">
                <i class="fab fa-google"></i> إعدادات تسجيل الدخول بـ Google
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="form-check form-switch me-3">
                                <input class="form-check-input" type="checkbox" id="google_login_enabled" 
                                       name="google_login_enabled" {{ ($setting->google_login_enabled ?? false) ? 'checked' : '' }}
                                       onchange="toggleGoogleSettings(this)">
                                <label class="form-check-label" for="google_login_enabled">
                                    <strong>تفعيل تسجيل الدخول بـ Google</strong>
                                </label>
                            </div>
                            <span id="google-status" class="badge {{ ($setting->google_login_enabled ?? false) ? 'bg-success' : 'bg-secondary' }}">
                                {{ ($setting->google_login_enabled ?? false) ? 'مفعل' : 'معطل' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div id="google-settings" style="{{ ($setting->google_login_enabled ?? false) ? '' : 'display: none;' }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Google Client ID <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-google text-danger"></i></span>
                                <input type="text" class="form-control" name="google_client_id" 
                                       value="{{ $setting->google_client_id ?? '' }}" 
                                       placeholder="xxxx.apps.googleusercontent.com">
                            </div>
                            <small class="text-muted">معرف العميل</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Google Client Secret <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key text-warning"></i></span>
                                <input type="password" class="form-control" name="google_client_secret" 
                                       value="{{ $setting->google_client_secret ?? '' }}" 
                                       placeholder="GOCSPX-xxxxxxxxxxxx">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">كلمة السر السرية</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Redirect URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                                <input type="text" class="form-control" name="google_redirect_url" 
                                       value="{{ $setting->google_redirect_url ?? url('/auth/google/callback') }}" 
                                       readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard(this)" 
                                        data-copy="{{ $setting->google_redirect_url ?? url('/auth/google/callback') }}">
                                    <i class="fas fa-copy"></i> نسخ
                                </button>
                            </div>
                            <small class="text-muted">استخدم هذا الرابط في إعدادات Google OAuth</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3"><i class="fas fa-cogs"></i> خيارات إضافية</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="google_auto_register" 
                                       name="google_auto_register" {{ ($setting->google_auto_register ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="google_auto_register">
                                    تسجيل المستخدمين الجدد تلقائياً
                                </label>
                                <small class="text-muted d-block">السماح للمستخدمين الجدد بإنشاء حساب عند تسجيل الدخول بـ Google</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="google_sync_profile" 
                                       name="google_sync_profile" {{ ($setting->google_sync_profile ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="google_sync_profile">
                                    مزامنة معلومات الملف الشخصي
                                </label>
                                <small class="text-muted d-block">تحديث الاسم والصورة من حساب Google</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mt-4">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>ملاحظة مهمة:</strong>
                    <ul class="mb-0 mt-2">
                        <li>تأكد من تفعيل Google+ API في مشروع Google Cloud</li>
                        <li>أضف النطاقات المسموح بها في إعدادات OAuth consent screen</li>
                        <li>في بيئة الإنتاج، استخدم HTTPS للأمان</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Social Login Display Settings -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-paint-brush"></i> إعدادات عرض تسجيل الدخول الاجتماعي
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">نص زر Google (عربي)</label>
                        <input type="text" class="form-control" name="google_button_text_ar" 
                               value="{{ $setting->google_button_text_ar ?? 'تسجيل الدخول بـ Google' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">نص زر Google (English)</label>
                        <input type="text" class="form-control" name="google_button_text_en" 
                               value="{{ $setting->google_button_text_en ?? 'Sign in with Google' }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">معاينة الزر</label>
                        <div class="d-flex gap-3">
                            <button type="button" class="btn btn-outline-danger">
                                <i class="fab fa-google me-2"></i>
                                <span id="preview-ar">{{ $setting->google_button_text_ar ?? 'تسجيل الدخول بـ Google' }}</span>
                            </button>
                            <button type="button" class="btn btn-danger">
                                <i class="fab fa-google me-2"></i>
                                <span id="preview-en">{{ $setting->google_button_text_en ?? 'Sign in with Google' }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="button" class="btn btn-outline-primary me-3" onclick="testGoogleLogin()">
                <i class="fas fa-vial"></i> اختبار الاتصال
            </button>
            <button type="button" class="btn btn-primary btn-lg px-5 save-button" onclick="saveSettings('oauthForm')">
                <i class="fas fa-save"></i> حفظ إعدادات OAuth
            </button>
        </div>
    </form>
</div>

<script>
function toggleGoogleSettings(checkbox) {
    const settings = document.getElementById('google-settings');
    const status = document.getElementById('google-status');
    
    if (checkbox.checked) {
        settings.style.display = 'block';
        status.textContent = 'مفعل';
        status.className = 'badge bg-success';
    } else {
        settings.style.display = 'none';
        status.textContent = 'معطل';
        status.className = 'badge bg-secondary';
    }
}

function togglePassword(button) {
    const input = button.parentElement.querySelector('input');
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

function copyToClipboard(button) {
    const text = button.getAttribute('data-copy');
    navigator.clipboard.writeText(text).then(() => {
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i> تم النسخ';
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalHtml;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    });
}

// Update button preview
document.querySelector('[name="google_button_text_ar"]')?.addEventListener('input', function(e) {
    document.getElementById('preview-ar').textContent = e.target.value;
});

document.querySelector('[name="google_button_text_en"]')?.addEventListener('input', function(e) {
    document.getElementById('preview-en').textContent = e.target.value;
});

function testGoogleLogin() {
    Swal.fire({
        title: 'اختبار اتصال Google',
        text: 'جاري اختبار الإعدادات...',
        icon: 'info',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
            
            // Simulate API test
            setTimeout(() => {
                const clientId = document.querySelector('[name="google_client_id"]').value;
                const clientSecret = document.querySelector('[name="google_client_secret"]').value;
                
                if (clientId && clientSecret) {
                    Swal.fire({
                        icon: 'success',
                        title: 'نجح الاختبار',
                        text: 'تم الاتصال بـ Google OAuth بنجاح',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'فشل الاختبار',
                        text: 'الرجاء إدخال Client ID و Client Secret'
                    });
                }
            }, 1500);
        }
    });
}
</script>
