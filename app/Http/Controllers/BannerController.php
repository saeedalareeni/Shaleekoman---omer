<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('id', 'desc')->paginate(10);
        return view('backend.pages.banners.index', compact('banners'));
    }

    /**
     * Store multiple banners.
     */
    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $path = 'images/banners/';

        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($path), $filename);

            Banner::create([
                'image' => $path . $filename,
            ]);
        }

        toast('تم إضافة الصور بنجاح', 'success');
        return redirect()->back();
    }

    /**
     * Update a banner (single image).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $banner = Banner::findOrFail($id);
        $data = [];

        $path = 'images/banners/';

        if ($image = $request->file('image')) {
            // حذف الصورة القديمة
            if ($banner->image && File::exists(public_path($banner->image))) {
                File::delete(public_path($banner->image));
            }

            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($path), $filename);

            $data['image'] = $path . $filename;
        }

        $banner->update($data);

        toast('تم التعديل بنجاح', 'success');
        return redirect()->back();
    }

    /**
     * Delete a banner.
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // حذف الصورة من السيرفر
        if ($banner->image && File::exists(public_path($banner->image))) {
            File::delete(public_path($banner->image));
        }

        $banner->delete();

        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }
}
