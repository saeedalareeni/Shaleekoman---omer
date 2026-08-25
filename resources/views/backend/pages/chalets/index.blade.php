@extends('backend.layouts.master')

@section('page_title', trans('back.chalets'))

@section('title', trans('back.chalets'))

@section('css')
<style>
    .chalet-badge {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-pending { background: #ffc107; color: #000; }
    .badge-approved { background: #28a745; color: #fff; }
    .badge-rejected { background: #dc3545; color: #fff; }
    .badge-featured { background: #17a2b8; color: #fff; }
</style>
@endsection

@section('content')

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card primary">
                <div class="text-center">
                    <div class="stats-icon text-primary">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="stats-number text-primary">{{ \App\Models\Chalet::count() }}</div>
                    <div class="stats-label">{{ __('back.total_chalets') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card success">
                <div class="text-center">
                    <div class="stats-icon text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-number text-success">{{ \App\Models\Chalet::where('status', 'approved')->count() }}</div>
                    <div class="stats-label">{{ __('back.approved_chalets') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card warning">
                <div class="text-center">
                    <div class="stats-icon text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-number text-warning">{{ \App\Models\Chalet::where('status', 'pending')->count() }}</div>
                    <div class="stats-label">{{ __('back.pending_approval') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-box">
        <div class="filter-box-header">
            <div class="filter-box-title">
                <i class="fas fa-filter"></i>
                <span>{{ __('back.search') }} & {{ __('back.filter') }}</span>
            </div>
            <div class="filter-results">
                <i class="fas fa-list"></i> {{ __('back.results_count') }}: {{ $chalets->total() }}
            </div>
        </div>
        
        <form method="GET" action="{{ route('chalets.index') }}" id="filterForm">
            <div class="filter-box-body">
                <div class="filter-row">
                    <div class="filter-col">
                        <label><i class="fas fa-search"></i> {{ __('back.search') }}</label>
                        <input type="text" name="query" class="form-control" value="{{ request('query') }}" 
                               placeholder="{{ __('back.chalet_search_placeholder') }}">
                    </div>
                    
                    <div class="filter-col">
                        <label><i class="fas fa-toggle-on"></i> {{ __('back.status') }}</label>
                        <select name="status" class="form-control">
                            <option value="">{{ __('back.all') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('back.pending') }}</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('back.approved') }}</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('back.rejected') }}</option>
                        </select>
                    </div>
                    
                    <div class="filter-col">
                        <label><i class="fas fa-map-marker-alt"></i> {{ __('back.area') }}</label>
                        <select name="area_id" class="form-control">
                            <option value="">{{ __('back.all_areas') }}</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                                    {{ app()->getLocale() == 'ar' ? $area->name_ar : $area->name_en }} 
                                    ({{ app()->getLocale() == 'ar' ? $area->city->name_ar : $area->city->name_en }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> {{ __('back.apply_filter') }}
                </button>
                <a href="{{ route('chalets.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> {{ __('back.reset') }}
                </a>
                @can('add_chalet')
                    <a href="{{ route('chalets.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> {{ __('back.add_chalet') }}
                    </a>
                @endcan
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-download"></i> {{ __('back.export') }}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="exportChaletsToExcel()">
                            <i class="fas fa-file-excel text-success"></i> Excel
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="exportChaletsToPDF()">
                            <i class="fas fa-file-pdf text-danger"></i> PDF
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="bg-light">
                        <tr>
                            <th width="50">#</th>
                            <th>{{ __('back.image') }}</th>
                            <th>{{ __('back.chalet') }}</th>
                            <th>{{ __('back.owner') }}</th>
                            <th>{{ __('back.location') }}</th>
                            <th>{{ __('back.bookings') }}</th>
                            <th>{{ __('back.status') }}</th>
                            <th width="200">{{ __('back.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($chalets as $key => $chalet)
                            <tr>
                                <td>{{ $chalets->firstItem() + $key }}</td>
                                
                                <!-- Image -->
                                <td class="text-center">
                                    @if($chalet->main_image)
                                        <img src="{{ asset($chalet->main_image) }}" class="rounded" width="50" height="50" alt="">
                                    @else
                                        <span class="text-muted">{{ __('back.no_image') }}</span>
                                    @endif
                                </td>
                                
                                <!-- Chalet Info -->
                                <td>
                                    <div>
                                        <strong>{{ App::getLocale() =='ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en }}</strong>
                                    </div>
                                    <small class="text-muted">{{ $chalet->price_per_night }} {{ __('back.currency') }}/{{ __('back.night') }}</small>
                                </td>
                                
                                <!-- Owner -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($chalet->owner)
                                            <div>
                                                <div>{{ $chalet->owner->name }}</div>
                                                <small class="text-muted">{{ $chalet->owner->phone }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">غير محدد</span>
                                        @endif
                                    </div>
                                </td>
                                
                                <!-- Location -->
                                <td>
                                    <div>
                                        <i class="fas fa-map-marker-alt text-muted"></i>
                                        {{ app()->getLocale()=='ar'? $chalet->city->name_ar:$chalet->city->name_en }}
                                    </div>
                                    <small class="text-muted">
                                        {{ app()->getLocale()=='ar'? $chalet->area->name_ar:$chalet->area->name_en }}
                                    </small>
                                </td>
                                
                                <!-- Bookings -->
                                <td class="text-center">
                                    <div>
                                        <span class="badge badge-info">{{ $chalet->bookings->count() }} حجز</span>
                                    </div>
                                    <small class="text-muted">{{ number_format($chalet->bookings->sum('payment_amount'), 2) }} ريال</small>
                                </td>
                                
                                <!-- Status -->
                                <td class="text-center">
                                    @if($chalet->status == 'approved')
                                        <span class="badge badge-approved">معتمد</span>
                                    @elseif($chalet->status == 'pending')
                                        <span class="badge badge-pending">قيد المراجعة</span>
                                    @else
                                        <span class="badge badge-rejected">مرفوض</span>
                                    @endif
                                </td>
                                
                                <!-- Actions -->
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Prices -->
                                        <a class="btn btn-info btn-sm" href="{{ route('chalets.prices.index', $chalet->id) }}" title="الأسعار">
                                            <i class="fas fa-dollar-sign"></i>
                                        </a>
                                        
                                        <!-- View -->
                                        @can('show_chalet')
                                            <a class="btn btn-primary btn-sm" href="{{ route('chalets.show', $chalet->id) }}" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        
                                        <!-- Images -->
                                        @can('show_chalet')
                                            <a class="btn btn-warning btn-sm" href="{{ route('chalets.images.index', $chalet->id) }}" title="الصور">
                                                <i class="fas fa-images"></i>
                                                <span class="badge badge-light">{{ count($chalet->images) }}</span>
                                            </a>
                                        @endcan
                                        
                                        <!-- Edit -->
                                        @can('edit_chalet')
                                            <a class="btn btn-success btn-sm" href="{{ route('chalets.edit', $chalet->id) }}" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        
                                        <!-- Status Toggle -->
                                        <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#model_status{{ $chalet->id }}" title="تغيير الحالة">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                        
                                        <!-- Delete -->
                                        @can('delete_chalet')
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_chalet{{ $chalet->id }}" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @include('backend.pages.chalets.model_status')
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="p-4">
                                        <i class="fas fa-home fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">لا توجد شاليهات حالياً</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center p-3">
                    <div>
                        عرض {{ $chalets->firstItem() ?? 0 }} إلى {{ $chalets->lastItem() ?? 0 }} من {{ $chalets->total() }} شاليه
                    </div>
                    <div>
                        {!! $chalets->appends(request()->query())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Delete Modals -->
    @foreach($chalets as $chalet)
        @include('backend.pages.chalets.delete', ['chalet' => $chalet])
    @endforeach

@endsection

@section('js')
<script>
// Export to Excel
function exportChaletsToExcel() {
    const params = new URLSearchParams(window.location.search);
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("chalets.export.excel") }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    params.forEach((value, key) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Export to PDF
function exportChaletsToPDF() {
    const params = new URLSearchParams(window.location.search);
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("chalets.export.pdf") }}';
    form.target = '_blank';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    params.forEach((value, key) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
</script>
@endsection
