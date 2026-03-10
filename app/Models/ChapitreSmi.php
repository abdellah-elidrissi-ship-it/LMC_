<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapitreSmi extends Model
{
    use HasFactory;

    protected $table = 'chapitres_smis';

    protected $fillable = [
        'code_chapitre',
        'titre_chapitre',
        'exigences_cles',
        'ordre'
    ];

    /**
     * العلاقة مع تتبع الفصول في المشاريع
     * ChapitreSmi has many SuiviChapitre
     */
    public function suivis()
    {
        return $this->hasMany(SuiviChapitre::class, 'chapitre_id');
    }

    /**
     * العلاقة مع المشاريع (من خلال SuiviChapitre)
     * ChapitreSmi belongs to many Projets via SuiviChapitre
     */
    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'suivi_chapitres')
                    ->withPivot('avancement_percent', 'phase', 'jours_intervention', 'statut_livrables', 'observations')
                    ->withTimestamps();
    }

    /**
     * Scope لترتيب الفصول
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre', 'asc');
    }
}