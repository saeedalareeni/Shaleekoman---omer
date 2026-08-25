<?php

namespace App\Http\Controllers;

use App\Exports\FilterOrderByChaletExcel;
use App\Mail\Notify;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class BookingCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query()->with(['chalet', 'chalet.owner', 'dates', 'PaymentMethod']);
        
        // Search filter
        if ($request->filled('query')) {
            $search = $request->query;
            $query->where(function($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Chalet filter
        if ($request->filled('chalet_id')) {
            $query->where('chalet_id', $request->chalet_id);
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }
        
        $bookings = $query->orderBy('id', 'desc')->paginate(10);
        
        return view('backend.pages.bookingCustomers.index', compact('bookings'));
    }


    public function search_booking(Request $request)
    {
        $search = $request->input('query');
        $orders = Booking::query()
            ->where('booking_number', 'LIKE', "%{$search}%")
            ->OrWhere('name', 'LIKE', "%{$search}%")
            ->OrWhere('phone_number', 'LIKE', "%{$search}%")
            ->orderBy('id', 'desc')->paginate();
        return view('backend.pages.bookingCustomers.index', compact('orders'));
    }



    public function search_booking_between_date(Request $request)
    {
        $start_date = $request->start_date ? Carbon::parse($request->start_date)->format('Y-m-d') : null;
        $end_date = $request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d') : null;
        $query = $request->input('query');

        $orders = Booking::with('chalet') // علشان نجيب اسم الشالية من العلاقة
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereDate('created_at', '>=', $start_date)
                  ->whereDate('created_at', '<=', $end_date);
            })
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q) use ($query) {
                    $q->where('booking_number', 'like', "%{$query}%") // رقم الحجز
                      ->orWhere('customer_name', 'like', "%{$query}%") // اسم العميل
                      ->orWhere('phone_number', 'like', "%{$query}%") // رقم العميل
                      ->orWhereHas('chalet', function ($q) use ($query) {
                          $q->where('chalet_name_ar', 'like', "%{$query}%");
                          $q->orwhere('chalet_name_en', 'like', "%{$query}%");
                      });
                });
            })
            ->orderBy('created_at', 'asc')
            ->paginate(25);

        return view('backend.pages.bookingCustomers.index', compact('orders', 'start_date', 'end_date', 'query'));
    }




    // فلتر الطلبات
    public function filter_booking_by_chalet(Request $request)
    {
        if($request->chalet_id == 0)
        {
            $orders = Booking::orderBy('id', 'desc')->paginate(25);
            return view('backend.pages.bookingCustomers.index', compact('orders'));
        }
        else
        {
            $orders = Booking::where('chalet_id', $request->chalet_id)->orderBy('id', 'desc')->paginate(25);
            return view('backend.pages.bookingCustomers.index', compact('orders'));
        }
    }


    // تصدير الطلبات حسب الشاليهات اكسيل
    public function filter_booking_by_chalet_excel(Request $request)
    {
        $chalet_id = $request->chalet_id;
        return Excel::download(new FilterOrderByChaletExcel($chalet_id), 'bookins.xlsx');
    }



    public function show($slug)
    {
        $booking = Booking::where('slug',$slug)->first();
        return view('frontend.pages.invoice', compact('booking'));
    }

    public function updateStatus(Booking $booking, $status)
    {
        if (!in_array($status, ['APPROVED', 'REJECTED', 'CANCELED'])) {
            toast('لم يتم العثور على الحالة!', 'error');
            return back();
        }

        $booking->status = $status;
        $booking->save();
        toast('تم تحديث الحالة بنجاح', 'success');
        return back();
    }

    public function exportExcel(Request $request)
    {
        $bookings = $this->getFilteredBookings($request);
        
        $filename = 'bookings_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            
            // Header row
            fputcsv($file, [
                'الرقم',
                'رقم الحجز',
                'الشاليه',
                'المالك',
                'اسم العميل',
                'الهاتف',
                'البريد الإلكتروني',
                'تاريخ الدخول',
                'تاريخ الخروج',
                'عدد الليالي',
                'المبلغ الإجمالي',
                'المبلغ المدفوع',
                'المتبقي',
                'الحالة',
                'طريقة الدفع',
                'تاريخ الحجز'
            ]);
            
            // Data rows
            foreach ($bookings as $index => $booking) {
                fputcsv($file, [
                    $index + 1,
                    $booking->booking_number,
                    $booking->chalet ? (app()->getLocale() == 'ar' ? $booking->chalet->chalet_name_ar : $booking->chalet->chalet_name_en) : '',
                    $booking->chalet && $booking->chalet->owner ? $booking->chalet->owner->name : '',
                    $booking->customer_name ?? '',
                    $booking->country . $booking->phone_number,
                    $booking->email ?? '',
                    $booking->checkin_date ?? '',
                    $booking->checkout_date ?? '',
                    $booking->dates ? $booking->dates->count() : 0,
                    number_format($booking->total_amount ?? 0, 2),
                    number_format($booking->payment_amount ?? 0, 2),
                    number_format(($booking->total_amount - $booking->payment_amount), 2),
                    $booking->status,
                    $booking->payment_method ?? '',
                    $booking->created_at->format('Y-m-d')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportPDF(Request $request)
    {
        $bookings = $this->getFilteredBookings($request);
        $setting = \App\Models\Setting::first();
        
        $totalBookings = $bookings->count();
        $confirmedBookings = $bookings->where('status', 'confirmed')->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $totalRevenue = $bookings->sum('total_amount');
        
        $html = view('backend.pages.bookingCustomers.pdf', compact('bookings', 'setting', 'totalBookings', 'confirmedBookings', 'pendingBookings', 'totalRevenue'))->render();
        
        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Content-Disposition', 'inline; filename="bookings_' . date('Y-m-d') . '.html"');
    }
    
    private function getFilteredBookings(Request $request)
    {
        $query = Booking::query()->with(['chalet', 'chalet.owner', 'dates', 'PaymentMethod']);
        
        // Apply same filters as index method
        if ($request->filled('query')) {
            $search = $request->query;
            $query->where(function($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('chalet_id')) {
            $query->where('chalet_id', $request->chalet_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }
        
        return $query->orderBy('id', 'desc')->get();
    }

    public function cancelBooking($booking_number, Request $request)
    {
        $booking = Booking::where('booking_number', $booking_number)->firstOrFail();       
        if ($booking->status === 'canceled') {
            return back()->with('error', 'تم إلغاء هذا الحجز مسبقًا.');
        }       

        $booking->dates()->delete();
        $booking->update([
            'status' => 'canceled',
        ]);       

        try {
            $data = [
                'title' => 'مرحباً ' . $booking->customer_name,
                'message' => 'نود إعلامك بأنه تم إلغاء حجزك رقم ' . $booking->booking_number . "\n\n" .$request->notes
            ];           
            Mail::to($booking->email)->send(new Notify($data,'إلغاء حجزك'));
        } catch (\Exception $e) {
            Log::error('فشل إرسال بريد إلغاء الحجز: ' . $e->getMessage());
        }
        toast('تم إلغاء الحجز بنجاح.', 'success');
        return redirect()->back();
    }
    public function destroy(Booking $booking)
    {
        $booking->dates()->delete();
        $booking->delete();
        toast('تم  الحذف بنجاح', 'success');
        return back();
    }
}