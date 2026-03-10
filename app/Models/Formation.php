<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $table = 'formations';

    protected $fillable = [
        'titre_formation',
        'description'
    ];

    /**
     * العلاقة مع المشاريع (Many-to-Many)
     * Formation belongs to many Projets via projet_formations
     */
    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'projet_formations')
                    ->withPivot('statut', 'observations')
                    ->withTimestamps();
    }

    /**
     * Scope للبحث عن التكوينات
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('titre_formation', 'like', "%{$search}%");
    }
}