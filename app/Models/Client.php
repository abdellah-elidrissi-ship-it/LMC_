<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_client', 'secteur_activite', 'adresse', 
        'telephone','logo_path', 'email_contact'
    ];
    
    public function projets()
    {
        return $this->hasMany(Projet::class);
    }
}
