@extends('backend.layouts.master')

@section('content')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 0;
        margin-bottom: 40px;
        border-radius: 0 0 20px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .profile-header h1 {
        color: white;
        margin: 0;
        font-size: 32px;
        font-weight: 600;
    }
    
    .profile-header p {
        color: rgba(255,255,255,0.9);
        margin: 10px 0 0;
        font-size: 16px;
    }
    
    .profile-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .profile-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .card-header {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 20px 25px;
        border-bottom: none;
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .card-header i {
        margin-left: 10px;
        color: #667eea;
    }
    
    .card-body {
        padding: 30px;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 15px;
        transition: all 0.3s ease;
        font-size: 15px;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .input-group {
        position: relative;
    }
    
    .input-group-text {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px 0 0 8px;
        color: #667eea;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 35px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary {
        background: #6c757d;
        border: none;
        padding: 12px 35px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        z-index: 10;
    }
    
    .password-toggle:hover {
        color: #495057;
    }
    
    .divider {
        height: 1px;
        background: linear-gradient(to right, transparent, #e0e0e0, transparent);
        margin: 30px 0;
    }
    
    .text-muted {
        color: #6c757d !important;
        font-size: 13px;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
    }
    
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: bold;
        margin: 0 auto 20px;
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    }
</style>

<div class="profile-header">
    <div class="container">
        <h1>{{ __('back.profile') }}</h1>
        <p>{{ __('back.manage_your_account') }}</p>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> 
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Profile Form -->
            <div class="profile-card">
                <div class="card-header">
                    <i class="fas fa-user-edit"></i> {{ __('back.edit_profile') }}
                </div>
                <div class="card-body">
                    <!-- Profile Avatar -->
                    <div class="profile-avatar">
                        {{ strtoupper(substr($admin->name ?? 'A', 0, 1)) }}
                    </div>
                    
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information -->
                        <h5 class="mb-3"><i class="fas fa-info-circle"></i> {{ __('back.basic_information') }}</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('back.name') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('back.email') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">{{ __('back.phone') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $admin->phone ?? '') }}" placeholder="+968 xxxx xxxx">
                            </div>
                        </div>
                        
                        <div class="divider"></div>
                        
                        <!-- Change Password Section -->
                        <h5 class="mb-3"><i class="fas fa-lock"></i> {{ __('back.change_password') }}</h5>
                        <p class="text-muted mb-3">{{ __('back.leave_blank_to_keep_current') }}</p>
                        
                        <div class="form-group">
                            <label class="form-label">{{ __('back.current_password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" name="current_password" class="form-control" id="current_password">
                                <span class="password-toggle" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('back.new_password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="new_password" class="form-control" id="new_password">
                                        <span class="password-toggle" onclick="togglePassword('new_password')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                    <small class="text-muted">{{ __('back.minimum_8_characters') }}</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('back.confirm_new_password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock-open"></i></span>
                                        <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation">
                                        <span class="password-toggle" onclick="togglePassword('new_password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="divider"></div>
                        
                        <!-- Submit Buttons -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('back.save_changes') }}
                            </button>
                            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> {{ __('back.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = event.currentTarget.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
