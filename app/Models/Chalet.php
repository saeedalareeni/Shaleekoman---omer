<?php

namespace App\Models;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chalet extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected $appends = ['dedicated_to_label'];

    protected $casts = [
    'tags' => 'array',
    'has_pool' => 'boolean',
    'has_beachfront' => 'boolean',
    'has_beach' => 'boolean',
    'has_garden' => 'boolean',
    'has_mountain_view' => 'boolean',
    'show_contact_icon' => 'boolean',
    'amenities' => 'array',
    'nearby_places' => 'array',
    'latitude' => 'float',
    'longitude' => 'float',
];

public function getWhatsappLinkAttribute()
{
    $number = static::normalizeOmaniPhone($this->getRawOriginal('whatsapp_number'));
    if (!$number) {
        return null;
    }

    return 'https://wa.me/' . $number;
}

public function getPhoneLinkAttribute()
{
    $digits = static::normalizeOmaniPhone($this->getRawOriginal('phone'));
    if (!$digits) {
        return null;
    }
    return 'tel:+' . $digits;
}

public static function normalizeOmaniPhone(?string $value): ?string
{
    $digits = preg_replace('/\D/', '', (string) $value);

    if ($digits === '') {
        return null;
    }

    if (str_starts_with($digits, '00968') && strlen($digits) === 13) {
        $digits = substr($digits, 2);
    }

    if (strlen($digits) === 8) {
        return '968' . $digits;
    }

    if (strlen($digits) === 11 && str_starts_with($digits, '968')) {
        return $digits;
    }

    return null;
}

public static function formatOmaniPhone(?string $value): ?string
{
    $normalized = static::normalizeOmaniPhone($value);

    return $normalized ? '+' . $normalized : null;
}

public function getPhoneAttribute($value)
{
    return static::formatOmaniPhone($value);
}

public function setPhoneAttribute($value): void
{
    $this->attributes['phone'] = static::normalizeOmaniPhone($value);
}

public function getWhatsappNumberAttribute($value)
{
    return static::formatOmaniPhone($value);
}

public function setWhatsappNumberAttribute($value): void
{
    $this->attributes['whatsapp_number'] = static::normalizeOmaniPhone($value);
}

/** العقار مخصص: عوائل - عزاب - الجميع */
public function getDedicatedToLabelAttribute()
{
    $map = [
        'families' => ['ar' => 'عوائل', 'en' => 'Families'],
        'singles'  => ['ar' => 'عزاب', 'en' => 'Singles'],
        'everyone' => ['ar' => 'الجميع', 'en' => 'Everyone'],
    ];
    $key = $this->dedicated_to ?? 'everyone';
    $lang = app()->getLocale() === 'ar' ? 'ar' : 'en';
    return $map[$key][$lang] ?? $map['everyone'][$lang];
}



    public function images()
    {
        return $this->hasMany(ChaletImage::class);
    }


    public function prices()
    {
        return $this->hasMany(ChaletPrice::class);
    }

    public function getPriceForDate($date)
    {
        $specialPrice = $this->prices()->where('date', $date)->first();
        return $specialPrice ? $specialPrice->price : $this->default_day_price;
    }

    public function getBookedDates($start = null, $end = null)
    {
        $booked = [];
        $dates = $this->orders()->select('status', 'chalet_id', 'start_date', 'id', 'nights')
            ->when($start, function ($q) use ($start) {
                $q->whereDate('start_date', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                $q->whereDate('start_date', '<=', $end);
            })
            ->whereNotIn('status', ['REJECTED', 'CANCELED'])->get();
        foreach ($dates as $item) {
            foreach ($item->nights as $date => $cost) {
                $booked[] = $date;
            }
        }
        return $booked;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }


    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->chalet_name_ar : $this->chalet_name_en;
    }


    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }


    public function city()
    {
        return $this->belongsTo(City::class);
    }


    public function status()
{
    switch ($this->status) {
        case 'approved':
            return '<span class="badge badge-success">' . trans('back.approved') . '</span>';
        case 'pending':
            return '<span class="badge badge-warning">' . trans('back.pending') . '</span>';
        case 'rejected':
        default:
            return '<span class="badge badge-danger">' . trans('back.rejected') . '</span>';
    }
}

    public function isFeature()
    {
        return $this->is_feature ? trans('back.yes') : trans('back.no');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function views()
    {
        return $this->hasMany(View::class);
    }
    public function wishedBy()
    {
        return $this->belongsToMany(Customer::class, 'wishlists')->withTimestamps();
    }


}
