$(document).ready(function() {
    // var total_commission=0;
    // var site_commission = parseFloat(document.getElementsByName("site_commission")[0].value);
    // var second_commission = parseFloat(document.getElementsByName("second_commission")[0].value);
    // var gate_fee = parseFloat(document.getElementsByName("gate_fee")[0].value);
    // var env_fee = parseFloat(document.getElementsByName("env_fee")[0].value);
    // var titlepickupfee = parseFloat(document.getElementsByName("titlepickupfee")[0].value);
    // total_commission = site_commission + second_commission + gate_fee + env_fee + titlepickupfee;
    // document.getElementById("total_commission").value = total_commission;


    $('select[name="auction_type_id"]').on('change', function() {
        var auction_type_id = $(this).val();
        if (auction_type_id) {
            $.ajax({
                url: "{{ URL::to('getarea') }}/" + auction_type_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('select[name="area_id"]').empty();
                    $('select[name="area_id"]').append('<option value="" selected disabled>اختر المنطقة</option>');
                    $.each(data, function(key, value) {
                        $('select[name="area_id"]').append('<option value="' + value.id + '">' + value.price + ' / ' + value.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX load did not work:', xhr.responseText);
                }
            });
        } else {
            console.log('AJAX load did not work');
        }
    });
});


// سعر انوع السيارات
$('select[name="car_type_id"]').on('change', function() {
    var carTypeId = $(this).val();
    console.log(carTypeId);
    $.ajax({
        url: "{{ URL::to('get_price_car_type') }}/" + carTypeId,
        type: 'GET',
        data: { car_type_id: carTypeId },
        success: function(response) {
            console.log(response.price);
            $('#price_car_type').val(response.price);
            UpdateTotal();
        },
        error: function(xhr) {
            console.error('خطأ في جلب السعر:', xhr.responseText);
        }
    });
});

// سعر انواع البنزين
$('select[name="fuel_type_id"]').on('change', function() {
    var fuel_type_id = $(this).val();
    $.ajax({
        url: "{{ URL::to('get_price_fuel_type') }}/" + fuel_type_id,
        type: 'GET',
        data: { fuel_type_id: fuel_type_id },
        success: function(response) {
            console.log(response.price);
            $('#price_fuel_type').val(response.price);
            UpdateTotal();
        },
        error: function(xhr) {
            console.error('خطأ في جلب السعر:', xhr.responseText);
        }
    });
});

// سعر انواع البنزين
$('select[name="area_id"]').on('change', function() {
    var area_id = $(this).val();
    $.ajax({
        url: "{{ URL::to('get_price_area') }}/" + area_id,
        type: 'GET',
        data: { area_id: area_id },
        success: function(response) {
            console.log(response.price);
            $('#price_area').val(response.price);
            UpdateTotal();
        },
        error: function(xhr) {
            console.error('خطأ في جلب السعر:', xhr.responseText);
        }
    });
});

    // عمولة الموقع
    $('#site_commission').on('keyup blur', function() {
        // if ($(this).val() === '') {
        //     $(this).val('0');
        // }
        UpdateTotal();
    });

    // عمولة الموقع الثانية
    $('#second_commission').on('keyup blur', function() {
        UpdateTotal();
    });

    //  سعر الشحن البحري
    $('#price_shipping_sea').on('keyup blur', function() {
        UpdateTotal();
    });


    $('#price_car').on('keyup blur', function() {
        UpdateTotal();

    });

     // العمولة الاولي
    function FirstCommission(){
        var first_commission=0;
        var price_car = parseFloat(document.getElementsByName("price_car")[0].value);

        if(price_car >= 0 && price_car <=49.99){
            first_commission = 25;
        }
        else if(price_car >= 50 && price_car <= 99.99){
            first_commission = 45;
        }
        else if(price_car >= 100 && price_car <= 100.99){
            first_commission = 80;
        }
        else if(price_car >= 200 && price_car <= 200.99){
            first_commission = 130;
        }
        else if(price_car >= 300 && price_car <= 349.99){
            first_commission = 132.50;
        }
        else if(price_car >= 350 && price_car <= 399.99){
            first_commission = 135;
        }
        else if(price_car >= 400 && price_car <= 449.99){
            first_commission = 170;
        }
        else if(price_car >= 450 && price_car <= 499.99){
            first_commission = 180;
        }
        else if(price_car >= 500 && price_car <= 549.99){
            first_commission = 200;
        }
        else if(price_car >= 550 && price_car <= 599.99){
            first_commission = 205;
        }
        else if(price_car >= 600 && price_car <= 699.99){
            first_commission = 235;
        }
        else if(price_car >= 700 && price_car <= 799.99){
            first_commission = 260;
        }
        else if(price_car >= 800 && price_car <= 899.99){
            first_commission = 280;
        }
        else if(price_car >= 900 && price_car <= 999.99){
            first_commission = 305;
        }
        else if(price_car >= 1000 && price_car <= 1199.99){
            first_commission = 355;
        }
        else if(price_car >= 1200 && price_car <= 1299.99){
            first_commission = 380;
        }
        else if(price_car >= 1300 && price_car <= 1399.99){
            first_commission = 400;
        }
        else if(price_car >= 1400 && price_car <= 1499.99){
            first_commission = 410;
        }
        else if(price_car >= 1500 && price_car <= 1599.99){
            first_commission = 420;
        }
        else if(price_car >= 1600 && price_car <= 1699.99){
            first_commission = 440;
        }
        else if(price_car >= 1700 && price_car <= 1799.99){
            first_commission = 450;
        }
        else if(price_car >= 1800 && price_car <= 1999.99){
            first_commission = 465;
        }
        else if(price_car >= 2000 && price_car <= 2399.99){
            first_commission = 500;
        }
        else if(price_car >= 2400 && price_car <= 2499.99){
            first_commission = 525;
        }
        else if(price_car >= 2500 && price_car <= 2999.99){
            first_commission = 550;
        }
        else if(price_car >= 3000 && price_car <= 3499.99){
            first_commission = 650;
        }
        else if(price_car >= 3500 && price_car <= 3999.99){
            first_commission = 700;
        }
        else if(price_car >= 4000 && price_car <= 4499.99){
            first_commission = 725;
        }
        else if(price_car >= 4500 && price_car <= 4999.99){
            first_commission = 750;
        }
        else if(price_car >= 5000 && price_car <= 5999.99){
            first_commission = 775;
        }
        else if(price_car >= 6000 && price_car <= 6999.99){
            first_commission = 800;
        }
        else if(price_car >= 7000 && price_car <= 7999.99){
            first_commission = 825;
        }
        else if(price_car >= 8000 && price_car <= 9999.99){
            first_commission = 850;
        }
        else if(price_car >= 10000 && price_car <= 14999.99){
            first_commission = 900;
        }
        else if(price_car >= 15000){
            first_commission = price_car * (7.50 / 100);
        }
        document.getElementsByName("site_commission")[0].value=first_commission;
    }

    // العمولة الاولي
    function SecondCommission(){
        var second_commission=0;
        var price_car = parseFloat(document.getElementsByName("price_car")[0].value);

        if(price_car >= 100 && price_car <= 499.99){
            second_commission = 49;
        }
        else if(price_car >= 500 && price_car <= 999.99){
            second_commission = 59;
        }
        else if(price_car >= 1000 && price_car <= 1499.99){
            second_commission = 79;
        }
        else if(price_car >= 1500 && price_car <= 1999.99){
            second_commission = 89;
        }
        else if(price_car >= 2000 && price_car <= 3999.99){
            second_commission = 99;
        }
        else if(price_car >= 4000 && price_car <= 5999.99){
            second_commission = 109;
        }
        else if(price_car >= 6000 && price_car <= 7999.99){
            second_commission = 139;
        }
        else if(price_car >= 8000){
            second_commission = 149;
        }
        document.getElementsByName("second_commission")[0].value=second_commission;
    }

    // دالة تحسب المجموع النهائي لسعر السيارة
    function UpdateTotal() {
        FirstCommission();
        SecondCommission();
        var total_commission=0;
        var price_after_site_commission = 0;
        var total = 0;
        var price_car = parseFloat(document.getElementsByName("price_car")[0].value);
        var price_car_type = parseFloat(document.getElementsByName("price_car_type")[0].value);
        var price_fuel_type = parseFloat(document.getElementsByName("price_fuel_type")[0].value);
        var price_shipping_sea = parseFloat(document.getElementsByName("price_shipping_sea")[0].value);
        var price_area = parseFloat(document.getElementsByName("price_area")[0].value);

        // حقول العمولة
        var site_commission = parseFloat(document.getElementsByName("site_commission")[0].value);
        var second_commission = parseFloat(document.getElementsByName("second_commission")[0].value);
        var gate_fee = parseFloat(document.getElementsByName("gate_fee")[0].value);
        var env_fee = parseFloat(document.getElementsByName("env_fee")[0].value);
        var titlepickupfee = parseFloat(document.getElementsByName("titlepickupfee")[0].value);
        total_commission = site_commission + second_commission + gate_fee + env_fee + titlepickupfee;
        document.getElementById("total_commission").value = total_commission;

        price_after_site_commission = total_commission + price_car;
        document.getElementById("price_after_site_commission").value = price_after_site_commission;
        total = price_after_site_commission + price_car_type + price_fuel_type + price_area + price_shipping_sea;
        document.getElementById("total_price_car").value = total;


    }
// });
