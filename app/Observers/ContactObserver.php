<?php

namespace App\Observers;

use App\Models\Contact;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class ContactObserver
{
    /**
     * Handle the Contact "created" event.
     */
    public function created(Contact $contact)
    {
        try {
            // إذا كانت الرسالة مرتبطة بشاليه معين
            if ($contact->chalet_id) {
                $chalet = $contact->chalet;
                
                if ($chalet && $chalet->owner_id) {
                    Notification::create([
                        'owner_id' => $chalet->owner_id,
                        'type' => 'contact_message',
                        'title_ar' => 'رسالة جديدة',
                        'title_en' => 'New Message',
                        'message_ar' => "لديك رسالة جديدة من {$contact->name} بخصوص {$chalet->name}",
                        'message_en' => "New message from {$contact->name} about {$chalet->name_en}",
                        'data' => [
                            'contact_id' => $contact->id,
                            'chalet_id' => $chalet->id,
                            'chalet_name' => $chalet->name,
                            'sender_name' => $contact->name,
                            'sender_email' => $contact->email,
                            'sender_phone' => $contact->phone ?? '',
                            'subject' => $contact->subject ?? 'استفسار',
                            'message' => $contact->message,
                            'created_at' => $contact->created_at->format('Y-m-d H:i:s')
                        ],
                        'icon_type' => 'info', // أزرق للرسائل
                        'is_read' => false
                    ]);
                    
                    Log::info('Contact message notification created', [
                        'contact_id' => $contact->id,
                        'owner_id' => $chalet->owner_id
                    ]);
                }
            } else {
                // رسالة عامة - إرسالها لجميع المالكين أو للمدير
                // يمكنك تخصيص هذا حسب احتياجك
                Log::info('General contact message received', [
                    'contact_id' => $contact->id,
                    'sender' => $contact->name
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to create contact notification: ' . $e->getMessage());
        }
    }
}
