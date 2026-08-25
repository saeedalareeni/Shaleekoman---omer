@php
    $contact = \App\Models\Contact::first();
    $about = \App\Models\About::first();
    $locale = app()->getLocale();
@endphp

<style>
    .footer-wrapper {
        width: 100%;
        margin-top: 48px;
        padding: 40px 0 28px;
        background: linear-gradient(180deg, #ffffff 0%, #f7fbfa 100%);
        border-top: 1px solid #e6efec;
    }

    .footer-outer-container {
        display: none;
    }

    .footer-container {
        width: min(1120px, calc(100% - 24px));
        padding: 0;
    }

    .footer-logo {
        margin-bottom: 28px;
    }

    .footer-logo-image {
        width: min(180px, 42vw);
        max-width: 100%;
        height: auto;
        object-fit: contain;
    }

    .footer-title {
        margin-bottom: 14px;
        color: #127664;
        font-weight: 800;
    }

    .footer-links {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .footer-links a,
    .footer-links p {
        margin: 0;
        color: #5f6c7b;
        line-height: 1.8;
        text-decoration: none;
        word-break: break-word;
    }

    .footer-links a:hover {
        color: #127664;
    }

    .social-icons {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .social-icons a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef7f4;
        color: #127664;
        transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }

    .social-icons a:hover {
        background: #127664;
        color: #fff;
        transform: translateY(-2px);
    }

    @media (max-width: 767.98px) {
        .footer-wrapper {
            margin-top: 32px;
            padding: 32px 0 24px;
        }

        .footer-logo {
            margin-bottom: 20px;
        }

        .footer-logo-image {
            width: min(140px, 46vw);
        }

        .footer-title,
        .footer-links,
        .social-icons {
            text-align: center;
            justify-content: center;
        }
    }
</style>



<div class="footer-wrapper position-relative w-100">
    <div class="footer-outer-container"></div>
    <footer class="footer-container py-6 mx-auto">
        <div class="footer-logo text-center">
            @if($about)
                <img src="{{ asset(App\Models\Setting::first()->logo) }}" alt="{{ $locale == 'ar' ? $about->company_name_ar : $about->company_name_en }}" class="footer-logo-image">
            @endif
        </div>
        <div class="container">
            <div class="row text-center text-md-start mt-8 mt-md-10">

                <div class="col-md-4 mb-4">
                    <h3 class="footer-title fs-18"> {{ App::getLocale()== 'ar' ? $about->company_name_ar : $about->company_name_en }}</h3>
                    <div class="footer-links">
                        <p>
                            {{ App::getLocale()== 'ar' ? $about->about_ar : $about->about_en }}
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <h3 class="footer-title fs-18"> {{ __('back.quick_links') }}</h3>
                    <div class="footer-links">
                        <a href="{{ route('showAllChalet') }}"> {{ trans('back.offer_weekend') }} </a>
                        <a href="{{ route('about_us') }}">{{ __('back.about_us') }}</a>
                        <a href="{{ route('contact_us') }}">{{ __('back.contact_us') }}</a>
                        <a href="{{ route('all-posts') }}">{{ __('back.blog') }}</a>
                        <a href="{{ route('terms') }}">{{ __('back.terms') }}</a>
                        <a href="{{ route('page', ['slug' => 'privacy-policy']) }}">{{ __('back.privacy_policy') }}</a>
                        @foreach (App\Models\Page::where('status',1)->where('slug', '!=', 'privacy-policy')->get() as $page)
                            <a href="{{ route('page', ['slug' => $page->slug]) }}"> {{ App::getLocale()== 'ar' ? $page->name_ar : $page->name_en }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <h3 class="footer-title fs-18">{{ __('back.contact_us') }}</h3>

                    <div class="footer-links">
                        <a class="" href="mailto:{{ $contact->email}}"> {{ __('back.email') }} : {{ $contact->email }}</a>
                        @if(!empty($contact->phone))
                        <a class="" href="tel:{{ $contact->phone }}"> {{ __('back.phone') }} : {{ $contact->phone }}</a>
                        @endif
                        <a class=""> {{ __('back.address') }} : {{ App::getLocale()== 'ar' ? $contact->address_ar : $contact->address_en }}</a>
                    </div>

                    @if($contact)
                        <div class="social-icons">
                            @if($contact->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/\D+/', '', $contact->whatsapp) }}" class="whatsapp-icon" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a>
                            @endif
                            @if($contact->instagram_url)
                            <a href="{{ $contact->instagram_url}}" class="instagram-icon" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if($contact->tiktok_url)
                            <a href="{{ $contact->tiktok_url }}" class="tiktok-icon" target="_blank" rel="noopener"><i class="fab fa-tiktok"></i></a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </footer>
</div>
