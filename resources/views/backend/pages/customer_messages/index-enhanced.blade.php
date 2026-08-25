@extends('backend.layouts.master')

@section('page_title')
{{ trans('back.customer_messages') ?? 'رسائل العملاء' }}
@endsection

@section('title')
{{ trans('back.customer_messages') ?? 'رسائل العملاء' }} - {{ trans('back.contact_form') ?? 'نموذج الاتصال' }}
@endsection

@section('css')
<style>
    .message-card {
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border-left: 4px solid #6c5ce7;
    }
    .message-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    .message-card.unread {
        background: #f8f9fa;
        border-left-color: #ff6b6b;
    }
    .message-header {
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
    }
    .message-body {
        padding: 20px;
    }
    .sender-info {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .sender-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 20px;
        font-weight: bold;
    }
    .message-meta {
        display: flex;
        gap: 20px;
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 10px;
    }
    .message-meta i {
        margin-right: 5px;
    }
    .subject-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .subject-general { background: #e3f2fd; color: #1976d2; }
    .subject-booking { background: #f3e5f5; color: #7b1fa2; }
    .subject-payment { background: #fff3e0; color: #f57c00; }
    .subject-complaint { background: #ffebee; color: #c62828; }
    .subject-suggestion { background: #e8f5e9; color: #2e7d32; }
    .subject-partnership { background: #fce4ec; color: #c2185b; }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 30px;
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
    .filter-section {
        background: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .btn-reply {
        background: #6c5ce7;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        transition: all 0.3s;
    }
    .btn-reply:hover {
        background: #5f3dc4;
        transform: translateY(-2px);
    }
    
    /* Hide modal backdrop */
    .modal-backdrop {
        display: none !important;
    }
    
    /* Ensure modal is visible and on top */
    #replyModal {
        z-index: 9999 !important;
    }
    
    #replyModal .modal-dialog {
        z-index: 10000 !important;
    }
    
    #replyModal .modal-content {
        z-index: 10001 !important;
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    
    /* Add dark overlay to modal itself */
    #replyModal.show {
        background-color: rgba(0,0,0,0.5);
    }
    
    /* Remove any extra padding from body when modal is open */
    body.modal-open {
        padding-right: 0 !important;
        overflow: auto !important;
    }
    
    /* Ensure modal is clickable */
    .modal.show {
        pointer-events: auto !important;
    }
    
    .modal-dialog {
        pointer-events: auto !important;
    }
</style>
@endsection

@section('content')

<form action="{{ route('customer-messages.bulk-destroy') }}" method="POST" id="bulkDeleteFormEnhanced" class="d-none">
    @csrf
</form>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="page-title mb-1">
                    <i class="fas fa-envelope"></i> رسائل العملاء
                </h4>
                <p class="text-muted">إدارة الرسائل الواردة من نموذج الاتصال</p>
            </div>
            <div>
                <button type="button" class="btn btn-danger btn-sm" onclick="markAllAsRead()">
                    <i class="fas fa-check-double"></i> تحديد الكل كمقروء
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="icon text-primary">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="number">{{ $stats['total'] ?? 0 }}</div>
            <div class="label">إجمالي الرسائل</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="icon text-danger">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="number">{{ $stats['unread'] ?? 0 }}</div>
            <div class="label">رسائل غير مقروءة</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="icon text-success">
                <i class="fas fa-reply"></i>
            </div>
            <div class="number">{{ $stats['replied'] ?? 0 }}</div>
            <div class="label">تم الرد عليها</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="icon text-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="number">{{ $stats['today'] ?? 0 }}</div>
            <div class="label">رسائل اليوم</div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <form method="GET" action="{{ route('customer-messages.index') }}">
        <div class="row">
            <div class="col-md-3">
                <select name="subject" class="form-control">
                    <option value="">جميع المواضيع</option>
                    <option value="general" {{ request('subject') == 'general' ? 'selected' : '' }}>استفسار عام</option>
                    <option value="booking" {{ request('subject') == 'booking' ? 'selected' : '' }}>مشكلة في الحجز</option>
                    <option value="payment" {{ request('subject') == 'payment' ? 'selected' : '' }}>مشكلة في الدفع</option>
                    <option value="complaint" {{ request('subject') == 'complaint' ? 'selected' : '' }}>شكوى</option>
                    <option value="suggestion" {{ request('subject') == 'suggestion' ? 'selected' : '' }}>اقتراح</option>
                    <option value="partnership" {{ request('subject') == 'partnership' ? 'selected' : '' }}>شراكة</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">جميع الحالات</option>
                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>غير مقروء</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>مقروء</option>
                    <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>تم الرد</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="البحث بالاسم أو البريد..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-search"></i> بحث
                </button>
            </div>
        </div>
    </form>
</div>

<div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 10px;">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="selectAllMessagesEnhanced">
        <label class="custom-control-label" for="selectAllMessagesEnhanced">{{ app()->getLocale() == 'ar' ? 'تحديد الكل' : 'Select all' }}</label>
    </div>
    <button type="submit" form="bulkDeleteFormEnhanced" class="btn btn-danger btn-sm" id="bulkDeleteBtnEnhanced" disabled>
        {{ app()->getLocale() == 'ar' ? 'حذف المحدد' : 'Delete selected' }}
    </button>
</div>

<!-- Messages List -->
<div class="messages-list">
    @forelse($customer_messages as $message)
    <div class="card message-card {{ !$message->is_read ? 'unread' : '' }}">
        <div class="message-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="sender-info">
                        <div class="sender-avatar">
                            {{ strtoupper(substr($message->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $message->name ?? 'غير محدد' }}</h5>
                            @if($message->first_name || $message->last_name)
                                <small class="text-muted">{{ $message->first_name }} {{ $message->last_name }}</small>
                            @endif
                            <span class="subject-badge subject-{{ $message->subject ?? 'general' }}">
                                @switch($message->subject)
                                    @case('booking')
                                        مشكلة في الحجز
                                        @break
                                    @case('payment')
                                        مشكلة في الدفع
                                        @break
                                    @case('complaint')
                                        شكوى
                                        @break
                                    @case('suggestion')
                                        اقتراح
                                        @break
                                    @case('partnership')
                                        شراكة
                                        @break
                                    @default
                                        استفسار عام
                                @endswitch
                            </span>
                        </div>
                    </div>
                    <div class="message-meta">
                        @if($message->email)
                        <span><i class="fas fa-envelope"></i> {{ $message->email }}</span>
                        @endif
                        @if($message->phone)
                        <span><i class="fas fa-phone"></i> {{ $message->phone }}</span>
                        @endif
                        @if($message->created_at)
                        <span><i class="fas fa-calendar"></i> {{ $message->created_at->format('Y-m-d H:i') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="custom-control custom-checkbox d-inline-block mr-2" title="{{ app()->getLocale() == 'ar' ? 'تحديد' : 'Select' }}">
                        <input type="checkbox" form="bulkDeleteFormEnhanced" class="custom-control-input message-checkbox-enhanced" id="msg_{{ $message->id }}" name="ids[]" value="{{ $message->id }}">
                        <label class="custom-control-label" for="msg_{{ $message->id }}"></label>
                    </div>
                    <button class="btn btn-reply btn-sm" onclick="replyToMessage({{ $message->id }}, '{{ $message->email }}')">
                        <i class="fas fa-reply"></i> رد
                    </button>
                    <button class="btn btn-info btn-sm" onclick="toggleMessage({{ $message->id }})">
                        <i class="fas fa-eye"></i> عرض
                    </button>
                    <form action="{{ route('customer-messages.destroy', $message->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="message-body" id="message-{{ $message->id }}" style="display: none;">
            <h6>الرسالة:</h6>
            <p class="text-muted">{{ $message->message }}</p>
            @if($message->reply)
            <div class="alert alert-success mt-3">
                <h6><i class="fas fa-reply"></i> الرد:</h6>
                <p>{{ $message->reply }}</p>
                <small>تم الرد بتاريخ: {{ $message->replied_at }}</small>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="alert alert-info text-center">
        <i class="fas fa-inbox fa-3x mb-3"></i>
        <h5>لا توجد رسائل</h5>
        <p>لم يتم استلام أي رسائل من نموذج الاتصال بعد</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $customer_messages->links() }}
</div>

{{-- bulk delete form moved to top (no nesting) --}}

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">الرد على الرسالة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="replyForm" method="POST" onsubmit="showReplyLoading()">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>إلى:</label>
                        <input type="email" id="replyEmail" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>الموضوع:</label>
                        <input type="text" name="subject" class="form-control" value="رد على استفسارك" required>
                    </div>
                    <div class="form-group">
                        <label>الرسالة:</label>
                        <textarea name="message" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary" id="replyBtn">
                        <i class="fas fa-paper-plane"></i> إرسال الرد
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
// Fix for modal backdrop issue
$(document).ready(function() {
    // Remove backdrop whenever modal is shown
    $('#replyModal').on('shown.bs.modal', function () {
        $('.modal-backdrop').remove();
        $(this).find('textarea[name="message"]').focus();
    });
    
    // Clean up when modal is hidden
    $('#replyModal').on('hidden.bs.modal', function () {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    });
});

function toggleMessage(id) {
    $('#message-' + id).slideToggle();
    
    // Mark as read
    $.ajax({
        url: '{{ url("customer-messages") }}/' + id + '/mark-read',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function() {
            $('#message-' + id).closest('.message-card').removeClass('unread');
        }
    });
}

function replyToMessage(id, email) {
    // Set form values
    $('#replyEmail').val(email);
    $('#replyForm').attr('action', '{{ url("customer-messages") }}/' + id + '/reply');
    
    // Simply show the modal
    $('#replyModal').modal('show');
    
    // Remove backdrop after modal shows
    setTimeout(function() {
        $('.modal-backdrop').remove();
        $('#replyModal').find('textarea[name="message"]').focus();
    }, 200);
}

function markAllAsRead() {
    if (confirm('هل تريد تحديد جميع الرسائل كمقروءة؟')) {
        $.ajax({
            url: '{{ url("customer-messages/mark-all-read") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function() {
                $('.message-card').removeClass('unread');
                toastr.success('تم تحديد جميع الرسائل كمقروءة');
            }
        });
    }
}

function showReplyLoading() {
    $('#replyBtn').html('<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...').prop('disabled', true);
}

// Bulk select + delete
$(document).ready(function() {
    const $selectAll = $('#selectAllMessagesEnhanced');
    const $bulkBtn = $('#bulkDeleteBtnEnhanced');
    const $boxes = () => $('.message-checkbox-enhanced');

    function updateBulkState() {
        const total = $boxes().length;
        const checked = $boxes().filter(':checked').length;
        $bulkBtn.prop('disabled', checked === 0);
        $selectAll.prop('checked', total > 0 && checked === total);
    }

    $selectAll.on('change', function() {
        $boxes().prop('checked', this.checked);
        updateBulkState();
    });

    $(document).on('change', '.message-checkbox-enhanced', function() {
        updateBulkState();
    });

    $('#bulkDeleteFormEnhanced').on('submit', function(e) {
        if ($boxes().filter(':checked').length === 0) {
            e.preventDefault();
            return false;
        }
        if (!confirm('{{ app()->getLocale() == "ar" ? "هل أنت متأكد من حذف الرسائل المحددة؟" : "Are you sure you want to delete selected messages?" }}')) {
            e.preventDefault();
            return false;
        }
    });

    updateBulkState();
});
</script>
@endsection
