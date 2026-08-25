<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::first();

        if (!$about) {
            $about = About::create([
                'company_name_ar' => 'شاليك',
                'company_name_en' => 'shaleek',
                'hero_title_ar' => 'من نحن',
                'hero_title_en' => 'About Us',
                'hero_subtitle_ar' => 'نحن منصة متخصصة في حجز الشاليهات والمزارع والاستراحات والأكواخ',
                'hero_subtitle_en' => 'We are a specialized platform for booking chalets, farms, retreats, and cabins',
                'story_title_ar' => 'رحلة نحو تجربة ضيافة استثنائية',
                'story_title_en' => 'Journey Towards Exceptional Hospitality',
                'features_title_ar' => 'ما يميزنا عن الآخرين',
                'features_title_en' => 'What Sets Us Apart',
                'cta_title_ar' => 'هل أنت مالك شاليه أو مزرعة أو استراحة؟',
                'cta_title_en' => 'Are you a chalet, farm, or retreat owner?',
                'cta_subtitle_ar' => 'انضم إلينا اليوم وابدأ في استقبال حجوزات أكثر عبر منصتنا',
                'cta_subtitle_en' => 'Join us today and start receiving more bookings through our platform',
            ]);
        }

        return view('backend.pages.about_us.index-simple', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name_ar' => 'required',
            'company_name_en' => 'required',
            'about_ar' => 'required',
            'about_en' => 'required',
        ]);

        $about = About::findOrFail($id);

        $about->company_name_ar = $request->company_name_ar;
        $about->company_name_en = $request->company_name_en;
        $about->about_ar = $request->about_ar;
        $about->about_en = $request->about_en;

        $optionalFields = [
            'slogan_ar', 'slogan_en',
            'vision_ar', 'vision_en',
            'mission_ar', 'mission_en',
            'hero_title_ar', 'hero_title_en',
            'hero_subtitle_ar', 'hero_subtitle_en',
            'story_title_ar', 'story_title_en',
            'features_title_ar', 'features_title_en',
            'cta_title_ar', 'cta_title_en',
            'cta_subtitle_ar', 'cta_subtitle_en',
        ];

        foreach ($optionalFields as $field) {
            if ($request->has($field) && Schema::hasColumn('abouts', $field)) {
                $about->$field = $request->$field;
            }
        }

        if ($image = $request->file('logo')) {
            $path = 'images/about/';
            $filename = time() . '_logo_' . $image->getClientOriginalName();
            $image->move($path, $filename);

            if ($about->logo && file_exists(public_path($about->logo))) {
                unlink(public_path($about->logo));
            }

            if (Schema::hasColumn('abouts', 'logo')) {
                $about->logo = $path . $filename;
            }
        }

        if ($image = $request->file('image_about_us')) {
            $path = 'images/about/';
            $filename = time() . '_about_' . $image->getClientOriginalName();
            $image->move($path, $filename);

            if ($about->image_about_us && file_exists(public_path($about->image_about_us))) {
                unlink(public_path($about->image_about_us));
            }

            if (Schema::hasColumn('abouts', 'image_about_us')) {
                $about->image_about_us = $path . $filename;
            }
        }

        if ($image = $request->file('hero_image')) {
            $path = 'images/about/';
            $filename = time() . '_hero_' . $image->getClientOriginalName();
            $image->move($path, $filename);

            if ($about->hero_image && file_exists(public_path($about->hero_image))) {
                unlink(public_path($about->hero_image));
            }

            if (Schema::hasColumn('abouts', 'hero_image')) {
                $about->hero_image = $path . $filename;
            }
        }

        $about->save();

        toast('تم التعديل بنجاح', 'success');

        return redirect()->back();
    }
}
