<!-- Payment Methods Tab -->
<div class="tab-pane fade" id="payment" role="tabpanel">
    <style>
        .payment-method-card {
            border: 2px solid #e8e8e8;
            border-radius: 15px;
            margin-bottom: 25px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .payment-method-card:hover {
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .payment-method-card.active {
            border-color: #127664;
            box-shadow: 0 0 0 3px rgba(18,118,100,0.1);
        }
        
        .payment-header {
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-bottom: 1px solid #e8e8e8;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }
        
        .payment-method-card.active .payment-header {
            background: linear-gradient(135deg, #e3f0ed 0%, #ffffff 100%);
            border-bottom-color: #127664;
        }
        
        .payment-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .payment-logo h5 {
            margin: 0;
            font-weight: 600;
            color: #333;
            font-size: 18px;
        }
        
        .payment-logo .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .payment-body {
            padding: 25px;
            display: none;
            animation: slideDown 0.3s ease;
        }
        
        .payment-method-card.active .payment-body {
            display: block;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .payment-switch {
            position: relative;
            display: inline-block;
            width: 65px;
            height: 32px;
        }
        
        .payment-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .payment-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 32px;
        }
        
        .payment-slider:before {
            position: absolute;
            content: "";
            height: 24px;
            width: 24px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        input:checked + .payment-slider {
            background: linear-gradient(135deg, #127664, #0d5d4e);
        }
        
        input:checked + .payment-slider:before {
            transform: translateX(33px);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #127664;
            box-shadow: 0 0 0 0.2rem rgba(18,118,100,0.15);
        }
        
        .input-group .btn {
            border: 2px solid #e0e0e0;
            border-left: 0;
            background: white;
            color: #666;
            padding: 0 15px;
        }
        
        .input-group .btn:hover {
            background: #f8f9fa;
            color: #127664;
        }
        
        .help-text {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
            display: block;
        }
        
        .info-box {
            background: linear-gradient(135deg, #f0f8ff 0%, #fff 100%);
            border-left: 4px solid #1877f2;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .info-box.warning {
            background: linear-gradient(135deg, #fff9e6 0%, #fff 100%);
            border-left-color: #ffc107;
        }
        
        .info-box.success {
            background: linear-gradient(135deg, #e6ffe6 0%, #fff 100%);
            border-left-color: #28a745;
        }
        
        .info-box h6 {
            color: #1877f2;
            margin-bottom: 10px;
            font-weight: 600;
            font-size: 14px;
        }
        
        .info-box.warning h6 {
            color: #ff9800;
        }
        
        .info-box.success h6 {
            color: #28a745;
        }
        
        .info-box ul {
            margin: 0;
            padding-left: 20px;
            font-size: 13px;
            color: #555;
            line-height: 1.8;
        }
        
        .info-box a {
            color: #1877f2;
            text-decoration: none;
            font-weight: 500;
        }
        
        .info-box a:hover {
            text-decoration: underline;
        }
    </style>

    <form id="paymentForm" action="{{ route('admin.settings.update.payment') }}" method="post">
        @csrf
        @method('PUT')
        
        <!-- PayPal -->
        <div class="payment-method-card {{ ($setting->paypal_enabled ?? false) ? 'active' : '' }}" id="paypal-card">
            <div class="payment-header" onclick="togglePaymentCard('paypal')">
                <div class="payment-logo">
                    <i class="fab fa-paypal fa-2x" style="color: #003087;"></i>
                    <div>
                        <h5>PayPal</h5>
                        <span class="badge bg-info">الأكثر استخداماً عالمياً</span>
                    </div>
                </div>
                <label class="payment-switch" onclick="event.stopPropagation();">
                    <input type="checkbox" id="paypal_enabled" name="paypal_enabled" 
                           {{ ($setting->paypal_enabled ?? false) ? 'checked' : '' }}
                           onchange="togglePaymentMethod('paypal', this)">
                    <span class="payment-slider"></span>
                </label>
            </div>
            <div class="payment-body">
                <div class="info-box">
                    <h6><i class="fas fa-info-circle"></i> كيفية الإعداد</h6>
                    <ul>
                        <li>قم بإنشاء حساب تجاري في <a href="https://developer.paypal.com" target="_blank">PayPal Developer</a></li>
                        <li>أنشئ تطبيق جديد (Create App) واحصل على المفاتيح</li>
                        <li>استخدم وضع Sandbox للاختبار قبل التشغيل المباشر</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-key text-primary"></i> Client ID
                            </label>
                            <input type="text" class="form-control" name="paypal_client_id" 
                                   value="{{ $setting->paypal_client_id ?? '' }}" 
                                   placeholder="AX1234567890abcdefgh...">
                            <span class="help-text">معرف العميل من PayPal Dashboard</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock text-warning"></i> Secret Key
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="paypal_secret" 
                                       name="paypal_secret" 
                                       value="{{ $setting->paypal_secret ?? '' }}" 
                                       placeholder="••••••••">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('paypal_secret')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <span class="help-text">كلمة السر من PayPal Dashboard</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-cog text-success"></i> الوضع
                            </label>
                            <select class="form-select form-control" name="paypal_mode">
                                <option value="sandbox" {{ ($setting->paypal_mode ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>
                                    تجريبي (Sandbox) - للاختبار
                                </option>
                                <option value="live" {{ ($setting->paypal_mode ?? '') == 'live' ? 'selected' : '' }}>
                                    مباشر (Live) - للإنتاج
                                </option>
                            </select>
                            <span class="help-text">استخدم Sandbox للتجربة أولاً</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-dollar-sign text-info"></i> العملة الافتراضية
                            </label>
                            <select class="form-select form-control" name="paypal_currency">
                                <option value="USD" {{ ($setting->paypal_currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD - دولار أمريكي</option>
                                <option value="OMR" {{ ($setting->paypal_currency ?? '') == 'OMR' ? 'selected' : '' }}>OMR - ريال عماني</option>
                                <option value="SAR" {{ ($setting->paypal_currency ?? '') == 'SAR' ? 'selected' : '' }}>SAR - ريال سعودي</option>
                                <option value="AED" {{ ($setting->paypal_currency ?? '') == 'AED' ? 'selected' : '' }}>AED - درهم إماراتي</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stripe -->
        <div class="payment-method-card {{ ($setting->stripe_enabled ?? false) ? 'active' : '' }}" id="stripe-card">
            <div class="payment-header" onclick="togglePaymentCard('stripe')">
                <div class="payment-logo">
                    <i class="fab fa-stripe fa-2x" style="color: #635BFF;"></i>
                    <div>
                        <h5>Stripe</h5>
                        <span class="badge bg-success">أفضل تجربة مستخدم</span>
                    </div>
                </div>
                <label class="payment-switch" onclick="event.stopPropagation();">
                    <input type="checkbox" id="stripe_enabled" name="stripe_enabled" 
                           {{ ($setting->stripe_enabled ?? false) ? 'checked' : '' }}
                           onchange="togglePaymentMethod('stripe', this)">
                    <span class="payment-slider"></span>
                </label>
            </div>
            <div class="payment-body">
                <div class="info-box warning">
                    <h6><i class="fas fa-exclamation-triangle"></i> معلومات مهمة</h6>
                    <ul>
                        <li>Stripe يدعم أكثر من 135 عملة ومتاح في 40+ دولة</li>
                        <li>عمولة منخفضة: 2.9% + 30¢ لكل معاملة</li>
                        <li>احصل على المفاتيح من <a href="https://dashboard.stripe.com/apikeys" target="_blank">Stripe Dashboard</a></li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-key text-primary"></i> Publishable Key
                            </label>
                            <input type="text" class="form-control" name="stripe_publishable_key" 
                                   value="{{ $setting->stripe_publishable_key ?? '' }}" 
                                   placeholder="pk_test_...">
                            <span class="help-text">المفتاح العام (يظهر في الواجهة)</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock text-warning"></i> Secret Key
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="stripe_secret" 
                                       name="stripe_secret_key" 
                                       value="{{ $setting->stripe_secret_key ?? '' }}" 
                                       placeholder="sk_test_...">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('stripe_secret')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <span class="help-text">المفتاح السري (لا يظهر أبداً)</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-link text-info"></i> Webhook Secret
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="stripe_webhook" 
                                       name="stripe_webhook_secret" 
                                       value="{{ $setting->stripe_webhook_secret ?? '' }}" 
                                       placeholder="whsec_...">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('stripe_webhook')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <span class="help-text">للتحقق من webhooks الآمنة</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-dollar-sign text-success"></i> العملة
                            </label>
                            <select class="form-select form-control" name="stripe_currency">
                                <option value="USD" {{ ($setting->stripe_currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD - دولار أمريكي</option>
                                <option value="OMR" {{ ($setting->stripe_currency ?? '') == 'OMR' ? 'selected' : '' }}>OMR - ريال عماني</option>
                                <option value="SAR" {{ ($setting->stripe_currency ?? '') == 'SAR' ? 'selected' : '' }}>SAR - ريال سعودي</option>
                                <option value="AED" {{ ($setting->stripe_currency ?? '') == 'AED' ? 'selected' : '' }}>AED - درهم إماراتي</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thawani Pay -->
        <div class="payment-method-card {{ ($setting->thawani_enabled ?? false) ? 'active' : '' }}" id="thawani-card">
            <div class="payment-header" onclick="togglePaymentCard('thawani')">
                <div class="payment-logo">
                    <img src="https://wkndoman.com/images/paymentMethods/thawani.jpg" style="height: 35px;" alt="Thawani">
                    <div>
                        <h5>Thawani Pay</h5>
                        <span class="badge bg-warning text-dark">الأفضل في عُمان</span>
                    </div>
                </div>
                <label class="payment-switch" onclick="event.stopPropagation();">
                    <input type="checkbox" id="thawani_enabled" name="thawani_enabled" 
                           {{ ($setting->thawani_enabled ?? false) ? 'checked' : '' }}
                           onchange="togglePaymentMethod('thawani', this)">
                    <span class="payment-slider"></span>
                </label>
            </div>
            <div class="payment-body">
                <div class="info-box success">
                    <h6><i class="fas fa-check-circle"></i> مميزات Thawani Pay</h6>
                    <ul>
                        <li>بوابة دفع عمانية محلية معتمدة من البنك المركزي</li>
                        <li>عمولة تنافسية للمعاملات المحلية</li>
                        <li>دعم البطاقات المحلية والدولية</li>
                        <li>احصل على المفاتيح من <a href="https://thawani.om" target="_blank">thawani.om</a></li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-key text-primary"></i> Publishable Key
                            </label>
                            <input type="text" class="form-control" name="thawani_publishable_key" 
                                   value="{{ $setting->thawani_publishable_key ?? '' }}" 
                                   placeholder="HGvTMLDssJchr...">
                            <span class="help-text">المفتاح العام من لوحة التحكم</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock text-warning"></i> Secret Key
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="thawani_secret" 
                                       name="thawani_secret_key" 
                                       value="{{ $setting->thawani_secret_key ?? '' }}" 
                                       placeholder="rRQ26GcsZzoEhbrP...">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('thawani_secret')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <span class="help-text">المفتاح السري من لوحة التحكم</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-cog text-info"></i> الوضع
                            </label>
                            <select class="form-select form-control" name="thawani_mode">
                                <option value="test" {{ ($setting->thawani_mode ?? 'test') == 'test' ? 'selected' : '' }}>
                                    تجريبي (UAT)
                                </option>
                                <option value="live" {{ ($setting->thawani_mode ?? '') == 'live' ? 'selected' : '' }}>
                                    مباشر (Production)
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-check text-success"></i> صفحة النجاح
                            </label>
                            <input type="text" class="form-control" name="thawani_success_url" 
                                   value="{{ $setting->thawani_success_url ?? url('/payment/success') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-times text-danger"></i> صفحة الإلغاء
                            </label>
                            <input type="text" class="form-control" name="thawani_cancel_url" 
                                   value="{{ $setting->thawani_cancel_url ?? url('/payment/cancel') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cash & Bank Transfer -->
        <div class="payment-method-card {{ ($setting->cash_enabled ?? true) ? 'active' : '' }}" id="cash-card">
            <div class="payment-header" onclick="togglePaymentCard('cash')">
                <div class="payment-logo">
                    <i class="fas fa-money-bill-wave fa-2x" style="color: #28a745;"></i>
                    <div>
                        <h5>الدفع النقدي والتحويل البنكي</h5>
                        <span class="badge bg-danger">مطلوب للمعاملات المحلية</span>
                    </div>
                </div>
                <label class="payment-switch" onclick="event.stopPropagation();">
                    <input type="checkbox" id="cash_enabled" name="cash_enabled" 
                           {{ ($setting->cash_enabled ?? true) ? 'checked' : '' }}
                           onchange="togglePaymentMethod('cash', this)">
                    <span class="payment-slider"></span>
                </label>
            </div>
            <div class="payment-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-university text-primary"></i> اسم البنك
                            </label>
                            <input type="text" class="form-control" name="bank_name" 
                                   value="{{ $setting->bank_name ?? '' }}" 
                                   placeholder="بنك مسقط">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user text-info"></i> اسم صاحب الحساب
                            </label>
                            <input type="text" class="form-control" name="bank_account_name" 
                                   value="{{ $setting->bank_account_name ?? '' }}" 
                                   placeholder="شركة شاليك للسياحة">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-hashtag text-success"></i> رقم الحساب
                            </label>
                            <input type="text" class="form-control" name="bank_account" 
                                   value="{{ $setting->bank_account ?? '' }}" 
                                   placeholder="1234567890">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-barcode text-warning"></i> IBAN
                            </label>
                            <input type="text" class="form-control" name="bank_iban" 
                                   value="{{ $setting->bank_iban ?? '' }}" 
                                   placeholder="OM12 3456 7890 1234 5678 90">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-code text-danger"></i> Swift Code
                            </label>
                            <input type="text" class="form-control" name="bank_swift" 
                                   value="{{ $setting->bank_swift ?? '' }}" 
                                   placeholder="BMUSOMRXXXX">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt text-secondary"></i> فرع البنك
                            </label>
                            <input type="text" class="form-control" name="bank_branch" 
                                   value="{{ $setting->bank_branch ?? '' }}" 
                                   placeholder="الفرع الرئيسي - مسقط">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-info-circle text-info"></i> تعليمات التحويل البنكي
                            </label>
                            <textarea class="form-control" name="bank_transfer_instructions" rows="3" 
                                      placeholder="يرجى تحويل المبلغ المطلوب إلى الحساب البنكي المذكور أعلاه وإرسال إيصال التحويل عبر واتساب أو البريد الإلكتروني...">{{ $setting->bank_transfer_instructions ?? '' }}</textarea>
                            <span class="help-text">هذه التعليمات ستظهر للعملاء عند اختيار التحويل البنكي</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="button" class="btn btn-save btn-lg" onclick="saveSettings('paymentForm')">
                <i class="fas fa-save"></i> حفظ إعدادات وسائل الدفع
            </button>
        </div>
    </form>
</div>

<script>
function togglePaymentCard(method) {
    const card = document.getElementById(method + '-card');
    const checkbox = document.getElementById(method + '_enabled');
    
    if (!checkbox.checked) {
        // Don't toggle card if it's disabled
        return;
    }
    
    card.classList.toggle('active');
}

function togglePaymentMethod(method, checkbox) {
    const card = document.getElementById(method + '-card');
    
    if (checkbox.checked) {
        card.classList.add('active');
    } else {
        card.classList.remove('active');
    }
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = event.currentTarget;
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

// Initialize payment cards on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check all enabled payment methods and show their cards
    ['paypal', 'stripe', 'thawani', 'cash'].forEach(method => {
        const checkbox = document.getElementById(method + '_enabled');
        if (checkbox && checkbox.checked) {
            document.getElementById(method + '-card').classList.add('active');
        }
    });
});
</script>
