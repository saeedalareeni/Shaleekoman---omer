<?php


namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Chalet;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $owner_id = Auth::id();
        
        // عدد الشاليهات
        $chalets_count = Chalet::where('owner_id', $owner_id)->count();
        
        // عدد الحجوزات
        $bookings_count = Booking::whereHas('chalet', function ($query) use ($owner_id) {
            $query->where('owner_id', $owner_id);
        })->count();
        
        // إجمالي الإيرادات
        $total_revenue = Booking::whereHas('chalet', function ($query) use ($owner_id) {
            $query->where('owner_id', $owner_id);
        })->where('status', 'confirmed')->sum('total_amount');
        
        // عدد المشاهدات من جدول views
        $chalet_ids = Chalet::where('owner_id', $owner_id)->pluck('id');
        $total_views = \App\Models\View::whereIn('chalet_id', $chalet_ids)->count();
        
        // إجمالي الزوار (عدد الحجوزات الفريدة)
        $total_visitors = Booking::whereHas('chalet', function ($query) use ($owner_id) {
            $query->where('owner_id', $owner_id);
        })->distinct('user_id')->count('user_id');
        
        // أفضل الشاليهات (آخر 4 شاليهات)
        $chalets = Chalet::where('owner_id', $owner_id)
            ->with(['images', 'views'])
            ->latest()
            ->take(4)
            ->get();
        
        // الإشعارات الأخيرة
        $notifications = Notification::where('owner_id', $owner_id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // عدد الإشعارات غير المقروءة
        $unread_notifications_count = Notification::where('owner_id', $owner_id)
            ->where('is_read', false)
            ->count();
        
        // بيانات الرسم البياني - الحجوزات والإيرادات لكل شهر
        $current_year = date('Y');
        $monthly_bookings = [];
        $monthly_revenue = [];
        
        for ($month = 1; $month <= 12; $month++) {
            // عدد الحجوزات لكل شهر
            $monthly_bookings[] = Booking::whereHas('chalet', function ($query) use ($owner_id) {
                $query->where('owner_id', $owner_id);
            })->whereYear('created_at', $current_year)
              ->whereMonth('created_at', $month)
              ->count();
            
            // الإيرادات لكل شهر
            $revenue = Booking::whereHas('chalet', function ($query) use ($owner_id) {
                $query->where('owner_id', $owner_id);
            })->whereYear('created_at', $current_year)
              ->whereMonth('created_at', $month)
              ->where('status', 'confirmed')
              ->sum('total_amount');
            $monthly_revenue[] = (float) $revenue;
        }
        
        return view('owners.dashboard', compact(
            'chalets_count',
            'bookings_count',
            'total_revenue',
            'total_views',
            'total_visitors',
            'chalets',
            'monthly_bookings',
            'monthly_revenue',
            'notifications',
            'unread_notifications_count'
        ));
    }

}
