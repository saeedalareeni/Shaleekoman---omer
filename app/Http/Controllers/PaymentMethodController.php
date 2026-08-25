<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Payment_method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{


    public function index()
    {
        $paymentMethods = Payment_method::orderBy('id', 'desc')->paginate(100);
        return view('backend.pages.paymentMethods.index', compact('paymentMethods'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        Payment_method::create([
            'user_id' => Auth::id(),
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
        ]);
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        $payment_method = Payment_method::find($id);
        $payment_method->update([
            'user_id' => Auth::id(),
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
        ]);
        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }

    public function show($id)
    {
        $paymentMethod = Payment_method::find($id);
        return view('backend.pages.paymentMethods.setting',compact('paymentMethod'));
    }

    public function setting(Request $request)
    {
        $paymentMethod = Payment_method::find($request->id);
        $paymentMethod->update([
            'secret_key'=>$request->secret_key,
            'publish_key'=>$request->publish_key,
            'is_active'=>$request->is_active,
        ]);
        $paymentMethod->save();
        toast('تم التعديل بنجاح','success');
        return redirect()->route('paymentsMethod.index');

    }


    public function destroy($id)
    {
        $payment_method = Payment_method::find($id);
        $payment_method->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }
}
