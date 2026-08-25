<div class="{{ $style ?? '' }} w-100" style="z-index: 199;">
    <div class="bg-light p-1 custom-rounded mx-auto">
        <div class="border border-1 border-danger-subtle p-5 custom-rounded">

            <form action="{{ route('search-result') }}" method="GET" class="d-flex align-items-center justify-content-between">
                <div class="d-flex flex-wrap gap-2 justify-content-center w-100">
                    <div class="row w-100 gx-6 gy-4">
                        <div class="col-md-6 col-lg-3">
                            <select class="form-select rounded-pill text-dark select2" name="city" id="citySelect">
                                <option value="0">{{ trans('back.filter_city') }} {{ trans('back.all') }}</option>
                                @foreach (App\Models\City::all() as $city)
                                    <option value="{{ $city->id }}" {{ $city->id == request()->input('city') ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? $city->name_ar : $city->name_en }}
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <select class="form-select select2 rounded-pill text-dark" name="area" id="areaSelect">
                                <option value="0">{{ trans('back.filter_area') }} {{ trans('back.all') }}</option>
                            </select>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <select class="form-select select2 rounded-pill text-dark" name="category" id="categorySelect">
                                <option selected disabled>{{ trans('back.select_category') }}</option>
                                @foreach (App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == request()->input('category') ? 'selected' : '' }}>
                                        {{ App::getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <select class="form-select select2 rounded-pill text-dark" name="date-price" id="priceSelect">
                                <option value="0">{{ trans('back.filter_price') }} {{ trans('back.all') }}</option>
                                <option value="0-10" {{ old('date-price', request()->input('date-price')) == '0-10' ? 'selected' : null }}>0 - 10 {{ trans('back.currency') }}</option>
                                <option value="10-20" {{ old('date-price', request()->input('date-price')) == '10-20' ? 'selected' : null }}>10 - 20 {{ trans('back.currency') }}</option>
                                <option value="20-30" {{ old('date-price', request()->input('date-price')) == '20-30' ? 'selected' : null }}>20 - 30 {{ trans('back.currency') }}</option>
                                <option value="30-40" {{ old('date-price', request()->input('date-price')) == '30-40' ? 'selected' : null }}>30 - 40 {{ trans('back.currency') }}</option>
                                <option value="50" {{ old('date-price', request()->input('date-price')) == '50' ? 'selected' : null }}>+50 {{ trans('back.currency') }}</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="ms-2">
                    <button class="btn btn-circle btn-gradient gradient-2" data-text="{{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}">
                        <i class="fas fa-search"></i>
                        <span class="d-none d-md-none mobile-search-text">{{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<style>
    .select2-container--default .select2-selection--single {
        font-size: 0.7rem;
    }
</style>
