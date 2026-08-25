<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth('owner')->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('owners.notifications.index', compact('notifications'));
    }

    public function getUnread()
    {
        $notifications = auth('owner')->user()->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $unreadCount = auth('owner')->user()->unread_notifications_count;
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        // التحقق من أن الإشعار يخص المالك الحالي
        if ($notification->owner_id !== auth('owner')->id()) {
            abort(403);
        }
        
        $notification->markAsRead();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'تم تحديد الإشعار كمقروء');
    }

    public function markAllAsRead()
    {
        auth('owner')->user()->unreadNotifications()->update([
            'is_read' => true,
            'read_at' => now()
        ]);
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة');
    }

    public function destroy(Notification $notification)
    {
        // التحقق من أن الإشعار يخص المالك الحالي
        if ($notification->owner_id !== auth('owner')->id()) {
            abort(403);
        }
        
        $notification->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'تم حذف الإشعار بنجاح');
    }

    public function clearAll()
    {
        auth('owner')->user()->notifications()->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'تم حذف جميع الإشعارات');
    }
}
