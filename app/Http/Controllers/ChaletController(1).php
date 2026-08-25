<?php

namespace App\Http\Controllers;

use App\Mail\Notify;
use App\Models\Area;
use App\Models\Category;
use App\Models\Chalet;
use App\Models\ChaletImage;
use App\Models\City;
use App\Models\Owner;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ChaletController extends Controller
{

    public function index(Request $request)
    {
        $areas = Area::all();
        $query = $request->input('query');
        $chalets = Chalet::query()->with(['owner', 'city', 'area', 'bookings', 'images']);

        // تطبيق فلترة البحث
        if ($query) {
            $chalets->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('chalet_name_ar', 'like', "%{$query}%")
                    ->orWhere('chalet_name_en', 'like', "%{$query}%")
                    ->orWhere('slug', 'like', "%{$query}%")
                    ->orWhere('location', 'like', "%{$query}%");
            });
        }

        // تطبيق فلترة المنطقة
        if ($request->filled('area_id')) {
            $chalets->where('area_id', $request->area_id);
        }

        // تطبيق فلترة الحالة
        if ($request->filled('status')) {
            $chalets->where('status', $request->status);
        }
        
        // تطبيق فلترة المميز
        if ($request->filled('featured')) {
            $chalets->where('is_feature', $request->featured);
        }

        $chalets = $chalets->orderBy('id', 'desc')->paginate(10);

        return view('backend.pages.chalets.index', compact('chalets', 'areas'));
    }




    public function create()
    {
        $cities = City::all();
        $areas = Area::all();
        $owners = Owner::all();
        $categories = Category::all();
        return view('backend.pages.chalets.create',compact('cities','areas' ,'owners','categories'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'owner_id'                  => 'required',
            'category_id'               => 'required',
            'chalet_name_ar'            => 'required|string|max:255',
            'chalet_name_en'            => 'required|string|max:255',
            'slug'                      => 'required|string|unique:chalets,slug',
            'main_image'                => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'video'                     => 'nullable|string',
            'short_description_ar'      => 'nullable|string',
            'short_description_en'      => 'nullable|string',
            'long_description_ar'       => 'nullable|string',
            'long_description_en'       => 'nullable|string',
            'location'                  => 'nullable|string',
            'map_link'                  => 'nullable',
            'default_day_price'         => 'required|numeric|min:0',
            'half_day_price'            => 'required|numeric|min:0',
            'stay_price'                => 'required|numeric|min:0',
            'holiday_day_price'         => 'required|numeric|min:0',
            'seo_keywords_ar'           => 'nullable|string',
            'seo_keywords_en'           => 'nullable|string',
            'seo_meta_description_ar'   => 'nullable|string',
            'seo_meta_description_en'   => 'nullable|string',
            'city_id'                   => 'required',
            'area_id'                   => 'required',
        ]);


        $chalet = new Chalet();
        $chalet->owner_id = $request->owner_id;
        $chalet->category_id = $request->category_id;
        $chalet->chalet_name_ar = $request->chalet_name_ar;
        $chalet->chalet_name_en = $request->chalet_name_en;
        $chalet->slug = $request->slug;
        $chalet->video = $request->video;

        $chalet->short_description_ar = $request->short_description_ar;
        $chalet->short_description_en = $request->short_description_en;

        $chalet->long_description_ar = $request->long_description_ar;
        $chalet->long_description_en = $request->long_description_en;

        $chalet->location = $request->location;
        $chalet->map_link = $request->map_link;
        $chalet->default_day_price = $request->default_day_price;
        $chalet->half_day_price = $request->half_day_price;
        $chalet->stay_price = $request->stay_price;
        $chalet->holiday_day_price = $request->holiday_day_price;

        $chalet->seo_keywords_ar = $request->seo_keywords_ar;
        $chalet->seo_keywords_en = $request->seo_keywords_en;
        $chalet->seo_meta_description_ar = $request->seo_meta_description_ar;
        $chalet->seo_meta_description_en = $request->seo_meta_description_en;
        $chalet->city_id                 = $request->city_id;
        $chalet->area_id                 = $request->area_id;
        $chalet->is_feature              = $request->is_feature??1;
        
        // New amenities fields
        $chalet->has_pool                = $request->has_pool ? 1 : 0;
        $chalet->has_beachfront          = $request->has_beachfront ? 1 : 0;
        $chalet->has_beach               = $request->has_beach ? 1 : 0;
        $chalet->has_garden              = $request->has_garden ? 1 : 0;
        $chalet->has_mountain_view       = $request->has_mountain_view ? 1 : 0;

        if ($image = $request->file('main_image')){
            $path = 'images/chalets/';
            $filename = time().$image->getClientOriginalName();
            $image->move(public_path($path), $filename);
            $chalet['main_image'] = $path.$filename;
        }

        $chalet->save();
        toast('  تم الاضافة بنجاح','success');
        return redirect()->route('chalets.index');
    }


// public function show($id)
//{
 //   $chalet = Chalet::findOrFail($id);

    // التحقق من اللغة الحالية
//    $isArabic = app()->getLocale() === 'ar';

    // جلب طرق الدفع المفعلة
  //  $paymentMethods = \App\Models\PaymentMethod::where('status', 1)->get();

//    return view('backend.pages.chalets.show', compact('chalet', 'isArabic', 'paymentMethods'));
//}



    public function show($id)
    {
        $chalet = Chalet::findOrFail($id);
        return view('backend.pages.chalets.show', compact('chalet'));
    }

    public function getImages($id)
    {
        $chalet = Chalet::findOrFail($id);
        return view('backend.pages.chalets.images', compact('chalet'));
    }

    public function edit($id)
    {
        $owners = Owner::all();
        $cities = City::all();
        $areas = Area::all();
        $categories = Category::all();
        $chalet = Chalet::findOrFail($id);
        return view('backend.pages.chalets.edit', compact('chalet','cities','areas','owners','categories'));
    }

    public function update(Request $request, Chalet $chalet)
    {
        $request->validate([
            'owner_id'              => 'required',
            'category_id'              => 'required',
            'chalet_name_ar'        => 'required|string|max:255',
            'chalet_name_en'        => 'required|string|max:255',
            'slug'                  => 'required|string|unique:chalets,slug,' . $chalet->id,
            'main_image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'video'                 => 'nullable|string',

            'short_description_ar'  => 'nullable|string',
            'short_description_en'  => 'nullable|string',

            'long_description_ar'   => 'nullable|string',
            'long_description_en'   => 'nullable|string',

            'location'              => 'nullable|string',
            'map_link'              => 'nullable',

            'default_day_price'     => 'required|numeric|min:0',
            'half_day_price'            => 'required|numeric|min:0',
            'stay_price'            => 'required|numeric|min:0',
            'holiday_day_price'     => 'required|numeric|min:0',

            'seo_keywords_ar'       => 'nullable|string',
            'seo_keywords_en'       => 'nullable|string',

            'seo_meta_description_ar'  => 'nullable|string',
            'seo_meta_description_en'  => 'nullable|string',
            'city_id'                  => 'required',
            'area_id'                  => 'required',
        ]);

        $chalet->owner_id = $request->owner_id;
        $chalet->category_id = $request->category_id;
        $chalet->chalet_name_ar = $request->chalet_name_ar;
        $chalet->chalet_name_en = $request->chalet_name_en;
        $chalet->slug = $request->slug;
        $chalet->video = $request->video;

        $chalet->short_description_ar = $request->short_description_ar;
        $chalet->short_description_en = $request->short_description_en;

        $chalet->long_description_ar = $request->long_description_ar;
        $chalet->long_description_en = $request->long_description_en;

        $chalet->location = $request->location;
        $chalet->map_link = $request->map_link;
        $chalet->default_day_price = $request->default_day_price;
        $chalet->half_day_price = $request->half_day_price;
        $chalet->stay_price = $request->stay_price;
        $chalet->holiday_day_price = $request->holiday_day_price;

        $chalet->seo_keywords_ar = $request->seo_keywords_ar;
        $chalet->seo_keywords_en = $request->seo_keywords_en;
        $chalet->seo_meta_description_ar = $request->seo_meta_description_ar;
        $chalet->seo_meta_description_en = $request->seo_meta_description_en;
        $chalet->city_id                 = $request->city_id;
        $chalet->area_id                 = $request->area_id;
        $chalet->is_feature              = $request->is_feature??1;
        
        // New amenities fields
        $chalet->has_pool                = $request->has_pool ? 1 : 0;
        $chalet->has_beachfront          = $request->has_beachfront ? 1 : 0;
        $chalet->has_beach               = $request->has_beach ? 1 : 0;
        $chalet->has_garden              = $request->has_garden ? 1 : 0;
        $chalet->has_mountain_view       = $request->has_mountain_view ? 1 : 0;

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
        toast('  تم التحديث  بنجاح','success');
        return redirect()->route('chalets.index');
    }

    public function status(Request $request)
{
    $chalet = Chalet::where('slug', $request->slug)->firstOrFail();

    $chalet->status = $request->status;
    $chalet->save();

    $owner = $chalet->owner;
    $website_name = app()->getLocale() == 'ar' ? Setting::first()->website_name : Setting::first()->website_name_en;

    $data = [
        'title' => 'مرحباً ' . $owner->name,
        'message' => 'لقد تم ' . "[" . trans('back.' . $chalet->status) . "]!" . $chalet->title_ar . " " . $request->note
    ];

    try {
        Mail::to($owner->email)->send(new Notify($data, 'لقد تم ' . trans('back.' . $chalet->status)));
        toast('تم تحديث حالة الشاليه بنجاح وإرسال إشعار بالبريد الإلكتروني', 'success');
    } catch (\Exception $e) {
        Log::error('فشل إرسال البريد الإلكتروني: ' . $e->getMessage());
        toast('تم تحديث حالة الشاليه بنجاح، ولكن فشل إرسال إشعار بالبريد الإلكتروني', 'warning');
    }

    return redirect()->back();
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

        return redirect()->route('chalets.index')->with('success', 'تم حذف الشاليه بنجاح');
    }







    // اضافة الصور للشاليه
    public function storeImages(Request $request, $chaletId)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_names_ar.*' => 'nullable|string',
            'image_names_en.*' => 'nullable|string',
        ]);

        $chalet = Chalet::findOrFail($chaletId);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = 'images/chalets/';
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path($path), $filename);

                ChaletImage::create([
                    'chalet_id' => $chalet->id,
                    'image_path' => $path . $filename,
                    'image_name_ar' => $request->image_names_ar[$index],
                    'image_name_en' => $request->image_names_en[$index],
                ]);
            }
        }

        return redirect()->route('chalets.show', $chalet->id)->with('success', 'تم إضافة الصور بنجاح');
    }



    public function destroyImage($imageId)
    {
        $image = ChaletImage::findOrFail($imageId);

        // حذف الصورة من المجلد
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        // حذف الصورة من قاعدة البيانات
        $image->delete();

        return redirect()->back()->with('success', 'تم حذف الصورة بنجاح');
    }





    public function exportExcel(Request $request)
    {
        $chalets = $this->getFilteredChalets($request);
        
        $filename = 'chalets_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($chalets) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            
            // Header row
            fputcsv($file, [
                'الرقم',
                'اسم الشاليه',
                'المالك',
                'المدينة',
                'المنطقة',
                'السعر لليلة',
                'عدد الحجوزات',
                'إجمالي المبالغ',
                'الحالة',
                'مميز',
                'تاريخ الإضافة'
            ]);
            
            // Data rows
            foreach ($chalets as $index => $chalet) {
                fputcsv($file, [
                    $index + 1,
                    app()->getLocale() == 'ar' ? $chalet->chalet_name_ar : $chalet->chalet_name_en,
                    $chalet->owner ? $chalet->owner->name : 'غير محدد',
                    app()->getLocale() == 'ar' ? $chalet->city->name_ar : $chalet->city->name_en,
                    app()->getLocale() == 'ar' ? $chalet->area->name_ar : $chalet->area->name_en,
                    $chalet->price_per_night,
                    $chalet->bookings->count(),
                    number_format($chalet->bookings->sum('payment_amount'), 2),
                    $chalet->status == 'approved' ? 'معتمد' : ($chalet->status == 'pending' ? 'قيد المراجعة' : 'مرفوض'),
                    $chalet->is_feature ? 'نعم' : 'لا',
                    $chalet->created_at->format('Y-m-d')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportPDF(Request $request)
    {
        $chalets = $this->getFilteredChalets($request);
        $setting = Setting::first();
        
        $totalChalets = $chalets->count();
        $approvedChalets = $chalets->where('status', 'approved')->count();
        $pendingChalets = $chalets->where('status', 'pending')->count();
        $featuredChalets = $chalets->where('is_feature', 1)->count();
        
        $html = view('backend.pages.chalets.pdf', compact('chalets', 'setting', 'totalChalets', 'approvedChalets', 'pendingChalets', 'featuredChalets'))->render();
        
        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Content-Disposition', 'inline; filename="chalets_' . date('Y-m-d') . '.html"');
    }
    
    private function getFilteredChalets(Request $request)
    {
        $query = Chalet::query()->with(['owner', 'city', 'area', 'bookings', 'images']);
        
        // Apply same filters as index method
        if ($request->filled('query')) {
            $searchQuery = $request->query;
            $query->where(function ($queryBuilder) use ($searchQuery) {
                $queryBuilder->where('chalet_name_ar', 'like', "%{$searchQuery}%")
                    ->orWhere('chalet_name_en', 'like', "%{$searchQuery}%")
                    ->orWhere('slug', 'like', "%{$searchQuery}%")
                    ->orWhere('location', 'like', "%{$searchQuery}%");
            });
        }
        
        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('featured')) {
            $query->where('is_feature', $request->featured);
        }
        
        return $query->orderBy('id', 'desc')->get();
    }

}
