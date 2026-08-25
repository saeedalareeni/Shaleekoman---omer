<?php

namespace App\Observers;

use App\Models\Review;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     */
    public function created(Review $review)
    {
        try {
            // جلب معلومات الشاليه والمالك
            $chalet = $review->chalet;
            $customer = $review->customer;
            
            if ($chalet && $chalet->owner_id) {
                // إنشاء إشعار للمالك
                $notification = Notification::create([
                    'owner_id' => $chalet->owner_id,
                    'type' => 'review',
                    'title_ar' => 'تقييم جديد',
                    'title_en' => 'New Review',
                    'message_ar' => "قام {$customer->name} بتقييم {$chalet->name} بـ {$review->rating} نجوم",
                    'message_en' => "{$customer->name} rated {$chalet->name_en} with {$review->rating} stars",
                    'data' => [
                        'review_id' => $review->id,
                        'chalet_id' => $chalet->id,
                        'chalet_name' => $chalet->name,
                        'customer_name' => $customer->name,
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at->format('Y-m-d H:i:s')
                    ],
                    'icon_type' => 'warning', // للون الأصفر (تقييم)
                    'is_read' => false
                ]);
                
                Log::info('Review notification created', [
                    'notification_id' => $notification->id,
                    'owner_id' => $chalet->owner_id,
                    'review_id' => $review->id
                ]);
                
                // يمكن إضافة إرسال بريد إلكتروني هنا إذا لزم الأمر
            }
        } catch (\Exception $e) {
            Log::error('Failed to create review notification: ' . $e->getMessage());
        }
    }
}
