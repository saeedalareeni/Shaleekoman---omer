<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{trans('back.login')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content=" {{app()->getLocale() == 'ar' ? App\Models\Setting::first()->company_name_ar : App\Models\Setting::first()->company_name_en}}" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ $siteFavicon ?? asset('assets/images/shaleek_logo.png') }}">

    @if (App::getLocale() == 'ar')
        <!-- Bootstrap Css -->
        <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('backend/assets/css/app-rtl.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    @else
        <!-- Bootstrap Css -->
        <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('backend/assets/css/app.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    @endif


    <link href="{{asset('backend/assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />

    {{-- Google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400&display=swap" rel="stylesheet">

    <!-- custom css -->
    <link href="{{asset('backend/custom.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/login-custom.css?v=2.0')}}" rel="stylesheet" type="text/css" />
    
    <style>
        /* Override Styles */
        .authentication-bg20 {
            position: relative;
            min-height: 100vh;
            background: #f5f7fa !important;
        }
        
        .authentication-bg20::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(18, 118, 100, 0.9) 0%, rgba(21, 146, 101, 0.85) 50%, rgba(223, 77, 45, 0.8) 100%) !important;
            z-index: 1;
        }
        
        /* Decorative circles */
        .authentication-bg20::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(223, 77, 45, 0.15) 0%, transparent 60%);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            z-index: 1;
        }
        
        .account-pages {
            position: relative;
            z-index: 2;
        }
        
        .text-center h4 {
            color: white !important;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .card {
            border: none !important;
            border-radius: 20px !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
            overflow: hidden;
            position: relative;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #127664 0%, #159265 50%, #DF4D2D 100%);
        }
        
        .card-body h4 {
            color: #127664 !important;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }
        
        .card-body h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #DF4D2D 0%, #FF6341 100%);
            border-radius: 2px;
        }
        
        .login-type-btn {
            background: white !important;
            border: 2px solid #e0e0e0 !important;
            color: #333 !important;
            border-radius: 15px !important;
            padding: 15px 20px !important;
            font-size: 1.1rem !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            margin-bottom: 1.5rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
            text-decoration: none !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        .login-type-btn::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 5px;
            background: #127664;
            transition: width 0.3s ease;
        }
        
        .login-type-btn:first-of-type {
            border-left: 5px solid #127664 !important;
        }
        
        .login-type-btn:last-of-type {
            border-left: 5px solid #DF4D2D !important;
        }
        
        .login-type-btn:first-of-type:hover {
            background: linear-gradient(135deg, #127664 0%, #159265 100%) !important;
            color: white !important;
            transform: translateX(5px) !important;
            box-shadow: 0 5px 15px rgba(18, 118, 100, 0.3) !important;
            text-decoration: none !important;
            border-color: #127664 !important;
        }
        
        .login-type-btn:last-of-type:hover {
            background: linear-gradient(135deg, #DF4D2D 0%, #FF6341 100%) !important;
            color: white !important;
            transform: translateX(5px) !important;
            box-shadow: 0 5px 15px rgba(223, 77, 45, 0.3) !important;
            text-decoration: none !important;
            border-color: #DF4D2D !important;
        }
        
        .login-type-btn i {
            font-size: 1.3rem;
            transition: transform 0.3s ease;
        }
        
        .login-type-btn:hover i {
            transform: scale(1.1);
        }
        
        /* RTL Support */
        [dir="rtl"] .login-type-btn {
            direction: rtl;
        }
        
        [dir="rtl"] .login-type-btn span {
            margin-right: 0 !important;
            margin-left: 5px !important;
        }
        
        [dir="rtl"] .login-type-btn:first-of-type {
            border-left: none !important;
            border-right: 5px solid #127664 !important;
        }
        
        [dir="rtl"] .login-type-btn:last-of-type {
            border-left: none !important;
            border-right: 5px solid #DF4D2D !important;
        }
        
        /* Additional decorative elements */
        .card::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(18, 118, 100, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(223, 77, 45, 0.06) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
        }
    </style>

</head>

<body class="authentication-bg20" style="background-image: url({{asset('backend/bg.jpg')}}) " >

    <div class="account-pages mt-5 mb-5">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">

                    <div class="text-center">
                        <a href="/" class="logo text-center">
                            <img  src="{{ $siteLogo ?? asset('assets/images/shaleek_logo.png') }}" width="150"  alt=" {{app()->getLocale() == 'ar' ? App\Models\Setting::first()->company_name_ar : App\Models\Setting::first()->company_name_en}}">
                        </a>
                        <h4 class=" mt-2 mb-2">
                            {{app()->getLocale() == 'ar' ? App\Models\Setting::first()->company_name_ar : App\Models\Setting::first()->company_name_en}}
                        </h4>
                    </div>

                    @include('flash-message')
                    <div class="card" style="position: relative;">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">{{trans('back.login')}}</h4>
                                <p style="color: #666; margin-top: 10px; font-size: 0.95rem;">
                                    {{ app()->getLocale() == 'ar' ? 'اختر نوع الحساب للمتابعة' : 'Select account type to continue' }}
                                </p>
                            </div>
                            
                            <a href="{{ route('admin.login') }}" class="btn btn-purple btn-block login-type-btn">
                                <span style="display: inline-block; width: 35px; height: 35px; background: linear-gradient(135deg, #127664 0%, #159265 100%); border-radius: 50%; line-height: 35px; margin-right: 5px;">
                                    <i class="mdi mdi-shield-account" style="color: white;"></i>
                                </span>
                                {{trans('back.login-admin')}}
                            </a>
                            
                            <a href="{{ route('owner.login') }}" class="btn btn-purple btn-block login-type-btn">
                                <span style="display: inline-block; width: 35px; height: 35px; background: linear-gradient(135deg, #DF4D2D 0%, #FF6341 100%); border-radius: 50%; line-height: 35px; margin-right: 5px;">
                                    <i class="mdi mdi-home-account" style="color: white;"></i>
                                </span>
                                {{trans('back.login-owner')}}
                            </a>
                            
                            <!-- Divider -->
                            <div style="position: relative; margin: 30px 0;">
                                <hr style="border: none; border-top: 1px solid #e0e0e0;">
                                <span style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: white; padding: 0 15px; color: #999; font-size: 0.9rem;">
                                    {{ app()->getLocale() == 'ar' ? 'أو' : 'OR' }}
                                </span>
                            </div>
                            
                            <!-- Customer Login Link -->
                            <div class="text-center">
                                <p style="color: #666; margin-bottom: 15px; font-size: 0.95rem;">
                                    {{ app()->getLocale() == 'ar' ? 'هل أنت عميل؟' : 'Are you a customer?' }}
                                </p>
                                <a href="{{ route('customer_login') }}" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #127664 0%, #DF4D2D 100%); color: white; border-radius: 25px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: all 0.3s;" 
                                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.25)';" 
                                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.2)';">
                                    <i class="mdi mdi-account-circle"></i>
                                    {{ app()->getLocale() == 'ar' ? 'تسجيل دخول العملاء' : 'Customer Login' }}
                                </a>
                            </div>
                            
                            <!-- Footer info -->
                            <div class="text-center mt-4" style="padding-top: 20px; border-top: 1px solid #f0f0f0;">
                                <small style="color: #999; font-size: 0.85rem;">
                                    © {{ date('Y') }} {{ app()->getLocale() == 'ar' ? 'جميع الحقوق محفوظة' : 'All rights reserved' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
