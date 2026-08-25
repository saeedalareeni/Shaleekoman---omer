<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');
        // بناء الاستعلام للبحث في قاعدة البيانات
        $categories = Category::query()
            ->when($query, function ($queryBuilder, $query) {
                return $queryBuilder->where('name', 'like', "%{$query}%")
                    ->orWhere('name_en', 'like', "%{$query}%");
            })
            ->paginate(10); // تحديد عدد العناصر في كل صفحة

        return view('backend.pages.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'            => 'required|string|max:255',
            'name_en'            => 'required|string|max:255',
        ]);
        $category = new Category();
        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->save();
        toast('  تم الاضافة بنجاح','success');
        return redirect()->back();
    }


    public function update(Request $request, category $category)
    {
        $request->validate([
            'name_ar'            => 'required|string|max:255',
            'name_en'            => 'required|string|max:255',
        ]);
        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->save();
        toast('  تم التحديث  بنجاح','success');
        return redirect()->back();

    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if($category->chalets->count()>0){
            toast('لا يمكن الحذف المدينة مرتبة بالشاليهات','error');
        }
        else{
            toast('تم حذف المدينة بنجاح','success');
            $category->delete();
        }
        return redirect()->back();
    }

}
