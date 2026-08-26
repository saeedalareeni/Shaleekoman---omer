<?php

namespace App\Http\Controllers;

use App\Mail\Notify;
use App\Models\About;
use App\Models\Area;
use App\Models\Banner;
use App\Models\BookingDate;
use App\Models\Category;
use App\Models\Chalet;
use App\Models\ChaletPrice;
use App\Models\City;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\CustomerMessage;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class FrontendController extends Controller
{
    public function index(Request $request)
    {
        // تسجيل زيارة الموقع
        trackSiteView();

        $areas = Area::all();
        $banners = Banner::all();
        $query = Chalet::query();

        // فلترة حسب المدينة
        if ($request->filled('city') && $request->city != 0) {
            $query->where('city_id', $request->input('city'));
        }

        // فلترة حسب المنطقة
        if ($request->filled('area') && $request->area != 0) {
            $query->where('area_id', $request->input('area'));
        }

        // فلترة حسب التصنيف
        if ($request->filled('category') && $request->category != 0) {
            $query->where('category_id', $request->input('category'));
        }

        // فلترة حسب التاريخ
        if ($request->filled('date')) {
            $dates = explode(' to ', $request->input('date'));
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                $query->whereDoesntHave('bookings.bookingDates', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate]);
                });
            }
        }

        // فلترة حسب السعر
        if ($request->filled('date-price') && $request->input('date-price') != 0) {
            $priceRange = explode('-', $request->input('date-price'));
            if (count($priceRange) == 2) {
                $minPrice = (float) $priceRange[0];
                $maxPrice = (float) $priceRange[1];
                $query->whereHas('bookings.bookingDates', function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween('default_day_price', [$minPrice, $maxPrice])
                        ->orWhereBetween('holiday_day_price', [$minPrice, $maxPrice]);
                });
            } elseif ($priceRange[0] == '50') {
                $query->whereDoesntHave('bookings.bookingDates', function ($q) {
                    $q->where('default_day_price', '>=', 50)
                        ->orWhere('holiday_day_price', '>=', 50);
                });
            }
        }

        $chalets = $query->where('status', 'approved')->distinct()->get();
        $sliders = Slider::where('status', 1)->get();
        $categories = Category::all();
        $cities = City::all();
        $about = About::first();

        return view('frontend.home', compact(
            'chalets', 'areas', 'sliders', 'categories', 'cities', 'about', 'banners'
        ));
    }

    public function cityDetails($slug)
    {
        // Track site view
        trackSiteView();

        // Get city by slug or name (handle both cases: with and without slug column)
        $city = City::where(function($query) use ($slug) {
            // Check if slug column exists
            if (\Schema::hasColumn('cities', 'slug')) {
                $query->where('slug', $slug);
            }
            // Also check by name
            $query->orWhere('name_ar', str_replace('-', ' ', $slug))
                  ->orWhere('name_en', str_replace('-', ' ', $slug))
                  ->orWhere('name_ar', $slug)
                  ->orWhere('name_en', $slug);
        })->firstOrFail();

        // Get all areas in this city
        $areas = Area::where('city_id', $city->id)
            ->withCount(['chalets' => function($query) {
                $query->where('status', 'approved');
            }])
            ->get();

        // Chalets to highlight in this city (newest first, no "featured" filter)
        $featuredChalets = Chalet::where('city_id', $city->id)
            ->where('status', 'approved')
            ->with(['images', 'area', 'category', 'reviews', 'owner'])
            ->withAvg('reviews', 'rating')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Get all chalets in this city with pagination
        $chalets = Chalet::where('city_id', $city->id)
            ->where('status', 'approved')
            ->with(['images', 'area', 'category', 'reviews', 'owner'])
            ->withAvg('reviews', 'rating')
            ->paginate(12);

        // Get categories with count
        $categories = Category::withCount(['chalets' => function($query) use ($city) {
            $query->where('status', 'approved')
                  ->where('city_id', $city->id);
        }])->get();

        // Get price ranges
        $priceRanges = [
            ['min' => 0, 'max' => 50, 'label' => app()->getLocale() == 'ar' ? 'أقل من 50 ريال' : 'Less than 50 OMR'],
            ['min' => 50, 'max' => 100, 'label' => '50 - 100 ' . (app()->getLocale() == 'ar' ? 'ريال' : 'OMR')],
            ['min' => 100, 'max' => 200, 'label' => '100 - 200 ' . (app()->getLocale() == 'ar' ? 'ريال' : 'OMR')],
            ['min' => 200, 'max' => 500, 'label' => '200 - 500 ' . (app()->getLocale() == 'ar' ? 'ريال' : 'OMR')],
            ['min' => 500, 'max' => null, 'label' => app()->getLocale() == 'ar' ? 'أكثر من 500 ريال' : 'More than 500 OMR'],
        ];

        // Get amenities for filter
        $amenities = [
            'pool' => app()->getLocale() == 'ar' ? 'مسبح' : 'Pool',
            'wifi' => app()->getLocale() == 'ar' ? 'واي فاي' : 'WiFi',
            'parking' => app()->getLocale() == 'ar' ? 'موقف سيارات' : 'Parking',
            'kitchen' => app()->getLocale() == 'ar' ? 'مطبخ' : 'Kitchen',
            'ac' => app()->getLocale() == 'ar' ? 'تكييف' : 'Air Conditioning',
            'garden' => app()->getLocale() == 'ar' ? 'حديقة' : 'Garden',
            'bbq' => app()->getLocale() == 'ar' ? 'شواء' : 'BBQ',
            'playground' => app()->getLocale() == 'ar' ? 'ملعب أطفال' : 'Playground',
        ];

        // Get statistics
        $stats = [
            'total_chalets' => $chalets->total(),
            'avg_price' => Chalet::where('city_id', $city->id)
                ->where('status', 'approved')
                ->avg('default_day_price'),
            'total_reviews' => \App\Models\Review::whereHas('chalet', function($q) use ($city) {
                $q->where('city_id', $city->id);
            })->count(),
            'avg_rating' => \App\Models\Review::whereHas('chalet', function($q) use ($city) {
                $q->where('city_id', $city->id);
            })->avg('rating'),
        ];

        return view('frontend.city-details', compact(
            'city',
            'areas',
            'featuredChalets',
            'chalets',
            'categories',
            'priceRanges',
            'amenities',
            'stats'
        ));
    }

    public function weekendHome()
    {
        // Track site view
        trackSiteView();

        // Get sliders for hero section
        $sliders = Slider::where('status', 1)
            ->orderBy('id', 'asc')
            ->take(5)
            ->get();

        // Get featured destinations (cities with chalets)
        $destinations = City::has('chalets')
            ->withCount(['chalets' => function($query) {
                $query->where('status', 'approved');
            }])
            ->take(8)
            ->get();

        // Deals section: recent approved chalets (no "featured" filter)
        $featuredChalets = Chalet::where('status', 'approved')
            ->with(['images', 'city', 'area', 'category', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        // Get recent chalets for "New Properties" section
        $newChalets = Chalet::where('status', 'approved')
            ->with(['images', 'city', 'area', 'category', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Get popular chalets based on views or bookings
        $popularChalets = Chalet::where('status', 'approved')
            ->with(['images', 'city', 'area', 'category', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(8)
            ->get();

        // Get banners for advertising
        $banners = Banner::all();

        // Get categories for filter
        $categories = Category::withCount(['chalets' => function($query) {
            $query->where('status', 'approved');
        }])
        ->get()
        ->filter(function($category) {
            return $category->chalets_count > 0;
        });

        // Get Chalets by category (for tabs)
        $chaletsByCategory = Chalet::where('status', 'approved')
            ->where('category_id', 1) // Assuming category ID 1 is for Chalets
            ->with(['images', 'city', 'area', 'category', 'reviews', 'owner'])
            ->withAvg('reviews', 'rating')
            ->take(10)
            ->get();

        // Get Farms by category
        $farmsByCategory = Chalet::where('status', 'approved')
            ->where('category_id', 2) // Assuming category ID 2 is for Farms
            ->with(['images', 'city', 'area', 'category', 'reviews', 'owner'])
            ->withAvg('reviews', 'rating')
            ->take(10)
            ->get();

        // Get Rest Houses by category
        $restHousesByCategory = Chalet::where('status', 'approved')
            ->where('category_id', 3) // Assuming category ID 3 is for Rest Houses
            ->with(['images', 'city', 'area', 'category', 'reviews', 'owner'])
            ->withAvg('reviews', 'rating')
            ->take(10)
            ->get();

        // Get areas for filter
        $areas = Area::withCount(['chalets' => function($query) {
            $query->where('status', 'approved');
        }])
        ->get()
        ->filter(function($area) {
            return $area->chalets_count > 0;
        });

        // Build a chalets list per real category (used by the homepage category sections)
        $chaletsByCategoryMap = [];
        foreach ($categories as $cat) {
            $chaletsByCategoryMap[$cat->id] = Chalet::where('status', 'approved')
                ->where('category_id', $cat->id)
                ->with(['images', 'city', 'area', 'category', 'reviews', 'owner'])
                ->withAvg('reviews', 'rating')
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();
        }

        // Get about section data
        $about = About::first();

        // Get contact info
        $contact = Contact::first();

        // Get latest blog posts
        $posts = Post::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get all cities for filter
        $cities = City::all();

        // Simple site-wide stats for the "why Shaleek" section
        $totalApprovedCount = Chalet::where('status', 'approved')->count();
        $totalGovernoratesCount = City::has('chalets')->count();

        return view('frontend.weekend-home', compact(
            'sliders',
            'destinations',
            'featuredChalets',
            'newChalets',
            'popularChalets',
            'chaletsByCategory',
            'farmsByCategory',
            'restHousesByCategory',
            'chaletsByCategoryMap',
            'banners',
            'categories',
            'areas',
            'cities',
            'about',
            'contact',
            'posts',
            'totalApprovedCount',
            'totalGovernoratesCount'
        ));
    }




    public function old_showAllChalet(Request $request)
    {
        $areas = Area::all();
        $query = Chalet::query();

        if ($request->area != 0) {
            $query->whereDoesntHave('bookings.bookingDates')->where('area_id', $request->input('area'));
        }

        if ($request->category != 0) {
            $query->whereDoesntHave('bookings.bookingDates')->where('category_id', $request->input('category'));
        }
        if ($request->filled('date')) {
            $dates = explode(' to ', $request->input('date'));

            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                $query->whereDoesntHave('bookings.bookingDates', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate]);
                });
            }
        }

        if ($request->filled('date-price') && $request->input('date-price') != 0) {
            $priceRange = explode('-', $request->input('date-price'));

            if (count($priceRange) == 2) {
                $minPrice = (float) $priceRange[0];
                $maxPrice = (float) $priceRange[1];

                $query->whereHas('bookings.bookingDates', function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween('default_day_price', [$minPrice, $maxPrice])
                      ->orWhereBetween('holiday_day_price', [$minPrice, $maxPrice]);
                });
            } elseif ($priceRange[0] == '50') {
                // تصفية الشاليهات التي أسعارها أكبر من 50
                $query->whereDoesntHave('bookings', function ($q) {
                    $q->where('default_day_price', '>=', 50)
                      ->orWhere('holiday_day_price', '>=', 50);
                });
            }
        }

        $chalets = $query->where('status', 'approved')->where('is_feature', 1)->distinct()->paginate(20);
        return view('frontend.pages.chalets.index', compact('chalets','areas'));
    }



    // API للحصول على الولايات حسب المحافظة
    public function getStatesByGovernorate($govId)
    {
        $states = City::where('id', $govId)->get();
        return response()->json($states);
    }

    // API للحصول على المناطق حسب الولاية
    public function getAreasByState($stateId)
    {
        $areas = Area::where('city_id', $stateId)->get();
        return response()->json($areas);
    }

    public function showPremiumChalets(Request $request)
    {
        $areas = Area::all();
        $query = Chalet::query();

        // فلترة حسب السعر (من الصفحة الرئيسية)
        if ($request->filled('price')) {
            $prices = $request->input('price');
            $query->where(function($q) use ($prices) {
                foreach ($prices as $priceRange) {
                    if ($priceRange == '200+') {
                        $q->orWhere('default_day_price', '>=', 200);
                    } else {
                        $range = explode('-', $priceRange);
                        if (count($range) == 2) {
                            $q->orWhereBetween('default_day_price', [(float)$range[0], (float)$range[1]]);
                        }
                    }
                }
            });
        }

        // فلترة حسب نوع العقار (أقسام من قاعدة البيانات - category ids)
        if ($request->filled('property')) {
            $categoryIds = $request->input('property');
            if (is_array($categoryIds)) {
                $query->whereIn('category_id', $categoryIds);
            } else {
                $query->where('category_id', $categoryIds);
            }
        }

        // فلترة حسب تاريخ الحجز (من الصفحة الرئيسية)
        if ($request->filled('booking_from') && $request->filled('booking_to')) {
            $startDate = $request->input('booking_from');
            $endDate = $request->input('booking_to');
            $query->whereDoesntHave('bookings.bookingDates', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            });
        }

        // فلترة حسب المنطقة (من الصفحة الرئيسية)
        if ($request->filled('area')) {
            $areaValues = $request->input('area');
            if (is_array($areaValues)) {
                // إذا كانت array (من الصفحة الرئيسية)
                $query->whereIn('area_id', $areaValues);
            } elseif ($areaValues != 0) {
                // إذا كانت قيمة واحدة (من الفلتر القديم)
                $query->where('area_id', $areaValues);
            }
        }

        // فلترة حسب الولاية (من الصفحة الرئيسية)
        if ($request->filled('state')) {
            $stateValues = $request->input('area');
            if (is_array($stateValues)) {
                $query->whereIn('city_id', $stateValues);
            }
        }

        // فلترة حسب المحافظة (من الصفحة الرئيسية)
        if ($request->filled('gov')) {
            $govValues = $request->input('gov');
            if (is_array($govValues)) {
                $query->whereIn('city_id', $govValues);
            }
        }

        // الفلترات القديمة (للتوافق مع الصفحة القديمة)
        if ($request->filled('city') && $request->city != 0) {
            $query->where('city_id', $request->input('city'));
        }

        if ($request->filled('category') && $request->category != 0) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('date')) {
            $dates = explode(' to ', $request->input('date'));
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                $query->whereDoesntHave('bookings.bookingDates', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate]);
                });
            }
        }

        if ($request->filled('date-price') && $request->input('date-price') != 0) {
            $priceRange = explode('-', $request->input('date-price'));
            if (count($priceRange) == 2) {
                $minPrice = (float) $priceRange[0];
                $maxPrice = (float) $priceRange[1];
                $query->whereBetween('default_day_price', [$minPrice, $maxPrice]);
            } elseif ($priceRange[0] == '50') {
                $query->where('default_day_price', '<', 50);
            }
        }

        $chalets = $query->where('status', 'approved')
            // ->where('is_feature', 1) // تم التعليق لعرض جميع الشاليهات
            ->distinct()
            ->paginate(20);

        return view('frontend.pages.chalets.premium-index', compact('chalets', 'areas'));
    }

    public function showAllChalet(Request $request)
    {
        $areas = Area::all();
        $query = Chalet::query();
        $selectedCategory = null;

        // فلترة حسب المدينة
        if ($request->filled('city') && $request->city != 0) {
            $query->where('city_id', $request->input('city'));
        }

        if ($request->filled('area') && $request->area != 0) {
            $query->where('area_id', $request->input('area'));
        }

        if ($request->filled('category') && $request->category != 0) {
            $query->where('category_id', $request->input('category'));
            $selectedCategory = Category::find($request->input('category'));
        }

        if ($request->filled('date')) {
            $dates = explode(' to ', $request->input('date'));
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                $query->whereDoesntHave('bookings.bookingDates', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate]);
                });
            }
        }

        if ($request->filled('date-price') && $request->input('date-price') != 0) {
            $priceRange = explode('-', $request->input('date-price'));
            if (count($priceRange) == 2) {
                $minPrice = (float) $priceRange[0];
                $maxPrice = (float) $priceRange[1];
                $query->whereHas('bookings.bookingDates', function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween('default_day_price', [$minPrice, $maxPrice])
                        ->orWhereBetween('holiday_day_price', [$minPrice, $maxPrice]);
                });
            } elseif ($priceRange[0] == '50') {
                $query->whereDoesntHave('bookings.bookingDates', function ($q) {
                    $q->where('default_day_price', '>=', 50)
                        ->orWhere('holiday_day_price', '>=', 50);
                });
            }
        }

        $chalets = $query->where('status', 'approved')
            ->where('is_feature', 1)
            ->distinct()
            ->paginate(20);

        return view('frontend.pages.chalets.index', compact('chalets','areas', 'selectedCategory'));
    }






    public function about_us()
    {
        $about=About::first();
        return view('frontend.pages.about_us_simple',compact('about'));
    }

    public function page($slug)
    {
        $page=Page::where('slug', $slug)->first();
        return view('frontend.pages.page',compact('page'));
    }


    public function contact_us()
    {
        $contact_us = Contact::first();
        $faqs = \App\Models\Faq::active()->ordered()->get();
        return view('frontend.pages.contact_us',compact('contact_us', 'faqs'));
    }


    public function send_messages(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Combine first and last name
        $data = $request->all();
        $data['name'] = $request->first_name . ' ' . $request->last_name;

        // Create the message
        $customerMessage = CustomerMessage::create($data);

        // Send notification to admins
        $this->notifyAdminsAboutNewMessage($customerMessage);

        // Send email notification
        try {
            // Get admins with same logic
            $admins = collect();
            if (\Schema::hasColumn('users', 'role')) {
                $admins = \App\Models\User::where('role', 'admin')->get();
            } elseif (\Schema::hasColumn('users', 'is_admin')) {
                $admins = \App\Models\User::where('is_admin', 1)->get();
            } else {
                $admins = \App\Models\User::where('id', 1)->get();
            }

            foreach ($admins as $admin) {
                // You can create this mail class later if needed
                // Mail::to($admin->email)->send(new \App\Mail\NewContactMessage($customerMessage));
            }
        } catch (\Exception $e) {
            Log::error('فشل إرسال البريد الإلكتروني: ' . $e->getMessage());
        }

        // Flash success message
        session()->flash('success', app()->getLocale() == 'ar' ?
            'شكراً لتواصلك معنا! تم إرسال رسالتك بنجاح وسنقوم بالرد عليك في أقرب وقت ممكن.' :
            'Thank you for contacting us! Your message has been sent successfully and we will reply to you as soon as possible.');

        return redirect()->back();
    }

    private function notifyAdminsAboutNewMessage($message)
    {
        // Get all admins - check if columns exist first
        $admins = collect();

        // Check if role column exists
        if (\Schema::hasColumn('users', 'role')) {
            $admins = \App\Models\User::where('role', 'admin')->get();
        } elseif (\Schema::hasColumn('users', 'is_admin')) {
            $admins = \App\Models\User::where('is_admin', 1)->get();
        } else {
            // If no admin columns exist, get first user as admin
            $admins = \App\Models\User::where('id', 1)->get();
        }

        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'type' => 'contact_message',
                'title_ar' => 'رسالة جديدة من نموذج الاتصال',
                'title_en' => 'New Contact Form Message',
                'message_ar' => 'رسالة جديدة من: ' . $message->name . ' - الموضوع: ' . $message->subject,
                'message_en' => 'New message from: ' . $message->name . ' - Subject: ' . $message->subject,
                'url' => route('customer-messages.index'),
                'icon' => 'fas fa-envelope',
                'color' => 'info',
                'data' => json_encode([
                    'message_id' => $message->id,
                    'sender_name' => $message->name,
                    'sender_email' => $message->email,
                    'subject' => $message->subject
                ])
            ]);
        }
    }



    public function showChalet($slug)
    {
        $chalet = Chalet::where('slug', $slug)->firstOrFail();
        // تسجيل مشاهدة الشاليه
        trackChaletView($chalet->id);

        $similarChalets = Chalet::where('status', 'approved')
            ->where('id', '!=', $chalet->id)
            ->where(function ($q) use ($chalet) {
                $q->where('category_id', $chalet->category_id)
                    ->orWhere('city_id', $chalet->city_id);
            })
            ->with(['images', 'city', 'area', 'category', 'owner'])
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.pages.chalets.show', compact('chalet', 'similarChalets'));
    }

    public function ownerChalets($ownerId)
    {
        $owner = \App\Models\Owner::findOrFail($ownerId);
        $chalets = Chalet::where('owner_id', $ownerId)
            ->where('status', 'approved')
            ->with(['images', 'city', 'area'])
            ->get();

        return view('frontend.pages.owner-chalets', compact('owner', 'chalets'));
    }



    // جلب السعر
    public function getPrices(Request $request, Chalet $chalet)
    {
        // الحصول على التواريخ من الطلب
        $dates = $request->input('dates');

        // الحصول على التواريخ المحجوزة
        $bookedDates = BookingDate::whereHas('booking', function ($query) use ($chalet) {
            $query->where('chalet_id', $chalet->id);
        })->pluck('date')->toArray();

        // تصفية التواريخ المحجوزة من التواريخ المطلوبة
        $filteredDates = array_diff($dates, $bookedDates);

        // استرجاع الأسعار المخصصة
        $customPrices = ChaletPrice::where('chalet_id', $chalet->id)
            ->whereIn('date', $filteredDates)
            ->get()
            ->keyBy('date');

        $prices = [];

        // جمع الأسعار لكل تاريخ
        foreach ($filteredDates as $date) {
            $price = $chalet->getPriceForDate($date);
            $isCustom = $customPrices->has($date);

            $prices[] = [
                'date' => $date,
                'price' => $price,
                'isCustom' => $isCustom,
            ];
        }

        return response()->json([
            'prices' => $prices,
            'bookedDates' => $bookedDates
        ]);
    }


    public function terms()
    {
        $setting = Setting::first();
        $terms = \App\Models\Term::active()->byType('terms')->ordered()->get();
        $privacy = \App\Models\Term::active()->byType('privacy')->ordered()->get();
        $refund = \App\Models\Term::active()->byType('refund')->ordered()->get();
        return view('frontend.pages.terms-new' , compact('setting', 'terms', 'privacy', 'refund'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'رمز القسيمة غير صحيح.']);
        }

        if (!$coupon->is_active) {
            return response()->json(['valid' => false, 'message' => 'رمز القسيمة غير نشط.']);
        }

        if ($coupon->expires_at && Carbon::parse($coupon->expires_at)->isPast()) {
            return response()->json(['valid' => false, 'message' => 'انتهت صلاحية هذه القسيمة.']);
        }

        if ($coupon->used_count >= $coupon->max_uses) {
            return response()->json(['valid' => false, 'message' => 'تم استخدام هذه القسيمة بالكامل.']);
        }

        return response()->json([
            'valid' => true,
            'discount_percentage' => $coupon->discount_percentage
        ]);
    }


    public function post_details($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (!$post) {
            abort(404);
        }

        // Increment views count
        $post->increment('views');

        return view('frontend.pages.posts.show-enhanced', compact('post'));
    }

    public function posts()
    {
        $posts=Post::where('status',1)->paginate(12);
        return view('frontend.pages.posts.index',compact('posts'));
    }
}
