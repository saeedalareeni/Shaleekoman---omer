@extends('frontend.layouts.weekend_master')

@section('page_title', app()->getLocale() == 'ar' ? 'المدونة' : 'Blog')

@section('css')
<style>
    /* Font Settings for Arabic */
    @if(app()->getLocale() == 'ar')
    body, h1, h2, h3, h4, h5, h6, p, span, div, a, button, input, select, textarea, * {
        font-family: 'Tajawal', sans-serif !important;
    }
    @endif
    /* Hero Section */
    .blog-hero {
        background: linear-gradient(135deg, rgba(18, 118, 100, 0.95) 0%, rgba(18, 118, 100, 0.85) 100%), 
                    url('https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=1920&q=80') center/cover;
        min-height: 350px;
        display: flex;
        align-items: center;
        position: relative;
    }
    
    /* Blog Section */
    .blog-section {
        padding: 80px 0;
        background: #f8f9fa;
    }
    
    /* Blog Card */
    .blog-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .blog-image {
        position: relative;
        height: 250px;
        overflow: hidden;
    }
    
    .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .blog-card:hover .blog-image img {
        transform: scale(1.1);
    }
    
    .blog-category {
        position: absolute;
        top: 20px;
        left: 20px;
        background: #127664;
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .blog-content {
        padding: 30px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .blog-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 15px;
        font-size: 14px;
        color: #6c757d;
    }
    
    .blog-meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .blog-title {
        font-size: 22px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 15px;
        line-height: 1.4;
        transition: color 0.3s ease;
    }
    
    .blog-card:hover .blog-title {
        color: #127664;
    }
    
    .blog-excerpt {
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }
    
    .blog-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #127664;
        font-weight: 600;
        text-decoration: none;
        transition: gap 0.3s ease;
    }
    
    .blog-link:hover {
        gap: 12px;
        color: #0e5a4c;
    }
    
    /* Categories Filter */
    .categories-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-bottom: 50px;
    }
    
    .category-btn {
        padding: 10px 25px;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        color: #495057;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .category-btn:hover,
    .category-btn.active {
        background: #127664;
        border-color: #127664;
        color: white;
    }
    
    /* Pagination */
    .pagination {
        gap: 5px;
    }
    
    .page-link {
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        color: #127664;
        font-weight: 500;
        background: white;
        margin: 0 2px;
    }
    
    .page-link:hover {
        background: #127664;
        color: white;
    }
    
    .page-item.active .page-link {
        background: #127664;
        color: white;
    }
    
    /* Featured Post */
    .featured-post {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-bottom: 50px;
    }
    
    .featured-post .row {
        min-height: 400px;
    }
    
    .featured-image {
        background-size: cover;
        background-position: center;
        min-height: 400px;
    }
    
    .featured-content {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .featured-badge {
        display: inline-block;
        background: rgba(18, 118, 100, 0.1);
        color: #127664;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 20px;
        width: fit-content;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .blog-hero {
            min-height: 250px;
        }
        
        .blog-hero h1 {
            font-size: 2rem !important;
        }
        
        .blog-section {
            padding: 50px 0;
        }
        
        .blog-image {
            height: 200px;
        }
        
        .blog-content {
            padding: 20px;
        }
        
        .blog-title {
            font-size: 18px;
        }
        
        .featured-post .row {
            min-height: auto;
        }
        
        .featured-image {
            min-height: 250px;
        }
        
        .featured-content {
            padding: 25px;
        }
        
        .categories-filter {
            margin-bottom: 30px;
        }
    }
</style>
@endsection

@section('content')

<!-- Hero Section -->
<section class="blog-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('shaleek.home') }}" class="text-white-50">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                        </li>
<li class="breadcrumb-item text-white mx-1">
        
    </li>
                        <li class="breadcrumb-item active text-white">{{ app()->getLocale() == 'ar' ? 'المدونة' : 'Blog' }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">{{ app()->getLocale() == 'ar' ? 'المدونة' : 'Our Blog' }}</h1>
                <p class="lead text-white mb-0">{{ app()->getLocale() == 'ar' ? 'اكتشف أحدث المقالات والنصائح حول السفر والضيافة' : 'Discover the latest articles and tips about travel and hospitality' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Blog Posts Section -->
<section class="blog-section">
    <div class="container">
        {{-- Categories Filter - Removed until categories are implemented --}}
        {{-- <div class="categories-filter">
            <a href="{{ route('all-posts') }}" class="category-btn active">{{ app()->getLocale() == 'ar' ? 'الكل' : 'All' }}</a>
        </div> --}}
        
        <!-- Featured Post (First Post) -->
        @if($posts->count() > 0 && $posts->currentPage() == 1)
            @php $featuredPost = $posts->first(); @endphp
            <div class="featured-post">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="featured-image" style="background-image: url('{{ $featuredPost->image ? asset($featuredPost->image) : 'https://images.unsplash.com/photo-1455849318743-b2233052fcff?w=800&q=80' }}');"></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="featured-content">
                            <span class="featured-badge">{{ app()->getLocale() == 'ar' ? 'مميز' : 'Featured' }}</span>
                            <h2 class="mb-3">{{ app()->getLocale() == 'ar' ? $featuredPost->title_ar : $featuredPost->title_en }}</h2>
                            <div class="blog-meta mb-3">
                                <div class="blog-meta-item">
                                    <i class="far fa-calendar"></i>
                                    <span>{{ $featuredPost->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="blog-meta-item">
                                    <i class="far fa-clock"></i>
                                    <span>{{ app()->getLocale() == 'ar' ? '5 دقائق قراءة' : '5 min read' }}</span>
                                </div>
                            </div>
                            <p class="text-muted mb-4">{{ Str::limit(strip_tags(app()->getLocale() == 'ar' ? $featuredPost->body_ar : $featuredPost->body_en), 200) }}</p>
                            <a href="{{ route('post_details', $featuredPost->slug) }}" class="blog-link">
                                {{ app()->getLocale() == 'ar' ? 'اقرأ المزيد' : 'Read More' }}
                                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Blog Grid -->
        <div class="row g-4">
            @forelse ($posts as $index => $post)
                @if($posts->currentPage() != 1 || $index != 0) {{-- Skip first post on first page as it's featured --}}
                    <div class="col-md-6 col-lg-4">
                        <article class="blog-card">
                            <div class="blog-image">
                                <img src="{{ $post->image ? asset($post->image) : 'https://images.unsplash.com/photo-1455849318743-b2233052fcff?w=600&q=80' }}" 
                                     alt="{{ app()->getLocale() == 'ar' ? $post->title_ar : $post->title_en }}">
                                <span class="blog-category">{{ app()->getLocale() == 'ar' ? 'نصائح' : 'Tips' }}</span>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <div class="blog-meta-item">
                                        <i class="far fa-calendar"></i>
                                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="blog-meta-item">
                                        <i class="far fa-clock"></i>
                                        <span>{{ rand(3, 10) }} {{ app()->getLocale() == 'ar' ? 'دقائق' : 'min' }}</span>
                                    </div>
                                </div>
                                <h3 class="blog-title">
                                    {{ app()->getLocale() == 'ar' ? $post->title_ar : $post->title_en }}
                                </h3>
                                <p class="blog-excerpt">
                                    {{ Str::limit(strip_tags(app()->getLocale() == 'ar' ? $post->body_ar : $post->body_en), 120) }}
                                </p>
                                <a href="{{ route('post_details', $post->slug) }}" class="blog-link">
                                    {{ app()->getLocale() == 'ar' ? 'اقرأ المزيد' : 'Read More' }}
                                    <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @endif
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ app()->getLocale() == 'ar' ? 'لا توجد مقالات حالياً' : 'No articles available' }}</h4>
                        <p class="text-muted">{{ app()->getLocale() == 'ar' ? 'يرجى العودة لاحقاً' : 'Please check back later' }}</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</section>

@endsection
