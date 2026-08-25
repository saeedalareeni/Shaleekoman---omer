<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

@include('backend.layouts.head')

<body @if(app()->getLocale() == 'ar') dir="rtl" style="direction: rtl !important;" @else dir="ltr" style="direction: ltr !important;" @endif>

    <!-- Container خاص للمودالات (الحل الجديد) -->
    <div id="modal-fix-container"></div>
    
    <div id="wrapper">
        @include('backend.layouts.modern-header')

        <div class="content-page" style="margin: 70px auto 0 auto; max-width: 100%; padding: 0 15px;">
            <div class="content" style="padding: 20px 0;">
                <div class="container-fluid" style="max-width: 1400px; margin: 0 auto;">

                    <!-- Page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="page-title">@yield('title')</h4>
                            </div>
                        </div>
                    </div>

                    @include('flash-message')
                    @yield('content')

                </div> <!-- container-fluid -->
            </div> <!-- content -->
        </div>
    </div>

    <!-- jQuery + Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    @include('backend.layouts.script')
    @include('sweetalert::alert')
    @stack('scripts')

    <!-- =============================
         الحل المختصر لمشكلة التعتيم
    ============================== -->
    <style>
        /* 1. تأكد أن المودال فوق كل شيء */
        .modal {
            z-index: 99999 !important;
            position: fixed !important;
        }
        
        /* 2. تأكد أن الخلفية تحت المودال */
        .modal-backdrop {
            z-index: 99998 !important;
            background-color: rgba(0, 0, 0, 0.5) !important;
        }
        
        /* 3. إصلاح مشكلة التمرير */
        body.modal-open {
            overflow: hidden !important;
            padding-right: 0 !important;
        }
        
        /* 4. إخفاء أي عناصر قد تظهر خلف المودال */
        .navbar-fixed,
        .fixed-top,
        .sticky-top {
            z-index: 1000 !important;
        }
        
        /* 5. تأكد أن محتوى الصفحة لا يتجاوز */
        #wrapper,
        .content-page {
            position: relative !important;
            z-index: 1 !important;
        }
        
        /* 6. إصلاح عرض المودال */
        .modal.show {
            display: block !important;
            overflow-y: auto !important;
        }
        
        /* 7. تنسيق جميل للمودال */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        
        /* 8. منع ظهور أي عنصر خلف المودال */
        [style*="z-index: 9999"],
        [style*="z-index: 10000"] {
            display: none !important;
        }
    </style>

    <script>
        $(document).ready(function () {
            console.log('بدء حل مشكلة التعتيم...');
            
            // ===========================================
            // الخطوة 1: نقل جميع المودالات إلى container خاص
            // ===========================================
            $('.modal').each(function() {
                $(this).appendTo('#modal-fix-container');
            });
            
            // ===========================================
            // الخطوة 2: تنظيف أي مشاكل سابقة
            // ===========================================
            function cleanPreviousProblems() {
                // إزالة أي backdrops زائدة
                $('.modal-backdrop').not(':first').remove();
                
                // إزالة class modal-open إذا لا يوجد مودال مفتوح
                if ($('.modal.show').length === 0) {
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                }
            }
            cleanPreviousProblems();
            
            // ===========================================
            // الخطوة 3: إدارة فتح المودالات
            // ===========================================
            $(document).on('show.bs.modal', '.modal', function(e) {
                console.log('فتح المودال...');
                
                // تنظيف أولاً
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                
                // إضافة backdrop جديد
                $('body').append('<div class="modal-backdrop fade shows"></div>');
                
                // ضبط الـ z-index
                $(this).css('z-index', '99999');
                $('.modal-backdrop').css('z-index', '99998');
                
                // منع تمرير الصفحة
                $('body').addClass('modal-open');
                $('body').css('overflow', 'hidden');
            });
            
            // ===========================================
            // الخطوة 4: إدارة إغلاق المودالات
            // ===========================================
            $(document).on('hidden.bs.modal', '.modal', function(e) {
                console.log('إغلاق المودال...');
                
                // إزالة الـ backdrop
                $('.modal-backdrop').remove();
                
                // إعادة تمكين التمرير
                $('body').removeClass('modal-open');
                $('body').css('overflow', 'auto');
            });
            
            // ===========================================
            // الخطوة 5: التركيز على أول حقل
            // ===========================================
            $(document).on('shown.bs.modal', function (e) {
                $(e.target).find('input, select, textarea').first().trigger('focus');
            });
            
            // ===========================================
            // الخطوة 6: حل سريع للطوارئ
            // ===========================================
            window.fixAllModals = function() {
                console.log('إصلاح جميع المودالات...');
                $('.modal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('overflow', 'auto');
            };
            
            // ===========================================
            // الخطوة 7: مراقبة وإصلاح تلقائي
            // ===========================================
            setInterval(function() {
                // إذا كان هناك backdrop بدون مودال مفتوح
                if ($('.modal-backdrop').length > 0 && $('.modal.show').length === 0) {
                    console.log('اكتشاف backdrop زائد - تنظيف...');
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                }
            }, 1000);
            
            console.log('تم حل مشكلة التعتيم بنجاح!');
        });
    </script>

</body>
</html>