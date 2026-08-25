<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\CustomerNotification;
use App\Mail\BookingStatusMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingObserver
{
    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking)
    {
        try {
            // إشعار عند إلغاء الحجز
            if ($booking->isDirty('status') && $booking->status == 'cancelled') {
                $chalet = $booking->chalet;
                $customer = $booking->customer;
                
                // إشعار للمالك
                if ($chalet && $chalet->owner_id) {
                    Notification::create([
                        'owner_id' => $chalet->owner_id,
                        'type' => 'booking_cancelled',
                        'title_ar' => 'إلغاء حجز',
                        'title_en' => 'Booking Cancelled',
                        'message_ar' => "قام {$customer->name} بإلغاء الحجز رقم {$booking->booking_number} للشاليه {$chalet->name}",
                        'message_en' => "{$customer->name} cancelled booking #{$booking->booking_number} for {$chalet->name_en}",
                        'data' => [
                            'booking_id' => $booking->id,
                            'booking_number' => $booking->booking_number,
                            'chalet_id' => $chalet->id,
                            'chalet_name' => $chalet->name,
                            'customer_name' => $customer->name,
                            'checkin_date' => $booking->checkin_date,
                            'checkout_date' => $booking->checkout_date,
                            'total_amount' => $booking->total_amount,
                            'cancellation_reason' => $booking->cancellation_reason ?? ''
                        ],
                        'icon_type' => 'error',
                        'is_read' => false
                    ]);
                }
                
                // إشعار للعميل
                if ($customer) {
                    $notification = CustomerNotification::create([
                        'customer_id' => $customer->id,
                        'booking_id' => $booking->id,
                        'type' => 'booking_cancelled',
                        'title_ar' => 'تم إلغاء حجزك',
                        'title_en' => 'Your Booking Has Been Cancelled',
                        'message_ar' => "تم إلغاء حجزك رقم {$booking->booking_number} للشاليه {$chalet->name}. سيتم استرداد المبلغ المدفوع خلال 3-5 أيام عمل.",
                        'message_en' => "Your booking #{$booking->booking_number} for {$chalet->name_en} has been cancelled. Refund will be processed within 3-5 business days.",
                        'data' => [
                            'booking_id' => $booking->id,
                            'booking_number' => $booking->booking_number,
                            'chalet_id' => $chalet->id,
                            'chalet_name' => $chalet->name,
                            'checkin_date' => $booking->checkin_date,
                            'checkout_date' => $booking->checkout_date,
                            'total_amount' => $booking->total_amount,
                            'cancellation_reason' => $booking->cancellation_reason ?? ''
                        ],
                        'icon_type' => 'warning',
                        'is_read' => false
                    ]);
                    
                    // إرسال إيميل
                    $this->sendStatusEmail($booking, $customer, 'cancelled', $notification);
                }
            }
            
            // إشعار عند تأكيد الحجز
            if ($booking->isDirty('status') && $booking->status == 'confirmed') {
                $chalet = $booking->chalet;
                $customer = $booking->customer;
                
                // إشعار للمالك
                if ($chalet && $chalet->owner_id) {
                    Notification::create([
                        'owner_id' => $chalet->owner_id,
                        'type' => 'booking_confirmed',
                        'title_ar' => 'تأكيد حجز',
                        'title_en' => 'Booking Confirmed',
                        'message_ar' => "تم تأكيد الحجز رقم {$booking->booking_number} للشاليه {$chalet->name}",
                        'message_en' => "Booking #{$booking->booking_number} confirmed for {$chalet->name_en}",
                        'data' => [
                            'booking_id' => $booking->id,
                            'booking_number' => $booking->booking_number,
                            'chalet_id' => $chalet->id,
                            'chalet_name' => $chalet->name,
                            'customer_name' => $customer->name,
                            'checkin_date' => $booking->checkin_date,
                            'checkout_date' => $booking->checkout_date,
                            'total_amount' => $booking->total_amount
                        ],
                        'icon_type' => 'success',
                        'is_read' => false
                    ]);
                }
                
                // إشعار للعميل
                if ($customer) {
                    $notification = CustomerNotification::create([
                        'customer_id' => $customer->id,
                        'booking_id' => $booking->id,
                        'type' => 'booking_confirmed',
                        'title_ar' => 'تم تأكيد حجزك',
                        'title_en' => 'Your Booking is Confirmed',
                        'message_ar' => "مبروك! تم تأكيد حجزك رقم {$booking->booking_number} للشاليه {$chalet->name}. نتمنى لك إقامة سعيدة.",
                        'message_en' => "Congratulations! Your booking #{$booking->booking_number} for {$chalet->name_en} is confirmed. We wish you a pleasant stay.",
                        'data' => [
                            'booking_id' => $booking->id,
                            'booking_number' => $booking->booking_number,
                            'chalet_id' => $chalet->id,
                            'chalet_name' => $chalet->name,
                            'checkin_date' => $booking->checkin_date,
                            'checkout_date' => $booking->checkout_date,
                            'checkin_time' => $booking->checkin_time,
                            'checkout_time' => $booking->checkout_time,
                            'total_amount' => $booking->total_amount
                        ],
                        'icon_type' => 'success',
                        'is_read' => false
                    ]);
                    
                    // إرسال إيميل
                    $this->sendStatusEmail($booking, $customer, 'confirmed', $notification);
                }
            }
            
            // إشعار عند رفض الحجز
            if ($booking->isDirty('status') && $booking->status == 'rejected') {
                $chalet = $booking->chalet;
                $customer = $booking->customer;
                
                // إشعار للمالك
                if ($chalet && $chalet->owner_id) {
                    Notification::create([
                        'owner_id' => $chalet->owner_id,
                        'type' => 'booking_rejected',
                        'title_ar' => 'رفض حجز',
                        'title_en' => 'Booking Rejected',
                        'message_ar' => "تم رفض الحجز رقم {$booking->booking_number} للشاليه {$chalet->name}",
                        'message_en' => "Booking #{$booking->booking_number} rejected for {$chalet->name_en}",
                        'data' => [
                            'booking_id' => $booking->id,
                            'booking_number' => $booking->booking_number,
                            'chalet_id' => $chalet->id,
                            'chalet_name' => $chalet->name,
                            'customer_name' => $customer->name,
                            'checkin_date' => $booking->checkin_date,
                            'checkout_date' => $booking->checkout_date
                        ],
                        'icon_type' => 'error',
                        'is_read' => false
                    ]);
                }
                
                // إشعار للعميل
                if ($customer) {
                    $notification = CustomerNotification::create([
                        'customer_id' => $customer->id,
                        'booking_id' => $booking->id,
                        'type' => 'booking_rejected',
                        'title_ar' => 'تم رفض حجزك',
                        'title_en' => 'Your Booking Has Been Rejected',
                        'message_ar' => "نأسف لإبلاغك أن حجزك رقم {$booking->booking_number} للشاليه {$chalet->name} قد تم رفضه. يمكنك البحث عن شاليهات أخرى متاحة.",
                        'message_en' => "We regret to inform you that your booking #{$booking->booking_number} for {$chalet->name_en} has been rejected. You can search for other available chalets.",
                        'data' => [
                            'booking_id' => $booking->id,
                            'booking_number' => $booking->booking_number,
                            'chalet_id' => $chalet->id,
                            'chalet_name' => $chalet->name,
                            'rejection_reason' => $booking->rejection_reason ?? ''
                        ],
                        'icon_type' => 'error',
                        'is_read' => false
                    ]);
                    
                    // إرسال إيميل
                    $this->sendStatusEmail($booking, $customer, 'rejected', $notification);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to create booking update notification: ' . $e->getMessage());
        }
    }
    
    /**
     * Send email notification to customer
     */
    private function sendStatusEmail($booking, $customer, $status, $notification)
    {
        try {
            if ($customer->email) {
                Mail::to($customer->email)->send(new BookingStatusMail($booking, $status, $notification));
                $notification->update(['email_sent' => true]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send booking status email: ' . $e->getMessage());
        }
    }
}
