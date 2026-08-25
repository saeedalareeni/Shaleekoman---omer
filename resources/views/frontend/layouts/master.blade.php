<!DOCTYPE html>
<html lang="ar" dir="rtl" >

@include('frontend.layouts.head')

<body class="overflow-x-hidden" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{--Header--}}
    <div class="content-wrapper">
        @include('frontend.layouts.header')
    </div>

    @yield('content')

    @include('frontend.layouts.footer')

    @include('frontend.layouts.script')
    
    
</body>

</html>
