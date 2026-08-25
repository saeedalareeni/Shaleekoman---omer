<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\Owner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owners = Owner::all();
        
        foreach ($owners as $owner) {
            // إشعار حجز جديد
            Notification::create([
                'owner_id' => $owner->id,
                'type' => 'booking',
                'title_ar' => 'حجز جديد',
                'title_en' => 'New Booking',
                'message_ar' => 'تم حجز الشاليه الخاص بك - شاليه الواحة',
                'message_en' => 'Your chalet has been booked - Al Waha Chalet',
                'icon_type' => 'success',
                'is_read' => false,
                'data' => [
                    'booking_id' => rand(1, 100),
                    'chalet_id' => $owner->chalets()->first()?->id
                ]
            ]);
            
            // إشعار تقييم جديد
            Notification::create([
                'owner_id' => $owner->id,
                'type' => 'review',
                'title_ar' => 'تقييم جديد',
                'title_en' => 'New Review',
                'message_ar' => 'قام أحد العملاء بتقييم عقارك بـ 5 نجوم',
                'message_en' => 'A customer rated your property 5 stars',
                'icon_type' => 'info',
                'is_read' => false,
                'data' => [
                    'rating' => 5,
                    'chalet_id' => $owner->chalets()->first()?->id
                ]
            ]);
            
            // إشعار تذكير
            Notification::create([
                'owner_id' => $owner->id,
                'type' => 'reminder',
                'title_ar' => 'تذكير بالحجز',
                'title_en' => 'Booking Reminder',
                'message_ar' => 'لديك حجز غداً في شاليه النخيل',
                'message_en' => 'You have a booking tomorrow at Palm Chalet',
                'icon_type' => 'warning',
                'is_read' => rand(0, 1),
                'data' => [
                    'booking_date' => now()->addDay()->format('Y-m-d'),
                    'chalet_id' => $owner->chalets()->first()?->id
                ]
            ]);
            
            // إشعار دفعة مالية
            Notification::create([
                'owner_id' => $owner->id,
                'type' => 'payment',
                'title_ar' => 'دفعة مالية جديدة',
                'title_en' => 'New Payment',
                'message_ar' => 'تم استلام دفعة بقيمة 500 ريال',
                'message_en' => 'Payment of 500 SAR received',
                'icon_type' => 'success',
                'is_read' => rand(0, 1),
                'data' => [
                    'amount' => 500,
                    'currency' => 'SAR'
                ]
            ]);
        }
    }
}
