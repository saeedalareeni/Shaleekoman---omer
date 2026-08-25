<?php

namespace App\Http\Controllers;

use App\Exports\ReportsOwnersExpensesExport;
use App\Models\OwnersExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OwnersExpenseController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('query');
        $owners_expenses = OwnersExpense::query()
            ->where('about', 'LIKE', "%{$search}%")

            ->orWhereHas('Owner', function ($query)use ($search){
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            })

            ->orderBy('id', 'desc')->paginate(10);

        return view('backend.pages.owners_expenses.index', compact('owners_expenses'));
    }





    public function store(Request $request)
    {
        $request->validate([
            'payment_method_id'         => 'required|string',
            'owner_id'                  => 'nullable|string',
            'check_number'              => 'nullable|string',
            'amount'                    => 'required|numeric',
            'expense_date'              => 'required|date',
            'about'                     => 'nullable|string',
            'notes'                     => 'nullable|string',
            'image'                     => 'nullable|max:5048',
        ]);

        if ($image = $request->file('image')){
            $path = 'images/expenses/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $path.$filename;
        }
        $data['user_id'] = Auth::id();
        $data['owner_id'] = $request->input('owner_id');
        $data['payment_method_id'] = $request->input('payment_method_id');
        $data['amount'] = $request->input('amount');

        $data['expense_date'] = $request->input('expense_date');
        $data['check_number'] = $request->input('check_number');
        $data['about'] = $request->input('about');
        $data['notes'] = $request->input('notes');

        $ownersExpense=OwnersExpense::create($data);


        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }

    public function show($id)
    {
        $owners_expense = OwnersExpense::find($id);
        return view('backend2.pages.owners_expenses.show', compact('owners_expense'));
    }

   

    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_method_id'         => 'required|string',
            'owner_id'                  => 'nullable|string',
            'check_number'              => 'nullable|string',
            'amount'                    => 'required|numeric',
            'expense_date'              => 'required|date',
            'about'                     => 'nullable|string',
            'notes'                     => 'nullable|string',
            'image'                     => 'nullable|max:5048',
        ]);

        $ownersExpense = OwnersExpense::find($id);

        if ($image = $request->file('image')){
            $path = 'images/expenses/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $path.$filename;
        }

        $data['user_id'] = Auth::id();
        $data['owner_id'] = $request->input('owner_id');
        $data['payment_method_id'] = $request->input('payment_method_id');

        $data['amount'] = $request->input('amount');
        $data['expense_date'] = $request->input('expense_date');
        $data['check_number'] = $request->input('check_number');
        $data['about'] = $request->input('about');
        $data['notes'] = $request->input('notes');

        $ownersExpense->update($data);


        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $owners_expense = OwnersExpense::find($id);
        $owners_expense->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }



}
