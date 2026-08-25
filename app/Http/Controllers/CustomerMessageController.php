<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CustomerMessage;
use Illuminate\Http\Request;

class CustomerMessageController extends Controller
{

    public function index(Request $request)
    {
        $query = CustomerMessage::query();
        
        // Filter by subject
        if ($request->has('subject') && $request->subject != '') {
            $query->where('subject', $request->subject);
        }
        
        // Filter by status
        if ($request->has('status')) {
            if ($request->status == 'unread') {
                $query->where('is_read', 0);
            } elseif ($request->status == 'read') {
                $query->where('is_read', 1);
            } elseif ($request->status == 'replied') {
                $query->where('is_replied', 1);
            }
        }
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
        
        $customer_messages = $query->orderBy('id', 'desc')->paginate(25);
        
        // Get statistics
        $stats = [
            'total' => CustomerMessage::count(),
            'unread' => CustomerMessage::where('is_read', 0)->count(),
            'replied' => CustomerMessage::where('is_replied', 1)->count(),
            'today' => CustomerMessage::whereDate('created_at', today())->count(),
        ];
        
        // Check if enhanced view exists, otherwise use default
        if (view()->exists('backend.pages.customer_messages.index-enhanced')) {
            return view('backend.pages.customer_messages.index-enhanced', compact('customer_messages', 'stats'));
        }
        
        return view('backend.pages.customer_messages.index', compact('customer_messages', 'stats'));
    }


public function show($id)
{
    $message = CustomerMessage::findOrFail($id);

    // ضع الرسالة كمقروءة
    if ($message->is_read == 0) {
        $message->update(['is_read' => 1]);
    }

    return view('backend.pages.customer_messages.show', compact('message'));
}


    public function destroy($id)
    {
        $customermessage = CustomerMessage::find($id);
        $customermessage->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids)) {
            $ids = [];
        }

        $ids = array_values(array_filter($ids, fn($v) => is_numeric($v)));

        if (count($ids) === 0) {
            toast('لم يتم تحديد أي رسائل للحذف', 'info');
            return redirect()->back();
        }

        CustomerMessage::whereIn('id', $ids)->delete();
        toast('تم حذف الرسائل المحددة بنجاح', 'success');
        return redirect()->back();
    }
    
    public function markAsRead($id)
    {
        $message = CustomerMessage::find($id);
        if ($message) {
            $message->is_read = 1;
            $message->save();
        }
        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        CustomerMessage::where('is_read', 0)->update(['is_read' => 1]);
        return response()->json(['success' => true]);
    }
    
    public function reply(Request $request, $id)
    {
        $message = CustomerMessage::find($id);
        if ($message) {
            // Send email reply
            try {
                \Mail::to($message->email)->send(new \App\Mail\ReplyToContact($request->all()));
                
                // Update message status
                $message->is_replied = 1;
                $message->reply = $request->message;
                $message->replied_at = now();
                $message->save();
                
                toast('تم إرسال الرد بنجاح', 'success');
            } catch (\Exception $e) {
                toast('فشل إرسال الرد', 'error');
            }
        }
        return redirect()->back();
    }

}
