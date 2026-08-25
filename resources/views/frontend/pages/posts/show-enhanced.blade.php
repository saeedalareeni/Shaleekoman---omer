@extends('frontend.layouts.weekend_master')

@php
    $locale = app()->getLocale();
    $title = $locale == 'ar' ? $post->title_ar : $post->title_en;
    $body = $locale == 'ar' ? $post->body_ar : $post->body_en;
    $meta_keywords = $locale == 'ar' ? ($post->meta_keywords_ar ?? $post->tags) : ($post->meta_keywords_en ?? $post->tags);
    $meta_description = $locale == 'ar' ? ($post->meta_description_ar ?? Str::limit(strip_tags($body), 160)) : ($post->meta_description_en ?? Str::limit(strip_tags($body), 160));
@endphp

@section('meta_keywords', $meta_keywords)
@section('meta_description', $meta_description)
@section('page_title', $title)

@section('css')
<style>
    /* Font Settings for Arabic */
    @if(app()->getLocale() == 'ar')
    body, h1, h2, h3, h4, h5, h6, p, span, div, a, button, input, select, textarea, * {
        font-family: 'Tajawal', sans-serif !important;
    }
    @endif
    
    /* Hero Section */
    .post-hero {
        background: linear-gradient(135deg, rgba(18, 118, 100, 0.95) 0%, rgba(18, 118, 100, 0.85) 100%), 
                    url('{{ $post->image ?? "https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=1920&q=80" }}') center/cover;
        min-height: 450px;
        display: flex;
        align-items: center;
        position: relative;
    }
    
    /* Content */
    .post-content {
        padding: 80px 0;
        background: #fff;
    }
    
    .article-content {
        font-size: 1.1rem;
        line-height: 1.9;
        color: #4a4a4a;
    }
    
    .article-content h2 {
        color: #2c3e50;
        font-size: 1.8rem;
        font-weight: 600;
        margin: 40px 0 20px;
        padding-bottom: 10px;
        border-bottom: 3px solid #127664;
        position: relative;
    }
    
    .article-content h3 {
        color: #34495e;
        font-size: 1.4rem;
        font-weight: 600;
        margin: 30px 0 15px;
    }
    
    .article-content p {
        margin-bottom: 20px;
        text-align: justify;
    }
    
    .article-content ul,
    .article-content ol {
        margin: 20px 0;
        padding-{{ $locale == 'ar' ? 'right' : 'left' }}: 30px;
    }
    
    .article-content li {
        margin-bottom: 10px;
        line-height: 1.8;
    }
    
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 20px 0;
    }
    
    .article-content blockquote {
        border-{{ $locale == 'ar' ? 'right' : 'left' }}: 4px solid #127664;
        padding: 20px;
        margin: 30px 0;
        background: #f8f9fa;
        font-style: italic;
    }
    
    /* Meta Info */
    .post-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 25px;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #6c757d;
        font-size: 15px;
    }
    
    .meta-item i {
        color: #127664;
        font-size: 18px;
    }
    
    /* Feature Image */
    .feature-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 20px;
        margin-bottom: 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    
    /* Share Buttons */
    .share-section {
        padding: 30px 0;
        border-top: 1px solid #e9ecef;
        margin-top: 50px;
    }
    
    .share-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #2c3e50;
    }
    
    .share-buttons {
        display: flex;
        gap: 10px;
    }
    
    .share-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .share-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .share-facebook { background: #1877f2; }
    .share-twitter { background: #1da1f2; }
    .share-whatsapp { background: #25d366; }
    .share-linkedin { background: #0077b5; }
    
    /* Tags */
    .tags-section {
        margin-top: 40px;
    }
    
    .tag {
        display: inline-block;
        padding: 6px 16px;
        background: #f0f2f5;
        color: #495057;
        border-radius: 20px;
        margin: 5px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .tag:hover {
        background: #127664;
        color: white;
    }
    
    /* Related Posts */
    .related-posts {
        padding: 80px 0;
        background: #f8f9fa;
    }
    
    .related-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }
    
    .related-image {
        height: 200px;
        width: 100%;
        object-fit: cover;
    }
    
    .related-content {
        padding: 20px;
    }
    
    .related-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    
    .related-excerpt {
        color: #6c757d;
        font-size: 14px;
        line-height: 1.6;
    }
    
    /* Navigation */
    .post-navigation {
        padding: 40px 0;
        border-top: 1px solid #e9ecef;
    }
    
    .nav-link-post {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .nav-link-post:hover {
        background: #127664;
        color: white;
    }
    
    .nav-link-post:hover * {
        color: white !important;
    }
    
    .nav-label {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .nav-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-top: 5px;
    }
    
    /* Sidebar */
    .sidebar-widget {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .widget-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #127664;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .post-hero {
            min-height: 300px;
        }
        
        .post-hero h1 {
            font-size: 1.8rem !important;
        }
        
        .post-content {
            padding: 50px 0;
        }
        
        .article-content {
            font-size: 1rem;
        }
        
        .article-content h2 {
            font-size: 1.5rem;
        }
        
        .article-content h3 {
            font-size: 1.2rem;
        }
        
        .feature-image {
            max-height: 300px;
        }
        
        .share-buttons {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')

<!-- Hero Section -->
<section class="post-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('shaleek.home') }}" class="text-white-50">{{ $locale == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('all-posts') }}" class="text-white-50">{{ $locale == 'ar' ? 'المدونة' : 'Blog' }}</a></li>
                        <li class="breadcrumb-item active text-white">{{ Str::limit($title, 30) }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">{{ $title }}</h1>
                <div class="d-flex flex-wrap gap-3 text-white-50">
                    <span><i class="far fa-calendar me-2"></i>{{ $post->created_at->format('d M, Y') }}</span>
                    <span><i class="far fa-user me-2"></i>{{ $locale == 'ar' ? 'شاليك عُمان' : 'Shaleek Oman' }}</span>
                    <span><i class="far fa-eye me-2"></i>{{ $post->views ?? rand(100, 500) }} {{ $locale == 'ar' ? 'مشاهدة' : 'views' }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="post-content">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Feature Image -->
                @if($post->image)
                <img src="{{ asset($post->image) }}" alt="{{ $title }}" class="feature-image">
                @endif
                
                <!-- Article Content -->
                <div class="article-content">
                    {!! $body !!}
                </div>
                
                <!-- Tags -->
                @if($post->tags)
                <div class="tags-section">
                    <span class="me-2"><i class="fas fa-tags"></i></span>
                    @foreach(explode(',', $post->tags) as $tag)
                    <span class="tag">{{ trim($tag) }}</span>
                    @endforeach
                </div>
                @endif
                
                <!-- Share Section -->
                <div class="share-section">
                    <h5 class="share-title">{{ $locale == 'ar' ? 'شارك هذا المقال' : 'Share this article' }}</h5>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                           target="_blank" class="share-btn share-facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($title) }}" 
                           target="_blank" class="share-btn share-twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($title . ' ' . request()->fullUrl()) }}" 
                           target="_blank" class="share-btn share-whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ urlencode($title) }}" 
                           target="_blank" class="share-btn share-linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Post Navigation -->
                @php
                    $prevPost = \App\Models\Post::where('id', '<', $post->id)->where('status', 1)->orderBy('id', 'desc')->first();
                    $nextPost = \App\Models\Post::where('id', '>', $post->id)->where('status', 1)->orderBy('id', 'asc')->first();
                @endphp
                
                @if($prevPost || $nextPost)
                <div class="post-navigation">
                    <div class="row">
                        @if($prevPost)
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('post_details', $prevPost->slug) }}" class="nav-link-post">
                                <i class="fas fa-arrow-{{ $locale == 'ar' ? 'right' : 'left' }} fa-2x text-muted"></i>
                                <div>
                                    <div class="nav-label">{{ $locale == 'ar' ? 'المقال السابق' : 'Previous Post' }}</div>
                                    <div class="nav-title">{{ $locale == 'ar' ? $prevPost->title_ar : $prevPost->title_en }}</div>
                                </div>
                            </a>
                        </div>
                        @endif
                        
                        @if($nextPost)
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('post_details', $nextPost->slug) }}" class="nav-link-post text-{{ $locale == 'ar' ? 'start' : 'end' }}">
                                <div>
                                    <div class="nav-label">{{ $locale == 'ar' ? 'المقال التالي' : 'Next Post' }}</div>
                                    <div class="nav-title">{{ $locale == 'ar' ? $nextPost->title_ar : $nextPost->title_en }}</div>
                                </div>
                                <i class="fas fa-arrow-{{ $locale == 'ar' ? 'left' : 'right' }} fa-2x text-muted"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Recent Posts Widget -->
                <div class="sidebar-widget">
                    <h4 class="widget-title">{{ $locale == 'ar' ? 'أحدث المقالات' : 'Recent Posts' }}</h4>
                    @php
                        $recentPosts = \App\Models\Post::where('status', 1)
                            ->where('id', '!=', $post->id)
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    @foreach($recentPosts as $recentPost)
                    <div class="d-flex mb-3">
                        <img src="{{ $recentPost->image ?? 'https://via.placeholder.com/80' }}" 
                             alt="{{ $locale == 'ar' ? $recentPost->title_ar : $recentPost->title_en }}"
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;">
                        <div class="ms-3">
                            <h6 class="mb-1">
                                <a href="{{ route('post_details', $recentPost->slug) }}" class="text-dark text-decoration-none">
                                    {{ Str::limit($locale == 'ar' ? $recentPost->title_ar : $recentPost->title_en, 50) }}
                                </a>
                            </h6>
                            <small class="text-muted">{{ $recentPost->created_at->format('d M, Y') }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Categories Widget -->
                <!-- <div class="sidebar-widget">
                    <h4 class="widget-title">{{ $locale == 'ar' ? 'التصنيفات' : 'Categories' }}</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-dark">
                                <i class="fas fa-chevron-{{ $locale == 'ar' ? 'left' : 'right' }} me-2 text-muted"></i>
                                {{ $locale == 'ar' ? 'نصائح السفر' : 'Travel Tips' }} 
                                <span class="float-end text-muted">(12)</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-dark">
                                <i class="fas fa-chevron-{{ $locale == 'ar' ? 'left' : 'right' }} me-2 text-muted"></i>
                                {{ $locale == 'ar' ? 'وجهات سياحية' : 'Destinations' }}
                                <span class="float-end text-muted">(8)</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-dark">
                                <i class="fas fa-chevron-{{ $locale == 'ar' ? 'left' : 'right' }} me-2 text-muted"></i>
                                {{ $locale == 'ar' ? 'عروض خاصة' : 'Special Offers' }}
                                <span class="float-end text-muted">(5)</span>
                            </a>
                        </li>
                    </ul>
                </div> -->
                
                <!-- Newsletter Widget -->
                <div class="sidebar-widget" style="background: linear-gradient(135deg, #127664 0%, #159265 100%); color: white;">
                    <h4 class="widget-title text-white border-bottom border-white">{{ $locale == 'ar' ? 'النشرة البريدية' : 'Newsletter' }}</h4>
                    <p>{{ $locale == 'ar' ? 'اشترك للحصول على أحدث العروض والأخبار' : 'Subscribe to get latest offers and news' }}</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="{{ $locale == 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}">
                        </div>
                        <button type="submit" class="btn btn-light w-100">{{ $locale == 'ar' ? 'اشترك الآن' : 'Subscribe Now' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Posts -->
@php
    $relatedPosts = \App\Models\Post::where('status', 1)
        ->where('id', '!=', $post->id)
        ->inRandomOrder()
        ->limit(3)
        ->get();
@endphp

@if($relatedPosts->count() > 0)
<section class="related-posts">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">{{ $locale == 'ar' ? 'مقالات ذات صلة' : 'Related Articles' }}</h2>
            <p class="text-muted">{{ $locale == 'ar' ? 'اكتشف المزيد من المقالات المميزة' : 'Discover more featured articles' }}</p>
        </div>
        
        <div class="row g-4">
            @foreach($relatedPosts as $relatedPost)
            <div class="col-md-4">
                <div class="related-card">
                    <img src="{{ $relatedPost->image ?? 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=600&q=80' }}" 
                         alt="{{ $locale == 'ar' ? $relatedPost->title_ar : $relatedPost->title_en }}"
                         class="related-image">
                    <div class="related-content">
                        <h5 class="related-title">
                            <a href="{{ route('post_details', $relatedPost->slug) }}" class="text-decoration-none text-dark">
                                {{ $locale == 'ar' ? $relatedPost->title_ar : $relatedPost->title_en }}
                            </a>
                        </h5>
                        <p class="related-excerpt">
                            {{ Str::limit(strip_tags($locale == 'ar' ? $relatedPost->body_ar : $relatedPost->body_en), 100) }}
                        </p>
                        <a href="{{ route('post_details', $relatedPost->slug) }}" class="text-decoration-none" style="color: #127664; font-weight: 600;">
                            {{ $locale == 'ar' ? 'اقرأ المزيد' : 'Read More' }}
                            <i class="fas fa-arrow-{{ $locale == 'ar' ? 'left' : 'right' }} ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@section('js')
<script>
// Increment view count
document.addEventListener('DOMContentLoaded', function() {
    // View count is handled by controller
});
</script>
@endsection
