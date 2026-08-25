<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    public function index()
    {
        $images = Image::orderBy('id', 'desc')->paginate(25);
        return view('backend.pages.images.index', compact('images'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($image = $request->file('image')){
            $path = 'images/photos/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $path.$filename;
        }

        $data['page_id'] = $request->page_id;
        $data['post_id'] = $request->post_id;
        
        $data['name'] = $request->name;
        Image::create($data);

        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }




    public function destroy($id)
    {
        $image = Image::find($id);
        $image->delete();

        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }
}
