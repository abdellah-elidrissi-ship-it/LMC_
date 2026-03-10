<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuiviChapitre extends Model
{
    use HasFactory;

    protected $table = 'suivi_chapitres';

    protected $fillable = [
        'projet_id',
        'chapitre_id',
        'avancement_percent',
        'phase',
        'jours_intervention',
        'statut_livrables',
        'observations'
    ];

    protected $casts = [
        'avancement_percent' => 'integer',
        'jours_intervention' => 'integer'
    ];

    /**
     * العلاقة مع المشروع
     * SuiviChapitre belongs to Projet
     */
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    /**
     * العلاقة مع الفصل
     * SuiviChapitre belongs to ChapitreSmi
     */
    public function chapitre()
    {
        return $this->belongsTo(ChapitreSmi::class, 'chapitre_id');
    }

    /**
     * الحصول على نص phase منسق
     */
    public function getPhaseFormattedAttribute()
    {
        $phases = [
            '⬜ Non démarré' => 'Non démarré',
            '⏳ Démarré' => 'Démarré',
            '🔄 En cours' => 'En cours',
            '✅ Terminé' => 'Terminé'
        ];

        return $phases[$this->phase] ?? $this->phase;
    }

    /**
     * حساب التقدم بالنسبة المئوية
     */
    public function getProgressColorAttribute()
    {
        if ($this->avancement_percent >= 100) return 'success';
        if ($this->avancement_percent >= 50) return 'warning';
        return 'error';
    }

    /**
     * Scope لجلب الفصول النشطة
     */
    public function scopeEnCours($query)
    {
        return $query->whereIn('phase', ['⏳ Démarré', '🔄 En cours']);
    }

    /**
     * Scope لجلب الفصول المكتملة
     */
    public function scopeTermine($query)
    {
        return $query->where('phase', '✅ Terminé');
    }
}