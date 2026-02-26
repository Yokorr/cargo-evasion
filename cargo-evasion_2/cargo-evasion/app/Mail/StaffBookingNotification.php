<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffBookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bookings;
    public $reference;

    public function __construct($bookings, $reference)
    {
        $this->bookings = $bookings;
        $this->reference = $reference;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 BRAVO ! Nouvelle réservation : ' . $this->reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.new_booking',
        );
    }
}