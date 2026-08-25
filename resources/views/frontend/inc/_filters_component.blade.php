<!-- Reusable Filters Component -->
@if(app()->getLocale() == 'ar')
    <!-- Arabic Order: Search (on right) - Gov - State - Area - Booking - Property - Price -->

    <!-- Search Button (on right for Arabic RTL) -->
    <button class="search-btn search-btn-ar" type="button">
        <span>
            <svg width="35" height="34" viewBox="0 0 35 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 32.7503L9.6003 25.331M9.6003 25.331C10.9003 26.6001 12.4437 27.6068 14.1423 28.2936C15.8409 28.9805 17.6614 29.334 19.5 29.334C21.3386 29.334 23.1591 28.9805 24.8577 28.2937C26.5563 27.6068 28.0997 26.6001 29.3998 25.331C30.6998 24.0619 31.7311 22.5553 32.4347 20.8971C33.1382 19.239 33.5004 17.4618 33.5004 15.667C33.5004 13.8722 33.1382 12.095 32.4347 10.4368C31.7311 8.7787 30.6998 7.272 29.3998 6.0029C26.7742 3.4399 23.2131 2 19.5 2C15.7869 2 12.2258 3.4399 9.6003 6.0029C6.9747 8.566 5.4996 12.0423 5.4996 15.667C5.4996 19.2917 6.9747 22.7679 9.6003 25.331Z" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    </button>

    <!-- Governorate Filter -->
    <div class="filter-dropdown">
        <button class="filter-pill" type="button" data-filter="gov">
            <span class="filter-label">المحافظة</span>
            <span class="filter-count" style="display: none;"></span>
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="dropdown-content">
            <div class="filter-header">
                <h5>اختر المحافظة</h5>
                <button type="button" class="close-dropdown">&times;</button>
            </div>
            <div class="filter-body">
                @if(isset($cities) && $cities->count() > 0)
                    @foreach($cities as $city)
                        <label class="checkbox-item">
                            <input type="checkbox" name="gov[]" value="{{ $city->id }}">
                            <span>{{ $city->name_ar }}</span>
                        </label>
                    @endforeach
                @else
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="1">
                        <span>محافظة مسقط</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="2">
                        <span>محافظة ظفار</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="3">
                        <span>شمال الباطنة</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="4">
                        <span>جنوب الباطنة</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="5">
                        <span>شمال الشرقية</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="6">
                        <span>جنوب الشرقية</span>
                    </label>
                @endif
            </div>
        </div>
    </div>

    <!-- State Filter -->
    <div class="filter-dropdown" id="state-filter">
        <button class="filter-pill" type="button" data-filter="state" disabled style="opacity: 0.5; cursor: not-allowed;">
            <span class="filter-label">المنطقة</span>
            <span class="filter-count" style="display: none;"></span>
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="dropdown-content">
            <div class="filter-header">
                <h5>اختر المنطقة</h5>
                <button type="button" class="close-dropdown">&times;</button>
            </div>
            <div class="filter-body" id="state-options">
                <p class="text-muted text-center">اختر المحافظة أولاً</p>
            </div>
        </div>
    </div>

    <!-- Area Filter -->
{{--    <div class="filter-dropdown" id="area-filter">--}}
{{--        <button class="filter-pill" type="button" data-filter="area" disabled style="opacity: 0.5; cursor: not-allowed;">--}}
{{--            <span class="filter-label">المنطقة</span>--}}
{{--            <span class="filter-count" style="display: none;"></span>--}}
{{--            <i class="fas fa-chevron-left"></i>--}}
{{--        </button>--}}
{{--        <div class="dropdown-content">--}}
{{--            <div class="filter-header">--}}
{{--                <h5>اختر المنطقة</h5>--}}
{{--                <button type="button" class="close-dropdown">&times;</button>--}}
{{--            </div>--}}
{{--            <div class="filter-body" id="area-options">--}}
{{--                <p class="text-muted text-center">اختر الولاية أولاً</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Booking Time Filter -->
{{--    <div class="filter-dropdown">--}}
{{--        <button class="filter-pill" type="button" data-filter="booking">--}}
{{--            <span class="filter-label">وقت الحجز</span>--}}
{{--            <span class="filter-count" style="display: none;"></span>--}}
{{--            <i class="fas fa-chevron-left"></i>--}}
{{--        </button>--}}
{{--        <div class="dropdown-content">--}}
{{--            <div class="filter-header">--}}
{{--                <h5>اختر تاريخ الحجز</h5>--}}
{{--                <button type="button" class="close-dropdown">&times;</button>--}}
{{--            </div>--}}
{{--            <div class="filter-body">--}}
{{--                <div class="date-range-container">--}}
{{--                    <div class="date-input-group">--}}
{{--                        <label>من</label>--}}
{{--                        <input type="date" name="booking_from" class="date-input" id="booking_from">--}}
{{--                    </div>--}}
{{--                    <div class="date-input-group">--}}
{{--                        <label>إلى</label>--}}
{{--                        <input type="date" name="booking_to" class="date-input" id="booking_to">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <button type="button" class="btn-apply-dates">تطبيق</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Property Type Filter (أقسام من قاعدة البيانات) -->
    <div class="filter-dropdown">
        <button class="filter-pill" type="button" data-filter="property">
            <span class="filter-label">نوع العقار</span>
            <span class="filter-count" style="display: none;"></span>
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="dropdown-content">
            <div class="filter-header">
                <h5>اختر نوع العقار</h5>
                <button type="button" class="close-dropdown">&times;</button>
            </div>
            <div class="filter-body">
                @foreach($headerCategories ?? [] as $category)
                <label class="checkbox-item">
                    <input type="checkbox" name="property[]" value="{{ $category->id }}">
                    <span>{{ $category->name }}</span>
                </label>
                @endforeach
                @if(empty($headerCategories) || count($headerCategories ?? []) == 0)
                <p class="text-muted text-center small mb-0">{{ app()->getLocale() == 'ar' ? 'لا توجد أقسام' : 'No categories' }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Price Filter -->
    <div class="filter-dropdown">
        <button class="filter-pill" type="button" data-filter="price">
            <span class="filter-label">السعر</span>
            <span class="filter-count" style="display: none;"></span>
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="dropdown-content">
            <div class="filter-header">
                <h5>اختر نطاق السعر</h5>
                <button type="button" class="close-dropdown">&times;</button>
            </div>
            <div class="filter-body">
                <label class="checkbox-item">
                    <input type="checkbox" name="price[]" value="0-50">
                    <span>0 - 50 ريال</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="price[]" value="50-100">
                    <span>50 - 100 ريال</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="price[]" value="100-200">
                    <span>100 - 200 ريال</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="price[]" value="200+">
                    <span>200+ ريال</span>
                </label>
            </div>
        </div>
    </div>

@else
    <!-- English Order: Search - Gov - State - Area - Booking - Property - Price -->

    <!-- Search Button (on right for English) -->
    <button class="search-btn" type="button">
        <span>
            <svg width="35" height="34" viewBox="0 0 35 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 32.7503L9.6003 25.331M9.6003 25.331C10.9003 26.6001 12.4437 27.6068 14.1423 28.2936C15.8409 28.9805 17.6614 29.334 19.5 29.334C21.3386 29.334 23.1591 28.9805 24.8577 28.2937C26.5563 27.6068 28.0997 26.6001 29.3998 25.331C30.6998 24.0619 31.7311 22.5553 32.4347 20.8971C33.1382 19.239 33.5004 17.4618 33.5004 15.667C33.5004 13.8722 33.1382 12.095 32.4347 10.4368C31.7311 8.7787 30.6998 7.272 29.3998 6.0029C26.7742 3.4399 23.2131 2 19.5 2C15.7869 2 12.2258 3.4399 9.6003 6.0029C6.9747 8.566 5.4996 12.0423 5.4996 15.667C5.4996 19.2917 6.9747 22.7679 9.6003 25.331Z" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    </button>

    <!-- Governorate Filter -->
    <div class="filter-dropdown">
        <button class="filter-pill" type="button" data-filter="gov">
            <span class="filter-label">Gov.</span>
            <span class="filter-count" style="display: none;"></span>
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="dropdown-content">
            <div class="filter-header">
                <h5>Select Governorate</h5>
                <button type="button" class="close-dropdown">&times;</button>
            </div>
            <div class="filter-body">
                @if(isset($cities) && $cities->count() > 0)
                    @foreach($cities as $city)
                        <label class="checkbox-item">
                            <input type="checkbox" name="gov[]" value="{{ $city->id }}">
                            <span>{{ $city->name_en }}</span>
                        </label>
                    @endforeach
                @else
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="1">
                        <span>Muscat Governorate</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="2">
                        <span>Dhofar Governorate</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="3">
                        <span>North Al Batinah</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="4">
                        <span>South Al Batinah</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="5">
                        <span>North Al Sharqiyah</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gov[]" value="6">
                        <span>South Al Sharqiyah</span>
                    </label>
                @endif
            </div>
        </div>
    </div>

    <!-- State Filter -->
    <div class="filter-dropdown" id="state-filter">
        <button class="filter-pill" type="button" data-filter="state" disabled style="opacity: 0.5; cursor: not-allowed;">
            <span class="filter-label">State</span>
            <span class="filter-count" style="display: none;"></span>
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="dropdown-content">
            <div class="filter-header">
                <h5>Select State</h5>
                <button type="button" class="close-dropdown">&times;</button>
            </div>
            <div class="filter-body" id="state-options">
                <p class="text-muted text-center">Select Governorate first</p>
            </div>
        </div>
    </div>

    <!-- Area Filter -->
    <div class="filter-dropdown" id="area-filter">
        <button class="filter-pill" type="button" data-filter="area" disabled style="opacity: 0.5; cursor: not-allowed;">
            <span class="filter-label">Area</span>
            <span class="filter-count" style="display: none;"></span>
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="dropdown-content">
            <div class="filter-header">
                <h5>Select Area</h5>
                <button type="button" class="close-dropdown">&times;</button>
            </div>
            <div class="filter-body" id="area-options">
                <p class="text-muted text-center">Select State first</p>
            </div>
        </div>
    </div>

    <!-- Booking Time Filter -->
    <div class="filter-dropdown">
        <button class="filter-pill" type="button" data-filter="booking">
            <span class="filter-label">Booking time</span>
            <span class="filter-count" style="display: none;"></span>
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="dropdown-content">
            <div class="filter-header">
                <h5>Select Booking Date</h5>
                <button type="button" class="close-dropdown">&times;</button>
            </div>
            <div class="filter-body">
                <div class="date-range-container">
                    <div class="date-input-group">
                        <label>From</label>
                        <input type="date" name="booking_from" class="date-input" id="booking_from">
                    </div>
                    <div class="date-input-group">
                        <label>To</label>
                        <input type="date" name="booking_to" class="date-input" id="booking_to">
                    </div>
                </div>
                <button type="button" class="btn-apply-dates">Apply</button>
            </div>
        </div>
    </div>

    <!-- Property Type Filter (categories from database) -->
    <div class="filter-dropdown">
        <button class="filter-pill" type="button" data-filter="property">
            <span class="filter-label">Property</span>
            <span class="filter-count" style="display: none;"></span>
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="dropdown-content">
            <div class="filter-header">
                <h5>Select Property Type</h5>
                <button type="button" class="close-dropdown">&times;</button>
            </div>
            <div class="filter-body">
                @foreach($headerCategories ?? [] as $category)
                <label class="checkbox-item">
                    <input type="checkbox" name="property[]" value="{{ $category->id }}">
                    <span>{{ $category->name }}</span>
                </label>
                @endforeach
                @if(empty($headerCategories) || count($headerCategories ?? []) == 0)
                <p class="text-muted text-center small mb-0">No categories</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Price Filter -->
    <div class="filter-dropdown">
        <button class="filter-pill" type="button" data-filter="price">
            <span class="filter-label">Price</span>
            <span class="filter-count" style="display: none;"></span>
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="dropdown-content">
            <div class="filter-header">
                <h5>Select Price Range</h5>
                <button type="button" class="close-dropdown">&times;</button>
            </div>
            <div class="filter-body">
                <label class="checkbox-item">
                    <input type="checkbox" name="price[]" value="0-50">
                    <span>0 - 50 OMR</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="price[]" value="50-100">
                    <span>50 - 100 OMR</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="price[]" value="100-200">
                    <span>100 - 200 OMR</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="price[]" value="200+">
                    <span>200+ OMR</span>
                </label>
            </div>
        </div>
    </div>
@endif
