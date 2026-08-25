<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function index()
    {
        $pages = Page::orderBy('id', 'desc')->paginate(25);
        return view('backend.pages.my_pages.index', compact('pages'));
    }




    public function create()
    {
        return view('backend.pages.my_pages.add');
    }



    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',

            'body_ar' => 'required',
            'body_en' => 'required',
        ]);

      

        $data['name_ar'] = $request->name_ar;
        $data['name_en'] = $request->name_en;

        $data['body_ar'] = $request->body_ar;
        $data['body_en'] = $request->body_en;

        $data['meta_keywords_ar'] = $request->meta_keywords_ar;
        $data['meta_keywords_en'] = $request->meta_keywords_en;

        $data['meta_description_ar'] = $request->meta_description_ar;
        $data['meta_description_en'] = $request->meta_description_en;

        $data['slug'] = $request->slug;
        $data['status'] = $request->status;

        Page::create($data);

        toast('تم الإضافة بنجاح','success');
        return redirect()->route('pages.index');
    }



    public function show($id)
    {
        $page = Page::find($id);
        return view('backend.pages.my_pages.show', compact('page'));
    }



    public function edit($id)
    {
        $page = Page::find($id);
        return view('backend.pages.my_pages.edit', compact('page'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',

            'body_ar' => 'required',
            'body_en' => 'required',

        ]);

        $page = Page::find($id);

        $data['slug'] = $request->slug;
        $data['name_ar'] = $request->name_ar;
        $data['name_en'] = $request->name_en;

        $data['body_ar'] = $request->body_ar;
        $data['body_en'] = $request->body_en;

        $data['meta_keywords_ar'] = $request->meta_keywords_ar;
        $data['meta_keywords_en'] = $request->meta_keywords_en;

        $data['meta_description_ar'] = $request->meta_description_ar;
        $data['meta_description_en'] = $request->meta_description_en;

        $data['status'] = $request->status;

        $page->update($data);

        toast('تم التعديل بنجاح','success');
        return redirect()->route('pages.index');
    }



    public function destroy($id)
    {
        $page = Page::find($id);
        $page->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }


}
