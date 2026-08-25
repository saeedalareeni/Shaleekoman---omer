<?php


namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{

    public function index()
    {
        $owner = Owner::find(auth()->user()->id);
        $bookings = $owner->chalets()->with('bookings')->get()->pluck('bookings')->flatten();
        $totalAmount = $bookings->sum('total_amount');
        $commissionPercentage = $owner->commission;
        $totalCommission = ($totalAmount * $commissionPercentage) / 100;
        return view('owners.pages.expenses.index', compact('owner','bookings','totalAmount','totalCommission'));
    }

    /**
     * Store a newly created expense.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'about' => 'required|string|max:255',
            'expense_date' => 'required|date',
        ]);

        $expense = new Expense();
        $expense->owner_id = Auth::guard('owner')->id();
        $expense->user_id = Auth::guard('owner')->id(); // نفس ID المالك
        $expense->payment_method_id = $request->payment_method_id ?? 1; // قيمة افتراضية 1 إذا لم يتم تحديدها
        $expense->amount = $request->amount;
        $expense->about = $request->about;
        $expense->expense_date = $request->expense_date;
        $expense->notes = $request->notes;
        $expense->check_number = $request->check_number;
        
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
     * Update the specified expense.
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::where('owner_id', Auth::guard('owner')->id())->findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'about' => 'required|string|max:255',
            'expense_date' => 'required|date',
        ]);

        $expense->amount = $request->amount;
        $expense->about = $request->about;
        $expense->expense_date = $request->expense_date;
        $expense->notes = $request->notes;
        $expense->check_number = $request->check_number;
        if ($request->has('payment_method_id')) {
            $expense->payment_method_id = $request->payment_method_id;
        }
        
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
     * Remove the specified expense.
     */
    public function destroy($id)
    {
        $expense = Expense::where('owner_id', Auth::guard('owner')->id())->findOrFail($id);
        
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
