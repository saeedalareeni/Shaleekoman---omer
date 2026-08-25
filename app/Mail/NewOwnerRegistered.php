<?php

namespace App\Mail;

use App\Models\Owner;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOwnerRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $owner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Owner $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('تسجيل مالك جديد - ' . $this->owner->name)
                    ->view('emails.new-owner-registered')
                    ->with('owner', $this->owner);
    }
}
