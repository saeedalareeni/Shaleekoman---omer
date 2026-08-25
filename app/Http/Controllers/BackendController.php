<?php

namespace App\Http\Controllers;

use App\Models\HR\Allowance;
use App\Models\Car;
use App\Models\CarsContract;
use App\Models\Customer;
use App\Models\HR\Discount;
use App\Models\HR\Holiday;
use App\Models\HR\Message;
use App\Models\HR\Salary;
use App\Models\Setting;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{

    public function index(Request $request)
    {
        return view('backend.dashboard');
    }



    public function show_notification_all()
    {
        // Get all admin notifications (where owner_id is null)
        $notifications = Notification::whereNull('owner_id')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('backend.show_notification_all', compact('notifications'));
    }




    // مسح جميع الإشعارات
    public function markAsRead_all(Request $request)
    {
        // Mark all admin notifications as read
        Notification::whereNull('owner_id')
            ->where('is_read', 0)
            ->update(['is_read' => 1, 'read_at' => now()]);
            
        toast('تم تحديد جميع الإشعارات كمقروءة بنجاح','success');
        return redirect()->back();
    }


    // مسح إشعار واحد فقط
    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->update(['is_read' => 1, 'read_at' => now()]);
            toast('تم تحديد الإشعار كمقروء بنجاح','success');
        }
        return redirect()->back();
    }
    
    // Test notifications page
    public function testNotifications()
    {
        return view('backend.test_notifications');
    }
    
    // Create test notification
    public function createTestNotification()
    {
        Notification::create([
            'owner_id' => null,
            'type' => 'test',
            'title_ar' => 'إشعار تجريبي - ' . now()->format('H:i:s'),
            'title_en' => 'Test Notification - ' . now()->format('H:i:s'),
            'message_ar' => 'هذا إشعار تجريبي تم إنشاؤه في ' . now()->format('Y-m-d H:i:s'),
            'message_en' => 'This is a test notification created at ' . now()->format('Y-m-d H:i:s'),
            'icon' => 'fas fa-bell',
            'color' => 'info',
            'url' => '/test',
            'is_read' => 0
        ]);
        
        toast('تم إنشاء إشعار تجريبي بنجاح', 'success');
        return redirect()->back();
    }



}
