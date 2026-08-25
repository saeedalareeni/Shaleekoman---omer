<script>
document.addEventListener('DOMContentLoaded', function () {
    const chaletId = {{ $chalet->id }};
    const stayDay = {{ $chalet->stay_price }};
    const halfDay = {{ $chalet->half_day_price }};
    const flatpickrInstance = flatpickr("#datePicker", {
        mode: "multiple",
        dateFormat: "Y-m-d",
        minDate: "today",
        inline: true,
        onChange: function (selectedDates, dateStr, instance) {
            fetchPrices(selectedDates);

            // تحويل التواريخ إلى نص بتنسيق "YYYY-MM-DD"
            const formattedDates = selectedDates.map(date => moment(date).format('YYYY-MM-DD'));

            // طباعة التواريخ في حقل مخفي أو عنصر input
            document.getElementById('data_booking').value = formattedDates.join(', '); // فصل التواريخ بفاصلة
        }
    });

    let bookingType = 'fullDay'; // القيمة الافتراضية هي يوم كامل

    // مراقبة تغيير نوع الحجز
    document.querySelectorAll('input[name="booking_type"]').forEach((radio) => {
        radio.addEventListener('change', function () {
            bookingType = this.value;
            fetchPrices(flatpickrInstance.selectedDates); // تحديث الأسعار بناءً على الاختيار
        });
    });

    function fetchPrices(dates) {
        const formattedDates = dates.map(date => moment(date).format('YYYY-MM-DD'));
        fetch(`/get-prices/${chaletId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ dates: formattedDates })
        })
            .then(response => response.json())
            .then(data => {
                displayPrices(data.prices, formattedDates);
                disableBookedDates(data.bookedDates);
            })
            .catch(error => {
                console.error('Error fetching prices:', error);
            });
    }

    function displayPrices(prices, selectedDates) {
        const pricesTableBody = document.querySelector('#pricesTable tbody');
        const totalPriceElement = document.getElementById('totalPrice');
        const totalAmountField = document.getElementById('totalAmount');
        pricesTableBody.innerHTML = '';

        let total = 0;
        prices.forEach(price => {
            if (selectedDates.includes(price.date)) {
                let finalPrice;

                // تغيير السعر بناءً على نوع الحجز
                if (bookingType === 'halfDay') {
                    finalPrice =   halfDay;
                } else if (bookingType === 'stayDay') {
                    finalPrice = stayDay;
                } else {
                    finalPrice = parseFloat(price.price); // السعر الافتراضي ليوم كامل
                }

                total += finalPrice;
                const row = document.createElement('tr');
                row.innerHTML = `<td>${price.date}</td><td>${finalPrice.toFixed(2)} {{__('back.currency') }} ${price.isCustom ? '(خاص)' : ''}</td>`;
                pricesTableBody.appendChild(row);
            }
        });

        totalPriceElement.textContent = `${total.toFixed(2)} {{__('back.currency') }}`;
        totalAmountField.innerHTML = `${total.toFixed(2)} {{__('back.currency') }}`;
        totalAmountField.setAttribute('data-original', total); // ← خزّن القيمة الأصلية
    }

    function disableBookedDates(bookedDates) {
        const disabledDates = bookedDates.map(date => moment(date).toDate());
        flatpickrInstance.set('disable', disabledDates);
    }

    
    // جلب تواريخ الحجز لتعطيلها عند تحميل الصفحة
    fetchPrices([]);
});

</script>
<script>
    function copyToClipboard(text) {

        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
            icon: 'success',
            text: 'تم نسخ الرابط ✅',
            timer: 1500,
            width: 300,
            showConfirmButton: false
        });
        });
    }
</script>
<script>
    $(document).ready(function() {

        $('#toggle-coupon').on('click', function(e) {
            e.preventDefault();
            $('#coupon-section').toggle();
        });

        $('#check-coupon').on('click', function() {
            let lastCouponCode = ''; 
            let code = $('#coupon-code').val();
            let originalAmount = parseFloat($('#totalAmount').attr('data-original'));

            if (code === lastCouponCode) {
                return;
            }
            lastCouponCode = code;
            $('#coupon-error').hide().text('');

            $.ajax({
                url: "{{ route('coupon.check') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    code: code
                },
                success: function(response) {
                    if (response.valid) {
                        $('.total_after_discount').empty();
                        let discount = (originalAmount * response.discount_percentage) / 100;
                        let newTotal = originalAmount - discount;

                        let discountedTotalDiv = document.createElement('div');
                        discountedTotalDiv.classList.add('form-group', 'mt-0',
                            'discounted-total');
                        discountedTotalDiv.innerHTML =
                            `<strong>{{ __('back.total_after_discount') }}: </strong><label id="discountedAmount">${newTotal.toFixed(2)} {{ __('back.currency') }}</label>`;

                        $('.total_after_discount').append(discountedTotalDiv);

                        Swal.fire({
                            text: 'تم تطبيق الخصم بنجاح.'+ response.discount_percentage + '%',
                            icon: 'success',
                            width:300,
                            confirmButtonText: 'موافق'
                        });
                    } else {
                        $('#coupon-error').text(response.message).show();
                        $('.total_after_discount').empty();

                    }
                },
                error: function() {
                    $('#coupon-error').text('حدث خطأ أثناء التحقق من الكوبون').show();

                    Swal.fire({
                        title: 'حدث خطأ!',
                        text: 'يرجى المحاولة مرة أخرى.',
                        icon: 'error',
                        confirmButtonText: 'موافق'
                    });
                }
            });
        });

    });
</script>