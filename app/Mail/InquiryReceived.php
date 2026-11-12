<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class InquiryReceived extends Mailable
{
    public function __construct(public Inquiry $inquiry)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            // Hitting "Reply" in your inbox answers the visitor directly
            replyTo: [new Address($this->inquiry->email, $this->inquiry->name)],
            subject: 'New website inquiry from '.$this->inquiry->name,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.inquiry-received');
    }
}
