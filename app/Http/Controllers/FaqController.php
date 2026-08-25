<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::ordered()->get();
        return view('backend.pages.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('backend.pages.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_ar' => 'required|string|max:255',
            'question_en' => 'required|string|max:255',
            'answer_ar' => 'required|string',
            'answer_en' => 'required|string',
            'category' => 'required|in:general,booking,payment,cancellation,owner',
            'order' => 'nullable|integer',
        ]);

        Faq::create($request->all());

        toast('تم إضافة السؤال بنجاح', 'success');
        return redirect()->route('faqs.index');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('backend.pages.faqs.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question_ar' => 'required|string|max:255',
            'question_en' => 'required|string|max:255',
            'answer_ar' => 'required|string',
            'answer_en' => 'required|string',
            'category' => 'required|in:general,booking,payment,cancellation,owner',
            'order' => 'nullable|integer',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->all());

        toast('تم تحديث السؤال بنجاح', 'success');
        return redirect()->route('faqs.index');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        toast('تم حذف السؤال بنجاح', 'success');
        return redirect()->route('faqs.index');
    }

    public function toggleStatus($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->is_active = !$faq->is_active;
        $faq->save();

        toast('تم تغيير حالة السؤال بنجاح', 'success');
        return redirect()->route('faqs.index');
    }
}
