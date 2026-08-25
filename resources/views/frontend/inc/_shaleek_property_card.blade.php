@php
    /** @var \App\Models\Chalet $chalet */
    $shImg = $chalet->main_image
        ? asset($chalet->main_image)
        : (optional($chalet->images->first() ?? null)->image ? asset($chalet->images->first()->image) : asset('no_image.png'));

    $shWaLink = $chalet->whatsapp_link;
    $shCallLink = $chalet->phone_link;
    if ((!$shWaLink || !$shCallLink) && $chalet->owner && $chalet->owner->phone) {
        $shOwnerDigits = \App\Models\Chalet::normalizeOmaniPhone($chalet->owner->phone);
        if (!$shWaLink && $shOwnerDigits) { $shWaLink = 'https://wa.me/' . $shOwnerDigits; }
        if (!$shCallLink && $shOwnerDigits) { $shCallLink = 'tel:+' . $shOwnerDigits; }
    }

    $shFeatures = [];
    if ($chalet->has_pool) $shFeatures[] = app()->getLocale() == 'ar' ? 'مسبح' : 'Pool';
    if ($chalet->has_garden) $shFeatures[] = app()->getLocale() == 'ar' ? 'حديقة' : 'Garden';
    if ($chalet->has_beachfront) $shFeatures[] = app()->getLocale() == 'ar' ? 'شاطئ خاص' : 'Private beach';
    if ($chalet->has_beach) $shFeatures[] = app()->getLocale() == 'ar' ? 'قريب من الشاطئ' : 'Near beach';
    if ($chalet->has_mountain_view) $shFeatures[] = app()->getLocale() == 'ar' ? 'إطلالة جبلية' : 'Mountain view';
    if (is_array($chalet->amenities)) {
        foreach ($chalet->amenities as $a) { $shFeatures[] = $a; }
    }
    $shFeatures = array_slice($shFeatures, 0, 3);

    $shIsFav = auth('customer')->check() && auth('customer')->user()->wishlist->contains($chalet->id);
    $shTitle = app()->getLocale() == 'ar' ? ($chalet->chalet_name_ar ?: $chalet->chalet_name_en) : ($chalet->chalet_name_en ?: $chalet->chalet_name_ar);
    $shLocation = trim(($chalet->city->name ?? '') . (($chalet->area->name ?? null) ? ' / ' . $chalet->area->name : ''));
@endphp
<a href="{{ route('showChalet', $chalet->slug) }}" class="shaleek-prop-card" style="text-decoration:none;">
    <div class="shaleek-prop-image">
        <img src="{{ $shImg }}" alt="{{ $shTitle }}" loading="lazy">
        <button type="button" class="shaleek-prop-fav {{ $shIsFav ? 'active' : '' }}" onclick="event.preventDefault(); event.stopPropagation(); shaleekToggleWishlist(this, '{{ route('wishlist.toggle', $chalet->id) }}')" aria-label="{{ app()->getLocale() == 'ar' ? 'حفظ' : 'Save' }}">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
        </button>
        <span class="shaleek-prop-cat-tag">{{ $chalet->category->name ?? '' }}</span>
        @if($chalet->is_feature)
            <span class="shaleek-prop-verified"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 1.8 3 .1 1 2.8 2.4 1.8-1 2.8 1 2.8-2.4 1.8-1 2.8-3 .1L12 22l-2.4-1.8-3-.1-1-2.8L3.2 15l1-2.8-1-2.8 2.4-1.8 1-2.8 3-.1z"/><path d="M9.5 12.5l1.8 1.8 3.5-3.7" fill="none" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>{{ app()->getLocale() == 'ar' ? 'مميّز' : 'Featured' }}</span>
        @endif
    </div>
    <div class="shaleek-prop-body">
        @if($shLocation)
            <div class="shaleek-prop-location">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                {{ $shLocation }}
            </div>
        @endif
        <h3 class="shaleek-prop-title">{{ $shTitle }}</h3>
        @if(count($shFeatures))
            <div class="shaleek-prop-features">
                @foreach($shFeatures as $f)
                    <span class="shaleek-prop-feature">{{ $f }}</span>
                @endforeach
            </div>
        @endif
        <div class="shaleek-prop-divider"></div>
        <div class="shaleek-prop-footer">
            <div class="shaleek-prop-price">
                @if($chalet->default_day_price)
                    <span class="shaleek-prop-price-from">{{ app()->getLocale() == 'ar' ? 'يبدأ من' : 'From' }}</span>
                    <div class="shaleek-prop-price-current">{{ number_format((float) $chalet->default_day_price, 0) }} <span class="shaleek-prop-price-unit">{{ app()->getLocale() == 'ar' ? 'ر.ع / ليلة' : 'OMR / night' }}</span></div>
                @else
                    <span class="shaleek-prop-price-ask">{{ app()->getLocale() == 'ar' ? 'تواصل لمعرفة الأسعار' : 'Contact for pricing' }}</span>
                @endif
            </div>
            <div class="shaleek-prop-actions">
                @if($shCallLink)
                    <a href="{{ $shCallLink }}" class="shaleek-prop-call" onclick="event.stopPropagation()" aria-label="{{ app()->getLocale() == 'ar' ? 'اتصال' : 'Call' }}">
                        <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        {{ app()->getLocale() == 'ar' ? 'اتصال' : 'Call' }}
                    </a>
                @endif
                @if($shWaLink)
                    <a href="{{ $shWaLink }}" target="_blank" rel="noopener" class="shaleek-prop-cta" onclick="event.stopPropagation()">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ app()->getLocale() == 'ar' ? 'تواصل' : 'Chat' }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</a>
