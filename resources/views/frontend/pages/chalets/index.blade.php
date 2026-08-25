@extends('frontend.layouts.weekend_master')

@section('page_title')
    {{ (isset($selectedCategory) && $selectedCategory) ? $selectedCategory->name : trans('back.chalets') }}
@endsection

@section('content')
    @php
        $shSelectedCity = request('city');
        $shSelectedArea = request('area');
        $shSelectedPrice = request('date-price');
        $shPriceLabels = [
            '0-50' => app()->getLocale() == 'ar' ? 'أقل من 50 ر.ع' : 'Under 50 OMR',
            '50-100' => '50 - 100',
            '100-200' => '100 - 200',
            '200-99999' => '200+',
        ];
    @endphp

    <div class="container">
        <div class="shaleek-breadcrumb">
            <a href="{{ route('shaleek.home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a>
            <span>›</span>
            <span>{{ (isset($selectedCategory) && $selectedCategory) ? $selectedCategory->name : (app()->getLocale() == 'ar' ? 'جميع العقارات' : 'All Properties') }}</span>
        </div>

        <div class="shaleek-listings-header">
            <h1 class="shaleek-listings-title">{{ (isset($selectedCategory) && $selectedCategory) ? $selectedCategory->name : (app()->getLocale() == 'ar' ? 'جميع العقارات' : 'All Properties') }}</h1>
            <p class="shaleek-listings-subtitle">
                {{ app()->getLocale() == 'ar' ? 'اكتشف ' . $chalets->total() . ' عقاراً متاحاً من جميع محافظات السلطنة' : 'Discover ' . $chalets->total() . ' listings across every governorate of Oman' }}
            </p>
        </div>
    </div>

    <!-- Filters bar -->
    <div class="shaleek-filters-bar">
        <div class="container" style="padding: 0;">
            <div class="shaleek-filters-scroll">
                <button type="button" class="shaleek-filter-pill active" onclick="shaleekOpenFilters()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                    {{ app()->getLocale() == 'ar' ? 'الفلاتر' : 'Filters' }}
                </button>
                @if($shSelectedCity && \App\Models\City::find($shSelectedCity))
                    <button type="button" class="shaleek-filter-pill with-dot" onclick="shaleekOpenFilters()">{{ app()->getLocale() == 'ar' ? 'المحافظة: ' : 'Governorate: ' }}{{ \App\Models\City::find($shSelectedCity)->name }}</button>
                @endif
                @if($shSelectedPrice)
                    <button type="button" class="shaleek-filter-pill with-dot" onclick="shaleekOpenFilters()">{{ app()->getLocale() == 'ar' ? 'السعر: ' : 'Price: ' }}{{ $shPriceLabels[$shSelectedPrice] ?? $shSelectedPrice }}</button>
                @endif
                @foreach($categories ?? \App\Models\Category::withCount('chalets')->get() as $catPill)
                    <a href="{{ route('showAllChalet', array_merge(request()->except(['page','category']), ['category' => $catPill->id])) }}" class="shaleek-filter-pill {{ (isset($selectedCategory) && $selectedCategory && $selectedCategory->id == $catPill->id) ? 'active' : '' }}" style="text-decoration:none;">{{ $catPill->name }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container">
        <div class="shaleek-results-row">
            <div class="shaleek-results-count">
                {{ app()->getLocale() == 'ar' ? 'عرض' : 'Showing' }}
                <b>{{ $chalets->firstItem() ?? 0 }}-{{ $chalets->lastItem() ?? 0 }}</b>
                {{ app()->getLocale() == 'ar' ? 'من أصل' : 'of' }}
                <b>{{ $chalets->total() }}</b>
                {{ app()->getLocale() == 'ar' ? 'عقار' : 'listings' }}
            </div>
            <div class="shaleek-sort-dropdown">
                <span>{{ app()->getLocale() == 'ar' ? 'ترتيب:' : 'Sort:' }}</span>
                <select onchange="shaleekSortResults(this.value)">
                    <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الأحدث' : 'Newest' }}</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'السعر: الأقل للأعلى' : 'Price: Low to High' }}</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'السعر: الأعلى للأقل' : 'Price: High to Low' }}</option>
                </select>
            </div>
        </div>

        <div class="shaleek-props-grid">
            @forelse($chalets as $chalet)
                @include('frontend.inc._shaleek_property_card', ['chalet' => $chalet])
            @empty
                <div style="grid-column: 1/-1; text-align:center; padding: 48px 0; color: var(--ink-500);">
                    {{ app()->getLocale() == 'ar' ? 'لا توجد عقارات مطابقة لبحثك حاليًا' : 'No listings match your search right now' }}
                </div>
            @endforelse
        </div>

        {{ $chalets->appends(request()->except('page'))->links('frontend.inc._shaleek_pagination') }}
    </div>

    <!-- Filter sheet -->
    <div class="shaleek-filter-sheet" id="shaleekFilterSheet" onclick="if(event.target===this)shaleekCloseFilters()">
        <div class="shaleek-filter-sheet-panel">
            <div class="shaleek-filter-sheet-handle"></div>
            <div class="shaleek-filter-sheet-header">
                <div class="shaleek-filter-sheet-title">{{ app()->getLocale() == 'ar' ? 'الفلاتر' : 'Filters' }}</div>
                <a href="{{ route('showAllChalet') }}" class="shaleek-filter-sheet-clear">{{ app()->getLocale() == 'ar' ? 'مسح الكل' : 'Clear all' }}</a>
            </div>
            <form method="GET" action="{{ route('showAllChalet') }}">
                <div class="shaleek-filter-sheet-body">
                    <div class="shaleek-filter-group">
                        <div class="shaleek-filter-group-label">{{ app()->getLocale() == 'ar' ? 'المحافظة' : 'Governorate' }}</div>
                        <select name="city" id="shListCity" class="shaleek-form-select">
                            <option value="0">{{ app()->getLocale() == 'ar' ? 'كل المحافظات' : 'All governorates' }}</option>
                            @foreach(\App\Models\City::all() as $city)
                                <option value="{{ $city->id }}" {{ (string) $shSelectedCity === (string) $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="shaleek-filter-group">
                        <div class="shaleek-filter-group-label">{{ app()->getLocale() == 'ar' ? 'نوع العقار' : 'Property type' }}</div>
                        <select name="category" class="shaleek-form-select">
                            <option value="0">{{ app()->getLocale() == 'ar' ? 'الكل' : 'All' }}</option>
                            @foreach(\App\Models\Category::all() as $catOpt)
                                <option value="{{ $catOpt->id }}" {{ (isset($selectedCategory) && $selectedCategory && $selectedCategory->id == $catOpt->id) ? 'selected' : '' }}>{{ $catOpt->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="shaleek-filter-group">
                        <div class="shaleek-filter-group-label">{{ app()->getLocale() == 'ar' ? 'المنطقة' : 'Area' }}</div>
                        <select name="area" id="shListArea" class="shaleek-form-select">
                            <option value="0">{{ app()->getLocale() == 'ar' ? 'كل المناطق' : 'All areas' }}</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" data-city="{{ $area->city_id }}" {{ (string) $shSelectedArea === (string) $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="shaleek-filter-group">
                        <div class="shaleek-filter-group-label">{{ app()->getLocale() == 'ar' ? 'نطاق السعر' : 'Price range' }}</div>
                        <div class="shaleek-filter-options">
                            @foreach($shPriceLabels as $val => $label)
                                <label class="shaleek-filter-option {{ $shSelectedPrice == $val ? 'active' : '' }} js-shaleek-filter-toggle" style="display:inline-flex; align-items:center; gap:6px;">
                                    <input type="radio" name="date-price" value="{{ $val }}" {{ $shSelectedPrice == $val ? 'checked' : '' }} style="accent-color: var(--green-700);">
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="shaleek-filter-sheet-footer">
                    <button type="submit" class="shaleek-btn-apply">{{ app()->getLocale() == 'ar' ? 'عرض النتائج' : 'Show results' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function shaleekSortResults(sortBy) {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sortBy);
            window.location.href = url.toString();
        }

        (function () {
            var citySelect = document.getElementById('shListCity');
            var areaSelect = document.getElementById('shListArea');
            if (!citySelect || !areaSelect) return;
            var allOptions = Array.prototype.slice.call(areaSelect.options);

            function applyFilter() {
                var cityId = citySelect.value;
                var current = areaSelect.value;
                areaSelect.innerHTML = '';
                var stillHasSelection = false;
                allOptions.forEach(function (opt) {
                    if (opt.value === '0' || !opt.dataset.city || opt.dataset.city === cityId) {
                        areaSelect.appendChild(opt);
                        if (opt.value === current) stillHasSelection = true;
                    }
                });
                if (!stillHasSelection) areaSelect.value = '0';
            }
            citySelect.addEventListener('change', applyFilter);
        })();
    </script>
@endsection
