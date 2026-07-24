<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GanttTache extends Model
{
    protected $table = 'gantt_taches';

    protected $fillable = [
        'projet_id',
        'phase_id',
        'numero',
        'designation',
        'unite',
        'responsable',
        'ct_prevue',
        'ct_realisee',
        'avancement',
        'type_tache',
        'date_debut',
        'date_fin',
        'date_interruption',
        'jours_choisis',
        'date_reprise',
        'segments',
    ];

    protected $casts = [
        'ct_prevue' => 'float',
        'ct_realisee' => 'float',
        'avancement' => 'float',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_interruption' => 'date',
        'jours_choisis' => 'array',
        'date_reprise' => 'date',
        'segments' => 'array',
    ];

    public function phase()
    {
        return $this->belongsTo(GanttPhase::class, 'phase_id');
    }

    public function consultants()
    {
        return $this->belongsToMany(Consultant::class, 'gantt_tache_consultant');
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function getEcartAttribute()
    {
        return round($this->ct_prevue - $this->ct_realisee, 2);
    }

    public function isJournee(): bool
    {
        return $this->type_tache === 'journee';
    }

    // "Report" n'est plus un type_tache — c'est un état orthogonal (applicable à
    // phase ET journee) marqué par la présence d'une date de reprise.
    public function hasReport(): bool
    {
        return !is_null($this->date_reprise);
    }
}
