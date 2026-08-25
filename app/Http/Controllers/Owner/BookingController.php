<?php

namespace App\Http\Controllers\Owner;
use App\Exports\FilterOrderByChaletExcel;

use App\Http\Controllers\Controller;
use App\Mail\Notify;
use App\Mail\PaymentConfirmationMail;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::whereHas('chalet', function ($query) {
            $query->where('owner_id', auth()->user()->id);
        })
        ->latest('id')  // ترتيب النتائج بحسب تاريخ الحجز
        ->paginate();

        return view('owners.pages.bookings.index', compact('bookings'));
    }



    public function search_booking(Request $request)
{
    $search = $request->input('query');
    $bookings = Booking::query()
        ->whereHas('chalet', function($query) {
            $query->where('owner_id', auth()->user()->id);  // التأكد من أن الشاليه يخص المالك الحالي
        })
        ->where(function($query) use ($search) {
            $query->where('booking_number', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('phone_number', 'LIKE', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate();

    return view('owners.pages.bookings.index', compact('bookings'));
}



public function search_booking_between_date(Request $request)
{
    $start_date = $request->start_date ? Carbon::parse($request->start_date)->format('Y-m-d') : null;
    $end_date = $request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d') : null;
    $query = $request->input('query');

    $bookings = Booking::whereHas('chalet', function($query) {
        $query->where('owner_id', auth()->user()->id); 
    })->with(['chalet', 'dates', 'PaymentMethod'])
        ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
            $q->whereDate('created_at', '>=', $start_date)
              ->whereDate('created_at', '<=', $end_date);
        })
        ->when($query, function ($q) use ($query) {
            $q->where(function ($q) use ($query) {
                $q->where('booking_number', 'like', "%{$query}%")
                  ->orWhere('customer_name', 'like', "%{$query}%") 
                  ->orWhere('phone_number', 'like', "%{$query}%") 
                  ->orWhereHas('chalet', function ($q) use ($query) {
                      $q->where('chalet_name_ar', 'like', "%{$query}%");
                      $q->orwhere('chalet_name_en', 'like', "%{$query}%");
                  });
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    // إذا كان طلب AJAX، نرجع جزء من الصفحة فقط
    if ($request->ajax()) {
        return view('owners.partials.bookings-data', compact('bookings'));
    }

    // للطلبات العادية، نرجع إلى تاب الحجوزات في لوحة التحكم
    return redirect()->route('owner.dashboard')->with('active_tab', 'bookings');
}





    public function filter_booking_by_chalet(Request $request)
{
    if ($request->chalet_id == 0) {
        $bookings = Booking::whereHas('chalet', function($query) {
            $query->where('owner_id', auth()->user()->id);
        })
        ->with(['chalet', 'dates', 'PaymentMethod'])
        ->orderBy('id', 'desc')
        ->paginate(15);
    } else {
        $bookings = Booking::whereHas('chalet', function($query) use ($request) {
            $query->where('owner_id', auth()->user()->id);
        })
        ->where('chalet_id', $request->chalet_id)
        ->with(['chalet', 'dates', 'PaymentMethod'])
        ->orderBy('id', 'desc')
        ->paginate(15);
    }

    // إذا كان طلب AJAX، نرجع جزء من الصفحة فقط
    if ($request->ajax()) {
        return view('owners.partials.bookings-data', compact('bookings'));
    }

    // للطلبات العادية، نرجع إلى تاب الحجوزات في لوحة التحكم
    return redirect()->route('owner.dashboard')->with('active_tab', 'bookings');
}


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

    public function confirmPayment($booking_number)
    {
        try {
            $booking = Booking::where('booking_number', $booking_number)->first();
            
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'الحجز غير موجود'
                ], 404);
            }
        
        // التحقق من أن الحجز يخص المالك الحالي
        if ($booking->chalet->owner_id != auth()->guard('owner')->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بتعديل هذا الحجز'
            ], 403);
        }
        
        // التحقق من أن طريقة الدفع هي نقدي أو تحويل بنكي
        if (!in_array($booking->payment_method, ['cash', 'bank_transfer'])) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن تأكيد الدفع لهذه الطريقة'
            ], 400);
        }
        
        // تحديث حالة الدفع وحقول المبالغ
        $booking->payment_status = 'paid';
        $booking->payment_amount = $booking->total_amount; // المبلغ المدفوع = المبلغ الإجمالي
        // لا نحتاج rest_amount لأنه غير موجود في قاعدة البيانات
        $booking->save();
        
        // إرسال إشعار للعميل
        if ($booking->customer_id) {
            \App\Models\CustomerNotification::create([
                'customer_id' => $booking->customer_id,
                'booking_id' => $booking->id,
                'type' => 'payment_confirmed',
                'title_ar' => 'تأكيد الدفع',
                'title_en' => 'Payment Confirmed',
                'message_ar' => 'تم تأكيد دفع مبلغ ' . number_format($booking->total_amount, 2) . ' ر.ع للحجز رقم ' . $booking->booking_number,
                'message_en' => 'Payment of ' . number_format($booking->total_amount, 2) . ' OMR has been confirmed for booking #' . $booking->booking_number,
                'icon_type' => 'success',
                'is_read' => false,
                'data' => json_encode([
                    'booking_number' => $booking->booking_number,
                    'amount_paid' => $booking->total_amount,
                    'payment_method' => $booking->payment_method,
                    'chalet_name' => $booking->chalet->name_ar ?? $booking->chalet->name_en
                ])
            ]);
            
            // إرسال إيميل تأكيد الدفع
            try {
                if ($booking->customer && $booking->customer->email) {
                    Mail::to($booking->customer->email)->send(new PaymentConfirmationMail($booking));
                }
            } catch (\Exception $e) {
                // تسجيل الخطأ ولكن لا نوقف العملية
                \Log::error('Failed to send payment confirmation email: ' . $e->getMessage());
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'تم تأكيد الدفع بنجاح وإرسال إشعار للعميل',
            'data' => [
                'payment_amount' => number_format($booking->payment_amount, 2),
                'total_amount' => number_format($booking->total_amount, 2),
                'payment_status_ar' => 'مدفوع',
                'payment_status_en' => 'paid'
            ]
        ]);
        
        } catch (\Exception $e) {
            \Log::error('Error in confirmPayment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تأكيد الدفع: ' . $e->getMessage()
            ], 500);
        }
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
    
    public function destroy($booking_number)
    {
        $booking = Booking::where('booking_number', $booking_number)->first();
        if (!$booking) {
            toast('لم يتم العثور على الحجز', 'error');
            return back();
        }
        $booking->delete();
        toast('تم  الحذف بنجاح', 'success');
        return back();
    }
    
    public function changeStatus(Request $request, $booking_number)
    {
        $request->validate([
            'status' => 'required|in:new,pending,confirmed,cancelled,rejected'
        ]);
        
        $booking = Booking::where('booking_number', $booking_number)
            ->whereHas('chalet', function($q) {
                $q->where('owner_id', auth()->id());
            })
            ->first();
            
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على الحجز'
            ], 404);
        }
        
        $oldStatus = $booking->status;
        $booking->status = $request->status;
        $booking->save();
        
        // إرسال إشعار للعميل إذا تغيرت الحالة
        if ($oldStatus != $request->status && $booking->email) {
            try {
                $statusMessages = [
                    'confirmed' => 'تم تأكيد حجزك',
                    'pending' => 'حجزك قيد المراجعة',
                    'cancelled' => 'تم إلغاء حجزك',
                    'rejected' => 'تم رفض حجزك'
                ];
                
                $data = [
                    'title' => 'مرحباً ' . $booking->customer_name,
                    'message' => $statusMessages[$request->status] ?? 'تم تحديث حالة حجزك' . ' رقم ' . $booking->booking_number
                ];
                
                Mail::to($booking->email)->send(new Notify($data, 'تحديث حالة الحجز'));
            } catch (\Exception $e) {
                Log::error('فشل إرسال بريد تحديث الحالة: ' . $e->getMessage());
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث حالة الحجز بنجاح',
            'new_status' => $request->status
        ]);
    }
   
}
