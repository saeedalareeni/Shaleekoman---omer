<!DOCTYPE html>
<html lang="ar" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" >

@include('frontend.layouts.head')

<body dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="content-wrapper bg-soft-ash">

        @include('frontend.layouts.pageheader')

        @yield('content')

    </div>

    @include('frontend.layouts.footer')

    @include('frontend.layouts.script')
</body>

</html>
