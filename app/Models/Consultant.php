<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    protected $fillable = [
        'nom_complet', 'type_consultant', 'specialite', 
        'email', 'telephone', 'actif'
    ];
    
    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'affectations')
                    ->withPivot('role_dans_projet', 'jours_alloues', 'jours_realises');
    }
    
    public function projetsDiriges()
    {
        return $this->hasMany(Projet::class, 'chef_projet_id');
    }
}