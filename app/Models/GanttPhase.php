<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GanttPhase extends Model
{
    protected $fillable = ['projet_id', 'nom', 'ordre'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function taches()
    {
        return $this->hasMany(GanttTache::class, 'phase_id')->orderBy('numero');
    }

    public function getCtPrevuTotalAttribute()
    {
        return round($this->taches->sum('ct_prevue'), 2);
    }

    public function getCtRealiseTotalAttribute()
    {
        return round($this->taches->sum('ct_realisee'), 2);
    }

    public function getEcartTotalAttribute()
    {
        return round($this->ct_prevu_total - $this->ct_realise_total, 2);
    }

    public function getAvancementMoyenAttribute()
    {
        return $this->taches->count() > 0
            ? round($this->taches->avg('avancement'))
            : 0;
    }
}
