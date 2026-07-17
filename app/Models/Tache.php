<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultant_id',
        'client_id',
        'assigned_by',
        'titre',
        'objectif',
        'date',
        'heure_debut',
        'heure_fin',
        'statut',
        'lu_at',
        'reponse_at',
        'commentaire',
    ];

    protected $casts = [
        'date' => 'date',
        'lu_at' => 'datetime',
        'reponse_at' => 'datetime',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function assignePar()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function getStatutColorAttribute()
    {
        return match ($this->statut) {
            'Acceptée', 'Terminée' => 'success',
            'En cours' => 'info',
            'Lue' => 'warning',
            'Refusée' => 'danger',
            default => 'secondary',
        };
    }

    public function toCalendarEvent(): array
    {
        $heureDebut = $this->heure_debut ? substr($this->heure_debut, 0, 5) : null;
        $heureFin = $this->heure_fin ? substr($this->heure_fin, 0, 5) : null;
        $dateStr = $this->date->toDateString();

        return [
            'id' => $this->id,
            'title' => $this->titre,
            'start' => $dateStr . ($heureDebut ? "T{$heureDebut}" : ''),
            'end' => $heureFin ? $dateStr . "T{$heureFin}" : null,
            'allDay' => !$heureDebut,
            'extendedProps' => [
                'objectif' => $this->objectif,
                'client_id' => $this->client_id,
                'client' => $this->client->nom_client ?? null,
                'consultant' => $this->consultant->nom_complet ?? null,
                'assigne_par' => $this->assignePar->name ?? null,
                'statut' => $this->statut,
                'commentaire' => $this->commentaire,
                'date' => $dateStr,
                'heure_debut' => $heureDebut,
                'heure_fin' => $heureFin,
                'lu' => (bool) $this->lu_at,
            ],
        ];
    }
}
