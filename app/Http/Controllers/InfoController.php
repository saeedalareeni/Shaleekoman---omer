<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Http\Requests\StoreInfoRequest;
use App\Http\Requests\UpdateInfoRequest;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::all();
        return view('backend.pages.infos.index', compact('infos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'body_ar' => 'required',
            'body_en' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($image = $request->file('image')){
            $path = 'images/infos/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $path.$filename;
        }

        $data['name_ar'] = $request->name_ar;
        $data['name_en'] = $request->name_en;
        $data['body_ar'] = $request->body_ar;
        $data['body_en'] = $request->body_en;

        Info::create($data);

        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'body_ar' => 'required',
            'body_en' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $info = Info::find($id);

        if ($image = $request->file('image')){
            $path = 'images/infos/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $path.$filename;
        }

        $data['name_ar'] = $request->name_ar;
        $data['name_en'] = $request->name_en;
        $data['body_ar'] = $request->body_ar;
        $data['body_en'] = $request->body_en;

        $info->update($data);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }


    public function destroy($id)
    {
        $info = Info::find($id);
        $info->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }


}
