@extends('frontend.layouts.weekend_master')

@section('page_title', app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us')

@section('css')
<style>
    @if(app()->getLocale() == 'ar')
    body, h1, h2, h3, h4, h5, h6, p, span, div, a, button, input, select, textarea, * {
        font-family: 'Tajawal', sans-serif !important;
    }
    @endif

    .contact-hero {
        background: linear-gradient(135deg, rgba(18, 118, 100, 0.95) 0%, rgba(18, 118, 100, 0.85) 100%),
                    url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1920&q=80') center/cover;
        min-height: 350px;
        display: flex;
        align-items: center;
        position: relative;
    }

    .contact-section {
        padding: 80px 0;
    }

    .contact-form-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #127664;
        box-shadow: 0 0 0 0.2rem rgba(18, 118, 100, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #127664, #159265);
        color: white;
        border: none;
        padding: 14px 40px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(18, 118, 100, 0.3);
        color: white;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .alert-success {
        animation: slideInDown 0.5s ease;
    }

    @keyframes checkmark {
        0% {
            transform: scale(0) rotate(45deg);
        }
        50% {
            transform: scale(1.2) rotate(45deg);
        }
        100% {
            transform: scale(1) rotate(45deg);
        }
    }

    .fa-check-circle {
        animation: checkmark 0.5s ease 0.3s;
    }

    @media (max-width: 768px) {
        .contact-hero {
            min-height: 250px;
        }

        .contact-hero h1 {
            font-size: 2rem !important;
        }

        .contact-section {
            padding: 50px 0;
        }

        .contact-form-card {
            padding: 25px;
        }
    }
</style>
@endsection

@section('content')

<section class="contact-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('shaleek.home') }}" class="text-white-50">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                        <li class="breadcrumb-item active text-white">{{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">{{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}</h1>
                <p class="lead text-white mb-0">{{ app()->getLocale() == 'ar' ? 'أرسل لنا رسالتك وسنقوم بالرد عليك في أقرب وقت ممكن.' : 'Send us your message and we will get back to you as soon as possible.' }}</p>
            </div>
        </div>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="contact-form-card">
                    <h3 class="mb-4">{{ app()->getLocale() == 'ar' ? 'أرسل لنا رسالة' : 'Send Us a Message' }}</h3>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); border: none; color: white;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div>
                                <strong>{{ app()->getLocale() == 'ar' ? 'تم الإرسال بنجاح!' : 'Successfully Sent!' }}</strong>
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('send_messages') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الاسم الأول' : 'First Name' }} *</label>
                                <input type="text" class="form-control" name="first_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الاسم الأخير' : 'Last Name' }} *</label>
                                <input type="text" class="form-control" name="last_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }} *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone Number' }}</label>
                                <input type="tel" class="form-control" name="phone">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الموضوع' : 'Subject' }} *</label>
                                <select class="form-select" name="subject" required>
                                    <option value="">{{ app()->getLocale() == 'ar' ? 'اختر الموضوع' : 'Select Subject' }}</option>
                                    <option value="general">{{ app()->getLocale() == 'ar' ? 'استفسار عام' : 'General Inquiry' }}</option>
                                    <option value="booking">{{ app()->getLocale() == 'ar' ? 'مشكلة في العرض' : 'Booking Issue' }}</option>
                                    <option value="payment">{{ app()->getLocale() == 'ar' ? 'مشكلة في الدفع' : 'Payment Issue' }}</option>
                                    <option value="complaint">{{ app()->getLocale() == 'ar' ? 'شكوى' : 'Complaint' }}</option>
                                    <option value="suggestion">{{ app()->getLocale() == 'ar' ? 'اقتراح' : 'Suggestion' }}</option>
                                    <option value="partnership">{{ app()->getLocale() == 'ar' ? 'شراكة' : 'Partnership' }}</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الرسالة' : 'Message' }} *</label>
                                <textarea class="form-control" name="message" rows="5" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-submit w-100">
                                    {{ app()->getLocale() == 'ar' ? 'إرسال الرسالة' : 'Send Message' }}
                                    <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';

                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }, 5000);
        }

        @if(session('success'))
        document.querySelector('form').reset();
        window.scrollTo({
            top: document.querySelector('.contact-form-card').offsetTop - 100,
            behavior: 'smooth'
        });

        Swal.fire({
            icon: 'success',
            title: '{{ app()->getLocale() == "ar" ? "تم الإرسال بنجاح!" : "Successfully Sent!" }}',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        @endif
    });

    document.querySelector('form').addEventListener('submit', function() {
        const submitBtn = this.querySelector('.btn-submit');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' +
            ('{{ app()->getLocale() }}' === 'ar' ? 'جاري الإرسال...' : 'Sending...');
        submitBtn.disabled = true;
    });
</script>
@endsection
