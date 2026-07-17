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
        'date_debut',
        'date_fin',
    ];

    protected $casts = [
        'ct_prevue' => 'float',
        'ct_realisee' => 'float',
        'avancement' => 'float',
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function phase()
    {
        return $this->belongsTo(GanttPhase::class, 'phase_id');
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function getEcartAttribute()
    {
        return round($this->ct_prevue - $this->ct_realisee, 2);
    }

    public function getStatutColorAttribute()
    {
        if ($this->avancement >= 100) return 'success';
        if ($this->avancement >= 50) return 'warning';
        return 'danger';
    }
}
