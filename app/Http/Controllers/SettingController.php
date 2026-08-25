<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{


    public function index()
    {
        $setting = Setting::first() ?? new Setting();
        return view('backend.pages.setting.admin_settings', compact('setting'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'logo'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'header'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stamp'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_name_ar'   => 'required|string|max:255',
            'company_name_en'   => 'required|string|max:255',
            'cr_no'             => 'nullable|string|max:255',
            'address_ar'        => 'nullable|string|max:255',
            'address_en'        => 'nullable|string|max:255',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:20',
            'tax_no'            => 'nullable|string|max:255',
            'tax'               => 'nullable|numeric|min:0|max:100',
        ]);

        $setting = Setting::find($id);

        // رفع الملفات وحفظ المسارات
        $files = ['logo', 'header', 'footer', 'stamp'];
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $image = $request->file($file);
                $newImage = time() . $image->getClientOriginalName();
                $image->move('uploads/setting', $newImage);
                $setting->$file = 'uploads/setting/' . $newImage;
            }
        }

        $setting->company_name_ar = $request->input('company_name_ar');
        $setting->company_name_en = $request->input('company_name_en');
        $setting->cr_no = $request->input('cr_no');
        $setting->address_ar = $request->input('address_ar');
        $setting->address_en = $request->input('address_en');
        $setting->email = $request->input('email');
        $setting->phone = $request->input('phone');
        $setting->tax_no = $request->input('tax_no');
        $setting->tax = $request->input('tax');
        $setting->advance_amount = $request->advance_amount;
        $setting->terms_ar = $request->terms_ar;
        $setting->terms_en = $request->terms_en;

        $setting->save();
        Cache::forget('site_settings');

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }




}
