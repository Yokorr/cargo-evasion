<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
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
            subject: 'Confirmation de votre réservation - Milly Évasion',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.bookings.booking_confirmation',
        );
    }
}