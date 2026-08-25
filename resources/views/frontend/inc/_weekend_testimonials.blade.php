@php
    $isArabic = app()->getLocale() == 'ar';
@endphp

<!-- Testimonials Section -->
<section class="testimonials-section py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3" style="color: #127664;">
                {{ $isArabic ? 'آراء عملائنا' : 'What Our Customers Say' }}
            </h2>
            <p class="text-muted">
                {{ $isArabic ? 'تجارب حقيقية من عملائنا السعداء' : 'Real experiences from our happy customers' }}
            </p>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="swiper testimonials-swiper">
                    <div class="swiper-wrapper">
                        <!-- Testimonial 1 -->
                        <div class="swiper-slide">
                            <div class="testimonial-card bg-white p-4 rounded-3 h-100">
                                <div class="mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-3">
                                    {{ $isArabic ? 'تجربة رائعة! الشاليه كان نظيف ومرتب والخدمة ممتازة. بالتأكيد سأعرض مرة أخرى.' : 'Amazing experience! The chalet was clean and tidy and the service was excellent. I will definitely book again.' }}
                                </p>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3" style="width: 50px; height: 50px; background: #127664; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <span>{{ $isArabic ? 'أ.م' : 'A.M' }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $isArabic ? 'أحمد محمد' : 'Ahmed Mohammed' }}</h6>
                                        <small class="text-muted">{{ $isArabic ? 'عميل منذ 2023' : 'Customer since 2023' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 2 -->
                        <div class="swiper-slide">
                            <div class="testimonial-card bg-white p-4 rounded-3 h-100">
                                <div class="mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-3">
                                    {{ $isArabic ? 'موقع سهل الاستخدام وعرض سريع. الأسعار منافسة والخيارات متنوعة.' : 'Easy to use website and quick booking. Competitive prices and diverse options.' }}
                                </p>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3" style="width: 50px; height: 50px; background: #127664; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <span>{{ $isArabic ? 'ف.س' : 'F.S' }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $isArabic ? 'فاطمة سالم' : 'Fatima Salem' }}</h6>
                                        <small class="text-muted">{{ $isArabic ? 'عميل منذ 2022' : 'Customer since 2022' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 3 -->
                        <div class="swiper-slide">
                            <div class="testimonial-card bg-white p-4 rounded-3 h-100">
                                <div class="mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                </div>
                                <p class="mb-3">
                                    {{ $isArabic ? 'خدمة العملاء ممتازة وسريعة الاستجابة. الشاليهات نظيفة ومجهزة بكل شيء.' : 'Excellent customer service and quick response. The chalets are clean and equipped with everything.' }}
                                </p>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3" style="width: 50px; height: 50px; background: #127664; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <span>{{ $isArabic ? 'خ.ع' : 'K.A' }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $isArabic ? 'خالد العمري' : 'Khalid Al-Omari' }}</h6>
                                        <small class="text-muted">{{ $isArabic ? 'عميل منذ 2023' : 'Customer since 2023' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 4 -->
                        <div class="swiper-slide">
                            <div class="testimonial-card bg-white p-4 rounded-3 h-100">
                                <div class="mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-3">
                                    {{ $isArabic ? 'أفضل موقع لعرض الشاليهات في عمان. الصور حقيقية والوصف دقيق.' : 'Best website for booking chalets in Oman. Real photos and accurate description.' }}
                                </p>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3" style="width: 50px; height: 50px; background: #127664; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <span>{{ $isArabic ? 'م.ح' : 'M.H' }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $isArabic ? 'مريم الحارثي' : 'Mariam Al-Harthi' }}</h6>
                                        <small class="text-muted">{{ $isArabic ? 'عميل منذ 2021' : 'Customer since 2021' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination mt-4"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.testimonial-card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s;
}

.testimonial-card:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}
</style>
