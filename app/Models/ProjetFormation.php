<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetFormation extends Model
{
    use HasFactory;

    protected $table = 'projet_formations';

    protected $fillable = [
        'projet_id',
        'formation_id',
        'statut',
        'observations'
    ];

    protected $casts = [
        'statut' => 'string'
    ];

    /**
     * العلاقة مع المشروع
     * ProjetFormation belongs to Projet
     */
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    /**
     * العلاقة مع التكوين
     * ProjetFormation belongs to Formation
     */
    public function formation()
    {
        return $this->belongsTo(Formation::class, 'formation_id');
    }

    /**
     * الحصول على لون الحالة
     */
    public function getStatutColorAttribute()
    {
        $colors = [
            'Finalisée' => 'success',
            'Réalisée' => 'success',
            'En cours' => 'warning',
            'À planifier' => 'error'
        ];

        return $colors[$this->statut] ?? 'default';
    }

    /**
     * Scope لجلب التكوينات المكتملة
     */
    public function scopeComplete($query)
    {
        return $query->whereIn('statut', ['Finalisée', 'Réalisée']);
    }

    /**
     * Scope لجلب التكوينات المخططة
     */
    public function scopePlanifie($query)
    {
        return $query->where('statut', 'À planifier');
    }
}