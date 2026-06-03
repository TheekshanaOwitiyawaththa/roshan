<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $appointment)
    {
        $this->appointment->loadMissing(['coachingProgram', 'location']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We received your appointment request',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.appointments.received',
        );
    }
}
