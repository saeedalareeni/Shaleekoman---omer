<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- <script>
        $(document).ready(function() {
        $('select[name="city"]').on('change', function() {
            var city_id = $(this).val();
            //console.log(college_id);
            if (city_id) {
                $.ajax({
                    url: "{{ URL::to('getareas') }}/" + city_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="area"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="area"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script> --}}
<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // تهيئة Select2 لجميع القوائم المنسدلة
        $('#citySelect, #areaSelect, #categorySelect, #priceSelect').select2();

        $('#citySelect').on('change', function() {
            let cityId = $(this).val();
            let areaSelect = $('#areaSelect');

            if (cityId) {
                areaSelect.html('<option value="0">جارٍ التحميل...</option>').trigger('change');

                $.ajax({
                    url: '{{ route('get.areas') }}',
                    type: 'GET',
                    data: { city_id: cityId },
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        areaSelect.empty().append('<option value="0">{{ trans('back.filter_area') }} {{ trans('back.all') }}</option>');

                        $.each(data, function(key, value) {
                            areaSelect.append($('<option>', {
                                value: value.id,
                                text: value.name
                            }));
                        });

                        areaSelect.trigger('change'); // تحديث Select2 بعد تغيير المحتوى
                    },
                    error: function() {
                        console.error('Error fetching areas.');
                        areaSelect.html('<option value="0">{{ trans('back.filter_area') }} {{ trans('back.all') }}</option>').trigger('change');
                    }
                });
            } else {
                areaSelect.empty().append('<option value="0">{{ trans('back.filter_area') }} {{ trans('back.all') }}</option>').trigger('change');
            }
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function toggleWishlist(element, chaletId) {
        if (!@json(auth('customer')->check())) {
            if (confirm('{{ app()->getLocale() == "ar" ? "يجب تسجيل الدخول أولاً لإضافة الشاليه إلى المفضلة. هل تريد الذهاب إلى صفحة تسجيل الدخول؟" : "Please login first to add this chalet to wishlist. Do you want to go to login page?" }}')) {
                window.location.href = '{{ route("login") }}';
            }
            return;
        }

        const wishlistUrl = @json(route('wishlist.toggle', ['chalet' => '__CHALET_ID__']));

        fetch(wishlistUrl.replace('__CHALET_ID__', encodeURIComponent(chaletId)), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'added') {
                element.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                    </svg>`;
                Swal.fire({
                    icon: 'success',
                    text: 'تمت الإضافة  إلى المفضلة!',
                    timer: 1500,
                    showConfirmButton: false,
                    width: '300px'
                });
            } else {
                element.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                    </svg>`;
                Swal.fire({
                    icon: 'info',
                    // title: 'تمت الإزالة',
                    text: 'تمت الإزالة من المفضلة.',
                    timer: 1500,
                    showConfirmButton: false,
                    width: '300px'
                });
            }
        });
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-wishlist-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const chaletId = this.dataset.id;

                const wishlistUrl = @json(route('wishlist.toggle', ['chalet' => '__CHALET_ID__']));

                fetch(wishlistUrl.replace('__CHALET_ID__', encodeURIComponent(chaletId)), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'removed') {
                        this.closest('tr').remove();

                        const tbody = document.querySelector('table tbody');
                        if (tbody.children.length === 0) {
                            tbody.innerHTML = `<tr><td colspan="4">{{ __('back.not_found') }}</td></tr>`;
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'تم الحذف',
                            text: 'تمت إزالة الشاليه من المفضلة.',
                            timer: 1500,
                            showConfirmButton: false,
                            width: '400px'
                        });
                    }
                });
            });
        });
    });
</script>




@include('sweetalert::alert')

@yield('js')
