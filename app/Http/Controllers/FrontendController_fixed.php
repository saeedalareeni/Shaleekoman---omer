<?php

namespace App\Http\Controllers;

use App\Mail\Notify;
use App\Models\About;
use App\Models\Area;
use App\Models\Banner;
use App\Models\BookingDate;
use App\Models\Category;
use App\Models\Chalet;
use App\Models\ChaletPrice;
use App\Models\City;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\CustomerMessage;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Notification;

class FrontendController extends Controller
{
    // ... [keeping existing methods] ...

    public function send_messages(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric', 
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $data = $request->all();
        
        // Create the message
        $customerMessage = CustomerMessage::create($data);
        
        // Send notification to all admins
        $this->notifyAdminsAboutNewMessage($customerMessage);
        
        // Send email notification
        try {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new \App\Mail\NewContactMessage($customerMessage));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send contact message email: ' . $e->getMessage());
        }
        
        // Flash success message
        session()->flash('success', app()->getLocale() == 'ar' ? 
            'شكراً لتواصلك معنا! تم إرسال رسالتك بنجاح وسنقوم بالرد عليك في أقرب وقت ممكن.' : 
            'Thank you for contacting us! Your message has been sent successfully and we will reply to you as soon as possible.');
        
        return redirect()->back();
    }
    
    private function notifyAdminsAboutNewMessage($message)
    {
        // Get all admins
        $admins = User::where('role', 'admin')->orWhere('is_admin', 1)->get();
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'contact_message',
                'title_ar' => 'رسالة جديدة من نموذج الاتصال',
                'title_en' => 'New Contact Form Message',
                'message_ar' => 'رسالة جديدة من: ' . $message->name . ' - الموضوع: ' . $message->subject,
                'message_en' => 'New message from: ' . $message->name . ' - Subject: ' . $message->subject,
                'url' => route('customer-messages.index'),
                'icon' => 'fas fa-envelope',
                'color' => 'info',
                'data' => json_encode([
                    'message_id' => $message->id,
                    'sender_name' => $message->name,
                    'sender_email' => $message->email,
                    'subject' => $message->subject
                ])
            ]);
        }
    }
    
    // ... [rest of the methods] ...
}
