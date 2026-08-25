@extends('backend.layouts.master')

@section('title')
الأسئلة الشائعة
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>الأسئلة الشائعة</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('faqs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> إضافة سؤال جديد
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">السؤال</th>
                                <th width="35%">الإجابة</th>
                                <th width="10%">الفئة</th>
                                <th width="5%">الترتيب</th>
                                <th width="10%">الحالة</th>
                                <th width="10%">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>عربي:</strong> {{ Str::limit($faq->question_ar, 50) }}<br>
                                    <strong>English:</strong> {{ Str::limit($faq->question_en, 50) }}
                                </td>
                                <td>
                                    <strong>عربي:</strong> {{ Str::limit($faq->answer_ar, 100) }}<br>
                                    <strong>English:</strong> {{ Str::limit($faq->answer_en, 100) }}
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $faq->category_label }}</span>
                                </td>
                                <td>{{ $faq->order }}</td>
                                <td>
                                    <form action="{{ route('faqs.toggle-status', $faq->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $faq->is_active ? 'btn-success' : 'btn-danger' }}">
                                            {{ $faq->is_active ? 'مفعل' : 'معطل' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">لا توجد أسئلة شائعة</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
