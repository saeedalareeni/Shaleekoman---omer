<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link active" href="/">{{ __('back.home') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('showAllChalet') }}">
            {{ trans('back.offer_weekend') }}
        </a>
    </li>
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
    <li class="">
        <div class="dropdown  nav-itemd-none d-md-flex">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                @if (App::getLocale() == 'ar')
                    <strong class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }} </strong>
                @else
                    <strong class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}</strong>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        @if($properties['native'] == "English")
                        @elseif($properties['native'] == "العربية")
                        @endif
                        {{ $properties['native'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </li>
    {{-- نهاية كود تغيير اللغة  --}}



</ul>
