<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\CustomerNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $status;
    public $notification;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, string $status, CustomerNotification $notification)
    {
        $this->booking = $booking;
        $this->status = $status;
        $this->notification = $notification;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->status) {
            'confirmed' => app()->getLocale() == 'ar' ? 'تأكيد حجزك - شاليك عُمان' : 'Booking Confirmation - Shaleek Oman',
            'rejected' => app()->getLocale() == 'ar' ? 'حالة حجزك - شاليك عُمان' : 'Booking Status - Shaleek Oman',
            'cancelled' => app()->getLocale() == 'ar' ? 'إلغاء حجزك - شاليك عُمان' : 'Booking Cancellation - Shaleek Oman',
            default => app()->getLocale() == 'ar' ? 'تحديث حجزك - شاليك عُمان' : 'Booking Update - Shaleek Oman'
        };

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-status',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
