<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Norme extends Model
{
    protected $fillable = ['code_norme', 'description'];
    
    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'projet_normes');
    }
}
