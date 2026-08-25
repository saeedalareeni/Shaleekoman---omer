@extends('frontend.layouts.weekend_master')

@php
    $locale = app()->getLocale();
    $isRtl = $locale === 'ar';
    $pageTitle = $isRtl ? $page->name_ar : $page->name_en;
    $pageBody = $isRtl ? $page->body_ar : $page->body_en;
    $isPrivacyPolicy = $page->slug === 'privacy-policy';
    $pageKicker = $isPrivacyPolicy
        ? ($isRtl ? 'حماية بياناتك' : 'Your Data Protection')
        : ($isRtl ? 'محتوى توضيحي' : 'Information Page');
    $pageSubtitle = $isPrivacyPolicy
        ? ($isRtl
            ? 'تعرف على كيفية جمع بياناتك واستخدامها وحمايتها أثناء استخدامك للمنصة.'
            : 'Learn how your information is collected, used, and protected while using the platform.')
        : ($isRtl
            ? 'نضع لك كل التفاصيل المهمة في تنسيق واضح وسهل القراءة.'
            : 'We present all important details in a clean and easy-to-read layout.');
    $pageIntro = $isPrivacyPolicy
        ? ($isRtl
            ? 'تم تحسين تنسيق هذه الصفحة لتكون أوضح في قراءة البنود والعناوين والقوائم.'
            : 'This page is formatted for clearer reading of policy sections, headings, and lists.')
        : ($isRtl
            ? 'يمكنك مراجعة محتوى الصفحة بالكامل من خلال الأقسام التالية.'
            : 'You can review the full page content in the sections below.');
@endphp

@section('page_title')
    {{ $pageTitle }}
@endsection

@section('meta_keywords')
    {{ $isRtl ? $page->meta_keywords_ar : $page->meta_keywords_en }}
@endsection

@section('meta_description')
    {{ $isRtl ? $page->meta_description_ar : $page->meta_description_en }}
@endsection

@section('css')
    <style>
        .info-page {
            padding: 32px 0 72px;
            background:
                radial-gradient(circle at top, rgba(18, 118, 100, 0.08), transparent 34%),
                linear-gradient(180deg, #f7fbfa 0%, #ffffff 38%);
        }

        .info-page-hero {
            background: linear-gradient(135deg, #127664 0%, #0d5d4f 100%);
            color: #fff;
            border-radius: 28px;
            padding: 36px 40px;
            box-shadow: 0 24px 60px rgba(18, 118, 100, 0.18);
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .info-page-hero::after {
            content: "";
            position: absolute;
            inset: auto -80px -90px auto;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .info-page-breadcrumb .breadcrumb {
            margin-bottom: 14px;
        }

        .info-page-breadcrumb .breadcrumb-item,
        .info-page-breadcrumb .breadcrumb-item a,
        .info-page-breadcrumb .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.88);
            font-size: 0.95rem;
        }

        .info-page-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.7);
        }

        .info-page-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
            font-weight: 700;
            font-size: 0.92rem;
            margin-bottom: 16px;
            backdrop-filter: blur(6px);
        }

        .info-page-title {
            margin: 0;
            font-size: clamp(2rem, 3vw, 3rem);
            font-weight: 800;
            line-height: 1.2;
        }

        .info-page-subtitle {
            margin: 14px 0 0;
            max-width: 760px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.04rem;
            line-height: 1.9;
        }

        .info-page-card {
            background: #fff;
            border: 1px solid rgba(18, 118, 100, 0.1);
            border-radius: 26px;
            box-shadow: 0 18px 45px rgba(16, 24, 40, 0.08);
            overflow: hidden;
        }

        .info-page-card-header {
            padding: 24px 28px;
            border-bottom: 1px solid #edf1f0;
            background: linear-gradient(180deg, rgba(18, 118, 100, 0.05), rgba(18, 118, 100, 0.015));
        }

        .info-page-card-header h2 {
            margin: 0;
            color: #127664;
            font-size: 1.45rem;
            font-weight: 800;
        }

        .info-page-card-header p {
            margin: 10px 0 0;
            color: #6b7280;
            line-height: 1.8;
        }

        .info-page-body {
            padding: 30px 32px 36px;
        }

        .info-page-body,
        .info-page-body * {
            max-width: 100%;
        }

        .info-page-body h1,
        .info-page-body h2,
        .info-page-body h3,
        .info-page-body h4,
        .info-page-body h5,
        .info-page-body h6 {
            color: #12312a;
            font-weight: 800;
            line-height: 1.45;
            margin-top: 1.65em;
            margin-bottom: 0.7em;
        }

        .info-page-body h1:first-child,
        .info-page-body h2:first-child,
        .info-page-body h3:first-child,
        .info-page-body h4:first-child,
        .info-page-body h5:first-child,
        .info-page-body h6:first-child,
        .info-page-body > p:first-child {
            margin-top: 0;
        }

        .info-page-body h2,
        .info-page-body h3 {
            color: #127664;
        }

        .info-page-body p,
        .info-page-body li,
        .info-page-body span,
        .info-page-body div {
            color: #49566a;
            line-height: 1.95;
            font-size: 1.03rem;
        }

        .info-page-body ul,
        .info-page-body ol {
            margin-bottom: 1.4rem;
            padding-inline-start: 1.35rem;
        }

        .info-page-body li {
            margin-bottom: 0.7rem;
        }

        .info-page-body a {
            color: #127664;
            font-weight: 700;
            text-decoration: none;
            word-break: break-word;
        }

        .info-page-body a:hover {
            color: #0d5d4f;
            text-decoration: underline;
        }

        .info-page-body strong,
        .info-page-body b {
            color: #12312a;
            font-weight: 800;
        }

        .info-page-body blockquote {
            margin: 1.6rem 0;
            padding: 18px 22px;
            background: #f8fbfa;
            border-radius: 18px;
            border-inline-start: 4px solid #127664;
        }

        .info-page-body table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            overflow: hidden;
            border-radius: 18px;
            display: block;
            overflow-x: auto;
        }

        .info-page-body table th,
        .info-page-body table td {
            padding: 14px 16px;
            border: 1px solid #e6ecea;
            text-align: start;
            vertical-align: top;
        }

        .info-page-body table th {
            background: #f2f8f6;
            color: #12312a;
            font-weight: 800;
        }

        .info-page-body img,
        .info-page-body iframe,
        .info-page-body video {
            width: auto;
            max-width: 100%;
            border-radius: 18px;
            height: auto;
        }

        .info-page-body hr {
            margin: 2rem 0;
            border: 0;
            border-top: 1px solid #e8eeec;
        }

        [dir="rtl"] .info-page-body,
        [dir="rtl"] .info-page-card-header,
        [dir="rtl"] .info-page-hero {
            text-align: right;
        }

        @media (max-width: 991.98px) {
            .info-page {
                padding: 20px 0 56px;
            }

            .info-page-hero {
                padding: 28px 22px;
                border-radius: 22px;
            }

            .info-page-card-header,
            .info-page-body {
                padding-inline: 22px;
            }
        }

        @media (max-width: 575.98px) {
            .info-page-title {
                font-size: 1.75rem;
            }

            .info-page-subtitle,
            .info-page-body p,
            .info-page-body li,
            .info-page-body span,
            .info-page-body div {
                font-size: 0.98rem;
            }
        }
    </style>
@endsection

@section('content')
    <section class="info-page">
        <div class="container">
            <div class="info-page-hero">
                <div class="info-page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">{{ __('back.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                        </ol>
                    </nav>
                </div>

                <span class="info-page-kicker">
                    <i class="fas {{ $isPrivacyPolicy ? 'fa-shield-halved' : 'fa-file-lines' }}"></i>
                    {{ $pageKicker }}
                </span>

                <h1 class="info-page-title">{{ $pageTitle }}</h1>
                <p class="info-page-subtitle">{{ $pageSubtitle }}</p>
            </div>

            <div class="info-page-card">
                <div class="info-page-card-header">
                    <h2>{{ $pageTitle }}</h2>
                    <p>{{ $pageIntro }}</p>
                </div>

                <div class="info-page-body">
                    {!! $pageBody !!}
                </div>
            </div>
        </div>
    </section>
@endsection
