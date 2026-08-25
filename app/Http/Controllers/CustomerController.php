<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Models\Customer;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('query');
        $customers = Customer::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")

            ->orderBy('id', 'desc')->paginate(10);
        return view('backend.pages.customers.index',compact('customers'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:customers,phone',
            'email' => 'required|unique:customers,email',
        ]);

        if (Customer::count() > 0) {
            $account_number = DB::table('customers')->orderBy('id', 'DESC')->latest()->first()->id + 2;
        } else {
            $account_number = 1;
        }
        $data = $request->all();
        $data['account_number'] = '00000' . $account_number;
        $data['password'] = Hash::make($request->password);
        $data['username'] = $request->email;
        Customer::create($data);
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }


    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:customers,phone,' .$customer->id,
            'email' => 'required|unique:customers,email,' .$customer->id,
        ]);

        $customer->update($request->all());
        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        $bookings = $customer->bookings;

        return view('backend.pages.customers.show',compact('customer','bookings'));

    }

    public function customer_account($id)
    {
        $customer = Customer::find($id);
        return view('backend.pages.customers.customer_account',compact('customer'));

    }


    public function show_order($id)
    {
        $customer=Customer::find($id);
        $orders=$customer->Orders;
        return view('backend.pages.customers.show_order',compact('orders','customer'));
    }
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if($customer->bookings->count() == 0)
        {
            $customer->delete();
            toast('تم حذف العميل بنجاح','success');
            return redirect()->back();
        }else{
            return redirect()->back()->with('error','لا يمكن حذف هذا العميل .. يوجد عقود تحت هذا العميل .. قم بحذف العقود اولاً ');
        }
    }

    

   


}
