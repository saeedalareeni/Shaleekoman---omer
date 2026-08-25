@extends('backend.layouts.master')

@section('page_title')
{{ trans('back.posts') }}
@endsection

@section('title')
{{ trans('back.posts') }}
@endsection

@section('css')
<style>
    .stats-card {
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .stats-card .icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }
    .stats-card .number {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .stats-card .label {
        color: #6c757d;
        font-size: 0.9rem;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: #333;
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        color: #333;
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #333;
    }
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        padding: 10px 20px;
        margin-right: 10px;
        border-radius: 5px;
        transition: all 0.3s;
    }
    .nav-tabs .nav-link.active {
        background: #6c5ce7;
        color: white;
    }
    .nav-tabs .nav-link:hover {
        background: #e9ecef;
    }
    .filter-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .post-card {
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    .post-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .post-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
    }
    .status-active {
        background: #d4edda;
        color: #155724;
    }
    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }
</style>
@endsection

@section('content')

<!-- Statistics Section -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card bg-gradient-primary text-center">
            <div class="icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="number">{{ \App\Models\Post::count() }}</div>
            <div class="label">إجمالي المقالات</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-gradient-success text-center">
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="number">{{ \App\Models\Post::where('status', 1)->count() }}</div>
            <div class="label">المقالات المنشورة</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-gradient-warning text-center">
            <div class="icon">
                <i class="fas fa-eye-slash"></i>
            </div>
            <div class="number">{{ \App\Models\Post::where('status', 0)->count() }}</div>
            <div class="label">المقالات المخفية</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-gradient-info text-center">
            <div class="icon">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="number">{{ \App\Models\Post::whereMonth('created_at', date('m'))->count() }}</div>
            <div class="label">مقالات هذا الشهر</div>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<ul class="nav nav-tabs mb-4" id="postTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab">
            <i class="fas fa-list"></i> جميع المقالات
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="published-tab" data-toggle="tab" href="#published" role="tab">
            <i class="fas fa-check"></i> المنشورة
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="draft-tab" data-toggle="tab" href="#draft" role="tab">
            <i class="fas fa-file-alt"></i> المسودات
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="stats-tab" data-toggle="tab" href="#stats" role="tab">
            <i class="fas fa-chart-bar"></i> الإحصائيات
        </a>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content" id="postTabContent">
    <!-- All Posts Tab -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-6">
                    {{-- @can('add_post') --}}
                        <a href="{{route('posts.create')}}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> إضافة مقال جديد
                        </a>
                    {{-- @endcan --}}
                    <button class="btn btn-success ml-2" onclick="exportPosts()">
                        <i class="fas fa-file-excel"></i> تصدير Excel
                    </button>
                    <button class="btn btn-info ml-2" data-toggle="modal" data-target="#advancedSearchModal">
                        <i class="fas fa-search-plus"></i> بحث متقدم
                    </button>
                </div>
                <div class="col-md-6">
                    {{-- @can('search_post') --}}
                        <form action="{{ route('posts.index') }}" method="GET" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="query" 
                                       placeholder="البحث في المقالات..." value="{{ request('query') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    {{-- @endcan --}}
                </div>
            </div>
        </div>

        <!-- Posts List -->
        <div class="card">
            <div class="card-body">
                @foreach($posts as $key => $post)
                <div class="post-card">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="{{asset($post->image)}}" alt="{{$post->title_ar}}" class="post-image">
                        </div>
                        <div class="col-md-6">
                            <h5>{{ app()->getLocale() == 'ar' ? $post->title_ar : $post->title_en }}</h5>
                            <p class="text-muted mb-1">
                                <i class="fas fa-calendar"></i> {{ $post->created_at->format('Y-m-d') }}
                                <span class="ml-3"><i class="fas fa-folder"></i> {{ $post->category_label ?? 'غير مصنف' }}</span>
                                <span class="ml-3"><i class="fas fa-eye"></i> {{ $post->views }} مشاهدة</span>
                            </p>
                            <p class="text-truncate">
                                {{ strip_tags(app()->getLocale() == 'ar' ? $post->body_ar : $post->body_en) }}
                            </p>
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="status-badge {{ $post->status == 1 ? 'status-active' : 'status-inactive' }}">
                                {{ $post->status == 1 ? 'منشور' : 'مسودة' }}
                            </span>
                        </div>
                        <div class="col-md-2 text-right">
                            <form action="{{ route('posts.toggle-status', $post->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $post->status == 1 ? 'warning' : 'success' }} btn-sm mb-1" title="{{ $post->status == 1 ? 'إخفاء' : 'نشر' }}">
                                    <i class="fas fa-{{ $post->status == 1 ? 'eye-slash' : 'eye' }}"></i>
                                </button>
                            </form>
                            {{-- @can('show_post') --}}
                                <a href="{{route('posts.show', $post->id)}}" class="btn btn-info btn-sm mb-1" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                            {{-- @endcan --}}
                            {{-- @can('edit_post') --}}
                                <a href="{{route('posts.edit', $post->id)}}" class="btn btn-success btn-sm mb-1" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                            {{-- @endcan --}}
                            {{-- @can('delete_post') --}}
                                <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#delete_Post{{$post->id}}" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            {{-- @endcan --}}
                            @include('backend.pages.posts.delete')
                        </div>
                    </div>
                </div>
                @endforeach
                
                {!! $posts->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>

    <!-- Published Tab -->
    <div class="tab-pane fade" id="published" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <h5>المقالات المنشورة</h5>
                @php
                    $publishedPosts = \App\Models\Post::where('status', 1)->paginate(10);
                @endphp
                @foreach($publishedPosts as $post)
                <div class="post-card">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="{{asset($post->image)}}" alt="{{$post->title_ar}}" class="post-image">
                        </div>
                        <div class="col-md-8">
                            <h6>{{ app()->getLocale() == 'ar' ? $post->title_ar : $post->title_en }}</h6>
                            <small class="text-muted">{{ $post->created_at->format('Y-m-d') }}</small>
                        </div>
                        <div class="col-md-2 text-right">
                            <a href="{{route('posts.edit', $post->id)}}" class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Draft Tab -->
    <div class="tab-pane fade" id="draft" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <h5>المسودات</h5>
                @php
                    $draftPosts = \App\Models\Post::where('status', 0)->paginate(10);
                @endphp
                @foreach($draftPosts as $post)
                <div class="post-card">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="{{asset($post->image)}}" alt="{{$post->title_ar}}" class="post-image">
                        </div>
                        <div class="col-md-8">
                            <h6>{{ app()->getLocale() == 'ar' ? $post->title_ar : $post->title_en }}</h6>
                            <small class="text-muted">{{ $post->created_at->format('Y-m-d') }}</small>
                        </div>
                        <div class="col-md-2 text-right">
                            <a href="{{route('posts.edit', $post->id)}}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> نشر
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Statistics Tab -->
    <div class="tab-pane fade" id="stats" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>المقالات حسب الشهر</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>توزيع المقالات</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5>آخر المقالات المضافة</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Post::latest()->take(10)->get() as $post)
                        <tr>
                            <td>{{ app()->getLocale() == 'ar' ? $post->title_ar : $post->title_en }}</td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge {{ $post->status == 1 ? 'badge-success' : 'badge-warning' }}">
                                    {{ $post->status == 1 ? 'منشور' : 'مسودة' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('backend.pages.posts.advanced-search')

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Posts Chart
var ctx = document.getElementById('monthlyChart');
if (ctx) {
    ctx = ctx.getContext('2d');
    var monthlyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            datasets: [{
                label: 'عدد المقالات',
                data: [
                    @for($i = 1; $i <= 12; $i++)
                        {{ \App\Models\Post::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->count() }},
                    @endfor
                ],
                backgroundColor: 'rgba(108, 92, 231, 0.5)',
                borderColor: 'rgba(108, 92, 231, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Status Chart
var ctx2 = document.getElementById('statusChart');
if (ctx2) {
    ctx2 = ctx2.getContext('2d');
    var statusChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['منشور', 'مسودة'],
            datasets: [{
                data: [
                    {{ \App\Models\Post::where('status', 1)->count() }},
                    {{ \App\Models\Post::where('status', 0)->count() }}
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)'
                ]
            }]
        }
    });
}

function exportPosts() {
    window.location.href = '{{ route("posts.index") }}?export=excel';
}
</script>
@endsection
