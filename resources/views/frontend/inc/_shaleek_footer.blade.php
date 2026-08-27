<footer class="shaleek-footer">
    <div class="container">
        <div class="shaleek-footer-grid">
            <div class="shaleek-footer-brand">
                <div class="shaleek-logo" style="color: white;">
                    <span class="shaleek-logo-mark">
                        @if($siteLogo ?? false)
                            <img src="{{ $siteLogo }}" alt="{{ $siteName ?? 'شاليك' }}">
                        @else
                            ش
                        @endif
                    </span>
                    <span>{{ $siteName ?? 'شاليك' }}</span>
                </div>
                <p>
                    @if($siteSettings->site_description ?? false)
                        {{ $siteSettings->site_description }}
                    @else
                        {{ app()->getLocale() == 'ar' ? 'منصة عرض وحجز الشاليهات والمزارع والاستراحات وقاعات الأفراح في جميع محافظات سلطنة عمان.' : 'Discover and book chalets, farms, rest houses and wedding halls across the governorates of Oman.' }}
                    @endif
                </p>
                <div class="shaleek-footer-social">
                    @if(!empty($contact_info->whatsapp))
                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', $contact_info->whatsapp) }}" target="_blank" rel="noopener" aria-label="واتساب">
                            <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    @endif
                    @if(!empty($contact_info->instagram_url))
                        <a href="{{ $contact_info->instagram_url }}" target="_blank" rel="noopener" aria-label="انستجرام">
                            <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    @endif
                    @if(!empty($contact_info->tiktok_url))
                        <a href="{{ $contact_info->tiktok_url }}" target="_blank" rel="noopener" aria-label="تيك توك">
                            <svg viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5.8 20.1a6.34 6.34 0 0 0 10.86-4.43V8.74a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1.84-.17z"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <div>
                <h4>{{ app()->getLocale() == 'ar' ? 'روابط سريعة' : 'Quick links' }}</h4>
                <ul>
                    <li><a href="{{ route('shaleek.home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                    <li><a href="{{ route('showAllChalet') }}">{{ app()->getLocale() == 'ar' ? 'جميع العقارات' : 'All Properties' }}</a></li>
                    <li><a href="{{ route('about_us') }}">{{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}</a></li>
                    <li><a href="{{ route('all-posts') }}">{{ app()->getLocale() == 'ar' ? 'المدونة' : 'Blog' }}</a></li>
                    <li><a href="{{ route('contact_us') }}">{{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}</a></li>
                </ul>
            </div>

            <div>
                <h4>{{ app()->getLocale() == 'ar' ? 'المعلومات' : 'Information' }}</h4>
                <ul>
                    <li><a href="{{ route('terms') }}">{{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms and Conditions' }}</a></li>
                    <li><a href="{{ route('page', ['slug' => 'privacy-policy']) }}">{{ app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</a></li>
                    <li><a href="{{ route('contact_us') }}#faqAccordion">{{ app()->getLocale() == 'ar' ? 'الأسئلة الشائعة' : 'FAQ' }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl('/owner/login') }}">{{ app()->getLocale() == 'ar' ? 'بوابة المضيف' : 'Host Portal' }}</a></li>
                    @auth('customer')
                        <li><a href="{{ route('account.orders') }}">{{ app()->getLocale() == 'ar' ? 'حسابي' : 'My Account' }}</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4>{{ app()->getLocale() == 'ar' ? 'تواصل معنا' : 'Contact Us' }}</h4>
                <ul>
                    @if(!empty($contact_info->whatsapp))
                        <li><a href="https://wa.me/{{ preg_replace('/\D+/', '', $contact_info->whatsapp) }}" target="_blank" rel="noopener" style="direction: ltr; display: inline-block;">{{ app()->getLocale() == 'ar' ? 'واتساب: ' : 'WhatsApp: ' }}{{ $contact_info->whatsapp }}</a></li>
                    @endif
                    <li><a href="mailto:info@shaleekoman.com">info@shaleekoman.com</a></li>
                </ul>
            </div>
        </div>

        <div class="shaleek-footer-bottom">
            <div class="shaleek-footer-maroof">{{ app()->getLocale() == 'ar' ? 'تصريح وزارة التجارة (معروف): 609' : 'Ministry of Commerce License (Maroof): 609' }}</div>
            <div>
                @if(app()->getLocale() == 'ar')
                    جميع الحقوق محفوظة © {{ date('Y') }} {{ $siteName ?? 'شاليك' }} — منصة حجز الشاليهات والمزارع والاستراحات وقاعات الأفراح في سلطنة عُمان
                @else
                    All rights reserved © {{ date('Y') }} {{ $siteName ?? 'Shaleek' }} — a booking platform for chalets, farms, rest houses and wedding halls in Oman
                @endif
            </div>
            @if(!auth('customer')->check() && !auth('owner')->check())
                <div style="margin-top: 10px;">
                    <a href="{{ LaravelLocalization::localizeUrl('/login') }}" style="opacity: 1; color: var(--gold-400); font-weight: 700;">
                        {{ app()->getLocale() == 'ar' ? 'تسجيل دخول أو إنشاء حساب جديد' : 'Sign in or create a new account' }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</footer>
