<!-- Commission & Tax Tab -->
<div class="tab-pane fade" id="commission" role="tabpanel">
    <form id="commissionForm" action="{{ route('admin.settings.update.commission') }}" method="post">
        @csrf
        @method('PUT')
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-percentage"></i> إعدادات العمولات والضرائب
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">عمولة الموقع (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="site_commission" min="0" max="100" step="0.1" value="{{ $setting->site_commission ?? 15 }}">
                            <span class="input-group-text">%</span>
                        </div>
                        <small class="text-muted">النسبة المئوية التي يأخذها الموقع من كل حجز</small>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="form-label">ضريبة القيمة المضافة (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="vat_percentage" min="0" max="100" step="0.1" value="{{ $setting->vat_percentage ?? 5 }}">
                            <span class="input-group-text">%</span>
                        </div>
                        <small class="text-muted">نسبة ضريبة القيمة المضافة المطبقة على الحجوزات</small>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="form-label">رسوم الخدمة (مبلغ ثابت)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="service_fee" min="0" step="0.01" value="{{ $setting->service_fee ?? 10 }}">
                            <span class="input-group-text">ر.ع</span>
                        </div>
                        <small class="text-muted">رسوم خدمة ثابتة تضاف لكل حجز</small>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="form-label">رسوم التنظيف (اختياري)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="cleaning_fee" min="0" step="0.01" value="{{ $setting->cleaning_fee ?? 0 }}">
                            <span class="input-group-text">ر.ع</span>
                        </div>
                        <small class="text-muted">رسوم تنظيف إضافية (يمكن للمالك تخصيصها)</small>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3"><i class="fas fa-coins"></i> إعدادات الحجز</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">الحد الأدنى للحجز</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="min_booking_amount" min="0" step="1" value="{{ $setting->min_booking_amount ?? 50 }}">
                            <span class="input-group-text">ر.ع</span>
                        </div>
                        <small class="text-muted">الحد الأدنى لقيمة الحجز</small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">نسبة العربون (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="deposit_percentage" min="0" max="100" step="1" value="{{ $setting->deposit_percentage ?? 30 }}">
                            <span class="input-group-text">%</span>
                        </div>
                        <small class="text-muted">نسبة العربون المطلوب دفعه مقدماً</small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">مهلة الإلغاء (ساعات)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="cancellation_hours" min="0" step="1" value="{{ $setting->cancellation_hours ?? 24 }}">
                            <span class="input-group-text">ساعة</span>
                        </div>
                        <small class="text-muted">عدد الساعات المسموح بها للإلغاء المجاني</small>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3"><i class="fas fa-chart-line"></i> سياسة الإلغاء</h5>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">نوع سياسة الإلغاء</label>
                        <select class="form-select" name="cancellation_policy">
                            <option value="flexible" {{ ($setting->cancellation_policy ?? '') == 'flexible' ? 'selected' : '' }}>مرنة - إلغاء مجاني حتى 24 ساعة قبل الوصول</option>
                            <option value="moderate" {{ ($setting->cancellation_policy ?? '') == 'moderate' ? 'selected' : '' }}>متوسطة - إلغاء مجاني حتى 5 أيام قبل الوصول</option>
                            <option value="strict" {{ ($setting->cancellation_policy ?? '') == 'strict' ? 'selected' : '' }}>صارمة - إلغاء مجاني حتى 14 يوم قبل الوصول</option>
                            <option value="super_strict" {{ ($setting->cancellation_policy ?? '') == 'super_strict' ? 'selected' : '' }}>صارمة جداً - إلغاء مجاني حتى 30 يوم قبل الوصول</option>
                            <option value="no_refund" {{ ($setting->cancellation_policy ?? '') == 'no_refund' ? 'selected' : '' }}>بدون استرداد - لا يمكن استرداد المبلغ</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">رسوم الإلغاء (%)</label>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label small">إلغاء في نفس اليوم</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="cancellation_fee_same_day" min="0" max="100" value="{{ $setting->cancellation_fee_same_day ?? 100 }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">قبل 1-3 أيام</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="cancellation_fee_1_3_days" min="0" max="100" value="{{ $setting->cancellation_fee_1_3_days ?? 50 }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">قبل 4-7 أيام</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="cancellation_fee_4_7_days" min="0" max="100" value="{{ $setting->cancellation_fee_4_7_days ?? 25 }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">أكثر من 7 أيام</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="cancellation_fee_7_plus_days" min="0" max="100" value="{{ $setting->cancellation_fee_7_plus_days ?? 0 }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>تنبيه:</strong> تغيير هذه الإعدادات سيؤثر على جميع الحجوزات الجديدة. الحجوزات الحالية لن تتأثر.
                </div>

                <div class="text-center mt-4">
                    <button type="button" class="btn btn-save" onclick="saveSettings('commissionForm')">
                        <i class="fas fa-save"></i> حفظ إعدادات العمولات
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
