<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('query');
        $coupons = Coupon::query()
            ->where('code', 'LIKE', "%{$search}%")
            ->orWhere('discount_percentage', 'LIKE', "%{$search}%")
            ->orWhere('max_uses', 'LIKE', "%{$search}%")
            ->orWhere('used_count', 'LIKE', "%{$search}%")
            ->orWhere('expires_at', 'LIKE', "%{$search}%")
            ->orWhere('is_active', 'LIKE', "%{$search}%")

            ->orderBy('id', 'desc')->paginate(10);
        return view('backend.pages.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'max_uses' => 'required|integer|min:1',
            'expires_at' => 'nullable|date|after_or_equal:today',
        ]);

        Coupon::create($request->all());
        toast('تم إنشاء الكوبون بنجاح', 'success');
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'discount_percentage' => 'required|integer|min:1|max:100',
            'max_uses' => 'required|integer|min:1',
            'expires_at' => 'nullable|date|',
            'is_active' => 'required|boolean',
        ]);
    
        $coupon->update($request->all());
        toast('تم تحديث الكوبون بنجاح', 'success');
        return redirect()->back();
    }


    public function show($code)
    {
        return 'll';
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }



}

