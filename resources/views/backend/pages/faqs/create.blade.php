@extends('backend.layouts.master')

@section('title')
إضافة سؤال جديد
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>إضافة سؤال جديد</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('faqs.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>السؤال (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="question_ar" class="form-control @error('question_ar') is-invalid @enderror" 
                                       value="{{ old('question_ar') }}" required>
                                @error('question_ar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question (English) <span class="text-danger">*</span></label>
                                <input type="text" name="question_en" class="form-control @error('question_en') is-invalid @enderror" 
                                       value="{{ old('question_en') }}" required>
                                @error('question_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>الإجابة (عربي) <span class="text-danger">*</span></label>
                                <textarea name="answer_ar" class="form-control @error('answer_ar') is-invalid @enderror" 
                                          rows="4" required>{{ old('answer_ar') }}</textarea>
                                @error('answer_ar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Answer (English) <span class="text-danger">*</span></label>
                                <textarea name="answer_en" class="form-control @error('answer_en') is-invalid @enderror" 
                                          rows="4" required>{{ old('answer_en') }}</textarea>
                                @error('answer_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>الفئة <span class="text-danger">*</span></label>
                                <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                                    <option value="">اختر الفئة</option>
                                    <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>عام</option>
                                    <option value="booking" {{ old('category') == 'booking' ? 'selected' : '' }}>الحجز</option>
                                    <option value="payment" {{ old('category') == 'payment' ? 'selected' : '' }}>الدفع</option>
                                    <option value="cancellation" {{ old('category') == 'cancellation' ? 'selected' : '' }}>الإلغاء</option>
                                    <option value="owner" {{ old('category') == 'owner' ? 'selected' : '' }}>المالك</option>
                                </select>
                                @error('category')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>الحالة</label>
                                <select name="is_active" class="form-control">
                                    <option value="1">مفعل</option>
                                    <option value="0">معطل</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> حفظ
                        </button>
                        <a href="{{ route('faqs.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
