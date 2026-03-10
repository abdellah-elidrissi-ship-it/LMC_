<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;

    protected $table = 'affectations';

    protected $fillable = [
        'projet_id',
        'consultant_id',
        'role_dans_projet',
        'jours_alloues',
        'jours_realises'
    ];

    protected $casts = [
        'jours_alloues' => 'decimal:1',
        'jours_realises' => 'decimal:1'
    ];

    protected $appends = [
        'charge_percent',
        'jours_restants'
    ];


    
    /**
     * العلاقة مع المشروع
     * Affectation belongs to Projet
     */
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    /**
     * العلاقة مع المستشار
     * Affectation belongs to Consultant
     */
    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'consultant_id');
    }

    /**
     * حساب نسبة الإنجاز
     */
    public function getChargePercentAttribute()
    {
        if ($this->jours_alloues > 0) {
            return round(($this->jours_realises / $this->jours_alloues) * 100);
        }
        return 0;
    }

    /**
     * حساب الأيام المتبقية
     */
    public function getJoursRestantsAttribute()
    {
        return $this->jours_alloues - $this->jours_realises;
    }

    /**
     * التحقق إذا كانت المهمة مكتملة
     */
    public function getEstCompleteAttribute()
    {
        return $this->jours_realises >= $this->jours_alloues;
    }

    /**
     * الحصول على لون نسبة الإنجاز
     */
    public function getChargeColorAttribute()
    {
        $percent = $this->charge_percent;
        
        if ($percent >= 100) return 'success';
        if ($percent >= 75) return 'warning';
        if ($percent >= 50) return 'info';
        if ($percent > 0) return 'primary';
        return 'error';
    }

    /**
     * Scope لجلب affectations النشطة (لي فيها أيام مزال)
     */
    public function scopeActives($query)
    {
        return $query->whereRaw('jours_realises < jours_alloues');
    }

    /**
     * Scope لجلب affectations المكتملة
     */
    public function scopeCompletes($query)
    {
        return $query->whereRaw('jours_realises >= jours_alloues');
    }

    /**
     * Scope لجلب affectations حسب المستشار
     */
    public function scopeForConsultant($query, $consultantId)
    {
        return $query->where('consultant_id', $consultantId);
    }

    /**
     * Scope لجلب affectations حسب المشروع
     */
    public function scopeForProjet($query, $projetId)
    {
        return $query->where('projet_id', $projetId);
    }
}