<!-- Email Settings Tab -->
<div class="tab-pane fade" id="email" role="tabpanel">
    <form id="emailForm" action="{{ route('admin.settings.update.email') }}" method="post">
        @csrf
        @method('PUT')
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-envelope"></i> إعدادات البريد الإلكتروني SMTP
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mail Driver</label>
                        <select class="form-select" name="mail_driver">
                            <option value="smtp" {{ (env('MAIL_MAILER') ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="sendmail" {{ (env('MAIL_MAILER') ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            <option value="mailgun" {{ (env('MAIL_MAILER') ?? '') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                            <option value="ses" {{ (env('MAIL_MAILER') ?? '') == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mail Host</label>
                        <input type="text" class="form-control" name="mail_host" value="{{ env('MAIL_HOST') ?? '' }}" placeholder="smtp.gmail.com">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Mail Port</label>
                        <input type="text" class="form-control" name="mail_port" value="{{ env('MAIL_PORT') ?? '' }}" placeholder="587">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Mail Username</label>
                        <input type="text" class="form-control" name="mail_username" value="{{ env('MAIL_USERNAME') ?? '' }}" placeholder="your-email@gmail.com">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Mail Password</label>
                        <input type="password" class="form-control" name="mail_password" value="{{ env('MAIL_PASSWORD') ?? '' }}" placeholder="••••••••">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Mail Encryption</label>
                        <select class="form-select" name="mail_encryption">
                            <option value="tls" {{ (env('MAIL_ENCRYPTION') ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ (env('MAIL_ENCRYPTION') ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="" {{ (env('MAIL_ENCRYPTION') ?? '') == '' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Mail From Address</label>
                        <input type="email" class="form-control" name="mail_from_address" value="{{ env('MAIL_FROM_ADDRESS') ?? '' }}" placeholder="noreply@yourdomain.com">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Mail From Name</label>
                        <input type="text" class="form-control" name="mail_from_name" value="{{ env('MAIL_FROM_NAME') ?? '' }}" placeholder="Your Company">
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3"><i class="fas fa-bell"></i> إعدادات الإشعارات</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="email_notifications_enabled" name="email_notifications_enabled" {{ ($setting->email_notifications_enabled ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_notifications_enabled">
                                تفعيل إشعارات البريد الإلكتروني
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="sms_notifications_enabled" name="sms_notifications_enabled" {{ ($setting->sms_notifications_enabled ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="sms_notifications_enabled">
                                تفعيل إشعارات SMS
                            </label>
                        </div>
                    </div>
                </div>

                <h6 class="mt-3 mb-2">أنواع الإشعارات:</h6>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notify_new_booking" name="notify_new_booking" {{ ($setting->notify_new_booking ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notify_new_booking">
                                حجز جديد
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notify_booking_confirmed" name="notify_booking_confirmed" {{ ($setting->notify_booking_confirmed ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notify_booking_confirmed">
                                تأكيد الحجز
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notify_booking_cancelled" name="notify_booking_cancelled" {{ ($setting->notify_booking_cancelled ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notify_booking_cancelled">
                                إلغاء الحجز
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notify_payment_confirmed" name="notify_payment_confirmed" {{ ($setting->notify_payment_confirmed ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notify_payment_confirmed">
                                تأكيد الدفع
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notify_new_review" name="notify_new_review" {{ ($setting->notify_new_review ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notify_new_review">
                                تقييم جديد
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notify_new_owner" name="notify_new_owner" {{ ($setting->notify_new_owner ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notify_new_owner">
                                تسجيل مالك جديد
                            </label>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle"></i>
                    <strong>ملاحظة:</strong> للاستخدام مع Gmail، تحتاج إلى:
                    <ul class="mb-0 mt-2">
                        <li>تفعيل "Less secure app access" أو</li>
                        <li>استخدام "App Password" (كلمة مرور التطبيق)</li>
                        <li>التأكد من أن المنفذ 587 مع TLS أو 465 مع SSL</li>
                    </ul>
                </div>

                <div class="text-center mt-4">
                    <button type="button" class="btn btn-secondary me-2" onclick="testEmailSettings()">
                        <i class="fas fa-paper-plane"></i> اختبار الإعدادات
                    </button>
                    <button type="button" class="btn btn-save" onclick="saveSettings('emailForm')">
                        <i class="fas fa-save"></i> حفظ إعدادات البريد
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
