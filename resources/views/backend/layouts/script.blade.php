<!-- Vendor js -->
<script src="{{asset('backend/assets/js/vendor.min.js')}}"></script>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{asset('backend/assets/libs/pdfmake/vfs_fonts.js')}}"></script>
<!-- third party js ends -->

<!-- dropify js -->
<script src="{{asset('backend/assets/libs/dropify/dropify.min.js')}}"></script>

<!-- form-upload init -->
<script src="{{asset('backend/assets/js/pages/form-fileupload.init.js')}}"></script>

<!-- App js -->
<script src="{{asset('backend/assets/js/app.min.js')}}"></script>

<!-- Plugins Js -->
<script src="{{asset('backend/assets/libs/switchery/switchery.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/multiselect/jquery.multi-select.js')}}"></script>

<script src="{{asset('backend/assets/libs/select2/select2.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/jquery-mask-plugin/jquery.mask.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/moment/moment.js')}}"></script>
<script src="{{asset('backend/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>


<script src="{{asset('backend/assets/libs/select2/select2.min.js')}}"></script>
<script>
    $(".select2").select2({
        placeholder: "Select",
        allowClear: true
    });
</script>



{{-- بداية حساب المبلغ الباقي عند دفع مبلغ--}}
<script>
    $(document).ready(function (){

        $('form').on('keyup change', '#payment_amount', function (){
            $('#rest_amount').val(calculate_rest_amount());
        });

        // فانكشن لعمل العملية الحسابية
        function calculate_rest_amount(){
            let rest_amount = 0;
            let total_amount =  parseFloat($('#total_amount').val());
            let payment_amount = parseFloat($('#payment_amount').val());

            rest_amount = total_amount - payment_amount;
            return rest_amount.toFixed(2);
        }

    })
</script>
{{-- نهاية حساب المبلغ الباقي عند دفع مبلغ--}}



{{--Start ckeditor --}}
<script src="{{ asset('backend/ckeditor.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.editor').each(function() {
            const fieldName = ($(this).attr('name') || '').toLowerCase();
            const isEnglishField = fieldName.endsWith('_en') || fieldName.includes('english');
            const editorLanguage = isEnglishField ? 'en' : 'ar';
            const editorDirection = isEnglishField ? 'ltr' : 'rtl';

            CKEDITOR.replace(this, {
                extraPlugins: 'font,colorbutton,justify',
                toolbar: [
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
                    { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                    { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
                    { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                    { name: 'colors', items: ['TextColor', 'BGColor'] },
                    { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
                ],
                contentsLangDirection: editorDirection,
                defaultLanguage: editorLanguage,
                language: editorLanguage
            });
        });
    });
</script>
{{--End ckeditor --}}



{{--loader cleanup--}}
<script>
    // تنظيف أي loader متبقي من صفحات أخرى
    $(document).ready(function() {
        // إزالة أي loader متبقي فورًا
        $('.loader-wrapper').remove();
        $('.loader').remove();
        $('.preloader').remove();
        
        // إزالة أي overlay متبقي
        $('.modal-backdrop').remove();
        $('.rightbar-overlay').remove();
        $('[class*="overlay"]').each(function() {
            if($(this).css('position') == 'fixed' && $(this).css('z-index') > 1000) {
                $(this).remove();
            }
        });
        
        // إعادة تفعيل body
        $('body').removeClass('modal-open').css({
            'overflow': 'auto',
            'pointer-events': 'auto'
        });
    });
</script>


@include('sweetalert::alert')
@livewireScripts

{{-- Bootstrap 5 Modal Fallback --}}
<script>
    // Ensure Bootstrap 5 modals work with both data-toggle and data-bs-toggle
    document.addEventListener('DOMContentLoaded', function() {
        // Handle old Bootstrap 4 attributes
        var modals = document.querySelectorAll('[data-toggle="modal"]');
        modals.forEach(function(element) {
            element.addEventListener('click', function() {
                var target = this.getAttribute('data-target');
                if (target) {
                    var modal = document.querySelector(target);
                    if (modal) {
                        var bsModal = new bootstrap.Modal(modal);
                        bsModal.show();
                    }
                }
            });
        });
        
        // Initialize tooltips and popovers if present
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
    });
</script>

@yield('js')
