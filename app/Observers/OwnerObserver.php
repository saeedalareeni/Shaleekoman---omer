<?php

namespace App\Observers;

use App\Models\Owner;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;

class OwnerObserver
{
    /**
     * Handle the Owner "created" event.
     */
    public function created(Owner $owner)
    {
        try {
            // Create notification for admin (owner_id = null means it's for admin)
            Notification::create([
                'owner_id' => null, // null for admin notifications
                'type' => 'new_owner',
                'title_ar' => 'مالك جديد سجل في الموقع',
                'title_en' => 'New Owner Registered',
                'message_ar' => 'قام مالك جديد بالتسجيل: ' . $owner->name . ' - البريد: ' . $owner->email . ' - الهاتف: ' . $owner->phone,
                'message_en' => 'New owner registered: ' . $owner->name . ' - Email: ' . $owner->email . ' - Phone: ' . $owner->phone,
                'url' => '/owners/' . $owner->id,
                'icon' => 'fas fa-user-plus',
                'color' => 'success',
                'is_read' => 0,
                'data' => json_encode([
                    'owner_id' => $owner->id,
                    'owner_name' => $owner->name,
                    'owner_email' => $owner->email,
                    'owner_phone' => $owner->phone,
                    'registered_at' => now()->toDateTimeString()
                ])
            ]);
            
            \Log::info('Admin notification created for new owner registration: ' . $owner->id);
            
            // Send email notification to admins (optional)
            try {
                $admins = collect();
                
                // Check if role column exists
                if (\Schema::hasColumn('users', 'role')) {
                    $admins = User::where('role', 'admin')->get();
                } elseif (\Schema::hasColumn('users', 'is_admin')) {
                    $admins = User::where('is_admin', 1)->get();
                } else {
                    // If no admin columns exist, get first user as admin
                    $admins = User::where('id', 1)->get();
                }
                
                foreach ($admins as $admin) {
                    // Only send email if mail is properly configured
                    if (config('mail.default') != 'log' && config('mail.from.address')) {
                        Mail::to($admin->email)->send(new \App\Mail\NewOwnerRegistered($owner));
                    } else {
                        \Log::info('New owner registered email would be sent to: ' . $admin->email);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send new owner email notification: ' . $e->getMessage());
                // Continue without throwing error - email is optional
            }
        } catch (\Exception $e) {
            \Log::error('Error creating notification for new owner: ' . $e->getMessage());
        }
    }
}
