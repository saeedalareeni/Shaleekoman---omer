<?php

namespace App\Http\Controllers;

use App\Models\Customer; // تأكد من استيراد نموذج العميل
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerProfileController extends Controller
{

    public function index()
    {
        $customer = Customer::find(auth('customer')->id());
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }
        $chalets = Auth::guard('customer')->user()->wishlist()->latest()->get();

        return view('frontend.customer.index', compact('customer', 'chalets'));
    }
    public function orders()
    {
        // جلب جميع الحجوزات الخاصة بالعميل الحالي
        $bookings = \App\Models\Booking::where('customer_id', auth('customer')->id())
                    ->orWhere('user_id', auth('customer')->id())
                    ->with(['chalet', 'chalet.city', 'chalet.area'])
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('frontend.customer.my_order', compact('bookings'));
    }

public function wishlist()
{
    $chalets = Auth::guard('customer')->user()->wishlist()->latest()->get();
    return view('frontend.customer.wishlist' , compact('chalets'));
}
    // عرض الملف الشخصي للعميل
    public function show($id)
    {
        $customer = Customer::find(auth('customer')->id());
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }
        return view('frontend.customer.profile', compact('customer'));
    }


    // عرض صفحة تحرير الملف الشخصي للعميل
    public function edit($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }

        return view('customer.edit', compact('customer'));
    }

    // تحديث الملف الشخصي للعميل
    public function update(Request $request)
    {
        $customer = Customer::find($request->id);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|unique:customers,phone,' .$customer->id,
        ]);
        $customer->update($request->all());
        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }
    public function ResetPassword(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'password' => 'required|min:8',
            'confirm-password' => 'required|min:8|same:password',
        ]);
        $customer = Customer::findOrFail($request->id);

        $customer->password = Hash::make($request->password);
        $customer->save();
        toast('تم تغيير كلمة المرور بنجاح ','success');
        return redirect()->back();
    }
}
