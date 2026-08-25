<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link active" href="/">{{ __('back.home') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('showAllChalet') }}">
            {{ trans('back.offer_weekend') }}
        </a>
    </li>

    {{-- عرض الأقسام تلقائيًا --}}
    @if(isset($headerCategories) && $headerCategories->count() > 0)
        @foreach($headerCategories as $category)
            <li class="nav-item">
                <a class="nav-link" 
                   href="{{ route('showAllChalet', ['category' => $category->id]) }}">
                   {{ $category->name }}
                </a>
            </li>
        @endforeach
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{ route('all-posts') }}">
            {{ trans('back.posts') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('about_us') }}"> {{ __('back.about_us') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('contact_us') }}">{{ __('back.contact_us') }} </a>
    </li>

    {{-- كود تغيير اللغة  --}}
    <li class="nav-item">
        <div class="dropdown d-none d-md-flex">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                <strong class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}</strong>
            </a>
            <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $properties['native'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </li>
    {{-- نهاية كود تغيير اللغة --}}
</ul>
