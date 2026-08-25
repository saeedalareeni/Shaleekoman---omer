@extends('backend.layouts.master')

@section('page_title', $chalet->name)
@section('title', $chalet->name)

@section('content')

    <div class="row mb-2">
        <div class="col-md-12">
            <a href="{{route('chalets.index')}}" class="btn btn-primary btn-sm">
                العودة لكل الشاليهات
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <h5>الأسعار : </h5>
            <div class="card-box">
                <div class="container">
                    <div id='calendarChalet'></div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <h5>تعديل الأسعار : </h5>
            <div class="card-box">
                <div class="container">
                    <h5 class="text-danger font-weight-bold">
                        تحديث السعر حسب الأيام المختارة:
                    </h5>
                    <form action="{{ route('chalet.prices.update', $chalet->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="dates">اختر التاريخ/التواريخ</label>
                                <input type="text" id="dates" name="dates" class="form-control" placeholder="اختر التواريخ">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="price">السعر</label>
                                <input type="number" step="0.01" id="price" name="price" class="form-control" placeholder="أدخل السعر">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">تحديث السعر</button>
                    </form>
                </div>
                <hr>

                <!-- النموذج الجديد لتحديث سعر شهر كامل -->
                <div class="container mt-2">
                    <h5 class="text-danger font-weight-bold">
                        تحديث السعر حسب الشهور:
                    </h5>
                    <form action="{{ route('chalet.prices.update', $chalet->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="month">اختر الشهر</label>
                                <input type="text" id="month" name="month" class="form-control" placeholder="اختر الشهر">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="price_month">سعر الشهر</label>
                                <input type="number" step="0.01" id="price_month" name="price_month" class="form-control" placeholder="أدخل سعر الشهر">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">تحديث سعر الشهر</button>
                    </form>
                </div>
                <hr>

                <!-- النموذج الجديد لتحديث سعر يوم محدد في عدة أشهر -->
                <div class="container mt-2">
                    <h5 class="text-danger font-weight-bold">
                        تحديث السعر وتكراره لمدة معينة:
                    </h5>
                    <form action="{{ route('chalet.prices.update.recurrence', $chalet->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="weekday">اختر يوم الأسبوع</label>
                                <select id="weekday" name="weekday" class="form-control">
                                    <option value="0">الأحد</option>
                                    <option value="1">الاثنين</option>
                                    <option value="2">الثلاثاء</option>
                                    <option value="3">الأربعاء</option>
                                    <option value="4">الخميس</option>
                                    <option value="5">الجمعة</option>
                                    <option value="6">السبت</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="months">عدد الأشهر</label>
                                <input type="number" id="months" name="months" class="form-control" placeholder="عدد الأشهر" min="1">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="price_recurrence">سعر التكرار</label>
                                <input type="number" step="0.01" id="price_recurrence" name="price_recurrence" class="form-control" placeholder="أدخل سعر التكرار">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">تحديث السعر للأيام المحددة</button>
                    </form>
                </div>


            </div>
        </div>

    </div>
@endsection

@section('js')
    <!-- Plugin css -->
    <link href="{{ asset('backend/assets/libs/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <!-- Include month select plugin CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

    <!-- Include month select plugin JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>



    <!-- fullcalendar plugins -->
    <script src="{{ asset('backend/assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/fullcalendar.init.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- FullCalendar Locale Files -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/ar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/en-gb.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Include flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            $('#calendarChalet').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                locale: '{{ app()->getLocale() }}',
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: '{{ route('chalets.prices.data', $chalet) }}',
                        dataType: 'json',
                        success: function(data) {
                            var events = [];
                            $(data).each(function() {
                                var eventColor = '#378006'; // Default color for regular days
                                if (this.custom) {
                                    eventColor = '#FF0000'; // Color for changed prices
                                }
                                events.push({
                                    title: this.price,
                                    start: this.date,
                                    color: eventColor
                                });
                            });
                            callback(events);
                        },
                        error: function() {
                            console.error('Error fetching prices.');
                        }
                    });
                }
            });

            // Initialize Flatpickr for the date picker
            $('#dates').flatpickr({
                mode: "multiple",
                dateFormat: "Y-m-d"
            });

            // Initialize Flatpickr for the month picker
            $('#month').flatpickr({
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "Y-m",
                        altFormat: "F Y"
                    })
                ],
                mode: "single",
                dateFormat: "Y-m",
                altInput: true,
                altFormat: "F Y"
            });
        });


    </script>

@endsection
