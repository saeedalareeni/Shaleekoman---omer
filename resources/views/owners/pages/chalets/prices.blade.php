@extends('owners.layouts.master')

@section('page_title', 'إدارة أسعار ' . $chalet->name)
@section('title', 'إدارة أسعار ' . $chalet->name)

@push('styles')
<style>
/* نفس ستايل لوحة التحكم */
.dashboard-container {
    background: #f8f9fa;
    min-height: 100vh;
    padding: 20px;
}

.pricing-header {
    background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border-top: 3px solid #ff6b35;
}

.pricing-header h1 {
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 10px;
    color: white !important;
}

.pricing-header h1 i {
    color: #ffc107;
}

.pricing-header .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.pricing-header .breadcrumb-item {
    color: rgba(255, 255, 255, 0.9);
}

.pricing-header .breadcrumb-item.active {
    color: #ffc107;
}

.pricing-header .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9) !important;
    text-decoration: none;
}

.pricing-header .breadcrumb-item a:hover {
    color: #ffc107 !important;
}

.pricing-card {
    background: white;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
}

.pricing-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
}

.section-title {
    color: #127664;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e0e0e0;
    position: relative;
}

.section-title:before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #ff6b35 0%, #ffc107 100%);
    border-radius: 2px;
}

.section-title i {
    color: #ff6b35;
    margin-left: 8px;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #e0e0e0;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #127664;
    box-shadow: 0 0 0 0.2rem rgba(18, 118, 100, 0.25);
}

.btn-primary {
    background: #127664;
    border: none;
    border-radius: 8px;
    padding: 10px 25px;
    font-weight: 500;
    color: white;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #0d5a4d;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(18, 118, 100, 0.3);
}

.btn-warning {
    background: #ff6b35;
    border: none;
    border-radius: 8px;
    padding: 10px 25px;
    font-weight: 500;
    color: white;
    transition: all 0.3s ease;
}

.btn-warning:hover {
    background: #ff5722;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    color: white;
}

.btn-success {
    background: #28a745;
    border: none;
    border-radius: 8px;
    padding: 10px 25px;
    font-weight: 500;
    color: white;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: #218838;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}

/* Calendar Styles */
#calendarChalet {
    background: white;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #ffe0d0;
    box-shadow: 0 2px 10px rgba(255, 107, 53, 0.08);
}

.fc-header-toolbar {
    background: linear-gradient(135deg, #fffaf5 0%, #fff5f0 100%);
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    border: 1px solid #ffe0d0;
}

.fc-button {
    background: linear-gradient(135deg, #127664 0%, #0d5a4d 100%) !important;
    border: none !important;
    border-radius: 6px !important;
    padding: 5px 15px !important;
    color: white !important;
    transition: all 0.3s ease !important;
}

.fc-button:hover {
    background: linear-gradient(135deg, #ff6b35 0%, #ff5722 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(255, 107, 53, 0.3);
}

.fc-button-primary:not(:disabled).fc-button-active {
    background: #ff6b35 !important;
    border-color: #ff6b35 !important;
}

.fc-event {
    border-radius: 5px;
    padding: 2px 5px;
    font-weight: 600;
    color: white !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
}

.alert-info {
    background: linear-gradient(135deg, #fff5f0 0%, #ffe8df 100%);
    color: #127664;
    border: 1px solid #ff6b35;
    border-radius: 8px;
    padding: 15px;
    font-weight: 500;
    border-left: 4px solid #ff6b35;
}

.alert-info strong {
    color: #ff6b35;
    font-weight: 700;
}

.alert-info i {
    color: #ff6b35;
}

.property-info {
    background: linear-gradient(135deg, white 0%, #fffaf5 100%);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    border: 1px solid #ffe0d0;
    box-shadow: 0 2px 8px rgba(255, 107, 53, 0.08);
    position: relative;
    overflow: hidden;
}

.property-info:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #ff6b35 0%, #ffc107 100%);
}

.property-info h5 {
    color: #127664;
    margin-bottom: 15px;
}

.property-info h5 i {
    color: #ff6b35;
}

.property-info .info-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #dee2e6;
}

.property-info .info-item:last-child {
    border-bottom: none;
}

.property-info .info-label {
    font-weight: 600;
    color: #6c757d;
}

.property-info .info-value {
    color: #ff6b35;
    font-weight: 700;
    font-size: 16px;
}

/* أنماط إضافية للتقويم */
.fc-today {
    background-color: rgba(18, 118, 100, 0.1) !important;
}

.fc-day-number {
    color: #127664;
    font-weight: 600;
}

.fc-event {
    border: none !important;
}

/* ألوان الأحداث في التقويم */
.fc-event[style*="378006"] {
    background: #127664 !important;
    border-color: #127664 !important;
    color: white !important;
}

.fc-event[style*="FF0000"] {
    background: #ff6b35 !important;
    border-color: #ff6b35 !important;
    color: white !important;
}

/* تحسين التقويم */
.fc-day-grid-event {
    padding: 3px 5px;
    font-weight: bold;
}

.fc-title {
    color: white !important;
    font-weight: 600;
}

.fc th {
    background: rgba(18, 118, 100, 0.1);
    color: #127664;
    font-weight: 600;
    padding: 10px;
}

.fc-day-header {
    color: #127664 !important;
    font-weight: 600;
}

/* تحسين مظهر الجداول */
.form-label {
    color: #127664;
    font-weight: 600;
}

label {
    color: #127664;
    font-weight: 600;
    margin-bottom: 8px;
}

/* أزرار إضافية */
.btn-light {
    background: white;
    border: 2px solid #ff6b35;
    color: #ff6b35;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-light:hover {
    background: #ff6b35;
    color: white !important;
    border-color: #ff6b35;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.btn-light i {
    transition: all 0.3s ease;
}

.btn-light:hover i {
    transform: translateX(5px);
}

/* تحسين الحقول */
select.form-control {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23127664' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    background-size: 16px 12px;
    padding-right: 2.5rem;
}

/* رسائل التنبيه */
.text-primary {
    color: #127664 !important;
}

.text-warning {
    color: #ff6b35 !important;
}

.text-success {
    color: #28a745 !important;
}

/* تحسين قراءة النصوص */
h6.text-primary {
    background: #f0f8f6;
    padding: 10px 15px;
    border-radius: 6px;
    border-left: 3px solid #127664;
    margin-bottom: 15px;
}

h6.text-warning {
    background: #fff5f0;
    padding: 10px 15px;
    border-radius: 6px;
    border-left: 3px solid #ff6b35;
    margin-bottom: 15px;
}

h6.text-success {
    background: #f0fdf4;
    padding: 10px 15px;
    border-radius: 6px;
    border-left: 3px solid #28a745;
    margin-bottom: 15px;
}

/* تحسين الفواصل */
hr {
    border: none;
    height: 2px;
    background: linear-gradient(90deg, transparent, #ff6b35, transparent);
    margin: 30px 0;
}

/* تحسينات إضافية */
.fc-today {
    background: linear-gradient(135deg, rgba(255, 107, 53, 0.1) 0%, rgba(255, 193, 7, 0.1) 100%) !important;
    border: 2px solid #ff6b35 !important;
}

.fc th {
    background: linear-gradient(135deg, #fffaf5 0%, #fff5f0 100%);
    color: #127664;
    font-weight: 600;
    padding: 10px;
    border-bottom: 2px solid #ff6b35;
}

/* تحسين الأزرار */
.btn-primary:focus,
.btn-warning:focus,
.btn-success:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
}

/* إضافة hover effect للبطاقات */
.pricing-card {
    position: relative;
    overflow: hidden;
}

.pricing-card:before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #ff6b35, #ffc107, #127664, #ff6b35);
    border-radius: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.pricing-card:hover:before {
    opacity: 0.1;
}
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <div class="pricing-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-calendar-alt mr-2"></i>إدارة أسعار {{ $chalet->chalet_name_ar ?? $chalet->name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}" style="color: rgba(255,255,255,0.8);">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('owner.chalets.index') }}" style="color: rgba(255,255,255,0.8);">العقارات</a></li>
                        <li class="breadcrumb-item active">إدارة الأسعار</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('owner.dashboard') }}" class="btn btn-light">
                    <i class="fas fa-arrow-right mr-2"></i>العودة للوحة التحكم
                </a>
            </div>
        </div>
    </div>

    <!-- معلومات العقار -->
    <div class="pricing-card property-info">
        <h5><i class="fas fa-home mr-2"></i>معلومات العقار</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="info-item">
                    <span class="info-label">اسم العقار:</span>
                    <span class="info-value">{{ $chalet->chalet_name_ar ?? $chalet->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">السعر الافتراضي:</span>
                    <span class="info-value">{{ number_format($chalet->default_day_price) }} ر.ع</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <span class="info-label">سعر الإجازات:</span>
                    <span class="info-value">{{ number_format($chalet->holiday_day_price) }} ر.ع</span>
                </div>
                <div class="info-item">
                    <span class="info-label">سعر نصف اليوم:</span>
                    <span class="info-value">{{ number_format($chalet->half_day_price) }} ر.ع</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="pricing-card">
                <h5 class="section-title"><i class="fas fa-calendar mr-2"></i>تقويم الأسعار</h5>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>ملاحظة:</strong> الأيام باللون الأخضر تستخدم السعر الافتراضي، والأيام باللون الأحمر لها أسعار مخصصة.
                </div>
                <div id='calendarChalet'></div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="pricing-card">
                <h5 class="section-title"><i class="fas fa-edit mr-2"></i>تحديث الأسعار</h5>
                <!-- تحديث أيام محددة -->
                <div class="mb-4">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-calendar-check mr-2"></i>تحديث سعر أيام محددة
                    </h6>
                    <form action="{{ route('owner.chalet.prices.update', $chalet->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="dates">{{ trans('back.select_dates') }}</label>
                                <input type="text" id="dates" name="dates" class="form-control" placeholder="{{ trans('back.select_dates_placeholder') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="price">{{ trans('back.price') }}</label>
                                <input type="number" step="0.01" id="price" name="price" class="form-control" placeholder="{{ trans('back.enter_price') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>تحديث السعر
                        </button>
                    </form>
                </div>
                <hr>

                <!-- تحديث شهر كامل -->
                <div class="mb-4">
                    <h6 class="text-warning mb-3">
                        <i class="fas fa-calendar-alt mr-2"></i>تحديث سعر شهر كامل
                    </h6>
                    <form action="{{ route('owner.chalet.prices.update', $chalet->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="month">{{ trans('back.select_month') }}</label>
                                <input type="text" id="month" name="month" class="form-control" placeholder="{{ trans('back.select_month_placeholder') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="price_month">{{ trans('back.month_price') }}</label>
                                <input type="number" step="0.01" id="price_month" name="price_month" class="form-control" placeholder="{{ trans('back.enter_month_price') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-2"></i>تحديث سعر الشهر
                        </button>
                    </form>
                </div>
                <hr>

                <!-- تحديث يوم محدد متكرر -->
                <div class="mb-4">
                    <h6 class="text-success mb-3">
                        <i class="fas fa-redo mr-2"></i>تحديث سعر يوم محدد بشكل متكرر
                    </h6>
                    <form action="{{ route('owner.chalet.prices.update.recurrence', $chalet->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="weekday">{{ trans('back.select_weekday') }}</label>
                                <select id="weekday" name="weekday" class="form-control">
                                    <option value="0">{{ trans('back.sunday') }}</option>
                                    <option value="1">{{ trans('back.monday') }}</option>
                                    <option value="2">{{ trans('back.tuesday') }}</option>
                                    <option value="3">{{ trans('back.wednesday') }}</option>
                                    <option value="4">{{ trans('back.thursday') }}</option>
                                    <option value="5">{{ trans('back.friday') }}</option>
                                    <option value="6">{{ trans('back.saturday') }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="months">{{ trans('back.number_of_months') }}</label>
                                <input type="number" id="months" name="months" class="form-control" placeholder="{{ trans('back.number_of_months_placeholder') }}" min="1">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="price_recurrence">{{ trans('back.recurrence_price') }}</label>
                                <input type="number" step="0.01" id="price_recurrence" name="price_recurrence" class="form-control" placeholder="{{ trans('back.enter_recurrence_price') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-2"></i>تحديث السعر المتكرر
                        </button>
                    </form>
                </div>


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
