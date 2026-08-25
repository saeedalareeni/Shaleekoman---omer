<style>
    /* ساعة عمان الكاملة - نسخة موسطة بهوامش ضيقة */
    .oman-clock-full {
        background: linear-gradient(135deg, #159265 0%, #0d6e47 100%);
        border-radius: 12px;
        padding: 10px 20px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: 'Segoe UI', 'Cairo', sans-serif;
        box-shadow: 0 5px 15px rgba(21, 146, 101, 0.3);
        margin: 0 auto;
        width: 100%;
        max-width: 350px;
    }

    .oman-clock-icon {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .oman-clock-icon i {
        font-size: 20px;
    }

    .oman-clock-icon span {
        font-size: 14px;
        font-weight: 600;
    }

    .oman-clock-display {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .oman-time {
        font-size: 24px;
        font-weight: 700;
        letter-spacing: 1px;
        direction: ltr;
        line-height: 1.2;
    }

    .oman-date {
        font-size: 12px;
        opacity: 0.9;
        margin-top: 3px;
    }

    .colon-blink {
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    /* حاوية التوسيط مع مسافة من الأعلى */
    .clock-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin-top: 30px;  /* مسافة من الأعلى */
        margin-bottom: 25px;
    }

    @media (max-width: 768px) {
        .clock-wrapper {
            margin-top: 25px;  /* مسافة أقل للجوال */
            margin-bottom: 20px;
        }
        
        .oman-clock-full {
            padding: 8px 16px;
            max-width: 380px;
        }
        
        .oman-time {
            font-size: 22px;
        }
        
        .oman-date {
            font-size: 11px;
        }
        
        .oman-clock-icon i {
            font-size: 18px;
        }
        
        .oman-clock-icon span {
            font-size: 13px;
        }
    }

    @media (max-width: 400px) {
        .clock-wrapper {
            margin-top: 20px;  /* مسافة أقل للشاشات الصغيرة */
            margin-bottom: 15px;
        }
        
        .oman-clock-full {
            padding: 8px 12px;
            max-width: 100%;
        }
        
        .oman-time {
            font-size: 20px;
        }
    }
</style>

<!-- حاوية التوسيط مع مسافة من الأعلى -->
<div class="clock-wrapper">
    <div class="oman-clock-full">
        <div class="oman-clock-icon">
            <i class="fas fa-clock"></i>
            <span>{{ app()->getLocale() == 'ar' ? 'توقيت سلطنة عمان' : 'Oman Time' }}</span>
        </div>
        <div class="oman-clock-display">
            <div class="oman-time" id="oman-clock">
                <span class="hours">00</span>
                <span class="colon-blink">:</span>
                <span class="minutes">00</span>
                <span class="colon-blink">:</span>
                <span class="seconds">00</span>
                <span class="ampm"></span>
            </div>
            <div class="oman-date" id="oman-date"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hoursSpan = document.querySelector('.oman-time .hours');
        const minutesSpan = document.querySelector('.oman-time .minutes');
        const secondsSpan = document.querySelector('.oman-time .seconds');
        const ampmSpan = document.querySelector('.oman-time .ampm');
        const dateElement = document.getElementById('oman-date');
        
        const daysArabic = ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
        const monthsArabic = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
        
        function updateOmanTime() {
            const now = new Date();
            const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            const omanTime = new Date(utc + (3600000 * 4));
            
            let hours = omanTime.getHours();
            const minutes = omanTime.getMinutes().toString().padStart(2, '0');
            const seconds = omanTime.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'م' : 'ص';
            
            if (hours > 12) hours = hours - 12;
            if (hours === 0) hours = 12;
            hours = hours.toString().padStart(2, '0');
            
            if (hoursSpan) hoursSpan.textContent = hours;
            if (minutesSpan) minutesSpan.textContent = minutes;
            if (secondsSpan) secondsSpan.textContent = seconds;
            if (ampmSpan) ampmSpan.textContent = ampm;
            
            if (dateElement) {
                const day = daysArabic[omanTime.getDay()];
                const date = omanTime.getDate();
                const month = monthsArabic[omanTime.getMonth()];
                const year = omanTime.getFullYear();
                dateElement.textContent = `${day}، ${date} ${month} ${year}`;
            }
            
            setTimeout(updateOmanTime, 1000);
        }
        
        if (hoursSpan && minutesSpan) {
            updateOmanTime();
        }
    });
</script>

<!-- Destinations Section -->
<section class="destinations-section">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">{{ app()->getLocale() == 'ar' ? 'مكانك المثالي، أينما كنت' : 'Home for you, wherever you go' }}</h2>
            <div class="d-flex gap-3">
                <button class="btn-circular-green destinations-prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn-circular-green-outline destinations-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
      
        <div class="swiper destinationsSwiper">
            <h3>{{ app()->getLocale() == 'ar' ? 'المحافظات' : 'Governorates' }}</h3>
            <div class="swiper-wrapper">

                @if(isset($destinations) && $destinations->count() > 0)
                    @foreach($destinations as $destination)
                        <div class="swiper-slide">
                            <a href="{{ route('city.details', ['slug' => $destination->slug ?? Str::slug($destination->name_en ?? $destination->name)]) }}" class="destination-link">
                                <div class="destination-card">
                                    <div class="destination-image">
                                        @if($destination->image)
                                            <img src="{{ asset($destination->image) }}" alt="{{ $destination->name }}">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1512632578888-169bbbc64f33?w=400&q=80" alt="{{ $destination->name }}">
                                        @endif
                                    </div>
                                    <h3 class="destination-name">{{ $destination->name }}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <!-- Default destinations if no data from database -->
                    @php
                        $defaultDestinations = [
                            ['name' => app()->getLocale() == 'ar' ? 'مسقط' : 'Muscat', 'image' => 'https://images.unsplash.com/photo-1512632578888-169bbbc64f33?w=400&q=80'],
                            ['name' => app()->getLocale() == 'ar' ? 'صلالة' : 'Salalah', 'image' => 'https://images.unsplash.com/photo-1539037116277-4db20889f2d4?w=400&q=80'],
                            ['name' => app()->getLocale() == 'ar' ? 'نزوى' : 'Nizwa', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=400&q=80'],
                            ['name' => app()->getLocale() == 'ar' ? 'صحار' : 'Sohar', 'image' => 'https://images.unsplash.com/photo-1572252009286-268acec5ca0a?w=400&q=80'],
                            ['name' => app()->getLocale() == 'ar' ? 'صور' : 'Sur', 'image' => 'https://images.unsplash.com/photo-1512632578888-169bbbc64f33?w=400&q=80'],
                            ['name' => app()->getLocale() == 'ar' ? 'البريمي' : 'Buraimi', 'image' => 'https://images.unsplash.com/photo-1539037116277-4db20889f2d4?w=400&q=80'],
                            ['name' => app()->getLocale() == 'ar' ? 'خصب' : 'Khasab', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=400&q=80'],
                            ['name' => app()->getLocale() == 'ar' ? 'بركاء' : 'Barka', 'image' => 'https://images.unsplash.com/photo-1572252009286-268acec5ca0a?w=400&q=80'],
                            ['name' => app()->getLocale() == 'ar' ? 'الرستاق' : 'Rustaq', 'image' => 'https://images.unsplash.com/photo-1512632578888-169bbbc64f33?w=400&q=80'],
                            ['name' => app()->getLocale() == 'ar' ? 'عبري' : 'Ibri', 'image' => 'https://images.unsplash.com/photo-1539037116277-4db20889f2d4?w=400&q=80'],
                        ];
                    @endphp
                    @foreach($defaultDestinations as $destination)
                        <div class="swiper-slide">
                            <div class="destination-card">
                                <div class="destination-image">
                                    <img src="{{ $destination['image'] }}" alt="{{ $destination['name'] }}">
                                </div>
                                <h3 class="destination-name">{{ $destination['name'] }}</h3>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>

