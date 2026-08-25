@props([
    'image' => null,
    'alt' => '',
    'folder' => '', // optional: 'images', 'uploads/setting', etc.
    'class' => '',
])

@php
    // إذا لا توجد صورة، عرض الصورة الافتراضية
    if(!$image) {
        $src = asset('images/no_image.png');
    } else {
        // إذا الرابط URL كامل
        if(Str::startsWith($image, ['http://', 'https://'])) {
            $src = $image;
        } else {
            // مسار محلي داخل public
            $src = asset(($folder ? $folder.'/' : '') . urlencode($image));
        }
    }
@endphp

<img src="{{ $src }}" alt="{{ $alt }}" class="{{ $class }}">
