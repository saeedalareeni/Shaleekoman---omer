@extends('backend.layouts.master')

@section('page_title')
{{trans('back.owners')}}
@endsection
@section('title')
{{trans('back.owners')}}
@endsection

@section('css')
<style>
    .filter-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    
    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #dee2e6;
    }
    
    .filter-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filter-title i {
        color: #2c8e3d;
    }
    
    .filter-row {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: end;
    }
    
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    
    .filter-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 13px;
        font-weight: 600;
        color: #495057;
    }
    
    .filter-group label i {
        color: #6c757d;
        margin-right: 5px;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #2c8e3d;
        box-shadow: 0 0 0 0.2rem rgba(44, 142, 61, 0.1);
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
    }
    
    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .new-owner-badge {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 5px;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }
    
    .owner-status-active {
        background: #d4edda;
        color: #155724;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 12px;
    }
    
    .owner-status-inactive {
        background: #f8d7da;
        color: #721c24;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 12px;
    }
</style>
@endsection

@section('content')

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card primary">
                <div class="text-center">
                    <div class="stats-icon text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-number text-primary">{{ \App\Models\Owner::count() }}</div>
                    <div class="stats-label">إجمالي المالكين</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card success">
                <div class="text-center">
                    <div class="stats-icon text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-number text-success">{{ \App\Models\Owner::where('is_active', 1)->count() }}</div>
                    <div class="stats-label">المالكين النشطين</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card warning">
                <div class="text-center">
                    <div class="stats-icon text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-number text-warning">{{ \App\Models\Owner::where('is_active', 0)->count() }}</div>
                    <div class="stats-label">في انتظار التفعيل</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card info">
                <div class="text-center">
                    <div class="stats-icon text-info">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <div class="stats-number text-info">{{ \App\Models\Owner::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count() }}</div>
                    <div class="stats-label">جدد هذا الشهر</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-box">
        <div class="filter-box-header">
            <div class="filter-box-title">
                <i class="fas fa-filter"></i>
                <span>البحث والفلترة</span>
            </div>
            <div class="filter-results">
                <i class="fas fa-list"></i> عدد النتائج: {{ $owners->total() }}
            </div>
        </div>
        
        <form method="GET" action="{{ route('owners.index') }}" id="filterForm">
            <div class="filter-box-body">
                <div class="filter-row">
                    <div class="filter-col">
                        <label><i class="fas fa-search"></i> {{ __('back.search') }}</label>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('back.search_placeholder') }}">
                    </div>
                    
                    <div class="filter-col">
                        <label><i class="fas fa-toggle-on"></i> {{ __('back.status') }}</label>
                        <select name="status" class="form-control">
                            <option value="">{{ __('back.all') }}</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('back.active') }}</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('back.inactive') }}</option>
                        </select>
                    </div>
                    
                    <div class="filter-col">
                        <label><i class="fas fa-calendar-alt"></i> {{ __('back.report_period') }}</label>
                        <select name="period" class="form-control">
                            <option value="">{{ __('back.all') }}</option>
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>{{ __('back.daily') }}</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>{{ __('back.this_week') }}</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>{{ __('back.this_month') }}</option>
                        </select>
                    </div>
                    
                    <div class="filter-col">
                        <label><i class="fas fa-home"></i> عدد الشاليهات</label>
                        <select name="chalets" class="form-control">
                            <option value="">الكل</option>
                            <option value="0" {{ request('chalets') == '0' ? 'selected' : '' }}>بدون شاليهات</option>
                            <option value="1-5" {{ request('chalets') == '1-5' ? 'selected' : '' }}>1-5 شاليهات</option>
                            <option value="5+" {{ request('chalets') == '5+' ? 'selected' : '' }}>أكثر من 5</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> {{ __('back.filter') }}
                </button>
                <a href="{{ route('owners.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> {{ __('back.reload') }}
                </a>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_Owner">
                    <i class="fas fa-plus"></i> {{ __('back.add_owner') }}
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-download"></i> {{ __('back.export') }}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="exportToExcel()">
                            <i class="fas fa-file-excel text-success"></i> Excel
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf text-danger"></i> PDF
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="row mb-1">

        @can('add_owner')
            <div class="col-md-9 d-none">
                <button type="button" class="btn btn-purple btn-sm" data-toggle="modal" data-target="#add_Owner">
                    <i class="fas fa-plus pr-2 "></i>
                    {{trans('back.add_new_owner')}}
                </button>
                @include('backend.pages.owners.add')
            </div>
        @endcan

        @can('search_owner')
            <div class="col-md-3 ">
                <form action="{{ route('owners.index') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="{{trans('back.search')}}" id="query" >
                        <div class="input-group-prepend">
                            <button class="btn btn-purple btn-sm " type="submit" title="Search..">
                                <span class="fas fa-search"></span>
                            </button>
                            <a href="{{ route('owners.index') }}" class="btn btn-success btn-sm" title="{{trans('front.Reload the page')}}">
                                <span class="fas fa-sync-alt"></span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        @endcan
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-box">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm text-center">
                            <thead class="bg-light">
                            <tr>
                                <th width="50">#</th>
                                <th>{{ __('back.owner_name') }}</th>
                                <th>{{ __('back.contact_info') }}</th>
                                <th>{{ __('back.bank_account') }}</th>
                                <th>{{ __('back.chalets') }}</th>
                                <th>{{ __('back.owner_finance') }}</th>
                                <th>{{ __('back.status') }}</th>
                                <th width="200">{{ __('back.actions') }}</th>
                                <th>{{ __('back.registration_date') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($owners as $key => $Owner)
                                @php
                                    $isNew = $Owner->created_at->diffInDays(now()) <= 7;
                                    $bookings = $Owner->chalets()->with('bookings')->get()->pluck('bookings')->flatten();
                                    $totalAmount = $bookings->sum('total_amount');
                                    $commissionPercentage = $Owner->commission ?? 0;
                                    $totalCommission = ($totalAmount * $commissionPercentage) / 100;
                                    $expenses = $Owner->expenses->sum('amount');
                                    $netAmount = ($totalAmount - $totalCommission) - $expenses;
                                    $chaletsCount = $Owner->chalets->count();
                                @endphp
                                <tr style="{{ $isNew ? 'background-color: #f0f9f4;' : '' }}">
                                    <th scope="row">{{ $owners->firstItem() + $key }}</th>
                                    
                                    <!-- Owner Info -->
                                    <td class="text-right">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($Owner->image ?? 'avatar.png') }}" class="rounded-circle mr-2" width="40" height="40" alt="">
                                            <div>
                                                <strong>{{ $Owner->name }}</strong>
                                                @if($isNew)
                                                    <span class="new-owner-badge">{{ __('back.new') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Contact Info -->
                                    <td>
                                        <div><i class="fas fa-envelope text-muted"></i> {{ $Owner->email ?: __('back.not_specified') }}</div>
                                        <div><i class="fas fa-phone text-muted"></i> {{ $Owner->phone }}</div>
                                    </td>
                                    
                                    <!-- Bank Account -->
                                    <td>
                                        @if($Owner->bank_account_name)
                                            <div class="small">{{ $Owner->bank_account_name }}</div>
                                            <div class="font-weight-bold">{{ $Owner->bank_account_number }}</div>
                                        @else
                                            <span class="text-muted">{{ __('back.not_specified') }}</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Chalets -->
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="badge badge-info">{{ $chaletsCount }} {{ __('back.chalet') }}</span>
                                            <small class="text-muted mt-1">{{ __('back.commission') }}: {{ $commissionPercentage }}%</small>
                                        </div>
                                    </td>
                                    
                                    <!-- Finance -->
                                    <td>
                                        <div class="text-right">
                                            <div><small class="text-muted">{{ __('back.total') }}:</small> <strong>{{ number_format($totalAmount, 2) }}</strong></div>
                                            <div><small class="text-muted">{{ __('back.commission') }}:</small> <span class="text-danger">{{ number_format($totalCommission, 2) }}</span></div>
                                            <div><small class="text-muted">{{ __('back.expenses') }}:</small> <span class="text-warning">{{ number_format($expenses, 2) }}</span></div>
                                            <div class="border-top pt-1"><small class="text-muted">{{ __('back.net') }}:</small> <strong class="text-success">{{ number_format($netAmount, 2) }}</strong></div>
                                        </div>
                                    </td>
                                    
                                    <!-- Status -->
                                    <td>
                                        @if($Owner->is_active)
                                            <span class="badge badge-success">{{ __('back.active') }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ __('back.inactive') }}</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- View Details -->
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewOwner{{$Owner->id}}" title="عرض التفاصيل">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            <!-- Edit -->
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editOwner{{$Owner->id}}" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <!-- Toggle Status -->
                                            <form action="{{ route('owners.toggle-status', $Owner->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                @if($Owner->is_active)
                                                    <button type="submit" class="btn btn-warning btn-sm" title="إلغاء التفعيل">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-success btn-sm" title="تفعيل">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                            </form>
                                            
                                            <!-- Finance -->
                                            <a href="{{ route('owners.show', $Owner->id) }}" class="btn btn-success btn-sm" title="المالية">
                                                <i class="fas fa-dollar-sign"></i>
                                            </a>
                                            
                                            <!-- Delete -->
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteOwner{{$Owner->id}}" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    
                                    <!-- Date -->
                                    <td>{{ $Owner->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="p-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">لا يوجد مالكين حالياً</p>
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
                            عرض {{ $owners->firstItem() ?? 0 }} إلى {{ $owners->lastItem() ?? 0 }} من {{ $owners->total() }} مالك
                        </div>
                        <div>
                            {!! $owners->appends(request()->query())->links() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <!-- Modals -->
    @foreach($owners as $Owner)
        @php
            $bookings = $Owner->chalets()->with('bookings')->get()->pluck('bookings')->flatten();
            $totalAmount = $bookings->sum('total_amount');
            $commissionPercentage = $Owner->commission ?? 0;
            $totalCommission = ($totalAmount * $commissionPercentage) / 100;
            $expenses = $Owner->expenses->sum('amount');
        @endphp
        
        <!-- View Modal -->
        <div class="modal fade" id="viewOwner{{$Owner->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">تفاصيل المالك: {{ $Owner->name }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset($Owner->image ?? 'avatar.png') }}" class="rounded-circle mb-3" width="150" height="150">
                                <h5>{{ $Owner->name }}</h5>
                                @if($Owner->is_active)
                                    <span class="badge badge-success">نشط</span>
                                @else
                                    <span class="badge badge-danger">غير نشط</span>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="30%">البريد الإلكتروني:</th>
                                        <td>{{ $Owner->email ?: 'غير محدد' }}</td>
                                    </tr>
                                    <tr>
                                        <th>الهاتف:</th>
                                        <td>{{ $Owner->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>العنوان:</th>
                                        <td>{{ $Owner->address ?: 'غير محدد' }}</td>
                                    </tr>
                                    <tr>
                                        <th>عدد الشاليهات:</th>
                                        <td><span class="badge badge-info">{{ $Owner->chalets->count() }} شاليه</span></td>
                                    </tr>
                                    <tr>
                                        <th>نسبة العمولة:</th>
                                        <td>{{ $Owner->commission ?? 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <th>تاريخ التسجيل:</th>
                                        <td>{{ $Owner->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                </table>
                                
                                @if($Owner->bank_account_name)
                                <div class="alert alert-light">
                                    <h6>معلومات الحساب البنكي:</h6>
                                    <p class="mb-1">اسم الحساب: {{ $Owner->bank_account_name }}</p>
                                    <p class="mb-0">رقم الحساب: {{ $Owner->bank_account_number }}</p>
                                </div>
                                @endif
                                
                                <div class="alert alert-success">
                                    <h6>المعلومات المالية:</h6>
                                    <p class="mb-1">إجمالي الحجوزات: {{ number_format($totalAmount, 2) }} ريال</p>
                                    <p class="mb-1">العمولة: {{ number_format($totalCommission, 2) }} ريال</p>
                                    <p class="mb-1">المصروفات: {{ number_format($expenses, 2) }} ريال</p>
                                    <p class="mb-0"><strong>الصافي: {{ number_format(($totalAmount - $totalCommission) - $expenses, 2) }} ريال</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Edit Modal -->
        <div class="modal fade" id="editOwner{{$Owner->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{ route('owners.update', $Owner->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">تعديل بيانات المالك</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الاسم <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ $Owner->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>البريد الإلكتروني</label>
                                        <input type="email" name="email" class="form-control" value="{{ $Owner->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الهاتف <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" value="{{ $Owner->phone }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>العنوان</label>
                                        <input type="text" name="address" class="form-control" value="{{ $Owner->address }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>اسم الحساب البنكي</label>
                                        <input type="text" name="bank_account_name" class="form-control" value="{{ $Owner->bank_account_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>رقم الحساب البنكي</label>
                                        <input type="text" name="bank_account_number" class="form-control" value="{{ $Owner->bank_account_number }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>نسبة العمولة (%)</label>
                                        <input type="number" name="commission" class="form-control" value="{{ $Owner->commission }}" min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>كلمة المرور (اتركها فارغة إذا لم ترد تغييرها)</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteOwner{{$Owner->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">تأكيد الحذف</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>هل أنت متأكد من حذف المالك <strong>{{ $Owner->name }}</strong>؟</p>
                        @if($Owner->chalets->count() > 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                تحذير: هذا المالك لديه {{ $Owner->chalets->count() }} شاليه. يجب حذف أو نقل الشاليهات أولاً.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        @if($Owner->chalets->count() == 0)
                            <form action="{{ route('owners.destroy', $Owner->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        @else
                            <button type="button" class="btn btn-danger" disabled>لا يمكن الحذف</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
// Export to Excel
function exportToExcel() {
    // Get current filter parameters
    const params = new URLSearchParams(window.location.search);
    
    // Create form to submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("owners.export.excel") }}';
    
    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    // Add filter parameters
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
function exportToPDF() {
    const params = new URLSearchParams(window.location.search);
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("owners.export.pdf") }}';
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
