<!-- Link Footer CSS -->
<link rel="stylesheet" href="{{ asset('frontend/css/footer-styles.css') }}">

<!-- Footer Section -->
<footer class="footer-section">
    <div class="footer-content">
        <!-- Logo and Description -->
        <div class="footer-brand">
            <div class="footer-logo">
                <img src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" alt="{{ $siteName ?? 'shaleek' }}">
            </div>
            <p class="footer-description">
                @if($siteSettings && $siteSettings->site_description)
                    {{ $siteSettings->site_description }}
                @else
                    {{ app()->getLocale() == 'ar' ? 'جاهز للاسترخاء؟' : 'Ready to unwind?' }}<br>
                    {{ app()->getLocale() == 'ar' ? 'أخبرنا أين' : 'Tell us where you' }}<br> 
                    {{ app()->getLocale() == 'ar' ? 'تريد أن تذهب!' : 'want to go!' }}
                @endif
            </p>
        </div>

        <!-- Footer Links -->
        <div class="footer-links">
            <!-- Quick Links Column -->
            <div class="footer-column">
                <h4 class="footer-column-title">{{ app()->getLocale() == 'ar' ? 'روابط سريعة' : 'Quick links' }}</h4>
                <ul class="footer-menu">
                    <li><a href="{{ route('shaleek.home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                    <li><a href="{{ route('showAllChalet') }}">{{ app()->getLocale() == 'ar' ? 'جميع الشاليهات' : 'All Chalets' }}</a></li>
                    <li><a href="{{ route('about_us') }}">{{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}</a></li>
                    <li><a href="{{ route('all-posts') }}">{{ app()->getLocale() == 'ar' ? 'المدونة' : 'Blog' }}</a></li>
                    <li><a href="{{ route('contact_us') }}">{{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}</a></li>
                </ul>
            </div>

            <!-- Details Column -->
            <div class="footer-column">
                <h4 class="footer-column-title">{{ app()->getLocale() == 'ar' ? 'التفاصيل' : 'Details' }}</h4>
                <ul class="footer-menu">
                    <li><a href="{{ route('terms') }}">{{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms and Conditions' }}</a></li>
                    <li><a href="{{ route('contact_us') }}#faqAccordion">{{ app()->getLocale() == 'ar' ? 'الأسئلة الشائعة' : 'FAQ' }}</a></li>
                    <li><a href="{{ route('owner.login') }}">{{ app()->getLocale() == 'ar' ? 'بوابة المضيف' : 'Host Portal' }}</a></li>
                    @auth('customer')
                    <li><a href="{{ route('user-index.index') }}">{{ app()->getLocale() == 'ar' ? 'حسابي' : 'My Account' }}</a></li>
                    @endauth
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="footer-column">
                <h4 class="footer-column-title">{{ app()->getLocale() == 'ar' ? 'تواصل معنا!' : 'Get us!' }}</h4>
                <div class="contact-info">
                    <a href="{{ route('contact_us') }}" class="btn btn-sm mb-2" style="background: #127664; color: white; border-radius: 18px; padding: 6px 16px; font-size: 0.85rem; border: 1px solid #127664; transition: all 0.3s ease;">
                        <i class="fas fa-envelope me-2"></i>
                        {{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}
                    </a>
                    @if(!empty($contact_info->phone))
                    <div class="phone-wrapper d-flex align-items-center justify-content-center mb-3">
                        <i class="fas fa-phone" style="color: #127664; font-size: 0.9rem; {{ app()->getLocale() == 'ar' ? 'margin-left: 8px;' : 'margin-right: 8px;' }}"></i>
                        <span class="phone-number" style="direction: ltr;">{{ $contact_info->phone }}</span>
                    </div>
                    @endif
                    <div class="social-media">
                        @if(!empty($contact_info->whatsapp))
                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', $contact_info->whatsapp) }}" class="social-link" target="_blank" rel="noopener">
                            <svg width="20" height="20" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.34509 12.9187C5.34509 14.3638 5.75134 15.7741 6.51741 16.9871L6.69732 17.2772L5.92545 20.0978L8.82143 19.3375L9.1 19.5058C10.2723 20.2022 11.6187 20.5737 12.9942 20.5737H13C17.2134 20.5737 20.7362 17.1437 20.7362 12.9246C20.7362 10.8817 19.854 8.96071 18.4089 7.51562C16.958 6.06473 15.0429 5.26964 13 5.26964C8.7808 5.26964 5.35089 8.69955 5.34509 12.9187ZM15.9482 17.2946C15.217 17.4049 14.6482 17.3469 13.1915 16.7201C11.0558 15.7973 9.60491 13.7312 9.30893 13.3134C9.28571 13.2786 9.2683 13.2612 9.2625 13.2496C9.14643 13.0987 8.32232 12.0018 8.32232 10.8701C8.32232 9.80223 8.84464 9.25089 9.08839 8.99554C9.1058 8.97812 9.11741 8.96652 9.12902 8.94911C9.33795 8.71696 9.5875 8.65893 9.7442 8.65893C9.89509 8.65893 10.0518 8.65893 10.1853 8.66473H10.2317C10.3652 8.66473 10.5335 8.66473 10.7018 9.05937C10.7714 9.22768 10.8759 9.48304 10.9862 9.7442C11.1777 10.2085 11.375 10.6902 11.4098 10.7656C11.4679 10.8817 11.5085 11.0152 11.4272 11.1661C11.2299 11.5607 11.0268 11.7696 10.8875 11.9205C10.7076 12.1062 10.6263 12.1933 10.754 12.4196C11.642 13.946 12.5299 14.4741 13.8821 15.1531C14.1143 15.2692 14.2478 15.2518 14.3812 15.0951C14.5147 14.9442 14.9558 14.4219 15.1067 14.1955C15.2576 13.9634 15.4143 14.004 15.6232 14.0795C15.8321 14.1549 16.9638 14.7121 17.196 14.8281C17.2424 14.8513 17.283 14.8687 17.3179 14.8862C17.4804 14.9674 17.5906 15.0196 17.6371 15.0951C17.6893 15.2054 17.6893 15.6696 17.4978 16.2036C17.3062 16.7433 16.3893 17.2308 15.9482 17.2946ZM26 3.71429C26 1.66562 24.3344 0 22.2857 0H3.71429C1.66562 0 0 1.66562 0 3.71429V22.2857C0 24.3344 1.66562 26 3.71429 26H22.2857C24.3344 26 26 24.3344 26 22.2857V3.71429ZM8.59509 21.0031L3.71429 22.2857L5.02009 17.5152C4.21339 16.1223 3.78973 14.5379 3.78973 12.9129C3.79554 7.84062 7.92187 3.71429 12.9942 3.71429C15.4549 3.71429 17.7647 4.67188 19.5058 6.41295C21.2411 8.15402 22.2857 10.4638 22.2857 12.9246C22.2857 17.9969 18.0665 22.1232 12.9942 22.1232C11.4504 22.1232 9.93527 21.746 8.59509 21.0031Z" fill="#159265"/>
                            </svg>
                        </a>
                        @endif
                        @if(!empty($contact_info->instagram_url))
                        <a href="{{ $contact_info->instagram_url }}" class="social-link" target="_blank" rel="noopener">
                            <svg width="20" height="20" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_16_568)">
                                <path d="M13.0001 8.6665C11.8508 8.6665 10.7486 9.12305 9.93595 9.93571C9.12329 10.7484 8.66675 11.8506 8.66675 12.9998C8.66675 14.1491 9.12329 15.2513 9.93595 16.064C10.7486 16.8766 11.8508 17.3332 13.0001 17.3332C14.1494 17.3332 15.2516 16.8766 16.0642 16.064C16.8769 15.2513 17.3334 14.1491 17.3334 12.9998C17.3334 11.8506 16.8769 10.7484 16.0642 9.93571C15.2516 9.12305 14.1494 8.6665 13.0001 8.6665Z" fill="#159265"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.8 0C5.73131 0 3.74735 0.821783 2.28457 2.28457C0.821783 3.74735 0 5.73131 0 7.8L0 18.2C0 20.2687 0.821783 22.2526 2.28457 23.7154C3.74735 25.1782 5.73131 26 7.8 26H18.2C20.2687 26 22.2526 25.1782 23.7154 23.7154C25.1782 22.2526 26 20.2687 26 18.2V7.8C26 5.73131 25.1782 3.74735 23.7154 2.28457C22.2526 0.821783 20.2687 0 18.2 0L7.8 0ZM6.93333 13C6.93333 11.391 7.5725 9.84794 8.71022 8.71022C9.84794 7.5725 11.391 6.93333 13 6.93333C14.609 6.93333 16.1521 7.5725 17.2898 8.71022C18.4275 9.84794 19.0667 11.391 19.0667 13C19.0667 14.609 18.4275 16.1521 17.2898 17.2898C16.1521 18.4275 14.609 19.0667 13 19.0667C11.391 19.0667 9.84794 18.4275 8.71022 17.2898C7.5725 16.1521 6.93333 14.609 6.93333 13ZM19.0667 6.93333H20.8V5.2H19.0667V6.93333Z" fill="#159265"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_16_568">
                                <rect width="20" height="20" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </a>
                        @endif
                        @if(!empty($contact_info->tiktok_url))
                        <a href="{{ $contact_info->tiktok_url }}" class="social-link" target="_blank" rel="noopener">
                            <svg width="20" height="20" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.72727 0C3.47352 0 2.27112 0.498051 1.38459 1.38459C0.498051 2.27112 0 3.47352 0 4.72727V21.2727C0 22.5265 0.498051 23.7289 1.38459 24.6154C2.27112 25.5019 3.47352 26 4.72727 26H21.2727C22.5265 26 23.7289 25.5019 24.6154 24.6154C25.5019 23.7289 26 22.5265 26 21.2727V4.72727C26 3.47352 25.5019 2.27112 24.6154 1.38459C23.7289 0.498051 22.5265 0 21.2727 0H4.72727ZM4.33255 4.13636C4.20317 4.18444 4.08682 4.26207 3.99274 4.36306C3.89867 4.46405 3.82948 4.58561 3.79069 4.71806C3.75189 4.85052 3.74456 4.9902 3.76929 5.12598C3.79401 5.26177 3.8501 5.3899 3.93309 5.50018L10.5678 14.3047L3.57736 21.8034L3.52536 21.8636H5.94455L11.6527 15.743L16.0396 21.567C16.1414 21.7018 16.2796 21.8047 16.4379 21.8636H21.6639C21.7931 21.8153 21.9092 21.7375 22.003 21.6364C22.0968 21.5353 22.1658 21.4137 22.2043 21.2813C22.2429 21.1488 22.25 21.0092 22.2251 20.8736C22.2002 20.7379 22.144 20.6099 22.061 20.4998L15.4263 11.6953L22.4746 4.13636H20.0519L14.3437 10.2582L9.95445 4.43418C9.85284 4.29894 9.71464 4.1956 9.55618 4.13636H4.33255ZM17.1907 20.1476L6.41845 5.85236H8.80454L19.5756 20.1465L17.1907 20.1476Z" fill="#159265"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>

<!-- Maroof Logo & Text -->
<div class="d-flex align-items-center gap-2 mt-3">
   // <a href="https://maroof.sa/Business/Details/609" target="_blank" rel="noopener" class="d-flex align-items-center gap-2">
        <img src="{{ asset('frontend/images/maroof.png') }}"
             alt="تصريح وزارة التجارة معروف"
             style="width: 160px; height:auto;">

        <span style="font-size: 15px; font-weight: 550;">
            تصريح وزارة التجارة (معروف): 609
        </span>
    </a>
</div>


            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="footer-bottom-content">
            @if(!auth('customer')->check() && !auth('owner')->check())
            <div class="auth-links">
                <a href="{{ route('login') }}" class="auth-link btn btn-outline-success color-green-primary fw-bold d-flex border-radius-20 py-2 align-items-center gap-3 border-width-2">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.6801 15.12L14.2401 12.56L11.6801 10" stroke="#127664" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 12.5601H14.17" stroke="#127664" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 4.5C16.42 4.5 20 7.5 20 12.5C20 17.5 16.42 20.5 12 20.5" stroke="#127664" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ app()->getLocale() == 'ar' ? 'تسجيل دخول أو إنشاء حساب جديد' : 'Signin or create new account' }}</span>
                </a>
            </div>
            @endif
            <div class="copyright">
                <span><span class="text-secondary">{{ app()->getLocale() == 'ar' ? 'جميع الحقوق محفوظة © 2025' : 'All rights reserved © 2025' }}</span> <span class="text-dark">Shaleek Oman</span> <span class="text-secondary">، منصة عرض الشاليهات والمزارع والاستراحات والأكواخ ، لا نوفر خدمة حجوزات ، لسنا مسؤولين عن الحجوزات</span></span>
            </div>
        </div>
    </div>
</footer>

</main>

<!-- Footer Scripts -->
<script src="{{ asset('frontend/js/footer-mobile.js') }}"></script>
