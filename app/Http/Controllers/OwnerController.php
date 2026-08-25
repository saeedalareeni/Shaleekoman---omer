<?php

namespace App\Http\Controllers;


use App\Models\Owner;
use App\Models\ownersExpense;
use App\Models\State;
use App\Models\StateContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{

    public function index(Request $request)
    {
        $query = Owner::query()->with(['chalets', 'expenses']);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', 0);
            }
        }
        
        // Period filter
        if ($request->filled('period')) {
            if ($request->period == 'today') {
                $query->whereDate('created_at', today());
            } elseif ($request->period == 'week') {
                $query->where('created_at', '>=', now()->subWeek());
            } elseif ($request->period == 'month') {
                $query->where('created_at', '>=', now()->subMonth());
            }
        }
        
        // Chalets count filter
        if ($request->filled('chalets')) {
            if ($request->chalets == '0') {
                $query->has('chalets', '=', 0);
            } elseif ($request->chalets == '1-5') {
                $query->has('chalets', '>=', 1)->has('chalets', '<=', 5);
            } elseif ($request->chalets == '5+') {
                $query->has('chalets', '>', 5);
            }
        }
        
        // URL filter parameter
        if ($request->filled('filter')) {
            if ($request->filter == 'new') {
                $query->where('created_at', '>=', now()->subDays(7));
            } elseif ($request->filter == 'inactive') {
                $query->where('is_active', 0);
            }
        }
        
        $owners = $query->orderBy('id', 'desc')->paginate(10);

        return view('backend.pages.owners.index', compact('owners'));
    }
    
    public function create()
    {
        return view('backend.pages.owners.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string',
            'phone'             => 'required|unique:owners,phone',
            'email'             => 'nullable|string',
            'address'           => 'nullable|string',
            'address'           => 'nullable|string',
            'bank_account_name'           => 'nullable|string',
            'bank_account_number'           => 'nullable|string',
        ]);

        if ($image = $request->file('image')){
            $path = 'images/owners/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $path.$filename;
        }

        $data['name'] = $request->input('name');
        $data['bank_account_name'] = $request->input('bank_account_name');
        $data['bank_account_number'] = $request->input('bank_account_number');
        $data['phone'] = $request->input('phone');
        $data['email'] = $request->input('email');
        $data['address'] = $request->input('address');
        $data['commission'] = $request->input('commission');
        $data['password'] = Hash::make($request->input('password'));
        Owner::create($data);

        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }


    public function show($id)
    {
        $owner = Owner::findOrFail($id);
        $bookings = $owner->chalets()->with('bookings')->get()->pluck('bookings')->flatten();
        $totalAmount = $bookings->sum('total_amount');
        $commissionPercentage = $owner->commission;
        $totalCommission = ($totalAmount * $commissionPercentage) / 100;
        return view('backend.pages.owners.show', compact('owner','bookings','totalAmount','totalCommission'));
    }


    public function update(Request $request,$id)
    {
        $owner = Owner::find($id);

        $request->validate([
            'name'              => 'required|string',
            'phone'             => 'required|unique:owners,phone,' .$owner->id,
            'email'             => 'nullable|string',
            'address'           => 'nullable|string',
            'bank_account_name'           => 'nullable|string',
            'bank_account_number'           => 'nullable|string',
        ]);

        $data['name'] = $request->input('name');
        $data['bank_account_name'] = $request->input('bank_account_name');
        $data['bank_account_number'] = $request->input('bank_account_number');
        $data['phone'] = $request->input('phone');
        $data['email'] = $request->input('email');
        $data['address'] = $request->input('address');
        $data['commission'] = $request->input('commission');
        $data['password'] = Hash::make($request->input('password'));
        $owner->update($data);
        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $owner = Owner::find($id);

        if($owner->chalets->count() == 0)
        {
            $owner->delete();
            return redirect()->back()->with('success','تم حذف المالك بنجاح');
        }else{
            return redirect()->back()->with('error','لا يمكن حذف المالك .. يوجد تحته بنايات عقارية .. قم بحذف البنايات أولاً');
        }
    }
    
    public function toggleStatus($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->is_active = !$owner->is_active;
        $owner->save();
        
        $message = $owner->is_active ? 'تم تفعيل المالك بنجاح' : 'تم إلغاء تفعيل المالك بنجاح';
        toast($message, 'success');
        
        return redirect()->back();
    }
    
    public function exportExcel(Request $request)
    {
        $owners = $this->getFilteredOwners($request);
        
        $filename = 'owners_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($owners) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            
            // Header row
            fputcsv($file, [
                'الرقم',
                'الاسم',
                'البريد الإلكتروني',
                'الهاتف',
                'العنوان',
                'عدد الشاليهات',
                'نسبة العمولة',
                'إجمالي الحجوزات',
                'العمولة',
                'المصروفات',
                'الصافي',
                'الحالة',
                'تاريخ التسجيل'
            ]);
            
            // Data rows
            foreach ($owners as $index => $owner) {
                $bookings = $owner->chalets()->with('bookings')->get()->pluck('bookings')->flatten();
                $totalAmount = $bookings->sum('total_amount');
                $commissionPercentage = $owner->commission ?? 0;
                $totalCommission = ($totalAmount * $commissionPercentage) / 100;
                $expenses = $owner->expenses->sum('amount');
                $netAmount = ($totalAmount - $totalCommission) - $expenses;
                
                fputcsv($file, [
                    $index + 1,
                    $owner->name,
                    $owner->email ?: 'غير محدد',
                    $owner->phone,
                    $owner->address ?: 'غير محدد',
                    $owner->chalets->count(),
                    $commissionPercentage . '%',
                    number_format($totalAmount, 2),
                    number_format($totalCommission, 2),
                    number_format($expenses, 2),
                    number_format($netAmount, 2),
                    $owner->is_active ? 'نشط' : 'غير نشط',
                    $owner->created_at->format('Y-m-d')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportPDF(Request $request)
    {
        $owners = $this->getFilteredOwners($request);
        $setting = \App\Models\Setting::first();
        
        // Calculate totals
        $totalOwners = $owners->count();
        $activeOwners = $owners->where('is_active', 1)->count();
        $inactiveOwners = $owners->where('is_active', 0)->count();
        $totalChalets = $owners->sum(function($owner) {
            return $owner->chalets->count();
        });
        
        $html = view('backend.pages.owners.pdf', compact('owners', 'setting', 'totalOwners', 'activeOwners', 'inactiveOwners', 'totalChalets'))->render();
        
        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Content-Disposition', 'inline; filename="owners_' . date('Y-m-d') . '.html"');
    }
    
    private function getFilteredOwners(Request $request)
    {
        $query = Owner::query()->with(['chalets', 'expenses']);
        
        // Apply same filters as index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', 0);
            }
        }
        
        if ($request->filled('period')) {
            if ($request->period == 'today') {
                $query->whereDate('created_at', today());
            } elseif ($request->period == 'week') {
                $query->where('created_at', '>=', now()->subWeek());
            } elseif ($request->period == 'month') {
                $query->where('created_at', '>=', now()->subMonth());
            }
        }
        
        if ($request->filled('chalets')) {
            if ($request->chalets == '0') {
                $query->has('chalets', '=', 0);
            } elseif ($request->chalets == '1-5') {
                $query->has('chalets', '>=', 1)->has('chalets', '<=', 5);
            } elseif ($request->chalets == '5+') {
                $query->has('chalets', '>', 5);
            }
        }
        
        return $query->orderBy('id', 'desc')->get();
    }


}
