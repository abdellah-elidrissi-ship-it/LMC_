<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompteApprouveMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(protected User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre compte LMC Conseil a été activé',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.compte-approuve',
            with: ['user' => $this->user, 'url' => url('/login')],
        );
    }
}
