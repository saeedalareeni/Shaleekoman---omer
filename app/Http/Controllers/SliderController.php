<?php

namespace App\Http\Controllers;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('id', 'desc')->get();
        return view('backend.pages.sliders.index-new', compact('sliders'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'title_ar'      => 'required|string',
            'title_en'      => 'required|string',
            'url'           => 'required|string',
            'image'         => 'nullable|file|max:1048',
        ]);

        if ($image = $request->file('image')){
            $path = 'images/Sliders/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $path.$filename;
        }

        $data['title_ar'] = $request->title_ar;
        $data['title_en'] = $request->title_en;
        $data['url'] = $request->url;
        $data['status'] = $request->status;

        Slider::create($data);

        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'title_ar'      => 'required|string',
            'title_en'      => 'required|string',
            'url'           => 'required|string',
            'image'         => 'nullable|file|max:1048',
        ]);

        $slider = Slider::find($id);

        if ($image = $request->file('image')){
            $path = 'images/Sliders/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $path.$filename;
        }

        $data['title_ar'] = $request->title_ar;
        $data['title_en'] = $request->title_en;
        $data['url'] = $request->url;
        $data['status'] = $request->status;

        $slider->update($data);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $slider = Slider::find($id);
        $slider->delete();

        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }


}
