<?php

namespace App\Http\Controllers\Owner;
use App\Http\Controllers\Controller;

use App\Models\Area;
use App\Models\Category;
use App\Models\Chalet;
use App\Models\ChaletImage;
use App\Models\City;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChaletController extends Controller
{


    public function index(Request $request)
{
    $areas = Area::all();
    $query = $request->input('query');
    $areaId = $request->input('area_id');

    $chalets = Chalet::query()
        ->where('owner_id', Auth::id())
        ->when($query, function ($queryBuilder, $query) {
            return $queryBuilder->where('name', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->orWhere('location', 'like', "%{$query}%");
        })
        ->when($areaId, function ($queryBuilder, $areaId) {
            return $queryBuilder->where('area_id', $areaId);
        })
        ->paginate(10);

    return view('owners.pages.chalets.index', compact('chalets', 'areas'));
}




    public function create()
    {
        $cities = City::all();
        $areas = Area::all();
        $categories = Category::all();

        return view('owners.pages.chalets.create',compact('cities','areas','categories'));
    }




    public function store(Request $request)
    {
        $request->merge([
            'phone' => $request->filled('phone') ? (Chalet::formatOmaniPhone($request->phone) ?? $request->phone) : null,
            'whatsapp_number' => $request->filled('whatsapp_number') ? (Chalet::formatOmaniPhone($request->whatsapp_number) ?? $request->whatsapp_number) : null,
        ]);

        $omanPhoneRule = function ($attribute, $value, $fail) {
            $digits = preg_replace('/\D/', '', $value ?? '');
            if (strlen($digits) !== 11 || !str_starts_with($digits, '968')) {
                $fail(__('رقم الهاتف/الواتساب إجباري ومفتاح الدولة عُمان 968 فقط (مثال: 96812345678)'));
            }
        };
        $omanPhoneRuleOptional = function ($attribute, $value, $fail) {
            if (strlen(trim($value ?? '')) === 0) return;
            $digits = preg_replace('/\D/', '', $value);
            if (strlen($digits) !== 11 || !str_starts_with($digits, '968')) {
                $fail(__('رقم الهاتف يجب أن يكون مفتاح الدولة عُمان 968 فقط (مثال: 96812345678)'));
            }
        };

        $request->validate([
            'category_id'              => 'required',
            'chalet_name_ar'            => 'required|string|max:255',
            'main_image'                => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images'                    => 'nullable|array|max:10',
            'images.*'                  => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'phone'                     => ['nullable', 'string', 'max:30', $omanPhoneRuleOptional],
            'whatsapp_number'           => ['required', 'string', 'max:30', $omanPhoneRule],

            'long_description_ar'       => 'nullable|string',
            'booking_terms_ar'          => 'nullable|string',
            'instagram_url'             => 'nullable|url|max:500',
            'tiktok_url'                => 'nullable|url|max:500',

            'map_link'                  => 'nullable|url',

            'default_day_price'         => 'nullable|numeric|min:0',
            'half_day_price'            => 'nullable|numeric|min:0',
            'stay_price'                => 'nullable|numeric|min:0',
            'holiday_day_price'         => 'nullable|numeric|min:0',
            'insurance_amount'          => 'nullable|numeric|min:0',
            'max_guests'                => 'nullable|integer|min:1',
            'amenities'                 => 'nullable|array',

            'city_id'                  => 'required',
            'area_id'                  => 'required',
        ]);

        // توليد الرابط المختصر (slug) من الاسم بالعربية مع ضمان عدم التكرار
        $baseSlug = Str::slug($request->chalet_name_ar) ?: 'chalet-' . time();
        $slug = $baseSlug;
        $counter = 1;
        while (Chalet::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $chalet = new Chalet();
        $chalet->category_id = $request->category_id;
        $chalet->owner_id = Auth::id();
        $chalet->chalet_name_ar = $request->chalet_name_ar;
        $chalet->chalet_name_en = $request->chalet_name_ar;
        $chalet->slug = $slug;
        $chalet->phone = $request->filled('phone') ? $request->phone : null;

        $chalet->long_description_ar = $request->long_description_ar;
        $chalet->map_link = $request->map_link;
        // The add-property form only asks for one "starting from" price (or none,
        // for "contact for pricing"). Mirror it across all four date-based tiers
        // so the rest of the pricing engine keeps working as-is; the owner can
        // still split them out later from the prices page.
        $chalet->default_day_price = $request->default_day_price ?: 0;
        $chalet->half_day_price = $request->half_day_price ?: ($request->default_day_price ?: 0);
        $chalet->stay_price = $request->stay_price ?: ($request->default_day_price ?: 0);
        $chalet->holiday_day_price = $request->holiday_day_price ?: ($request->default_day_price ?: 0);
        $chalet->city_id                 = $request->city_id;
        $chalet->area_id                 = $request->area_id;

        $chalet->area_size = $request->area_size;
        $chalet->dedicated_to = $request->dedicated_to;
        $chalet->max_guests = $request->max_guests;
        $chalet->bedrooms = $request->bedrooms;
        $chalet->bathrooms = $request->bathrooms;
        $chalet->councils_count = $request->councils_count;
        $chalet->amenities = $request->amenities ? json_encode($request->amenities) : null;
        $chalet->check_in_time = $request->check_in_time ?? '14:00';
        $chalet->check_out_time = $request->check_out_time ?? '12:00';
        $chalet->booking_terms_ar = $request->booking_terms_ar;
        $chalet->instagram_url = $request->instagram_url;
        $chalet->tiktok_url = $request->tiktok_url;
        $chalet->whatsapp_number = $request->whatsapp_number;
        $chalet->insurance_amount = $request->filled('insurance_amount') ? (float) $request->insurance_amount : 0;

        // حفظ الميزات الخاصة (التاقات)
        $chalet->has_pool = $request->has('has_pool') ? 1 : 0;
        $chalet->has_beachfront = $request->has('has_beachfront') ? 1 : 0;
        $chalet->has_beach = $request->has('has_beach') ? 1 : 0;
        $chalet->has_garden = $request->has('has_garden') ? 1 : 0;
        $chalet->has_mountain_view = $request->has('has_mountain_view') ? 1 : 0;

        if ($image = $request->file('main_image')){
            $path = 'images/chalets/';
            $filename = time().$image->getClientOriginalName();
            $image->move(public_path($path), $filename);
            $chalet['main_image'] = $path.$filename;
        }

        $title_ar = $request->chalet_name_ar;
        $title_en = $request->chalet_name_en;

        $keywords_ar = collect(explode(' ', $title_ar))
            ->filter(fn($word) => strlen($word) > 2)
            ->implode(', ');

        $keywords_en = collect(explode(' ', $title_en))
            ->filter(fn($word) => strlen($word) > 2)
            ->implode(', ');


        $chalet->seo_keywords_ar     = $keywords_ar;
        $chalet->seo_keywords_en     = $keywords_en;

        $chalet->save();

        // حفظ الصور الإضافية (حد أقصى 10 صور)
        if ($request->hasFile('images')) {
            $path = 'images/chalets/';
            $additionalImages = array_slice($request->file('images'), 0, 10);
            foreach ($additionalImages as $image) {
                $filename = rand() . '_' . time() . '-' . $image->getClientOriginalName();
                $image->move($path, $filename);
                ChaletImage::create([
                    'chalet_id' => $chalet->id,
                    'image_path' => $path . $filename,
                    'is_main' => false
                ]);
            }
        }
        // إرجاع استجابة JSON للـ AJAX
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'تم الإضافة بنجاح']);
        }

        toast('  تم الاضافة بنجاح','success');
        return redirect()->route('owner.chalets.index');
    }




    public function show($slug)
    {
        $chalet = Chalet::where('slug', $slug)->where('owner_id', Auth::id())->first();
        if (!$chalet) {
            abort(404);
        }
        return view('owners.pages.chalets.show', compact('chalet'));
    }



    public function edit($slug)
    {
        $cities = City::all();
        $areas = Area::all();
        $categories = Category::all();
        $chalet = Chalet::where('slug',$slug)->first();
        return view('owners.pages.chalets.edit', compact('chalet','cities','areas','categories'));
    }

    // دالة جديدة لإرجاع بيانات العقار بصيغة JSON للمودال
    public function editJson($id)
    {
        $chalet = Chalet::with(['images', 'city', 'area', 'category'])
            ->where('id', $id)
            ->where('owner_id', Auth::id())
            ->first();

        if (!$chalet) {
            return response()->json(['error' => 'العقار غير موجود'], 404);
        }

        // تحويل amenities من JSON إلى array إذا كان موجود
        if ($chalet->amenities) {
            $chalet->amenities_array = json_decode($chalet->amenities, true);
        }

        return response()->json($chalet);
    }



    public function update(Request $request, $id)
    {
        $chalet = Chalet::where('id', $id)->where('owner_id', auth()->id())->first();
        $request->merge([
            'phone' => $request->filled('phone') ? (Chalet::formatOmaniPhone($request->phone) ?? $request->phone) : null,
            'whatsapp_number' => $request->filled('whatsapp_number') ? (Chalet::formatOmaniPhone($request->whatsapp_number) ?? $request->whatsapp_number) : null,
        ]);

        if (!$chalet) {
            return response()->json(['error' => 'العقار غير موجود'], 404);
        }

        $omanPhoneRule = function ($attribute, $value, $fail) {
            $digits = preg_replace('/\D/', '', $value ?? '');
            if (strlen($digits) !== 11 || !str_starts_with($digits, '968')) {
                $fail(__('رقم الهاتف/الواتساب إجباري ومفتاح الدولة عُمان 968 فقط (مثال: 96812345678)'));
            }
        };
        $omanPhoneRuleOptional = function ($attribute, $value, $fail) {
            if (strlen(trim($value ?? '')) === 0) return;
            $digits = preg_replace('/\D/', '', $value);
            if (strlen($digits) !== 11 || !str_starts_with($digits, '968')) {
                $fail(__('رقم الهاتف يجب أن يكون مفتاح الدولة عُمان 968 فقط (مثال: 96812345678)'));
            }
        };

        $request->validate([
            'category_id'              => 'required',
            'chalet_name_ar'        => 'required|string|max:255',
            'chalet_name_en'        => 'required|string|max:255',
            'slug'                  => 'required|string|unique:chalets,slug,' . $chalet->id,
            'main_image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images'                => 'nullable|array|max:10',
            'images.*'              => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'phone'                 => ['nullable', 'string', 'max:30', $omanPhoneRuleOptional],
            'whatsapp_number'       => ['required', 'string', 'max:30', $omanPhoneRule],

            'long_description_ar'   => 'nullable|string',
            'booking_terms_ar'      => 'nullable|string',
            'instagram_url'         => 'nullable|url|max:500',
            'tiktok_url'            => 'nullable|url|max:500',

            'map_link'              => 'required|url',

            'default_day_price'     => 'required|numeric|min:0',
            'half_day_price'            => 'required|numeric|min:0',
            'stay_price'            => 'required|numeric|min:0',
            'holiday_day_price'     => 'required|numeric|min:0',
            'insurance_amount'      => 'nullable|numeric|min:0',

            'city_id'                  => 'required',
            'area_id'                  => 'required',
        ]);
        $chalet->category_id = $request->category_id;
        $chalet->chalet_name_ar = $request->chalet_name_ar;
        $chalet->chalet_name_en = $request->chalet_name_en;
        $chalet->slug = $request->slug;
        $chalet->phone = $request->filled('phone') ? $request->phone : null;

        $chalet->long_description_ar = $request->long_description_ar;
        $chalet->map_link = $request->map_link;
        $chalet->default_day_price = $request->default_day_price;
        $chalet->half_day_price = $request->half_day_price;
        $chalet->stay_price = $request->stay_price;
        $chalet->holiday_day_price = $request->holiday_day_price;
        $chalet->city_id                 = $request->city_id;
        $chalet->area_id                 = $request->area_id;

        $chalet->area_size = $request->area_size;
        $chalet->dedicated_to = $request->dedicated_to;
        $chalet->max_guests = $request->max_guests;
        $chalet->bedrooms = $request->bedrooms;
        $chalet->bathrooms = $request->bathrooms;
        $chalet->councils_count = $request->councils_count;
        $chalet->amenities = $request->amenities ? json_encode($request->amenities) : null;
        $chalet->check_in_time = $request->check_in_time ?? '14:00';
        $chalet->check_out_time = $request->check_out_time ?? '12:00';
        $chalet->booking_terms_ar = $request->booking_terms_ar;
        $chalet->instagram_url = $request->instagram_url;
        $chalet->tiktok_url = $request->tiktok_url;
        $chalet->whatsapp_number = $request->whatsapp_number;
        $chalet->insurance_amount = $request->filled('insurance_amount') ? (float) $request->insurance_amount : 0;

        // حفظ الميزات الخاصة (التاقات)
        $chalet->has_pool = $request->has('has_pool') ? 1 : 0;
        $chalet->has_beachfront = $request->has('has_beachfront') ? 1 : 0;
        $chalet->has_beach = $request->has('has_beach') ? 1 : 0;
        $chalet->has_garden = $request->has('has_garden') ? 1 : 0;
        $chalet->has_mountain_view = $request->has('has_mountain_view') ? 1 : 0;

        if ($image = $request->file('main_image')) {
            if ($chalet->main_image && file_exists(public_path($chalet->main_image))) {
                unlink(public_path($chalet->main_image));
            }
            $path = 'images/chalets/';
            $filename = time() . $image->getClientOriginalName();
            $image->move(public_path($path), $filename);
            $chalet->main_image = $path . $filename;
        }


        $chalet->save();

        // حذف الصور التي اختارها المالك للحذف (تُنفّذ عند الحفظ فقط)
        if ($request->has('delete_images') && is_array($request->delete_images)) {
            foreach ($request->delete_images as $imageId) {
                $img = ChaletImage::with('chalet')->find($imageId);
                if ($img && $img->chalet && $img->chalet->owner_id === Auth::id()) {
                    $fullPath = public_path($img->image_path);
                    if ($img->image_path && file_exists($fullPath)) {
                        @unlink($fullPath);
                    }
                    $img->delete();
                }
            }
        }

        // حفظ الصور الإضافية الجديدة (حد أقصى 10 صور)
        if ($request->hasFile('images')) {
            $path = 'images/chalets/';
            $additionalImages = array_slice($request->file('images'), 0, 10);
            foreach ($additionalImages as $image) {
                $filename = rand() . '_' . time() . '-' . $image->getClientOriginalName();
                $image->move(public_path($path), $filename);
                ChaletImage::create([
                    'chalet_id' => $chalet->id,
                    'image_path' => $path . $filename,
                    'is_main' => false
                ]);
            }
        }

        // إرجاع استجابة JSON للـ AJAX
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'تم التحديث بنجاح']);
        }

        toast('  تم التحديث  بنجاح','success');
        return redirect()->route('owner.chalets.index');
    }





    public function destroy($id)
    {
        $chalet = Chalet::findOrFail($id);

        // حذف الصور من المجلد ومن جدول chalet_images
        foreach ($chalet->images as $image) {
            // حذف الصورة من المجلد
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }

            // حذف الصورة من قاعدة البيانات
            $image->delete();
        }

        // حذف الشاليه نفسه
        $chalet->delete();

        return redirect()->route('owner.chalets.index')->with('success', 'تم حذف الشاليه بنجاح');
    }





    public function getImages($slug)
    {
        $chalet = Chalet::where('slug',$slug)->first();
        return view('owners.pages.chalets.images', compact('chalet'));
    }

    // اضافة الصور للشاليه (حد أقصى 10 صور في كل رفع)
    public function storeImages(Request $request, $chaletId)
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_names_ar' => 'nullable|array',
            'image_names_ar.*' => 'nullable|string',
            'image_names_en' => 'nullable|array',
            'image_names_en.*' => 'nullable|string',
        ]);

        $chalet = Chalet::findOrFail($chaletId);
        $path = 'images/chalets/';
        $additionalImages = array_slice($request->file('images'), 0, 10);

        foreach ($additionalImages as $index => $image) {
            $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
            $image->move(public_path($path), $filename);

            ChaletImage::create([
                'chalet_id' => $chalet->id,
                'image_path' => $path . $filename,
                'image_name_ar' => $request->image_names_ar[$index] ?? null,
                'image_name_en' => $request->image_names_en[$index] ?? null,
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'تم رفع الصور بنجاح']);
        }
        return redirect()->back()->with('success', 'تم إضافة الصور بنجاح');
    }



    public function destroyImage(Request $request, $imageId)
    {
        $image = ChaletImage::with('chalet')->findOrFail($imageId);

        // التأكد أن الصورة تخص عقاراً للمالك الحالي
        if (!$image->chalet || $image->chalet->owner_id !== Auth::id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'غير مصرح بحذف هذه الصورة'], 403);
            }
            return redirect()->back()->with('error', 'غير مصرح بحذف هذه الصورة');
        }

        try {
            // حذف ملف الصورة من المجلد (إن وُجد)
            $fullPath = public_path($image->image_path);
            if ($image->image_path && file_exists($fullPath)) {
                @unlink($fullPath);
            }

            $image->delete();
        } catch (\Throwable $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء حذف الصورة'], 500);
            }
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف الصورة');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'تم حذف الصورة بنجاح']);
        }
        return redirect()->back()->with('success', 'تم حذف الصورة بنجاح');
    }





}
