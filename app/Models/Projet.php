<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $fillable = [
        'reference_projet', 'client_id', 'chef_projet_id', 'type_projet',
        'statut', 'jours_prevus', 'jours_realises', 'avancement_percent',
        'blocage', 'commentaire', 'date_debut', 'date_fin_prevue', 'date_fin_reelle'
    ];
    
    protected $appends = ['conso_jours_percent', 'ecart_jours'];
    
    // العلاقات
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function chefProjet()
    {
        return $this->belongsTo(Consultant::class, 'chef_projet_id');
    }
    
    public function normes()
    {
        return $this->belongsToMany(Norme::class, 'projet_normes');
    }
    
    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }
    
    public function consultants()
    {
        return $this->belongsToMany(Consultant::class, 'affectations')
                    ->withPivot('role_dans_projet', 'jours_alloues', 'jours_realises');
    }
    
    public function suiviChapitres()
    {
        return $this->hasMany(SuiviChapitre::class);
    }
    
    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'projet_formations')
                    ->withPivot('statut', 'observations');
    }
    
    // الحقول المحسوبة
    public function getConsoJoursPercentAttribute()
    {
        if ($this->jours_prevus > 0) {
            return round(($this->jours_realises / $this->jours_prevus) * 100);
        }
        return 0;
    }
    
    public function getEcartJoursAttribute()
    {
        return $this->jours_realises - $this->jours_prevus;
    }
}