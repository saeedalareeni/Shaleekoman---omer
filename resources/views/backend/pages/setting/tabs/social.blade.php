<!-- Social Media Tab -->
<div class="tab-pane fade" id="social" role="tabpanel">
    <form id="socialForm" action="{{ route('admin.settings.update.social') }}" method="post">
        @csrf
        @method('PUT')
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-share-alt"></i> وسائل التواصل الاجتماعي
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fab fa-facebook" style="color: #1877f2;"></i> Facebook</label>
                        <input type="url" class="form-control" name="facebook" value="{{ $setting->facebook ?? '' }}" placeholder="https://facebook.com/yourpage">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fab fa-twitter" style="color: #1da1f2;"></i> Twitter</label>
                        <input type="url" class="form-control" name="twitter" value="{{ $setting->twitter ?? '' }}" placeholder="https://twitter.com/yourhandle">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fab fa-instagram" style="color: #e4405f;"></i> Instagram</label>
                        <input type="url" class="form-control" name="instagram" value="{{ $setting->instagram ?? '' }}" placeholder="https://instagram.com/yourhandle">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fab fa-youtube" style="color: #ff0000;"></i> YouTube</label>
                        <input type="url" class="form-control" name="youtube" value="{{ $setting->youtube ?? '' }}" placeholder="https://youtube.com/channel/...">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fab fa-linkedin" style="color: #0077b5;"></i> LinkedIn</label>
                        <input type="url" class="form-control" name="linkedin" value="{{ $setting->linkedin ?? '' }}" placeholder="https://linkedin.com/company/...">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fab fa-whatsapp" style="color: #25d366;"></i> WhatsApp</label>
                        <input type="text" class="form-control" name="whatsapp" value="{{ $setting->whatsapp ?? '' }}" placeholder="+968 9999 9999">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fab fa-telegram" style="color: #0088cc;"></i> Telegram</label>
                        <input type="url" class="form-control" name="telegram" value="{{ $setting->telegram ?? '' }}" placeholder="https://t.me/yourchannel">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fab fa-snapchat" style="color: #fffc00;"></i> Snapchat</label>
                        <input type="text" class="form-control" name="snapchat" value="{{ $setting->snapchat ?? '' }}" placeholder="yourhandle">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fab fa-tiktok"></i> TikTok</label>
                        <input type="url" class="form-control" name="tiktok" value="{{ $setting->tiktok ?? '' }}" placeholder="https://tiktok.com/@yourhandle">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fab fa-pinterest" style="color: #bd081c;"></i> Pinterest</label>
                        <input type="url" class="form-control" name="pinterest" value="{{ $setting->pinterest ?? '' }}" placeholder="https://pinterest.com/yourhandle">
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3"><i class="fas fa-code"></i> أكواد التتبع والتحليلات</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Google Analytics ID</label>
                        <input type="text" class="form-control" name="google_analytics_id" value="{{ $setting->google_analytics_id ?? '' }}" placeholder="UA-XXXXXXXXX-X or G-XXXXXXXXXX">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Facebook Pixel ID</label>
                        <input type="text" class="form-control" name="facebook_pixel_id" value="{{ $setting->facebook_pixel_id ?? '' }}" placeholder="1234567890">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Google Tag Manager ID</label>
                        <input type="text" class="form-control" name="google_tag_manager_id" value="{{ $setting->google_tag_manager_id ?? '' }}" placeholder="GTM-XXXXXXX">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Google Maps API Key</label>
                        <input type="text" class="form-control" name="google_maps_api_key" value="{{ $setting->google_maps_api_key ?? '' }}" placeholder="AIzaSy...">
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3"><i class="fas fa-search"></i> SEO Settings</h5>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Meta Title (الصفحة الرئيسية)</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ $setting->meta_title ?? '' }}" placeholder="موقع حجز الشاليهات الأول في عمان">
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="3" placeholder="احجز أفضل الشاليهات والاستراحات في عمان بأسعار منافسة...">{{ $setting->meta_description ?? '' }}</textarea>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" name="meta_keywords" value="{{ $setting->meta_keywords ?? '' }}" placeholder="شاليهات, استراحات, حجز, عمان, سياحة">
                        <small class="text-muted">افصل بين الكلمات بفاصلة</small>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Open Graph Image</label>
                        <input type="file" class="form-control" name="og_image" accept="image/*" onchange="previewImage(this, 'og-preview')">
                        @if(isset($setting->og_image))
                            <img id="og-preview" src="{{ asset($setting->og_image) }}" class="preview-image mt-2" alt="OG Image">
                        @else
                            <img id="og-preview" class="preview-image mt-2" style="display:none;" alt="OG Image">
                        @endif
                        <small class="text-muted">الحجم المثالي: 1200x630 بكسل</small>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="button" class="btn btn-save" onclick="saveSettings('socialForm')">
                        <i class="fas fa-save"></i> حفظ إعدادات التواصل
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
