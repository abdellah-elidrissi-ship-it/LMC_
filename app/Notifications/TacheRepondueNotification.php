<?php

namespace App\Notifications;

use App\Models\Tache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class TacheRepondueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Tache $tache)
    {
    }

    public function via(object $notifiable): array
    {
        if (empty($notifiable->email)) {
            Log::warning('TacheRepondueNotification : notifiable sans email, canal mail ignoré.', [
                'notifiable_id' => $notifiable->id ?? null,
                'tache_id' => $this->tache->id,
            ]);

            return ['database'];
        }

        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'tache_id' => $this->tache->id,
            'titre' => $this->tache->titre,
            'statut' => $this->tache->statut,
            'consultant_nom' => $this->tache->consultant->nom_complet ?? null,
            'message' => ($this->tache->consultant->nom_complet ?? 'Un consultant') . ' a répondu "' .
                $this->tache->statut . '" à la tâche : ' . $this->tache->titre,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->tache->loadMissing(['client', 'consultant']);

        return (new MailMessage)
            ->subject('Réponse à une tâche : ' . $this->tache->titre)
            ->view('emails.tache-repondue', [
                'tache' => $this->tache,
                'url' => url('/admin/calendrier/' . $this->tache->consultant_id),
            ]);
    }
}
