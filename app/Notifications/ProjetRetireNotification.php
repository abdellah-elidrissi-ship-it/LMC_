<?php

namespace App\Notifications;

use App\Models\Projet;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ProjetRetireNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Projet $projet,
        protected User $retirePar
    ) {
    }

    public function via(object $notifiable): array
    {
        if (empty($notifiable->email)) {
            Log::warning('ProjetRetireNotification : notifiable sans email, canal mail ignoré.', [
                'notifiable_id' => $notifiable->id ?? null,
                'projet_id' => $this->projet->id,
            ]);

            return ['database'];
        }

        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'projet_id' => $this->projet->id,
            'message' => 'Vous n\'avez plus accès au projet ' . $this->projet->reference_projet,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Fin d\'accès au projet : ' . $this->projet->reference_projet)
            ->view('emails.projet-retire', [
                'projet' => $this->projet,
                'retirePar' => $this->retirePar,
            ]);
    }
}
