<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index()
    {
        $terms = Term::ordered()->get();
        return view('backend.pages.terms.index', compact('terms'));
    }

    public function create()
    {
        return view('backend.pages.terms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'required|string',
            'type' => 'required|in:terms,privacy,refund,cookies',
            'order' => 'nullable|integer',
            'effective_date' => 'nullable|date',
            'version' => 'nullable|string|max:20',
        ]);

        Term::create($request->all());

        toast('تم إضافة الصفحة بنجاح', 'success');
        return redirect()->route('terms.index');
    }

    public function edit($id)
    {
        $term = Term::findOrFail($id);
        return view('backend.pages.terms.edit', compact('term'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'required|string',
            'type' => 'required|in:terms,privacy,refund,cookies',
            'order' => 'nullable|integer',
            'effective_date' => 'nullable|date',
            'version' => 'nullable|string|max:20',
        ]);

        $term = Term::findOrFail($id);
        $term->update($request->all());

        toast('تم تحديث الصفحة بنجاح', 'success');
        return redirect()->route('terms.index');
    }

    public function destroy($id)
    {
        $term = Term::findOrFail($id);
        $term->delete();

        toast('تم حذف الصفحة بنجاح', 'success');
        return redirect()->route('terms.index');
    }

    public function toggleStatus($id)
    {
        $term = Term::findOrFail($id);
        $term->is_active = !$term->is_active;
        $term->save();

        toast('تم تغيير حالة الصفحة بنجاح', 'success');
        return redirect()->route('terms.index');
    }
}
