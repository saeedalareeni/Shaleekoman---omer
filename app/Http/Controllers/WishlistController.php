<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chalet;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle($chalet)
    {
        // Handle both ID and model binding
        if (!($chalet instanceof Chalet)) {
            $chalet = Chalet::findOrFail($chalet);
        }
        
        $chaletId = $chalet->id;
        $customer = auth('customer')->user();

        if (!$customer) {
            $message = app()->getLocale() == 'ar' ? 'يجب تسجيل الدخول أولاً لإضافة الشاليه إلى المفضلة' : 'Please login first to add this chalet to wishlist';
            return response()->json(['status' => 'unauthenticated', 'message' => $message], 401);
        }

        if ($customer->wishlist()->where('chalet_id', $chaletId)->exists()) {
            $customer->wishlist()->detach($chaletId);
            $message = app()->getLocale() == 'ar' ? 'تم إزالة الشاليه من المفضلة' : 'Chalet removed from wishlist';
            return response()->json(['status' => 'removed', 'message' => $message]);
        } else {
            $customer->wishlist()->attach($chaletId);
            $message = app()->getLocale() == 'ar' ? 'تم إضافة الشاليه إلى المفضلة' : 'Chalet added to wishlist';
            return response()->json(['status' => 'added', 'message' => $message]);
        }
    }

    public function index()
    {
        $chalets = Auth::guard('customer')->user()->wishlist()->latest()->get();
        return view('wishlist.index', compact('chalets'));
    }
}
