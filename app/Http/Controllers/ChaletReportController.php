<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerMessage;

class ChaletReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required',
        ]);

        // عنوان البلاغ (اسم الزر)
        $subject = 'الإبلاغ عن مخالفة عقارية';

        // نص الرسالة
        $message  = "العنوان: {$subject}\n";
        $message .= "بلاغ على شاليه رقم #{$request->chalet_id}\n";
        $message .= "السبب: {$request->reason}\n";

        if ($request->other_reason) {
            $message .= "تفاصيل إضافية: {$request->other_reason}\n";
        }

        CustomerMessage::create([
    'name'   => auth()->check() ? auth()->user()->name : 'زائر',
    'phone'  => auth()->check() ? auth()->user()->phone : '000000000',
    'email'  => auth()->check() ? auth()->user()->email : 'no-email@wkndoman.com',
    'subject'=> 'الإبلاغ عن مخالفة عقارية', // <-- هنا
    'message'=> $message,
    'is_read'    => 0,
    'is_replied' => 0,
]);

        return back()->with('success', 'تم إرسال البلاغ بنجاح');
    }
}
