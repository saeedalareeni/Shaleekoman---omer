<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * عرض جميع الأقسام مع البحث والصفحات
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $categories = Category::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name_ar', 'like', "%{$query}%")
                  ->orWhere('name_en', 'like', "%{$query}%")
                  ->orWhere('description_ar', 'like', "%{$query}%")
                  ->orWhere('description_en', 'like', "%{$query}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('backend.pages.categories.index', compact('categories'));
    }

    /**
     * عرض نموذج إنشاء قسم جديد
     */
    public function create()
    {
        return view('backend.pages.categories.create');
    }

    /**
     * حفظ قسم جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        Category::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
        ]);

        toast('تمت الإضافة بنجاح', 'success');
        return redirect()->route('categories.index');
    }

    /**
     * عرض نموذج تعديل قسم
     */
    public function edit(Category $category)
    {
        return view('backend.pages.categories.edit', compact('category'));
    }

    /**
     * تحديث قسم
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
        ]);

        toast('تم التحديث بنجاح', 'success');
        return redirect()->route('categories.index');
    }

    /**
     * حذف قسم
     */
    public function destroy(Category $category)
    {
        if ($category->chalets()->count() > 0) {
            toast('لا يمكن الحذف، هناك شاليهات مرتبطة بهذا القسم', 'error');
        } else {
            $category->delete();
            toast('تم الحذف بنجاح', 'success');
        }

        return redirect()->route('categories.index');
    }
}
