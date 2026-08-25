<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class OwnerExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::where('owner_id', Auth::id())
            ->orderBy('expense_date', 'desc')
            ->paginate(20);
            
        return view('owners.expenses.index', compact('expenses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'about' => 'required|string|max:255',
            'expense_date' => 'required|date',
        ]);

        $expense = new Expense();
        $expense->owner_id = Auth::id();
        $expense->amount = $request->amount;
        $expense->about = $request->about;
        $expense->expense_date = $request->expense_date;
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/expenses'), $imageName);
            $expense->image = 'uploads/expenses/' . $imageName;
        }
        
        $expense->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة المصروف بنجاح',
                'expense' => $expense
            ]);
        }

        return redirect()->back()->with('success', 'تم إضافة المصروف بنجاح');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::where('owner_id', Auth::id())->findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'about' => 'required|string|max:255',
            'expense_date' => 'required|date',
        ]);

        $expense->amount = $request->amount;
        $expense->about = $request->about;
        $expense->expense_date = $request->expense_date;
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($expense->image && file_exists(public_path($expense->image))) {
                unlink(public_path($expense->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/expenses'), $imageName);
            $expense->image = 'uploads/expenses/' . $imageName;
        }
        
        $expense->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث المصروف بنجاح',
                'expense' => $expense
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث المصروف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $expense = Expense::where('owner_id', Auth::id())->findOrFail($id);
        
        // Delete image if exists
        if ($expense->image && file_exists(public_path($expense->image))) {
            unlink(public_path($expense->image));
        }
        
        $expense->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم حذف المصروف بنجاح'
            ]);
        }

        return redirect()->back()->with('success', 'تم حذف المصروف بنجاح');
    }
}
