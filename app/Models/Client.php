<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nom_client', 'secteur_activite', 'adresse', 
        'telephone', 'email_contact'
    ];
    
    public function projets()
    {
        return $this->hasMany(Projet::class);
    }
}
