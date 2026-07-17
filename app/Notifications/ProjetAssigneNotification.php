<?php

namespace App\Notifications;

use App\Models\Projet;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ProjetAssigneNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Projet $projet,
        protected ?string $roleDansProjet,
        protected User $assignePar
    ) {
    }

    public function via(object $notifiable): array
    {
        if (empty($notifiable->email)) {
            Log::warning('ProjetAssigneNotification : notifiable sans email, canal mail ignoré.', [
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
            'message' => 'Vous avez été affecté au projet ' . $this->projet->reference_projet,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle affectation projet : ' . $this->projet->reference_projet)
            ->view('emails.projet-assigne', [
                'projet' => $this->projet,
                'role' => $this->roleDansProjet,
                'assignePar' => $this->assignePar,
                'url' => url('/projet/' . $this->projet->id),
            ]);
    }
}
