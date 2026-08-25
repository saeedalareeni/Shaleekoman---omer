<?php

namespace App\Observers;

use App\Models\Chalet;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class ChaletObserver
{
    /**
     * Handle the Chalet "created" event.
     */
    public function created(Chalet $chalet)
    {
        try {
            // إرسال إشعار للأدمن عند إضافة شاليه جديد
            Notification::create([
                'type' => 'new_chalet',
                'title_ar' => 'شاليه جديد',
                'title_en' => 'New Chalet',
                'message_ar' => 'تم إضافة شاليه جديد: ' . $chalet->chalet_name_ar . ' بواسطة المالك: ' . ($chalet->owner->name ?? 'غير محدد'),
                'message_en' => 'New chalet added: ' . $chalet->chalet_name_en . ' by owner: ' . ($chalet->owner->name ?? 'Unknown'),
                'icon' => 'fas fa-home',
                'color' => 'info',
                'url' => '/chalets/' . $chalet->id,
                'is_read' => 0,
                'data' => json_encode([
                    'chalet_id' => $chalet->id,
                    'chalet_name_ar' => $chalet->chalet_name_ar,
                    'chalet_name_en' => $chalet->chalet_name_en,
                    'owner_id' => $chalet->owner_id,
                    'owner_name' => $chalet->owner->name ?? null,
                    'area' => $chalet->area->name_ar ?? null,
                    'city' => $chalet->city->name_ar ?? null,
                    'price_per_night' => $chalet->price_per_night
                ])
            ]);
            
            Log::info('Admin notification created for new chalet: ' . $chalet->id);
        } catch (\Exception $e) {
            Log::error('Error creating admin notification for new chalet: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Chalet "updated" event.
     */
    public function updated(Chalet $chalet)
    {
        try {
            // التحقق من تغيير الحالة
            if ($chalet->isDirty('status')) {
                $oldStatus = $chalet->getOriginal('status');
                $newStatus = $chalet->status;
                
                // إرسال إشعار للمالك عند تغيير حالة الشاليه
                if ($chalet->owner_id) {
                    $statusMessages = [
                        'approved' => [
                            'ar' => 'تمت الموافقة على شاليهك',
                            'en' => 'Your chalet has been approved',
                            'color' => 'success',
                            'icon' => 'fas fa-check-circle'
                        ],
                        'rejected' => [
                            'ar' => 'تم رفض شاليهك',
                            'en' => 'Your chalet has been rejected',
                            'color' => 'danger',
                            'icon' => 'fas fa-times-circle'
                        ],
                        'pending' => [
                            'ar' => 'شاليهك قيد المراجعة',
                            'en' => 'Your chalet is under review',
                            'color' => 'warning',
                            'icon' => 'fas fa-clock'
                        ]
                    ];
                    
                    $statusInfo = $statusMessages[$newStatus] ?? [
                        'ar' => 'تم تحديث حالة شاليهك',
                        'en' => 'Your chalet status has been updated',
                        'color' => 'info',
                        'icon' => 'fas fa-info-circle'
                    ];
                    
                    // إنشاء إشعار للمالك
                    Notification::create([
                        'owner_id' => $chalet->owner_id,
                        'type' => 'chalet_status',
                        'title_ar' => $statusInfo['ar'],
                        'title_en' => $statusInfo['en'],
                        'message_ar' => 'تم تغيير حالة الشاليه "' . $chalet->chalet_name_ar . '" من ' . $this->getStatusArabic($oldStatus) . ' إلى ' . $this->getStatusArabic($newStatus),
                        'message_en' => 'Chalet "' . $chalet->chalet_name_en . '" status changed from ' . $oldStatus . ' to ' . $newStatus,
                        'icon' => $statusInfo['icon'],
                        'color' => $statusInfo['color'],
                        'url' => '/owner/chalets/' . $chalet->id,
                        'is_read' => 0,
                        'data' => json_encode([
                            'chalet_id' => $chalet->id,
                            'chalet_name_ar' => $chalet->chalet_name_ar,
                            'chalet_name_en' => $chalet->chalet_name_en,
                            'old_status' => $oldStatus,
                            'new_status' => $newStatus,
                            'changed_at' => now()->toDateTimeString()
                        ])
                    ]);
                    
                    Log::info('Owner notification created for chalet status change: ' . $chalet->id);
                }
            }
            
            // التحقق من تغيير الميزة (featured)
            if ($chalet->isDirty('is_feature')) {
                if ($chalet->is_feature && $chalet->owner_id) {
                    Notification::create([
                        'owner_id' => $chalet->owner_id,
                        'type' => 'chalet_featured',
                        'title_ar' => 'شاليهك الآن مميز!',
                        'title_en' => 'Your chalet is now featured!',
                        'message_ar' => 'تم تمييز شاليهك "' . $chalet->chalet_name_ar . '" وسيظهر في القسم المميز',
                        'message_en' => 'Your chalet "' . $chalet->chalet_name_en . '" has been featured',
                        'icon' => 'fas fa-star',
                        'color' => 'warning',
                        'url' => '/owner/chalets/' . $chalet->id,
                        'is_read' => 0,
                        'data' => json_encode([
                            'chalet_id' => $chalet->id,
                            'chalet_name_ar' => $chalet->chalet_name_ar,
                            'chalet_name_en' => $chalet->chalet_name_en,
                            'featured_at' => now()->toDateTimeString()
                        ])
                    ]);
                }
            }
            
        } catch (\Exception $e) {
            Log::error('Error creating notification for chalet update: ' . $e->getMessage());
        }
    }
    
    /**
     * Get Arabic status name
     */
    private function getStatusArabic($status)
    {
        $statuses = [
            'pending' => 'قيد المراجعة',
            'approved' => 'معتمد',
            'rejected' => 'مرفوض',
            'active' => 'نشط',
            'inactive' => 'غير نشط'
        ];
        
        return $statuses[$status] ?? $status;
    }
}
