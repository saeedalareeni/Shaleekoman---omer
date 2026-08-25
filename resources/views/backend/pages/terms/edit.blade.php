@extends('backend.layouts.master')

@section('title')
تعديل الصفحة
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>تعديل الصفحة</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('terms.update', $term->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>العنوان (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" 
                                       value="{{ old('title_ar', $term->title_ar) }}" required>
                                @error('title_ar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (English) <span class="text-danger">*</span></label>
                                <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" 
                                       value="{{ old('title_en', $term->title_en) }}" required>
                                @error('title_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>المحتوى (عربي) <span class="text-danger">*</span></label>
                                <textarea name="content_ar" class="form-control summernote @error('content_ar') is-invalid @enderror" 
                                          rows="10" required>{{ old('content_ar', $term->content_ar) }}</textarea>
                                @error('content_ar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Content (English) <span class="text-danger">*</span></label>
                                <textarea name="content_en" class="form-control summernote @error('content_en') is-invalid @enderror" 
                                          rows="10" required>{{ old('content_en', $term->content_en) }}</textarea>
                                @error('content_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>النوع <span class="text-danger">*</span></label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="">اختر النوع</option>
                                    <option value="terms" {{ old('type', $term->type) == 'terms' ? 'selected' : '' }}>الشروط والأحكام</option>
                                    <option value="privacy" {{ old('type', $term->type) == 'privacy' ? 'selected' : '' }}>سياسة الخصوصية</option>
                                    <option value="refund" {{ old('type', $term->type) == 'refund' ? 'selected' : '' }}>سياسة الاسترداد</option>
                                    <option value="cookies" {{ old('type', $term->type) == 'cookies' ? 'selected' : '' }}>سياسة ملفات تعريف الارتباط</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $term->order) }}">
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>الإصدار</label>
                                <input type="text" name="version" class="form-control" value="{{ old('version', $term->version) }}">
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>تاريخ السريان</label>
                                <input type="date" name="effective_date" class="form-control" 
                                       value="{{ old('effective_date', $term->effective_date ? $term->effective_date->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>الحالة</label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $term->is_active ? 'selected' : '' }}>مفعل</option>
                                    <option value="0" {{ !$term->is_active ? 'selected' : '' }}>معطل</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> تحديث
                        </button>
                        <a href="{{ route('terms.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
$(document).ready(function() {
    $('.summernote').summernote({
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});
</script>
@endsection
