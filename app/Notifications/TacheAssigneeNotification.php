<?php

namespace App\Notifications;

use App\Models\Tache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class TacheAssigneeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Tache $tache)
    {
    }

    public function via(object $notifiable): array
    {
        if (empty($notifiable->email)) {
            Log::warning('TacheAssigneeNotification : notifiable sans email, canal mail ignoré.', [
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
            'date' => optional($this->tache->date)->format('Y-m-d'),
            'client_nom' => $this->tache->client->nom_client ?? null,
            'message' => 'Nouvelle tâche assignée : ' . $this->tache->titre,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->tache->loadMissing(['client', 'assignePar', 'consultant']);

        return (new MailMessage)
            ->subject('Nouvelle mission assignée : ' . $this->tache->titre)
            ->view('emails.tache-assignee', [
                'tache' => $this->tache,
                'url' => url('/calendrier?tache=' . $this->tache->id),
            ]);
    }
}
