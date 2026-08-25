// ==========================================
// Excellence Learning - Main JavaScript
// ==========================================

// تحميل الصور من Unsplash API (صور احترافية مجانية)
const imageConfig = {
    logo: 'https://ui-avatars.com/api/?name=Excellence+Learning&background=1e3a8a&color=fff&size=200&bold=true&font-size=0.4',
    heroIllustration: 'https://img.freepik.com/free-vector/online-certification-illustration_23-2148575636.jpg?w=740',
    
    // شعارات المنظمات - دوائر ملونة
    acmpLogo: 'https://ui-avatars.com/api/?name=ACMP&background=1e3a8a&color=fff&size=160&bold=true&font-size=0.35&rounded=true',
    pmiLogo: 'https://ui-avatars.com/api/?name=PMI&background=2563eb&color=fff&size=160&bold=true&font-size=0.35&rounded=true',
    giniLogo: 'https://ui-avatars.com/api/?name=GInI&background=3b82f6&color=fff&size=160&bold=true&font-size=0.35&rounded=true',
    aspLogo: 'https://ui-avatars.com/api/?name=ASP&background=60a5fa&color=fff&size=160&bold=true&font-size=0.35&rounded=true',
    
    // صور المتدربين
    avatar1: 'https://randomuser.me/api/portraits/men/32.jpg',
    avatar2: 'https://randomuser.me/api/portraits/women/44.jpg',
    avatar3: 'https://randomuser.me/api/portraits/men/52.jpg',
};

// تطبيق الصور عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    // تطبيق اللوجو
    const logoImg = document.querySelector('.logo img');
    if (logoImg) {
        logoImg.src = imageConfig.logo;
        logoImg.alt = 'Excellence Learning';
    }
    
    // تطبيق صورة Hero
    const heroImg = document.querySelector('.hero-image img');
    if (heroImg) {
        heroImg.src = imageConfig.heroIllustration;
        heroImg.alt = 'التدريب الاحترافي';
    }
    
    // تطبيق شعارات المنظمات
    const certLogos = document.querySelectorAll('.cert-logo img');
    if (certLogos.length >= 4) {
        certLogos[0].src = imageConfig.acmpLogo;
        certLogos[1].src = imageConfig.pmiLogo;
        certLogos[2].src = imageConfig.giniLogo;
        certLogos[3].src = imageConfig.aspLogo;
    }
    
    // تطبيق صور المتدربين
    const avatars = document.querySelectorAll('.testimonial-author img');
    if (avatars.length >= 3) {
        avatars[0].src = imageConfig.avatar1;
        avatars[1].src = imageConfig.avatar2;
        avatars[2].src = imageConfig.avatar3;
    }
    
    // تفعيل القائمة على الموبايل
    setupMobileMenu();
    
    // تفعيل الأنيميشن عند السكرول
    setupScrollAnimations();
    
    // تفعيل عداد الإحصائيات
    setupCounters();
});

// ==========================================
// Mobile Menu
// ==========================================
function setupMobileMenu() {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            
            // تغيير الأيقونة
            const icon = this.querySelector('i');
            if (navMenu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
        
        // إغلاق القائمة عند النقر على رابط
        const navLinks = navMenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                const icon = menuToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            });
        });
    }
}

// ==========================================
// Scroll Animations
// ==========================================
function setupScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // مراقبة العناصر
    const animatedElements = document.querySelectorAll('.program-card, .feature-card, .testimonial-card');
    animatedElements.forEach(el => {
        observer.observe(el);
    });
}

// ==========================================
// Counter Animation
// ==========================================
function setupCounters() {
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200; // سرعة العد
    
    const observerOptions = {
        threshold: 0.5
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.textContent.replace(/\D/g, ''));
                const increment = target / speed;
                let current = 0;
                
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.ceil(current).toLocaleString('ar-SA');
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = counter.textContent; // الاحتفاظ بالنص الأصلي (مع + أو %)
                    }
                };
                
                updateCounter();
                observer.unobserve(counter);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
}

// ==========================================
// Language Toggle
// ==========================================
const langToggle = document.querySelector('.lang-toggle');
if (langToggle) {
    langToggle.addEventListener('click', function() {
        const html = document.documentElement;
        const currentLang = html.getAttribute('lang');
        
        if (currentLang === 'ar') {
            html.setAttribute('lang', 'en');
            html.setAttribute('dir', 'ltr');
            this.textContent = 'AR';
            // هنا يمكن تحميل النصوص الإنجليزية
        } else {
            html.setAttribute('lang', 'ar');
            html.setAttribute('dir', 'rtl');
            this.textContent = 'EN';
            // هنا يمكن تحميل النصوص العربية
        }
    });
}

// ==========================================
// Smooth Scroll
// ==========================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ==========================================
// Sticky Header on Scroll
// ==========================================
let lastScroll = 0;
const header = document.querySelector('.header');

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
    
    lastScroll = currentScroll;
});

// ==========================================
// Form Validation (للصفحات الأخرى)
// ==========================================
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('error');
                showError(input, 'هذا الحقل مطلوب');
            } else {
                input.classList.remove('error');
                removeError(input);
            }
            
            // التحقق من البريد الإلكتروني
            if (input.type === 'email' && input.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value)) {
                    isValid = false;
                    input.classList.add('error');
                    showError(input, 'البريد الإلكتروني غير صحيح');
                }
            }
            
            // التحقق من رقم الجوال
            if (input.type === 'tel' && input.value) {
                const phoneRegex = /^(05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/;
                if (!phoneRegex.test(input.value.replace(/\s/g, ''))) {
                    isValid = false;
                    input.classList.add('error');
                    showError(input, 'رقم الجوال غير صحيح');
                }
            }
        });
        
        if (isValid) {
            // إرسال النموذج
            submitForm(form);
        }
    });
    
    // إزالة الخطأ عند الكتابة
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('error');
            removeError(this);
        });
    });
}

function showError(input, message) {
    removeError(input);
    const error = document.createElement('div');
    error.className = 'error-message';
    error.textContent = message;
    input.parentElement.appendChild(error);
}

function removeError(input) {
    const error = input.parentElement.querySelector('.error-message');
    if (error) {
        error.remove();
    }
}

function submitForm(form) {
    // عرض رسالة تحميل
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';
    
    // محاكاة إرسال البيانات
    setTimeout(() => {
        // إظهار رسالة نجاح
        showSuccessMessage('تم إرسال طلبك بنجاح! سنتواصل معك قريباً.');
        form.reset();
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }, 2000);
}

function showSuccessMessage(message) {
    const alert = document.createElement('div');
    alert.className = 'success-alert';
    alert.innerHTML = `
        <i class="fas fa-check-circle"></i>
        <span>${message}</span>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        alert.classList.remove('show');
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

// ==========================================
// WhatsApp Button (زر واتساب عائم)
// ==========================================
function addWhatsAppButton() {
    const whatsappBtn = document.createElement('a');
    whatsappBtn.href = 'https://wa.me/966550994669?text=مرحباً، أريد الاستفسار عن البرامج التدريبية';
    whatsappBtn.target = '_blank';
    whatsappBtn.className = 'whatsapp-float';
    whatsappBtn.innerHTML = '<i class="fab fa-whatsapp"></i>';
    document.body.appendChild(whatsappBtn);
}

// تفعيل زر الواتساب
addWhatsAppButton();

// ==========================================
// Loading Screen
// ==========================================
window.addEventListener('load', function() {
    const loader = document.querySelector('.page-loader');
    if (loader) {
        setTimeout(() => {
            loader.classList.add('fade-out');
            setTimeout(() => loader.remove(), 500);
        }, 500);
    }
});

// ==========================================
// Print Styles Helper
// ==========================================
function printPage() {
    window.print();
}

// ==========================================
// Copy to Clipboard
// ==========================================
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showSuccessMessage('تم النسخ بنجاح!');
    });
}

// ==========================================
// Share on Social Media
// ==========================================
function shareOnSocial(platform, url, text) {
    const shareUrls = {
        twitter: `https://twitter.com/intent/tweet?url=${url}&text=${text}`,
        facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
        linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${url}`,
        whatsapp: `https://wa.me/?text=${text} ${url}`
    };
    
    if (shareUrls[platform]) {
        window.open(shareUrls[platform], '_blank', 'width=600,height=400');
    }
}

// ==========================================
// Console Message
// ==========================================
console.log('%c🎓 Excellence Learning', 'color: #1e3a8a; font-size: 24px; font-weight: bold;');
console.log('%cمنصة التدريب الاحترافي الأولى في المملكة', 'color: #f97316; font-size: 14px;');
console.log('%c📞 للاستفسار: 920011271', 'color: #10b981; font-size: 12px;');
