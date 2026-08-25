<?php

namespace App\Http\Controllers;

use App\Models\CustomerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerNotificationController extends Controller
{
    /**
     * Display a listing of notifications
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        $notifications = CustomerNotification::where('customer_id', $customer->id)
            ->recent()
            ->paginate(15);
            
        // Mark notifications as read when viewed
        CustomerNotification::where('customer_id', $customer->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
            
        return view('frontend.notifications.index', compact('notifications'));
    }
    
    /**
     * Get unread notifications count
     */
    public function unreadCount()
    {
        $customer = Auth::guard('customer')->user();
        
        $count = CustomerNotification::where('customer_id', $customer->id)
            ->unread()
            ->count();
            
        return response()->json(['count' => $count]);
    }
    
    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $customer = Auth::guard('customer')->user();
        
        $notification = CustomerNotification::where('customer_id', $customer->id)
            ->where('id', $id)
            ->first();
            
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
    
    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        CustomerNotification::where('customer_id', $customer->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
        
        // Check if request wants JSON response
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => __('تم تحديد جميع الإشعارات كمقروءة')]);
        }
            
        return back()->with('success', __('تم تحديد جميع الإشعارات كمقروءة'));
    }
    
    /**
     * Delete a notification
     */
    public function destroy(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();
        
        $notification = CustomerNotification::where('customer_id', $customer->id)
            ->where('id', $id)
            ->first();
            
        if ($notification) {
            $notification->delete();
            
            // Check if request wants JSON response
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'message' => __('تم حذف الإشعار بنجاح')]);
            }
            
            return back()->with('success', __('تم حذف الإشعار بنجاح'));
        }
        
        // Check if request wants JSON response
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => __('لم يتم العثور على الإشعار')], 404);
        }
        
        return back()->with('error', __('لم يتم العثور على الإشعار'));
    }
    
    /**
     * Get recent notifications for dropdown
     */
    public function recent()
    {
        $customer = Auth::guard('customer')->user();
        
        $notifications = CustomerNotification::where('customer_id', $customer->id)
            ->recent()
            ->limit(5)
            ->get();
            
        return response()->json($notifications);
    }
}
