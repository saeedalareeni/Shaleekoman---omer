<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Chalet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // التحقق من تسجيل الدخول
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')
                ->with('error', app()->getLocale() == 'ar' ? 'يجب تسجيل الدخول أولاً' : 'You must login first');
        }

        $request->validate([
            'chalet_id' => 'required|exists:chalets,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // التحقق من عدم وجود تقييم سابق من نفس المستخدم لنفس الشاليه
        $existingReview = Review::where('chalet_id', $request->chalet_id)
            ->where('customer_id', Auth::guard('customer')->id())
            ->first();

        if ($existingReview) {
            return back()->with('error', app()->getLocale() == 'ar' ? 
                'لقد قمت بتقييم هذا العقار مسبقاً' : 
                'You have already reviewed this property');
        }

        // إنشاء التقييم الجديد
        $review = Review::create([
            'chalet_id' => $request->chalet_id,
            'customer_id' => Auth::guard('customer')->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // تحديث متوسط التقييم للشاليه
        $chalet = Chalet::find($request->chalet_id);
        $reviews = Review::where('chalet_id', $request->chalet_id)->get();
        $chalet->rating = round($reviews->avg('rating'), 1);
        $chalet->total_reviews = $reviews->count();
        $chalet->save();

        return back()->with('success', app()->getLocale() == 'ar' ? 
            'تم إرسال تقييمك بنجاح' : 
            'Your review has been submitted successfully');
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // التحقق من أن المستخدم هو صاحب التقييم
        if ($review->customer_id != Auth::guard('customer')->id()) {
            return back()->with('error', app()->getLocale() == 'ar' ? 
                'غير مصرح لك بتعديل هذا التقييم' : 
                'You are not authorized to edit this review');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // تحديث متوسط التقييم للشاليه
        $chalet = Chalet::find($review->chalet_id);
        $reviews = Review::where('chalet_id', $review->chalet_id)->get();
        $chalet->rating = round($reviews->avg('rating'), 1);
        $chalet->total_reviews = $reviews->count();
        $chalet->save();

        return back()->with('success', app()->getLocale() == 'ar' ? 
            'تم تحديث تقييمك بنجاح' : 
            'Your review has been updated successfully');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // التحقق من أن المستخدم هو صاحب التقييم أو مدير النظام
        if ($review->customer_id != Auth::guard('customer')->id() && !Auth::guard('web')->check()) {
            return back()->with('error', app()->getLocale() == 'ar' ? 
                'غير مصرح لك بحذف هذا التقييم' : 
                'You are not authorized to delete this review');
        }

        $chaletId = $review->chalet_id;
        $review->delete();

        // تحديث متوسط التقييم للشاليه
        $chalet = Chalet::find($chaletId);
        $reviews = Review::where('chalet_id', $chaletId)->get();
        $chalet->rating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;
        $chalet->total_reviews = $reviews->count();
        $chalet->save();

        return back()->with('success', app()->getLocale() == 'ar' ? 
            'تم حذف التقييم بنجاح' : 
            'Review has been deleted successfully');
    }
}
